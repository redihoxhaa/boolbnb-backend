<?php

namespace App\Http\Controllers\Admin;

use App\Models\Visit;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Carbon\Carbon;


class VisitController extends Controller
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
        return view('admin.analytics.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }

    public function storeVisitFromGuest(Request $request)
    {
        $validatedData = $request->validate([
            'apartment_id' => 'required|integer|exists:apartments,id',
        ]);

        // Ottieni la data di inizio della giornata corrente
        $startOfDay = Carbon::now()->startOfDay();

        // Verifica se è stata fatta una visita per l'appartamento specificato dall'IP nella giornata corrente
        $lastVisit = Visit::where('apartment_id', $validatedData['apartment_id'])
            ->where('visitor_ip', $request->ip())
            ->where('created_at', '>=', $startOfDay)
            ->first();

        if ($lastVisit) {
            // Se è stata trovata una visita nella giornata corrente, restituisci un messaggio di errore
            return response()->json(['error' => 'Too many visits for this apartment today'], 403);
        }

        // Se non è stata trovata una visita per l'appartamento specificato dall'IP nella giornata corrente, salva la nuova visita
        $visit = new Visit();
        $visit->apartment_id = $validatedData['apartment_id'];
        $visit->visitor_ip = $request->ip();
        $visit->save();

        return response()->json(['message' => 'Registered visit'], 201);
    }
}
