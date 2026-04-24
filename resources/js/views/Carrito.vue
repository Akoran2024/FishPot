<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 border-b border-nautical-200 pb-12">
      <h2 class="text-primary-800 font-serif italic text-sm tracking-[0.2em] uppercase mb-2">Su selección</h2>
      <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Cesto de Compra</h1>
      <p class="text-nautical-600 mt-4 font-serif italic text-lg">Revise sus aparejos antes de confirmar el pedido. Listos para zarpar.</p>
    </div>

    <div v-if="cartStore.items.length === 0" class="nautical-card p-24 text-center">
      <div class="bg-nautical-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-10 text-nautical-200 border border-nautical-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
      </div>
      <p class="text-3xl text-nautical-300 font-serif italic mb-10">Su cesto está vacío</p>
      <router-link to="/tienda" class="nautical-btn">
        Volver al Almacén
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
      <!-- Lista de Aparejos -->
      <div class="lg:col-span-2 space-y-8">
        <div v-for="item in cartStore.items" :key="item.id" 
             class="nautical-card p-8 group flex flex-col sm:flex-row items-center gap-10 hover:border-primary-300 transition-all">
          <div class="h-32 w-32 bg-nautical-50 rounded flex-shrink-0 flex items-center justify-center p-4">
             <img v-if="item.image" :src="'/' + item.image" :alt="item.name" class="w-full h-full object-contain grayscale-[0.2] group-hover:grayscale-0 transition-all">
          </div>
          <div class="flex-grow text-center sm:text-left">
            <h3 class="font-serif font-black text-primary-950 text-2xl italic group-hover:text-primary-800 transition-colors">{{ item.name }}</h3>
            <p class="text-nautical-400 font-serif italic text-sm mt-1 uppercase tracking-widest">Cantidad: {{ item.quantity }} unidades</p>
            <button @click="cartStore.removeItem(item.id)" class="mt-4 text-[10px] font-bold text-red-700 uppercase tracking-widest hover:text-red-900 border-b border-red-200 pb-0.5">Retirar del cesto</button>
          </div>
          <div class="text-center sm:text-right flex flex-col justify-center">
            <p class="text-[9px] font-bold text-nautical-300 uppercase tracking-widest mb-1 italic">Subtotal</p>
            <p class="font-serif font-black text-3xl text-primary-950 italic tracking-tighter">{{ item.price * item.quantity }}<span class="text-sm">€</span></p>
          </div>
        </div>
      </div>

      <!-- Albarán de Pedido -->
      <div class="bg-white p-12 shadow-2xl border-4 border-double border-nautical-100 relative">
        <div class="absolute inset-0 pointer-events-none opacity-5" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative z-10">
          <h2 class="text-3xl font-serif font-black mb-10 text-primary-950 italic text-center border-b border-nautical-100 pb-6">Resumen de Pedido</h2>
          
          <div class="space-y-6 mb-12 font-serif italic">
            <div class="flex justify-between items-center text-nautical-600">
              <span>Suma de aparejos</span>
              <span class="font-bold text-primary-900">{{ cartStore.totalPrice }}€</span>
            </div>
            <div class="flex justify-between items-center text-nautical-600">
              <span>Portes de envío</span>
              <span v-if="shippingCost > 0" class="text-red-700 font-bold">{{ shippingCost.toFixed(2) }}€</span>
              <span v-else class="text-primary-700 font-bold">Sin cargo</span>
            </div>
            <div v-if="shippingCost > 0" class="text-[9px] text-nautical-400 font-bold uppercase tracking-widest text-right -mt-4">
              * Tarifa peninsular / exterior aplicada
            </div>
            <div class="pt-8 border-t-2 border-dashed border-nautical-200 flex justify-between items-end">
              <div>
                <span class="block text-nautical-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Total a liquidar</span>
                <span class="text-5xl font-serif font-black text-primary-950 tracking-tighter italic">{{ finalTotal.toFixed(2) }}€</span>
              </div>
            </div>
          </div>

          <!-- Detalles de Entrega -->
          <div class="space-y-6 mb-12">
            <h3 class="text-xs font-black text-primary-800 uppercase tracking-[0.3em] mb-4 italic">Detalles de Entrega</h3>
            <div class="grid grid-cols-1 gap-4">
              <input type="text" v-model="shippingAddress" placeholder="Dirección de entrega" class="nautical-input">
              <div class="grid grid-cols-2 gap-4">
                <input type="text" v-model="shippingCity" placeholder="Localidad" class="nautical-input">
                <input type="text" v-model="shippingZipCode" placeholder="C. Postal" class="nautical-input">
              </div>
            </div>
          </div>

          <!-- Forma de Pago -->
          <div class="mb-12">
            <h3 class="text-xs font-black text-primary-800 uppercase tracking-[0.3em] mb-6 italic">Forma de Pago</h3>
            <div class="space-y-4 font-serif italic text-sm text-nautical-700">
              <label class="flex items-center cursor-pointer group">
                <input type="radio" v-model="paymentMethod" value="online_payment" class="hidden peer">
                <div class="w-4 h-4 rounded-full border-2 border-nautical-300 mr-3 peer-checked:bg-primary-800 peer-checked:border-primary-800 transition-all"></div>
                <span class="group-hover:text-primary-950 transition-colors">Pago con tarjeta</span>
              </label>

              <!-- Sección de Tarjeta (Aparece solo si se selecciona) -->
              <transition name="fade">
                <div v-if="paymentMethod === 'online_payment'" class="mt-6 p-6 bg-nautical-50 border border-nautical-100 rounded-lg space-y-4">
                  <input type="text" v-model="cardHolder" placeholder="Nombre del Titular" class="nautical-input bg-white shadow-inner">
                  <input type="text" v-model="cardNumber" placeholder="Número de Tarjeta (16 dígitos)" maxlength="16" @input="cardNumber = cardNumber.replace(/\D/g, '')" class="nautical-input bg-white shadow-inner">
                  <div class="grid grid-cols-2 gap-4">
                    <input type="text" v-model="cardExpiry" placeholder="MM/YY" maxlength="5" @input="formatExpiry" class="nautical-input bg-white shadow-inner text-center">
                    <input type="text" v-model="cardCvc" placeholder="CVC" maxlength="3" @input="cardCvc = cardCvc.replace(/\D/g, '')" class="nautical-input bg-white shadow-inner text-center">
                  </div>
                </div>
              </transition>

              <label class="flex items-center cursor-pointer group">
                <input type="radio" v-model="paymentMethod" value="cash_on_delivery" class="hidden peer">
                <div class="w-4 h-4 rounded-full border-2 border-nautical-300 mr-3 peer-checked:bg-primary-800 peer-checked:border-primary-800 transition-all"></div>
                <span class="group-hover:text-primary-950 transition-colors">Pago al recibir el bulto</span>
              </label>
            </div>
          </div>

          <button @click="checkout" class="nautical-btn w-full text-center py-5">
            Confirmar Pedido
          </button>
          
          <div class="mt-10 text-center opacity-40">
            <img src="https://img.icons8.com/color/48/000000/visa.png" class="inline-block h-6 mx-2 grayscale" alt="Visa">
            <img src="https://img.icons8.com/color/48/000000/mastercard.png" class="inline-block h-6 mx-2 grayscale" alt="Mastercard">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useCartStore } from '../stores/cart'
