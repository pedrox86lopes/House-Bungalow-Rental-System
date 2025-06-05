<x-app-layout>
    {{-- Header Slot for the page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bungalows') }}
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Custom styles for Flatpickr if needed */
        .flatpickr-calendar {
            z-index: 9999; /* Ensure it's above other elements */
        }
    </style>

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
            {{-- Search and Date Filter Form --}}
            <div class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <form action="{{ route('bungalows.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-grow w-full md:w-auto">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesquisar Bungalows</label>
                        <input type="text"
                               name="search"
                               id="search"
                               placeholder="Nome ou descrição..."
                               value="{{ request('search') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    </div>

                    <div class="w-full md:w-auto">
                        <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Datas de Estadia</label>
                        <input type="text"
                               id="date_range"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm dark:bg-gray-700 dark:border-gray-700 dark:text-gray-100"
                               placeholder="Selecione as datas"
                               value="{{ $startDate && $endDate ? $startDate . ' to ' . $endDate : '' }}"
                               data-start-date="{{ $startDate }}"
                               data-end-date="{{ $endDate }}">
                        <input type="hidden" name="start_date" id="start_date_hidden" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" id="end_date_hidden" value="{{ $endDate }}">
                    </div>

                    <button type="submit"
                            class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all duration-300 ease-in-out">
                        Filtrar
                    </button>
                    @if(request('search') || $startDate || $endDate)
                        <a href="{{ route('bungalows.index') }}"
                           class="w-full md:w-auto bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all duration-300 ease-in-out text-center">
                            Limpar
                        </a>
                    @endif
                </form>
            </div>
            {{-- End Search and Date Filter Form --}}

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($bungalows as $bungalow)
                    @php
                        $isReserved = false;
                        if ($startDate && $endDate) {
                            // Check if the bungalow has any bookings for the selected date range
                            // The `bookings` relationship was eager-loaded with the date constraint in the controller
                            $isReserved = $bungalow->bookings->isNotEmpty();
                        }

                        // Determine the URL parameters to pass to the booking page
                        $bookingParams = [];
                        if ($startDate) {
                            $bookingParams['start_date'] = $startDate;
                        }
                        if ($endDate) {
                            $bookingParams['end_date'] = $endDate;
                        }
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105 {{ $isReserved ? 'border-2 border-red-500 opacity-70' : '' }}">
                        @if($bungalow->image_url)
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

                            @if ($startDate && $endDate)
                                @if ($isReserved)
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg text-sm text-center mb-4">
                                        <i class="fa-solid fa-calendar-times mr-2"></i> Reservado nestas datas
                                    </div>
                                    <button class="block w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed" disabled>
                                        Indisponível
                                    </button>
                                @else
                                    {{-- Pass selected dates as query parameters to booking.create --}}
                                    <a href="{{ route('booking.create', $bungalow->id) }}?{{ http_build_query($bookingParams) }}"
                                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300 ease-in-out shadow-md">
                                        Ver Detalhes e Reservar
                                    </a>
                                @endif
                            @else
                                {{-- Default link if no dates are selected --}}
                                <a href="{{ route('bungalows.show', $bungalow->id) }}"
                                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300 ease-in-out shadow-md">
                                    Ver Detalhes
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-200 px-6 py-8 rounded-lg text-center shadow-md">
                        <p class="text-xl font-semibold mb-2">Nenhum bungalow encontrado.</p>
                        <p class="text-lg">Tente ajustar a sua pesquisa ou limpe os filtros.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $bungalows->links() }} {{-- If you are using pagination --}}
            </div>
        </div>
    </div>

    {{-- Font Awesome for icons --}}
    <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script> {{-- Replace with your actual Font Awesome kit --}}
    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script> {{-- Portuguese localization --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateRangeInput = document.getElementById('date_range');
            const startDateHidden = document.getElementById('start_date_hidden');
            const endDateHidden = document.getElementById('end_date_hidden');

            flatpickr(dateRangeInput, {
                mode: "range",
                minDate: "today",
                dateFormat: "Y-m-d",
                locale: "pt", // Set locale to Portuguese
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        startDateHidden.value = instance.formatDate(selectedDates[0], "Y-m-d");
                        endDateHidden.value = instance.formatDate(selectedDates[1], "Y-m-d");
                    } else {
                        // If only one date or no date selected (e.g., cleared), clear hidden fields
                        startDateHidden.value = '';
                        endDateHidden.value = '';
                    }
                }
            });

            // Initialize flatpickr with pre-selected dates if available from old input
            const initialStartDate = dateRangeInput.dataset.startDate;
            const initialEndDate = dateRangeInput.dataset.endDate;
            if (initialStartDate && initialEndDate) {
                dateRangeInput._flatpickr.setDate([initialStartDate, initialEndDate], true);
            }
        });
    </script>
</x-app-layout>
