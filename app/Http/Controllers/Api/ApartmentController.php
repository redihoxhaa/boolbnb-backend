<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        // Eager loading per caricare le relazioni sponsorizzate
        $apartments = Apartment::with('sponsorships')
            ->orderByRaw('CASE 
                WHEN id IN (SELECT apartment_id FROM apartment_sponsorship) THEN 0
                WHEN is_visible = 1 THEN 1
                ELSE 2
            END')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($apartments);
    }
}
