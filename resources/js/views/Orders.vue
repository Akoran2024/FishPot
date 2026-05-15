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
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Logística de Flota</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Historial de Bitácora</h1>
        <p class="text-nautical-700 mt-4 font-serif italic text-lg leading-relaxed max-w-2xl">Registro detallado de transacciones, despachos y capturas comerciales de la cofradía.</p>
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

    <!-- Stats Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="nautical-card p-6 border-l-4 border-l-primary-800">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Volumen de Carga</p>
        <p class="text-4xl font-serif font-black text-primary-950 italic">{{ orders.length }} <span class="text-xs uppercase tracking-tighter text-nautical-400">pedidos</span></p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-emerald-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Ingresos de Flota</p>
        <p class="text-4xl font-serif font-black text-emerald-700 italic">{{ totalRevenue.toFixed(2) }}€</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Pendientes de Despacho</p>
        <p class="text-4xl font-serif font-black text-amber-600 italic">{{ pendingOrdersCount }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-indigo-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Ticket Promedio</p>
        <p class="text-4xl font-serif font-black text-indigo-700 italic">{{ averageOrderValue.toFixed(2) }}€</p>
      </div>
    </div>

    <!-- Main Table Section -->
    <div class="nautical-card overflow-hidden border-t-4 border-t-primary-950 shadow-2xl">
      <div class="p-6 bg-nautical-50 border-b border-nautical-200 flex flex-wrap justify-between items-center gap-4">
        <div class="relative w-full max-w-md">
          <input type="text" v-model="search" placeholder="Buscar por marinero o dirección..." class="w-full pl-10 pr-4 py-2 border border-nautical-300 rounded-lg text-sm font-serif italic outline-none focus:ring-2 focus:ring-primary-500/20">
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
              <th class="px-8 py-5">Bitácora</th>
              <th class="px-8 py-5">Marinero (Cliente)</th>     
              <th class="px-8 py-5">Destino (Entrega)</th>   
              <th class="px-8 py-5">Aparejos</th>   
              <th class="px-8 py-5">Total</th>       
              <th class="px-8 py-5">Estado Actual</th>
              <th class="px-8 py-5 text-right">Mando</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200 bg-white/30">
            <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-primary-50 transition-all duration-300 group">
              <td class="px-8 py-6 cursor-pointer" @click="openDetailsModal(order)">
                <span class="font-black text-nautical-400 text-sm group-hover:text-primary-800">#{{ order.id }}</span>
                <p class="text-[8px] font-bold text-nautical-300 uppercase mt-1">{{ formatDate(order.created_at) }}</p>
              </td>
              <td class="px-8 py-6 cursor-pointer" @click="openDetailsModal(order)">
                <div class="flex items-center space-x-3">
                  <div class="h-10 w-10 bg-primary-100 rounded-lg flex items-center justify-center text-primary-900 font-serif font-black italic shadow-sm group-hover:scale-110 transition-transform">
                    {{ order.user?.name.charAt(0) }}
                  </div>
                  <div>
                    <div class="font-black text-primary-950 text-lg leading-none group-hover:text-primary-700 transition-colors">{{ order.user?.name }}</div>
                    <div class="text-[10px] text-nautical-500 uppercase tracking-tighter mt-1">{{ order.user?.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6">
                <div class="text-sm text-nautical-700 font-bold max-w-xs truncate">{{ order.shipping_address }}</div>
                <div class="text-[10px] text-nautical-400 uppercase tracking-widest">{{ order.shipping_city }} ({{ order.shipping_zip_code }})</div>
              </td>
              <td class="px-8 py-6">
                <div class="flex flex-col space-y-1">
                  <div v-for="item in order.items" :key="item.id" class="inline-flex items-center text-[10px] bg-nautical-50 px-2 py-0.5 rounded border border-nautical-100 text-nautical-700 max-w-max">
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
                <div class="flex justify-end space-x-3">
                  <button @click="openDetailsModal(order)" class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Ver Bitácora">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                  </button>
                  <template v-if="order.status === 'pending'">
                    <button @click="updateStatus(order.id, 'accept')" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">Aceptar</button>
                    <button @click="updateStatus(order.id, 'cancel')" class="px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded text-[9px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm">Rechazar</button>
                  </template>
                  <template v-else-if="order.status === 'accepted'">
                    <button @click="openShipModal(order)" class="px-6 py-1.5 bg-primary-950 text-white rounded text-[10px] font-black uppercase tracking-widest hover:bg-primary-800 transition-all shadow-xl">Despachar</button>
                    <button @click="updateStatus(order.id, 'cancel')" class="p-1.5 text-red-400 hover:text-red-700 transition-colors" title="Cancelar">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </button>
                  </template>
                  <span v-else class="text-[10px] text-nautical-300 font-bold uppercase tracking-widest italic pr-4">Bitácora Cerrada</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div v-if="filteredOrders.length === 0" class="py-24 text-center bg-white/20">
        <svg class="mx-auto h-16 w-16 text-nautical-100 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        <p class="text-nautical-400 font-serif italic text-lg">No se han encontrado registros en este cuadrante del historial.</p>
        <button @click="search = ''; statusFilter = 'all'" class="mt-4 text-primary-800 font-serif font-black italic border-b border-primary-200 hover:border-primary-800 transition-all uppercase text-xs tracking-widest">Limpiar filtros</button>
      </div>
    </div>

    <!-- MODAL DE ENVÍO -->
    <transition name="modal">
      <div v-if="showShipModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-primary-950/80 backdrop-blur-md p-4 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl overflow-hidden border-4 border-white transform transition-all my-8">
          <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">Despacho de Mercancía</h2>
              <p class="text-xs text-nautical-500 font-serif italic uppercase tracking-widest mt-1">Hoja de ruta · Pedido #{{ selectedOrder.id }}</p>
            </div>
            <button @click="showShipModal = false" class="p-2 bg-white rounded-full text-primary-900 shadow-md hover:scale-110 transition-transform border border-nautical-100">     
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
          
          <div class="p-8 lg:p-12 space-y-10">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-8 border-b border-nautical-100">
               <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center text-primary-900 font-serif font-black italic text-4xl shadow-inner border border-primary-200">
                 {{ selectedOrder.user?.name.charAt(0) }}
               </div>
               <div class="text-center sm:text-left">
                 <p class="text-[10px] font-black text-nautical-400 uppercase tracking-[0.2em] mb-1">Consignatario</p>
                 <p class="text-3xl font-serif font-black text-primary-950 italic mb-1">{{ selectedOrder.user?.name }}</p>
                 <p class="text-sm font-serif italic text-primary-700">{{ selectedOrder.user?.email }}</p>
               </div>
            </div>

            <div class="space-y-6">
              <h3 class="text-xs font-black text-primary-900 uppercase tracking-widest flex items-center">
                <span class="w-8 h-px bg-primary-300 mr-3"></span>
                Destino del Cargamento
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-2">Dirección de Entrega</label>
                  <input type="text" v-model="shipForm.address" class="nautical-input" placeholder="Ej: Calle del Muelle, 12">
                </div>
                <div>
                  <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-2">Localidad / Puerto</label>
                  <input type="text" v-model="shipForm.city" class="nautical-input" placeholder="Ej: Arrecife">
                </div>
                <div>
                  <label class="block text-[10px] font-black text-nautical-500 uppercase tracking-widest mb-2">Distrito Postal</label>
                  <input type="text" v-model="shipForm.zip" class="nautical-input" placeholder="Ej: 35500">
                </div>
              </div>
            </div>

            <div class="bg-primary-50 p-6 rounded-xl border border-primary-100 relative overflow-hidden">
              <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="h-20 w-20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8l-8 5-8-5V6l8 5 8-5m0-2H4c-1.11 0-2 .89-2 2v12a2 2 0 002 2h16a2 2 0 002-2V4a2 2 0 00-2-2z"/></svg>
              </div>
              <p class="text-[10px] font-black text-primary-800 uppercase tracking-widest mb-4 flex items-center">
                <svg class="h-3 w-3 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Contenido del Bulto
              </p>
              <ul class="text-sm font-serif italic text-primary-950 space-y-2 relative z-10">
                <li v-for="item in selectedOrder.items" :key="item.id" class="flex justify-between items-center">
                  <span>{{ item.product?.name }}</span>
                  <span class="font-black text-primary-700">x{{ item.quantity }}</span>
                </li>
              </ul>
              <div class="mt-4 pt-4 border-t border-primary-200 flex justify-between items-center">
                <span class="text-[10px] font-black uppercase text-primary-400">Total a declarar</span>
                <span class="text-xl font-serif font-black text-primary-950 italic">{{ selectedOrder.total }}€</span>
              </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row gap-4">
              <button @click="showShipModal = false" class="flex-1 px-6 py-4 border border-nautical-300 rounded-lg font-serif italic text-primary-800 hover:bg-nautical-50 transition-all font-bold">Abortar despacho</button>
              <button @click="confirmShip" class="flex-[2] px-8 py-4 bg-primary-950 text-white rounded-lg font-serif italic text-lg hover:bg-primary-800 transition-all shadow-2xl font-black flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Confirmar Salida de Mercancía
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <!-- MODAL DE DETALLES DEL PEDIDO (VISTA DE BITÁCORA) -->
    <transition name="modal">
      <div v-if="showDetailsModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-primary-950/80 backdrop-blur-md p-4 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden border-4 border-white transform transition-all my-8">
          <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">Detalle de Bitácora</h2>
              <p class="text-xs text-nautical-500 font-serif italic uppercase tracking-widest mt-1">Registro de Pedido #{{ selectedOrderDetails.id }}</p>
            </div>
            <button @click="showDetailsModal = false" class="p-2 bg-white rounded-full text-primary-900 shadow-md hover:scale-110 transition-transform border border-nautical-100">     
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
          
          <div class="p-8 lg:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
              <!-- Información del Cliente -->
              <div class="space-y-8">
                <div class="flex items-start gap-6">
                  <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center text-primary-900 font-serif font-black italic text-2xl border border-primary-200 shadow-inner">
                    {{ selectedOrderDetails.user?.name.charAt(0) }}
                  </div>
                  <div>
                    <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Cliente</p>
                    <p class="text-2xl font-serif font-black text-primary-950 italic">{{ selectedOrderDetails.user?.name }}</p>
                    <p class="text-sm font-serif italic text-primary-700">{{ selectedOrderDetails.user?.email }}</p>
                  </div>
                </div>

                <div class="pt-6 border-t border-nautical-100">
                  <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-3 italic">Destino Registrado</p>
                  <div class="text-sm font-serif italic text-primary-950 space-y-1">
                    <p class="font-bold">{{ selectedOrderDetails.shipping_address }}</p>
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
              </div>

              <!-- Resumen de Productos -->
              <div class="bg-nautical-50 p-8 rounded-2xl border border-nautical-200 flex flex-col h-full">
                <h3 class="text-xs font-black text-primary-900 uppercase tracking-widest flex items-center mb-6">
                  <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                  Aparejos Seleccionados
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
                    <span class="text-[10px] font-black uppercase text-nautical-400 italic">Total Declarado</span>
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

            <div class="mt-12 pt-8 border-t border-nautical-100 flex justify-end">
              <button @click="showDetailsModal = false" class="px-8 py-3 bg-primary-950 text-white rounded font-serif italic font-black uppercase text-xs tracking-[0.2em] hover:bg-primary-800 transition-all shadow-xl">
                Cerrar Bitácora
              </button>
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
import { useToastStore } from '../stores/toast'

const toastStore = useToastStore()
const orders = ref([])
const showShipModal = ref(false)
const showDetailsModal = ref(false)
const selectedOrder = ref(null)
const selectedOrderDetails = ref(null)
const shipForm = ref({ address: '', city: '', zip: '' })
const search = ref('')
const statusFilter = ref('all')
const lastUpdate = ref(new Date().toLocaleTimeString())

const fetchOrders = async () => {
  try {
    const res = await axios.get('/orders-list')
    orders.value = res.data
    lastUpdate.value = new Date().toLocaleTimeString()
  } catch (error) {
    console.error('Error fetching orders:', error)
  }
}

const filteredOrders = computed(() => {
  let filtered = orders.value
  
  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(o => o.status === statusFilter.value)
  }
  
  if (search.value) {
    const s = search.value.toLowerCase()
    filtered = filtered.filter(o => 
      o.user?.name.toLowerCase().includes(s) || 
      o.shipping_address.toLowerCase().includes(s) ||
      o.shipping_city.toLowerCase().includes(s) ||
      o.id.toString().includes(s)
    )
  }
  
  return filtered
})

const pendingOrdersCount = computed(() => {
  return orders.value.filter(o => o.status === 'pending').length
})

const averageOrderValue = computed(() => {
  if (orders.value.length === 0) return 0
  const validOrders = orders.value.filter(o => o.status !== 'cancelled')
  if (validOrders.length === 0) return 0
  const total = validOrders.reduce((acc, order) => acc + parseFloat(order.total), 0)
  return total / validOrders.length
})

const openDetailsModal = (order) => {
  selectedOrderDetails.value = order
  showDetailsModal.value = true
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
    
    const index = orders.value.findIndex(o => o.id === selectedOrder.value.id)
    if (index !== -1) {
      orders.value[index] = res.data.order
    }
    
    showShipModal.value = false
    toastStore.add('¡Despacho confirmado! El pedido ya está en ruta.')
  } catch (error) {
    toastStore.add('Error al procesar el envío.', 'error')
  }
}

const updateStatus = async (orderId, action) => {
  const actionText = action === 'accept' ? 'aceptar' : 'rechazar'
  if (!confirm(`¿Está seguro de que desea ${actionText} este pedido?`)) return

  try {
    const res = await axios.patch(`/admin/api/orders/${orderId}/${action}`)
    const index = orders.value.findIndex(o => o.id === orderId)
    if (index !== -1) {
      orders.value[index] = res.data.order
    }
    toastStore.add(res.data.message)
  } catch (error) {
    toastStore.add('Error al actualizar el estado del pedido.', 'error')
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

const formatDate = (dateStr) => {
  if (!dateStr) return '--:--'
  const date = new Date(dateStr)
  return date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' })
}

onMounted(fetchOrders)
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

.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
