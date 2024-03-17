<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $apartments = Apartment::where('user_id', $userId)->get();

        $totalApartments = $apartments->count();
        $totalMessages = 0;
        $totalVisits = 0;

        foreach ($apartments as $apartment) {
            $totalMessages += $apartment->messages()->count();
            $totalVisits += $apartment->visits()->count();
        }

        return view('dashboard', compact('totalApartments', 'totalMessages', 'totalVisits'));
    }
}
