<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex justify-between items-end border-b border-primary-950/10 pb-8">
      <div>
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1 rounded-full border border-nautical-200 mb-4 shadow-sm">
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Inventario</span>
        </div>
        <h1 class="text-5xl font-serif font-black text-primary-950 italic">Gestión de Productos</h1>
        <p class="text-nautical-700 mt-2 font-serif italic text-lg leading-relaxed">Controla el stock y los aparejos del almacén.</p>
      </div>
      <button @click="openModal()" class="px-8 py-3 bg-primary-950 text-white font-serif italic text-lg hover:bg-primary-800 transition-all shadow-xl font-black">
        + Nuevo Aparejo
      </button>
    </div>

    <!-- Table Section -->
    <div class="nautical-card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Aparejo / Producto</th>    
              <th class="px-8 py-5">Categoría</th>  
              <th class="px-8 py-5">Precio</th>      
              <th class="px-8 py-5 text-center">Stock Disponible</th>       
              <th class="px-8 py-5 text-right">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200">
            <tr v-for="product in products" :key="product.id" class="hover:bg-primary-50/50 transition-all duration-300">
              <td class="px-8 py-6">
                <div class="font-black text-primary-950 text-lg">{{ product.name }}</div>
                <div class="text-xs text-nautical-500 truncate max-w-xs">{{ product.description }}</div>
              </td>
              <td class="px-8 py-6">
                <span class="bg-nautical-100 px-3 py-1 rounded text-[10px] font-bold text-nautical-700 uppercase tracking-widest border border-nautical-200">{{ product.category || 'Varios' }}</span>
              </td>
              <td class="px-8 py-6 font-black text-primary-950 text-xl">{{ product.price }}€</td>
              <td class="px-8 py-6 text-center">
                <span :class="product.stock < 5 ? 'bg-red-100 text-red-700 border-red-200' : 'bg-primary-50 text-primary-800 border-primary-100'"
                      class="px-4 py-1 rounded-full text-xs font-black border">      
                  {{ product.stock }} ud.
                </span>
              </td>
              <td class="px-8 py-6 text-right space-x-4">
                <button @click="openModal(product)" class="text-primary-700 hover:text-primary-950 font-black text-sm uppercase tracking-tighter border-b-2 border-primary-200 hover:border-primary-700 transition-all">Editar</button>
                <button @click="deleteProduct(product.id)" class="text-red-700 hover:text-red-950 font-black text-sm uppercase tracking-tighter transition-all">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal con Estilo Náutico -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/70 backdrop-blur-sm p-4">
      <div class="bg-white/95 backdrop-blur-md rounded shadow-2xl w-full max-w-md overflow-hidden border border-nautical-200">     
        <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
          <h2 class="text-2xl font-serif font-black text-primary-950 italic">{{ editingId ? 'Editar Aparejo' : 'Nuevo Aparejo' }}</h2>
          <button @click="showModal = false" class="text-primary-900 hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <form @submit.prevent="saveProduct" class="p-8 space-y-5">
          <div>
            <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Nombre del Producto</label>
            <input v-model="form.name" type="text" required class="nautical-input">
          </div>
          <div>
            <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Descripción (Bitácora)</label>
            <textarea v-model="form.description" class="nautical-input" rows="3"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Precio (€)</label>
              <input v-model="form.price" type="number" step="0.01" required class="nautical-input font-black text-lg">
            </div>
            <div>
              <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Stock Actual</label>
              <input v-model="form.stock" type="number" required class="nautical-input font-black text-lg text-primary-600">
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Categoría</label>
            <input v-model="form.category" type="text" class="nautical-input">
          </div>
          <div class="pt-6 flex space-x-3">
            <button type="button" @click="showModal = false" class="flex-1 px-4 py-3 border border-nautical-300 rounded font-serif italic text-primary-800 hover:bg-nautical-50 transition font-bold">Cancelar</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-primary-950 text-white rounded font-serif italic text-lg hover:bg-primary-800 transition shadow-xl font-black">Guardar en Almacén</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])
const showModal = ref(false)
const editingId = ref(null)
const form = ref({ name: '', description: '', price: 0, stock: 0, category: '' })

const fetchProducts = async () => {
  const res = await axios.get('/products-list')
  products.value = res.data
}

const openModal = (product = null) => {
  if (product) {
    editingId.value = product.id
    form.value = { ...product }
  } else {
    editingId.value = null
    form.value = { name: '', description: '', price: 0, stock: 0, category: '' }
  }
  showModal.value = true
}

const saveProduct = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/products/${editingId.value}`, form.value)
    } else {
      await axios.post('/products', form.value)
    }
    showModal.value = false
    fetchProducts()
  } catch (error) {
    alert('Error al guardar el producto.')
  }
}

const deleteProduct = async (id) => {
  if (confirm('¿Eliminar este producto?')) {
    await axios.delete(`/products/${id}`)
    fetchProducts()
  }
}

onMounted(fetchProducts)
</script>

<style scoped>
.nautical-card {
  @apply bg-white/50 backdrop-blur-md border border-nautical-200 shadow-2xl transition-all duration-300;
}
.nautical-input {
  @apply w-full px-4 py-3 border border-nautical-300 rounded font-serif italic bg-white focus:ring-4 focus:ring-primary-500/20 outline-none transition shadow-inner;
}
</style>