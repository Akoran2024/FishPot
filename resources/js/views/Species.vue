<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-nautical-200 dark:border-white/10 pb-12">
      <div class="max-w-2xl">
        <h2 class="text-primary-800 dark:text-primary-400 font-serif italic text-sm tracking-[0.2em] uppercase mb-4">Biodiversidad de Lanzarote</h2>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 dark:text-white leading-tight tracking-tight italic">Guía de Especies</h1>
        <p class="text-nautical-600 dark:text-nautical-300 mt-6 font-serif italic text-lg leading-relaxed">Un registro detallado de las especies que habitan nuestras aguas. Conozca sus tallas mínimas, hábitats y artes de pesca recomendadas.</p>
      </div>
      
      <div class="w-full md:w-auto flex flex-col sm:flex-row gap-4">
        <div class="flex bg-white dark:bg-primary-900/40 p-1 rounded-lg border border-nautical-200 dark:border-white/10 shadow-sm backdrop-blur-md">
          <button 
            @click="category = 'all'" 
            :class="category === 'all' ? 'bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950' : 'text-nautical-500 dark:text-primary-400 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Todas
          </button>
          <button 
            @click="category = 'pez'" 
            :class="category === 'pez' ? 'bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950' : 'text-nautical-500 dark:text-primary-400 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Peces
          </button>
          <button 
            @click="category = 'molusco'" 
            :class="category === 'molusco' ? 'bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950' : 'text-nautical-500 dark:text-primary-400 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Moluscos
          </button>
        </div>
        <div class="relative">
          <input type="text" v-model="search" placeholder="Buscar especie..." class="w-full sm:w-64 px-5 py-3 bg-white dark:bg-primary-950/50 border border-nautical-300 dark:border-white/10 rounded-lg focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-500/20 focus:border-primary-700 dark:focus:border-primary-500 outline-none transition font-serif italic text-sm dark:text-white">
          <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-nautical-400 dark:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
      </div>
    </div>

    <div v-if="filteredSpecies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
      <div 
        v-for="fish in filteredSpecies" 
        :key="fish.id" 
        @click="selectedSpecies = fish"
        class="nautical-card group cursor-pointer transition-all duration-500 hover:-translate-y-2 border-b-4 border-b-primary-100 dark:border-b-primary-900 hover:border-b-primary-700 dark:hover:border-b-primary-500 hover-shine"
      >
        <div class="h-72 relative overflow-hidden bg-nautical-50 dark:bg-primary-950">
           <img 
            v-if="fish.image"
            :src="fish.image" 
            :alt="fish.name"
            class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition duration-700 group-hover:scale-105 dark:brightness-75 dark:group-hover:brightness-100"
           />
           <div v-else :class="fish.color" class="w-full h-full flex items-center justify-center opacity-20 italic font-serif text-white">
              Sin imagen
           </div>
           
           <div class="absolute inset-0 bg-gradient-to-t from-primary-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

           <div class="absolute top-4 right-4 bg-white/90 dark:bg-primary-900/90 px-3 py-1 rounded border border-nautical-200 dark:border-white/10 text-[9px] font-bold text-primary-900 dark:text-primary-300 uppercase tracking-widest shadow-sm">
             {{ fish.type === 'pez' ? 'Pez' : 'Molusco' }}
           </div>
           
           <div class="absolute bottom-6 left-6 bg-white dark:bg-primary-950 px-4 py-2 border-l-4 border-primary-800 dark:border-primary-500 shadow-xl">
             <span class="text-[10px] font-bold text-nautical-400 dark:text-primary-400/60 uppercase tracking-widest block leading-none mb-1 italic">Talla Mínima</span>
             <span class="text-lg font-serif font-black text-primary-950 dark:text-white italic leading-none">{{ fish.size }}</span>
           </div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col mb-4">
            <h2 class="text-2xl font-serif font-black text-primary-950 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-400 transition duration-300 italic leading-none mb-1">{{ fish.name }}</h2>
            <span v-if="fish.vulgar" class="text-sm font-serif italic text-primary-600 dark:text-primary-400/70">{{ fish.vulgar }}</span>
          </div>
          <p class="text-nautical-400 dark:text-primary-500 italic text-xs mb-6 font-medium uppercase tracking-[0.2em]">{{ fish.latin }}</p>
          
          <div class="flex items-center justify-between pt-6 border-t border-nautical-100 dark:border-white/5">
            <span class="text-[10px] font-bold text-nautical-300 dark:text-primary-600 uppercase tracking-widest italic">Dificultad de captura</span>
            <div class="flex space-x-1.5">
              <div v-for="i in 3" :key="i" :class="i <= fish.difficulty ? 'bg-primary-800 dark:bg-primary-400' : 'bg-nautical-200 dark:bg-primary-900'" class="h-1.5 w-6 rounded-sm transition-colors duration-500"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-else class="text-center py-32 nautical-card border-2 border-dashed border-primary-100 dark:border-white/5 bg-white/40 dark:bg-primary-950/20">
      <p class="text-primary-950 dark:text-white font-serif font-black italic text-2xl mb-4">Aguas tranquilas...</p>
      <p class="text-nautical-400 dark:text-primary-300/60 font-serif italic text-lg max-w-md mx-auto mb-8">No encontramos registros de esa especie en nuestras bitácoras.</p>
      <button @click="search = ''; category = 'all'" class="text-primary-800 dark:text-primary-400 font-serif font-bold italic border-b border-primary-800 dark:border-primary-400 hover:text-primary-600 transition-colors">Ver todo el catálogo</button>
    </div>

    <!-- Modal Estilo Antiguo Mejorado y Compacto (Imagen Arriba) -->
    <transition name="modal-nautical">
      <div v-if="selectedSpecies" class="fixed inset-0 z-[100] overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-primary-950/80 dark:bg-black/90 backdrop-blur-md transition-opacity" @click="selectedSpecies = null"></div>
        
        <!-- Modal Centering Wrapper -->
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6 lg:p-8">
          <!-- Modal Container -->
          <div class="relative bg-white dark:bg-primary-950 w-full max-w-3xl max-h-[75vh] rounded-3xl shadow-[0_0_100px_rgba(0,0,0,0.5)] border-4 border-white dark:border-white/5 transform transition-all flex flex-col overflow-hidden text-left">
            
            <!-- Close Button -->
            <button @click="selectedSpecies = null" class="absolute top-4 right-4 z-50 p-2 bg-white/20 dark:bg-black/20 hover:bg-white/40 backdrop-blur-md text-white rounded-full transition-all border border-white/30 hover:scale-110 active:scale-95 shadow-lg">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <!-- Scrollable Content Wrapper -->
            <div class="overflow-y-auto w-full">
              <!-- Header: Visual Area -->
              <div class="relative w-full h-48 lg:h-64 overflow-hidden bg-nautical-900 flex-shrink-0 group">
                <img 
                  v-if="selectedSpecies.image"
                  :src="selectedSpecies.image" 
                  :alt="selectedSpecies.name"
                  class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110 dark:brightness-75 dark:group-hover:brightness-90"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/20 to-transparent"></div>

                <div class="absolute bottom-6 left-8 right-8">
                   <div class="flex items-center space-x-2 mb-2">
                     <span class="px-2 py-0.5 bg-primary-500 text-white text-[8px] font-black uppercase tracking-widest rounded shadow-md">Especie Marina</span>
                   </div>
                   <h2 class="text-3xl lg:text-5xl font-serif font-black text-white italic drop-shadow-xl leading-tight tracking-tighter">{{ selectedSpecies.name }}</h2>
                   <p class="text-white/70 italic font-serif text-sm tracking-widest uppercase mt-1">{{ selectedSpecies.latin }}</p>
                </div>
              </div>

              <!-- Content Area -->
              <div class="p-6 lg:p-10 bg-[#fcfcf9] dark:bg-primary-950 relative">
                <!-- Decorative background elements -->
                <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.05] pointer-events-none" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
                  <!-- Main Description -->
                  <div class="lg:col-span-2 space-y-8">
                    <div>
                      <h4 class="text-primary-800 dark:text-primary-400 font-serif italic text-[10px] tracking-[0.2em] mb-4 uppercase flex items-center">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        Descripción del Registro
                      </h4>
                      <p class="text-primary-950 dark:text-white leading-relaxed font-serif text-lg lg:text-xl italic">
                        "{{ selectedSpecies.description }}"
                      </p>
                    </div>

                    <!-- Curiosity Section -->
                    <div v-if="selectedSpecies.curiosity" class="bg-primary-50/50 dark:bg-white/5 p-6 rounded-xl border border-primary-100/50 dark:border-white/5 relative overflow-hidden group">
                      <h4 class="text-primary-950 dark:text-primary-300 font-serif font-black italic text-xs mb-2 flex items-center tracking-tight">
                        <span class="w-1 h-1 bg-primary-600 dark:bg-primary-500 rounded-full mr-2"></span>
                        Sabiduría del Puerto
                      </h4>
                      <p class="text-nautical-800 dark:text-primary-100 text-sm font-serif italic leading-relaxed">{{ selectedSpecies.curiosity }}</p>
                    </div>
                  </div>

                  <!-- Technical Data Sidebar -->
                  <div class="space-y-6">
                    <div class="bg-white dark:bg-primary-900/40 p-6 rounded-xl shadow-lg border border-nautical-100 dark:border-white/10 space-y-6 backdrop-blur-md">
                      <h4 class="text-[9px] font-black text-primary-950 dark:text-white uppercase tracking-[0.15em] border-b border-nautical-100 dark:border-white/10 pb-3">Ficha de Bitácora</h4>
                      
                      <div class="space-y-4">
                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 dark:text-primary-500 uppercase tracking-widest mb-1 italic">Hábitat</span>
                          <span class="font-serif font-black text-primary-950 dark:text-white text-base italic">{{ selectedSpecies.habitat || 'Costa' }}</span>
                        </div>

                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 dark:text-primary-500 uppercase tracking-widest mb-1 italic">Cebo</span>
                          <span class="font-serif font-black text-primary-700 dark:text-primary-400 text-base italic">{{ selectedSpecies.bait || 'Varios' }}</span>
                        </div>

                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 dark:text-primary-500 uppercase tracking-widest mb-1 italic">Talla Mínima</span>
                          <span class="font-serif font-black text-emerald-700 dark:text-emerald-400 text-base italic">{{ selectedSpecies.size }}</span>
                        </div>

                        <div>
                          <span class="block text-[9px] font-bold text-nautical-400 dark:text-primary-500 uppercase tracking-widest mb-1 italic">Dificultad</span>
                          <div class="flex space-x-1">
                            <div v-for="i in 3" :key="i" :class="i <= selectedSpecies.difficulty ? 'bg-primary-800 dark:bg-primary-500' : 'bg-nautical-100 dark:bg-primary-950'" class="h-1.5 w-full rounded-full"></div>
                          </div>
                        </div>
                      </div>

                      <button @click="selectedSpecies = null" class="w-full py-3 bg-primary-950 dark:bg-primary-500 text-white dark:text-primary-950 rounded-lg font-serif italic font-black uppercase text-[10px] tracking-[0.1em] hover:bg-primary-800 dark:hover:bg-primary-400 transition-all shadow-md active:scale-95">
                        Cerrar Ficha
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Footer Decorative -->
                <div class="mt-12 pt-6 border-t border-nautical-100 dark:border-white/5 flex justify-between items-center opacity-30 dark:opacity-10">
                   <span class="text-[7px] font-black uppercase tracking-[0.4em] dark:text-white">FishPot Registry</span>
                   <div class="flex space-x-3">
                      <div class="h-0.5 w-0.5 bg-primary-950 dark:bg-white rounded-full"></div>
                      <div class="h-0.5 w-0.5 bg-primary-950 dark:bg-white rounded-full"></div>
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
const category = ref('all')
const selectedSpecies = ref(null)

