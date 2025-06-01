<x-app-layout>
{{-- Hero Section for Booking Page --}}
<div class="relative bg-cover bg-center py-20 text-white text-center mb-10 rounded-lg shadow-lg"
    style="background-image: url('https://images.unsplash.com/photo-1570129476816-c0c1692e850b?auto=format&fit=crop&q=80&w=1974&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
    {{-- Overlay for better text readability --}}
    <div class="absolute inset-0 bg-black opacity-60 rounded-lg"></div>
    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">Reservar {{ $bungalow->name }}</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Garanta a sua estadia neste refúgio perfeito. Preencha os detalhes da reserva abaixo.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detalhes da Propriedade</h2>

        <div class="mb-8 border-b pb-6 border-gray-200">
            <p class="text-gray-700 text-lg mb-2">
                <span class="font-semibold text-gray-900">Descrição:</span> {{ $bungalow->description }}
            </p>
            <p class="text-gray-700 text-lg">
                <span class="font-semibold text-gray-900">Preço por noite:</span>
                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded-full text-xl font-bold ml-2">€{{ $bungalow->price_per_night }}</span>
            </p>
            {{-- Optional: Display bungalow image if available --}}
            @if($bungalow->image_url)
                <div class="mt-6">
                    <img src="{{ asset($bungalow->image_url) }}" alt="{{ $bungalow->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
            @endif
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Informações da Reserva</h2>

        <form id="bookingForm">
            @csrf

            <input type="hidden" name="bungalow_id" value="{{ $bungalow->id }}">
            <input type="hidden" id="price_per_night" value="{{ $bungalow->price_per_night }}">

            <div class="mb-6">
                <label for="start_date" class="block text-gray-700 text-base font-semibold mb-2">Data de Início</label>
                <input type="date"
                       class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out"
                       id="start_date"
                       name="start_date"
                       required>
            </div>

            <div class="mb-8">
                <label for="end_date" class="block text-gray-700 text-base font-semibold mb-2">Data de Fim</label>
                <input type="date"
                       class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out"
                       id="end_date"
                       name="end_date"
                       required>
            </div>

            {{-- Dynamic Price Invoice Section --}}
            <div id="priceSummary" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 shadow-inner">
                <h3 class="text-xl font-bold text-blue-800 mb-4">Resumo da Reserva</h3>
                <div class="flex justify-between items-center text-lg mb-2">
                    <span class="text-gray-700">Noites:</span>
                    <span id="numNights" class="font-semibold text-gray-900">0</span>
                </div>
                <div class="flex justify-between items-center text-lg mb-4">
                    <span class="text-gray-700">Preço por noite:</span>
                    <span class="font-semibold text-gray-900">€{{ $bungalow->price_per_night }}</span>
                </div>
                <div class="border-t border-blue-300 pt-4 mt-4 flex justify-between items-center text-2xl font-bold text-blue-700">
                    <span>Total a Pagar:</span>
                    <span id="totalPrice">€0.00</span>
                </div>
            </div>

            {{-- Message Box for user feedback --}}
            <div id="messageBox" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="messageText" class="block sm:inline"></span>
            </div>

            <div class="flex justify-center">
                <button type="submit" id="confirmBookingBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Confirmar Reserva
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const pricePerNight = parseFloat(document.getElementById('price_per_night').value);
        const priceSummary = document.getElementById('priceSummary');
        const numNightsSpan = document.getElementById('numNights');
        const totalPriceSpan = document.getElementById('totalPrice');
        const bookingForm = document.getElementById('bookingForm');
        const confirmBookingBtn = document.getElementById('confirmBookingBtn');
        const messageBox = document.getElementById('messageBox');
        const messageText = document.getElementById('messageText');

        // Function to show messages
        function showMessage(message, type = 'error') {
            messageBox.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700', 'bg-green-100', 'border-green-400', 'text-green-700');
            if (type === 'error') {
                messageBox.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
            } else {
                messageBox.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
            }
            messageText.textContent = message;
            messageBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Function to hide messages
        function hideMessage() {
            messageBox.classList.add('hidden');
        }

        function calculateTotalPrice() {
            hideMessage(); // Hide any previous messages

            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            // Set min date for end_date to be start_date + 1 day
            if (startDateInput.value) {
                const minEndDate = new Date(startDate);
                minEndDate.setDate(startDate.getDate() + 1);
                endDateInput.min = minEndDate.toISOString().split('T')[0];
            } else {
                endDateInput.min = ''; // No min date if start date is not set
            }

            // Ensure start_date is not in the past
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to compare dates only
            if (startDate < today && startDateInput.value) {
                showMessage('A data de início não pode ser no passado.', 'error');
                priceSummary.classList.add('hidden');
                return;
            }

            if (startDateInput.value && endDateInput.value) {
                if (endDate <= startDate) {
                    showMessage('A data de fim deve ser posterior à data de início.', 'error');
                    priceSummary.classList.add('hidden');
                    return;
                }

                const timeDiff = endDate.getTime() - startDate.getTime();
                const numNights = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Calculate full nights

                if (numNights > 0) {
                    const total = numNights * pricePerNight;
                    numNightsSpan.textContent = numNights;
                    totalPriceSpan.textContent = `€${total.toFixed(2)}`;
                    priceSummary.classList.remove('hidden');
                } else {
                    priceSummary.classList.add('hidden');
                }
            } else {
                priceSummary.classList.add('hidden');
            }
        }

        // Add event listeners to date inputs
        startDateInput.addEventListener('change', calculateTotalPrice);
        endDateInput.addEventListener('change', calculateTotalPrice);

        // Set min date for start_date to today
        const today = new Date();
        startDateInput.min = today.toISOString().split('T')[0];

        // Handle form submission via AJAX
        bookingForm.addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent default form submission

            // Basic client-side validation
            if (!startDateInput.value || !endDateInput.value) {
                showMessage('Por favor, selecione as datas de início e fim.', 'error');
                return;
            }
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (endDate <= startDate) {
                showMessage('A data de fim deve ser posterior à data de início.', 'error');
                return;
            }
            const todayDateOnly = new Date();
            todayDateOnly.setHours(0,0,0,0);
            if (startDate < todayDateOnly) {
                showMessage('A data de início não pode ser no passado.', 'error');
                return;
            }

            confirmBookingBtn.disabled = true;
            confirmBookingBtn.textContent = 'A processar...';
            confirmBookingBtn.classList.add('opacity-50', 'cursor-not-allowed');
            hideMessage(); // Hide any previous messages

            try {
                const response = await fetch('{{ route('booking.confirm_and_pay') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        bungalow_id: document.querySelector('input[name="bungalow_id"]').value,
                        start_date: startDateInput.value,
                        end_date: endDateInput.value,
                        total_price: parseFloat(totalPriceSpan.textContent.replace('€', '')) // Send calculated total
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.redirect_url) {
                        showMessage('Reserva criada com sucesso! Redirecionando para o PayPal...', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect_url; // Redirect to PayPal
                        }, 1500); // Give user a moment to see the success message
                    } else {
                        showMessage('Erro: URL de redirecionamento do PayPal não recebida.', 'error');
                    }
                } else {
                    // Handle validation errors or other server-side errors
                    const errorMessage = data.message || 'Ocorreu um erro ao processar a sua reserva.';
                    showMessage(errorMessage, 'error');
                    if (data.errors) {
                        // You can iterate through data.errors and display them next to fields
                        console.error('Validation Errors:', data.errors);
                    }
                }
            } catch (error) {
                console.error('Erro na requisição AJAX:', error);
                showMessage('Ocorreu um erro de rede. Por favor, tente novamente.', 'error');
            } finally {
                confirmBookingBtn.disabled = false;
                confirmBookingBtn.textContent = 'Confirmar Reserva';
                confirmBookingBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    });
</script>
</x-app-layout>
