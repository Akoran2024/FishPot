<template>
  <div class="min-h-screen flex flex-col relative text-nautical-900 dark:text-nautical-100 selection:bg-primary-200 selection:text-primary-900">
    <!-- Barra de Marea (Progreso de Scroll) -->
    <div class="fixed top-0 left-0 w-full h-1 z-[60] pointer-events-none">
      <div class="h-full bg-gradient-to-r from-primary-400 via-sea-400 to-primary-400 transition-all duration-150 ease-out shadow-[0_0_10px_rgba(56,169,248,0.5)]" :style="{ width: scrollProgress + '%' }"></div>
    </div>

    <!-- IMAGEN DE FONDO GENERAL (FIJA) -->
    <div class="fixed inset-0 z-0 pointer-events-none transition-opacity duration-1000">
      <img :src="'/imagenes/Tinajo-LaSanta-LR-1.jpg'" class="w-full h-full object-cover opacity-20 dark:opacity-[0.07]" alt="Fondo La Santa">
      <div class="absolute inset-0 bg-gradient-to-b from-primary-950/20 via-transparent to-primary-950/20 dark:from-black/40 dark:to-black/40"></div>
    </div>

    <!-- Navbar Administrador Mejorado -->
    <nav v-if="isAdminRoute" class="sticky top-0 z-50 w-full bg-primary-950/95 dark:bg-black/95 backdrop-blur-md text-nautical-100 shadow-2xl border-b border-white/5 transition-all duration-500">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div :class="['flex justify-between items-center transition-all duration-500', isScrolled ? 'h-16' : 'h-24']">
          <div class="flex items-center space-x-8">
            <router-link to="/" class="flex items-center space-x-4 group">
              <div class="relative">
                <div class="absolute inset-0 bg-primary-400 blur-lg opacity-0 group-hover:opacity-20 transition-opacity rounded-full"></div>
                <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-9 w-auto filter brightness-110 group-hover:-rotate-3 transition-transform duration-500 relative z-10" />
              </div>
              <div class="flex flex-col">
                <span class="text-2xl font-serif font-black tracking-tighter text-white italic leading-none">FishPot <span class="text-primary-400">Admin</span></span>
                <span class="text-[9px] font-bold text-primary-300/60 uppercase tracking-[0.3em] mt-1 italic">Gestión Profesional</span>
              </div>
            </router-link>
            
            <div class="h-10 w-px bg-white/10 mx-2"></div>
            
            <nav class="flex items-center space-x-1">
              <router-link to="/admin" class="nav-btn-dark">Resumen</router-link>
              <router-link to="/admin/pedidos" class="nav-btn-dark">Pedidos</router-link>
              <router-link to="/admin/productos" class="nav-btn-dark">Productos</router-link>
              <router-link to="/admin/usuarios" class="nav-btn-dark">Usuarios</router-link>
            </nav>
          </div>

          <div class="flex items-center space-x-6">
            <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-white/10 transition-colors text-primary-300">
              <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M7.757 6.343l.707-.707ZM8 12a4 4 0 118 0 4 4 0 01-8 0z" /></svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>

            <router-link to="/" class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-400 hover:text-white transition-all italic border-b border-primary-800/50 hover:border-primary-400 pb-1">
                Volver a la Web
            </router-link>
            
            <button @click="logout" class="group relative px-6 py-2 overflow-hidden rounded bg-red-500/10 border border-red-500/30 text-red-400 font-serif italic text-xs font-bold hover:text-white transition-all">
                <div class="absolute inset-0 bg-red-500 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                <span class="relative z-10 font-bold">Cerrar Sesión</span>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar Principal Mejorado -->
    <nav v-if="!isAdminRoute" class="sticky top-0 z-50 w-full bg-primary-950/95 dark:bg-black/95 backdrop-blur-md text-nautical-100 shadow-2xl border-b border-white/5 transition-all duration-500">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div :class="['flex justify-between items-center transition-all duration-500', isScrolled ? 'h-16' : 'h-24']">
          <router-link to="/" class="flex items-center space-x-4 group">
            <div class="relative">
                <div class="absolute inset-0 bg-primary-400 blur-xl opacity-0 group-hover:opacity-20 transition-opacity rounded-full"></div>
                <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-10 w-auto filter brightness-110 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500 relative z-10" />
            </div>
            <div class="flex flex-col">
              <span class="text-3xl font-serif font-black tracking-tighter text-white italic leading-none">Fish<span class="text-primary-400">Pot</span></span>
              <span class="text-[10px] font-bold text-primary-300/60 uppercase tracking-[0.4em] mt-1 italic">Lanzarote · Est. 2026</span>
            </div>
          </router-link>

          <div class="hidden lg:flex items-center space-x-2">
            <nav class="flex items-center space-x-1 mr-4">
                <router-link to="/mareas" class="nav-btn-dark">Mareas</router-link>
                <router-link to="/especies" class="nav-btn-dark">Especies</router-link>
                <router-link to="/lugares" class="nav-btn-dark">Costa</router-link>
                <router-link to="/licencia" class="nav-btn-dark">Licencia</router-link>
                <router-link to="/tienda" class="nav-btn-dark">Tienda</router-link>
            </nav>
            
            <div class="h-8 w-px bg-white/10 mx-4"></div>

            <!-- Auth & Carrito -->
            <div class="flex items-center space-x-6">
              <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-white/10 transition-colors text-primary-300">
                <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M7.757 6.343l.707-.707ZM8 12a4 4 0 118 0 4 4 0 01-8 0z" /></svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
              </button>

              <router-link to="/carrito" class="relative group p-2 transition-all">
                <div class="absolute inset-0 bg-white/5 rounded-full scale-0 group-hover:scale-100 transition-transform"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-200 group-hover:text-white relative z-10 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <span v-if="cartCount > 0" class="absolute top-0 right-0 bg-primary-500 text-white text-[10px] rounded-full h-5 w-5 flex items-center justify-center font-black border-2 border-primary-950 animate-bounce-subtle">{{ cartCount }}</span>
              </router-link>
              
              <template v-if="authStore.user">
                <div class="flex items-center space-x-4 pl-4 border-l border-white/5">
                  <div class="flex flex-col items-end">
                    <span class="text-xs font-serif italic text-white/90 leading-none mb-1">{{ authStore.user.name }}</span>
                    <div class="flex space-x-2">
                        <router-link to="/mis-pedidos" class="text-[9px] font-black uppercase tracking-widest text-primary-400 hover:text-white transition-colors">Mis Pedidos</router-link>
                        <router-link v-if="authStore.user.role === 'admin'" to="/admin" class="text-[9px] font-black uppercase tracking-widest text-sea-400 hover:text-white transition-colors">Admin</router-link>
                    </div>
                  </div>
                  <button @click="logout" class="p-2 hover:bg-red-500/10 rounded-full text-red-400 transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                  </button>
                </div>
              </template>
              <template v-else>
                <router-link to="/login" class="relative overflow-hidden group bg-primary-500 text-primary-950 px-8 py-2.5 rounded font-serif italic text-base font-bold transition-all shadow-lg hover:shadow-primary-500/20 active:scale-95">
                    <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover:translate-x-0 transition-transform duration-500 skew-x-12"></div>
                    <span class="relative z-10">Embarcar</span>
                </router-link>
              </template>
            </div>
          </div>

          <!-- Mobile Toggle -->
          <div class="lg:hidden flex items-center space-x-4">
            <button @click="toggleDarkMode" class="p-2 text-primary-300">
                <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1m-16 0H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M7.757 6.343l.707-.707ZM8 12a4 4 0 118 0 4 4 0 01-8 0z" /></svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>
            <button @click="isMenuOpen = !isMenuOpen" class="p-3 text-white bg-white/5 rounded-xl hover:bg-white/10 transition-colors">
              <svg v-if="!isMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <transition 
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div v-show="isMenuOpen" class="lg:hidden bg-primary-950/98 dark:bg-black/98 backdrop-blur-xl border-t border-white/5 px-6 py-10 space-y-6">
            <div class="grid grid-cols-1 gap-4">
                <router-link @click="isMenuOpen = false" to="/mareas" class="mobile-nav-link">Mareas</router-link>
                <router-link @click="isMenuOpen = false" to="/especies" class="mobile-nav-link">Especies</router-link>
                <router-link @click="isMenuOpen = false" to="/lugares" class="mobile-nav-link">Costa</router-link>
                <router-link @click="isMenuOpen = false" to="/licencia" class="mobile-nav-link">Licencia</router-link>
                <router-link @click="isMenuOpen = false" to="/tienda" class="mobile-nav-link">Tienda</router-link>
            </div>

            <div class="h-px bg-white/5"></div>

            <div class="flex items-center justify-between">
                <router-link @click="isMenuOpen = false" to="/carrito" class="flex items-center space-x-3 text-primary-200">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-primary-500 text-white text-[10px] rounded-full h-5 w-5 flex items-center justify-center font-black">{{ cartCount }}</span>
                    </div>
                    <span class="font-serif italic text-2xl">Bitácora</span>
                </router-link>

                <template v-if="authStore.user">
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-xs text-white/40 uppercase tracking-widest font-black leading-none mb-1">Pescador</p>
                            <p class="font-serif italic text-white text-xl leading-none">{{ authStore.user.name }}</p>
                        </div>
                        <button @click="logout" class="p-3 bg-red-500/10 text-red-400 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></button>
                    </div>
                </template>
                <template v-else>
                    <router-link @click="isMenuOpen = false" to="/login" class="bg-primary-500 text-primary-950 px-8 py-3 rounded font-serif italic text-xl font-bold shadow-2xl">Embarcar</router-link>
                </template>
            </div>
        </div>
      </transition>
    </nav>

    <main class="flex-grow relative z-10">
      <router-view v-slot="{ Component }">
        <transition name="page-fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <!-- Footer Mejorado -->
    <footer v-if="!isAdminRoute" class="bg-primary-950 dark:bg-black text-nautical-100 relative z-10 overflow-hidden transition-colors duration-500">
      <!-- Decoración Superior -->
      <div class="h-2 w-full bg-gradient-to-r from-primary-600 via-sea-400 to-primary-600"></div>
      
      <!-- Fondo con textura sutil -->
      <div class="absolute inset-0 opacity-[0.03] pointer-events-none mix-blend-overlay">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(#noise)"/></svg>
      </div>

      <div class="max-w-7xl mx-auto px-4 pt-32 pb-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
          
          <!-- Columna Marca -->
          <div class="lg:col-span-5">
            <div class="flex items-center space-x-4 mb-10 group">
              <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-10 w-auto filter brightness-125" />
              <span class="text-4xl font-serif font-black text-white italic tracking-tighter">FishPot</span>
            </div>
            <p class="text-xl font-serif italic text-primary-100/80 leading-relaxed mb-10 max-w-md">
              Protegiendo el legado de la pesca tradicional en Lanzarote. Porque el mar no es solo un recurso, es nuestra historia.
            </p>
            <div class="flex space-x-5">
                <a href="#" class="h-12 w-12 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 hover:border-primary-400 transition-all text-primary-300">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="#" class="h-12 w-12 rounded-full border border-white/10 flex items-center justify-center hover:bg-white/5 hover:border-primary-400 transition-all text-primary-300">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
            </div>
          </div>

          <!-- Columna Enlaces -->
          <div class="lg:col-span-3">
            <h4 class="text-white font-serif font-black mb-8 italic uppercase tracking-[0.2em] text-[10px] flex items-center">
                <span class="w-8 h-px bg-primary-500 mr-4"></span>
                Navegación
            </h4>
            <ul class="space-y-4">
              <li><router-link to="/mareas" class="footer-link group">Cuaderno de Mareas</router-link></li>
              <li><router-link to="/especies" class="footer-link group">Catálogo de Especies</router-link></li>
              <li><router-link to="/lugares" class="footer-link group">Rutas de Costa</router-link></li>
              <li><router-link to="/licencia" class="footer-link group">Trámites de Licencia</router-link></li>
              <li><router-link to="/tienda" class="footer-link group">La Lonja (Tienda)</router-link></li>
            </ul>
          </div>

          <!-- Columna Info -->
          <div class="lg:col-span-4">
            <h4 class="text-white font-serif font-black mb-8 italic uppercase tracking-[0.2em] text-[10px] flex items-center">
                <span class="w-8 h-px bg-primary-500 mr-4"></span>
                Puerto Base
            </h4>
            <div class="space-y-6">
                <div>
                    <p class="text-sm font-serif italic text-primary-100 mb-1">Muelle de La Santa</p>
                    <p class="text-xs text-primary-400/60 uppercase tracking-widest font-black">Tinajo, Lanzarote</p>
                </div>
                <div class="p-6 bg-white/5 rounded-2xl border border-white/5 relative group overflow-hidden">
                    <div class="absolute inset-0 bg-primary-500/5 translate-y-full group-hover:translate-y-0 transition-transform"></div>
                    <p class="text-[10px] font-black text-primary-400 uppercase tracking-[0.3em] mb-2 relative z-10">Coordenadas GPS</p>
                    <p class="text-xl font-serif italic text-white relative z-10">29° 02' 06" N <br> 13° 39' 11" W</p>
                </div>
                <div class="flex items-center space-x-3 text-primary-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <span class="text-sm font-serif italic">ahoy@fishpot.es</span>
                </div>
            </div>
          </div>
        </div>

        <!-- Copyright -->
        <div class="mt-32 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
          <p class="text-[10px] uppercase tracking-[0.4em] font-black text-primary-600/60 italic text-center md:text-left">
            © 2026 FishPot · Lanzarote Pesca Artesanal · Hecho con respeto al mar
          </p>
          <div class="flex space-x-8 text-[9px] font-black uppercase tracking-widest text-primary-400/40">
            <a href="#" class="hover:text-white transition-colors">Aviso Legal</a>
            <a href="#" class="hover:text-white transition-colors">Privacidad</a>
            <a href="#" class="hover:text-white transition-colors">Cookies</a>
          </div>
        </div>
      </div>
    </footer>
    <Toast />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import { useRouter, useRoute } from 'vue-router'
import Toast from './components/Toast.vue'

const authStore = useAuthStore()
const cartStore = useCartStore()
const router = useRouter()
const route = useRoute()

const isMenuOpen = ref(false)
const isScrolled = ref(false)
const isDark = ref(false)
const scrollProgress = ref(0)
const cartCount = computed(() => cartStore.totalItems)

const updateScrollProgress = () => {
  const h = document.documentElement, 
        b = document.body,
        st = 'scrollTop',
        sh = 'scrollHeight';
  const percent = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
  scrollProgress.value = percent;
}

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.theme = 'dark'
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.theme = 'light'
  }
}

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
  window.addEventListener('scroll', updateScrollProgress)
  
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  } else {
    isDark.value = false
    document.documentElement.classList.remove('dark')
  }
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  window.removeEventListener('scroll', updateScrollProgress)
})

