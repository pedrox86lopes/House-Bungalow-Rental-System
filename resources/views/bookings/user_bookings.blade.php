<x-app-layout>
<div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
    style="background-image: url('https://images.unsplash.com/photo-1542314881-d227b615144b?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
    <div class="absolute inset-0 bg-black opacity-60 rounded-lg"></div>
    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Minhas Reservas</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Aqui pode ver todas as suas reservas futuras e passadas.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
        </div>
    @endif

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
                    <span class="font-semibold">Período:</span> {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                </p>
                <p class="text-gray-700 text-lg mb-1">
                    <span class="font-semibold">Total:</span> <span class="text-green-600 font-bold">€{{ number_format($booking->total_amount, 2, ',', '.') }}</span>
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
                {{-- Add action buttons here, e.g., view details, cancel (if pending) --}}
                {{-- <a href="{{ route('booking.details', $booking->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Ver Detalhes</a> --}}
            </div>
        </div>
    @empty
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-8 rounded-lg text-center mt-12 shadow-md" role="alert">
            <div class="flex flex-col items-center justify-center">
                <span class="text-blue-500 mb-4" data-lucide="info" style="width: 48px; height: 48px;"></span>
                <p class="text-xl font-semibold mb-2">Não tem reservas ativas.</p>
                <p class="text-lg">Que tal explorar os nossos <a href="{{ route('bungalows.index') }}" class="text-blue-600 hover:underline">bungalows disponíveis</a>?</p>
            </div>
        </div>
    @endforelse
</div>
</x-app-layout>
