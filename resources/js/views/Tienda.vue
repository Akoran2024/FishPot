<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-12">
      <h1 class="text-4xl font-black text-slate-900">Tienda de Pesca</h1>
      <p class="text-slate-500 mt-2">Equipamiento profesional para tus días de pesca.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="product in products" :key="product.id" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col">
        <div class="h-48 bg-slate-50 rounded-xl mb-4 flex items-center justify-center group overflow-hidden">
           <!-- Placeholder for product image -->
           <div class="w-full h-full bg-blue-50 flex items-center justify-center transition group-hover:scale-110">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
           </div>
        </div>
        <h3 class="font-bold text-slate-800 text-lg">{{ product.name }}</h3>
        <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ product.description }}</p>
        
        <div class="mt-auto flex items-center justify-between">
          <span class="text-2xl font-black text-blue-900">{{ product.price }}€</span>
          <button @click="addToCart(product)" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition shadow-md shadow-blue-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../stores/cart'

const cartStore = useCartStore()

const products = [
  { id: 1, name: 'Caña de Carbono X1', description: 'Ligera y ultra resistente para spinning.', price: 129, category: 'Cañas' },
  { id: 2, name: 'Carrete Silver Stream', description: '7+1 rodamientos, freno de 12kg.', price: 89, category: 'Carretes' },
  { id: 3, name: 'Kit de Señuelos Rapala', description: 'Pack de 5 señuelos para agua salada.', price: 45, category: 'Señuelos' },
  { id: 4, name: 'Línea Trenzada 0.20mm', description: '300 metros de máxima resistencia.', price: 24, category: 'Líneas' },
  { id: 5, name: 'Vadeador Neopreno', description: '4mm de espesor, bota reforzada.', price: 155, category: 'Ropa' },
  { id: 6, name: 'Caja de Pesca XL', description: '3 compartimentos móviles, estanca.', price: 38, category: 'Accesorios' },
]

const addToCart = (product) => {
  cartStore.addItem(product)
  alert(`${product.name} añadido al carrito`)
}
</script>
