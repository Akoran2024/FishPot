<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <!-- Header -->
    <div class="mb-12 border-b border-primary-950/10 pb-10">
      <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full border border-nautical-200 mb-4 shadow-sm">
        <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Panel de Control</span>
      </div>
      <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Bitácora General</h1>
      <p class="text-nautical-700 mt-4 font-serif italic text-lg max-w-2xl">Resumen ejecutivo de la actividad comercial y estado de la flota.</p>
    </div>

    <!-- Stats Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="nautical-card p-6 border-l-4 border-l-primary-800">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Ventas Totales</p>
        <p class="text-4xl font-serif font-black text-primary-950 italic">{{ stats.totalRevenue.toFixed(2) }}€</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-emerald-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Pedidos Hoy</p>
        <p class="text-4xl font-serif font-black text-emerald-700 italic">{{ stats.ordersToday }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Alertas Stock</p>
        <p class="text-4xl font-serif font-black text-amber-600 italic">{{ stats.stockAlerts }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-indigo-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Socios Activos</p>
        <p class="text-4xl font-serif font-black text-indigo-700 italic">{{ stats.totalUsers }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Recent Activity -->
      <div class="lg:col-span-2 nautical-card overflow-hidden flex flex-col h-full">
        <div class="p-6 bg-nautical-50 border-b border-nautical-200 flex justify-between items-center">
          <h3 class="text-xs font-black text-primary-950 uppercase tracking-widest italic flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Últimos Movimientos
          </h3>
          <router-link to="/admin/pedidos" class="text-[10px] font-bold text-primary-700 hover:text-primary-950 uppercase tracking-tighter transition-colors">Ver todos</router-link>
        </div>
        <div class="flex-grow p-0">
          <div v-if="loading" class="p-8 space-y-4">
            <div v-for="i in 5" :key="i" class="h-12 skeleton w-full rounded"></div>
          </div>
          <div v-else class="divide-y divide-nautical-100">
            <div v-for="order in recentOrders" :key="order.id" class="p-6 hover:bg-primary-50 transition-colors flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center text-primary-900 font-serif font-black italic">
                  {{ order.user?.name.charAt(0) }}
                </div>
                <div>
                  <p class="font-serif font-black text-primary-950 italic leading-none">{{ order.user?.name }}</p>
                  <p class="text-[10px] text-nautical-400 uppercase tracking-widest mt-1">Pedido #{{ order.id }} · {{ formatDate(order.created_at) }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-serif font-black text-primary-950 italic">{{ order.total }}€</p>
                <span class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-nautical-200 bg-white">
                  {{ order.status }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions / Alerts -->
      <div class="space-y-6">
        <div class="nautical-card p-8 bg-primary-950 text-white border-none shadow-2xl relative overflow-hidden">
          <div class="relative z-10">
            <h3 class="text-[10px] font-black text-primary-400 uppercase tracking-[0.3em] mb-6 italic">Acciones de Mando</h3>
            <div class="grid grid-cols-1 gap-4">
              <router-link to="/admin/productos" class="flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-lg transition-all group border border-white/5">
                <span class="font-serif italic font-bold">Añadir Inventario</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              </router-link>
              <router-link to="/admin/usuarios" class="flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-lg transition-all group border border-white/5">
                <span class="font-serif italic font-bold">Gestionar Socios</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
              </router-link>
            </div>
          </div>
          <!-- Background image for style -->
          <img :src="'/imagenes/Vieja.png'" class="absolute -bottom-10 -right-10 h-48 opacity-10 rotate-12 pointer-events-none" />
        </div>

        <div v-if="lowStockProducts.length > 0" class="nautical-card p-6 border-l-4 border-l-red-500 bg-red-50/30">
          <h3 class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-4 italic">Alerta de Almacén</h3>
          <div class="space-y-3">
            <div v-for="prod in lowStockProducts.slice(0, 3)" :key="prod.id" class="flex justify-between items-center text-sm">
              <span class="font-serif italic text-primary-950">{{ prod.name }}</span>
              <span class="font-black text-red-700">{{ prod.stock }} ud.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import axios from 'axios'

const loading = ref(true)
const recentOrders = ref([])
const lowStockProducts = ref([])
const stats = reactive({
  totalRevenue: 0,
  ordersToday: 0,
  stockAlerts: 0,
  totalUsers: 0
})

const fetchData = async () => {
  try {
    const [ordersRes, productsRes, usersRes] = await Promise.all([
      axios.get('/orders-list'),
      axios.get('/products-list'),
      axios.get('/admin/users-list')
    ])

    recentOrders.value = ordersRes.data.slice(0, 5)
    
    // Stats calculation
    stats.totalRevenue = ordersRes.data
      .filter(o => o.status !== 'cancelled')
      .reduce((acc, o) => acc + parseFloat(o.total), 0)
    
    const today = new Date().toISOString().split('T')[0]
    stats.ordersToday = ordersRes.data.filter(o => o.created_at.startsWith(today)).length
    
    lowStockProducts.value = productsRes.data.filter(p => p.stock < 5)
    stats.stockAlerts = lowStockProducts.value.length
    
    stats.totalUsers = usersRes.data.length

  } catch (error) {
    console.error('Error fetching dashboard data:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (dateStr) => {
  const date = new Date(dateStr)
  return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })
}

onMounted(fetchData)
</script>
