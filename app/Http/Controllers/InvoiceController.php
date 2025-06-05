<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Use the Booking model
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF Facade
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Generate and download the PDF invoice for a specific booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice(Booking $booking)
    {
        // Ensure only the owner or an admin can download their invoice
        if (Auth::id() !== $booking->user_id && Auth::user()->email !== config('app.admin_email')) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the booking is paid before generating an invoice
        if ($booking->status !== 'paid') {
            return redirect()->back()->with('error', 'Fatura apenas disponível para reservas pagas.');
        }

        // Eager load the bungalow relationship
        // This ensures $booking->bungalow is available without N+1 queries.
        $booking->load('bungalow');

        // Load the view with booking data
        $pdf = Pdf::loadView('invoices.booking', compact('booking'));

        // Set paper size to A4 and orientation to portrait (optional, but good practice)
        $pdf->setPaper('A4', 'portrait');

        // Download the PDF file with a dynamic filename
        return $pdf->download('fatura_reserva_' . $booking->invoice_number . '.pdf');
    }
}
