<template>
  <div class="min-h-screen relative flex items-center justify-center overflow-hidden bg-primary-950">
    <!-- Fondo con imagen y overlay -->
    <div class="absolute inset-0 z-0">
      <img :src="'/imagenes/Tinajo-LaSanta-LR-1.jpg'" class="w-full h-full object-cover opacity-40" alt="Fondo La Santa">
      <div class="absolute inset-0 bg-gradient-to-b from-primary-950/60 via-primary-950/40 to-primary-950/80"></div>
    </div>

    <!-- Contenido Principal -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
      <div class="mb-12 animate-fade-in-up">
        <div class="inline-flex items-center justify-center p-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 mb-8 shadow-2xl">
          <img :src="'/imagenes/Vieja.png'" alt="FishPot Logo" class="h-20 w-auto filter brightness-110 drop-shadow-[0_0_15px_rgba(56,169,248,0.5)]">
        </div>
        
        <h1 class="text-6xl md:text-8xl font-serif font-black text-white mb-6 tracking-tighter italic">
          Fish<span class="text-primary-400">Pot</span>
        </h1>
        
        <p class="text-xl md:text-2xl font-serif italic text-primary-100/90 mb-12 max-w-2xl mx-auto leading-relaxed">
          Bienvenido a la cofradía digital de Lanzarote. <br class="hidden md:block">
          Registrate o entra para disfrutar de nuestro servicio y descubrir los tesoros del Atlántico.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
          <router-link to="/login" class="landing-btn primary w-full sm:w-auto">
            Entrar a la Web
          </router-link>
          <router-link to="/register" class="landing-btn secondary w-full sm:w-auto">
            Registrarse
          </router-link>
        </div>
      </div>

      <!-- Decoración inferior -->
      <div class="mt-20 flex items-center justify-center space-x-8 opacity-50">
        <div class="flex flex-col items-center">
          <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-400 mb-2 italic">Artesanal</span>
          <div class="h-px w-12 bg-primary-500/30"></div>
        </div>
        <div class="flex flex-col items-center">
          <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-400 mb-2 italic">Tradición</span>
          <div class="h-px w-12 bg-primary-500/30"></div>
        </div>
        <div class="flex flex-col items-center">
          <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-400 mb-2 italic">Lanzarote</span>
          <div class="h-px w-12 bg-primary-500/30"></div>
        </div>
      </div>
    </div>

    <!-- Ondas decorativas en el fondo -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-0 opacity-20">
      <svg class="relative block w-full h-32" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C58.47,113.1,145.51,123.09,221.39,111.41,273.69,103.4,321.39,56.44,321.39,56.44Z" class="fill-primary-500"></path>
      </svg>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

onMounted(() => {
  // Si ya está logueado, lo mandamos al inicio
  if (authStore.user) {
    router.push('/inicio')
  }
})
</script>

<style scoped>
.landing-btn {
  @apply px-12 py-4 rounded font-serif italic text-xl font-bold transition-all duration-300 text-center shadow-xl;
}

.landing-btn.primary {
  @apply bg-primary-500 text-primary-950 hover:bg-primary-400 hover:scale-105 active:scale-95;
}

.landing-btn.secondary {
  @apply bg-white/5 backdrop-blur-md text-white border border-white/20 hover:bg-white/10 hover:border-white/40;
}

@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
