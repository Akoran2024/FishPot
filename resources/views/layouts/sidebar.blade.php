<aside class="fixed inset-y-0 left-0 w-64 bg-primary-900 text-white transition-transform duration-300 transform z-30 overflow-y-auto shadow-2xl border-r border-primary-800">
    <div class="flex items-center justify-center h-20 border-b border-primary-800 bg-primary-950/50 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
             <div class="bg-white p-1 rounded-lg w-8 h-8 flex items-center justify-center shadow-lg shadow-white/10 overflow-hidden">
               <img src="/imagenes/Vieja.png" alt="FishPot Logo" class="h-8 w-auto object-contain mix-blend-multiply">
             </div>
             <span class="text-2xl font-black tracking-tight text-white">Fish<span class="text-primary-400">Pot</span></span>
        </div>
    </div>

    <nav class="mt-8 px-4 space-y-2">
        <p class="px-4 text-xs font-black text-primary-400 uppercase tracking-widest mb-4">Panel de Control</p>
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 text-white shadow-lg shadow-primary-900/50 border border-primary-700' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        <p class="px-4 text-xs font-black text-primary-400 uppercase tracking-widest mt-8 mb-4">Gestión</p>

        <a href="{{ route('admin.usuarios') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('admin.usuarios') ? 'bg-primary-800 text-white shadow-lg shadow-primary-900/50 border border-primary-700' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Usuarios
        </a>

        <a href="{{ route('admin.productos') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('admin.productos') ? 'bg-primary-800 text-white shadow-lg shadow-primary-900/50 border border-primary-700' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Productos
        </a>
        
        <a href="{{ route('admin.pedidos') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-colors {{ request()->routeIs('admin.pedidos') ? 'bg-primary-800 text-white shadow-lg shadow-primary-900/50 border border-primary-700' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Pedidos
        </a>
    </nav>
    
    <div class="absolute bottom-0 w-full p-4 border-t border-primary-800 bg-primary-950/30">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center px-4 py-3 text-sm font-bold text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-xl transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>