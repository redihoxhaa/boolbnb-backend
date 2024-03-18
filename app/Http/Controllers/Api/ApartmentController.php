<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    public function index()
    {
        // Ottieni la data e l'ora attuali

        $now = Carbon::now();

        // Ottieni gli appartamenti sponsorizzati

        $sponsoredApartments = Apartment::with('sponsorships')->whereHas('sponsorships', function ($query) use ($now) {

            // Filtra le sponsorizzazioni attive

            $query->where('end_date', '>', $now);
        })
            ->where('is_visible', 1) // Aggiungi la condizione per is_visible
            ->with(['sponsorships' => function ($query) {

                // Ordina le sponsorizzazioni per data di creazione decrescente

                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy(function ($query) {

                // Ordina gli appartamenti in base alla data di creazione della sponsorizzazione più recente

                $query->select('created_at')
                    ->from('apartment_sponsorship')
                    ->whereColumn('apartment_id', 'apartments.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1);
            }, 'desc')->get();

        // Ottieni gli appartamenti non sponsorizzati

        $nonSponsoredApartments = Apartment::where('is_visible', 1) // Aggiungi la condizione per is_visible
            ->orderBy('created_at', 'desc') // Ordina gli appartamenti non sponsorizzati per data di creazione
            ->get();

        // Rimuovi gli appartamenti sponsorizzati dalla lista degli appartamenti non sponsorizzati

        $nonSponsoredApartments = $nonSponsoredApartments->diff($sponsoredApartments);

        // Combina gli appartamenti sponsorizzati e non sponsorizzati

        $allApartments = $sponsoredApartments->merge($nonSponsoredApartments);

        return response()->json([
            'sponsored_apartments' => $sponsoredApartments,
            'non_sponsored_apartments' => $nonSponsoredApartments
        ]);
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

        $radius = $request->has('radius') ? $data['radius'] : 1;

        // Effettua una chiamata all'API di geocodifica per ottenere la latitudine e la longitudine

        $response = Http::withoutVerifying()->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json', [
            'key' => env('TOMTOM_API_KEY'),
        ]);

        if ($response->successful()) {
            $addressQuery = $response->json();
            if (isset($addressQuery['results']) && !empty($addressQuery['results'])) {
                $latitude = $addressQuery['results'][0]['position']['lat'];
                $longitude = $addressQuery['results'][0]['position']['lon'];

                // Esecuzione della query per gli appartamenti sponsorizzati
                $sponsoredApartments = Apartment::where('is_visible', 1)->with('services', 'sponsorships')
                    ->whereHas('sponsorships', function ($query) {
                        $query->where('end_date', '>', now());
                    })
                    ->whereBetween('lat', [$latitude - ($radius / 111.045), $latitude + ($radius / 111.045)])
                    ->whereBetween('lon', [$longitude - ($radius / (111.045 * cos(deg2rad($latitude)))), $longitude + ($radius / (111.045 * cos(deg2rad($latitude))))]);

                // Aggiunta delle condizioni opzionali per i servizi ai sponsorizzati

                if ($request->has('services')) {
                    $serviceIds = explode(',', $request->input('services'));
                    foreach ($serviceIds as $serviceId) {
                        $sponsoredApartments->whereHas('services', function ($query) use ($serviceId) {
                            $query->where('id', $serviceId);
                        });
                    }
                }

                // Aggiunta delle condizioni opzionali ai sponsorizzati

                if ($request->has('rooms')) {
                    $sponsoredApartments->where('rooms', '>=', $data['rooms']);
                }

                if ($request->has('beds')) {
                    $sponsoredApartments->where('beds', '>=', $data['beds']);
                }

                if ($request->has('bathrooms')) {
                    $sponsoredApartments->where('bathrooms', '>=', $data['bathrooms']);
                }

                // Esegui la query per gli appartamenti sponsorizzati

                $sponsoredApartments = $sponsoredApartments->get();

                // Calcola e aggiunge la distanza per ogni appartamento sponsorizzato

                $sponsoredApartments->each(function ($apartment) use ($latitude, $longitude) {
                    $apartment->distance = $this->haversineDistance($latitude, $longitude, $apartment->lat, $apartment->lon);
                });

                // Ordina gli appartamenti sponsorizzati per distanza

                $sponsoredApartments = $sponsoredApartments->sortBy('distance');

                // Esecuzione della query per gli appartamenti non sponsorizzati

                $nonSponsoredQuery = Apartment::where('is_visible', 1)->with('services', 'sponsorships')
                    ->whereDoesntHave('sponsorships', function ($query) {
                        $query->where('end_date', '>', now());
                    })
                    ->whereBetween('lat', [$latitude - ($radius / 111.045), $latitude + ($radius / 111.045)])
                    ->whereBetween('lon', [$longitude - ($radius / (111.045 * cos(deg2rad($latitude)))), $longitude + ($radius / (111.045 * cos(deg2rad($latitude))))]);

                // Aggiunta delle condizioni opzionali per i servizi ai non sponsorizzati

                if ($request->has('services')) {
                    $serviceIds = explode(',', $request->input('services'));
                    foreach ($serviceIds as $serviceId) {
                        $nonSponsoredQuery->whereHas('services', function ($query) use ($serviceId) {
                            $query->where('id', $serviceId);
                        });
                    }
                }

                // Aggiunta delle condizioni opzionali ai non sponsorizzati

                if ($request->has('rooms')) {
                    $nonSponsoredQuery->where('rooms', '>=', $data['rooms']);
                }

                if ($request->has('beds')) {
                    $nonSponsoredQuery->where('beds', '>=', $data['beds']);
                }

                if ($request->has('bathrooms')) {
                    $nonSponsoredQuery->where('bathrooms', '>=', $data['bathrooms']);
                }

                // Esecuzione della query per gli appartamenti non sponsorizzati

                $nonSponsoredApartments = $nonSponsoredQuery->get();

                // Calcola e aggiunge la distanza per ogni appartamento non sponsorizzato

                $nonSponsoredApartments->each(function ($apartment) use ($latitude, $longitude) {
                    $apartment->distance = $this->haversineDistance($latitude, $longitude, $apartment->lat, $apartment->lon);
                });

                // Ordina gli appartamenti non sponsorizzati per distanza

                $nonSponsoredApartments = $nonSponsoredApartments->sortBy('distance');

                // Unisci gli appartamenti sponsorizzati e non sponsorizzati

                $mergedApartments = $sponsoredApartments->merge($nonSponsoredApartments);

                $center = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'radius' => (int)$radius,

                ];

                return response()->json([
                    'apartments' => $mergedApartments,
                    'center' => $center,
                ]);
            } else {

                // Nessun risultato trovato per l'indirizzo fornito

                return response()->json(['error' => 'Indirizzo non valido'], 400);
            }
        } else {

            // La chiamata all'API non è riuscita

            return response()->json(['error' => 'Errore durante la geocodifica'], 500);
        }
    }



    // Funzione per il calcolo della distanza tramite la formula di Haversine

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
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
        // Ottieni la data e l'ora attuali

        $now = Carbon::now();

        // Ottieni gli appartamenti sponsorizzati

        $sponsoredApartments = Apartment::whereHas('sponsorships', function ($query) use ($now) {

            // Filtra le sponsorizzazioni attive

            $query->where('end_date', '>', $now);
        })
            ->where('is_visible', 1) // Aggiungi la condizione per is_visible
            ->with(['sponsorships' => function ($query) {

                // Ordina le sponsorizzazioni per data di creazione decrescente

                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy(function ($query) {

                // Ordina gli appartamenti in base alla data di creazione della sponsorizzazione più recente

                $query->select('created_at')
                    ->from('apartment_sponsorship')
                    ->whereColumn('apartment_id', 'apartments.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1);
            }, 'desc')
            ->take(8) // Prendi solo i primi 6 appartamenti sponsorizzati
            ->get();

        return response()->json($sponsoredApartments);
    }
}
