<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Don't forget to import Log
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Handle the submission of the contact admin form.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would implement your logic to send the message to the admin.
        // This could be:
        // 1. Sending an email notification to the admin (e.g., using Mail::to('admin@example.com')->send(new AdminContactMail($request->all())));
        // 2. Storing the message in a 'feedback' or 'admin_messages' table in the database for the admin to view later.
        // 3. Using a third-party service.

        // For now, we'll just log it and redirect.
        Log::info('Admin Contact Message from ' . Auth::user()->email . ':', [
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'A sua mensagem foi enviada para o Gestor! - CONFIRMAR em logs/laravel.log :)');
    }
}
