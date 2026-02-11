<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-10 flex justify-between items-end">
      <div>
        <h1 class="text-4xl font-black text-slate-900">Guía de Especies</h1>
        <p class="text-slate-500 mt-2">Conoce las tallas mínimas y especies de nuestras costas.</p>
      </div>
      <div class="hidden md:block">
        <input type="text" v-model="search" placeholder="Buscar especie..." class="px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div v-for="fish in filteredSpecies" :key="fish.id" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 overflow-hidden">
        <div class="h-48 bg-slate-200 relative overflow-hidden">
           <!-- Placeholder image with color -->
           <img 
            :src="fish.image" 
            :alt="fish.name"
            class="w-full h-full object-cover"
  />
           <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-slate-800 uppercase tracking-widest">
             {{ fish.water }}
           </div>
           <div class="absolute bottom-4 left-4 bg-blue-600/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-white uppercase tracking-wider">
             Talla mín: {{ fish.size }}
           </div>
        </div>
        <div class="p-6">
          <div class="flex flex-col mb-2">
            <h2 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition">{{ fish.name }}</h2>
            <span v-if="fish.vulgar" class="text-sm font-medium text-blue-500 italic">{{ fish.vulgar }}</span>
          </div>
          <p class="text-slate-400 italic text-sm mb-4">{{ fish.latin }}</p>
          <p class="text-slate-600 line-clamp-2 mb-6">{{ fish.description }}</p>
          
          <div class="flex items-center justify-between pt-4 border-t border-slate-50">
            <span class="text-xs font-bold text-slate-400 uppercase">Dificultad</span>
            <div class="flex space-x-1">
              <div v-for="i in 3" :key="i" :class="i <= fish.difficulty ? 'bg-amber-400' : 'bg-slate-200'" class="h-2 w-6 rounded-full"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const search = ref('')

const species = [
  { id: 1, name: 'Cangrejo moro o negro', latin: 'Grapsus adscensionis', size: '60 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-slate-800', image: '/imagenes/cangrejomoro.jpg'  },
  { id: 2, name: 'Cangrejo blanco', latin: 'Plagusia depressa', size: '50 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-slate-400', image: '/imagenes/cangrejoblanco.jpg' },
  { id: 3, name: 'Lapa blanca', latin: 'Patella ulyssiponensis aspera', size: '45 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-stone-200', image: '/imagenes/lapablanca.jpg' },
  { id: 4, name: 'Lapa negra', latin: 'Patella candei crenata', size: '45 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-stone-400', image: '/imagenes/lapanegra.jpeg' },
  { id: 5, name: 'Lapa curvina', latin: 'Patella rustica o P. piperata', size: '45 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-stone-300' },
  { id: 6, name: 'Burgado común', latin: 'Phorcus (= Osilinus) astratus', size: '15 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-zinc-500' },
  { id: 7, name: 'Burgado macho', latin: 'Phorcus (= Osilinus) sauciatus', size: '15 mm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-zinc-600' },
  { id: 8, name: 'Pulpo común', latin: 'Octopus vulgaris', size: '1 kg', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-orange-400' },
  { id: 9, name: 'Mejillón canario', latin: 'Perna perna', size: '7 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-blue-900' },
  { id: 10, name: 'Aligote', vulgar: 'Besugo', latin: 'Pagellus acarne', size: '12 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-pink-200' },
  { id: 11, name: 'Cabrilla', vulgar: 'Cabrilla, cabrilla rubia', latin: 'Serranus cabrilla', size: '15 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-orange-300' },
  { id: 12, name: 'Cachucho', vulgar: 'Antoñito, calé, dientón', latin: 'Dentex macrophtalmus', size: '18 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-red-400' },
  { id: 13, name: 'Chopa', vulgar: 'Chopa, negrón', latin: 'Spondyliosoma cantharus', size: '19 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-slate-500' },
  { id: 14, name: 'Estornino', vulgar: 'Caballa', latin: 'Scomber colias', size: '20 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-blue-300' },
  { id: 15, name: 'Gitano', vulgar: 'Abade, abadejo', latin: 'Mycteroperca fusca', size: '35 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-emerald-700' },
  { id: 16, name: 'Jurel', vulgar: 'Chicharro', latin: 'Trachurus trachurus', size: '15 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-sky-400' },
  { id: 17, name: 'Loro viejo', vulgar: 'Vieja', latin: 'Sparisoma cretense', size: '20 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-red-500' },
  { id: 18, name: 'Mero', vulgar: 'Mero', latin: 'Epinephelus marginatus', size: '45 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-amber-800' },
  { id: 19, name: 'Morraja', vulgar: 'Seifia, seifio', latin: 'Diplodus vulgaris', size: '22 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-gray-300' },
  { id: 20, name: 'Pagel', vulgar: 'Breca', latin: 'Pagellus erytrinus', size: '22 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-rose-300' },
  { id: 21, name: 'Pargo', vulgar: 'Bocinegro, pargo, palleta', latin: 'Pagrus pagrus', size: '33 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-red-300' },
  { id: 22, name: 'Salpa', vulgar: 'Salema', latin: 'Sarpa salpa', size: '24 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 1, color: 'bg-yellow-200' },
  { id: 23, name: 'Salmonete de roca', vulgar: 'Salmón, salmonete', latin: 'Mullus surmuletus', size: '15 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-orange-500' },
  { id: 24, name: 'Salmonete de fango', vulgar: 'Salmón, salmonete', latin: 'Mullus barbatus', size: '15 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-orange-400' },
  { id: 25, name: 'Sama de pluma', vulgar: 'Sama, serruda, pargo macho', latin: 'Dentex gibosus', size: '35 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-rose-400' },
  { id: 26, name: 'Sargo', vulgar: 'Sargo, sargo blanco', latin: 'Diplodus sargus', size: '22 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-slate-300' },
  { id: 27, name: 'Serrano imperial', vulgar: 'Cabrilla, cabrilla reina', latin: 'Serranus atricauda', size: '15 cm', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 2, color: 'bg-amber-500' },
  { id: 28, name: 'Patudo', vulgar: 'Tuna', latin: 'Thunnus obesus', size: '3,2 kg', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-blue-800' },
  { id: 29, name: 'Rabil', vulgar: 'Rabil', latin: 'Thunnus albacares', size: '3,2 kg', description: 'Especie común en aguas canarias.', water: 'Salada', difficulty: 3, color: 'bg-blue-700' }
]

const filteredSpecies = computed(() => {
  return species.filter(fish => 
    fish.name.toLowerCase().includes(search.value.toLowerCase()) || 
    fish.latin.toLowerCase().includes(search.value.toLowerCase()) ||
    (fish.vulgar && fish.vulgar.toLowerCase().includes(search.value.toLowerCase()))
  )
})
</script>
