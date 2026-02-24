<header class="bg-primary-50/80 backdrop-blur-md shadow-sm border-b border-primary-200 h-20 flex items-center justify-between px-8 sticky top-0 z-20">
    <!-- Left side -->
    <div class="flex items-center">
        <h2 class="text-xl font-black text-primary-800">
            @yield('header', 'Dashboard')
        </h2>
    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-6">
        <!-- Notifications -->
        <button class="relative p-2 text-primary-700 hover:text-primary-600 transition-colors rounded-full hover:bg-primary-50">
            <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 border-2 border-white"></span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </button>

        <!-- User Profile -->
        @auth
            <div class="flex items-center space-x-3 border-l border-primary-200 pl-6">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-primary-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-primary-500 font-medium uppercase tracking-wider">Administrador</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-black border border-primary-200 shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        @endauth
    </div>
</header>