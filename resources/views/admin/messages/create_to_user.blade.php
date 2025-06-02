<x-app-layout>
    {{-- Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-20 text-white text-center mb-10 rounded-lg shadow-lg overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/clean-textile.png');"></div>
        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-5xl font-extrabold mb-4 drop-shadow-2xl">Enviar Mensagem</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90">Envie uma mensagem para {{ $user->name }}.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        {{-- Sidebar Navigation (same as admin dashboard) --}}
        <aside class="md:col-span-1 bg-white p-6 rounded-lg shadow-xl h-fit sticky top-8">
            <nav>
                <h3 class="text-xl font-bold text-gray-800 mb-5">Navegação</h3>
                <ul>
                    <li class="mb-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="book-check" class="w-5 h-5 mr-3"></span>
                            Reservas
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('admin.bungalows.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="home" class="w-5 h-5 mr-3"></span>
                            Bungalows
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center text-blue-600 font-bold py-2 px-3 rounded-lg bg-blue-50 transition duration-200">
                            <span data-lucide="users" class="w-5 h-5 mr-3"></span>
                            Utilizadores
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('admin.messages.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="messages-square" class="w-5 h-5 mr-3"></span>
                            Mensagens
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('contact.admin.create') }}" class="flex items-center text-gray-700 hover:text-blue-600 font-medium py-2 px-3 rounded-lg hover:bg-blue-50 transition duration-200">
                            <span data-lucide="mail" class="w-5 h-5 mr-3"></span>
                            Enviar Mensagem ao Admin
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content Area --}}
        <main class="md:col-span-3">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-8 border-b pb-4">Enviar Mensagem para {{ $user->name }}</h2>

            <div class="bg-white rounded-xl shadow-md p-6">
                <form action="{{ route('admin.users.message.send', $user->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="recipient_name" class="block text-gray-700 text-sm font-bold mb-2">Destinatário:</label>
                        <input type="text" id="recipient_name" name="recipient_name" value="{{ $user->name }} ({{ $user->email }})"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-100 cursor-not-allowed"
                               readonly>
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Assunto:</label>
                        <input type="text" id="subject" name="subject"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('subject') border-red-500 @enderror"
                               value="{{ old('subject') }}" required autofocus>
                        @error('subject')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Mensagem:</label>
                        <textarea id="body" name="body" rows="8"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('body') border-red-500 @enderror"
                                  required>{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                            <span data-lucide="send" class="w-5 h-5 mr-2"></span> Enviar Mensagem
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
