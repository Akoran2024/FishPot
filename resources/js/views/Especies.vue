<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-nautical-200 pb-12">
      <div class="max-w-2xl">
        <h2 class="text-primary-800 font-serif italic text-sm tracking-[0.2em] uppercase mb-4">Biodiversidad de Lanzarote</h2>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 leading-tight tracking-tight italic">Guía de Especies</h1>
        <p class="text-nautical-600 mt-6 font-serif italic text-lg leading-relaxed">Un registro detallado de las especies que habitan nuestras aguas. Conozca sus tallas mínimas, hábitats y artes de pesca recomendadas.</p>
      </div>
      
      <div class="w-full md:w-auto flex flex-col sm:flex-row gap-4">
        <div class="flex bg-white p-1 rounded-lg border border-nautical-200 shadow-sm">
          <button 
            @click="category = 'all'" 
            :class="category === 'all' ? 'bg-primary-950 text-white' : 'text-nautical-500 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Todas
          </button>
          <button 
            @click="category = 'pez'" 
            :class="category === 'pez' ? 'bg-primary-950 text-white' : 'text-nautical-500 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Peces
          </button>
          <button 
            @click="category = 'molusco'" 
            :class="category === 'molusco' ? 'bg-primary-950 text-white' : 'text-nautical-500 hover:text-primary-800'"
            class="px-5 py-2 rounded font-serif italic text-sm transition-all"
          >
            Moluscos
          </button>
        </div>
        <div class="relative">
          <input type="text" v-model="search" placeholder="Buscar especie..." class="w-full sm:w-64 px-5 py-3 bg-white border border-nautical-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-700 outline-none transition font-serif italic text-sm">
          <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-nautical-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
      </div>
    </div>

    <div v-if="filteredSpecies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
      <div 
        v-for="fish in filteredSpecies" 
        :key="fish.id" 
        @click="selectedSpecies = fish"
        class="nautical-card group cursor-pointer transition-all duration-500 hover:-translate-y-2 border-b-4 border-b-primary-100 hover:border-b-primary-700"
      >
        <div class="h-72 relative overflow-hidden bg-nautical-50">
           <img 
            v-if="fish.image"
            :src="fish.image" 
            :alt="fish.name"
            class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition duration-700 group-hover:scale-105"
           />
           <div v-else :class="fish.color" class="w-full h-full flex items-center justify-center opacity-20 italic font-serif">
              Sin imagen
           </div>
           
           <div class="absolute inset-0 bg-gradient-to-t from-primary-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

           <div class="absolute top-4 right-4 bg-white/90 px-3 py-1 rounded border border-nautical-200 text-[9px] font-bold text-primary-900 uppercase tracking-widest shadow-sm">
             {{ fish.type === 'pez' ? 'Pez' : 'Molusco' }}
           </div>
           
           <div class="absolute bottom-6 left-6 bg-white px-4 py-2 border-l-4 border-primary-800 shadow-xl">
             <span class="text-[10px] font-bold text-nautical-400 uppercase tracking-widest block leading-none mb-1">Talla Mínima</span>
             <span class="text-lg font-serif font-black text-primary-950 italic leading-none">{{ fish.size }}</span>
           </div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col mb-4">
            <h2 class="text-2xl font-serif font-black text-primary-950 group-hover:text-primary-700 transition duration-300 italic">{{ fish.name }}</h2>
            <span v-if="fish.vulgar" class="text-sm font-serif italic text-primary-600">{{ fish.vulgar }}</span>
          </div>
          <p class="text-nautical-400 italic text-xs mb-6 font-medium uppercase tracking-[0.2em]">{{ fish.latin }}</p>
          
          <div class="flex items-center justify-between pt-6 border-t border-nautical-100">
            <span class="text-[10px] font-bold text-nautical-300 uppercase tracking-widest italic">Dificultad de captura</span>
            <div class="flex space-x-1.5">
              <div v-for="i in 3" :key="i" :class="i <= fish.difficulty ? 'bg-primary-800' : 'bg-nautical-200'" class="h-1.5 w-6 rounded-sm transition-colors duration-500"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-else class="text-center py-32 bg-white/50 border-2 border-dashed border-nautical-200">
      <p class="text-nautical-400 font-serif italic text-lg">No encontramos registros de esa especie en nuestras bitácoras.</p>
      <button @click="search = ''; category = 'all'" class="mt-6 text-primary-800 font-serif font-bold italic border-b border-primary-800">Ver todo el catálogo</button>
    </div>

    <!-- Modal Estilo Antiguo -->
    <transition name="page">
      <div v-if="selectedSpecies" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-primary-950/60 backdrop-blur-sm" @click="selectedSpecies = null"></div>
        
        <div class="relative bg-white w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-lg shadow-2xl border-4 border-white">
          <button @click="selectedSpecies = null" class="absolute top-6 right-6 z-10 p-2 bg-nautical-100 hover:bg-nautical-200 text-primary-900 transition">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>

          <div class="flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 h-[450px] lg:h-auto bg-nautical-50">
              <img 
                v-if="selectedSpecies.image"
                :src="selectedSpecies.image" 
                :alt="selectedSpecies.name"
                class="w-full h-full object-cover border-r border-nautical-100"
              />
            </div>
            
            <div class="w-full lg:w-1/2 p-10 lg:p-16">
              <div class="flex items-center space-x-3 mb-8">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-800 border-b-2 border-primary-800 pb-1">Ficha Especie</span>
              </div>
              
              <h2 class="text-5xl font-serif font-black text-primary-950 leading-tight mb-2 italic">{{ selectedSpecies.name }}</h2>
              <p class="text-primary-500 italic font-serif text-sm tracking-widest uppercase mb-10">{{ selectedSpecies.latin }}</p>
              
              <div class="space-y-10">
                <div class="prose prose-nautical">
                  <h4 class="text-nautical-400 font-serif italic text-xs tracking-[0.2em] mb-4 uppercase">Descripción y Notas</h4>
                  <p class="text-primary-900 leading-relaxed font-serif text-lg italic">
                    "{{ selectedSpecies.description }}"
                  </p>
                </div>

                <div v-if="selectedSpecies.curiosity" class="bg-nautical-50 p-6 border-l-4 border-primary-700">
                  <h4 class="text-primary-900 font-serif font-black italic text-sm mb-2">¿Sabía que?</h4>
                  <p class="text-nautical-700 text-sm font-serif italic">{{ selectedSpecies.curiosity }}</p>
                </div>

                <div class="grid grid-cols-2 gap-8 pt-10 border-t border-nautical-100">
                  <div>
                    <span class="block text-[10px] font-bold text-nautical-400 uppercase tracking-widest mb-2 italic">Hábitat</span>
                    <span class="font-serif font-black text-primary-950 text-xl italic">{{ selectedSpecies.habitat || 'Zonas de roca' }}</span>
                  </div>
                  <div>
                    <span class="block text-[10px] font-bold text-nautical-400 uppercase tracking-widest mb-2 italic">Cebo Recomendado</span>
                    <span class="font-serif font-black text-primary-700 text-xl italic">{{ selectedSpecies.bait || 'Varios' }}</span>
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