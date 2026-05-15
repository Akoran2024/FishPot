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
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Panel de Cliente</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Mis Pedidos</h1>
        <p class="text-nautical-700 mt-4 font-serif italic text-lg leading-relaxed max-w-2xl">Consulta el historial de tus compras y el estado de tus envíos en tiempo real.</p>
      </div>
      <div class="flex items-center space-x-4">
        <div class="text-right hidden sm:block">
          <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest italic">Última actualización</p>
          <p class="text-sm font-serif font-bold text-primary-900 italic">{{ lastUpdate }}</p>
        </div>
        <button @click="fetchOrders" class="p-4 bg-white border border-nautical-200 rounded-full hover:bg-nautical-50 transition-colors shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
        </button>
      </div>
    </div>

    <!-- Stats Dashboard con Rangos Náuticos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="nautical-card p-6 border-l-4 border-l-primary-800">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Rango Náutico</p>
        <p class="text-2xl font-serif font-black text-primary-950 italic flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
          {{ userRank }}
        </p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-emerald-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Inversión Total</p>
        <p class="text-4xl font-serif font-black text-emerald-700 italic">{{ totalSpent.toFixed(2) }}€</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">En Proceso</p>
        <p class="text-4xl font-serif font-black text-amber-600 italic">{{ processingOrdersCount }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-indigo-600 flex flex-col justify-between">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Herramientas</p>
        <div class="flex space-x-2 mt-2">
          <router-link title="Consultar Mareas" to="/mareas" class="flex-1 text-center py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-600 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest italic border border-indigo-100">Mareas</router-link>
          <router-link title="Explorar Costa" to="/lugares" class="flex-1 text-center py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-600 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest italic border border-indigo-100">Costa</router-link>
        </div>
      </div>
    </div>

    <!-- Main Table Section -->
    <div class="nautical-card overflow-hidden border-t-4 border-t-primary-950 shadow-2xl">
      <div class="p-6 bg-nautical-50 border-b border-nautical-200 flex flex-wrap justify-between items-center gap-4">
        <div class="relative w-full max-w-md">
          <input type="text" v-model="search" placeholder="Buscar por pedido o dirección..." class="w-full pl-10 pr-4 py-2 border border-nautical-300 rounded-lg text-sm font-serif italic outline-none focus:ring-2 focus:ring-primary-500/20">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-nautical-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <div class="flex space-x-2">
          <select v-model="statusFilter" class="px-4 py-2 border border-nautical-300 rounded-lg text-[10px] font-bold uppercase tracking-widest outline-none focus:ring-2 focus:ring-primary-500/20">
            <option value="all">Todos los Estados</option>
            <option value="pending">Pendientes</option>
            <option value="accepted">Aceptados</option>
            <option value="shipped">Enviados</option>
            <option value="completed">Completados</option>
            <option value="cancelled">Rechazados</option>
          </select>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Nº Pedido</th>
              <th class="px-8 py-5">Fecha</th>
              <th class="px-8 py-5">Dirección de Envío</th>   
              <th class="px-8 py-5">Artículos</th>   
              <th class="px-8 py-5">Total</th>       
              <th class="px-8 py-5">Estado</th>
              <th class="px-8 py-5 text-right">Detalles</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200 bg-white/30">
            <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-primary-50 transition-all duration-300 group">
              <td class="px-8 py-6">
                <span class="font-black text-nautical-400 text-sm group-hover:text-primary-800">#{{ order.id }}</span>
              </td>
              <td class="px-8 py-6">
                <p class="text-xs font-bold text-nautical-600 uppercase">{{ formatDate(order.created_at) }}</p>
              </td>
              <td class="px-8 py-6">
                <div class="text-sm text-nautical-700 font-bold max-w-xs truncate">{{ order.shipping_address }}</div>
                <div class="text-[10px] text-nautical-400 uppercase tracking-widest">{{ order.shipping_city }}</div>
              </td>
              <td class="px-8 py-6">
                <div class="flex flex-col space-y-1">
                  <div v-for="item in order.items.slice(0, 2)" :key="item.id" class="inline-flex items-center text-[10px] bg-nautical-50 px-2 py-0.5 rounded border border-nautical-100 text-nautical-700 max-w-max">
                    <span class="font-black mr-1 text-primary-800">{{ item.quantity }}x</span> {{ item.product?.name }}
                  </div>
                  <div v-if="order.items.length > 2" class="text-[8px] font-bold text-nautical-400 uppercase italic pl-1">
                    + {{ order.items.length - 2 }} artículos más
                  </div>
                </div>
              </td>
              <td class="px-8 py-6">
                <span class="font-black text-primary-900 text-xl">{{ order.total }}€</span>
              </td>
              <td class="px-8 py-6">
                <span :class="statusClass(order.status)" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border shadow-sm inline-block">
                  {{ statusText(order.status) }}
                </span>
              </td>
              <td class="px-8 py-6 text-right">
                <button @click="openDetailsModal(order)" class="p-2 text-primary-600 hover:text-primary-900 transition-colors" title="Ver detalles">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div v-if="filteredOrders.length === 0" class="py-24 text-center bg-white/20">
        <svg class="mx-auto h-16 w-16 text-nautical-100 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        <p class="text-nautical-400 font-serif italic text-lg">No tienes pedidos que coincidan con los filtros.</p>
        <button @click="search = ''; statusFilter = 'all'" class="mt-4 text-primary-800 font-serif font-black italic border-b border-primary-200 hover:border-primary-800 transition-all uppercase text-xs tracking-widest">Limpiar filtros</button>
      </div>
    </div>

    <!-- MODAL DE DETALLES DEL PEDIDO CON OPCIÓN DE DESCARGA -->
    <transition name="modal">
      <div v-if="showDetailsModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-primary-950/80 backdrop-blur-md p-4 overflow-y-auto">
        <div id="printable-invoice" class="bg-white rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden border-4 border-white transform transition-all my-8">
          <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50 no-print">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">Detalles del Pedido</h2>
              <p class="text-xs text-nautical-500 font-serif italic uppercase tracking-widest mt-1">Pedido #{{ selectedOrderDetails.id }}</p>
            </div>
            <div class="flex space-x-4">
              <button @click="downloadInvoice" class="flex items-center space-x-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded font-bold text-[10px] uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <span>Factura</span>
              </button>
              <button @click="showDetailsModal = false" class="p-2 bg-white rounded-full text-primary-900 shadow-md hover:scale-110 transition-transform border border-nautical-100">     
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </div>
          
          <div class="p-8 lg:p-12">
            <!-- Header para Impresión (solo visible al imprimir) -->
            <div class="print-only mb-12 border-b-2 border-primary-950 pb-8">
               <div class="flex justify-between items-end">
                  <div>
                    <h1 class="text-4xl font-serif font-black text-primary-950 italic">FISHPOT LANZAROTE</h1>
                    <p class="text-sm font-serif italic text-nautical-600">Cooperativa de Pesca Artesanal · La Santa</p>
                  </div>
                  <div class="text-right">
                    <p class="text-xl font-serif font-black italic">FACTURA #{{ selectedOrderDetails.id }}</p>
                    <p class="text-xs uppercase tracking-widest font-bold">{{ formatDate(selectedOrderDetails.created_at) }}</p>
                  </div>
               </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
              <!-- Información de Envío -->
              <div class="space-y-8">
                <div>
                  <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-3 italic">Destino del Envío</p>
                  <div class="text-sm font-serif italic text-primary-950 space-y-1">
                    <p class="font-bold text-lg">{{ selectedOrderDetails.shipping_address }}</p>
                    <p>{{ selectedOrderDetails.shipping_city }} ({{ selectedOrderDetails.shipping_zip_code }})</p>
                    <p class="uppercase text-[10px] tracking-tighter text-nautical-400">{{ selectedOrderDetails.shipping_country || 'España' }}</p>
                  </div>
                </div>

                <div class="pt-6 border-t border-nautical-100">
                  <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-3 italic">Método de Pago</p>
                  <p class="text-sm font-serif italic font-bold text-primary-900">
                    {{ selectedOrderDetails.payment_method === 'online_payment' ? 'Pago con Tarjeta' : 'Pago al Recibir (Contrareembolso)' }}
                  </p>
                </div>

                <div v-if="selectedOrderDetails.tracking_number" class="pt-6 border-t border-nautical-100">
                  <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-3 italic">Número de Seguimiento</p>
                  <p class="text-lg font-black text-primary-950">{{ selectedOrderDetails.tracking_number }}</p>
                </div>
              </div>

              <!-- Resumen de Productos -->
              <div class="bg-nautical-50 p-8 rounded-2xl border border-nautical-200 flex flex-col h-full">
                <h3 class="text-xs font-black text-primary-900 uppercase tracking-widest flex items-center mb-6">
                  <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                  Artículos Comprados
                </h3>
                
                <div class="flex-grow space-y-4 overflow-y-auto max-h-60 pr-2">
                  <div v-for="item in selectedOrderDetails.items" :key="item.id" class="flex justify-between items-center border-b border-nautical-100 pb-3">
                    <div class="flex-grow">
                      <p class="font-serif font-black text-primary-950 text-base italic leading-tight">{{ item.product?.name }}</p>
                      <p class="text-[10px] text-nautical-400 font-bold uppercase tracking-widest mt-1">{{ item.quantity }} unidades x {{ item.price }}€</p>
                    </div>
                    <span class="font-black text-primary-900 text-lg ml-4">{{ (item.quantity * item.price).toFixed(2) }}€</span>
                  </div>
                </div>

                <div class="mt-8 pt-6 border-t-2 border-dashed border-nautical-300">
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-black uppercase text-nautical-400 italic">Total Pagado</span>
                    <span class="text-3xl font-serif font-black text-primary-950 italic">{{ selectedOrderDetails.total }}€</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-[10px] font-black uppercase text-nautical-400 italic">Estado Actual</span>
                    <span :class="statusClass(selectedOrderDetails.status)" class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border shadow-sm">
                      {{ statusText(selectedOrderDetails.status) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-12 pt-8 border-t border-nautical-100 flex justify-end no-print">
              <button @click="showDetailsModal = false" class="px-8 py-3 bg-primary-950 text-white rounded font-serif italic font-black uppercase text-xs tracking-[0.2em] hover:bg-primary-800 transition-all shadow-xl">
                Cerrar
              </button>
            </div>
            
            <div class="print-only mt-24 text-center border-t border-nautical-100 pt-8">
               <p class="text-[10px] font-black uppercase tracking-[0.5em] text-nautical-400">Gracias por confiar en los marineros de FishPot</p>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useCartStore } from '../stores/cart'
import { useRoute } from 'vue-router'

const cartStore = useCartStore()
const route = useRoute()
const orders = ref([])
const showDetailsModal = ref(false)
const selectedOrderDetails = ref(null)
const search = ref('')
const statusFilter = ref('all')
const lastUpdate = ref(new Date().toLocaleTimeString())

const fetchOrders = async () => {
  try {
    const res = await axios.get('/my-orders')
    orders.value = res.data
    lastUpdate.value = new Date().toLocaleTimeString()
  } catch (error) {
    console.error('Error fetching orders:', error)
  }
}

const userRank = computed(() => {
  const total = totalSpent.value
  if (total >= 1000) return 'Capitán de Flota'
  if (total >= 500) return 'Patrón de Costa'
  if (total >= 100) return 'Grumete'
  return 'Polizón'
})

const filteredOrders = computed(() => {
  let filtered = orders.value
  
  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(o => o.status === statusFilter.value)
  }
  
  if (search.value) {
    const s = search.value.toLowerCase()
    filtered = filtered.filter(o => 
      o.shipping_address.toLowerCase().includes(s) ||
      o.shipping_city.toLowerCase().includes(s) ||
      o.id.toString().includes(s)
    )
  }
  
  return filtered
})

const processingOrdersCount = computed(() => {
  return orders.value.filter(o => ['pending', 'accepted', 'shipped'].includes(o.status)).length
})

const totalSpent = computed(() => {
  return orders.value
    .filter(o => o.status !== 'cancelled')
    .reduce((acc, order) => acc + parseFloat(order.total), 0)
})

const openDetailsModal = (order) => {
  selectedOrderDetails.value = order
  showDetailsModal.value = true
}

const downloadInvoice = () => {
  window.print()
}

const statusClass = (status) => {
  switch (status) {
    case 'pending': return 'bg-amber-50 text-amber-700 border-amber-200'
    case 'accepted': return 'bg-blue-50 text-blue-700 border-blue-200'
    case 'shipped': return 'bg-indigo-50 text-indigo-700 border-indigo-200'
    case 'completed': return 'bg-emerald-50 text-emerald-700 border-emerald-200'
    case 'cancelled': return 'bg-red-50 text-red-700 border-red-200'
    default: return 'bg-slate-50 text-slate-700 border-slate-200'
  }
}

const statusText = (status) => {
  const texts = {
    pending: 'Pendiente',
    accepted: 'Aceptado',
    shipped: 'Enviado',
    completed: 'Completado',
    cancelled: 'Rechazado'
  }
  return texts[status] || status
}

const formatDate = (dateStr) => {
  if (!dateStr) return '--/--/----'
  const date = new Date(dateStr)
  return date.toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' })
}

onMounted(() => {
  fetchOrders()
  if (route.query.payment === 'success') {
    cartStore.clearCart()
  }
})
</script>

<style scoped>
.nautical-card {
  @apply bg-white/80 backdrop-blur-md border border-nautical-200 shadow-xl transition-all duration-300;
}

/* Animations */
.modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .bg-white { animation: modal-in 0.3s ease-out; }

@keyframes modal-in {
  from { transform: scale(0.95) translateY(10px); opacity: 0; }
  to { transform: scale(1) translateY(0); opacity: 1; }
}

/* Print Styles */
@media print {
  .no-print { display: none !important; }
  body * { visibility: hidden; }
  #printable-invoice, #printable-invoice * { visibility: visible; }
  #printable-invoice {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    border: none !important;
    box-shadow: none !important;
  }
  .print-only { display: block !important; }
}

.print-only { display: none; }
</style>
