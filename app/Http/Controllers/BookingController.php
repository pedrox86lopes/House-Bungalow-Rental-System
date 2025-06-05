<?php

namespace App\Http\Controllers;

use App\Models\Bungalow;
use App\Models\Booking;
use App\Models\Message; // <--- ADD THIS LINE
use App\Models\User;    // <--- ADD THIS LINE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;       // <--- ADD THIS LINE for date formatting

class BookingController extends Controller
{
    public function create(Request $request, $bungalowId)
    {
        $bungalow = Bungalow::findOrFail($bungalowId);

        // Get dates from query parameters
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return view('bookings.create', compact('bungalow', 'startDate', 'endDate'));
    }

    public function confirmAndPay(Request $request)
    {
        $request->validate([
            'bungalow_id' => 'required|exists:bungalows,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0.01',
        ]);

        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
            }

            $bungalow = Bungalow::findOrFail($request->bungalow_id);

            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $interval = $startDate->diff($endDate);
            $calculatedNights = $interval->days;
            $calculatedTotalPrice = $calculatedNights * $bungalow->price_per_night;

            if (abs($calculatedTotalPrice - $request->total_price) > 0.01) {
                Log::warning("Price mismatch for booking. Client sent {$request->total_price}, server calculated {$calculatedTotalPrice}. Bungalow ID: {$bungalow->id}");
                return response()->json(['message' => 'Erro de validação de preço. Por favor, tente novamente.'], 422);
            }

            // --- NEW AVAILABILITY CHECK IS HERE ---
            $existingBooking = Booking::where('bungalow_id', $bungalow->id)
                                        ->where(function ($query) use ($startDate, $endDate) {
                                            $query->where(function ($q) use ($startDate, $endDate) {
                                                $q->where('start_date', '<', $endDate->format('Y-m-d'))
                                                  ->where('end_date', '>', $startDate->format('Y-m-d'));
                                            })
                                            // Consider pending bookings as well for availability
                                            ->orWhere(function ($q) use ($startDate, $endDate) {
                                                $q->where('status', 'pending')
                                                  ->where('start_date', '<', $endDate->format('Y-m-d'))
                                                  ->where('end_date', '>', $startDate->format('Y-m-d'));
                                            });
                                        })
                                        ->whereIn('status', ['paid', 'pending'])
                                        ->first();

            if ($existingBooking) {
                return response()->json(['message' => 'Este bungalow não está disponível para as datas selecionadas. Por favor, escolha outras datas.'], 409);
            }
            // --- END NEW AVAILABILITY CHECK ---

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'bungalow_id' => $bungalow->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => $calculatedTotalPrice,
                'status' => 'pending', // Initial status
                'guest_name' => Auth::user()->name,
                'guest_email' => Auth::user()->email,
                'check_in' => $request->start_date,
                'check_out' => $request->end_date,
            ]);

            // --- Send message for PENDING booking ---
            $this->sendMessageToUserAboutBooking($booking, 'pending');

            $paypalRedirectUrl = route('transaction.process', ['bookingId' => $booking->id]);

            return response()->json([
                'message' => 'Reserva criada com sucesso. Redirecionando para o pagamento.',
                'redirect_url' => $paypalRedirectUrl
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error creating booking: " . $e->getMessage());
            return response()->json(['message' => 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.'], 500);
        }
    }

    public function userBookings()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor, faça login para ver as suas reservas.');
        }

        $bookings = Booking::where('user_id', Auth::id())
                            ->with('bungalow')
                            ->orderBy('start_date', 'asc')
                            ->get();

        return view('bookings.user_bookings', compact('bookings'));
    }

    /**
     * Helper function to send an internal message to the user about their booking.
     *
     * @param Booking $booking The booking instance.
     * @param string $status The new status of the booking ('pending', 'paid', 'cancelled').
     * @return void
     */
    private function sendMessageToUserAboutBooking(Booking $booking, string $status)
    {
        $sender = User::where('is_admin', true)->first(); // Assuming you have an admin user. Adjust as needed.

        if (!$sender) {
            Log::error("No admin user found to send booking messages.");
            return; // Exit if no admin sender is found
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
                // Fallback for unknown status
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

    // --- You will also need to add calls to sendMessageToUserAboutBooking
    // --- in other methods where booking status changes, e.g.,
    // --- a method that handles successful PayPal payments (status to 'paid')
    // --- and a method that handles cancellations (status to 'cancelled').
    // --- Example (placeholder - you'll integrate this into your actual payment/cancellation logic):

    // public function handlePaymentSuccess(Request $request, Booking $booking)
    // {
    //     // ... existing payment processing logic ...
    //     $booking->update(['status' => 'paid', 'paypal_transaction_id' => $transactionId]);
    //     $this->sendMessageToUserAboutBooking($booking, 'paid');
    //     // ... redirect or return response ...
    // }

    // public function cancelBooking(Booking $booking)
    // {
    //     // ... existing cancellation logic ...
    //     $booking->update(['status' => 'cancelled']);
    //     $this->sendMessageToUserAboutBooking($booking, 'cancelled');
    //     // ... redirect or return response ...
    // }
}