const species = [
  { 
    id: 1, type: 'molusco', name: 'Cangrejo moro o negro', latin: 'Grapsus adscensionis', size: '60 mm', 
    description: 'Es el cangrejo más emblemático de las zonas intermareales canarias. Muy ágil y difícil de capturar manualmente.', 
    habitat: 'Zonas rocosas de costa', bait: 'No aplica', curiosity: 'Sus pinzas son extremadamente fuertes para romper pequeñas conchas.',
    difficulty: 2, color: 'bg-primary-800', image: '/imagenes/cangrejomoro.jpg'  
  },
  { 
    id: 2, type: 'molusco', name: 'Cangrejo blanco', latin: 'Plagusia depressa', size: '50 mm', 
    description: 'Cangrejo de caparazón más aplanado que el moro, suele estar más sumergido y es muy rápido.', 
    habitat: 'Rocas batidas por el mar', bait: 'No aplica', curiosity: 'Su cuerpo plano le permite esconderse en grietas muy estrechas.',
    difficulty: 2, color: 'bg-primary-400', image: '/imagenes/cangrejoblanco.jpg' 
  },
  { 
    id: 3, type: 'molusco', name: 'Lapa blanca', latin: 'Patella ulyssiponensis aspera', size: '45 mm', 
    description: 'Molusco univalvo que vive pegado a las rocas. Muy apreciada en la cocina canaria.', 
    habitat: 'Zona baja del intermareal', bait: 'No aplica', curiosity: 'La fuerza con la que se adhiere a la roca es equivalente a cientos de veces su peso.',
    difficulty: 1, color: 'bg-secondary-200', image: '/imagenes/lapablanca.jpg' 
  },
  { 
    id: 8, type: 'molusco', name: 'Pulpo común', latin: 'Octopus vulgaris', size: '1 kg', 
    description: 'Uno de los cefalópodos más inteligentes. Se mimetiza perfectamente con el entorno rocoso de Lanzarote.', 
    habitat: 'Fondos rocosos y cuevas', bait: 'Cangrejo o pota', curiosity: 'Tiene tres corazones y su sangre es de color azul.',
    difficulty: 3, color: 'bg-secondary-400', image: '/imagenes/pulpocomun.jpg' 
  },
  { 
    id: 10, type: 'pez', name: 'Aligote', vulgar: 'Besugo', latin: 'Pagellus acarne', size: '12 cm', 
    description: 'Pez de cuerpo ovalado y color plateado-rosáceo. Es muy común en capturas desde embarcación.', 
    habitat: 'Fondos arenosos y mixtos', bait: 'Gamba o lombriz', curiosity: 'Se diferencia del besugo por tener la mancha negra justo en la axila de la aleta.',
    difficulty: 2, color: 'bg-secondary-200', image: '/imagenes/aligote.jpg' 
  },
  { 
    id: 13, type: 'pez', name: 'Chopa', vulgar: 'Chopa, negrón', latin: 'Spondyliosoma cantharus', size: '19 cm', 
    description: 'Pez de color grisáceo con líneas longitudinales amarillentas. Muy combativo para su tamaño.', 
    habitat: 'Fondos rocosos y sebadales', bait: 'Pan o gamba', curiosity: 'Durante la época de desove, los machos excavan un nido en la arena.',
    difficulty: 2, color: 'bg-primary-500', image: '/imagenes/chopa.jpg'
  },
  { 
    id: 14, type: 'pez', name: 'Estornino', vulgar: 'Caballa', latin: 'Scomber colias', size: '20 cm', 
    description: 'Pez azul muy abundante. Se reconoce por las manchas irregulares en su lomo verde azulado.', 
    habitat: 'Aguas libres (pelágico)', bait: 'Sardina o cucharilla', curiosity: 'Es un nadador incansable; no tiene vejiga natatoria y debe nadar para no hundirse.',
    difficulty: 2, color: 'bg-primary-300', image: '/imagenes/estornino.jpg'
  },
  { 
    id: 15, type: 'pez', name: 'Gitano', vulgar: 'Abade, abadejo', latin: 'Mycteroperca fusca', size: '35 cm', 
    description: 'Uno de los depredadores más nobles de Canarias. Su carne es excelente y muy valorada.', 
    habitat: 'Fondos rocosos profundos', bait: 'Vivo o jigging', curiosity: 'Los ejemplares más grandes suelen ser solitarios y territoriales.',
    difficulty: 3, color: 'bg-primary-700', image: '/imagenes/gitano.jpg' 
  },
  { 
    id: 16, type: 'pez', name: 'Jurel', vulgar: 'Chicharro', latin: 'Trachurus trachurus', size: '15 cm', 
    description: 'Pez pelágico muy activo y veloz. Suele moverse en grandes bancos cerca de la superficie.', 
    habitat: 'Aguas abiertas cerca de costa', bait: 'Cucharilla o vivo', curiosity: 'Su línea lateral tiene escamas en forma de escudo muy duras.',
    difficulty: 2, color: 'bg-primary-400', image: '/imagenes/jurel.jpg' 
  },
  { 
    id: 17, type: 'pez', name: 'Loro viejo', vulgar: 'Vieja', latin: 'Sparisoma cretense', size: '20 cm', 
    description: 'El pez más icónico de Canarias. Posee colores vibrantes, especialmente las hembras que son rojas y amarillas.', 
    habitat: 'Arrecifes y sebadales', bait: 'Cangrejo blanco', curiosity: 'Tiene un "pico" similar al de un loro que usa para raspar algas de las rocas.',
    difficulty: 2, color: 'bg-primary-500', image: '/imagenes/vieja.jpg'  
  },
  { 
    id: 18, type: 'pez', name: 'Mero', vulgar: 'Mero', latin: 'Epinephelus marginatus', size: '45 cm', 
    description: 'El gigante de los fondos canarios. Puede vivir muchos años y alcanzar tamaños impresionantes.', 
    habitat: 'Grandes cuevas submarinas', bait: 'Pulpo o calamar', curiosity: 'Es hermafrodita: nace hembra y con el tiempo puede convertirse en macho.',
    difficulty: 3, color: 'bg-secondary-800', image: '/imagenes/mero.jpg'
  },
  { 
    id: 21, type: 'pez', name: 'Pargo', vulgar: 'Bocinegro, pargo, palleta', latin: 'Pagrus pagrus', size: '33 cm', 
    description: 'Pez de color rosado intenso, muy fuerte. Es uno de los reyes de la pesca de fondo.', 
    habitat: 'Fondos rocosos limpios', bait: 'Gamba o calamar', curiosity: 'Su nombre "bocinegro" viene del color oscuro de su boca.',
    difficulty: 2, color: 'bg-primary-300', image: '/imagenes/pargo.jpeg'   
  },
  { 
    id: 22, type: 'pez', name: 'Salpa', vulgar: 'Salema', latin: 'Sarpa salpa', size: '24 cm', 
    description: 'Pez herbívoro de color plateado con líneas doradas. Suele nadar en bancos muy numerosos.', 
    habitat: 'Zonas de algas en rocas', bait: 'Algas o pan', curiosity: 'Es de los pocos peces canarios que se alimenta casi exclusivamente de algas.',
    difficulty: 1, color: 'bg-secondary-200', image: '/imagenes/salema.jpg' 
  },
  { 
    id: 26, type: 'pez', name: 'Sargo', vulgar: 'Sargo, sargo blanco', latin: 'Diplodus sargus', size: '22 cm', 
    description: 'El rey del ropaje. Pez muy fuerte que vive en el rompiente de las olas.', 
    habitat: 'Zonas de mucha espuma', bait: 'Cangrejo o langostino', curiosity: 'Sus dientes frontales se parecen mucho a los humanos.',
    difficulty: 2, color: 'bg-primary-300', image: '/imagenes/sargo.jpg' 
  },
  { 
    id: 28, type: 'pez', name: 'Patudo', vulgar: 'Tuna', latin: 'Thunnus obesus', size: '3,2 kg', 
    description: 'Túnido de gran tamaño. Una de las pescas más deportivas y exigentes que se pueden hacer en Lanzarote.', 
    habitat: 'Aguas oceánicas profundas', bait: 'Curricán o vivo', curiosity: 'Puede regular su temperatura corporal por encima de la del agua.',
    difficulty: 3, color: 'bg-primary-800', image: '/imagenes/patudo.jpg' 
  }
]

const filteredSpecies = computed(() => {
  return species.filter(fish => {
    const matchesSearch = fish.name.toLowerCase().includes(search.value.toLowerCase()) || 
                         fish.latin.toLowerCase().includes(search.value.toLowerCase()) ||
                         (fish.vulgar && fish.vulgar.toLowerCase().includes(search.value.toLowerCase()));
    const matchesCategory = category.value === 'all' || fish.type === category.value;
    return matchesSearch && matchesCategory;
  })
})
</script>

<style scoped>
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

/* Scrollbar styling for the modal content */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}
.overflow-y-auto::-webkit-scrollbar-track {
  @apply bg-transparent;
}
.overflow-y-auto::-webkit-scrollbar-thumb {
  @apply bg-nautical-200 rounded-full;
}
</style>