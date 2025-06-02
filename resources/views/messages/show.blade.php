<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes da Mensagem') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-64px)]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 sm:p-8">

                {{-- Message Header & Subject --}}
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-2 leading-tight">
                        Assunto: {{ $message->subject ?? 'Sem Assunto' }}
                    </h3>
                    <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400">
                        De: <span class="font-bold">{{ $message->sender->name }}</span>
                        para <span class="font-bold">{{ $message->receiver->name }}</span>
                    </p>
                </div>

                {{-- Message Bubble --}}
                <div class="flex items-start gap-4 mb-8">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-600 dark:bg-blue-500 flex items-center justify-center text-white font-bold text-lg sm:text-xl ring-2 ring-blue-300 dark:ring-blue-700">
                            {{ Str::upper(substr($message->sender->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0"> {{-- Added min-w-0 to prevent overflow --}}
                        <div class="bg-blue-50 dark:bg-gray-700 p-4 sm:p-5 rounded-xl shadow-sm border border-blue-100 dark:border-gray-600 max-w-full overflow-hidden">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-3">
                                <p class="font-semibold text-lg sm:text-xl text-gray-900 dark:text-gray-100 mb-1 sm:mb-0 truncate">{{ $message->sender->name }}</p>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                    @if ($message->read_at)
                                        <span class="ml-2 text-green-600 dark:text-green-400 font-medium" title="Lido">✓</span>
                                    @else
                                        <span class="ml-2 text-blue-600 dark:text-blue-400 font-medium" title="Não Lido">●</span>
                                    @endif
                                </p>
                            </div>
                            {{-- Improved message body container with scrolling for very long content --}}
                            <div class="max-h-[60vh] overflow-y-auto"> {{-- Added max height and scroll for very long messages --}}
                                <pre class="whitespace-pre-wrap font-sans text-gray-800 dark:text-gray-200 leading-relaxed text-base break-words overflow-x-auto">{{ $message->body }}</pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end sm:justify-between items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('messages.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 rounded-full shadow-sm text-sm sm:text-base font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                        Voltar para a Caixa de Entrada
                    </a>
                    @if ($message->receiver_id === Auth::id())
                        <a href="{{ route('messages.create', ['receiver' => $message->sender->id, 'subject' => 'RE: ' . $message->subject]) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-transparent rounded-full shadow-sm text-sm sm:text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            Responder
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
