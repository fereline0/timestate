<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Электронная почта')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <x-checkbox id="remember_me" name="remember" label="{{ __('Запомнить меня') }}" />
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <x-link href="{{ route('register') }}">{{ __('Нет аккаунта?') }}</x-link>

            <x-link href="{{ route('password.request') }}">
                {{ __('Забыли пароль?') }}
            </x-link>

            <x-primary-button class="ms-3">
                {{ __('Войти') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
