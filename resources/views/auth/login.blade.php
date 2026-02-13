<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black text-slate-900">Bienvenido</h2>
        <p class="text-slate-500 font-medium mt-2">Accede a tu cuenta de FishPot</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-primary-600 shadow-sm focus:ring-primary-500" name="remember">
                <span class="ms-2 text-sm text-slate-500 font-bold uppercase tracking-widest">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <x-primary-button>
                {{ __('Entrar') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
            @if (Route::has('password.request'))
                <a class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-primary-600 transition" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <a class="text-xs font-black uppercase tracking-widest text-primary-600 hover:text-primary-700 transition" href="{{ route('register') }}">
                {{ __('Crear cuenta') }}
            </a>
        </div>
    </form>
</x-guest-layout>
