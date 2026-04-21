<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <!-- Header Section -->
    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-8 border-b border-primary-950/10 pb-10">
      <div>
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1.5 rounded-full border border-nautical-200 mb-4 shadow-sm">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
          </span>
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Registro de Tripulación</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-serif font-black text-primary-950 italic tracking-tight">Gestión de Usuarios</h1>
        <p class="text-nautical-700 mt-4 font-serif italic text-lg leading-relaxed max-w-2xl">Administre los rangos, accesos y credenciales de la comunidad de pescadores de FishPot.</p>
      </div>
      
      <router-link :to="{ name: 'admin.usuarios.create' }" class="group relative px-10 py-4 bg-primary-950 text-white font-serif italic text-lg hover:bg-primary-800 transition-all shadow-2xl font-black overflow-hidden flex items-center">
        <span class="relative z-10 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
          Reclutar Nuevo Marinero
        </span>
        <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
      </router-link>
    </div>

    <!-- Stats Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="nautical-card p-6 border-l-4 border-l-primary-800">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Total Tripulación</p>
        <p class="text-4xl font-serif font-black text-primary-950 italic">{{ users.length }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-indigo-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Almirantes (Admin)</p>
        <p class="text-4xl font-serif font-black text-indigo-700 italic">{{ adminCount }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-emerald-600">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Marineros Activos</p>
        <p class="text-4xl font-serif font-black text-emerald-700 italic">{{ userCount }}</p>
      </div>
      <div class="nautical-card p-6 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mb-1">Nuevos (Mes)</p>
        <p class="text-4xl font-serif font-black text-amber-600 italic">{{ recentUsersCount }}</p>
      </div>
    </div>

    <!-- Main Table Section -->
    <div class="nautical-card overflow-hidden border-t-4 border-t-primary-950 shadow-2xl">
      <div class="p-6 bg-nautical-50 border-b border-nautical-200 flex flex-wrap justify-between items-center gap-4">
        <div class="relative w-full max-w-md">
          <input type="text" v-model="search" placeholder="Filtrar por nombre o email..." class="w-full pl-10 pr-4 py-2 border border-nautical-300 rounded-lg text-sm font-serif italic outline-none focus:ring-2 focus:ring-primary-500/20">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-nautical-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <div class="flex items-center space-x-2 text-[10px] font-bold text-nautical-500 uppercase tracking-widest">
          <span>{{ filteredUsers.length }} usuarios en el cuadrante</span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Identidad</th>
              <th class="px-8 py-5 text-center">Rango / Rol</th>
              <th class="px-8 py-5">Fecha de Alistamiento</th>
              <th class="px-8 py-5 text-right">Acciones de Mando</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200 bg-white/30">
            <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-primary-50 transition-all duration-300 group">    
              <td class="px-8 py-6">
                <div class="flex items-center space-x-4">
                  <div class="h-12 w-12 bg-white border-2 border-primary-100 rounded-full flex items-center justify-center text-primary-900 font-serif font-black italic text-xl shadow-sm group-hover:border-primary-500 transition-colors">
                    {{ user.name.charAt(0) }}
                  </div>
                  <div>
                    <div class="font-black text-primary-950 text-lg leading-none group-hover:text-primary-700 transition-colors">{{ user.name }}</div>
                    <div class="text-xs text-nautical-500 mt-1">{{ user.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-8 py-6 text-center">
                <span :class="user.role === 'admin' ? 'bg-primary-950 text-white border-primary-950' : 'bg-primary-50 text-primary-800 border-primary-200'"
                      class="px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border shadow-sm inline-block"> 
                  {{ user.role === 'admin' ? 'Almirante' : 'Marinero' }}
                </span>
              </td>
              <td class="px-8 py-6">
                <p class="text-sm font-bold text-nautical-700">{{ formatDate(user.created_at) }}</p>
                <p class="text-[10px] text-nautical-400 uppercase tracking-tighter">Registro oficial</p>
              </td>
              <td class="px-8 py-6 text-right">
                <div class="flex justify-end space-x-2">
                  <button @click="openModal(user)" class="p-3 text-primary-700 hover:bg-primary-100 rounded-xl transition-all group/btn" title="Modificar Rango">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                  </button>
                  <button @click="deleteUser(user.id)" class="p-3 text-red-600 hover:bg-red-50 rounded-xl transition-all group/btn" title="Eliminar del Registro">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="filteredUsers.length === 0" class="py-24 text-center bg-white/20">
        <svg class="mx-auto h-16 w-16 text-nautical-100 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        <p class="text-nautical-400 font-serif italic text-lg">No hay marineros que coincidan con su búsqueda.</p>
        <button @click="search = ''" class="mt-4 text-primary-800 font-serif font-black italic border-b border-primary-200 hover:border-primary-800 transition-all uppercase text-xs tracking-widest">Ver toda la tripulación</button>
      </div>
    </div>

    <!-- Enhanced Modal -->
    <transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-primary-950/80 backdrop-blur-md p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border-4 border-white transform transition-all">
          <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
            <div>
              <h2 class="text-3xl font-serif font-black text-primary-950 italic">Modificar Rango</h2>
              <p class="text-[10px] font-black text-nautical-400 uppercase tracking-widest mt-1">Ordenanza de la Cofradía</p>
            </div>
            <button @click="showModal = false" class="p-2 bg-white rounded-full text-primary-900 shadow-md hover:scale-110 transition-transform border border-nautical-100">     
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
          
          <form @submit.prevent="saveUser" class="p-10 space-y-8">
            <div class="flex items-center space-x-6 bg-primary-50 p-6 rounded-2xl border border-primary-100 shadow-inner">
               <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-primary-950 font-serif font-black italic text-3xl shadow-md border-2 border-primary-200">
                 {{ form.name.charAt(0) }}
               </div>
               <div>
                 <p class="text-[10px] font-black text-primary-400 uppercase tracking-widest">Perfil Seleccionado</p>
                 <p class="text-2xl font-serif font-black text-primary-950 italic leading-tight">{{ form.name }}</p>
               </div>
            </div>

            <div class="space-y-4">
              <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2 flex items-center">
                <span class="w-2 h-2 bg-primary-500 rounded-full mr-2"></span>
                Seleccionar Nuevo Rango en Flota
              </label>
              <div class="relative">
                <select v-model="form.role" class="nautical-input appearance-none bg-white pr-10 font-bold text-primary-900">
                  <option value="user">Marinero (Acceso Estándar)</option>
                  <option value="admin">Almirante (Acceso Total)</option>
                </select>
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-primary-400 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
              </div>
              <p class="text-[10px] text-nautical-400 font-serif italic text-center px-4">Esta acción cambiará los permisos de navegación del usuario inmediatamente.</p>
            </div>

            <div class="pt-4 flex flex-col gap-3">
              <button type="submit" class="w-full px-8 py-4 bg-primary-950 text-white rounded-xl font-serif italic text-lg hover:bg-primary-800 transition-all shadow-2xl font-black tracking-tight">
                Aplicar Nuevo Rango
              </button>
              <button type="button" @click="showModal = false" class="w-full px-4 py-3 text-nautical-500 font-serif italic text-sm hover:text-primary-800 transition-colors">
                Mantener rango actual
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </main>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const users = ref([])
const showModal = ref(false)
const selectedUser = ref(null)
const search = ref('')
const form = ref({ name: '', role: '' })

const fetchUsers = async () => {
  try {
    const res = await axios.get('/admin/users-list')
    users.value = res.data
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

const filteredUsers = computed(() => {
  if (!search.value) return users.value
  const s = search.value.toLowerCase()
  return users.value.filter(u => 
    u.name.toLowerCase().includes(s) || 
    u.email.toLowerCase().includes(s)
  )
})

const adminCount = computed(() => users.value.filter(u => u.role === 'admin').length)
const userCount = computed(() => users.value.filter(u => u.role !== 'admin').length)
const recentUsersCount = computed(() => {
  const monthAgo = new Date()
  monthAgo.setMonth(monthAgo.getMonth() - 1)
  return users.value.filter(u => new Date(u.created_at) > monthAgo).length
})

const openModal = (user) => {
  selectedUser.value = user
  form.value = { name: user.name, role: user.role }
  showModal.value = true
}

const saveUser = async () => {
  try {
    await axios.patch(`/admin/users/${selectedUser.value.id}/role`, { role: form.value.role })
    showModal.value = false
    fetchUsers()
  } catch (error) {
    alert('Error al actualizar el rol del usuario.')
  }
}

const deleteUser = async (id) => {
  if (confirm('¿Está seguro de que desea eliminar a este miembro de la tripulación? Esta acción es irreversible y retirará todos sus permisos.')) {
    try {
      await axios.delete(`/admin/users/${id}`)
      fetchUsers()
    } catch (error) {
      const message = error.response?.data?.message || 'Error al eliminar el usuario.'
      alert(message)
    }
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return 'Fecha desconocida'
  return new Date(dateStr).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' })
}

onMounted(fetchUsers)
</script>

<style scoped>
.nautical-card {
  @apply bg-white/80 backdrop-blur-md border border-nautical-200 shadow-xl transition-all duration-300;
}
.nautical-input {
  @apply w-full px-4 py-3 border border-nautical-300 rounded font-serif italic bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none transition-all shadow-sm;
}

/* Animations */
.modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-active .bg-white { animation: modal-in 0.3s ease-out; }

@keyframes modal-in {
  from { transform: scale(0.95) translateY(10px); opacity: 0; }
  to { transform: scale(1) translateY(0); opacity: 1; }
}
</style>