import { useRouter } from 'vue-router'
import axios from 'axios'

const cartStore = useCartStore()
const router = useRouter()

const paymentMethod = ref('online_payment')
const shippingAddress = ref('')
const shippingCity = ref('')
const shippingZipCode = ref('')

// Campos de Tarjeta
const cardHolder = ref('')
const cardNumber = ref('')
const cardExpiry = ref('')
const cardCvc = ref('')

const shippingCost = computed(() => {
  if (!shippingZipCode.value || shippingZipCode.value.length < 2) return 0
  const prefix = shippingZipCode.value.substring(0, 2)
  // 35 y 38 son las provincias Canarias
  return (prefix === '35' || prefix === '38') ? 0 : 9.50
})

const finalTotal = computed(() => {
  return parseFloat(cartStore.totalPrice) + shippingCost.value
})

const formatExpiry = (e) => {
  let val = e.target.value.replace(/\D/g, '')
  if (val.length > 2) {
    val = val.substring(0, 2) + '/' + val.substring(2, 4)
  }
  cardExpiry.value = val
}

const checkout = async () => {
  if (cartStore.items.length === 0) return
  
  // Validaciones básicas de envío
  if (!shippingAddress.value || !shippingCity.value || !shippingZipCode.value) {
    alert('Por favor, complete todos los campos de entrega del albarán.')
    return
  }

  // Validaciones de tarjeta si procede
  if (paymentMethod.value === 'online_payment') {
    if (!cardHolder.value || !cardNumber.value || !cardExpiry.value || !cardCvc.value) {
      alert('Por favor, complete los datos de su tarjeta para zarpar.')
      return
    }
    if (cardNumber.value.length < 16) {
      alert('El número de tarjeta debe tener 16 dígitos.')
      return
    }
    if (!/^\d{2}\/\d{2}$/.test(cardExpiry.value)) {
      alert('El formato de caducidad debe ser MM/YY.')
      return
    }
  }

  try {
    // Aseguramos el token CSRF antes de la petición POST
    await axios.get('/sanctum/csrf-cookie')

    const orderData = {
      items: cartStore.items.map(item => ({ id: item.id, quantity: item.quantity })),
      total: finalTotal.value,
      payment_method: paymentMethod.value,
      shipping_address: shippingAddress.value,
      shipping_city: shippingCity.value,
      shipping_zip_code: shippingZipCode.value,
      // Datos de tarjeta (simulados)
      card_holder: cardHolder.value,
      card_number: cardNumber.value,
      card_expiry: cardExpiry.value,
      card_cvc: cardCvc.value
    }

    await axios.post('/orders', orderData)
    alert('¡Pedido anotado con éxito! Recibirá sus aparejos pronto.')
    cartStore.clearCart()
    router.push('/')
  } catch (error) {
    console.error('Error al procesar el pedido:', error)
    if (error.response) {
      console.error('Detalles del error del servidor:', error.response.data);
      alert(`Hubo un error al procesar el pedido en el puerto: ${error.response.data.message || error.response.statusText || 'Error desconocido'}`);
    } else {
      alert('Hubo un error al procesar el pedido en el puerto.');
    }
  }
}
</script>

<style scoped>
.nautical-input {
  @apply w-full px-4 py-3 bg-nautical-50 border border-nautical-200 rounded font-serif italic text-sm focus:ring-1 focus:ring-primary-800 focus:border-primary-800 outline-none transition-all placeholder:text-nautical-300;
}
</style>
