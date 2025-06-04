<x-app-layout>
    {{-- Lucide Icons CDN for the info icon in the empty state and other icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-20 text-white text-center mb-10 rounded-lg shadow-lg overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/clean-textile.png');"></div>
        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-5xl font-extrabold mb-4 drop-shadow-2xl">Painel de Administração</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">Gestão abrangente de reservas e propriedades.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-4 gap-8">

        {{-- Sidebar Navigation --}}
        <aside class="md:col-span-1 bg-white p-6 rounded-lg shadow-xl h-fit sticky top-8">
            <nav>
                <h3 class="text-xl font-bold text-gray-800 mb-5">Navegação</h3>
                <ul>
                    <li class="mb-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-blue-600 font-bold py-2 px-3 rounded-lg bg-blue-50 transition duration-200">
                            <span data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></span>
                            Dashboard
                        </a>
                    </li>
                    {{-- New Bungalow Management Link --}}
                    <li class="mb-3">
                        <a href="{{ route('admin.bungalows.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="home" class="w-5 h-5 mr-3"></span>
                            Gerir Bungalows
                        </a>
                    </li>
                    <li class="mb-3">
                        {{-- Linking to user's general message inbox --}}
                        <a href="{{ route('messages.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="messages-square" class="w-5 h-5 mr-3"></span>
                            Minhas Mensagens
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content Area --}}
        <main class="md:col-span-3">
            {{-- Dashboard Overview (Example Data - Replace with actual counts from AdminController) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Total de Reservas</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBookings ?? 0 }}</p>
                    </div>
                    <span data-lucide="calendar-check" class="text-blue-500 w-10 h-10"></span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Bungalows Ativos</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeBungalows ?? 0 }}</p>
                    </div>
                    <span data-lucide="home" class="text-green-500 w-10 h-10"></span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-semibold">Utilizadores Registados</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <span data-lucide="users" class="text-purple-500 w-10 h-10"></span>
                </div>
            </div>

            <hr class="my-10 border-gray-300">

            {{-- Reservations Grouped by Status --}}
            @php
                $allBookingsGrouped = [
                    'paid' => $paidBookings,
                    'pending' => $pendingBookings,
                    'cancelled' => $cancelledBookings,
                ];
            @endphp

            @foreach ($allBookingsGrouped as $statusKey => $statusBookings)
                <div class="mb-12">
                    <h2 class="text-4xl font-extrabold text-gray-800 mb-8 border-b pb-4">
                        @if ($statusKey === 'paid')
                            Reservas Pagas
                        @elseif ($statusKey === 'pending')
                            Reservas Pendentes
                        @else
                            Reservas Canceladas
                        @endif
                        <span class="text-gray-500 text-2xl ml-2">({{ $statusBookings->count() }})</span>
                    </h2>

                    @forelse ($statusBookings as $booking)
                        <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col md:flex-row items-center md:items-start gap-6 hover:shadow-lg transition-shadow duration-200">
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
                                    <span class="font-semibold">Email:</span> {{ $booking->user->email ?? 'N/A' }}
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
                            <div class="flex-shrink-0 mt-4 md:mt-0 flex flex-col gap-2">
                                <a href="{{ route('bungalows.show', $booking->bungalow->id) }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center transition duration-200 shadow-sm">
                                    <span data-lucide="eye" class="w-4 h-4 mr-2"></span> Ver Bungalow
                                </a>
                            </div>
                        </div>
                    @empty
                        {{-- Empty state for each specific status --}}
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-8 rounded-lg text-center mt-12 shadow-md" role="alert">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-blue-500 mb-4" data-lucide="info" style="width: 48px; height: 48px;"></span>
                                <p class="text-xl font-semibold mb-2">
                                    @if ($statusKey === 'paid')
                                        Nenhuma reserva paga encontrada.
                                    @elseif ($statusKey === 'pending')
                                        Nenhuma reserva pendente encontrada.
                                    @else
                                        Nenhuma reserva cancelada encontrada.
                                    @endif
                                </p>
                                <p class="text-lg">Não há reservas {{ $statusKey === 'paid' ? 'pagas' : ($statusKey === 'pending' ? 'pendentes' : 'canceladas') }} no momento.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endforeach

            {{-- Overall empty state (only if ALL categories are empty) --}}
            @if ($paidBookings->isEmpty() && $pendingBookings->isEmpty() && $cancelledBookings->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-8 rounded-lg text-center mt-12 shadow-md" role="alert">
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-blue-500 mb-4" data-lucide="info" style="width: 48px; height: 48px;"></span>
                        <p class="text-xl font-semibold mb-2">Nenhuma reserva encontrada.</p>
                        <p class="text-lg">Ainda não há reservas de qualquer tipo no sistema.</p>
                    </div>
                </div>
            @endif

            {{-- Pagination commented out as the list might not be paginated without a dedicated admin route --}}
            {{-- <div class="mt-8">
                {{ $bookings->links() }}
            </div> --}}
        </main>
    </div>
</x-app-layout>
