<template>
  <div>
    <!-- Hero Section -->
    <div class="relative bg-blue-900 h-[600px] flex items-center overflow-hidden">
      <div class="absolute inset-0 opacity-20">
         <!-- Patrón de fondo simulado con círculos -->
         <div class="absolute top-0 left-0 w-96 h-96 bg-blue-400 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
         <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-400 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-2xl">
          <span class="bg-blue-500/20 text-blue-300 px-4 py-1 rounded-full text-sm font-bold tracking-widest uppercase mb-6 inline-block">Temporada 2026 Abierta</span>
          <h1 class="text-6xl md:text-7xl font-black text-white leading-tight mb-8">
            Domina el arte de la <span class="text-blue-400">Pesca Deportiva</span>
          </h1>
          <p class="text-xl text-blue-100 mb-10 leading-relaxed">
            Consulta mareas en tiempo real, descubre nuevas especies y equípate con lo mejor del mercado profesional.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <router-link to="/tienda" class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-4 rounded-2xl font-bold text-lg text-center transition shadow-xl shadow-blue-500/20">Ver Tienda</router-link>
            <router-link to="/mareas" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md px-8 py-4 rounded-2xl font-bold text-lg text-center transition">Consultar Mareas</router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="max-w-7xl mx-auto px-4 -mt-16 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
           <div class="text-blue-600 mb-4 font-bold text-4xl">500+</div>
           <p class="text-slate-500 font-medium">Especies catalogadas</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
           <div class="text-blue-600 mb-4 font-bold text-4xl">24h</div>
           <p class="text-slate-500 font-medium">Actualización de mareas</p>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
           <div class="text-blue-600 mb-4 font-bold text-4xl">10k+</div>
           <p class="text-slate-500 font-medium">Pescadores activos</p>
        </div>
      </div>
    </div>

    <!-- Features -->
    <section class="py-24">
      <div class="max-w-7xl mx-auto px-4 text-center mb-16">
        <h2 class="text-4xl font-black text-slate-900 mb-4">Todo lo que un pescador necesita</h2>
        <p class="text-slate-500 text-lg">Herramientas diseñadas por expertos para amantes del mar.</p>
      </div>
      
      <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="p-8 rounded-3xl hover:bg-white hover:shadow-xl transition group">
           <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
              </svg>
           </div>
           <h3 class="text-xl font-bold mb-3">Meteorología</h3>
           <p class="text-slate-500">Predicción exacta de viento, olas y presión atmosférica.</p>
        </div>
        <!-- ... more features ... -->
      </div>
    </section>
  </div>
</template>

<script setup>
</script>
