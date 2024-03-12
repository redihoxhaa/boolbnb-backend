<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ottieni l'ID dell'utente autenticato
        $userId = Auth::id();

        // Ottieni tutti gli appartamenti dell'utente loggato con almeno un messaggio
        $apartments = Apartment::where('user_id', $userId)
            ->whereHas('messages')
            ->get();

        return view('admin.messages.list', compact('apartments'));
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
    public function store(StoreMessageRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($apartmentId)
    {
        // Ottieni l'ID dell'utente autenticato
        $userId = Auth::id();

        // Controlla se l'appartamento specificato appartiene all'utente autenticato
        $apartment = Apartment::where('id', $apartmentId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Ottieni solo i messaggi relativi all'appartamento specificato
        $messages = $apartment->messages;

        // Ritorna la vista mostrando solo i messaggi dell'appartamento
        return response()->json($messages);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();
    }

    public function storeMessageFromGuest(Request $request)
    {
        $validatedData = $request->validate([
            'apartment_id' => 'required|integer|exists:apartments,id',
            'sender_name' => 'required|string',
            'sender_email' => 'required|email',
            'message_text' => 'required|string',
        ]);

        $message = new Message();
        $message->apartment_id = $validatedData['apartment_id'];
        $message->sender_name = $validatedData['sender_name'];
        $message->sender_email = $validatedData['sender_email'];
        $message->message_text = $validatedData['message_text'];
        $message->save();

        return response()->json(['message' => 'Message successfully delivered'], 201);
    }
}
