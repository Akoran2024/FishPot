<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex justify-between items-end border-b border-primary-950/10 pb-8">
      <div>
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1 rounded-full border border-nautical-200 mb-4 shadow-sm">
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Tripulación</span>
        </div>
        <h1 class="text-5xl font-serif font-black text-primary-950 italic">Gestión de Usuarios</h1>
        <p class="text-nautical-700 mt-2 font-serif italic text-lg leading-relaxed">Administra los accesos y roles de la comunidad FishPot.</p>
      </div>
    </div>

    <!-- Table Section con estilo de Bitácora -->
    <div class="nautical-card overflow-hidden">      
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-serif italic">
          <thead class="bg-primary-950 text-white uppercase tracking-widest text-[10px] font-bold">
            <tr>
              <th class="px-8 py-5">Nombre</th>
              <th class="px-8 py-5">Email</th>
              <th class="px-8 py-5 text-center">Rol de Usuario</th>
              <th class="px-8 py-5 text-right">Acciones de Mando</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-nautical-200">
            <tr v-for="user in users" :key="user.id" class="hover:bg-primary-50/50 transition-all duration-300">    
              <td class="px-8 py-6 font-black text-primary-950 text-lg">{{ user.name }}</td>
              <td class="px-8 py-6 text-nautical-600">{{ user.email }}</td>
              <td class="px-8 py-6 text-center">
                <span :class="user.role === 'admin' ? 'bg-primary-950 text-white' : 'bg-primary-100 text-primary-800'"
                      class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-primary-200"> 
                  {{ user.role === 'admin' ? 'Almirante' : 'Marinero' }}
                </span>
              </td>
              <td class="px-8 py-6 text-right space-x-4">
                <button @click="openModal(user)" class="text-primary-700 hover:text-primary-950 font-black text-sm uppercase tracking-tighter transition-colors border-b-2 border-primary-200 hover:border-primary-700">Editar Rol</button>
                <button @click="deleteUser(user.id)" class="text-red-700 hover:text-red-950 font-black text-sm uppercase tracking-tighter transition-colors">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal con Estilo Náutico -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/70 backdrop-blur-sm p-4">
      <div class="bg-white/95 backdrop-blur-md rounded shadow-2xl w-full max-w-md overflow-hidden border border-nautical-200">
        <div class="p-8 border-b border-nautical-100 flex justify-between items-center bg-nautical-50">
          <h2 class="text-2xl font-serif font-black text-primary-950 italic">Modificar Rango</h2>
          <button @click="showModal = false" class="text-primary-900 hover:scale-110 transition-transform">     
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <form @submit.prevent="saveUser" class="p-8 space-y-6">
          <div>
            <p class="text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Nombre del Usuario</p>
            <p class="text-2xl font-serif font-black text-primary-950 italic">{{ form.name }}</p>
          </div>
          <div>
            <label class="block text-[10px] font-black text-primary-800 uppercase tracking-widest mb-2">Seleccionar Nuevo Rol</label>
            <select v-model="form.role" class="w-full px-4 py-3 border border-nautical-300 rounded font-serif italic bg-white focus:ring-4 focus:ring-primary-500/20 outline-none transition shadow-inner">
              <option value="user">Marinero (Usuario Estándar)</option>
              <option value="admin">Almirante (Administrador)</option>
            </select>
          </div>
          <div class="pt-6 flex space-x-3">
            <button type="button" @click="showModal = false" class="flex-1 px-4 py-3 border border-nautical-300 rounded font-serif italic text-primary-800 hover:bg-nautical-50 transition font-bold">Cancelar</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-primary-950 text-white rounded font-serif italic text-lg hover:bg-primary-800 transition shadow-xl font-black tracking-tight">Aplicar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const showModal = ref(false)
const selectedUser = ref(null)
const form = ref({ name: '', role: '' })

const fetchUsers = async () => {
  try {
    const res = await axios.get('/admin/users-list')
    users.value = res.data
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

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
  if (confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')) {
    try {
      await axios.delete(`/admin/users/${id}`)
      fetchUsers()
    } catch (error) {
      const message = error.response?.data?.message || 'Error al eliminar el usuario.'        
      alert(message)
    }
  }
}

onMounted(fetchUsers)
</script>

<style scoped>
.nautical-card {
  @apply bg-white/50 backdrop-blur-md border border-nautical-200 shadow-2xl transition-all duration-300;
}
</style>