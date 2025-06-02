<x-app-layout>
    {{-- Header Slot for the page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bungalows') }}
        </h2>
    </x-slot>

    {{-- Main content starts here (this is the default slot for x-app-layout) --}}
    <div class="py-12"> {{-- This div provides standard padding and max-width for content --}}
        {{-- Hero Section for Bungalows Page --}}
        <div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
            style="background-image: url('/storage/bungalows/4.jpg');">
            {{-- Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black opacity-60 rounded-lg"></div>
            <div class="relative z-10 container mx-auto px-4">
                <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Nossas Propriedades</h1>
                <p class="text-xl mb-8 max-w-3xl mx-auto">Explore nossos bungalows cuidadosamente selecionados para a sua estadia perfeita.</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            {{-- Search Filter Form --}}
            <div class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <form action="{{ route('bungalows.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <label for="search" class="sr-only">Pesquisar bungalows</label>
                        <input type="text"
                               name="search"
                               id="search"
                               placeholder="Pesquisar por nome ou descrição..."
                               value="{{ request('search') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    </div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all duration-300 ease-in-out">
                        Pesquisar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('bungalows.index') }}"
                           class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all duration-300 ease-in-out text-center md:text-left">
                            Limpar
                        </a>
                    @endif
                </form>
            </div>
            {{-- End Search Filter Form --}}

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($bungalows as $bungalow)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105">
                        @if($bungalow->image_url) {{-- Assuming you store image_path relative to storage/app/public --}}
                            <img src="{{ asset('' . $bungalow->image_url) }}" alt="{{ $bungalow->name }}" class="w-full h-56 object-cover">
                        @else
                            <img src="https://placehold.co/600x400/E0E0E0/333333?text=Sem+Imagem" alt="Sem Imagem" class="w-full h-56 object-cover">
                        @endif
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $bungalow->name }}</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">{{ $bungalow->description }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-600 dark:text-green-400 font-extrabold text-2xl">€{{ number_format($bungalow->price_per_night, 2, ',', '.') }}</span>
                                <span class="text-gray-600 dark:text-gray-400">/ noite</span>
                            </div>
                            <a href="{{ route('bungalows.show', $bungalow->id) }}"
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300 ease-in-out shadow-md">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-200 px-6 py-8 rounded-lg text-center shadow-md">
                        <p class="text-xl font-semibold mb-2">Nenhum bungalow encontrado.</p>
                        <p class="text-lg">Tente ajustar a sua pesquisa ou limpe os filtros.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
