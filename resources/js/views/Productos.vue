<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-primary-950/10 pb-10">
      <div>
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full border border-nautical-200 mb-4 shadow-sm">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
          </span>
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Panel de Control · Inventario</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Gestión de Almacén</h1>
        <p class="text-nautical-700 mt-4 font-serif italic text-lg leading-relaxed max-w-2xl">Supervise el catálogo de aparejos, controle los niveles de existencias y actualice los registros del puerto en tiempo real.</p>
      </div>
      <button @click="openModal()" class="group relative px-10 py-4 bg-primary-950 text-white font-serif italic text-lg hover:bg-primary-800 transition-all shadow-2xl font-black overflow-hidden">
        <span class="relative z-10 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
          Registrar Nuevo Aparejo
        </span>
        <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
      </button>
    </div>

    <!-- Stats Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="nautical-card p-6 border-l-4 border-l-primary-800">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Total Productos</p>
        <p class="text-4xl font-serif font-black text-primary-950 italic">{{ products.length }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Stock Bajo (< 10)</p>
        <p class="text-4xl font-serif font-black text-amber-600 italic">{{ lowStockCount }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-emerald-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Valor Inventario</p>
        <p class="text-4xl font-serif font-black text-emerald-700 italic">{{ inventoryValue }}€</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-indigo-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Categorías</p>
        <p class="text-4xl font-serif font-black text-indigo-700 italic">{{ uniqueCategories }}</p>
      </div>
    </div>

    <!-- Main Table Section -->
    <div class="nautical-card overflow-hidden border-t-4 border-t-primary-950 shadow-2xl">
      <div class="p-6 bg-nautical-50 border-b border-nautical-200 flex justify-between items-center">
        <div class="relative w-full max-w-md">
          <input type="text" v-model="search" placeholder="Filtrar por nombre o categoría..." class="w-full pl-10 pr-4 py-2 border border-nautical-300 rounded-lg text-sm font-serif italic outline-none focus:ring-2 focus:ring-primary-500/20">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-nautical-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <div class="flex items-center space-x-2 text-[10px] font-bold text-nautical-500 uppercase tracking-widest">
          <span>Mostrando {{ filteredProducts.length }} aparejos</span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Imagen</th>    
              <th class="px-8 py-5">Aparejo / Detalles</th>    
              <th class="px-8 py-5">Categoría</th>  
              <th class="px-8 py-5">Precio Unit.</th>      
              <th class="px-8 py-5 text-center">Estado Stock</th>       
              <th class="px-8 py-5 text-right">Gestión</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200 bg-white/30">
            <tr v-for="product in filteredProducts" :key="product.id" class="hover:bg-primary-50 transition-all duration-300 group">
              <td class="px-8 py-4">
                <div class="h-16 w-16 rounded-lg overflow-hidden border-2 border-white shadow-md bg-nautical-100 flex-shrink-0">
                  <img v-if="product.image" :src="formatImagePath(product.image)" :alt="product.name" class="w-full h-full object-cover">
                  <div v-else class="w-full h-full flex items-center justify-center text-nautical-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6">
                <div class="font-black text-primary-950 text-lg group-hover:text-primary-700 transition-colors">{{ product.name }}</div>
                <div class="text-xs text-nautical-500 line-clamp-1 max-w-xs">{{ product.description }}</div>
              </td>
              <td class="px-8 py-6">
                <span class="px-3 py-1 rounded-full text-[9px] font-bold text-primary-900 bg-primary-100 border border-primary-200 uppercase tracking-widest">{{ product.category || 'Sin Categoría' }}</span>
              </td>
              <td class="px-8 py-6">
                <span class="font-black text-primary-950 text-xl">{{ product.price }}€</span>
              </td>
              <td class="px-8 py-6 text-center">
                <div class="flex flex-col items-center group/stock">
                  <span :class="getStockClass(product.stock)" class="px-4 py-1.5 rounded-full text-[10px] font-black border uppercase tracking-tighter transition-all group-hover/stock:scale-105">      
                    {{ product.stock }} unidades
                  </span>
                  <span class="text-[8px] mt-1 font-bold text-nautical-400 uppercase">{{ getStockLabel(product.stock) }}</span>
                  
                  <!-- Quick Repose Button -->
                  <button 
                    @click="reposeStock(product)" 
                    :disabled="reposeLoading === product.id"
                    class="mt-3 opacity-0 group-hover/stock:opacity-100 transition-all flex items-center space-x-1 px-3 py-1 bg-emerald-600 text-white text-[9px] font-black uppercase tracking-widest rounded hover:bg-emerald-700 shadow-lg active:scale-95 disabled:opacity-50"
                  >
                    <svg v-if="reposeLoading !== product.id" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    <svg v-else class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Reponer +10</span>
                  </button>
                </div>
              </td>
              <td class="px-8 py-6 text-right">
                <div class="flex justify-end space-x-2">
                  <button @click="openModal(product)" class="p-2 text-primary-700 hover:bg-primary-100 rounded-lg transition-colors" title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                  </button>
                  <button @click="deleteProduct(product.id)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div v-if="filteredProducts.length === 0" class="py-20 text-center bg-white/20">
        <svg class="mx-auto h-12 w-12 text-nautical-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
        <p class="text-nautical-400 font-serif italic text-lg">No se han encontrado aparejos con ese nombre.</p>
      </div>
    </div>

    <!-- Enhanced Modal -->
    <transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-primary-950/80 backdrop-blur-md p-4 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden border-4 border-white transform transition-all my-8">     
          <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">{{ editingId ? 'Actualizar Bitácora' : 'Nuevo Registro de Aparejo' }}</h2>
              <p class="text-xs text-nautical-500 font-serif italic uppercase tracking-widest mt-1">{{ editingId ? 'ID de Producto: #' + editingId : 'Añadiendo artículo al inventario local' }}</p>
            </div>
            <button @click="showModal = false" class="p-2 bg-white rounded-full text-primary-900 shadow-md hover:scale-110 transition-transform border border-nautical-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
          
          <form @submit.prevent="saveProduct" class="p-0">
            <div class="flex flex-col lg:flex-row">
              <!-- Left Column: Form -->
              <div class="flex-1 p-8 lg:p-12 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Nombre Comercial del Aparejo</label>
                    <input v-model="form.name" type="text" required class="nautical-input" placeholder="Ej: Caña de Carbono Pro">
                  </div>
                  
                  <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Descripción Detallada</label>
                    <textarea v-model="form.description" class="nautical-input" rows="4" placeholder="Especificaciones técnicas y recomendaciones de uso..."></textarea>
                  </div>

                  <div>
                    <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Precio de Venta (€)</label>
                    <div class="relative">
                      <input v-model="form.price" type="number" step="0.01" required class="nautical-input pl-10 font-black text-xl">
                      <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary-400 font-serif italic text-lg">€</span>
                    </div>
                  </div>

                  <div>
                    <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Existencias Actuales</label>
                    <input v-model="form.stock" type="number" required class="nautical-input font-black text-xl text-primary-600">
                  </div>

                  <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Categoría del Producto</label>
                    <select v-model="form.category" class="nautical-input bg-white appearance-none">
                      <option value="">Seleccione categoría...</option>
                      <option value="Cañas">Cañas</option>
                      <option value="Carretes">Carretes</option>
                      <option value="Cebos">Cebos</option>
                      <option value="Accesorios">Accesorios</option>
                      <option value="Ropa">Ropa</option>
                      <option value="Varios">Varios</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Right Column: Image and Actions -->
              <div class="w-full lg:w-80 bg-nautical-50 p-8 lg:p-12 flex flex-col items-center border-l border-nautical-100">
                <label class="block w-full text-[10px] font-black text-primary-800 uppercase tracking-widest mb-6 text-center">Imagen de Referencia</label>
                
                <div class="w-full aspect-square bg-white rounded-xl shadow-inner border-2 border-dashed border-nautical-300 overflow-hidden flex flex-col items-center justify-center mb-8 relative group">
                  <img v-if="form.image" :src="formatImagePath(form.image)" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                  <div v-else class="text-center p-4">
                    <svg class="mx-auto h-12 w-12 text-nautical-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span class="text-[10px] font-bold text-nautical-300 uppercase tracking-tighter">Sin imagen asignada</span>
                  </div>
                </div>

                <div class="w-full space-y-4">
                  <div>
                    <label class="block text-[10px] font-black text-primary-400 uppercase tracking-widest mb-2">URL de la Imagen</label>
                    <input v-model="form.image" type="text" class="nautical-input py-2 text-xs" placeholder="https://...">
                  </div>

                  <div class="pt-8 space-y-3">
                    <button type="submit" class="w-full px-6 py-4 bg-primary-950 text-white rounded shadow-xl font-serif italic text-lg hover:bg-primary-800 transition-all font-black flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                      {{ editingId ? 'Guardar Cambios' : 'Confirmar Registro' }}
                    </button>
                    <button type="button" @click="showModal = false" class="w-full px-6 py-3 bg-white border border-nautical-200 text-nautical-600 rounded font-serif italic text-sm hover:bg-nautical-50 transition-all">
                      Cancelar operación
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const products = ref([])
const showModal = ref(false)
const editingId = ref(null)
const search = ref('')
const reposeLoading = ref(null)
const form = ref({ name: '', description: '', price: 0, stock: 0, category: '', image: '' })

// Computed properties for dashboard
const lowStockCount = computed(() => products.value.filter(p => p.stock < 10).length)
const inventoryValue = computed(() => products.value.reduce((acc, p) => acc + (p.price * p.stock), 0).toLocaleString('de-DE', { minimumFractionDigits: 2 }))
const uniqueCategories = computed(() => new Set(products.value.map(p => p.category).filter(Boolean)).size)

const filteredProducts = computed(() => {
  if (!search.value) return products.value
  const s = search.value.toLowerCase()
  return products.value.filter(p => 
    p.name.toLowerCase().includes(s) || 
    (p.category && p.category.toLowerCase().includes(s))
  )
})

const formatImagePath = (path) => {
  if (!path) return null
  if (path.startsWith('http') || path.startsWith('/')) return path
  return '/' + path
}

const fetchProducts = async () => {
  try {
    const res = await axios.get('/products-list')
    products.value = res.data.map(p => ({
      ...p,
      image: formatImagePath(p.image)
    }))
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

const getStockClass = (stock) => {
  if (stock <= 5) return 'bg-red-50 text-red-600 border-red-200'
  if (stock <= 15) return 'bg-amber-50 text-amber-600 border-amber-200'
  return 'bg-emerald-50 text-emerald-600 border-emerald-200'
}

const getStockLabel = (stock) => {
  if (stock <= 5) return 'Crítico'
  if (stock <= 15) return 'Limitado'
  return 'Óptimo'
}

const openModal = (product = null) => {
  if (product) {
    editingId.value = product.id
    form.value = { ...product }
  } else {
    editingId.value = null
    form.value = { name: '', description: '', price: 0, stock: 0, category: '', image: '' }
  }
  showModal.value = true
}

const reposeStock = async (product) => {
  reposeLoading.value = product.id
  try {
    const newStock = product.stock + 10
    await axios.put(`/products/${product.id}`, {
      ...product,
      stock: newStock
    })
    product.stock = newStock
  } catch (error) {
    console.error('Error reponiendo stock:', error)
    alert('No se pudo actualizar el stock.')
  } finally {
    reposeLoading.value = null
  }
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
  if (confirm('¿Está seguro de que desea eliminar este aparejo del inventario? Esta acción no se puede deshacer.')) {
    try {
      await axios.delete(`/products/${id}`)
      fetchProducts()
    } catch (error) {
      alert('Error al eliminar el producto.')
    }
  }
}

onMounted(fetchProducts)
</script>

<style scoped>
.nautical-card {
  @apply bg-white/80 backdrop-blur-md border border-nautical-200 shadow-xl transition-all duration-300;
}
.nautical-input {
  @apply w-full px-4 py-3 border border-nautical-300 rounded font-serif italic bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none transition-all shadow-sm;
}

/* Animations */
.modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .bg-white { animation: modal-in 0.3s ease-out; }

@keyframes modal-in {
  from { transform: scale(0.95) translateY(10px); opacity: 0; }
  to { transform: scale(1) translateY(0); opacity: 1; }
}
</style>
