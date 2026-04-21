<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-nautical-200 pb-12">
      <div class="max-w-2xl">
        <h2 class="text-primary-800 font-serif italic text-sm tracking-[0.2em] uppercase mb-4">Costa de Lanzarote</h2>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 leading-tight tracking-tight italic">Lugares de Pesca</h1>
        <p class="text-nautical-600 mt-6 font-serif italic text-lg leading-relaxed">Explore los rincones de nuestra costa. Un mapa de sensaciones y desafíos para el pescador que respeta el entorno. Recuerde: el secreto del buen pesquero es el silencio.</p>
      </div>

      <div class="w-full md:w-auto">
        <div class="relative">
          <input type="text" v-model="search" placeholder="Buscar lugar..." class="w-full sm:w-64 px-5 py-3 bg-white border border-nautical-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-700 outline-none transition font-serif italic text-sm">
          <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-nautical-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
      </div>
    </div>

    <div v-if="filteredPlaces.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
      <div 
        v-for="place in filteredPlaces" 
        :key="place.id" 
        @click="selectedPlace = place"
        class="nautical-card group cursor-pointer border-b-4 border-primary-100 hover:border-primary-700 transition-all duration-500"
      >
        <div class="h-64 relative overflow-hidden bg-nautical-50">
           <img 
            v-if="place.image"
            :src="place.image" 
            :alt="place.name"
            class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition duration-700 group-hover:scale-105"
           />
           <div class="absolute inset-0 bg-gradient-to-t from-primary-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
           
           <div class="absolute top-4 right-4 bg-white/90 px-3 py-1 border border-nautical-200 text-[9px] font-bold text-primary-950 uppercase tracking-widest shadow-sm">
             {{ place.solo_or_accompanied === 'solo' ? 'solo' : 'acompañado' }}
           </div>
        </div>
        
        <div class="p-8">
          <h2 class="text-3xl font-serif font-black text-primary-950 group-hover:text-primary-700 transition duration-300 italic mb-4">{{ place.name }}</h2>
          <div class="flex items-center justify-between pt-6 border-t border-nautical-100">
            <span class="text-[10px] font-bold text-nautical-300 uppercase tracking-widest italic">Nivel de desafío</span>
            <div class="flex space-x-1.5">
              <div v-for="i in 3" :key="i" :class="i <= place.difficulty ? 'bg-primary-800' : 'bg-nautical-200'" class="h-1.5 w-6 rounded-sm"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Lugar -->
    <transition name="page">
      <div v-if="selectedPlace" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-primary-950/60 backdrop-blur-sm" @click="selectedPlace = null"></div>
        
        <div class="relative bg-white w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-lg shadow-2xl border-4 border-white">
          <button @click="selectedPlace = null" class="absolute top-6 right-6 z-10 p-2 bg-nautical-100 hover:bg-nautical-200 text-primary-900 transition">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 h-[400px] lg:h-auto">
              <img 
                v-if="selectedPlace.image"
                :src="selectedPlace.image" 
                :alt="selectedPlace.name"
                class="w-full h-full object-cover border-r border-nautical-100"
              />
            </div>
            
            <div class="w-full lg:w-1/2 p-10 lg:p-16">
              <div class="flex items-center space-x-3 mb-8">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-800 border-b-2 border-primary-800 pb-1">Cuaderno de Bitácora</span>
              </div>
              
              <h2 class="text-5xl font-serif font-black text-primary-950 leading-tight mb-8 italic">{{ selectedPlace.name }}</h2>
              
              <div class="space-y-8">
                <div>
                  <h4 class="text-nautical-400 font-serif italic text-xs tracking-[0.2em] mb-4 uppercase">Notas del Terreno</h4>
                  <p class="text-primary-900 leading-relaxed font-serif text-lg italic">
                    "{{ selectedPlace.description }}"
                  </p>
                </div>
                
                <div class="pt-10 border-t border-nautical-100 flex items-center justify-between">
                   <div>
                     <span class="block text-[10px] font-bold text-nautical-400 uppercase tracking-widest mb-1 italic">Recomendación</span>
                     <span class="font-serif font-black text-primary-900 italic capitalize">{{ selectedPlace.solo_or_accompanied === 'solo' ? 'solo' : 'acompañado' }}</span>
                   </div>
                   <div class="text-primary-200">
                     <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const search = ref('')
const selectedPlace = ref(null)

const places = [
  { 
    id: 1, name: 'La Santa', difficulty: 3, 
    description: 'Conocido spot para la pesca de altura y fondo. Requiere experiencia. Famoso por sus fuertes corrientes y grandes olas, ideal para surfcasting y pesca con boya. La zona de los "Tubos" ofrece buenos ejemplares de sargos y pargos.', 
    solo_or_accompanied: 'acompañado', image: '/imagenes/lasanta.jpg'  
  },
  { 
    id: 2, name: 'Playa Blanca', difficulty: 1, 
    description: 'Ideal para pesca con caña desde la orilla, apto para principiantes. Sus aguas tranquilas y accesibles la hacen perfecta para la pesca familiar. Se pueden capturar bogas, sargos pequeños y herreras.', 
    solo_or_accompanied: 'solo', image: '/imagenes/playablanca.webp' 
  },
  { 
    id: 3, name: 'Orzola', difficulty: 2, 
    description: 'Zona rocosa con buena variedad de especies. Se recomienda precaución. Las rocas cercanas al muelle son excelentes para la pesca a fondo. Abundan viejas, sargos y a veces algún mero pequeño.', 
    solo_or_accompanied: 'solo', image: '/imagenes/orzola.webp' 
  },
  { 
    id: 4, name: 'El Golfo', difficulty: 2, 
    description: 'Paisaje espectacular para pescar, aunque el acceso puede ser complicado. La caleta ofrece protección y buenas capturas de sargos y morenas. Requiere caminar por terreno irregular.', 
    solo_or_accompanied: 'acompañado', image: '/imagenes/golfo.webp' 
  },
  { 
    id: 5, name: 'Puerto del Carmen', difficulty: 2, 
    description: 'Pesca desde el muelle o en las pequeñas calas. Fácil acceso y variedad de peces. Ideal para la pesca a flotador y fondo. Se pueden encontrar salemas, sargos y, ocasionalmente, pulpos.', 
    solo_or_accompanied: 'solo', image: '/imagenes/puertodelcarmen.jpg' 
  },
  { 
    id: 6, name: 'Famara', difficulty: 3, 
    description: 'Playa extensa con fuertes corrientes, ideal para surfcasting experimentado. Famosa por sus grandes ejemplares de corvinas y, en temporada, lisas. Solo para pescadores con experiencia.', 
    solo_or_accompanied: 'acompañado', image: '/imagenes/famara.jpg' 
  },
]

const filteredPlaces = computed(() => {
  return places.filter(place => {
    const matchesSearch = place.name.toLowerCase().includes(search.value.toLowerCase()) || 
                          place.description.toLowerCase().includes(search.value.toLowerCase());
    return matchesSearch;
  })
})
</script>

<style scoped>
.nautical-card {
  @apply bg-white/50 backdrop-blur-md border border-nautical-200 shadow-2xl transition-all duration-300;
}
.page-enter-active, .page-leave-active { transition: all 0.4s ease-out; }
.page-enter-from { opacity: 0; transform: translateY(10px); }
.page-leave-to { opacity: 0; transform: translateY(-10px); }
</style>
