<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-16 text-center">
      <h2 class="text-primary-800 font-serif italic text-sm tracking-[0.2em] uppercase mb-2">Estado de la Mar</h2>
      <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 tracking-tight">Bitácora de Mareas</h1>
      <p class="text-nautical-600 mt-4 font-serif italic text-lg max-w-2xl mx-auto">Previsiones precisas para la costa de Lanzarote. Consulte el pulso del Atlántico antes de su jornada.</p>
      <div class="w-24 h-px bg-primary-700 mx-auto mt-8 opacity-20"></div>
    </div>

    <div v-if="loading" class="flex justify-center py-32 bg-white/50 backdrop-blur-sm rounded-xl border border-nautical-200">
      <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-10 w-10 border-2 border-nautical-200 border-t-primary-800 mb-6"></div>
        <p class="text-primary-900 font-serif italic animate-pulse">Consultando los registros del puerto...</p>
      </div>
    </div>

    <div v-else-if="error" class="bg-red-50 p-12 rounded-xl border border-red-100 text-red-800 text-center shadow-sm">
      <p class="text-xl font-serif italic mb-4">{{ error }}</p>
      <button @click="fetchTides" class="text-sm font-bold uppercase tracking-widest text-red-600 hover:text-red-800 transition">Reintentar conexión</button>
    </div>

    <div v-else class="space-y-16">
      <!-- Dashboard de Hoy (Estilo Placa Tradicional) -->
      <div v-if="todayTides" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-primary-950 p-10 rounded-lg shadow-xl text-white relative overflow-hidden group border-b-4 border-primary-800">
          <p class="text-primary-300 font-serif italic text-xs tracking-widest mb-4 opacity-60">Puerto de Referencia</p>
          <p class="text-4xl font-serif font-black mb-2 tracking-tight italic">La Santa</p>
          <p class="text-xs text-primary-400 font-bold uppercase tracking-[0.2em]">Lanzarote · Canarias</p>
        </div>
        
        <div class="nautical-card p-10 text-center flex flex-col justify-center border-b-4 border-primary-200">
          <p class="text-nautical-400 font-serif italic text-xs tracking-widest mb-4">Estado de Pesca</p>
          <p class="text-2xl font-serif font-black text-primary-950 mb-1" v-if="todayTides">{{ getFishingStatus(todayTides).label }}</p>
          <p class="text-sm text-nautical-500 font-serif italic" v-if="todayTides">{{ getFishingStatus(todayTides).risk }}</p>
        </div>

        <div class="bg-white p-10 rounded-lg shadow-xl border border-nautical-200 relative overflow-hidden text-center border-b-4 border-nautical-100">
          <p class="text-nautical-400 font-serif italic text-xs tracking-widest mb-4">Próximo Cambio</p>
          <p class="text-5xl font-serif font-black text-primary-950 mb-2 italic tracking-tighter">{{ nextTide ? nextTide.hora : '--:--' }}</p>
          <p class="text-[10px] font-black text-primary-700 uppercase tracking-[0.4em]">{{ nextTide ? nextTide.tipo : 'Calculando...' }}</p>
        </div>
      </div>

      <!-- Listado Semanal (Estilo Catálogo) -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div v-for="day in weeklyTides" :key="day.date" 
             class="nautical-card p-10 group hover:border-primary-300 transition-all duration-500">
          <div class="flex items-center justify-between mb-10 pb-6 border-b border-nautical-100">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">{{ day.day_name }}</h2>
              <p class="text-primary-700 font-serif italic text-sm">{{ day.date }}</p>
            </div>
            <div class="text-primary-200 group-hover:text-primary-400 transition-colors">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
            </div>
          </div>

          <!-- Indicador Náutico -->
          <div :class="getFishingStatus(day).class" class="mb-10 p-6 border-l-4 border-primary-800 bg-primary-50/30">
            <div class="flex items-center space-x-4">
              <span class="text-2xl">{{ getFishingStatus(day).icon }}</span>
              <div>
                <p class="font-serif font-black text-primary-950 text-lg italic">{{ getFishingStatus(day).label }}</p>
                <p class="text-xs font-serif italic text-nautical-600 mt-1">{{ getFishingStatus(day).risk }}</p>
              </div>
            </div>
          </div>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div v-for="tide in day.tides" :key="tide.hora" 
                 class="p-5 bg-nautical-50/50 border border-nautical-100 hover:bg-white hover:border-primary-200 transition duration-300">
              <div class="flex items-center justify-between mb-2">
                <span :class="tide.tipo.toLowerCase() === 'pleamar' ? 'text-primary-800' : 'text-nautical-500'" class="text-[10px] font-black uppercase tracking-[0.2em]">
                  {{ tide.tipo }}
                </span>
                <span class="text-primary-950 font-serif font-black text-xl">{{ tide.hora }}</span>
              </div>
              <div class="flex items-end justify-between">
                <div class="h-1.5 w-16 bg-nautical-200 rounded-full overflow-hidden">
                   <div :style="{ width: (parseFloat(tide.altura) * 30) + '%' }" class="h-full bg-primary-700"></div>
                </div>
                <span class="text-xs font-serif italic text-nautical-500">{{ tide.altura }} metros</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const weeklyTides = ref([])
const loading = ref(true)
const error = ref(null)

const fetchTides = async () => {
  try {
    loading.value = true
    const response = await axios.get('/tides')
    weeklyTides.value = response.data
  } catch (err) {
    console.error('Error fetching tides:', err)
    error.value = 'No se pudieron recuperar los registros de marea. Inténtelo más tarde.'
  } finally {
    loading.value = false
  }
}

const todayTides = computed(() => {
  if (weeklyTides.value.length === 0) return null
  const today = new Date().toISOString().split('T')[0]
  return weeklyTides.value.find(day => day.date === today) || weeklyTides.value[0]
})

const nextTide = computed(() => {
  if (!todayTides.value) return null
  const now = new Date()
  const currentTime = now.getHours() * 60 + now.getMinutes()
  const futureTides = todayTides.value.tides.filter(tide => {
    const [hours, minutes] = tide.hora.split(':').map(Number)
    return (hours * 60 + minutes) > currentTime
  })
  if (futureTides.length > 0) return futureTides[0]
  if (weeklyTides.value.length > 1) return weeklyTides.value[1].tides[0]
  return todayTides.value.tides[0]
})

const getFishingStatus = (day) => {
  if (!day.tides || day.tides.length === 0) return { label: 'Sin datos', class: '', icon: '?', risk: '' }
  const heights = day.tides.map(t => parseFloat(t.altura))
  const minHeight = Math.min(...heights)
  if (minHeight >= 0.5 && minHeight <= 1.0) {
    return { label: 'Jornada favorable', class: '', icon: '⚓', risk: 'Condiciones óptimas según los registros locales.' }
  } else if (minHeight < 0.5) {
    return { label: 'Marea muy baja', class: '', icon: '⚠️', risk: 'Riesgo de rocas expuestas. Proceda con cautela.' }
  } else {
    return { label: 'Marea alta / Viva', class: '', icon: '🌊', risk: 'Corrientes fuertes. Solo para expertos en costa.' }
  }
}

onMounted(() => {
  fetchTides()
})
</script>