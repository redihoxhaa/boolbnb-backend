<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::orderBy('created_at', 'desc')->get();
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
        $apartment = new Apartment();
        $user = Auth::user();

        $apartment->user_id = $user->id;
        $apartment->title = $data['title'];
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->square_meters = $data['square_meters'];
        $apartment->address = $data['address'];
        $apartment->latitude = $data['latitude'];
        $apartment->longitude = $data['longitude'];
        if (isset($data['images'])) {
            $imagesPaths = [];
            foreach ($data['images'] as $image) {
                $imagesPaths[] = Storage::put('uploads', $image);
            }
            $apartment->images = implode(',', $imagesPaths);
        }
        // $imagesPaths = explode(',', $apartment->images); -Metodo per trasformare da stringa in array in modo da ciclarlo
        $apartment->is_visible = $data['is_visible'];
        $apartment->save();
        $apartment->slug = Str::slug($data['title']) . '-' . $apartment->id;
        $apartment->save();
        if (isset($data['services'])) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->sync([]);
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

        $apartment->title = $data['title'];
        $apartment->description = $data['description'];
        $apartment->rooms = $data['rooms'];
        $apartment->beds = $data['beds'];
        $apartment->bathrooms = $data['bathrooms'];
        $apartment->square_meters = $data['square_meters'];
        $apartment->address = $data['address'];
        $apartment->latitude = $data['latitude'];
        $apartment->longitude = $data['longitude'];
        if (isset($data['images'])) {
            $imagesPaths = [];
            foreach ($data['images'] as $image) {
                $imagesPaths[] = Storage::put('uploads', $image);
            }
            $apartment->images = implode(',', $imagesPaths);
        }
        // $imagesPaths = explode(',', $apartment->images); -Metodo per trasformare da stringa in array in modo da ciclarlo

        $apartment->slug = Str::slug($data['title']) . '-' . $apartment->id;
        $apartment->is_visible = $data['is_visible'];
        $apartment->save();
        if (isset($data['services'])) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->sync([]);
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

        return redirect()->route('admin.apartments.index')->with('message', $apartment->title . '" was successfully deleted.');
    }
}
