<template>
  <div class="min-h-screen text-nautical-900 selection:bg-primary-200">
    <!-- Hero Tradicional (Transparente para ver el fondo) -->
    <section class="relative min-h-[85vh] flex items-center overflow-hidden border-b border-nautical-200/50 dark:border-white/5">
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-3xl">
          <div class="inline-flex items-center space-x-2 bg-white/80 dark:bg-primary-900/50 backdrop-blur-sm px-4 py-1.5 rounded-full border border-nautical-200 dark:border-white/10 mb-8 shadow-sm">
            <span class="text-primary-800 dark:text-primary-300 font-serif italic text-xs tracking-wide">Tradición pesquera en Lanzarote</span>
          </div>
          
          <h1 class="text-6xl md:text-8xl font-serif font-black leading-[1.1] tracking-tight text-primary-950 dark:text-white mb-8">
            El Arte de la <br/>
            <span class="italic text-primary-700 dark:text-primary-400 drop-shadow-sm">Buena Pesca</span>
          </h1>
          
          <p class="text-xl text-nautical-700 dark:text-nautical-200 mb-12 leading-relaxed font-serif italic max-w-xl">
            Siente el pulso del Atlántico. Consulta las mareas, conoce nuestras especies y equípate con lo mejor para tu próxima jornada en la costa.
          </p>
          
          <div class="flex flex-wrap gap-4">
            <router-link to="/tienda" class="nautical-btn">
              Visitar Tienda
            </router-link>
            <router-link to="/mareas" class="px-8 py-3 bg-white dark:bg-primary-900/50 text-primary-900 dark:text-white border border-nautical-300 dark:border-white/10 font-serif italic text-lg hover:bg-nautical-50 dark:hover:bg-primary-800 transition-all shadow-sm backdrop-blur-sm">
              Tablas de Mareas
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section (Estilo Bitácora) -->
    <section class="py-12 -mt-16 relative z-20">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(stat, i) in stats" :key="i" class="nautical-card p-6 text-center border-b-2 border-b-primary-200 dark:border-b-primary-500/50">
            <p class="text-nautical-400 dark:text-primary-300/60 font-serif italic text-xs uppercase tracking-widest mb-1">{{ stat.label }}</p>
            <p class="text-3xl font-black text-primary-950 dark:text-white">{{ stat.value }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Core Features (Cuadrícula Clásica) -->
    <section class="py-24 relative">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-20">
          <h2 class="text-4xl md:text-5xl font-serif font-black text-primary-950 dark:text-white mb-4 tracking-tight">Todo para el Pescador</h2>
          <div class="w-24 h-1 bg-primary-700 dark:bg-primary-500 mx-auto opacity-30"></div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <div v-for="(feature, index) in features" :key="index" 
               class="nautical-card p-10 group hover:border-primary-400 dark:hover:border-primary-500 transition-all duration-500">
            <div class="w-16 h-16 bg-nautical-50 dark:bg-primary-800/50 rounded-full flex items-center justify-center text-primary-700 dark:text-primary-400 mb-8 border border-nautical-200 dark:border-white/10 group-hover:bg-primary-950 dark:group-hover:bg-primary-500 group-hover:text-white dark:group-hover:text-primary-950 transition-all duration-500">
                 <div v-html="feature.icon" class="w-8 h-8"></div>
            </div>
            
            <h3 class="text-2xl font-serif font-black mb-4 text-primary-950 dark:text-white italic">{{ feature.title }}</h3>
            <p class="text-nautical-600 dark:text-nautical-300 leading-relaxed text-sm mb-8 font-serif italic">{{ feature.description }}</p>
            
            <router-link :to="feature.link" class="text-primary-800 dark:text-primary-400 font-serif font-bold italic text-sm hover:text-primary-600 dark:hover:text-primary-300 transition-colors flex items-center">
              Saber más <span class="ml-2">→</span>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter / CTA Tradicional -->
    <section class="py-32 px-4 bg-primary-950 dark:bg-black/80 relative overflow-hidden text-center border-t border-white/5">
       <div class="absolute inset-0 opacity-10 pointer-events-none" 
            style="background-image: url('https://www.transparenttextures.com/patterns/pinstripe-dark.png')"></div>
       
       <div class="relative z-10 max-w-4xl mx-auto">
          <h2 class="text-4xl md:text-6xl font-serif font-black text-white mb-8 leading-tight tracking-tight italic">Únete a nuestra Cofradía</h2>
          <p class="text-primary-100 dark:text-primary-300 text-xl mb-12 max-w-2xl mx-auto font-serif italic">Recibe en tu correo las mejores ofertas, noticias de pesca y el estado de la mar en Lanzarote.</p>
          
          <div v-if="!authStore.user">
            <router-link to="/login" class="px-12 py-4 bg-white dark:bg-primary-500 text-primary-950 font-serif italic text-xl hover:bg-primary-50 dark:hover:bg-primary-400 transition-all shadow-xl inline-block">
               Registrarse ahora
            </router-link>
          </div>
       </div>
    </section>
  </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

const stats = [
  { label: 'Especies', value: '45+' },
  { label: 'Puntos Costa', value: '12' },
  { label: 'Aparejos', value: '120+' },
  { label: 'Comunidad', value: '500+' }
]

const features = [
  {
    title: 'Bitácora de Mareas',
    description: 'Consulta los mejores momentos para salir a pescar. Datos precisos de pleamar y bajamar en nuestras costas.',
    link: '/mareas',
    icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>'
  },
  {
    title: 'Especies Locales',
    description: 'Conoce a fondo los peces de nuestras aguas: vieja, sargo, mero y muchos más. Técnicas y mejores cebos.',
    link: '/especies',
    icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>'
  },
  {
    title: 'Tienda de Aparejos',
    description: 'Equípate con cañas, carretes y los mejores hilos para enfrentar cualquier captura en el Atlántico.',
    link: '/tienda',
    icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>'
  }
]
</script>

<style scoped>
.nautical-card {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.nautical-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
}
</style>
