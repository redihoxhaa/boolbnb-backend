<?php

namespace App\Http\Controllers\Admin;

use App\Models\Visit;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $message = new Visit();
        $message->apartment_id = $validatedData['apartment_id'];
        $message->visitor_ip = $request->ip();
        $message->save();

        return response()->json(['message' => 'Registered visit'], 201);
    }
}
