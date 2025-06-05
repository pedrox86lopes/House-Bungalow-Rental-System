<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard do Utilizador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Welcome Message --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Olá, {{ Auth::user()->name }}! Bem-vindo(a) ao seu Dashboard.
                </div>
            </div>

            {{-- COMMON SUCCESS/ERROR MESSAGE DISPLAY --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Admin Messages Section (Visible only to the specific admin email) --}}
            @if(Auth::user()->email === config('app.admin_email'))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-4 flex items-center">
                            <svg class="h-8 w-8 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-1 10a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h12a2 2 0 012 2v10z" />
                            </svg>
                            Mensagens Recebidas (Administrador)
                            @php
                                $unreadAdminMessagesCount = $adminMessages->whereNull('read_at')->count();
                            @endphp
                            @if($unreadAdminMessagesCount > 0)
                                <span class="ml-2 px-3 py-1 text-sm font-semibold rounded-full bg-red-500 text-white dark:bg-red-700">
                                    {{ $unreadAdminMessagesCount }} não lida{{ $unreadAdminMessagesCount > 1 ? 's' : '' }}
                                </span>
                            @endif
                        </h3>

                        @if ($adminMessages->isEmpty())
                            <p class="text-gray-600 dark:text-gray-400">Não há mensagens recebidas para o administrador.</p>
                        @else
                            <div class="overflow-x-auto mb-4">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                De
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Assunto
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Recebido Em
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Ver</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($adminMessages->take(5) as $message) {{-- Show more admin messages if desired --}}
                                            <tr class="{{ is_null($message->read_at) ? 'font-bold bg-blue-50 dark:bg-blue-900/20' : 'text-gray-600 dark:text-gray-300' }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ $message->sender->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ Str::limit($message->subject ?? 'Sem Assunto', 40) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('messages.show', $message->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Ver Mensagem</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ver Todas as Mensagens do Administrador
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- User Messages Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4 flex items-center">
                        <svg class="h-8 w-8 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-1 10a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h12a2 2 0 012 2v10z" />
                        </svg>
                        Minhas Mensagens
                        @if($unreadMessagesCount > 0)
                            <span class="ml-2 px-3 py-1 text-sm font-semibold rounded-full bg-red-500 text-white dark:bg-red-700">
                                {{ $unreadMessagesCount }} não lida{{ $unreadMessagesCount > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </h3>

                    @if ($receivedMessages->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Você não tem mensagens.</p>
                    @else
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            De
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Assunto
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Recebido Em
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Ver</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {{-- Display up to 3 latest messages directly on the dashboard --}}
                                    @foreach ($receivedMessages->take(3) as $message)
                                        <tr class="{{ is_null($message->read_at) ? 'font-bold bg-blue-50 dark:bg-blue-900/20' : 'text-gray-600 dark:text-gray-300' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $message->sender->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ Str::limit($message->subject ?? 'Sem Assunto', 40) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('messages.show', $message->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Ver Mensagem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Ver Todas as Mensagens
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- User Reservations Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Minhas Reservas</h3>

                    @if ($userBookings->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Ainda não tem reservas. Que tal explorar os nossos <a href="{{ route('bungalows.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 underline">bungalows</a>?</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Bungalow
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Check-in
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Check-out
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Noites
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Preço Total
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Detalhes</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($userBookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $booking->bungalow->name ?? 'Bungalow Removido' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $booking->number_of_nights }} {{-- Using the accessor --}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                €{{ number_format($booking->total_amount, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $statusClass = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                        'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                    ][$booking->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('bungalows.show', $booking->bungalow_id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-4">Ver Bungalow</a>
                                                @if ($booking->status === 'paid')
                                                    <a href="{{ route('bookings.invoice.download', $booking) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200">Download Fatura</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Send Message to Admin Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Enviar Mensagem ao Gestor das Reservas</h3>

                    <form action="{{ route('contact.admin') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assunto:</label>
                            <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('subject') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mensagem:</label>
                            <textarea name="message" id="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
