<template>

  <!-- imagen -->
   <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950 via-primary-900/80 to-transparent z-10"></div>
        <img src="https://www.diariodelanzarote.com/sites/default/files/archivos/2015/Julio%202015/230720-pescador660.jpeg" alt="Fishing Background" class="w-full h-full object-cover">
      </div>


  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
      <div class="animate-fade-in">
        <h2 class="text-accent-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Equipamiento Profesional</h2>
        <h1 class="text-5xl font-black text-slate-900">Tienda de Pesca</h1>
        <p class="text-slate-500 mt-4 font-medium max-w-xl">Solo las mejores marcas y materiales seleccionados por pescadores expertos para tus jornadas en Lanzarote.</p>
      </div>
      
      <div class="flex items-center space-x-4 bg-white/50 backdrop-blur-md p-2 rounded-2xl border border-white shadow-sm">
        <div class="p-2 bg-primary-100 rounded-xl">
          <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">En tu carrito</p>
          <p class="text-sm font-black text-primary-900">{{ cartStore.totalItems }} artículos</p>
        </div>
      </div>
    </div>

    <div v-if="loading" class="flex justify-center py-24 bg-white/50 backdrop-blur-md rounded-[3rem] border border-white">
      <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary-100 border-t-primary-600 mb-4"></div>
        <p class="text-primary-900 font-bold">Cargando catálogo...</p>
      </div>
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      <div v-for="product in products" :key="product.id" 
           class="group bg-white/80 backdrop-blur-sm rounded-[2.5rem] border border-white p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 flex flex-col">
        
        <div class="h-56 bg-slate-50 rounded-[2rem] mb-6 flex items-center justify-center group-hover:bg-primary-50 transition-colors duration-500 relative overflow-hidden">
           <div v-if="product.stock <= 0" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
              <span class="bg-red-600 text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg transform -rotate-12">Agotado</span>
           </div>
           
           <!-- Decorative background for product -->
           <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-primary-100/50 to-transparent"></div>
           
           <!-- Placeholder for product image -->
           <div class="w-full h-full flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
              <svg class="h-20 w-20 text-primary-200 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
           </div>
           
           <div class="absolute bottom-4 left-4">
             <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-widest shadow-sm">
               {{ product.category || 'Equipo' }}
             </span>
           </div>
        </div>

        <div class="flex-grow space-y-3">
          <h3 class="font-black text-slate-900 text-xl group-hover:text-primary-600 transition-colors duration-300">{{ product.name }}</h3>
          <p class="text-slate-500 text-sm leading-relaxed font-medium line-clamp-2">{{ product.description }}</p>
          
          <div class="flex items-center space-x-2 pt-2">
            <div :class="product.stock < 5 ? 'bg-red-500' : 'bg-emerald-500'" class="w-1.5 h-1.5 rounded-full shadow-sm animate-pulse"></div>
            <span :class="product.stock < 5 ? 'text-red-500' : 'text-slate-400'" class="text-[10px] font-black uppercase tracking-[0.2em]">
              Stock: {{ product.stock }} unidades
            </span>
          </div>
        </div>
        
        <div class="mt-8 flex items-center justify-between">
          <div class="flex flex-col">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Precio</span>
            <span class="text-3xl font-black text-primary-950">{{ product.price }}<span class="text-lg text-primary-600">€</span></span>
          </div>
          <button 
            @click="addToCart(product)" 
            :disabled="product.stock <= 0"
            :class="product.stock <= 0 ? 'bg-slate-100 text-slate-300 cursor-not-allowed' : 'bg-accent-500 hover:bg-accent-400 text-primary-950 shadow-lg shadow-accent-950/10 active:scale-95'"
            class="p-4 rounded-2xl transition-all duration-300 transform"
            title="Añadir al carrito"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!loading && products.length === 0" class="text-center py-32 bg-white/50 backdrop-blur-md rounded-[3rem] border-2 border-dashed border-white">
      <p class="text-slate-400 font-bold text-lg">Estamos reponiendo nuestro inventario.</p>
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
    if (res.data && res.data.length > 0) {
      products.value = res.data
    } else {
      useFallbackProducts()
    }
  } catch (error) {
    console.error('Error cargando productos, usando respaldo:', error)
    useFallbackProducts()
  } finally {
    loading.value = false
  }
}

const useFallbackProducts = () => {
  products.value = [
    { id: 1, name: 'Caña de Carbono X1', description: 'Cargada desde respaldo local', price: 129, stock: 10, category: 'Cañas' },
    { id: 2, name: 'Carrete Silver Stream', description: 'Cargada desde respaldo local', price: 89, stock: 5, category: 'Carretes' },
    { id: 3, name: 'Kit de Señuelos Rapala', description: 'Cargada desde respaldo local', price: 45, stock: 0, category: 'Señuelos' }
  ]
}

onMounted(fetchProducts)

const addToCart = (product) => {
  if (product.stock <= 0) {
    alert('Lo sentimos, no queda stock de este producto')
    return
  }
  cartStore.addItem(product)
  alert(`${product.name} añadido al carrito`)
}
</script>