const isAdminRoute = computed(() => {
  return route.path.startsWith('/admin')
})

const logout = async () => {
  await authStore.logout()
  isMenuOpen.value = false
  router.push('/login')
}
</script>

<style>
.nav-btn-dark {
  @apply px-5 py-2 text-sm font-serif italic text-primary-200/80 hover:text-white transition-all border-b-2 border-transparent hover:border-primary-500/50 relative;
}
.nav-btn-dark.router-link-active {
  @apply text-white border-primary-400 font-bold bg-white/5 rounded-t-lg;
}

.mobile-nav-link {
    @apply block font-serif italic text-3xl py-3 text-white/90 hover:text-primary-400 transition-colors border-l-4 border-transparent hover:border-primary-500 pl-4;
}

.footer-link {
    @apply text-sm font-serif italic text-primary-200/60 hover:text-primary-300 transition-all flex items-center;
}
.footer-link::before {
    content: '→';
    @apply mr-3 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 text-primary-500;
}

@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}
.animate-bounce-subtle {
    animation: bounce-subtle 2s infinite ease-in-out;
}

/* Transiciones de Página PRO */
.page-fade-enter-active,
.page-fade-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-fade-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.page-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Skeleton Effect */
.skeleton {
  @apply bg-primary-900/10 relative overflow-hidden rounded;
}
.skeleton::after {
  content: "";
  @apply absolute inset-0 -translate-x-full;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  animation: shimmer 1.5s infinite;
}
@keyframes shimmer {
  100% { transform: translateX(100%); }
}
</style>
