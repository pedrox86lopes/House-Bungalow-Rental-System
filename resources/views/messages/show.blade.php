<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Mensagem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Assunto: {{ $message->subject ?? 'Sem Assunto' }}</h3>

                    <div class="mb-4 text-gray-700 dark:text-gray-300">
                        <p><strong>De:</strong> {{ $message->sender->name }}</p>
                        <p><strong>Recebido Em:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>
                        @if ($message->read_at)
                            <p><strong>Lido Em:</strong> {{ $message->read_at->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="text-blue-600 dark:text-blue-400"><strong>Não Lido</strong></p>
                        @endif
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md shadow-inner mb-6">
                        <p class="whitespace-pre-wrap text-gray-800 dark:text-gray-200">{{ $message->body }}</p>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Voltar para a Caixa de Entrada
                        </a>
                        @if ($message->receiver_id === Auth::id())
                            <a href="{{ route('messages.create', ['receiver' => $message->sender->id, 'subject' => 'RE: ' . $message->subject]) }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Responder
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
