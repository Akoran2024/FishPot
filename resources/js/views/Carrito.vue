<template>
  <!-- imagen -->
 

  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 animate-fade-in">
      <h2 class="text-accent-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Tu Selección</h2>
      <h1 class="text-5xl font-black text-slate-900 mb-4">Carrito de Compras</h1>
      <p class="text-slate-500 font-medium">Revisa tus artículos antes de zarpar.</p>
    </div>

    <div v-if="cartStore.items.length === 0" class="bg-white/70 backdrop-blur-xl rounded-[3rem] p-20 text-center border border-white shadow-xl animate-fade-in">
      <div class="bg-primary-50 w-24 h-24 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-primary-200 shadow-inner">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
      </div>
      <p class="text-2xl text-slate-400 font-black mb-8 uppercase tracking-widest">Tu carrito está vacío</p>
      <router-link to="/tienda" class="inline-block bg-primary-900 text-white px-10 py-5 rounded-2xl font-black text-lg hover:bg-primary-950 transition-all shadow-xl shadow-primary-950/20 active:scale-95">
        Volver a la Tienda
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
      <!-- Lista de Productos -->
      <div class="lg:col-span-2 space-y-6">
        <div v-for="item in cartStore.items" :key="item.id" 
             class="group bg-white/80 backdrop-blur-md p-8 rounded-[2.5rem] border border-white flex flex-col sm:flex-row items-center gap-8 shadow-xl hover:shadow-2xl transition-all duration-300">
          <div class="h-32 w-32 bg-slate-50 rounded-[1.5rem] flex-shrink-0 flex items-center justify-center text-primary-200 group-hover:bg-primary-50 transition-colors duration-500 relative overflow-hidden">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
             </svg>
          </div>
          <div class="flex-grow text-center sm:text-left">
            <h3 class="font-black text-slate-900 text-2xl group-hover:text-primary-600 transition-colors">{{ item.name }}</h3>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest mt-1">Cantidad: {{ item.quantity }}</p>
            <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-4">
               <button @click="cartStore.removeItem(item.id)" class="text-xs font-black text-red-500 hover:text-red-700 uppercase tracking-widest bg-red-50 px-4 py-2 rounded-xl transition-colors">Eliminar</button>
            </div>
          </div>
          <div class="text-center sm:text-right flex flex-col justify-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Subtotal</p>
            <p class="font-black text-3xl text-primary-950">{{ item.price * item.quantity }}<span class="text-sm">€</span></p>
          </div>
        </div>
      </div>

      <!-- Resumen -->
      <div class="bg-primary-950 text-white p-10 rounded-[3rem] shadow-2xl sticky top-28 border border-primary-900 overflow-hidden relative group">
        <!-- Decorative element -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary-800 rounded-full blur-[80px] opacity-20 transition-all duration-700 group-hover:scale-110"></div>
        
        <div class="relative z-10">
          <h2 class="text-3xl font-black mb-10">Resumen</h2>
          <div class="space-y-6 mb-12">
            <div class="flex justify-between items-center">
              <span class="text-primary-300 font-bold uppercase text-[10px] tracking-[0.2em]">Subtotal</span>
              <span class="font-black text-xl">{{ cartStore.totalPrice }}€</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-primary-300 font-bold uppercase text-[10px] tracking-[0.2em]">Gastos de Envío</span>
              <span class="text-accent-400 font-black text-xs uppercase tracking-widest">Gratis</span>
            </div>
            <div class="pt-8 border-t border-primary-800 flex justify-between items-end">
              <div>
                <span class="block text-primary-400 font-bold uppercase text-[10px] tracking-[0.2em] mb-1">Total a pagar</span>
                <span class="text-4xl font-black">{{ cartStore.totalPrice }}€</span>
              </div>
            </div>
          </div>
          <button @click="checkout" class="w-full bg-accent-500 hover:bg-accent-400 text-primary-950 py-5 rounded-[1.5rem] font-black text-lg transition-all shadow-xl shadow-accent-950/20 active:scale-95">
            Finalizar Pedido
          </button>
          
          <div class="mt-8 flex items-center justify-center space-x-4 opacity-50 grayscale hover:grayscale-0 transition duration-500">
            <!-- Payment icons placeholders -->
            <div class="w-10 h-6 bg-white/20 rounded-sm"></div>
            <div class="w-10 h-6 bg-white/20 rounded-sm"></div>
            <div class="w-10 h-6 bg-white/20 rounded-sm"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../stores/cart'
import { useRouter } from 'vue-router'
import axios from 'axios'

const cartStore = useCartStore()
const router = useRouter()

const checkout = async () => {
  if (cartStore.items.length === 0) return

  try {
    const orderData = {
      items: cartStore.items.map(item => ({
        id: item.id,
        quantity: item.quantity
      })),
      total: cartStore.totalPrice
    }

    await axios.post('/orders', orderData)

    alert('¡Pedido realizado con éxito! El stock ha sido actualizado.')
    cartStore.clearCart()
    router.push('/')
  } catch (error) {
    console.error('Error al procesar el pedido:', error)
    const message = error.response?.data?.message || 'Hubo un error al procesar tu pedido.'
    alert(message)
  }
}
</script>
