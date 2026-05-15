<aside class="w-64 h-full bg-primary-950 text-nautical-100 flex flex-col z-30 overflow-y-auto border-r border-primary-900">
    <div class="flex items-center justify-center h-20 border-b border-primary-900 bg-black/10 backdrop-blur-md">
        <a href="/" class="flex items-center space-x-3 group">
             <div class="bg-white p-1 rounded-lg w-8 h-8 flex items-center justify-center shadow-lg transform group-hover:rotate-3 transition-transform">
               <img src="/imagenes/Vieja.png" alt="Logo" class="h-6 w-auto">
             </div>
             <span class="text-xl font-serif font-black tracking-tight text-white italic">FishPot <span class="text-primary-400 text-xs not-italic uppercase tracking-widest">Admin</span></span>
        </a>
    </div>

    <nav class="mt-8 px-4 space-y-2">
        <p class="px-4 text-[10px] font-bold text-primary-400 uppercase tracking-[0.3em] mb-6 italic opacity-60">Gestión de Capitanía</p>

        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-sm font-serif italic rounded-lg transition-all {{ request()->routeIs('admin.users.*') ? 'bg-primary-800 text-white shadow-lg border border-primary-700' : 'text-nautical-300 hover:bg-primary-900 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Socios y Usuarios
        </a>

        <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-serif italic rounded-lg transition-all {{ request()->routeIs('admin.products.*') ? 'bg-primary-800 text-white shadow-lg border border-primary-700' : 'text-nautical-300 hover:bg-primary-900 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Inventario Aparejos
        </a>
        
        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-serif italic rounded-lg transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-primary-800 text-white shadow-lg border border-primary-700' : 'text-nautical-300 hover:bg-primary-900 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Libro de Pedidos
        </a>
    </nav>
    
    <div class="absolute bottom-0 w-full p-4 border-t border-primary-900 bg-black/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center px-4 py-3 text-xs font-bold text-red-400 hover:text-red-300 rounded-lg transition-all uppercase tracking-widest italic">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Cerrar Bitácora
            </button>
        </form>
    </div>
</aside>
