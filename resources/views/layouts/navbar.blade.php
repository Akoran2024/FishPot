<header class="bg-white/90 backdrop-blur-md shadow-sm border-b border-nautical-200 h-20 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-20">
    <!-- Left side -->
    <div class="flex items-center min-w-0">
        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="mr-2 sm:mr-4 p-2 text-nautical-600 lg:hidden focus:outline-none flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <h2 class="text-base sm:text-xl font-serif font-black text-primary-950 italic truncate">
            @yield('header', 'Mesa de Trabajo')
            <span class="ml-2 px-1.5 py-0.5 bg-primary-100 text-primary-800 text-[8px] sm:text-[10px] border border-primary-200 rounded font-bold tracking-widest uppercase not-italic inline-block align-middle">Capitán</span>
        </h2>
    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-2 sm:space-x-6 flex-shrink-0">
        <!-- Notifications -->
        <button class="relative p-2 text-nautical-400 hover:text-primary-800 transition-all rounded-lg hover:bg-nautical-50 group hidden sm:block">
            <span class="absolute top-2.5 right-2.5 h-1.5 w-1.5 rounded-full bg-primary-700 border border-white animate-pulse"></span>
            <svg class="w-5 h-5 sm:w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </button>

        <!-- User Profile -->
        @auth
            <div class="flex items-center space-x-2 sm:space-x-4 border-l border-nautical-100 pl-2 sm:pl-6">
                <div class="text-right hidden sm:block">
                    <p class="text-xs sm:text-sm font-serif font-black text-primary-950 italic leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[8px] sm:text-[9px] text-nautical-400 font-bold uppercase tracking-widest mt-1">Oficial</p>
                </div>
                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded bg-primary-950 flex items-center justify-center text-white font-serif font-black italic shadow-md text-xs sm:text-base">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        @endauth
    </div>
</header>
