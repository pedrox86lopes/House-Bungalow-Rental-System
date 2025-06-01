<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Booking; // Make sure to import your Booking model
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    // ... (your existing createTransaction method if any)

    public function processTransaction(Request $request)
    {
        $bookingId = $request->query('bookingId');
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return redirect()->route('booking.create')->with('error', 'Reserva não encontrada.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('user.reservations')->with('info', 'Esta reserva já foi processada.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('transaction.success', ['bookingId' => $booking->id]),
                "cancel_url" => route('transaction.cancel', ['bookingId' => $booking->id]),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR", // Or your currency
                        "value" => number_format($booking->total_price, 2, '.', ''), // Ensure correct format
                    ],
                    "description" => "Aluguel de " . $booking->bungalow->name . " de " . $booking->start_date . " a " . $booking->end_date,
                    // You can add more details here if needed
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // Redirect to PayPal approval URL
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        // Handle error if PayPal order creation fails
        Log::error("PayPal order creation failed: " . json_encode($response));
        $booking->update(['status' => 'failed']); // Mark booking as failed
        return redirect()->route('booking.create', ['bungalowId' => $booking->bungalow_id])->with('error', 'Ocorreu um erro ao iniciar o pagamento PayPal. Por favor, tente novamente.');
    }

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        $bookingId = $request->query('bookingId');
        $booking = Booking::find($bookingId);

        if (!$booking) {
            Log::error("PayPal success callback: Booking not found for ID: " . $bookingId);
            return redirect()->route('user.reservations')->with('error', 'Erro: Reserva não encontrada após pagamento.');
        }

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $booking->update(['status' => 'paid']);
            return redirect()->route('user.reservations')->with('success', 'Pagamento efetuado com sucesso! A sua reserva está confirmada.');
        } else {
            Log::warning("PayPal payment not completed for booking ID: " . $bookingId . " Response: " . json_encode($response));
            $booking->update(['status' => 'failed']);
            return redirect()->route('user.reservations')->with('error', 'O pagamento PayPal não foi concluído. Por favor, tente novamente.');
        }
    }

    public function cancelTransaction(Request $request)
    {
        $bookingId = $request->query('bookingId');
        $booking = Booking::find($bookingId);

        if ($booking) {
            $booking->update(['status' => 'cancelled']); // Mark as cancelled
            // Or if you prefer to delete pending bookings on cancel:
            // $booking->delete();
        }

        return redirect()->route('user.reservations')->with('info', 'Pagamento PayPal cancelado. A sua reserva não foi concluída.');
    }

    // ... (your existing finishTransaction method if any)
}
