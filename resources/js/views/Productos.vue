<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:lg-px-8">
    <div class="mb-10 flex justify-between items-end">
      <div>
        <h1 class="text-4xl font-black text-slate-900">Gestión de Productos</h1>
        <p class="text-slate-700 mt-2 font-medium">Administra el inventario y stock de la tienda.</p>
      </div>
     
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-slate-100 border-b border-slate-300">
            <tr>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Producto</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Categoría</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Precio</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Stock</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest text-right">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-300">
            <tr v-for="product in products" :key="product.id" class="hover:bg-slate-50 transition">
              <td class="px-6 py-4">
                <div class="font-bold text-slate-900">{{ product.name }}</div>
                <div class="text-xs text-slate-500 truncate max-w-xs">{{ product.description }}</div>
              </td>
              <td class="px-6 py-4">
                <span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold text-slate-600 uppercase">{{ product.category || 'Sin Cat.' }}</span>
              </td>
              <td class="px-6 py-4 font-black text-slate-900">{{ product.price }}€</td>
              <td class="px-6 py-4">
                <span :class="product.stock < 5 ? 'text-red-600 font-black' : 'text-slate-700 font-bold'">
                  {{ product.stock }} ud.
                </span>
              </td>
              <td class="px-6 py-4 text-right space-x-3">
                <button @click="openModal(product)" class="text-primary-600 hover:text-primary-800 font-bold text-sm underline">Editar</button>
                <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-800 font-bold text-sm underline">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-300">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
          <h2 class="text-xl font-bold text-slate-900">{{ editingId ? 'Editar Producto' : 'Nuevo Producto' }}</h2>
          <button @click="showModal = false" class="text-slate-600 hover:text-slate-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <form @submit.prevent="saveProduct" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-1">Nombre</label>
            <input v-model="form.name" type="text" required class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition">
          </div>
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-1">Descripción</label>
            <textarea v-model="form.description" class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition" rows="3"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-1">Precio (€)</label>
              <input v-model="form.price" type="number" step="0.01" required class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition">
            </div>
            <div>
              <label class="block text-sm font-bold text-slate-900 mb-1">Stock</label>
              <input v-model="form.stock" type="number" required class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition">
            </div>
          </div>
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-1">Categoría</label>
            <input v-model="form.category" type="text" class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition">
          </div>
          <div class="pt-4 flex space-x-3">
            <button type="button" @click="showModal = false" class="flex-1 px-4 py-2 border-2 border-slate-300 rounded-xl font-bold text-slate-700 hover:bg-slate-100 transition">Cancelar</button>
            <button type="submit" class="flex-1 px-4 py-2 bg-primary-700 text-white rounded-xl font-bold hover:bg-primary-800 transition">Guardar</button>
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