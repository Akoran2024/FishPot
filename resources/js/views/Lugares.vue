<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
      <div class="animate-fade-in">
        <h2 class="text-primary-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Descubre Lanzarote</h2>
        <h1 class="text-5xl font-black text-primary-950 leading-tight">Lugares de Pesca</h1>
        <p class="text-primary-500 mt-4 font-medium max-w-xl">Explora los mejores puntos de pesca en las costas de Lanzarote, su dificultad, descripción y recomendaciones.
          Tenga en cuenta que en nuestra web sólo mostraremos la zona, nunca los puntos exactos, ya que nuestro objetivo es que no se saturen los pesqueros.
        </p>
      </div>
      
      <div class="w-full md:w-auto flex flex-col sm:flex-row gap-4 animate-fade-in">
        <div class="relative group">
          <input type="text" v-model="search" placeholder="Buscar lugar..." class="w-full sm:w-64 px-6 py-4 bg-white/80 backdrop-blur-md border border-primary-200 rounded-2xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-400 outline-none transition shadow-sm group-hover:shadow-md">
          <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
      </div>
    </div>

    <div v-if="filteredPlaces.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      <div 
        v-for="place in filteredPlaces" 
        :key="place.id" 
        @click="selectedPlace = place"
        class="group bg-white/80 backdrop-blur-sm rounded-[2.5rem] shadow-xl hover:shadow-2xl transition-all duration-500 border border-primary-200 overflow-hidden cursor-pointer transform hover:-translate-y-2"
      >
        <div class="h-64 relative overflow-hidden">
           <img 
            v-if="place.image"
            :src="place.image" 
            :alt="place.name"
            class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
           />
           <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 opacity-40">
              <svg class="h-20 w-20 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
           </div>
           
           <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

           <div class="absolute top-6 right-6 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black text-primary-800 uppercase tracking-widest shadow-lg">
             {{ place.solo_or_accompanied }}
           </div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col mb-4">
            <h2 class="text-2xl font-black text-primary-900 group-hover:text-primary-600 transition duration-300">{{ place.name }}</h2>
          </div>
          
          <div class="flex items-center justify-between pt-6 border-t border-primary-50">
            <span class="text-[10px] font-black text-primary-400 uppercase tracking-widest">Dificultad</span>
            <div class="flex space-x-1.5">
              <div v-for="i in 3" :key="i" :class="i <= place.difficulty ? 'bg-primary-500' : 'bg-primary-100'" class="h-1.5 w-6 rounded-full shadow-inner transition-colors duration-500"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-else class="text-center py-32 bg-white/50 backdrop-blur-md rounded-[3rem] border-2 border-dashed border-primary-200">
      <div class="max-w-xs mx-auto">
        <svg class="w-16 h-16 mx-auto mb-6 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <p class="text-primary-500 font-bold text-lg">No encontramos ese lugar de pesca en nuestras costas.</p>
        <button @click="search = ''" class="mt-6 text-primary-600 font-black text-sm uppercase tracking-widest hover:text-primary-800 transition">Ver todos</button>
      </div>
    </div>

    <!-- Modal con Glassmorphism -->
    <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
      <div v-if="selectedPlace" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="absolute inset-0 bg-primary-950/40 backdrop-blur-md" @click="selectedPlace = null"></div>
        
        <div class="relative bg-white/90 backdrop-blur-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-[3rem] shadow-2xl border border-white/50">
          <button 
            @click="selectedPlace = null" 
            class="absolute top-6 right-6 z-10 p-3 bg-white hover:bg-primary-50 rounded-2xl text-primary-900 transition shadow-xl group"
          >
            <svg class="h-6 w-6 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 h-[400px] lg:h-auto relative">
              <img 
                v-if="selectedPlace.image"
                :src="selectedPlace.image" 
                :alt="selectedPlace.name"
                class="w-full h-full object-cover"
              />
              <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 opacity-40">
                  <svg class="h-32 w-32 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
              </div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent lg:hidden"></div>
            </div>
            
            <div class="w-full lg:w-1/2 p-10 lg:p-16">
              <div class="flex items-center space-x-3 mb-8">
                <span class="px-4 py-1.5 bg-primary-900 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">
                  {{ selectedPlace.solo_or_accompanied }}
                </span>
                <span class="px-4 py-1.5 bg-accent-500 text-primary-950 rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">
                  Dificultad: {{ selectedPlace.difficulty }}
                </span>
              </div>
              
              <h2 class="text-5xl font-black text-primary-950 leading-tight mb-4">{{ selectedPlace.name }}</h2>
              
            <div class="space-y-8">
                <div>
                  <h4 class="text-primary-900 font-black uppercase text-xs tracking-[0.2em] mb-4">Descripción</h4>
                  <p class="text-primary-600 leading-relaxed font-medium text-lg">
                    {{ selectedPlace.description }}
                  </p>
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
                          place.description.toLowerCase().includes(search.value.toLowerCase()) ||
                          place.solo_or_accompanied.toLowerCase().includes(search.value.toLowerCase());
    
    return matchesSearch;
  })
})
</script>
