<template>
  <div class="min-h-[80vh] flex items-center justify-center px-4 relative z-10">
    <div class="max-w-md w-full bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-2xl p-12 border border-white animate-fade-in">
      <div class="text-center mb-10">
        <div class="bg-accent-500 w-20 h-20 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-primary-950 shadow-lg transform -rotate-6" aria-hidden="true">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
           </svg>
        </div>
        <h1 class="text-4xl font-black text-slate-900 leading-tight">Bienvenido</h1>
        <p class="text-slate-500 mt-3 font-medium">Accede a tu cuenta de FishPot</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div class="space-y-2">
          <label for="email" class="block text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
          <input id="email" v-model="form.email" type="email" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-slate-900 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-400 outline-none transition placeholder-slate-400 font-medium" placeholder="tu@email.com">
        </div>
        <div class="space-y-2">
          <div class="flex justify-between items-center ml-1">
            <label for="password" class="block text-xs font-black text-slate-400 uppercase tracking-widest">Contraseña</label>
            <a href="#" class="text-[10px] font-black text-primary-600 hover:text-primary-800 uppercase tracking-widest transition">¿Olvidaste la contraseña?</a>
          </div>
          <input id="password" v-model="form.password" type="password" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-slate-900 focus:ring-4 focus:ring-primary-500/20 focus:border-primary-400 outline-none transition placeholder-slate-400 font-medium" placeholder="••••••••">
        </div>
        
        <div class="pt-4">
          <button type="submit" class="w-full bg-primary-900 hover:bg-primary-950 text-white py-5 rounded-2xl font-black text-lg transition-all shadow-xl shadow-primary-950/20 active:scale-95">
            Iniciar Sesión
          </button>
        </div>
      </form>

      <div class="mt-12 pt-8 border-t border-slate-100 text-center">
        <p class="text-slate-500 text-sm font-medium">
          ¿Aún no tienes cuenta? 
          <router-link to="/register" class="text-primary-600 font-black hover:text-primary-800 transition ml-1 uppercase tracking-widest text-xs">Regístrate</router-link>
        </p>
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
    await authStore.login(form.email, form.password)
    router.push('/')
  } catch (error) {
    alert('Error al iniciar sesión: Verifique sus credenciales')
  }
}
</script>
