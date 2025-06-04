<x-app-layout>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-20 text-white text-center mb-10 rounded-lg shadow-lg overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/clean-textile.png');"></div>
        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-5xl font-extrabold mb-4 drop-shadow-2xl">Gerir Bungalows</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">Adicionar, editar ou remover propriedades do seu sistema.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sucesso!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.remove();"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.remove();"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.bungalows.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
                <span data-lucide="plus-circle" class="w-5 h-5 mr-2"></span> Adicionar Novo Bungalow
            </a>
        </div>

        @forelse ($bungalows as $bungalow)
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex flex-col md:flex-row items-center md:items-start gap-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex-shrink-0">
                    <img src="{{ asset($bungalow->image_url ? '' . $bungalow->image_url : 'https://placehold.co/200x150/E0E0E0/333333?text=Bungalow') }}"
                         alt="{{ $bungalow->name }}"
                         class="w-48 h-36 object-cover rounded-lg shadow">
                </div>
                <div class="flex-grow text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $bungalow->name }}</h3>
                    <p class="text-gray-700 text-lg mb-1">
                        <span class="font-semibold">Descrição:</span> {{ Str::limit($bungalow->description, 100) }}
                    </p>
                    <p class="text-gray-700 text-lg mb-1">
                        <span class="font-semibold">Preço por Noite:</span> <span class="text-green-600 font-bold">€{{ number_format($bungalow->price_per_night, 2, ',', '.') }}</span>
                    </p>
                    <p class="text-gray-700 text-lg">
                        <span class="font-semibold">Criado em:</span> {{ \Carbon\Carbon::parse($bungalow->created_at)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="flex-shrink-0 mt-4 md:mt-0 flex flex-col gap-2">
                    <a href="{{ route('bungalows.show', $bungalow->id) }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center transition duration-200 shadow-sm">
                        <span data-lucide="eye" class="w-4 h-4 mr-2"></span> Ver Detalhes
                    </a>
                    {{-- UNCOMMENT AND USE THIS EDIT BUTTON --}}
                    <a href="{{ route('admin.bungalows.edit', $bungalow->id) }}" class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 flex items-center justify-center transition duration-200 shadow-sm">
                        <span data-lucide="edit" class="w-4 h-4 mr-2"></span> Editar
                    </a>
                    <form action="{{ route('admin.bungalows.destroy', $bungalow->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este bungalow? Esta ação não pode ser desfeita.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center justify-center transition duration-200 shadow-sm">
                            <span data-lucide="trash-2" class="w-4 h-4 mr-2"></span> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-8 rounded-lg text-center mt-12 shadow-md" role="alert">
                <div class="flex flex-col items-center justify-center">
                    <span class="text-blue-500 mb-4" data-lucide="info" style="width: 48px; height: 48px;"></span>
                    <p class="text-xl font-semibold mb-2">Nenhum bungalow encontrado.</p>
                    <p class="text-lg">Comece por adicionar um novo bungalow para gerir.</p>
                    <a href="{{ route('admin.bungalows.create') }}" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                        Adicionar Primeiro Bungalow
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
