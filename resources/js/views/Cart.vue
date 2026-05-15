<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 border-b border-nautical-200 dark:border-white/10 pb-12">
      <h2 class="text-primary-800 dark:text-primary-400 font-serif italic text-sm tracking-[0.2em] uppercase mb-2">Su selección</h2>
      <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 dark:text-white italic tracking-tight leading-none mb-4">Cesto de Compra</h1>
      <p class="text-nautical-600 dark:text-nautical-300 font-serif italic text-lg">Revise sus aparejos antes de confirmar el pedido. Listos para zarpar.</p>
    </div>

    <div v-if="cartStore.items.length === 0" class="nautical-card p-24 text-center border-2 border-dashed border-primary-100 dark:border-white/5 bg-white/40 dark:bg-primary-950/20">
      <div class="relative w-32 h-32 mx-auto mb-10">
        <div class="absolute inset-0 bg-primary-500/10 rounded-full animate-ping"></div>
        <div class="relative bg-white dark:bg-primary-900 w-full h-full rounded-full flex items-center justify-center text-nautical-200 dark:text-primary-400 border border-nautical-100 dark:border-white/10 shadow-inner animate-float">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
      </div>
      <h3 class="text-4xl text-primary-950 dark:text-white font-serif font-black italic mb-4 tracking-tighter">Bitácora en blanco</h3>
      <p class="text-nautical-400 dark:text-primary-300/60 font-serif italic text-xl mb-12 max-w-md mx-auto">Parece que hoy no hay capturas en el cesto. Vuelve a la lonja para equiparte con lo mejor.</p>
      <router-link to="/tienda" class="nautical-btn inline-block">
        Ir a la Lonja
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
      <!-- Lista de Aparejos -->
      <div class="lg:col-span-2 space-y-8">
        <div v-for="item in cartStore.items" :key="item.id" 
             class="nautical-card p-8 group flex flex-col sm:flex-row items-center gap-10 hover:border-primary-300 dark:hover:border-primary-500/50 transition-all">
          <div class="h-32 w-32 bg-nautical-50 dark:bg-primary-950 rounded flex-shrink-0 flex items-center justify-center p-4 relative overflow-hidden group-hover:bg-white dark:group-hover:bg-primary-900 transition-colors">
             <img v-if="item.image" :src="'/' + item.image" :alt="item.name" class="w-full h-full object-contain grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-500 relative z-10 dark:brightness-90">
             <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/5 to-transparent"></div>
          </div>
          <div class="flex-grow text-center sm:text-left">
            <h3 class="font-serif font-black text-primary-950 dark:text-white text-2xl italic group-hover:text-primary-800 dark:group-hover:text-primary-400 transition-colors">{{ item.name }}</h3>
            <p class="text-nautical-400 dark:text-primary-400/60 font-serif italic text-sm mt-1 uppercase tracking-widest">Cantidad: {{ item.quantity }} unidades</p>
            <button @click="cartStore.removeItem(item.id)" class="mt-4 text-[10px] font-bold text-red-700 dark:text-red-400 uppercase tracking-widest hover:text-red-900 dark:hover:text-red-300 border-b border-red-200 dark:border-red-900/50 pb-0.5 transition-colors">Retirar del cesto</button>
          </div>
          <div class="text-center sm:text-right flex flex-col justify-center">
            <p class="text-[9px] font-bold text-nautical-300 dark:text-primary-500 uppercase tracking-widest mb-1 italic">Subtotal</p>
            <p class="font-serif font-black text-3xl text-primary-950 dark:text-white italic tracking-tighter">{{ item.price * item.quantity }}<span class="text-sm ml-0.5">€</span></p>
          </div>
        </div>
      </div>

      <!-- Albarán de Pedido -->
      <div class="bg-white dark:bg-primary-900/40 backdrop-blur-xl p-12 shadow-2xl border-4 border-double border-nautical-100 dark:border-white/10 relative overflow-hidden transition-colors duration-500">
        <div class="absolute inset-0 pointer-events-none opacity-5 dark:opacity-10" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative z-10">
          <h2 class="text-3xl font-serif font-black mb-10 text-primary-950 dark:text-white italic text-center border-b border-nautical-100 dark:border-white/10 pb-6">Resumen de Pedido</h2>
          
          <div class="space-y-6 mb-12 font-serif italic">
            <div class="flex justify-between items-center text-nautical-600 dark:text-primary-200">
              <span>Suma de aparejos</span>
              <span class="font-bold text-primary-900 dark:text-primary-400">{{ cartStore.totalPrice }}€</span>
            </div>
            <div class="flex justify-between items-center text-nautical-600 dark:text-primary-200">
              <span>Portes de envío</span>
              <span v-if="shippingCost > 0" class="text-red-700 dark:text-red-400 font-bold">{{ shippingCost.toFixed(2) }}€</span>
              <span v-else class="text-primary-700 dark:text-sea-400 font-bold">Sin cargo</span>
            </div>
            <div v-if="shippingCost > 0" class="text-[9px] text-nautical-400 dark:text-primary-500 font-bold uppercase tracking-widest text-right -mt-4">
              * Tarifa peninsular / exterior aplicada
            </div>
            <div class="pt-8 border-t-2 border-dashed border-nautical-200 dark:border-white/10 flex justify-between items-end">
              <div>
                <span class="block text-nautical-400 dark:text-primary-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Total a liquidar</span>
                <span class="text-5xl font-serif font-black text-primary-950 dark:text-white tracking-tighter italic">{{ finalTotal.toFixed(2) }}€</span>
              </div>
            </div>
          </div>

          <!-- Detalles de Entrega -->
          <div class="space-y-6 mb-12">
            <h3 class="text-xs font-black text-primary-800 dark:text-primary-400 uppercase tracking-[0.3em] mb-4 italic">Detalles de Entrega</h3>
            <div class="grid grid-cols-1 gap-4">
              <input type="text" v-model="shippingAddress" placeholder="Dirección de entrega" class="nautical-input dark:bg-primary-950/50 dark:border-white/10 dark:text-white">
              <div class="grid grid-cols-2 gap-4">
                <input type="text" v-model="shippingCity" placeholder="Localidad" class="nautical-input dark:bg-primary-950/50 dark:border-white/10 dark:text-white">
                <input type="text" v-model="shippingZipCode" placeholder="C. Postal" class="nautical-input dark:bg-primary-950/50 dark:border-white/10 dark:text-white">
              </div>
            </div>
          </div>

          <!-- Forma de Pago -->
          <div class="mb-12">
            <h3 class="text-xs font-black text-primary-800 dark:text-primary-400 uppercase tracking-[0.3em] mb-6 italic">Forma de Pago</h3>
            <div class="space-y-4 font-serif italic text-sm text-nautical-700 dark:text-primary-200">
              <label class="flex items-center cursor-pointer group">
                <input type="radio" v-model="paymentMethod" value="online_payment" class="hidden peer">
                <div class="w-4 h-4 rounded-full border-2 border-nautical-300 dark:border-white/20 mr-3 peer-checked:bg-primary-800 dark:peer-checked:bg-primary-500 peer-checked:border-primary-800 dark:peer-checked:border-primary-500 transition-all"></div>
                <span class="group-hover:text-primary-950 dark:group-hover:text-white transition-colors">Pago con tarjeta</span>
              </label>

              <!-- Sección de Tarjeta (Aparece solo si se selecciona) -->
              <transition name="fade">
                <div v-if="paymentMethod === 'online_payment'" class="mt-6 p-6 bg-nautical-50 dark:bg-primary-950/50 border border-nautical-100 dark:border-white/10 rounded-lg space-y-4">
                  <p class="text-xs text-nautical-500 dark:text-primary-400 italic mb-2">Al confirmar, será redirigido a nuestra pasarela de pago segura (Stripe).</p>
                </div>
              </transition>

              <label class="flex items-center cursor-pointer group">
                <input type="radio" v-model="paymentMethod" value="cash_on_delivery" class="hidden peer">
                <div class="w-4 h-4 rounded-full border-2 border-nautical-300 dark:border-white/20 mr-3 peer-checked:bg-primary-800 dark:peer-checked:bg-primary-500 peer-checked:border-primary-800 dark:peer-checked:border-primary-500 transition-all"></div>
                <span class="group-hover:text-primary-950 dark:group-hover:text-white transition-colors">Pago al recibir el bulto</span>
              </label>
            </div>
          </div>

          <button @click="checkout" class="nautical-btn w-full text-center py-5">
            Confirmar Pedido
          </button>
          
          <div class="mt-10 text-center opacity-40 dark:invert">
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
import { useToastStore } from '../stores/toast'
import { useRouter } from 'vue-router'
import axios from 'axios'

