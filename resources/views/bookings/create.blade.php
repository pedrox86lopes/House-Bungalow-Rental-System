<x-app-layout>
    {{-- Header Slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Confirmar Reserva para:') }} {{ $bungalow->name }}
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            z-index: 9999;
            /* Ensure it's above other elements */
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset($bungalow->image_url ?? 'https://placehold.co/100x75/E0E0E0/333333?text=Bungalow') }}"
                        alt="{{ $bungalow->name }}" class="w-24 h-18 object-cover rounded-md shadow">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $bungalow->name }}</h3>
                        <p class="text-lg text-gray-700 dark:text-gray-300">Preço por noite: <span
                                class="font-semibold text-green-600 dark:text-green-400">€{{ number_format($bungalow->price_per_night, 2, ',', '.') }}</span>
                        </p>
                    </div>
                </div>

                <form id="booking-form" action="{{ route('booking.confirm_and_pay') }}" method="POST"
                    class="space-y-6">
                    @csrf
                    <input type="hidden" name="bungalow_id" value="{{ $bungalow->id }}">

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data
                            de Entrada</label>
                        <input type="text" name="start_date" id="start_date" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                            value="{{ old('start_date', $startDate) }}"> {{-- Pre-fill from old input or $startDate --}}
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de
                            Saída</label>
                        <input type="text" name="end_date" id="end_date" required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                            value="{{ old('end_date', $endDate) }}"> {{-- Pre-fill from old input or $endDate --}}
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Noites: <span id="number_of_nights" class="text-blue-600 dark:text-blue-400">0</span>
                        </p>
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            Preço Total: <span id="total_price_display"
                                class="text-green-600 dark:text-green-400">€0.00</span>
                        </p>
                        {{-- OLD: <input type="hidden" name="total_price" id="total_price_hidden"> --}}
                        <input type="hidden" name="total_amount" id="total_amount_hidden"> {{-- <-- CHANGED THIS LINE --}}
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8">
                        <button type="submit" id="confirm-booking-btn"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                            Confirmar e Pagar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const pricePerNight = parseFloat({{ $bungalow->price_per_night }});
            const numberOfNightsSpan = document.getElementById('number_of_nights');
            const totalPriceDisplay = document.getElementById('total_price_display');
            const totalAmountHidden = document.getElementById('total_amount_hidden'); // <-- CHANGED THIS LINE
            const confirmBookingBtn = document.getElementById('confirm-booking-btn');

            function calculatePrice() {
                const start = flatpickr.parseDate(startDateInput.value, "Y-m-d");
                const end = flatpickr.parseDate(endDateInput.value, "Y-m-d");

                if (start && end && end > start) {
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    numberOfNightsSpan.textContent = diffDays;
                    const totalPrice = diffDays * pricePerNight;
                    totalPriceDisplay.textContent = `€${totalPrice.toFixed(2).replace('.', ',')}`;
                    totalAmountHidden.value = totalPrice.toFixed(2); // <-- CHANGED THIS LINE
                    confirmBookingBtn.disabled = false;
                } else {
                    numberOfNightsSpan.textContent = '0';
                    totalPriceDisplay.textContent = '€0.00';
                    totalAmountHidden.value = '0.00'; // <-- CHANGED THIS LINE
                    confirmBookingBtn.disabled = true;
                }
            }

            // Initialize Flatpickr for start and end dates
            const fpStartDate = flatpickr(startDateInput, {
                dateFormat: "Y-m-d",
                minDate: "today",
                locale: "pt",
                onChange: function(selectedDates, dateStr, instance) {
                    // Update minDate for endDate picker
                    if (selectedDates.length > 0) {
                        fpEndDate.set('minDate', selectedDates[0]);
                        calculatePrice();
                    } else {
                        fpEndDate.set('minDate', 'today'); // Reset if start date is cleared
                        calculatePrice();
                    }
                }
            });

            const fpEndDate = flatpickr(endDateInput, {
                dateFormat: "Y-m-d",
                minDate: startDateInput.value || "today", // Min date is start date or today
                locale: "pt",
                onChange: function(selectedDates, dateStr, instance) {
                    calculatePrice();
                }
            });

            // Initial calculation if dates are pre-filled
            calculatePrice();

            // Handle form submission via AJAX for a smoother UX
            document.getElementById('booking-form').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                confirmBookingBtn.disabled = true; // Disable button to prevent multiple submissions
                confirmBookingBtn.textContent = 'A processar...'; // Change button text

                fetch(this.action, {
                        method: this.method,
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Important for Laravel's AJAX detection
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        if (status >= 200 && status < 300) { // Success range
                            alert(body.message);
                            if (body.redirect_url) {
                                window.location.href = body.redirect_url; // Redirect to PayPal
                            }
                        } else if (status === 401) { // Unauthorized
                            alert('Não autorizado. Por favor, faça login.');
                            window.location.href = '{{ route('login') }}';
                        } else if (status === 409) { // Conflict (Bungalow already booked)
                            alert(body.message); // Display the specific error message
                            confirmBookingBtn.disabled = false; // Re-enable button
                            confirmBookingBtn.textContent = 'Confirmar e Pagar'; // Reset button text
                        } else { // Other errors (422 validation, 500 server error)
                            let errorMessage = body.message ||
                                'Ocorreu um erro inesperado. Por favor, tente novamente.';
                            if (body.errors) {
                                for (const key in body.errors) {
                                    errorMessage += `\n${body.errors[key].join(', ')}`;
                                }
                            }
                            alert(errorMessage);
                            confirmBookingBtn.disabled = false; // Re-enable button
                            confirmBookingBtn.textContent = 'Confirmar e Pagar'; // Reset button text
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Ocorreu um erro de rede. Por favor, tente novamente.');
                        confirmBookingBtn.disabled = false; // Re-enable button
                        confirmBookingBtn.textContent = 'Confirmar e Pagar'; // Reset button text
                    });
            });
        });
    </script>
</x-app-layout>
