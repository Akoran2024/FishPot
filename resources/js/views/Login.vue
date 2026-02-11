<template>
  <div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10 border border-slate-100">
      <div class="text-center mb-10">
        <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-blue-600">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
           </svg>
        </div>
        <h1 class="text-3xl font-black text-slate-900">Bienvenido de nuevo</h1>
        <p class="text-slate-500 mt-2">Ingresa tus datos para acceder a PescaPro</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
          <input v-model="form.email" type="email" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="tu@email.com">
        </div>
        <div>
          <label class="block text-sm font-bold text-slate-700 mb-2">Contraseña</label>
          <input v-model="form.password" type="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="••••••••">
        </div>
        
        <button type="submit" class="w-full bg-blue-900 hover:bg-slate-900 text-white py-4 rounded-xl font-bold transition-all shadow-lg">
          Iniciar Sesión
        </button>
      </form>

      <div class="mt-8 text-center">
        <p class="text-slate-500 text-sm">¿No tienes cuenta? <a href="#" class="text-blue-600 font-bold hover:underline">Regístrate gratis</a></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const form = reactive({
  email: '',
  password: ''
})

const handleLogin = async () => {
  try {
    // Simulamos login por ahora si no hay backend listo
    authStore.user = { name: 'Pescador Experto', email: form.email }
    router.push('/')
  } catch (error) {
    alert('Error al iniciar sesión')
  }
}
</script>
