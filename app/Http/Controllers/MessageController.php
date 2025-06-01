<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a list of received messages for the authenticated user (Inbox).
     */
    public function index()
    {
        $messages = Auth::user()->receivedMessages()->with('sender')->latest()->get();
        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message to a specific user.
     * @param User $receiver The user to whom the message will be sent.
     */
    public function create(User $receiver, Request $request)
    {
        // Prevent sending message to self (optional)
        if (Auth::id() === $receiver->id) {
            return redirect()->back()->with('error', 'Não pode enviar mensagens para si próprio.');
        }

        // Pass reservation info if present (for autofill)
        $reservation = null;
        if ($request->has('reservation_id')) {
            $reservation = [
                'id' => $request->input('reservation_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'status' => $request->input('status'),
            ];
        }

        return view('messages.create', compact('receiver', 'reservation'));
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request, User $receiver)
    {
        $request->validate([
        'subject' => 'nullable|string|max:255',
        'body' => 'required|string',
        'reservation_id' => 'nullable|integer',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'status' => 'nullable|string',
    ]);

        Message::create([
        'sender_id'     => Auth::id(),
        'receiver_id'   => $receiver->id,
        'subject'       => $request->subject,
        'body'          => $request->body,
    ]);

        return redirect()->route('messages.index')->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Ensure the authenticated user is either the sender or receiver of the message
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        // Mark as read if the current user is the receiver and it's not already read
        if ($message->receiver_id === Auth::id() && is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message'));
    }

    // You might also want methods for deleting messages, etc.
}
