<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="tw-w-20 tw-h-20 tw-fill-current tw-text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="tw-block tw-mt-1 tw-w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="tw-mt-2" />
            </div>

            <!-- Email Address -->
            <div class="tw-mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="tw-block tw-mt-1 tw-w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="tw-mt-2" />
            </div>

            <!-- Password -->
            <div class="tw-mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="tw-mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="tw-mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="tw-block tw-mt-1 tw-w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="tw-mt-2" />
            </div>

            <div class="tw-mt-4">
                <label class="tw-block tw-mb-2 tw-text-sm tw-font-medium tw-text-gray-900 dark:tw-text-gray-300">Role user</label>
                <select class="tw-block tw-mt-1 tw-w-full tw-border-gray-300 focus:tw-border-indigo-300 focus:tw-ring-indigo-200 focus:tw-ring-opacity-50 tw-rounded-md tw-shadow-sm dark:tw-text-gray-400 dark:hover:tw-text-gray-100 dark:focus:tw-ring-offset-gray-800 dark:tw-border-gray-700 dark:tw-bg-gray-900 dark:focus:tw-border-indigo-600 dark:tw-focus:ring-indigo-600" name="role_id">
                    <option value="developer">Developer</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                <a class="tw-underline tw-text-sm tw-text-gray-600 dark:tw-text-gray-400 hover:tw-text-gray-900 dark:hover:tw-text-gray-100 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500 dark:focus:tw-ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="tw-ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
