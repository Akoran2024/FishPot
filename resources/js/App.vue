<template>
  <div class="min-h-screen flex flex-col relative text-nautical-900 selection:bg-primary-200">
    <!-- IMAGEN DE FONDO GENERAL (FIJA) -->
    <div class="fixed inset-0 z-0 pointer-events-none">
      <img :src="'/imagenes/Tinajo-LaSanta-LR-1.jpg'" class="w-full h-full object-cover opacity-30" alt="Fondo La Santa">
      <div class="absolute inset-0 bg-gradient-to-b from-primary-950/20 via-transparent to-primary-950/20"></div>
    </div>

    <!-- Navbar Administrador -->
    <nav v-if="isAdminRoute" class="sticky top-0 z-50 w-full bg-primary-950 text-nautical-100 shadow-2xl border-b border-primary-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
          <div class="flex items-center space-x-8">
            <router-link to="/" class="flex items-center space-x-3">
              <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-8 w-auto filter brightness-110" />
              <div class="flex flex-col">
                <span class="text-xl font-serif font-black tracking-tight text-white italic leading-none">FishPot <span class="text-primary-400">Admin</span></span>
                <span class="text-[8px] font-bold text-primary-300 uppercase tracking-[0.3em] mt-1 italic opacity-60">Gestión Profesional</span>
              </div>
            </router-link>
            <div class="h-8 w-px bg-white/10"></div>
            <div class="flex space-x-1">
              <router-link to="/admin/pedidos" class="nav-btn-dark">Pedidos</router-link>
              <router-link to="/admin/productos" class="nav-btn-dark">Productos</router-link>
              <router-link to="/admin/usuarios" class="nav-btn-dark">Usuarios</router-link>
            </div>
          </div>
          <div class="flex items-center space-x-6">
            <router-link to="/" class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-300 hover:text-white transition-colors italic border-b border-primary-800 pb-1">Volver a la Web</router-link>
            <button @click="logout" class="bg-red-500/20 text-red-400 px-4 py-2 rounded font-serif italic text-xs font-bold hover:bg-red-500 hover:text-white transition-all border border-red-500/30">Cerrar Sesión</button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar Principal -->
    <nav v-if="!isAdminRoute" class="sticky top-0 z-50 w-full bg-primary-950 text-nautical-100 shadow-2xl border-b border-primary-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
          <router-link to="/" class="flex items-center space-x-3 group">
            <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-8 w-auto filter brightness-110 group-hover:rotate-3 transition-transform" />
            <div class="flex flex-col">
              <span class="text-2xl font-serif font-black tracking-tight text-white italic leading-none">Fish<span class="text-primary-400">Pot</span></span>
              <span class="text-[9px] font-bold text-primary-300 uppercase tracking-[0.3em] mt-1 italic opacity-60">Lanzarote · Est. 2026</span>
            </div>
          </router-link>

          <div class="hidden lg:flex items-center space-x-1">
            <router-link to="/mareas" class="nav-btn-dark">Mareas</router-link>
            <router-link to="/especies" class="nav-btn-dark">Especies</router-link>
            <router-link to="/lugares" class="nav-btn-dark">Costa</router-link>
            <router-link to="/licencia" class="nav-btn-dark">Licencia</router-link>
            <router-link to="/tienda" class="nav-btn-dark">Tienda</router-link>
            
            <div class="h-6 w-px bg-white/10 mx-4"></div>

            <!-- Auth -->
            <div class="flex items-center space-x-4">
              <router-link to="/carrito" class="relative p-2 text-primary-200 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-primary-500 text-primary-950 text-[9px] rounded-full h-4 w-4 flex items-center justify-center font-black border border-primary-950">{{ cartCount }}</span>
              </router-link>
              
              <template v-if="authStore.user">
                <div class="flex items-center space-x-3 bg-white/5 py-1.5 px-4 rounded-lg border border-white/10">
                  <span class="text-xs font-serif italic text-primary-100">{{ authStore.user.name }}</span>
                  <router-link v-if="authStore.user.role === 'admin'" to="/admin/pedidos" class="text-[10px] bg-primary-500 text-primary-950 px-2 py-1 rounded font-bold uppercase tracking-tighter hover:bg-primary-400 transition-colors">Admin</router-link>
                  <button @click="logout" class="text-primary-400 hover:text-red-400 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></button>
                </div>
              </template>
              <template v-else>
                <router-link to="/login" class="bg-primary-500 text-primary-950 px-6 py-2 rounded font-serif italic text-sm font-bold hover:bg-primary-400 shadow-lg transition-all">Entrar</router-link>
              </template>
            </div>
          </div>

          <div class="lg:hidden flex items-center space-x-4">
            <button @click="isMenuOpen = !isMenuOpen" class="p-2 text-white">
              <svg v-if="!isMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        </div>
      </div>

      <div v-show="isMenuOpen" class="lg:hidden bg-primary-950 border-b border-primary-800 px-6 py-8 space-y-4">
        <router-link @click="isMenuOpen = false" to="/mareas" class="block font-serif italic text-2xl py-2 text-white">Mareas</router-link>
        <router-link @click="isMenuOpen = false" to="/especies" class="block font-serif italic text-2xl py-2 text-white">Especies</router-link>
        <router-link @click="isMenuOpen = false" to="/lugares" class="block font-serif italic text-2xl py-2 text-white">Costa</router-link>
        <router-link @click="isMenuOpen = false" to="/licencia" class="block font-serif italic text-2xl py-2 text-white">Licencia</router-link>
        <router-link @click="isMenuOpen = false" to="/tienda" class="block font-serif italic text-2xl py-2 text-white">Tienda</router-link>

        <!-- ADDED MOBILE CART AND AUTH -->
        <div class="border-t border-primary-800 pt-4 mt-4"></div>
        <router-link @click="isMenuOpen = false" to="/carrito" class="flex items-center space-x-3 py-2 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            <span class="font-serif italic text-2xl">Carrito ({{ cartCount }})</span>
        </router-link>

        <template v-if="authStore.user">
            <div class="flex items-center space-x-3 py-2 text-primary-100">
                <span class="font-serif italic text-2xl">{{ authStore.user.name }}</span>
                <router-link v-if="authStore.user.role === 'admin'" @click="isMenuOpen = false" to="/admin/pedidos" class="text-[10px] bg-primary-500 text-primary-950 px-2 py-1 rounded font-bold uppercase tracking-tighter hover:bg-primary-400 transition-colors">Admin</router-link>
                <button @click="logout" class="text-primary-400 hover:text-red-400 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></button>
            </div>
        </template>
        <template v-else>
            <router-link @click="isMenuOpen = false" to="/login" class="block bg-primary-500 text-primary-950 px-6 py-2 rounded font-serif italic text-xl font-bold hover:bg-primary-400 shadow-lg transition-all text-center">Entrar</router-link>
        </template>
      </div>
    </nav>

    <main class="flex-grow relative z-10">
      <router-view />
    </main>

    <footer v-if="!isAdminRoute" class="bg-primary-950 text-nautical-200 border-t border-primary-900 py-24 relative z-10">
      <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-16">
        <div class="md:col-span-2">
          <div class="flex items-center space-x-3 mb-8">
            <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-6 w-auto filter brightness-110" />
            <span class="text-3xl font-serif font-black text-white italic tracking-tighter">FishPot</span>
          </div>
          <p class="text-lg font-serif italic text-primary-200 leading-relaxed max-w-md">
            Preservando el arte de la pesca en las Islas Canarias. Una comunidad dedicada al respeto del océano y la tradición artesanal.
          </p>
        </div>
        <div>
          <h4 class="text-white font-serif font-black mb-10 italic uppercase tracking-widest text-xs border-b border-white/10 pb-4">Bitácora</h4>
          <ul class="space-y-4 text-sm font-serif italic">
            <li><router-link to="/mareas" class="hover:text-primary-400 transition-colors">Mareas</router-link></li>
            <li><router-link to="/especies" class="hover:text-primary-400 transition-colors">Especies</router-link></li>
            <li><router-link to="/lugares" class="hover:text-primary-400 transition-colors">Costa</router-link></li>
            <li><router-link to="/licencia" class="hover:text-primary-400 transition-colors">Licencia</router-link></li>
            <li><router-link to="/tienda" class="hover:text-primary-400 transition-colors">Tienda</router-link></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-serif font-black mb-10 italic uppercase tracking-widest text-xs border-b border-white/10 pb-4">Ubicación</h4>
          <p class="text-sm font-serif italic text-primary-300 mb-2">Puerto de La Santa, Lanzarote</p>
          <p class="text-[10px] font-bold text-primary-500 uppercase tracking-[0.2em] italic">29.0350° N, 13.6330° W</p>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 mt-20 pt-8 border-t border-white/5 text-center">
        <p class="text-[10px] uppercase tracking-[0.4em] font-bold text-primary-600 italic">© 2026 FishPot · Lanzarote Pesca Artesanal · Hecho con respeto al mar</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import { useRouter, useRoute } from 'vue-router'

const authStore = useAuthStore()
const cartStore = useCartStore()
const router = useRouter()
const route = useRoute()

const isMenuOpen = ref(false)
const cartCount = computed(() => cartStore.totalItems)

const isAdminRoute = computed(() => {
  return route.path.startsWith('/admin')
})

const logout = async () => {
  await authStore.logout()
  isMenuOpen.value = false
  router.push('/login')
}
</script>

<style scoped>
.nav-btn-dark {
  @apply px-5 py-2 text-sm font-serif italic text-primary-200 hover:text-white transition-all border-b-2 border-transparent hover:border-primary-500;
}
.nav-btn-dark.router-link-active {
  @apply text-white border-primary-400 font-bold;
}
</style>
