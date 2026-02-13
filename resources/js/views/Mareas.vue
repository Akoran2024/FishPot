<template>

 

  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12">
      <h1 class="text-4xl font-black text-slate-900">Tabla de Mareas</h1>
      <p class="text-slate-500 mt-2 font-medium">Previsiones precisas para la costa de Lanzarote.</p>
    </div>

    <div v-if="loading" class="flex justify-center py-20 bg-white/50 backdrop-blur-md rounded-[2.5rem] border border-white">
      <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary-100 border-t-primary-600 mb-4"></div>
        <p class="text-primary-900 font-bold animate-pulse">Consultando al océano...</p>
      </div>
    </div>

    <div v-else-if="error" class="bg-red-50 p-10 rounded-[2.5rem] border border-red-100 text-red-700 text-center shadow-xl">
      <svg class="w-16 h-16 mx-auto mb-4 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
      <p class="text-lg font-bold">{{ error }}</p>
    </div>

    <div v-else class="space-y-12">
      <!-- Dashboard de Hoy -->
      <div v-if="todayTides" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-primary-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
          <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-110 transition duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
          </div>
          <p class="text-primary-300 font-bold uppercase text-xs tracking-[0.2em] mb-4">Puerto Base</p>
          <p class="text-4xl font-black mb-1">Arrecife</p>
          <p class="text-sm text-primary-200/60 font-medium">Lanzarote, Islas Canarias</p>
        </div>
        
        <div :class="todayTides ? getFishingStatus(todayTides).class : 'bg-white'" class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-white/50 relative overflow-hidden group">
          <p class="text-slate-500 font-bold uppercase text-xs tracking-[0.2em] mb-4">Estado Pesca</p>
          <p class="text-2xl font-black text-slate-900 mb-1" v-if="todayTides">{{ getFishingStatus(todayTides).label }}</p>
          <p class="text-sm text-slate-500 font-medium" v-if="todayTides">{{ getFishingStatus(todayTides).risk }}</p>
        </div>

        <div class="bg-accent-500 p-8 rounded-[2.5rem] shadow-xl text-primary-950 relative overflow-hidden group">
          <p class="text-primary-950/60 font-bold uppercase text-xs tracking-[0.2em] mb-4">Próxima Marea</p>
          <p class="text-4xl font-black mb-1">09:45</p>
          <p class="text-sm text-primary-950/60 font-medium">Pleamar (estimado)</p>
        </div>
      </div>

      <!-- Listado Semanal -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div v-for="day in weeklyTides" :key="day.date" 
             class="bg-white/70 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-xl border border-white hover:border-primary-200 transition-all duration-300">
          <div class="flex items-center justify-between mb-8">
            <div>
              <h2 class="text-2xl font-black text-slate-900">{{ day.day_name }}</h2>
              <p class="text-primary-600 font-bold text-sm">{{ day.date }}</p>
            </div>
            <div class="bg-primary-50 p-3 rounded-2xl">
              <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
          </div>

          <!-- Fishing Suitability Indicator -->
          <div :class="getFishingStatus(day).class" class="mb-6 p-4 rounded-2xl border flex items-start space-x-3">
            <div class="mt-0.5 font-bold text-lg">{{ getFishingStatus(day).icon }}</div>
            <div>
              <p class="font-bold text-sm">{{ getFishingStatus(day).label }}</p>
              <p v-if="getFishingStatus(day).risk" class="text-xs mt-1 opacity-90">{{ getFishingStatus(day).risk }}</p>
            </div>
          </div>
          
          <div class="space-y-4">
            <div v-for="tide in day.tides" :key="tide.hora" 
                 class="flex items-center justify-between p-4 rounded-2xl bg-slate-50/50 border border-slate-100 hover:bg-white hover:shadow-md transition duration-200">
              <div class="flex items-center space-x-4">
                <div :class="tide.tipo.toLowerCase() === 'pleamar' ? 'text-blue-600 bg-blue-100' : 'text-amber-600 bg-amber-100'" class="p-2 rounded-xl">
                  <svg v-if="tide.tipo.toLowerCase() === 'pleamar'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
                <div>
                  <p class="font-black text-slate-900">{{ tide.hora }}</p>
                  <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">{{ tide.tipo }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-lg font-black text-primary-900">{{ tide.altura }}m</p>
                <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Altura</p>
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
    error.value = 'No se pudieron cargar los datos de las mareas. Por favor, inténtelo de nuevo más tarde.'
  } finally {
    loading.value = false
  }
}

const todayTides = computed(() => {
  if (weeklyTides.value.length === 0) return null
  const today = new Date().toISOString().split('T')[0]
  return weeklyTides.value.find(day => day.date === today) || weeklyTides.value[0]
})

const getFishingStatus = (day) => {
  // Buscamos la bajamar más baja del día para evaluar seguridad
  const heights = day.tides.map(t => parseFloat(t.altura))
  const minHeight = Math.min(...heights)
  
  if (minHeight >= 0.5 && minHeight <= 1.0) {
    return { 
      label: 'Día adecuado para pescar', 
      class: 'bg-emerald-50 text-emerald-700 border-emerald-100',
      icon: '✓',
      risk: 'Las condiciones de la marea son óptimas para la costa de Lanzarote.'
    }
  } else if (minHeight < 0.5) {
    return { 
      label: 'Aviso de riesgo: Marea muy baja', 
      class: 'bg-amber-50 text-amber-700 border-amber-100',
      icon: '!',
      risk: 'Riesgo de rocas expuestas y superficies resbaladizas. Extremar precaución.'
    }
  } else {
    return { 
      label: 'Aviso de riesgo: Marea alta', 
      class: 'bg-orange-50 text-orange-700 border-orange-100',
      icon: '!',
      risk: 'Fuertes corrientes y difícil acceso a pesqueros. No recomendado para principiantes.'
    }
  }
}

onMounted(() => {
  fetchTides()
})
</script>