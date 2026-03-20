<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 border-b border-primary-950/10 pb-8">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1 rounded-full border border-nautical-200 mb-4 shadow-sm">
        <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Ventas y Logística</span>
      </div>
      <h1 class="text-5xl font-serif font-black text-primary-950 italic">Historial de Pedidos</h1>
      <p class="text-nautical-700 mt-2 font-serif italic text-lg leading-relaxed">Registro de capturas comerciales y transacciones de la cofradía.</p>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      <div class="nautical-card p-8 border-b-4 border-b-primary-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-[0.2em] mb-2">Total Pedidos</p>
        <h3 class="text-4xl font-serif font-black text-primary-950 italic">{{ orders.length }}</h3>
      </div>
      <div class="nautical-card p-8 border-b-4 border-b-primary-700">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-[0.2em] mb-2">Ingresos de Flota</p>        
        <h3 class="text-4xl font-serif font-black text-primary-800 italic">{{ totalRevenue.toFixed(2) }}€</h3>
      </div>
    </div>

    <!-- Table Section -->
    <div class="nautical-card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Bitácora (ID)</th>
              <th class="px-8 py-5">Marinero (Cliente)</th>     
              <th class="px-8 py-5">Entrega (Dirección)</th>   
              <th class="px-8 py-5">Aparejos</th>   
              <th class="px-8 py-5">Total</th>       
              <th class="px-8 py-5">Estado</th>
              <th class="px-8 py-5 text-right">Mando</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200">
            <tr v-for="order in orders" :key="order.id" class="hover:bg-primary-50/50 transition-all duration-300">
              <td class="px-8 py-6 font-black text-nautical-400 text-sm">#{{ order.id }}</td>
              <td class="px-8 py-6">
                <div class="font-black text-primary-950 text-lg leading-none">{{ order.user?.name }}</div>
                <div class="text-[10px] text-nautical-500 uppercase tracking-tighter mt-1">{{ order.user?.email }}</div>
              </td>
              <td class="px-8 py-6">
                <div class="text-sm text-nautical-700 font-bold">{{ order.shipping_address }}</div>
                <div class="text-[10px] text-nautical-400 uppercase tracking-widest">{{ order.shipping_city }} ({{ order.shipping_zip_code }})</div>
              </td>
              <td class="px-8 py-6">
                <ul class="text-xs text-nautical-700 font-serif italic space-y-1">
                  <li v-for="item in order.items" :key="item.id" class="flex items-center space-x-2">
                    <span class="w-1 h-1 bg-primary-400 rounded-full"></span>
                    <span>{{ item.quantity }}x {{ item.product?.name }}</span>
                  </li>
                </ul>
              </td>
              <td class="px-8 py-6 font-black text-primary-900 text-xl">{{ order.total }}€</td>
              <td class="px-8 py-6">
                <span :class="statusClass(order.status)" class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border">
                  {{ statusText(order.status) }}
                </span>
              </td>
              <td class="px-8 py-6 text-right space-x-2">
                <template v-if="order.status === 'pending'">
                  <button @click="updateStatus(order.id, 'accept')" class="text-emerald-700 hover:text-emerald-900 font-black text-[10px] uppercase border-b border-emerald-200">Aceptar</button>
                  <button @click="updateStatus(order.id, 'cancel')" class="text-red-700 hover:text-red-900 font-black text-[10px] uppercase border-b border-red-200">Rechazar</button>
                </template>
                <template v-else-if="order.status === 'accepted'">
                  <button @click="openShipModal(order)" class="bg-primary-950 text-white px-3 py-1 rounded text-[10px] font-black uppercase tracking-widest hover:bg-primary-800 transition-all shadow-lg">Enviar</button>
                  <button @click="updateStatus(order.id, 'cancel')" class="text-red-700 hover:text-red-900 font-black text-[10px] uppercase border-b border-red-200">Cancelar</button>
                </template>
                <span v-else class="text-[10px] text-nautical-300 font-bold uppercase tracking-widest">Sin acciones</span>
              </td>
            </tr>
            <tr v-if="orders.length === 0">
              <td colspan="7" class="px-8 py-16 text-center text-nautical-400 italic font-serif text-xl bg-white/30">
                No hay pedidos registrados en el cuaderno de bitácora aún.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MODAL DE ENVÍO (DESPACHO DE MERCANCÍA) -->
    <div v-if="showShipModal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/70 backdrop-blur-sm p-4">
      <div class="bg-white rounded shadow-2xl w-full max-w-lg overflow-hidden border-4 border-double border-nautical-100">
        <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
          <div>
            <h2 class="text-2xl font-serif font-black text-primary-950 italic">Despacho de Mercancía</h2>
            <p class="text-[10px] font-black text-primary-700 uppercase tracking-widest mt-1">Pedido #{{ selectedOrder.id }}</p>
          </div>
          <button @click="showShipModal = false" class="text-primary-900 hover:scale-110 transition-transform">     
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        
        <div class="p-8 space-y-8">
          <!-- Datos del Marinero -->
          <div class="flex items-center space-x-4 pb-6 border-b border-nautical-100">
             <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-900 font-serif font-black italic text-xl">
               {{ selectedOrder.user?.name.charAt(0) }}
             </div>
             <div>
               <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest">Destinatario</p>
               <p class="text-xl font-serif font-black text-primary-950 italic">{{ selectedOrder.user?.name }}</p>
             </div>
          </div>

          <!-- Formulario de Envío Autorrellenado -->
          <div class="space-y-5">
            <h3 class="text-xs font-black text-primary-900 uppercase tracking-widest border-l-4 border-primary-500 pl-3">Hoja de Ruta (Dirección)</h3>
            
            <div class="space-y-4">
              <div>
                <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-1">Dirección de Entrega</label>
                <input type="text" v-model="shipForm.address" class="nautical-input" placeholder="Calle, número, piso...">
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-1">Localidad</label>
                  <input type="text" v-model="shipForm.city" class="nautical-input" placeholder="Ciudad">
                </div>
                <div>
                  <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-1">Código Postal</label>
                  <input type="text" v-model="shipForm.zip" class="nautical-input" placeholder="CP">
                </div>
              </div>
            </div>
          </div>

          <!-- Resumen rápido de Aparejos -->
          <div class="bg-nautical-50 p-4 rounded border border-nautical-100">
            <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-2">Contenido del Bulto</p>
            <ul class="text-xs font-serif italic text-primary-950 space-y-1">
              <li v-for="item in selectedOrder.items" :key="item.id">
                • {{ item.quantity }}x {{ item.product?.name }}
              </li>
            </ul>
          </div>

          <div class="pt-4 flex space-x-3">
            <button @click="showShipModal = false" class="flex-1 px-4 py-3 border border-nautical-300 rounded font-serif italic text-primary-800 hover:bg-nautical-50 transition font-bold">Abortar</button>
            <button @click="confirmShip" class="flex-2 px-8 py-3 bg-primary-950 text-white rounded font-serif italic text-lg hover:bg-primary-800 transition shadow-xl font-black">Confirmar Salida de Mercancía</button>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const orders = ref([])
