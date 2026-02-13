<template>

  <!-- imagen -->
   <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950 via-primary-900/80 to-transparent z-10"></div>
        <img src="https://www.diariodelanzarote.com/sites/default/files/archivos/2015/Julio%202015/230720-pescador660.jpeg" alt="Fishing Background" class="w-full h-full object-cover">
      </div>

  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
      <div class="animate-fade-in">
        <h2 class="text-accent-600 font-bold tracking-[0.2em] uppercase text-sm mb-4">Biodiversidad de Lanzarote</h2>
        <h1 class="text-5xl font-black text-slate-900 leading-tight">Guía de Especies</h1>
        <p class="text-slate-500 mt-4 font-medium max-w-xl">Conoce las tallas mínimas, hábitats y curiosidades de las especies que habitan nuestras costas.</p>
      </div>
      
      <div class="w-full md:w-auto flex flex-col sm:flex-row gap-4 animate-fade-in">
        <div class="flex bg-white/50 backdrop-blur-md p-1.5 rounded-2xl border border-white shadow-sm">
          <button 
            @click="category = 'all'" 
            :class="category === 'all' ? 'bg-primary-900 text-white shadow-lg' : 'text-slate-500 hover:text-primary-700'"
            class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
          >
            Todos
          </button>
          <button 
            @click="category = 'pez'" 
            :class="category === 'pez' ? 'bg-primary-900 text-white shadow-lg' : 'text-slate-500 hover:text-primary-700'"
            class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
          >
            Peces
          </button>
          <button 
            @click="category = 'molusco'" 
            :class="category === 'molusco' ? 'bg-primary-900 text-white shadow-lg' : 'text-slate-500 hover:text-primary-700'"
            class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
          >
            Moluscos
          </button>
        </div>
        <div class="relative group">
          <input type="text" v-model="search" placeholder="Buscar especie..." class="w-full sm:w-64 px-6 py-4 bg-white/80 backdrop-blur-md border border-white rounded-2xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-400 outline-none transition shadow-sm group-hover:shadow-md">
          <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
      </div>
    </div>

    <div v-if="filteredSpecies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      <div 
        v-for="fish in filteredSpecies" 
        :key="fish.id" 
        @click="selectedSpecies = fish"
        class="group bg-white/80 backdrop-blur-sm rounded-[2.5rem] shadow-xl hover:shadow-2xl transition-all duration-500 border border-white overflow-hidden cursor-pointer transform hover:-translate-y-2"
      >
        <div class="h-64 relative overflow-hidden">
           <img 
            v-if="fish.image"
            :src="fish.image" 
            :alt="fish.name"
            class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
           />
           <div v-else :class="fish.color" class="w-full h-full flex items-center justify-center opacity-40">
              <svg class="h-20 w-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
           </div>
           
           <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

           <div class="absolute top-6 right-6 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black text-slate-800 uppercase tracking-widest shadow-lg">
             {{ fish.type === 'pez' ? 'Pez' : 'Molusco' }}
           </div>
           
           <div class="absolute bottom-6 left-6 bg-accent-500 px-4 py-1.5 rounded-xl text-xs font-black text-primary-950 uppercase tracking-wider shadow-xl transform -translate-x-2 group-hover:translate-x-0 transition-transform duration-500">
             Talla mín: {{ fish.size }}
           </div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col mb-4">
            <h2 class="text-2xl font-black text-slate-900 group-hover:text-primary-600 transition duration-300">{{ fish.name }}</h2>
            <span v-if="fish.vulgar" class="text-sm font-bold text-primary-500 italic">{{ fish.vulgar }}</span>
          </div>
          <p class="text-slate-400 italic text-xs mb-6 font-bold uppercase tracking-widest">{{ fish.latin }}</p>
          
          <div class="flex items-center justify-between pt-6 border-t border-slate-50">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dificultad</span>
            <div class="flex space-x-1.5">
              <div v-for="i in 3" :key="i" :class="i <= fish.difficulty ? 'bg-accent-500' : 'bg-slate-100'" class="h-1.5 w-6 rounded-full shadow-inner transition-colors duration-500"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-else class="text-center py-32 bg-white/50 backdrop-blur-md rounded-[3rem] border-2 border-dashed border-white">
      <div class="max-w-xs mx-auto">
        <svg class="w-16 h-16 mx-auto mb-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <p class="text-slate-500 font-bold text-lg">No encontramos esa especie en nuestras costas.</p>
        <button @click="search = ''; category = 'all'" class="mt-6 text-primary-600 font-black text-sm uppercase tracking-widest hover:text-primary-800 transition">Ver todos</button>
      </div>
    </div>

    <!-- Modal con Glassmorphism -->
    <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
      <div v-if="selectedSpecies" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="absolute inset-0 bg-primary-950/40 backdrop-blur-md" @click="selectedSpecies = null"></div>
        
        <div class="relative bg-white/90 backdrop-blur-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-[3rem] shadow-2xl border border-white/50">
          <button 
            @click="selectedSpecies = null" 
            class="absolute top-6 right-6 z-10 p-3 bg-white hover:bg-primary-50 rounded-2xl text-slate-900 transition shadow-xl group"
          >
            <svg class="h-6 w-6 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 h-[400px] lg:h-auto relative">
              <img 
                v-if="selectedSpecies.image"
                :src="selectedSpecies.image" 
                :alt="selectedSpecies.name"
                class="w-full h-full object-cover"
              />
              <div v-else :class="selectedSpecies.color" class="w-full h-full flex items-center justify-center opacity-40">
                  <svg class="h-32 w-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
              </div>
              <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent lg:hidden"></div>
            </div>
            
            <div class="w-full lg:w-1/2 p-10 lg:p-16">
              <div class="flex items-center space-x-3 mb-8">
                <span class="px-4 py-1.5 bg-primary-900 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">
                  {{ selectedSpecies.type === 'pez' ? 'Pez' : 'Molusco' }}
                </span>
                <span class="px-4 py-1.5 bg-accent-500 text-primary-950 rounded-xl text-[10px] font-black uppercase tracking-[0.2em]">
                  Talla: {{ selectedSpecies.size }}
                </span>
              </div>
              
              <h2 class="text-5xl font-black text-slate-900 leading-tight mb-4">{{ selectedSpecies.name }}</h2>
              <p v-if="selectedSpecies.vulgar" class="text-2xl font-bold text-primary-600 italic mb-2">{{ selectedSpecies.vulgar }}</p>
              <p class="text-slate-400 italic font-bold text-sm tracking-widest uppercase mb-10">{{ selectedSpecies.latin }}</p>
              
            <div class="space-y-8">
                <div>
                  <h4 class="text-slate-900 font-black uppercase text-xs tracking-[0.2em] mb-4">Descripción</h4>
                  <p class="text-slate-600 leading-relaxed font-medium text-lg">
                    {{ selectedSpecies.description }}
                  </p>
                </div>

                <div v-if="selectedSpecies.curiosity" class="bg-primary-50 p-6 rounded-2xl border border-primary-100">
                  <h4 class="text-primary-900 font-black uppercase text-xs tracking-[0.2em] mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    ¿Sabías que?
                  </h4>
                  <p class="text-primary-700 text-sm font-medium italic">{{ selectedSpecies.curiosity }}</p>
                </div>

                <div class="grid grid-cols-2 gap-8 pt-10 border-t border-slate-100">
                  <div class="group">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 group-hover:text-primary-600 transition">Hábitat Común</span>
                    <span class="font-black text-slate-900 text-xl italic group-hover:text-primary-900">{{ selectedSpecies.habitat || 'Costas de Lanzarote' }}</span>
                  </div>
                  <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Cebo Recomendado</span>
                    <span class="font-black text-primary-600 text-lg">{{ selectedSpecies.bait || 'Varios' }}</span>
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
    difficulty: 2, color: 'bg-slate-800', image: '/imagenes/cangrejomoro.jpg'  
  },
  { 
    id: 2, type: 'molusco', name: 'Cangrejo blanco', latin: 'Plagusia depressa', size: '50 mm', 
    description: 'Cangrejo de caparazón más aplanado que el moro, suele estar más sumergido y es muy rápido.', 
    habitat: 'Rocas batidas por el mar', bait: 'No aplica', curiosity: 'Su cuerpo plano le permite esconderse en grietas muy estrechas.',
    difficulty: 2, color: 'bg-slate-400', image: '/imagenes/cangrejoblanco.jpg' 
  },
  { 
    id: 3, type: 'molusco', name: 'Lapa blanca', latin: 'Patella ulyssiponensis aspera', size: '45 mm', 
    description: 'Molusco univalvo que vive pegado a las rocas. Muy apreciada en la cocina canaria.', 
    habitat: 'Zona baja del intermareal', bait: 'No aplica', curiosity: 'La fuerza con la que se adhiere a la roca es equivalente a cientos de veces su peso.',
    difficulty: 1, color: 'bg-stone-200', image: '/imagenes/lapablanca.jpg' 
  },
  { 
    id: 8, type: 'molusco', name: 'Pulpo común', latin: 'Octopus vulgaris', size: '1 kg', 
    description: 'Uno de los cefalópodos más inteligentes. Se mimetiza perfectamente con el entorno rocoso de Lanzarote.', 
    habitat: 'Fondos rocosos y cuevas', bait: 'Cangrejo o pota', curiosity: 'Tiene tres corazones y su sangre es de color azul.',
    difficulty: 3, color: 'bg-orange-400', image: '/imagenes/pulpocomun.jpg' 
  },
  { 
    id: 10, type: 'pez', name: 'Aligote', vulgar: 'Besugo', latin: 'Pagellus acarne', size: '12 cm', 
    description: 'Pez de cuerpo ovalado y color plateado-rosáceo. Es muy común en capturas desde embarcación.', 
    habitat: 'Fondos arenosos y mixtos', bait: 'Gamba o lombriz', curiosity: 'Se diferencia del besugo por tener la mancha negra justo en la axila de la aleta.',
    difficulty: 2, color: 'bg-pink-200', image: '/imagenes/aligote.jpg' 
  },
  { 
    id: 13, type: 'pez', name: 'Chopa', vulgar: 'Chopa, negrón', latin: 'Spondyliosoma cantharus', size: '19 cm', 
    description: 'Pez de color grisáceo con líneas longitudinales amarillentas. Muy combativo para su tamaño.', 
    habitat: 'Fondos rocosos y sebadales', bait: 'Pan o gamba', curiosity: 'Durante la época de desove, los machos excavan un nido en la arena.',
    difficulty: 2, color: 'bg-slate-500', image: '/imagenes/chopa.jpg'
  },
  { 
    id: 14, type: 'pez', name: 'Estornino', vulgar: 'Caballa', latin: 'Scomber colias', size: '20 cm', 
    description: 'Pez azul muy abundante. Se reconoce por las manchas irregulares en su lomo verde azulado.', 
    habitat: 'Aguas libres (pelágico)', bait: 'Sardina o cucharilla', curiosity: 'Es un nadador incansable; no tiene vejiga natatoria y debe nadar para no hundirse.',
    difficulty: 2, color: 'bg-blue-300', image: '/imagenes/estornino.jpg'
  },
  { 
    id: 15, type: 'pez', name: 'Gitano', vulgar: 'Abade, abadejo', latin: 'Mycteroperca fusca', size: '35 cm', 
    description: 'Uno de los depredadores más nobles de Canarias. Su carne es excelente y muy valorada.', 
    habitat: 'Fondos rocosos profundos', bait: 'Vivo o jigging', curiosity: 'Los ejemplares más grandes suelen ser solitarios y territoriales.',
    difficulty: 3, color: 'bg-emerald-700', image: '/imagenes/gitano.jpg' 
  },
  { 
    id: 16, type: 'pez', name: 'Jurel', vulgar: 'Chicharro', latin: 'Trachurus trachurus', size: '15 cm', 
    description: 'Pez pelágico muy activo y veloz. Suele moverse en grandes bancos cerca de la superficie.', 
    habitat: 'Aguas abiertas cerca de costa', bait: 'Cucharilla o vivo', curiosity: 'Su línea lateral tiene escamas en forma de escudo muy duras.',
    difficulty: 2, color: 'bg-sky-400', image: '/imagenes/jurel.jpg' 
  },
  { 
    id: 17, type: 'pez', name: 'Loro viejo', vulgar: 'Vieja', latin: 'Sparisoma cretense', size: '20 cm', 
    description: 'El pez más icónico de Canarias. Posee colores vibrantes, especialmente las hembras que son rojas y amarillas.', 
    habitat: 'Arrecifes y sebadales', bait: 'Cangrejo blanco', curiosity: 'Tiene un "pico" similar al de un loro que usa para raspar algas de las rocas.',
    difficulty: 2, color: 'bg-red-500', image: '/imagenes/vieja.jpg' 
  },
  { 
    id: 18, type: 'pez', name: 'Mero', vulgar: 'Mero', latin: 'Epinephelus marginatus', size: '45 cm', 
    description: 'El gigante de los fondos canarios. Puede vivir muchos años y alcanzar tamaños impresionantes.', 
    habitat: 'Grandes cuevas submarinas', bait: 'Pulpo o calamar', curiosity: 'Es hermafrodita: nace hembra y con el tiempo puede convertirse en macho.',
    difficulty: 3, color: 'bg-amber-800', image: '/imagenes/mero.jpg'
  },
  { 
    id: 21, type: 'pez', name: 'Pargo', vulgar: 'Bocinegro, pargo, palleta', latin: 'Pagrus pagrus', size: '33 cm', 
    description: 'Pez de color rosado intenso, muy fuerte. Es uno de los reyes de la pesca de fondo.', 
    habitat: 'Fondos rocosos limpios', bait: 'Gamba o calamar', curiosity: 'Su nombre "bocinegro" viene del color oscuro de su boca.',
    difficulty: 2, color: 'bg-red-300' 
  },
  { 
    id: 22, type: 'pez', name: 'Salpa', vulgar: 'Salema', latin: 'Sarpa salpa', size: '24 cm', 
    description: 'Pez herbívoro de color plateado con líneas doradas. Suele nadar en bancos muy numerosos.', 
    habitat: 'Zonas de algas en rocas', bait: 'Algas o pan', curiosity: 'Es de los pocos peces canarios que se alimenta casi exclusivamente de algas.',
    difficulty: 1, color: 'bg-yellow-200' 
  },
  { 
    id: 26, type: 'pez', name: 'Sargo', vulgar: 'Sargo, sargo blanco', latin: 'Diplodus sargus', size: '22 cm', 
    description: 'El rey del ropaje. Pez muy fuerte que vive en el rompiente de las olas.', 
    habitat: 'Zonas de mucha espuma', bait: 'Cangrejo o langostino', curiosity: 'Sus dientes frontales se parecen mucho a los humanos.',
    difficulty: 2, color: 'bg-slate-300', image: '/imagenes/sargo.jpg' 
  },
  { 
    id: 28, type: 'pez', name: 'Patudo', vulgar: 'Tuna', latin: 'Thunnus obesus', size: '3,2 kg', 
    description: 'Túnido de gran tamaño. Una de las pescas más deportivas y exigentes que se pueden hacer en Lanzarote.', 
    habitat: 'Aguas oceánicas profundas', bait: 'Curricán o vivo', curiosity: 'Puede regular su temperatura corporal por encima de la del agua.',
    difficulty: 3, color: 'bg-blue-800' 
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
