<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>

        <div class="flex flex-col gap-3 mt-1">
            <!-- Botón Google -->
            <a
                href="/google-auth/redirect"
                class="flex items-center justify-center gap-2 px-5 py-2 
                    border rounded-md shadow-sm text-sm font-medium 
                    bg-white text-gray-700 border-gray-300 
                    hover:bg-gray-50 hover:shadow-md transition duration-200"
            >
                <!-- Icono de Google (optimizado) -->
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 533.5 544.3">
                    <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34.1-4.6-50.4H272v95.3h147c-6.4 34.6-25.4 63.9-54.2 83.4l87.6 68.2c51.2-47.2 81.1-116.7 81.1-196.5z"/>
                    <path fill="#34A853" d="M272 544.3c73.7 0 135.4-24.3 180.6-66.2l-87.6-68.2c-24.4 16.5-55.7 26.1-93 26.1-71.5 0-132-48.2-153.5-112.7l-90.5 70c46 90.9 141.3 150.9 243.9 150.9z"/>
                    <path fill="#FBBC05" d="M118.5 323.3c-10.8-32.5-10.8-67.6 0-100.1l-90.5-70C4.6 197.6 0 237.8 0 278.4s4.6 80.8 28 125.2l90.5-70z"/>
                    <path fill="#EA4335" d="M272 107.7c39.9 0 75.7 13.8 103.9 40.8l77.8-77.8C407.4 24.3 345.7 0 272 0 169.4 0 74.1 60 28 150.9l90.5 70C140 155.9 200.5 107.7 272 107.7z"/>
                </svg>
                <span>Continuar con Google</span>
            </a>

            <!-- Botón Facebook -->
            <a
                href="/facebook-auth/redirect"
                class="flex items-center justify-center gap-2 px-5 py-2 
                    border rounded-md shadow-sm text-sm font-medium 
                    bg-[#1877F2] text-white border-transparent 
                    hover:bg-[#166FE5] hover:shadow-md transition duration-200"
            >
                <!-- Icono de Facebook -->
                <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                    <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325V22.68c0 .73.6 1.32 1.325 1.32H12.82V14.7h-3.1v-3.62h3.1V8.41c0-3.07 1.87-4.74 4.6-4.74 1.31 0 2.43.1 2.76.14v3.2l-1.9.001c-1.5 0-1.79.72-1.79 1.76v2.31h3.57l-.46 3.62h-3.11V24h6.1c.72 0 1.32-.59 1.32-1.32V1.32C24 .6 23.4 0 22.675 0z"/>
                </svg>
                <span>Continuar con Facebook</span>
            </a>
        </div>

    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
