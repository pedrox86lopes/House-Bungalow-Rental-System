<x-mail::message>
# Confirmação da Sua Reserva

Olá {{ $user->name }},

Agradecemos a sua reserva! Os detalhes da sua estadia são os seguintes:

---

**Detalhes da Reserva:**
* **Bungalow:** {{ $booking->bungalow->name }}
* **Datas da Reserva:** De {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
* **Noites:** {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) }}
* **Preço por Noite:** €{{ number_format($booking->bungalow->price_per_night, 2) }}
* **Total Pago:** €{{ number_format($booking->total_price, 2) }}
* **Status do Pagamento:** {{ ucfirst($booking->payment_status) }}
@if($booking->paypal_transaction_id)
* **ID da Transação PayPal:** {{ $booking->paypal_transaction_id }}
@endif

---

Estamos ansiosos por recebê-lo(a)! Se tiver alguma questão, por favor, não hesite em contactar-nos.

Atenciosamente,
{{ config('app.name') }}
</x-mail::message>
