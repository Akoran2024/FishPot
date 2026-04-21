<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-nautical-200 pb-12">
      <div class="max-w-2xl">
        <h2 class="text-primary-800 font-serif italic text-sm tracking-[0.2em] uppercase mb-4">Equipamiento de Calidad</h2>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 leading-tight tracking-tight italic">Almacén de Aparejos</h1>
        <p class="text-nautical-600 mt-6 font-serif italic text-lg leading-relaxed">Selección de materiales probados en nuestras costas. Desde la pesca tradicional a las artes más modernas, con el sello de confianza de FishPot.</p>
      </div>
      
      <router-link to="/carrito" class="flex items-center space-x-6 bg-white p-4 rounded-lg border border-nautical-200 shadow-md group">
        <div class="p-3 bg-primary-950 text-white rounded shadow-lg group-hover:bg-primary-800 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] font-black text-nautical-400 uppercase tracking-widest leading-none mb-1 italic">Su Cesto</span>
          <span class="text-lg font-serif font-black text-primary-950 leading-none italic">{{ cartStore.totalItems }} artículos</span>
        </div>
      </router-link>
    </div>

    <div v-if="loading" class="flex justify-center py-32 bg-white/50 border border-nautical-100 rounded-lg">
      <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-8 w-8 border-2 border-nautical-200 border-t-primary-800 mb-6"></div>
        <p class="text-primary-950 font-serif italic">Preparando el mostrador...</p>
      </div>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
      <div v-for="product in products" :key="product.id" 
           class="nautical-card p-4 group flex flex-col border-b-4 border-primary-100 hover:border-primary-800 transition-all duration-500">
        
        <div class="h-64 bg-nautical-50 rounded mb-6 flex items-center justify-center relative overflow-hidden group-hover:bg-white transition-colors">
           <div v-if="product.stock <= 0" class="absolute inset-0 bg-white/70 z-10 flex items-center justify-center">
              <span class="bg-primary-950 text-white px-5 py-2 font-serif italic text-sm shadow-xl transform -rotate-2">Sin Existencias</span>
           </div>
           
           <div class="w-full h-full p-6 transition-transform duration-700 group-hover:scale-110">
              <img v-if="product.image" :src="'/' + product.image" :alt="product.name" class="w-full h-full object-contain grayscale-[0.2] group-hover:grayscale-0">
              <div v-else class="w-full h-full flex items-center justify-center text-nautical-200 italic font-serif">Equipo</div>
           </div>
           
           <div class="absolute bottom-4 left-4">
             <span class="bg-white/80 px-3 py-1 border border-nautical-100 text-[9px] font-bold text-nautical-400 uppercase tracking-widest italic">
               {{ product.category || 'Equipo' }}
             </span>
           </div>
        </div>

        <div class="flex-grow px-2">
          <h3 class="font-serif font-black text-primary-950 text-xl group-hover:text-primary-800 transition-colors italic mb-2">{{ product.name }}</h3>
          <p class="text-nautical-600 text-sm leading-relaxed font-serif italic line-clamp-2 mb-4">{{ product.description }}</p>
          
          <div class="flex items-center space-x-2">
            <div :class="product.stock < 5 ? 'bg-red-500' : 'bg-primary-700'" class="w-1.5 h-1.5 rounded-full shadow-sm"></div>
            <span class="text-[10px] font-bold text-nautical-300 uppercase tracking-widest italic">
              Existencias: {{ product.stock }}
            </span>
          </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-nautical-100 flex items-center justify-between px-2">
          <div class="flex flex-col">
            <span class="text-[9px] font-bold text-nautical-400 uppercase tracking-widest italic mb-1">Precio</span>
            <span class="text-3xl font-serif font-black text-primary-950 italic tracking-tighter">{{ product.price }}<span class="text-base ml-0.5">€</span></span>
          </div>
          <button 
            @click="addToCart(product)" 
            :disabled="product.stock <= 0"
            :class="product.stock <= 0 ? 'bg-nautical-100 text-nautical-300' : 'bg-primary-950 text-white hover:bg-primary-800 active:translate-y-1 shadow-md'"
            class="p-4 rounded transition-all duration-300"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useCartStore } from '../stores/cart'

const cartStore = useCartStore()
const products = ref([])
const loading = ref(true)

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

onMounted(fetchProducts)

const addToCart = (product) => {
  if (product.stock <= 0) return
  cartStore.addItem(product)
}
</script>
