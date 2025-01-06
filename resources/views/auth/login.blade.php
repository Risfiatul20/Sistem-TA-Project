<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Sistem Informasi Tugas Akhir
                </h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input 
                        id="email" 
                        class="mt-1 block w-full rounded-md shadow-sm 
                               border-gray-300 dark:border-gray-700 
                               dark:bg-gray-900 dark:text-gray-300 
                               focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="Masukkan email anda"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input 
                        id="password" 
                        class="mt-1 block w-full rounded-md shadow-sm 
                               border-gray-300 dark:border-gray-700 
                               dark:bg-gray-900 dark:text-gray-300 
                               focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="Masukkan password anda"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded dark:bg-gray-900 
                                   border-gray-300 dark:border-gray-700 
                                   text-indigo-600 shadow-sm 
                                   focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                   dark:focus:ring-offset-gray-800" 
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Ingat saya') }}
                        </span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200"
                        >
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Masuk') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum punya akun? 
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">
                        Daftar disini
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-4 text-center text-xs text-gray-500 dark:text-gray-400">
            © {{ date('Y') }} Sistem Informasi Tugas Akhir. All rights reserved.
        </div>
    </div>
</x-guest-layout>