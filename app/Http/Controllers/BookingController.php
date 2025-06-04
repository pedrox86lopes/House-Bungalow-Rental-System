<?php

namespace App\Http\Controllers;

use App\Models\Bungalow;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function create(Request $request, $bungalowId) // Add Request $request
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
                                        ->whereIn('status', ['paid', 'pending']) // Only check 'paid' and 'pending' bookings
                                        ->first();

            if ($existingBooking) {
                return response()->json(['message' => 'Este bungalow não está disponível para as datas selecionadas. Por favor, escolha outras datas.'], 409); // 409 Conflict
            }
            // --- END NEW AVAILABILITY CHECK ---

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'bungalow_id' => $bungalow->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => $calculatedTotalPrice,
                'status' => 'pending',
                'guest_name' => Auth::user()->name,
                'guest_email' => Auth::user()->email,
                'check_in' => $request->start_date,
                'check_out' => $request->end_date,
            ]);

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
}
