<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        // Ottieni gli appartamenti sponsorizzati ordinati per data di sponsorizzazione decrescente
        $sponsoredApartments = Apartment::with(['sponsorships' => function ($query) {
            $query->orderBy('created_at', 'desc')->first();
        }])
            ->has('sponsorships')
            ->orderBy('sponsorships.created_at', 'desc')
            ->get();

        // Ottieni gli appartamenti non sponsorizzati ordinati per data di creazione decrescente
        $nonSponsoredApartments = Apartment::with('sponsorships')
            ->whereDoesntHave('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ottieni gli appartamenti nascosti ordinati per data di creazione decrescente
        $hiddenApartments = Apartment::where('is_visible', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        // Combina gli appartamenti in un'unica collezione ordinata
        $apartments = $sponsoredApartments
            ->merge($nonSponsoredApartments)
            ->merge($hiddenApartments);

        return response()->json($apartments);
    }
}
