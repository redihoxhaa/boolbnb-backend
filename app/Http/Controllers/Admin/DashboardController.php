<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $userId = auth()->id();
        $apartments = Apartment::where('user_id', $userId)->get();
        $totalApartments = count($apartments);
        $totalMessages = $apartments->messages()->count();
        $totalVisits = $apartments->visits()->count();

        return view('dashboard', compact('totalApartments', 'totalMessages', 'totalVisits'));
    }
}
