<template>
  <div class="min-h-[90vh] flex items-center justify-center px-4 relative z-10">
    <div class="max-w-md w-full bg-white border-4 border-double border-nautical-200 p-12 shadow-2xl relative overflow-hidden">
      <!-- Subtle Texture -->
      <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/canvas-orange.png')"></div>

      <div class="relative z-10">
        <div class="text-center mb-10">
          <div class="bg-primary-950 w-20 h-20 rounded-lg flex items-center justify-center mx-auto mb-8 shadow-lg border-2 border-primary-800 transform rotate-3">
             <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-10 w-auto filter brightness-125" />
          </div>
          <h1 class="text-4xl font-serif font-black text-primary-950 tracking-tight italic">Alta de Socio</h1>
          <p class="text-nautical-400 font-serif italic text-sm mt-2">Únase a la Cofradía de FishPot</p>
          <div class="w-16 h-px bg-nautical-200 mx-auto mt-6"></div>
        </div>

        <form @submit.prevent="handleRegister" class="space-y-6">
          <div class="space-y-1.5">
            <label for="name" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Nombre Completo</label>
            <input id="name" v-model="form.name" type="text" required class="nautical-input" placeholder="SU NOMBRE">
            <span v-if="validationErrors.name" class="text-red-500 text-xs italic">{{ validationErrors.name[0] }}</span>
          </div>

          <div class="space-y-1.5">
            <label for="email" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Correo Electrónico</label>
            <input id="email" v-model="form.email" type="email" required class="nautical-input" placeholder="ejemplo@correo.com">
            <span v-if="validationErrors.email" class="text-red-500 text-xs italic">{{ validationErrors.email[0] }}</span>
          </div>
          
          <div class="space-y-1.5">
            <label for="password" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Definir Contraseña</label>
            <input id="password" v-model="form.password" type="password" required class="nautical-input" placeholder="••••••••">
            <span v-if="validationErrors.password" class="text-red-500 text-xs italic">{{ validationErrors.password[0] }}</span>
          </div>

          <div class="space-y-1.5">
            <label for="password_confirmation" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Repetir Contraseña</label>
            <input id="password_confirmation" v-model="form.password_confirmation" type="password" required class="nautical-input" placeholder="••••••••">
            <span v-if="validationErrors.password_confirmation" class="text-red-500 text-xs italic">{{ validationErrors.password_confirmation[0] }}</span>
          </div>
          
          <div class="pt-6">
            <button type="submit" class="nautical-btn w-full py-4 text-center">
              Registrar Entrada
            </button>
          </div>
        </form>

        <div class="mt-10 pt-8 border-t border-nautical-100 text-center">
          <p class="text-nautical-500 text-xs font-serif italic">
            ¿Ya tiene una cuenta? 
            <router-link to="/login" class="text-primary-800 font-bold hover:text-primary-950 transition ml-1 border-b border-primary-200 pb-0.5">Acceder ahora</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue' // Import ref for validationErrors
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import { useToastStore } from '../stores/toast'

const authStore = useAuthStore()
const toastStore = useToastStore()
const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const validationErrors = reactive({}) // Reactive object to store validation errors

const handleRegister = async () => {
  // Clear previous errors
  Object.keys(validationErrors).forEach(key => delete validationErrors[key]);

  try {
    await authStore.register(form)
    toastStore.add(`¡Bienvenido a la Cofradía, ${authStore.user.name}!`)
    if (authStore.user.role === 'admin') {
      router.push('/admin/pedidos')
    } else {
      router.push('/mis-pedidos')
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      // Laravel validation error
      Object.assign(validationErrors, error.response.data.errors);
      toastStore.add('Error de validación: Por favor, revise los campos marcados.', 'error')
    } else {
      // Other errors
      toastStore.add('Error en el registro: Inténtelo de nuevo más tarde.', 'error')
    }
  }
}
</script>

<style scoped>
.nautical-input {
  @apply w-full px-5 py-3 bg-nautical-50 border border-nautical-200 rounded font-serif italic text-sm focus:ring-1 focus:ring-primary-800 focus:border-primary-800 outline-none transition-all placeholder:text-nautical-300;
}
</style>
