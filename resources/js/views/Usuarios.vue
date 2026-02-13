<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-10 flex justify-between items-end">
      <div>
        <h1 class="text-4xl font-black text-slate-900">Gestión de Usuarios</h1>
        <p class="text-slate-700 mt-2 font-medium">Administra los accesos y roles de los usuarios registrados.</p>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-slate-100 border-b border-slate-300">
            <tr>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Nombre</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Email</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Rol</th>
              <th class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest text-right">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-300">
            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 transition">
              <td class="px-6 py-4 font-bold text-slate-900">{{ user.name }}</td>
              <td class="px-6 py-4 text-slate-700">{{ user.email }}</td>
              <td class="px-6 py-4">
                <span :class="user.role === 'admin' ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-600'" 
                      class="px-2 py-1 rounded text-xs font-black uppercase tracking-widest">
                  {{ user.role }}
                </span>
              </td>
              <td class="px-6 py-4 text-right space-x-3">
                <button @click="openModal(user)" class="text-primary-600 hover:text-primary-800 font-bold text-sm underline">Editar Rol</button>
                <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-800 font-bold text-sm underline">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-300">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
          <h2 class="text-xl font-bold text-slate-900">Editar Usuario</h2>
          <button @click="showModal = false" class="text-slate-600 hover:text-slate-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <form @submit.prevent="saveUser" class="p-6 space-y-4">
          <div>
            <p class="text-sm font-bold text-slate-500 mb-1">Nombre</p>
            <p class="text-lg font-black text-slate-900">{{ form.name }}</p>
          </div>
          <div>
            <label class="block text-sm font-bold text-slate-900 mb-1">Rol</label>
            <select v-model="form.role" class="w-full px-4 py-2 border border-slate-400 rounded-xl focus:ring-4 focus:ring-primary-500/30 outline-none transition">
              <option value="user">Usuario</option>
              <option value="admin">Administrador</option>
            </select>
          </div>
          <div class="pt-4 flex space-x-3">
            <button type="button" @click="showModal = false" class="flex-1 px-4 py-2 border-2 border-slate-300 rounded-xl font-bold text-slate-700 hover:bg-slate-100 transition">Cancelar</button>
            <button type="submit" class="flex-1 px-4 py-2 bg-primary-700 text-white rounded-xl font-bold hover:bg-primary-800 transition">Guardar</button>
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
