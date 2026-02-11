<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-slate-900 mb-8">Tu Carrito</h1>

    <div v-if="cartStore.items.length === 0" class="bg-white rounded-2xl p-12 text-center border border-dashed border-slate-300">
      <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
      </div>
      <p class="text-xl text-slate-500 font-medium">Tu carrito está vacío</p>
      <router-link to="/tienda" class="mt-6 inline-block bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">Ir a la tienda</router-link>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Lista de Productos -->
      <div class="lg:col-span-2 space-y-4">
        <div v-for="item in cartStore.items" :key="item.id" class="bg-white p-6 rounded-2xl border border-slate-100 flex items-center gap-6">
          <div class="h-20 w-20 bg-blue-50 rounded-xl flex-shrink-0 flex items-center justify-center text-blue-300">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
             </svg>
          </div>
          <div class="flex-grow">
            <h3 class="font-bold text-slate-800 text-lg">{{ item.name }}</h3>
            <p class="text-slate-400 text-sm">Cantidad: {{ item.quantity }}</p>
          </div>
          <div class="text-right">
            <p class="font-black text-xl text-slate-900">{{ item.price * item.quantity }}€</p>
            <button @click="cartStore.removeItem(item.id)" class="text-red-500 text-sm font-bold hover:underline">Eliminar</button>
          </div>
        </div>
      </div>

      <!-- Resumen -->
      <div class="bg-blue-900 text-white p-8 rounded-3xl h-fit sticky top-24">
        <h2 class="text-2xl font-bold mb-6">Resumen</h2>
        <div class="space-y-4 mb-8">
          <div class="flex justify-between text-blue-200">
            <span>Subtotal</span>
            <span>{{ cartStore.totalPrice }}€</span>
          </div>
          <div class="flex justify-between text-blue-200">
            <span>Envío</span>
            <span>Gratis</span>
          </div>
          <div class="border-t border-blue-800 pt-4 flex justify-between text-xl font-black">
            <span>Total</span>
            <span>{{ cartStore.totalPrice }}€</span>
          </div>
        </div>
        <button class="w-full bg-blue-500 hover:bg-blue-400 text-white py-4 rounded-xl font-bold transition shadow-lg shadow-blue-900/50">
          Finalizar Pedido
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../stores/cart'

const cartStore = useCartStore()
</script>
