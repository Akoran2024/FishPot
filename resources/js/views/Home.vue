<template>
  <main class="space-y-20 pb-20">
    <!-- Hero Section -->
    <section class="relative min-h-[700px] flex items-center overflow-hidden">
      <!-- Background Video or Image Placeholder -->
      <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950 via-primary-900/80 to-transparent z-10"></div>
        <img src="https://www.diariodelanzarote.com/sites/default/files/archivos/2015/Julio%202015/230720-pescador660.jpeg" alt="Fishing Background" class="w-full h-full object-cover">
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
            <router-link to="/tienda" class="group relative bg-accent-500 hover:bg-accent-400 text-primary-950 px-10 py-5 rounded-2xl font-extrabold text-lg text-center transition-all duration-300 shadow-2xl shadow-accent-950/40 transform hover:-translate-y-1">
              Ver Tienda
              <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">→</span>
            </router-link>
            <router-link to="/mareas" class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 px-10 py-5 rounded-2xl font-extrabold text-lg text-center transition-all duration-300">
              Consultar Mareas
            </router-link>
          </div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce hidden md:block">
        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center p-1">
          <div class="w-1 h-2 bg-accent-400 rounded-full"></div>
        </div>
      </div>
    </section>

   

    <!-- Features Section -->
    <section class="py-12 relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
          <div class="max-w-xl">
            <h2 class="text-accent-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Herramientas Profesionales</h2>
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

const features = [
  {
    title: 'Meteorología',
    description: 'Predicción exacta de viento, olas y presión atmosférica para Lanzarote.',
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
      </svg>`
  },
  {
    title: 'Puntos de Pesca',
    description: 'Descubre los mejores pesqueros de la isla compartidos por la comunidad.',
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
      </svg>`
  },
  {
    title: 'Tienda Pro',
    description: 'Equípate con las mejores marcas y materiales testados por expertos.',
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
      </svg>`
  },
  {
    title: 'Enciclopedia',
    description: 'Guía completa de especies locales, tallas mínimas y vedas actuales.',
    icon: `<svg xmlns="http://www.w3.org/2000/vue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
      </svg>`
  }
]
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
