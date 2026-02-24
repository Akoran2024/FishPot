<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-10">
      <h1 class="text-4xl font-black text-slate-900">Historial de Pedidos</h1>
      <p class="text-slate-700 mt-2 font-medium">Gestiona y revisa todas las ventas realizadas en la tienda.</p>
    </div>

    <!-- Filtros/Stats rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Pedidos</p>
        <h3 class="text-2xl font-black text-slate-900">{{ orders.length }}</h3>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Ingresos Totales</p>
        <h3 class="text-2xl font-black text-primary-600">{{ totalRevenue.toFixed(2) }}€</h3>
      </div>
    </div>

    <!-- Tabla de Pedidos -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-slate-100 border-b border-slate-300">
            <tr>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">ID</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Cliente</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Productos</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Total</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Fecha</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Estado</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-300">
            <tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50 transition">
              <td class="px-6 py-4 font-bold text-slate-500">#{{ order.id }}</td>
              <td class="px-6 py-4">
                <div class="font-bold text-slate-900">{{ order.user?.name }}</div>
                <div class="text-xs text-slate-500">{{ order.user?.email }}</div>
              </td>
              <td class="px-6 py-4">
                <ul class="text-sm text-slate-700">
                  <li v-for="item in order.items" :key="item.id">
                    {{ item.quantity }}x {{ item.product?.name }}
                  </li>
                </ul>
              </td>
              <td class="px-6 py-4 font-black text-primary-900">{{ order.total }}€</td>
              <td class="px-6 py-4 text-sm text-slate-600">
                {{ formatDate(order.created_at) }}
              </td>
              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                  Completado
                </span>
              </td>
            </tr>
            <tr v-if="orders.length === 0">
              <td colspan="6" class="px-6 py-10 text-center text-slate-600 italic">No hay pedidos registrados aún.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const orders = ref([])

const fetchOrders = async () => {
  try {
    const res = await axios.get('/orders-list')
    orders.value = res.data
  } catch (error) {
    console.error('Error fetching orders:', error)
  }
}

const totalRevenue = computed(() => {
  return orders.value.reduce((acc, order) => acc + parseFloat(order.total), 0)
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(fetchOrders)
</script>