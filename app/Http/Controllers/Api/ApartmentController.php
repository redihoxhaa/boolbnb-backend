<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        // Eager loading per caricare le relazioni sponsorizzate
        $apartments = Apartment::with('sponsorships')
            ->where('is_visible', 1) // Considera solo gli appartamenti visibili
            ->orderByRaw('CASE 
            WHEN id IN (SELECT apartment_id FROM apartment_sponsorship) THEN 0
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
            'radius' => 'required|numeric',
        ]);

        $address = $data['address'];
        $radius = $data['radius'];

        // Effettua una chiamata all'API di geocodifica per ottenere la latitudine e la longitudine
        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json', [
            'key' => env('TOMTOM_API_KEY'),
        ]);

        if ($response->successful()) {
            $addressQuery = $response->json();
            if (isset($addressQuery['results']) && !empty($addressQuery['results'])) {
                $latitude = $addressQuery['results'][0]['position']['lat'];
                $longitude = $addressQuery['results'][0]['position']['lon'];

                // Esegue la query per trovare gli appartamenti entro il raggio specificato con eager loading di services e sponsorships
                $apartments = Apartment::with('services', 'sponsorships')
                    ->whereBetween('lat', [$latitude - ($radius / 111.045), $latitude + ($radius / 111.045)])
                    ->whereBetween('lon', [$longitude - ($radius / (111.045 * cos(deg2rad($latitude)))), $longitude + ($radius / (111.045 * cos(deg2rad($latitude))))])
                    ->get();

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
            $apartment = Apartment::find($id);

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
}
