<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
        {{-- Logo and Welcome Section --}}
        <div class="text-center mb-8">
            <a href="/">
                <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2484/2484119.png') }}" alt="My Company Logo" class="w-32 h-32 mx-auto mb-4 object-contain">
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Bem-vindo(a)!</h2>
            <p class="text-gray-600 dark:text-gray-300">Crie sua conta para começar a reservar bungalows incríveis.</p>
        </div>

        {{-- Registration Form Card --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name Input --}}
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nome')" class="block font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 dark:text-red-400" />
                </div>

                {{-- Email Input --}}
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="block font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 dark:text-red-400" />
                </div>

                {{-- Password Input --}}
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Senha')" class="block font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 dark:text-red-400" />
                </div>

                {{-- Confirm Password Input --}}
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="block font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 dark:text-red-400" />
                </div>

                {{-- Register Button and Login Link --}}
                <div class="flex items-center justify-between mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Já possui uma conta?') }}
                    </a>
                    <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 border-0 rounded-md shadow-sm focus:ring-indigo-500">
                        {{ __('Registar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
