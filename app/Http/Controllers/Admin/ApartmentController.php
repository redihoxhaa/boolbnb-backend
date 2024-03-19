<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
        $apartments = Apartment::with('sponsorships', 'services')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.apartments.list', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();

        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {

        $data = $request->validated();


        $address = $data['address'];

        // Effettua una chiamata all'API di geocodifica per ottenere la latitudine e la longitudine
        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json', [
            'key' => env('TOMTOM_API_KEY'),
        ]);


        if ($response->successful()) {
            $addressQuery = $response->json();
            if (isset($addressQuery['results']) && !empty($addressQuery['results'])) {
                $latitude = $addressQuery['results'][0]['position']['lat'];
                $longitude = $addressQuery['results'][0]['position']['lon'];
            } else {
                // Nessun risultato trovato per l'indirizzo fornito
                return redirect()->back()->withInput()->withErrors(['address' => 'Indirizzo non valido']);
            }
        } else {
            // La chiamata all'API non è riuscita
            return redirect()->back()->withInput()->withErrors(['address' => 'Errore durante la geocodifica']);
        }

        $apartment = new Apartment();
        $user = Auth::user();
        $apartment->user_id = $user->id;
        $apartment->title = $data['title'];
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->square_meters = $data['square_meters'];
        $apartment->address = $address;
        $apartment->lat = $latitude;
        $apartment->lon = $longitude;
        if (isset($data['images'])) {
            $imagesPaths = [];
            foreach ($data['images'] as $image) {
                $imagesPaths[] = Storage::put('uploads', $image);
            }
            $apartment->images = implode(',', $imagesPaths);
        }
        // $imagesPaths = explode(',', $apartment->images); -Metodo per trasformare da stringa in array in modo da ciclarlo
        $apartment->is_visible = $data['is_visible'];

        // Generazione dello slug unico
        $slug = Str::slug($data['title']);
        $counter = 0;
        while (Apartment::where('slug', $slug)->exists()) {
            $counter++;
            $slug = Str::slug($data['title'] . '-' . $counter);
        }
        $apartment->slug = $slug;

        $apartment->save();

        if (isset($data['services'])) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->sync([]);
        }

        if ($data['sponsor'] === 'Gold') {
            $sponsorships = Sponsorship::all();
            $preference = 'Gold';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        }

        if ($data['sponsor'] === 'Diamond') {
            $sponsorships = Sponsorship::all();
            $preference = 'Diamond';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        }

        if ($data['sponsor'] === 'Emerald') {
            $sponsorships = Sponsorship::all();
            $preference = 'Emerald';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        }


        return redirect()->route('admin.apartments.show', $apartment)->with('message', $apartment->title . '" was successfully listed.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {

        $services = Service::all();

        return view('admin.apartments.edit', compact('services', 'apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->validated();

        $address = $data['address'];

        // Effettua una chiamata all'API di geocodifica per ottenere la latitudine e la longitudine
        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json', [
            'key' => env('TOMTOM_API_KEY'),
        ]);


        if ($response->successful()) {
            $addressQuery = $response->json();
            if (isset($addressQuery['results']) && !empty($addressQuery['results'])) {
                $latitude = $addressQuery['results'][0]['position']['lat'];
                $longitude = $addressQuery['results'][0]['position']['lon'];
            } else {
                // Nessun risultato trovato per l'indirizzo fornito
                return redirect()->back()->withInput()->withErrors(['address' => 'Indirizzo non valido']);
            }
        } else {
            // La chiamata all'API non è riuscita
            return redirect()->back()->withInput()->withErrors(['address' => 'Errore durante la geocodifica']);
        }

        $apartment->title = $data['title'];
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->square_meters = $data['square_meters'];
        $apartment->address = $address;
        $apartment->lat = $latitude;
        $apartment->lon = $longitude;
        if (isset($data['images']) && strlen($apartment->images)) {
            $existingImages = explode(',', $apartment->images); // Converti la stringa di immagini esistenti in un array
            foreach ($data['images'] as $image) {
                $existingImages[] = Storage::put('uploads', $image); // Aggiungi le nuove immagini all'array delle immagini esistenti
            }
            $apartment->images = implode(',', $existingImages); // Converti l'array di immagini in una stringa separata da virgole
        } elseif (isset($data['images']) && !strlen($apartment->images)) {
            $imagesPaths = [];
            foreach ($data['images'] as $image) {
                $imagesPaths[] = Storage::put('uploads', $image);
            }
            $apartment->images = implode(',', $imagesPaths);
        }

        // $imagesPaths = explode(',', $apartment->images); -Metodo per trasformare da stringa in array in modo da ciclarlo

        // Generazione dello slug unico
        $slug = Str::slug($data['title']);
        $counter = 0;
        while (Apartment::where('slug', $slug)->where('id', '!=', $apartment->id)->exists()) {
            $counter++;
            $slug = Str::slug($data['title'] . '-' . $counter);
        }
        $apartment->slug = $slug;

        $apartment->is_visible = $data['is_visible'];
        $apartment->save();
        if (isset($data['services'])) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->sync([]);
        }

        if ($data['sponsor'] === 'Gold') {
            $sponsorships = Sponsorship::all();
            $preference = 'Gold';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        } elseif ($data['sponsor'] === 'Diamond') {
            $sponsorships = Sponsorship::all();
            $preference = 'Diamond';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        } elseif ($data['sponsor'] === 'Emerald') {
            $sponsorships = Sponsorship::all();
            $preference = 'Emerald';
            return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
        }

        return redirect()->route('admin.apartments.show', $apartment)->with('message', $apartment->title . '" was successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->services()->sync([]);
        // Elimina le immagini associate all'appartamento
        $imagesPaths = explode(',', $apartment->images);
        foreach ($imagesPaths as $imagePath) {
            Storage::delete($imagePath);
        }
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('message', $apartment->title . ' was successfully deleted.');
    }

    public function sponsorship($apartment)
    {
        $apartment = Apartment::findOrFail($apartment);
        $sponsorships = Sponsorship::all();
        $preference = '';

        return view('admin.apartments.sponsorship', compact('sponsorships', 'apartment', 'preference'));
    }

    public function buySponsorship(Request $request, $apartmentID)
    {

        // Validazione dei dati inviati dal form
        $validator = Validator::make($request->all(), [
            'sponsorship_choice' => 'required|exists:sponsorships,id',
        ]);

        // Se la validazione fallisce, gestire gli errori di validazione
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ottenere l'appartamento dal suo ID
        $apartment = Apartment::findOrFail($apartmentID);

        // Ottenere l'ID del tipo di sponsorizzazione scelta dal form
        $sponsorshipID = $request->input('sponsorship_choice');

        // Ottenere la sponsorizzazione dal suo ID
        $sponsorship = Sponsorship::findOrFail($sponsorshipID);

        // Ottenere la durata della sponsorizzazione in ore
        $durationHours = $sponsorship->package_duration;

        // Ottenere l'ultimo end_date di sponsorizzazione dell'appartamento
        $lastEndDate = DB::table('apartment_sponsorship')
            ->where('apartment_id', $apartmentID)
            ->orderBy('end_date', 'desc')
            ->value('end_date');

        // Calcolare la data di inizio della sponsorizzazione
        $startDate = Carbon::now();

        // Se c'è un record di sponsorizzazione precedente, impostare la data di inizio sulla base dell'end_date di questo record
        if ($lastEndDate) {
            $startDate = Carbon::parse($lastEndDate)->max(Carbon::now());
        }

        // Calcolare la data di fine della sponsorizzazione
        $endDate = $startDate->copy()->addHours($durationHours);

        // Se l'appartamento non è visibile, impostalo a visibile
        if (!$apartment->is_visible) {
            $apartment->update(['is_visible' => 1]);
        }

        // Inserire il nuovo record nella tabella pivot apartment_sponsorship
        DB::table('apartment_sponsorship')->insert([
            'apartment_id' => $apartmentID,
            'sponsorship_id' => $sponsorshipID,
            'created_at' => $startDate,
            'updated_at' => Carbon::now(),
            'end_date' => $endDate,
        ]);

        return view('admin.apartments.sponsor_result', compact('apartment', 'sponsorship', 'endDate'));
    }
}