const showShipModal = ref(false)
const selectedOrder = ref(null)
const shipForm = ref({ address: '', city: '', zip: '' })

const fetchOrders = async () => {
  try {
    const res = await axios.get('/orders-list')
    orders.value = res.data
  } catch (error) {
    console.error('Error fetching orders:', error)
  }
}

const openShipModal = (order) => {
  selectedOrder.value = order
  shipForm.value = {
    address: order.shipping_address,
    city: order.shipping_city,
    zip: order.shipping_zip_code
  }
  showShipModal.value = true
}

const confirmShip = async () => {
  try {
    const res = await axios.patch(`/admin/api/orders/${selectedOrder.value.id}/ship`, {
      shipping_address: shipForm.value.address,
      shipping_city: shipForm.value.city,
      shipping_zip_code: shipForm.value.zip
    })
    
    // Actualizar localmente
    const index = orders.value.findIndex(o => o.id === selectedOrder.value.id)
    if (index !== -1) {
      orders.value[index] = res.data.order
    }
    
    showShipModal.value = false
    alert('¡Despacho confirmado! El pedido ya está en ruta.')
  } catch (error) {
    alert('Error al procesar el envío.')
  }
}

const updateStatus = async (orderId, action) => {
  const confirmMsg = action === 'cancel' ? '¿Estás seguro de rechazar este pedido? Se devolverá el stock.' : `¿Quieres aceptar este pedido?`
  if (!confirm(confirmMsg)) return

  try {
    const res = await axios.patch(`/admin/api/orders/${orderId}/${action}`)
    const index = orders.value.findIndex(o => o.id === orderId)
    if (index !== -1) {
      orders.value[index] = res.data.order
    }
    alert(res.data.message)
  } catch (error) {
    alert('Error al actualizar el estado del pedido.')
  }
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

const totalRevenue = computed(() => {
  return orders.value
    .filter(o => o.status !== 'cancelled')
    .reduce((acc, order) => acc + parseFloat(order.total), 0)
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}

onMounted(fetchOrders)
</script>

<style scoped>
.nautical-card {
  @apply bg-white/50 backdrop-blur-md border border-nautical-200 shadow-2xl transition-all duration-300;
}
.nautical-input {
  @apply w-full px-4 py-3 border border-nautical-300 rounded font-serif italic bg-white focus:ring-4 focus:ring-primary-500/20 outline-none transition shadow-inner;
}
</style>