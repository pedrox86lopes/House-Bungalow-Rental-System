<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Booking; // Make sure to import your Booking model
use App\Models\Message; // <--- ADD THIS LINE
use App\Models\User;    // <--- ADD THIS LINE
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;       // <--- ADD THIS LINE for date formatting

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
                        "currency_code" => "EUR",
                        "value" => number_format($booking->total_amount, 2, '.', ''),
                    ],
                    "description" => "Aluguel de " . $booking->bungalow->name . " de " . $booking->start_date . " a " . $booking->end_date,
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        Log::error("PayPal order creation failed: " . json_encode($response));
        $booking->update(['status' => 'failed']);
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

            // --- Send message for PAID booking HERE ---
            $this->sendMessageToUserAboutBooking($booking, 'paid');

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
            $booking->update(['status' => 'cancelled']);

            // --- Send message for CANCELLED booking HERE ---
            $this->sendMessageToUserAboutBooking($booking, 'cancelled');
        }

        return redirect()->route('user.reservations')->with('info', 'Pagamento PayPal cancelado. A sua reserva não foi concluída.');
    }

    /**
     * Helper function to send an internal message to the user about their booking.
     * Copied from BookingController for direct use here.
     * Consider moving this to a Trait or Service for better reusability.
     *
     * @param Booking $booking The booking instance.
     * @param string $status The new status of the booking ('pending', 'paid', 'cancelled').
     * @return void
     */
    private function sendMessageToUserAboutBooking(Booking $booking, string $status)
    {
        $sender = User::where('is_admin', true)->first(); // Ensure an admin user exists with 'is_admin' column set to true

        if (!$sender) {
            Log::error("No admin user found to send booking messages.");
            return;
        }

        $subject = '';
        $body = '';
        $bungalowName = $booking->bungalow->name;
        $checkInDate = Carbon::parse($booking->start_date)->format('d/m/Y');
        $checkOutDate = Carbon::parse($booking->end_date)->format('d/m/Y');
        $totalPrice = number_format($booking->total_price, 2);

        switch ($status) {
            case 'pending':
                $subject = "Reserva #{$booking->id} para {$bungalowName} - Pagamento Pendente";
                $body = "Olá {$booking->user->name},\n\nA sua reserva para o bungalow '{$bungalowName}' de {$checkInDate} a {$checkOutDate} (Total: €{$totalPrice}) foi registada como PENDENTE de pagamento.\n\nPor favor, complete o pagamento para confirmar a sua reserva.\n\nAtenciosamente,\nA Equipa de Reservas";
                break;
            case 'paid':
                $subject = "Confirmação de Reserva #{$booking->id} - {$bungalowName}";
                $body = "Olá {$booking->user->name},\n\nA sua reserva para o bungalow '{$bungalowName}' de {$checkInDate} a {$checkOutDate} (Total: €{$totalPrice}) foi CONFIRMADA e o pagamento processado com sucesso.\n\nAguardamos a sua estadia!\n\nAtenciosamente,\nA Equipa de Reservas";
                break;
            case 'cancelled':
                $subject = "Reserva #{$booking->id} para {$bungalowName} - Cancelada";
                $body = "Olá {$booking->user->name},\n\nA sua reserva para o bungalow '{$bungalowName}' de {$checkInDate} a {$checkOutDate} (Total: €{$totalPrice}) foi CANCELADA com sucesso.\n\nSe tiver alguma dúvida, por favor, contacte-nos.\n\nAtenciosamente,\nA Equipa de Reservas";
                break;
            default:
                $subject = "Atualização da Reserva #{$booking->id} para {$bungalowName}";
                $body = "Olá {$booking->user->name},\n\nA sua reserva para o bungalow '{$bungalowName}' de {$checkInDate} a {$checkOutDate} (Total: €{$totalPrice}) tem um novo estado: {$status}.\n\nAtenciosamente,\nA Equipa de Reservas";
                break;
        }

        Message::create([
            'sender_id'     => $sender->id,
            'receiver_id'   => $booking->user_id,
            'subject'       => $subject,
            'body'          => $body,
        ]);

        Log::info("Sent internal message to user {$booking->user_id} for booking {$booking->id} with status '{$status}'.");
    }
}
