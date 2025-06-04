<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        {{-- Logo and Welcome Section --}}
        <div class="text-center mb-8 px-4">
            <a href="/">
                {{-- Replace with your actual logo component or image --}}
            </a>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-3 tracking-tight">Bem-vindo(a) ao BungalowBooker!</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-md mx-auto">
                Crie sua conta hoje mesmo e descubra uma vasta seleção de bungalows incríveis para sua próxima escapada.
            </p>
        </div>

        {{-- Registration Form Card --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-10 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg transform transition duration-300 hover:scale-105">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name Input --}}
                <div class="mb-5">
                    <x-input-label for="name" :value="__('Nome Completo')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <x-text-input id="name" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Seu nome completo" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
                </div>

                {{-- Email Input --}}
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Endereço de E-mail')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <x-text-input id="email" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu.email@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
                </div>

                {{-- Password Input --}}
                <div class="mb-5">
                    <x-input-label for="password" :value="__('Senha')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <x-text-input id="password" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo de 8 caracteres" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
                </div>

                {{-- Confirm Password Input --}}
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                    <x-text-input id="password_confirmation" class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirme sua senha" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 dark:text-red-400 text-sm" />
                </div>

                {{-- Register Button and Login Link --}}
                <div class="flex flex-col items-center justify-center mt-6 space-y-4">
                    <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 border-0 rounded-md shadow-lg text-white font-semibold text-lg transition duration-200 ease-in-out transform hover:-translate-y-0.5 hover:shadow-xl focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Criar Conta') }}
                    </x-primary-button>
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out" href="{{ route('login') }}">
                        {{ __('Já possui uma conta? Faça login aqui!') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
