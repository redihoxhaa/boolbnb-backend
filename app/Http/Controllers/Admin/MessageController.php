<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return view('admin.messages.list', compact('messages'));
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
        // $data = $request->validated();
        // $message = new Message();

        // $message->apartment_id = $data['apartment_id'];
        // $message->sender_name = $data['sender_name'];
        // $message->sender_email = $data['sender_email'];
        // $message->message_text = $data['message_text'];
        // $message->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
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