const cartStore = useCartStore()
const toastStore = useToastStore()
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
    toastStore.add('Por favor, complete todos los campos de entrega del albarán.', 'error')
    return
  }

  // Validaciones de tarjeta si procede (Opcional si se usa Stripe Checkout)
  if (paymentMethod.value === 'online_payment') {
    // Si se prefiere usar Stripe Checkout, podemos saltar estas validaciones locales
    // o dejarlas si queremos mantener la simulación activa.
    // Para una pasarela REAL, usaremos Stripe:
    try {
      await axios.get('/sanctum/csrf-cookie')
      const response = await axios.post('/stripe/checkout', {
        items: cartStore.items.map(item => ({ id: item.id, quantity: item.quantity })),
        shipping_address: shippingAddress.value,
        shipping_city: shippingCity.value,
        shipping_zip_code: shippingZipCode.value
      })
      if (response.data.url) {
        window.location.href = response.data.url
        return
      }
    } catch (error) {
      console.error('Error al iniciar Stripe Checkout:', error)
      toastStore.add('Error al conectar con la pasarela de pago.', 'error')
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
      // Datos de tarjeta (simulados) - Solo se envían si no se redirigió a Stripe
      card_holder: cardHolder.value,
      card_number: cardNumber.value,
      card_expiry: cardExpiry.value,
      card_cvc: cardCvc.value
    }

    await axios.post('/orders', orderData)
    toastStore.add('¡Pedido anotado con éxito! Recibirá sus aparejos pronto.')
    cartStore.clearCart()
    router.push('/')
  } catch (error) {
    console.error('Error al procesar el pedido:', error)
    if (error.response) {
      console.error('Detalles del error del servidor:', error.response.data);
      toastStore.add(`Hubo un error al procesar el pedido: ${error.response.data.message || error.response.statusText || 'Error desconocido'}`, 'error');
    } else {
      toastStore.add('Hubo un error al procesar el pedido en el puerto.', 'error');
    }
  }
}
</script>

<style scoped>
.nautical-input {
  @apply w-full px-4 py-3 bg-nautical-50 border border-nautical-200 rounded font-serif italic text-sm focus:ring-1 focus:ring-primary-800 focus:border-primary-800 outline-none transition-all placeholder:text-nautical-300;
}
</style>
