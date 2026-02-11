<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">
    <!-- Navbar -->
    <nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <div class="bg-white p-1.5 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-900" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12,2L4.5,20.29L5.21,21L12,18L18.79,21L19.5,20.29L12,2Z" />
              </svg>
            </div>
            <router-link to="/" class="text-2xl font-bold tracking-tight">Fish<span class="text-blue-400">Pot</span></router-link>
          </div>

          <!-- Menu Desktop -->
          <div class="hidden md:flex items-center space-x-8">
            <router-link to="/mareas" class="hover:text-blue-300 transition font-medium">Tabla de mareas</router-link>
            <router-link to="/especies" class="hover:text-blue-300 transition font-medium">Especies</router-link>
            <router-link to="/tienda" class="hover:text-blue-300 transition font-medium">Tienda</router-link>
            
            <div class="flex items-center space-x-4 ml-4 border-l border-blue-800 pl-8">
              <router-link to="/carrito" class="relative hover:text-blue-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">{{ cartCount }}</span>
              </router-link>

              <template v-if="authStore.user">
                <span class="text-sm opacity-75">Hola, {{ authStore.user.name }}</span>
                <button @click="logout" class="bg-blue-800 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-semibold transition">Salir</button>
              </template>
              <template v-else>
                <router-link to="/login" class="bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded-lg text-sm font-semibold transition">Ingresar</router-link>
              </template>
            </div>
          </div>
          
          <!-- Mobile Menu Button (Placeholder) -->
          <div class="md:hidden">
             <button class="p-2 rounded-md hover:bg-blue-800">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
               </svg>
             </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
      <router-view></router-view>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="font-bold text-white mb-2 text-lg">FishPot &copy; 2026</p>
        <p>Tu página de pesca en Lanzarote.</p>
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
