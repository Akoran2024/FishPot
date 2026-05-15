<template>
  <div class="min-h-[80vh] flex items-center justify-center px-4 relative z-10">
    <div class="max-w-md w-full bg-white border-4 border-double border-nautical-200 p-12 shadow-2xl relative overflow-hidden">
      <!-- Subtle Texture -->
      <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/canvas-orange.png')"></div>

      <div class="relative z-10">
        <div class="text-center mb-12">
          <div class="bg-primary-950 w-20 h-20 rounded-lg flex items-center justify-center mx-auto mb-8 shadow-lg border-2 border-primary-800 transform -rotate-3">
             <img :src="'/imagenes/Vieja.png'" alt="Logo" class="h-10 w-auto filter brightness-125" />
          </div>
          <h1 class="text-3xl font-serif font-black text-primary-950 tracking-tight italic">Nueva Contraseña</h1>
          <p class="text-nautical-400 font-serif italic text-sm mt-2">Defina sus nuevas credenciales de acceso</p>
          <div class="w-16 h-px bg-nautical-200 mx-auto mt-6"></div>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div class="space-y-2">
            <label for="email" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Confirmar Correo</label>
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
            <label for="password" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Nueva Contraseña</label>
            <input 
              id="password" 
              v-model="form.password" 
              type="password" 
              required 
              autocomplete="new-password"
              class="nautical-input" 
              placeholder="••••••••"
            >
            <span v-if="validationErrors.password" class="text-red-500 text-xs italic">{{ validationErrors.password[0] }}</span>
          </div>

          <div class="space-y-2">
            <label for="password_confirmation" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Repetir Contraseña</label>
            <input 
              id="password_confirmation" 
              v-model="form.password_confirmation" 
              type="password" 
              required 
              autocomplete="new-password"
              class="nautical-input" 
              placeholder="••••••••"
            >
          </div>
          
          <div class="pt-4">
            <button 
              type="submit" 
              :disabled="loading"
              class="nautical-btn w-full py-4 text-center disabled:opacity-50"
            >
              <span v-if="loading">Actualizando...</span>
              <span v-else>Actualizar Contraseña</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useToastStore } from '../stores/toast'
import { useRoute, useRouter } from 'vue-router'

const authStore = useAuthStore()
const toastStore = useToastStore()
const route = useRoute()
const router = useRouter()
const loading = ref(false)

const form = reactive({
  token: route.params.token,
  email: route.query.email || '',
  password: '',
  password_confirmation: ''
})

const validationErrors = reactive({})

const handleSubmit = async () => {
  loading.value = true
  Object.keys(validationErrors).forEach(key => delete validationErrors[key]);

  try {
    const response = await authStore.resetPassword(form)
    toastStore.add('¡Contraseña actualizada con éxito!')
    router.push('/login')
  } catch (error) {
    if (error.response && error.response.status === 422) {
      Object.assign(validationErrors, error.response.data.errors);
    } else {
      toastStore.add('Error al actualizar la contraseña.', 'error')
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
