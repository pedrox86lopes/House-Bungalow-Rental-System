<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use App\Models\Message; // Import the Message model

class ContactController extends Controller
{
    /**
     * Display the contact form to send a message to the admin.
     * This method is called by the route `contact.admin.create`
     */
    public function showContactForm()
    {
        // You might want to get the admin user here if you need their name for the form
        $adminEmail = config('app.admin_email');
        $adminUser = User::where('email', $adminEmail)->first();

        if (!$adminUser) {
            // Handle case where admin user is not found, e.g., redirect with error
            return redirect()->back()->with('error', 'O administrador não foi encontrado. Por favor, contacte o suporte técnico.');
        }

        return view('contact.admin_form', compact('adminUser')); // You'll create this view
    }

    /**
     * Store a new message to the administrator.
     * This method is called by the route `contact.admin` (POST)
     */
    public function sendMessage(Request $request)
    {
        // 1. Find the administrator user
        $adminEmail = config('app.admin_email');
        $adminUser = User::where('email', $adminEmail)->first();

        // If admin user is not found, redirect back with an error
        if (!$adminUser) {
            return redirect()->back()->with('error', 'O gestor de reservas não foi encontrado. Por favor, contacte o suporte técnico.');
        }

        // 2. Validate the request data
        $request->validate([
            'subject' => 'nullable|string|max:255', // Subject is optional as per your form
            'message' => 'required|string',         // The body of the message
        ]);

        // 3. Create a new message in the database
        Message::create([
            'sender_id'     => Auth::id(),         // The currently authenticated user
            'receiver_id'   => $adminUser->id,     // The admin user
            'subject'       => $request->subject,
            'body'          => $request->message,  // Use 'message' from the form
        ]);

        // 4. Redirect back with a success message
        return redirect()->back()->with('success', 'A sua mensagem foi enviada ao gestor de reservas com sucesso!');
    }
}
