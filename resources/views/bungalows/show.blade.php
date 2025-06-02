<x-app-layout>

    {{-- Hero Section for Bungalow Details Page (unchanged) --}}
    <div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
        style="background-image: url('{{ asset($bungalow->image_url ?? 'https://images.unsplash.com/photo-1570129476816-c0c1692e850b?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}');">
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

            {{--- START IMPROVED SECTION: Bungalow Configuration Details ---}}
            <div class="mb-8 border-t pt-6 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Configuração do Bungalow</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if($bungalow->bedrooms !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-bed text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Quartos:</span>
                                <span class="font-bold text-indigo-700 dark:text-indigo-300">{{ $bungalow->bedrooms }}</span>
                            </div>
                        </div>
                    @endif
                    @if($bungalow->beds !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-hotel text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Camas:</span>
                                <span class="font-bold text-indigo-700 dark:text-indigo-300">{{ $bungalow->beds }}</span>
                            </div>
                        </div>
                    @endif
                    @if($bungalow->bathrooms !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-bath text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Casas de Banho:</span>
                                <span class="font-bold text-indigo-700 dark:text-indigo-300">{{ $bungalow->bathrooms }}</span>
                            </div>
                        </div>
                    @endif
                    @if($bungalow->accommodates !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-person-shelter text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Acomoda:</span>
                                <span class="font-bold text-indigo-700 dark:text-indigo-300">{{ $bungalow->accommodates }} pessoa{{ $bungalow->accommodates > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    @endif
                     @if($bungalow->has_towels !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-hand-sparkles text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Toalhas Incluídas:</span>
                                <span class="font-bold {{ $bungalow->has_towels ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $bungalow->has_towels ? 'Sim' : 'Não' }}
                                </span>
                            </div>
                        </div>
                    @endif
                    @if($bungalow->has_private_bathroom !== null)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                            <i class="fa-solid fa-toilet text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Casa de Banho Privativa:</span>
                                <span class="font-bold {{ $bungalow->has_private_bathroom ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $bungalow->has_private_bathroom ? 'Sim' : 'Não' }}
                                </span>
                            </div>
                        </div>
                    @endif
                    @if($bungalow->amenities)
                        <div class="flex items-center text-gray-800 dark:text-gray-200 text-lg space-x-3 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm col-span-1 sm:col-span-2 lg:col-span-3">
                            <i class="fa-solid fa-lightbulb text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                            <div>
                                <span class="font-semibold">Outras Comodidades:</span>
                                <span class="font-normal">{{ $bungalow->amenities }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{--- END IMPROVED SECTION ---}}

            {{-- Section for check-in/check-out times (static as per requirement) --}}
            <div class="mb-8 border-t pt-6 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Horários</h3>
                <ul class="list-disc list-inside text-gray-700 text-lg space-y-2">
                    <li><span class="font-semibold">Hora de Entrada:</span> a partir das 16 horas</li>
                    <li><span class="font-semibold">Hora de Saída:</span> até às 12 horas</li>
                </ul>
            </div>


            <div class="mb-8 border-t pt-6 border-gray-200">
                <p class="text-gray-700 text-xl mb-4">
                    <span class="font-semibold text-gray-900">Preço por noite:</span>
                    <span class="inline-block bg-green-500 text-white px-4 py-2 rounded-full text-2xl font-bold ml-3 shadow-md">€{{ number_format($bungalow->price_per_night, 2, ',', '.') }}</span>
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
