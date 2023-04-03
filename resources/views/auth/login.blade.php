<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="tw-block tw-mt-1 tw-w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="tw-mt-2" />
            </div>

            <!-- Password -->
            <div class="tw-mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="tw-mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="tw-block tw-mt-4">
                <label for="remember_me" class="tw-inline-flex tw-items-center">
                    <input id="remember_me" type="checkbox" class="tw-rounded dark:tw-bg-gray-900 tw-border-gray-300 dark:tw-border-gray-700 tw-text-indigo-600 tw-shadow-sm focus:tw-ring-indigo-500 dark:focus:tw-ring-indigo-600 dark:focus:tw-ring-offset-gray-800" name="remember">
                    <span class="tw-ml-2 tw-text-sm tw-text-gray-600 dark:tw-text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                @if (Route::has('password.request'))
                    <a class="tw-underline tw-text-sm tw-text-gray-600 dark:tw-text-gray-400 hover:tw-text-gray-900 dark:hover:tw-text-gray-100 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500 dark:focus:tw-ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="tw-ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
