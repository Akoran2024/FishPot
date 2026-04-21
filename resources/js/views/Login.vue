<template>
  <div class="min-h-[80vh] flex items-center justify-center px-4 relative z-10 bg-nautical-100">
    <div class="max-w-md w-full bg-white border-4 border-double border-nautical-200 p-12 shadow-2xl relative overflow-hidden">
      <!-- Subtle Texture -->
      <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/canvas-orange.png')"></div>

      <div class="relative z-10">
        <div class="text-center mb-12">
          <div class="bg-primary-950 w-20 h-20 rounded-lg flex items-center justify-center mx-auto mb-8 shadow-lg border-2 border-primary-800 transform -rotate-3">
             <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-10 w-auto filter brightness-125" />
          </div>
          <h1 class="text-4xl font-serif font-black text-primary-950 tracking-tight italic">Acceso Socios</h1>
          <p class="text-nautical-400 font-serif italic text-sm mt-2">Bienvenido de nuevo a la Cofradía</p>
          <div class="w-16 h-px bg-nautical-200 mx-auto mt-6"></div>
        </div>

        <!-- Formulario con lógica restaurada -->
        <form @submit.prevent="handleLogin" class="space-y-8">
          <div class="space-y-2">
            <label for="email" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Correo Electrónico</label>
            <input 
              id="email" 
              v-model="form.email" 
              type="email" 
              required 
              autocomplete="email"
              class="nautical-input" 
              placeholder="ejemplo@correo.com"
            >
            <span v-if="validationErrors.email" class="text-red-500 text-xs italic">{{ validationErrors.email[0] }}</span>
          </div>
          
          <div class="space-y-2">
            <div class="flex justify-between items-center px-1">
              <label for="password" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] italic">Contraseña</label>
              <a href="#" class="text-[9px] font-bold text-primary-700 hover:text-primary-900 uppercase tracking-widest italic transition">¿Olvidó su clave?</a>
            </div>
            <input 
              id="password" 
              v-model="form.password" 
              type="password" 
              required 
              autocomplete="current-password"
              class="nautical-input" 
              placeholder="••••••••"
            >
            <span v-if="validationErrors.password" class="text-red-500 text-xs italic">{{ validationErrors.password[0] }}</span>
          </div>
          
          <div class="pt-4">
            <button 
              type="submit" 
              :disabled="loading"
              class="nautical-btn w-full py-4 text-center disabled:opacity-50"
            >
              <span v-if="loading">Verificando...</span>
              <span v-else>Entrar en Bitácora</span>
            </button>
          </div>
        </form>

        <div class="mt-12 pt-8 border-t border-nautical-100 text-center">
          <p class="text-nautical-500 text-xs font-serif italic">
            ¿Aún no es miembro? 
            <router-link to="/register" class="text-primary-800 font-bold hover:text-primary-950 transition ml-1 border-b border-primary-200 pb-0.5">Darse de alta</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()
const loading = ref(false)

const form = reactive({
  email: '',
  password: ''
})

const validationErrors = reactive({}) // Reactive object to store validation errors

const handleLogin = async () => {
  loading.value = true
  // Clear previous errors
  Object.keys(validationErrors).forEach(key => delete validationErrors[key]);

  try {
    await authStore.login(form.email, form.password)
    router.push('/')
  } catch (error) {
    console.error('Error de acceso:', error)
    if (error.response && error.response.status === 422) {
      Object.assign(validationErrors, error.response.data.errors);
      alert('Error de acceso: Por favor, compruebe sus credenciales.');
    } else {
      alert('Error de acceso: Acceso denegado: Por favor, compruebe que el correo y la contraseña son correctos.');
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.nautical-input {
  @apply w-full px-5 py-3 bg-nautical-50 border border-nautical-200 rounded font-serif italic text-sm focus:ring-1 focus:ring-primary-800 focus:border-primary-800 outline-none transition-all placeholder:text-nautical-300 text-primary-950;
}
</style>
