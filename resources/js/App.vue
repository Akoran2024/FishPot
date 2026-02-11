<template>
  <div class="min-h-screen bg-white flex flex-col">
    <!-- Navbar -->
    <nav class="bg-primary-900 text-white shadow-lg sticky top-0 z-50" 
    
    
    aria-label="Navegación principal">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <div>
               <img 
                src="/imagenes/Vieja.png" 
                alt="Logotipo de FishPot"
                class="h-12 w-auto"
              />
            </div>
            <router-link to="/" class="text-2xl font-bold tracking-tight text-white focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded p-1">Fish<span class="text-primary-300">Pot</span></router-link>
          </div>

          <!-- Menu Desktop -->
          <div class="hidden md:flex items-center space-x-8">
            <router-link to="/mareas" class="hover:text-primary-200 transition font-medium focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded px-2 py-1">Tabla de mareas</router-link>
            <router-link to="/especies" class="hover:text-primary-200 transition font-medium focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded px-2 py-1">Especies</router-link>
            <router-link to="/tienda" class="hover:text-primary-200 transition font-medium focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded px-2 py-1">Tienda</router-link>
            <router-link v-if="authStore.user" to="/clientes" class="hover:text-primary-200 transition font-medium text-primary-100 focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded px-2 py-1">Clientes</router-link>
            
            <div class="flex items-center space-x-4 ml-4 border-l border-primary-700 pl-8">
              <router-link to="/carrito" class="relative hover:text-primary-200 transition focus:outline-none focus:ring-2 focus:ring-accessible-focus rounded p-1" aria-label="Ver carrito de compras">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" aria-hidden="true">{{ cartCount }}</span>
                <span v-if="cartCount > 0" class="sr-only">{{ cartCount }} artículos en el carrito</span>
              </router-link>

              <template v-if="authStore.user">
                <span class="text-sm opacity-90 font-medium">Hola, {{ authStore.user.name }}</span>
                <button @click="logout" class="bg-primary-700 hover:bg-primary-600 px-4 py-2 rounded-lg text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-accessible-focus border border-transparent hover:border-primary-400">Salir</button>
              </template>
              <template v-else>
                <router-link to="/login" class="bg-primary-600 hover:bg-primary-500 px-4 py-2 rounded-lg text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-accessible-focus border border-transparent hover:border-primary-300">Ingresar</router-link>
              </template>
            </div>
          </div>
          
          <!-- Mobile Menu Button (Placeholder) -->
          <div class="md:hidden">
             <button class="p-2 rounded-md hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-accessible-focus" aria-label="Abrir menú principal">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
               </svg>
             </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow">
      <router-view></router-view>
    </div>

    <!-- Footer -->
    <footer class="bg-primary-950 text-slate-300 py-12 border-t-4 border-primary-700">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="font-bold text-white mb-2 text-lg">FishPot &copy; 2026</p>
        <p class="font-medium">Tu página de pesca en Lanzarote.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const cartStore = useCartStore()
const router = useRouter()

const cartCount = computed(() => cartStore.totalItems)

const logout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>

<style>

</style>
