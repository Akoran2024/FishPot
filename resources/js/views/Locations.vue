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

    <div v-else class="text-center py-32 bg-white/50 border-2 border-dashed border-nautical-200">
      <p class="text-nautical-400 font-serif italic text-lg">No encontramos registros en nuestras bitácoras.</p>
      <button @click="search = '';" class="mt-6 text-primary-800 font-serif font-bold italic border-b border-primary-800">Ver todo el catálogo</button>
    </div>

    <!-- Modal Lugar Rediseñado y Compacto -->
    <transition name="modal-nautical">
      <div v-if="selectedPlace" class="fixed inset-0 z-[100] overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-primary-950/80 backdrop-blur-md transition-opacity" @click="selectedPlace = null"></div>
        
        <!-- Modal Centering Wrapper -->
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6 lg:p-8">
          <!-- Modal Container -->
          <div class="relative bg-white w-full max-w-3xl max-h-[75vh] rounded-3xl shadow-[0_0_100px_rgba(0,0,0,0.5)] border-4 border-white transform transition-all flex flex-col overflow-hidden text-left">

            <!-- Close Button -->
            <button @click="selectedPlace = null" class="absolute top-4 right-4 z-50 p-2 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white rounded-full transition-all border border-white/30 hover:scale-110 active:scale-95 shadow-lg">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <!-- Scrollable Content Wrapper -->
            <div class="overflow-y-auto w-full">
              <!-- Header: Visual Area -->
              <div class="relative w-full h-48 lg:h-64 overflow-hidden bg-nautical-900 flex-shrink-0 group">
                <img 
                  v-if="selectedPlace.image"
                  :src="selectedPlace.image" 
                  :alt="selectedPlace.name"
                  class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/20 to-transparent"></div>

                <div class="absolute bottom-6 left-8 right-8">
                   <div class="flex items-center space-x-2 mb-2">
                     <span class="px-2 py-0.5 bg-primary-500 text-white text-[8px] font-black uppercase tracking-widest rounded shadow-md">Costa</span>
                   </div>
                   <h2 class="text-3xl lg:text-5xl font-serif font-black text-white italic drop-shadow-xl leading-tight tracking-tighter">{{ selectedPlace.name }}</h2>
                </div>
              </div>

              <!-- Content Area -->
              <div class="p-6 lg:p-12 bg-[#fcfcf9] relative">
                <div class="absolute inset-0 opacity-[0.02] pointer-events-none" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
                  <div class="lg:col-span-2 space-y-8">
                    <div>
                      <h4 class="text-primary-800 font-serif italic text-[10px] tracking-[0.2em] mb-4 uppercase flex items-center">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                        Crónica
                      </h4>
                      <p class="text-primary-950 leading-relaxed font-serif text-lg lg:text-xl italic">
                        "{{ selectedPlace.description }}"
                      </p>
                    </div>

                    <div class="bg-primary-50/50 p-6 rounded-xl border border-primary-100/50 flex items-center gap-4">
                       <p class="text-primary-800 font-serif italic text-xs leading-relaxed">
                         Recuerde consultar la tabla de mareas y la fuerza del viento antes de navegar estas aguas.
                       </p>
                    </div>
                  </div>

                  <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-nautical-100 space-y-6">
                      <h4 class="text-[9px] font-black text-primary-950 uppercase tracking-[0.15em] border-b border-nautical-100 pb-3">Bitácora</h4>
                      
                      <div class="space-y-4">
                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 uppercase tracking-widest mb-1 italic">Dificultad</span>
                          <div class="flex space-x-1">
                            <div v-for="i in 3" :key="i" :class="i <= selectedPlace.difficulty ? 'bg-primary-800' : 'bg-nautical-100'" class="h-1.5 w-full rounded-full transition-colors duration-700"></div>
                          </div>
                        </div>

                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 uppercase tracking-widest mb-1 italic">Compañía</span>
                          <div class="flex items-center space-x-2 text-primary-950">
                            <span class="font-serif font-black italic text-lg capitalize">{{ selectedPlace.solo_or_accompanied }}</span>
                          </div>
                        </div>
                      </div>

                      <button @click="selectedPlace = null" class="w-full py-3 bg-primary-950 text-white rounded-lg font-serif italic font-black uppercase text-[10px] tracking-[0.1em] hover:bg-primary-800 transition-all shadow-md active:scale-95">
                        Cerrar
                      </button>
                    </div>
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

.modal-nautical-enter-active, .modal-nautical-leave-active { 
  transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); 
}
.modal-nautical-enter-from { 
  opacity: 0; 
  transform: scale(0.95) translateY(20px); 
}
.modal-nautical-leave-to { 
  opacity: 0; 
  transform: scale(1.05) translateY(-20px); 
}

/* Custom scrollbar for immersive feel */
.overflow-y-auto::-webkit-scrollbar {
  width: 5px;
}
.overflow-y-auto::-webkit-scrollbar-track {
  @apply bg-transparent;
}
.overflow-y-auto::-webkit-scrollbar-thumb {
  @apply bg-nautical-200 rounded-full;
}
</style>