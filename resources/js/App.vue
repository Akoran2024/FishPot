<template>
  <div class="min-h-screen bg-slate-50 flex flex-col relative overflow-x-hidden">
    <!-- Decorative background elements -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-50"></div>
      <div class="absolute top-1/2 -left-24 w-80 h-80 bg-blue-100 rounded-full blur-3xl opacity-40"></div>
      <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-teal-50 rounded-full blur-3xl opacity-30"></div>
    </div>

    <!-- Navbar -->
    <nav class="bg-primary-900/90 backdrop-blur-md text-white shadow-xl sticky top-0 z-50 border-b border-primary-800" 
    aria-label="Navegación principal">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
          <!-- Logo -->
          <div class="flex items-center space-x-3 group">
            <div>
               <img 
                :src="'/imagenes/Vieja.png'" 
                alt="Logotipo de FishPot"
                class="h-10 w-auto"
              />
            </div>
            <router-link to="/" class="text-2xl font-extrabold tracking-tight text-white focus:outline-none focus:ring-2 focus:ring-accent-400 rounded p-1">
              Fish<span class="text-primary-300">Pot</span>
            </router-link>
          </div>

          <!-- Menu Desktop -->
          <div class="hidden md:flex items-center space-x-1">
            <router-link to="/mareas" class="px-4 py-2 hover:bg-white/10 rounded-lg transition-all duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-accent-400">Tabla de mareas</router-link>
            <router-link to="/especies" class="px-4 py-2 hover:bg-white/10 rounded-lg transition-all duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-accent-400">Especies</router-link>
            <router-link to="/tienda" class="px-4 py-2 hover:bg-white/10 rounded-lg transition-all duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-accent-400">Tienda</router-link>
            
            <div class="flex items-center space-x-6 ml-6 border-l border-primary-700/50 pl-6">
              <router-link to="/carrito" class="relative group p-2 text-white hover:text-accent-300 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-400 rounded-full" aria-label="Ver carrito de compras">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:scale-110 transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span v-if="cartCount > 0" class="absolute top-0 right-0 bg-accent-500 text-primary-950 text-[10px] rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-sm" aria-hidden="true">{{ cartCount }}</span>
              </router-link>

              <template v-if="authStore.user">
                <div class="flex items-center space-x-3 bg-primary-800/50 py-1.5 px-3 rounded-full border border-primary-700/50">
                  <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-xs font-bold border border-primary-500">
                    {{ authStore.user.name.charAt(0).toUpperCase() }}
                  </div>
                  <button @click="logout" class="text-xs font-bold hover:text-accent-300 transition-colors uppercase tracking-wider">Salir</button>
                </div>
              </template>
              <template v-else>
                <router-link to="/login" class="bg-accent-500 hover:bg-accent-400 text-primary-950 px-6 py-2 rounded-full text-sm font-bold transition-all duration-300 transform hover:scale-105 shadow-lg shadow-accent-950/20">Ingresar</router-link>
              </template>
            </div>
          </div>
          
          <!-- Mobile Menu Button -->
          <div class="md:hidden flex items-center space-x-2">
             <router-link to="/carrito" class="relative p-2 text-white hover:text-accent-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span v-if="cartCount > 0" class="absolute top-1 right-1 bg-accent-500 text-primary-950 text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-bold">{{ cartCount }}</span>
             </router-link>

             <button @click="isMenuOpen = !isMenuOpen" class="p-2 rounded-xl hover:bg-primary-800 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-400" aria-label="Abrir menú principal">
               <svg v-if="!isMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
               </svg>
               <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
               </svg>
             </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu Content -->
      <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 -translate-y-4" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
        <div v-show="isMenuOpen" class="md:hidden bg-primary-900 border-t border-primary-800 px-4 pt-2 pb-6 space-y-2 shadow-2xl">
          <router-link @click="isMenuOpen = false" to="/mareas" class="block px-4 py-3 rounded-xl text-lg font-semibold hover:bg-primary-800 transition">Tabla de mareas</router-link>
          <router-link @click="isMenuOpen = false" to="/especies" class="block px-4 py-3 rounded-xl text-lg font-semibold hover:bg-primary-800 transition">Especies</router-link>
          <router-link @click="isMenuOpen = false" to="/tienda" class="block px-4 py-3 rounded-xl text-lg font-semibold hover:bg-primary-800 transition">Tienda</router-link>
          <div class="pt-4 border-t border-primary-800">
            <template v-if="authStore.user">
               <button @click="logout" class="w-full text-center bg-primary-800 py-3 rounded-xl font-bold">Cerrar sesión ({{ authStore.user.name }})</button>
            </template>
            <template v-else>
               <router-link @click="isMenuOpen = false" to="/login" class="block w-full text-center bg-accent-500 text-primary-950 py-3 rounded-xl font-bold">Ingresar</router-link>
            </template>
          </div>
        </div>
      </transition>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow relative z-10">
      <router-view v-slot="{ Component }">
        <transition name="page" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-16 relative z-10 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="text-center md:text-left">
          <div class="flex items-center justify-center md:justify-start space-x-2 mb-4">
            <div>
               <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-6 w-auto" />
            </div>
            <span class="text-2xl font-bold text-white">Fish<span class="text-primary-500">Pot</span></span>
          </div>
          <p class="text-sm leading-relaxed">Tu portal especializado en la pesca recreativa y deportiva en la isla de Lanzarote. Información de mareas, especies y tienda.</p>
        </div>
        
        <div class="text-center">
          <h4 class="text-white font-bold mb-4 uppercase tracking-widest text-sm">Enlaces Rápidos</h4>
          <ul class="space-y-2 text-sm">
            <li><router-link to="/mareas" class="hover:text-primary-400 transition">Tabla de mareas</router-link></li>
            <li><router-link to="/especies" class="hover:text-primary-400 transition">Especies</router-link></li>
            <li><router-link to="/tienda" class="hover:text-primary-400 transition">Tienda</router-link></li>
          </ul>
        </div>

        <div class="text-center md:text-right">
          <h4 class="text-white font-bold mb-4 uppercase tracking-widest text-sm">Contacto</h4>
          <p class="text-sm">info@fishpot.es</p>
          <p class="text-sm mt-1">Lanzarote, Islas Canarias</p>
          <div class="mt-6 flex justify-center md:justify-end space-x-4">
            <!-- Social placeholders -->
            <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors cursor-pointer">
              <span class="sr-only">Facebook</span>
              <div class="w-4 h-4 bg-white/20 rounded-sm"></div>
            </div>
            <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors cursor-pointer">
              <span class="sr-only">Instagram</span>
              <div class="w-4 h-4 bg-white/20 rounded-sm"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-slate-800 text-center text-xs">
        <p>FishPot &copy; 2026. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useAuthStore } from './stores/auth'
import { useCartStore } from './stores/cart'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const cartStore = useCartStore()
const router = useRouter()

const isMenuOpen = ref(false)
const cartCount = computed(() => cartStore.totalItems)

const logout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>

<style>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}

.animate-fade-in {
  animation: fade-in 0.5s ease-out forwards;
}
</style>
