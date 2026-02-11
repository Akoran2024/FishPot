<template>
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-blue-900 px-8 py-6 text-white">
        <h1 class="text-3xl font-extrabold">Tabla de Mareas</h1>
        <p class="mt-2 text-blue-200">Previsiones para la semana actual</p>
      </div>
      
      <div class="p-8">
        <div v-if="loading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-900"></div>
        </div>

        <div v-else-if="error" class="bg-red-50 p-6 rounded-xl border border-red-100 text-red-700 text-center">
          {{ error }}
        </div>

        <div v-else>
          <!-- Dashboard Simple (Opcional: mostrar datos de hoy) -->
          <div v-if="todayTides" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 text-center">
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
              <p class="text-blue-600 font-bold uppercase text-xs tracking-wider mb-1">Puerto de Referencia</p>
              <p class="text-3xl font-black text-blue-900">Cádiz</p>
              <p class="text-sm text-blue-500 mt-1">Instituto Hidrográfico de la Marina</p>
            </div>
            <div class="bg-emerald-50 p-6 rounded-xl border border-emerald-100">
              <p class="text-emerald-600 font-bold uppercase text-xs tracking-wider mb-1">Estado Hoy</p>
              <p class="text-3xl font-black text-emerald-900">{{ todayTides.day_name }}</p>
              <p class="text-sm text-emerald-500 mt-1">{{ todayTides.tides.length }} movimientos detectados</p>
            </div>
          </div>

          <!-- Tablas por día -->
          <div class="space-y-12">
            <div v-for="day in weeklyTides" :key="day.date" class="border-b border-slate-100 pb-8 last:border-0">
              <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm mr-3">
                  {{ day.date }}
                </span>
                {{ day.day_name }}
              </h2>
              
              <div class="overflow-x-auto">
                <table class="w-full text-left">
                  <thead>
                    <tr class="border-b-2 border-slate-100">
                      <th class="py-4 px-4 font-bold text-slate-400 uppercase text-xs">Hora</th>
                      <th class="py-4 px-4 font-bold text-slate-400 uppercase text-xs">Tipo</th>
                      <th class="py-4 px-4 font-bold text-slate-400 uppercase text-xs">Altura</th>
                      <th class="py-4 px-4 font-bold text-slate-400 uppercase text-xs">Estado</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-50">
                    <tr v-for="tide in day.tides" :key="tide.hora" class="hover:bg-slate-50 transition">
                      <td class="py-4 px-4 font-bold text-slate-700 text-lg">{{ tide.hora }}</td>
                      <td class="py-4 px-4">
                        <span :class="tide.tipo.toLowerCase() === 'pleamar' ? 'text-blue-600 bg-blue-50' : 'text-red-600 bg-red-50'" class="font-bold px-3 py-1 rounded-full text-sm uppercase">
                          {{ tide.tipo }}
                        </span>
                      </td>
                      <td class="py-4 px-4 text-slate-600 font-mono">{{ tide.altura }}m</td>
                      <td class="py-4 px-4">
                         <div class="flex items-center">
                           <div :class="tide.tipo.toLowerCase() === 'pleamar' ? 'bg-blue-500' : 'bg-red-500'" class="w-2 h-2 rounded-full mr-2"></div>
                           <span class="text-sm text-slate-500">Marea {{ tide.tipo.toLowerCase() }}</span>
                         </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
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

onMounted(() => {
  fetchTides()
})
</script>