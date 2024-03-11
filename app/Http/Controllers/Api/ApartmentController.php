<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        // Eager loading per caricare le relazioni sponsorizzate
        $apartments = Apartment::with('sponsorships', 'services')
            ->where('is_visible', 1) // Considera solo gli appartamenti visibili
            ->orderByRaw('CASE 
            WHEN id IN (SELECT apartment_id FROM apartment_sponsorship WHERE end_date > NOW()) THEN 0
            ELSE 1
        END')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($apartments);
    }


    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'rooms' => 'nullable|numeric',
            'beds' => 'nullable|numeric',
            'bathrooms' => 'nullable|numeric',
            'radius' => 'nullable|numeric',
            'services.*' => 'nullable|exists:services,id'
        ]);

        $address = $data['address'];

        // Verifica se il parametro radius è stato fornito
        $radius = $request->has('radius') ? $data['radius'] : 50;

        // Effettua una chiamata all'API di geocodifica per ottenere la latitudine e la longitudine
        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json', [
            'key' => env('TOMTOM_API_KEY'),
        ]);

        if ($response->successful()) {
            $addressQuery = $response->json();
            if (isset($addressQuery['results']) && !empty($addressQuery['results'])) {
                $latitude = $addressQuery['results'][0]['position']['lat'];
                $longitude = $addressQuery['results'][0]['position']['lon'];

                // Costruzione della query base
                $query = Apartment::with('services', 'sponsorships')
                    ->whereBetween('lat', [$latitude - ($radius / 111.045), $latitude + ($radius / 111.045)])
                    ->whereBetween('lon', [$longitude - ($radius / (111.045 * cos(deg2rad($latitude)))), $longitude + ($radius / (111.045 * cos(deg2rad($latitude))))]);

                // Aggiunta delle condizioni opzionali per i servizi
                if ($request->has('services')) {
                    $serviceIds = explode(',', $request->input('services'));
                    $query->whereHas('services', function ($query) use ($serviceIds) {
                        $query->whereIn('id', $serviceIds);
                    });
                }


                // Aggiunta delle condizioni opzionali
                if ($request->has('rooms')) {
                    $query->where('rooms', $data['rooms']);
                }

                if ($request->has('beds')) {
                    $query->where('beds', $data['beds']);
                }

                if ($request->has('bathrooms')) {
                    $query->where('bathrooms', $data['bathrooms']);
                }

                // Esecuzione della query
                $apartments = $query->get();

                // Calcola la distanza per ogni appartamento e aggiungi il campo distance
                $apartments = $apartments->map(function ($apartment) use ($latitude, $longitude) {
                    $distance = $this->haversineDistance($latitude, $longitude, $apartment->latitude, $apartment->longitude);
                    $apartment->distance = $distance;
                    return $apartment;
                });

                // Ordina gli appartamenti per distanza
                $apartments = $apartments->sortBy('distance');

                return response()->json($apartments);
            } else {
                // Nessun risultato trovato per l'indirizzo fornito
                return response()->json(['error' => 'Indirizzo non valido'], 400);
            }
        } else {
            // La chiamata all'API non è riuscita
            return response()->json(['error' => 'Errore durante la geocodifica'], 500);
        }
    }

    public function show(Request $request)
    {
        // Assicurati che l'ID sia presente nella richiesta
        if ($request->has('id')) {
            // Recupera l'ID dalla richiesta
            $id = $request->input('id');

            // Esegui la query utilizzando l'ID sulla tabella "apartments"
            $apartment = Apartment::with('sponsorships', 'services')->find($id);

            // Verifica se l'appartamento è stato trovato
            if ($apartment) {
                // Ritorna l'appartamento (puoi fare altro con esso qui)
                return response()->json($apartment);
            } else {
                // Nel caso in cui l'appartamento non sia stato trovato, restituisci un messaggio di errore
                return response()->json(['error' => 'Appartamento non trovato'], 404);
            }
        } else {
            // Se l'ID non è presente nella richiesta, restituisci un messaggio di errore
            return response()->json(['error' => 'ID mancante nella richiesta'], 400);
        }
    }

    public function sponsored()
    {
        $now = Carbon::now();

        $sponsoredApartments = Apartment::whereHas('sponsorships', function ($query) use ($now) {
            $query->orderBy('end_date', 'desc')
                ->where('end_date', '>', $now);
        })
            ->where('is_visible', 1) // Aggiungo la condizione per is_visible
            ->take(6)
            ->get();

        return response()->json($sponsoredApartments);
    }
}
