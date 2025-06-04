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
            <h1 class="text-5xl font-extrabold mb-4 drop-shadow-2xl">Editar Bungalow</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">Atualize os detalhes da propriedade.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-3xl mx-auto">
            <a href="{{ route('admin.bungalows.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
                <span data-lucide="arrow-left" class="w-5 h-5 mr-2"></span> Voltar à Gestão de Bungalows
            </a>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Há alguns problemas com a sua entrada.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.bungalows.update', $bungalow->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- This tells Laravel to treat this as a PUT request for updates --}}

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-base font-semibold mb-2">Nome do Bungalow</label>
                    <input type="text"
                           class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           id="name"
                           name="name"
                           value="{{ old('name', $bungalow->name) }}" {{-- Pre-fill with existing data --}}
                           required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 text-base font-semibold mb-2">Descrição</label>
                    <textarea class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                              id="description"
                              name="description"
                              rows="6"
                              required>{{ old('description', $bungalow->description) }}</textarea> {{-- Pre-fill with existing data --}}
                </div>

                <div class="mb-6">
                    <label for="price_per_night" class="block text-gray-700 text-base font-semibold mb-2">Preço por Noite (€)</label>
                    <input type="number"
                           class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           id="price_per_night"
                           name="price_per_night"
                           value="{{ old('price_per_night', $bungalow->price_per_night) }}" {{-- Pre-fill with existing data --}}
                           step="0.01"
                           min="0"
                           required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="bedrooms" class="block text-gray-700 text-base font-semibold mb-2">Número de Quartos</label>
                        <input type="number"
                               class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               id="bedrooms"
                               name="bedrooms"
                               value="{{ old('bedrooms', $bungalow->bedrooms) }}" {{-- Pre-fill with existing data --}}
                               min="0"
                               required>
                    </div>
                    <div>
                        <label for="beds" class="block text-gray-700 text-base font-semibold mb-2">Número de Camas</label>
                        <input type="number"
                               class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               id="beds"
                               name="beds"
                               value="{{ old('beds', $bungalow->beds) }}" {{-- Pre-fill with existing data --}}
                               min="0"
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="bathrooms" class="block text-gray-700 text-base font-semibold mb-2">Número de Casas de Banho</label>
                        <input type="number"
                               class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               id="bathrooms"
                               name="bathrooms"
                               value="{{ old('bathrooms', $bungalow->bathrooms) }}" {{-- Pre-fill with existing data --}}
                               step="0.5"
                               min="0"
                               required>
                    </div>
                    <div>
                        <label for="accommodates" class="block text-gray-700 text-base font-semibold mb-2">Acomoda (Pessoas)</label>
                        <input type="number"
                               class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               id="accommodates"
                               name="accommodates"
                               value="{{ old('accommodates', $bungalow->accommodates) }}" {{-- Pre-fill with existing data --}}
                               min="1"
                               required>
                    </div>
                </div>

                <div class="mb-8">
                    <label for="image" class="block text-gray-700 text-base font-semibold mb-2">Imagem do Bungalow (Opcional)</label>
                    <input type="file"
                           class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100"
                           id="image"
                           name="image"
                           accept="image/*">
                    <p class="text-gray-500 text-xs mt-1">PNG, JPG, GIF até 2MB.</p>

                    @if ($bungalow->image_url)
                        <div class="mt-4">
                            <p class="text-gray-700 text-sm mb-2">Imagem atual:</p>
                            <img src="{{ asset('' . $bungalow->image_url) }}" alt="Current Bungalow Image" class="w-48 h-auto object-cover rounded-lg shadow">
                        </div>
                    @endif
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Atualizar Bungalow
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
