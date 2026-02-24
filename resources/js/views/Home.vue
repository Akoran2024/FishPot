<template>
  <main class="space-y-20 pb-20">
    <section class="relative min-h-[700px] flex items-center overflow-hidden">
      <!-- Imagen de fondo -->
      <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950 via-primary-900/80 to-transparent z-10"></div>
        <img src="/public/imagenes/barco.jpg" 
        alt="Mi imagen" 
        class="w-full h-full object-cover">

      </div>
      
      <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-3xl animate-fade-in">
          <div v-if="authStore.user" class="mb-6 inline-flex items-center space-x-2 bg-accent-500/20 backdrop-blur-md px-4 py-2 rounded-full border border-accent-500/30">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-accent-500"></span>
            </span>
            <span class="text-accent-300 font-black uppercase tracking-widest text-xs">Bienvenido, {{ authStore.user.name }}</span>
          </div>
          
          <h1 class="text-6xl md:text-8xl font-black text-white leading-[1.1] mb-8 drop-shadow-sm">
            Explora el mundo<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-accent-300"> de la pesca</span> en Lanzarote
          </h1>
          
          <p class="text-xl text-primary-100/90 mb-12 leading-relaxed font-medium max-w-xl">
            Tu guía definitiva para la pesca: mareas precisas, catálogo de especies locales con sus tallas mínimas y la mejor equipación profesional, para poder disfrutar de lo que te gusta.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-6">
            <router-link to="/tienda" class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 px-10 py-5 rounded-2xl font-extrabold text-lg text-center transition-all duration-300">
              Ver Tienda
              <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">→</span>
            </router-link>
            <router-link to="/mareas" class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 px-10 py-5 rounded-2xl font-extrabold text-lg text-center transition-all duration-300">
              Consultar Mareas
            </router-link>
          </div>
        </div>
      </div>

    </section>

   

    <!-- Sección sobre página -->
    <section class="py-12 relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
          <div class="max-w-xl">
            <h2 class="text-primary-950 font-bold tracking-[0.2em] uppercase text-sm mb-4">Herramientas Profesionales</h2>
            <p class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">Diseñado para los amantes del <span class="text-primary-600">mar</span>.</p>
          </div>
          <p class="text-slate-500 font-medium max-w-sm mb-2">
            Todo lo necesario para que tu jornada de pesca sea perfecta, desde la previsión meteorológica hasta el equipamiento.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(feature, index) in features" :key="index" 
               class="group p-10 rounded-[2rem] bg-white border border-slate-100 hover:border-primary-200 transition-all duration-300 hover:shadow-xl hover:shadow-primary-900/5">
            <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-primary-600 mb-8 group-hover:bg-primary-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
               <div v-html="feature.icon" class="w-7 h-7"></div>
            </div>
            <h3 class="text-xl font-extrabold mb-4 text-slate-900">{{ feature.title }}</h3>
            <p class="text-slate-500 leading-relaxed text-sm font-medium">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

   
  </main>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
const authStore = useAuthStore()

</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
