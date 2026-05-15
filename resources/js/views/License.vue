<template>
  <div class="min-h-screen text-nautical-900 selection:bg-primary-200 py-20 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Cabecera -->
      <div class="max-w-3xl mb-16">
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full border border-nautical-200 mb-8 shadow-sm">
          <span class="text-primary-800 font-serif italic text-xs tracking-wide">Compromiso con el Mar Canario</span>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-serif font-black leading-tight tracking-tight text-primary-950 mb-8">
          Licencia de <br/>
          <span class="italic text-primary-700">Pesca Recreativa</span>
        </h1>
        
        <p class="text-xl text-nautical-700 leading-relaxed font-serif italic max-w-2xl">
          Para disfrutar de la pesca en nuestras costas de forma legal y responsable, es imprescindible contar con la licencia en vigor. Aquí te guiamos en el proceso.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Columna Principal: Beneficios y Obligación -->
        <div class="lg:col-span-2 space-y-12">
          
          <!-- Obligación -->
          <section class="nautical-card p-10 border-l-4 border-l-red-400">
            <h2 class="text-3xl font-serif font-black text-primary-950 mb-6 italic">La Obligación Legal</h2>
            <div class="space-y-4 text-nautical-700 font-serif leading-relaxed text-lg">
              <p>En la Comunidad Autónoma de Canarias, la práctica de la pesca recreativa, ya sea desde tierra, desde embarcación o submarina, requiere obligatoriamente estar en posesión de una <strong>licencia de pesca</strong>.</p>
              <p>Pescar sin licencia no solo conlleva sanciones económicas considerables, sino que también dificulta la gestión sostenible de nuestros recursos marinos.</p>
            </div>
          </section>

          <!-- Beneficios -->
          <section class="nautical-card p-10">
            <h2 class="text-3xl font-serif font-black text-primary-950 mb-8 italic">¿Por qué es importante?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="flex space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-black italic">1</div>
                <div>
                  <h3 class="font-serif font-black text-primary-950 mb-2 italic">Sostenibilidad</h3>
                  <p class="text-sm text-nautical-600 font-serif">Ayuda a las autoridades a censar la actividad y proteger las especies locales del sobreesfuerzo pesquero.</p>
                </div>
              </div>
              <div class="flex space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-black italic">2</div>
                <div>
                  <h3 class="font-serif font-black text-primary-950 mb-2 italic">Legalidad</h3>
                  <p class="text-sm text-nautical-600 font-serif">Evita multas que pueden oscilar desde los 60€ hasta los 300€ en infracciones leves, y mucho más en graves.</p>
                </div>
              </div>
              <div class="flex space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-black italic">3</div>
                <div>
                  <h3 class="font-serif font-black text-primary-950 mb-2 italic">Investigación</h3>
                  <p class="text-sm text-nautical-600 font-serif">Las tasas de las licencias se reinvierten en estudios marinos y vigilancia de nuestras costas.</p>
                </div>
              </div>
              <div class="flex space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-black italic">4</div>
                <div>
                  <h3 class="font-serif font-black text-primary-950 mb-2 italic">Seguridad</h3>
                  <p class="text-sm text-nautical-600 font-serif">Garantiza que el pescador conoce la normativa básica sobre tallas mínimas y zonas permitidas.</p>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Sidebar: Enlace y Trámite -->
        <div class="space-y-8">
          <div class="nautical-card p-8 sticky top-24">
            <h2 class="text-2xl font-serif font-black mb-6 italic text-primary-950">Tramitación Online</h2>
            <p class="text-nautical-900 font-serif italic mb-8 leading-relaxed">
              La forma más rápida de obtenerla es a través de la Sede Electrónica del Gobierno de Canarias. Necesitarás DNIe, Certificado Digital o Cl@ve.
            </p>
            
            <a href="https://sede.gobiernodecanarias.org/sede/tramites/1186" 
               target="_blank" 
               class="block w-full text-center py-4 bg-primary-600 text-white font-serif italic text-lg font-black hover:bg-primary-700 transition-all shadow-xl mb-6">
               Solicitar Licencia
            </a>

            <div class="border-t border-nautical-200 pt-6">
              <h4 class="text-xs uppercase tracking-widest font-bold text-primary-800 mb-4">Pasos a seguir:</h4>
              <ul class="space-y-4 text-sm font-serif italic text-nautical-900">
                <li class="flex items-start space-x-3">
                  <span class="text-primary-600 font-black">•</span>
                  <span>Accede al enlace superior</span>
                </li>
                <li class="flex items-start space-x-3">
                  <span class="text-primary-600 font-black">•</span>
                  <span>Selecciona "Tramitación Electrónica"</span>
                </li>
                <li class="flex items-start space-x-3">
                  <span class="text-primary-600 font-black">•</span>
                  <span>Rellena tus datos personales</span>
                </li>
                <li class="flex items-start space-x-3">
                  <span class="text-primary-600 font-black">•</span>
                  <span>Paga la tasa correspondiente (Modelo 700)</span>
                </li>
                <li class="flex items-start space-x-3">
                  <span class="text-primary-600 font-black">•</span>
                  <span>Descarga tu carnet en PDF al instante</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.nautical-card {
  @apply bg-white/40 backdrop-blur-md border border-nautical-200 shadow-xl transition-all duration-300 hover:border-primary-300 rounded-lg;
}
</style>
