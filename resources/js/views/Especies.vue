<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-10 flex justify-between items-end">
      <div>
        <h1 class="text-4xl font-black text-slate-900">Guía de Especies</h1>
        <p class="text-slate-500 mt-2">Conoce los peces más buscados en nuestras costas.</p>
      </div>
      <div class="hidden md:block">
        <input type="text" placeholder="Buscar especie..." class="px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div v-for="fish in species" :key="fish.id" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 overflow-hidden">
        <div class="h-48 bg-slate-200 relative overflow-hidden">
           <!-- Placeholder image with color -->
           <div :class="fish.color" class="w-full h-full flex items-center justify-center text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
              </svg>
           </div>
           <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-slate-800 uppercase tracking-widest">
             {{ fish.water }}
           </div>
        </div>
        <div class="p-6">
          <h2 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition">{{ fish.name }}</h2>
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
const species = [
  { 
    id: 1, 
    name: 'Lubina', 
    latin: 'Dicentrarchus labrax', 
    description: 'La reina de la espuma. Muy apreciada por su combate y sabor.', 
    water: 'Salada', 
    difficulty: 3,
    color: 'bg-blue-400'
  },
  { 
    id: 2, 
    name: 'Dorado', 
    latin: 'Coryphaena hippurus', 
    description: 'Pez pelágico de colores vibrantes y saltos espectaculares.', 
    water: 'Salada', 
    difficulty: 2,
    color: 'bg-emerald-400'
  },
  { 
    id: 3, 
    name: 'Trucha Común', 
    latin: 'Salmo trutta', 
    description: 'Habitante de ríos cristalinos, un desafío para la pesca con mosca.', 
    water: 'Dulce', 
    difficulty: 3,
    color: 'bg-amber-600'
  },
  { 
    id: 4, 
    name: 'Sargo', 
    latin: 'Diplodus sargus', 
    description: 'Pez de roca, fuerte y astuto. Se pesca principalmente en zonas de rompiente.', 
    water: 'Salada', 
    difficulty: 2,
    color: 'bg-slate-400'
  }
]
</script>
