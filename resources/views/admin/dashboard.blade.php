<x-app-layout>
{{-- Lucide Icons CDN for the info icon in the empty state --}}
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>

<div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
    style="background-image: url('https://images.unsplash.com/photo-1517457210-bf26f4c0b485?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
    <div class="absolute inset-0 bg-black opacity-60 rounded-lg"></div>
    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Painel de Administração</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Gestão de reservas e propriedades.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-center text-4xl font-extrabold text-gray-800 mb-10">Todas as Reservas</h2>

    @forelse ($bookings as $booking)
        <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="flex-shrink-0">
                <img src="{{ asset($booking->bungalow->image_url ?? 'https://placehold.co/200x150/E0E0E0/333333?text=Bungalow') }}"
                     alt="{{ $booking->bungalow->name }}"
                     class="w-48 h-36 object-cover rounded-lg shadow">
            </div>
            <div class="flex-grow text-center md:text-left">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $booking->bungalow->name }}</h3>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Cliente:</span> {{ $booking->user->name ?? 'N/A' }} (ID: {{ $booking->user_id }})
                </p>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Período:</span> {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                </p>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Total:</span> <span class="text-green-600 font-bold">€{{ number_format($booking->total_price, 2, ',', '.') }}</span>
                </p>
                <p class="text-gray-700 text-lg">
                    <span class="font-semibold">Estado:</span>
                    @php
                        $statusClass = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'paid' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'failed' => 'bg-red-100 text-red-800',
                        ][$booking->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </p>
            </div>
            <div class="flex-shrink-0 mt-4 md:mt-0">
                {{-- Admin actions, e.g., change status, view details --}}
                {{-- <a href="{{ route('admin.booking.details', $booking->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Gerir</a> --}}
            </div>
        </div>
    @empty
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-8 rounded-lg text-center mt-12 shadow-md" role="alert">
            <div class="flex flex-col items-center justify-center">
                <span class="text-blue-500 mb-4" data-lucide="info" style="width: 48px; height: 48px;"></span>
                <p class="text-xl font-semibold mb-2">Nenhuma reserva encontrada.</p>
                <p class="text-lg">Ainda não há reservas no sistema.</p>
            </div>
        </div>
    @endforelse
</div>
</x-app-layout>
