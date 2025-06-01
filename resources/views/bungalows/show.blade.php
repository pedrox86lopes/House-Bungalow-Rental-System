
<x-app-layout>

{{-- Hero Section for Bungalow Details Page --}}
<div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
    style="background-image: url('{{ asset($bungalow->image_url ?? 'https://images.unsplash.com/photo-1570129476816-c0c1692e850b?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}');">
    {{-- Overlay for better text readability --}}
    <div class="absolute inset-0 bg-black opacity-60 rounded-lg"></div>
    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">{{ $bungalow->name }}</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">{{ Str::limit($bungalow->description, 150) }}</p>
    </div>
</div>


<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto">
        <div class="mb-8">
            <img src="{{ asset($bungalow->image_url ?? 'https://placehold.co/800x500/E0E0E0/333333?text=Sem+Imagem') }}"
                 class="w-full h-96 object-cover rounded-lg shadow-md mb-6"
                 alt="{{ $bungalow->name }}">
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-4">Sobre esta Propriedade</h2>
        <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $bungalow->description }}</p>

        <div class="mb-8 border-t pt-6 border-gray-200">
            <p class="text-gray-700 text-xl mb-4">
                <span class="font-semibold text-gray-900">Preço por noite:</span>
                <span class="inline-block bg-green-500 text-white px-4 py-2 rounded-full text-2xl font-bold ml-3 shadow-md">€{{ $bungalow->price_per_night }}</span>
            </p>
        </div>

        <div class="flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-4 mt-8">
            {{-- Conditional display for the "Reservar Agora" button --}}
            @auth
                {{-- User is logged in, show the booking button --}}
                <a href="{{ route('booking.create', $bungalow->id) }}"
                   class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Reservar Agora
                </a>
            @else
                {{-- User is a guest, show a login/register prompt --}}
                <div class="w-full sm:w-auto text-center bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-lg shadow-md">
                    <p class="text-lg font-semibold mb-3">Para reservar este bungalow, por favor, faça login ou registe-se.</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('login') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 ease-in-out">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 ease-in-out">
                            Registar
                        </a>
                    </div>
                </div>
            @endauth

            <a href="{{ route('bungalows.index') }}"
               class="w-full sm:w-auto text-center px-8 py-3 border border-gray-400 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-300 text-base font-medium focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                Voltar à Lista
            </a>
        </div>
    </div>
</div>
</x-app-layout>

