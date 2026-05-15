<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-nautical-200 dark:border-white/10 pb-12">
      <div class="max-w-2xl">
        <h2 class="text-primary-800 dark:text-primary-400 font-serif italic text-sm tracking-[0.2em] uppercase mb-4">Equipamiento de Calidad</h2>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 dark:text-white leading-tight tracking-tight italic">Almacén de Aparejos</h1>
        <p class="text-nautical-600 dark:text-nautical-300 mt-6 font-serif italic text-lg leading-relaxed">Selección de materiales probados en nuestras costas. Desde la pesca tradicional a las artes más modernas, con el sello de confianza de FishPot.</p>
      </div>
      
      <router-link to="/carrito" class="flex items-center space-x-6 bg-white dark:bg-primary-900/40 backdrop-blur-md p-4 rounded-lg border border-nautical-200 dark:border-white/10 shadow-md group transition-all">
        <div class="p-3 bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950 rounded shadow-lg group-hover:bg-primary-800 dark:group-hover:bg-primary-400 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] font-black text-nautical-400 dark:text-primary-300/60 uppercase tracking-widest leading-none mb-1 italic">Su Cesto</span>
          <span class="text-lg font-serif font-black text-primary-950 dark:text-white leading-none italic">{{ cartStore.totalItems }} artículos</span>
        </div>
      </router-link>
    </div>

    <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
      <div v-for="i in 8" :key="i" class="nautical-card p-4 flex flex-col h-[450px]">
        <div class="h-64 skeleton dark:bg-white/5 mb-6 rounded"></div>
        <div class="h-6 skeleton dark:bg-white/5 w-3/4 mb-4 rounded"></div>
        <div class="h-4 skeleton dark:bg-white/5 w-full mb-2 rounded"></div>
        <div class="h-4 skeleton dark:bg-white/5 w-5/6 mb-auto rounded"></div>
        <div class="flex justify-between items-center mt-8 pt-6 border-t border-nautical-100 dark:border-white/5 px-2">
          <div class="flex flex-col space-y-2">
            <div class="h-3 skeleton dark:bg-white/5 w-10 rounded"></div>
            <div class="h-8 skeleton dark:bg-white/5 w-20 rounded"></div>
          </div>
          <div class="h-12 skeleton dark:bg-white/5 w-12 rounded"></div>
        </div>
      </div>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
      <div v-for="product in products" :key="product.id" 
           @click="openProductModal(product)"
           class="nautical-card p-4 group flex flex-col border-b-4 border-primary-100 dark:border-primary-900 hover:border-primary-800 dark:hover:border-primary-500 transition-all duration-500 cursor-pointer hover-shine">
        
        <div class="h-64 bg-nautical-50 dark:bg-primary-950/50 rounded mb-6 flex items-center justify-center relative overflow-hidden group-hover:bg-white dark:group-hover:bg-primary-900 transition-colors">
           <div v-if="product.stock <= 0" class="absolute inset-0 bg-white/70 dark:bg-primary-950/70 z-10 flex items-center justify-center">
              <span class="bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950 px-5 py-2 font-serif italic text-sm shadow-xl transform -rotate-2">Sin Existencias</span>
           </div>
           
           <div class="w-full h-full p-6 transition-transform duration-700 group-hover:scale-110 group-hover:animate-float">
              <img v-if="product.image" :src="formatImagePath(product.image)" :alt="product.name" class="w-full h-full object-contain grayscale-[0.2] group-hover:grayscale-0 dark:brightness-90 dark:group-hover:brightness-110">
              <div v-else class="w-full h-full flex items-center justify-center text-nautical-200 dark:text-white/10 italic font-serif">Equipo</div>
           </div>
           
           <div class="absolute bottom-4 left-4">
             <span class="bg-white/80 dark:bg-primary-950/80 px-3 py-1 border border-nautical-100 dark:border-white/10 text-[9px] font-bold text-nautical-400 dark:text-primary-300 uppercase tracking-widest italic">
               {{ product.category || 'Equipo' }}
             </span>
           </div>
        </div>

        <div class="flex-grow px-2">
          <h3 class="font-serif font-black text-primary-950 dark:text-white text-xl group-hover:text-primary-800 dark:group-hover:text-primary-400 transition-colors italic mb-2">{{ product.name }}</h3>
          <p class="text-nautical-600 dark:text-nautical-400 text-sm leading-relaxed font-serif italic line-clamp-2 mb-4">{{ product.description }}</p>
          
          <div class="flex items-center space-x-2">
            <div :class="product.stock < 5 ? 'bg-red-500' : 'bg-primary-700 dark:bg-primary-400'" class="w-1.5 h-1.5 rounded-full shadow-sm"></div>
            <span class="text-[10px] font-bold text-nautical-300 dark:text-nautical-500 uppercase tracking-widest italic">
              Existencias: {{ product.stock }}
            </span>
          </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-nautical-100 dark:border-white/5 flex items-center justify-between px-2">
          <div class="flex flex-col">
            <span class="text-[9px] font-bold text-nautical-400 dark:text-primary-400 uppercase tracking-widest italic mb-1">Precio</span>
            <span class="text-3xl font-serif font-black text-primary-950 dark:text-white italic tracking-tighter">{{ product.price }}<span class="text-base ml-0.5">€</span></span>
          </div>
          <button 
            @click.stop="addToCart(product)" 
            :disabled="product.stock <= 0"
            :class="product.stock <= 0 ? 'bg-nautical-100 dark:bg-primary-900/50 text-nautical-300' : 'bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950 hover:bg-primary-800 dark:hover:bg-primary-400 active:translate-y-1 shadow-md'"
            class="p-4 rounded transition-all duration-300"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal de Detalles del Producto -->
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="selectedProduct" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-primary-950/80 dark:bg-black/90 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="closeModal"></div>

          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          <div class="inline-block align-middle bg-white dark:bg-primary-950 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
            <div class="absolute top-6 right-6 z-10">
              <button @click="closeModal" class="p-2 bg-white/10 dark:bg-black/20 hover:bg-primary-50 dark:hover:bg-primary-900 text-primary-950 dark:text-white rounded-full transition-all border border-nautical-100 dark:border-white/10">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>
            </div>

            <div class="flex flex-col md:flex-row h-full">
              <!-- Imagen Izquierda -->
              <div class="md:w-1/2 bg-nautical-50 dark:bg-primary-900/50 flex items-center justify-center p-12 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(#noise)"/></svg>
                </div>
                <img :src="formatImagePath(selectedProduct.image)" :alt="selectedProduct.name" class="max-h-[500px] w-full object-contain relative z-10 drop-shadow-2xl scale-110 dark:brightness-90">
              </div>

              <!-- Info Derecha -->
              <div class="md:w-1/2 p-12 flex flex-col justify-center">
                <div class="mb-8">
                  <span class="inline-block bg-primary-100 dark:bg-primary-800 text-primary-800 dark:text-primary-200 text-[10px] font-black uppercase tracking-[0.3em] px-3 py-1 rounded mb-4 italic">
                    {{ selectedProduct.category || 'Equipo Profesional' }}
                  </span>
                  <h2 class="text-4xl font-serif font-black text-primary-950 dark:text-white italic leading-tight mb-4 tracking-tighter">{{ selectedProduct.name }}</h2>
                  <div class="flex items-center space-x-3 mb-6">
                    <div :class="selectedProduct.stock < 5 ? 'bg-red-500' : 'bg-primary-700 dark:bg-primary-400'" class="w-2 h-2 rounded-full"></div>
                    <span class="text-xs font-bold text-nautical-400 dark:text-nautical-500 uppercase tracking-widest italic">
                      {{ selectedProduct.stock }} unidades en puerto
                    </span>
                  </div>
                  <p class="text-nautical-600 dark:text-nautical-300 font-serif italic text-lg leading-relaxed mb-8">{{ selectedProduct.description }}</p>
                </div>

                <div class="mt-auto pt-8 border-t border-nautical-100 dark:border-white/10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-nautical-400 dark:text-primary-400 uppercase tracking-widest italic mb-1">Precio Lonja</span>
                            <span class="text-5xl font-serif font-black text-primary-950 dark:text-white italic tracking-tighter">{{ selectedProduct.price }}<span class="text-2xl ml-1">€</span></span>
                        </div>
                    </div>
                    
                    <button 
                        @click="addToCart(selectedProduct)" 
                        :disabled="selectedProduct.stock <= 0"
                        class="w-full bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950 py-5 rounded-xl font-serif font-black italic text-xl hover:bg-primary-800 dark:hover:bg-primary-400 transition-all shadow-xl active:scale-[0.98] disabled:bg-nautical-100 disabled:text-nautical-300 flex items-center justify-center space-x-3"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Añadir al Cesto</span>
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useCartStore } from '../stores/cart'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import { useToastStore } from '../stores/toast'

const cartStore = useCartStore()
const authStore = useAuthStore()
const toastStore = useToastStore()
const router = useRouter()
const products = ref([])
const loading = ref(true)
const selectedProduct = ref(null)

const fetchProducts = async () => {
  try {
    const res = await axios.get('/products-list')
    products.value = res.data || []
  } catch (error) {
    console.error('Error cargando productos:', error)
  } finally {
    loading.value = false
  }
}

const formatImagePath = (path) => {
  if (!path) return null
  if (path.startsWith('http') || path.startsWith('/')) return path
  return '/' + path
}

onMounted(fetchProducts)

const openProductModal = (product) => {
  selectedProduct.value = product
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  selectedProduct.value = null
  document.body.style.overflow = 'auto'
}

const addToCart = (product) => {
  if (product.stock <= 0) return
  
  if (!authStore.user) {
    toastStore.add('Debe estar dado de alta como socio para añadir aparejos al cesto.', 'error')
    router.push('/login')
    return
  }
  
  cartStore.addItem(product)
  toastStore.add(`¡${product.name} añadido al cesto!`)
  
  if (selectedProduct.value) closeModal()
}
</script>
