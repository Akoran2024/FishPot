<template>



  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8" id="main-content">
    <div class="mb-10 flex justify-between items-end">
      <div>
        <h1 class="text-4xl font-black text-slate-900">Gestión de Clientes</h1>
        <p class="text-slate-700 mt-2 font-medium">Administra la base de datos de tus clientes.</p>
      </div>
      <button @click="openModal()" class="bg-primary-700 hover:bg-primary-800 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-primary-200 focus:ring-4 focus:ring-primary-500 focus:outline-none" aria-label="Crear nuevo cliente">
        Nuevo Cliente
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" aria-label="Lista de clientes">
          <thead class="bg-slate-100 border-b border-slate-300">
            <tr>
              <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Nombre</th>
              <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Email</th>
              <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Teléfono</th>
              <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest">Dirección</th>
              <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-800 uppercase tracking-widest text-right">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-300">
            <tr v-for="client in clients" :key="client.id" class="hover:bg-slate-50 transition">
              <td class="px-6 py-4 font-bold text-slate-900">{{ client.name }}</td>
              <td class="px-6 py-4 text-slate-700">{{ client.email || '-' }}</td>
              <td class="px-6 py-4 text-slate-700">{{ client.phone || '-' }}</td>
              <td class="px-6 py-4 text-slate-700">{{ client.address || '-' }}</td>
              <td class="px-6 py-4 text-right space-x-2">
                <button @click="openModal(client)" class="text-primary-700 hover:text-primary-900 font-bold text-sm underline decoration-2 underline-offset-2 focus:ring-2 focus:ring-primary-500 rounded px-1">Editar<span class="sr-only"> a {{ client.name }}</span></button>
                <button @click="deleteClient(client.id)" class="text-red-700 hover:text-red-900 font-bold text-sm underline decoration-2 underline-offset-2 focus:ring-2 focus:ring-red-500 rounded px-1">Eliminar<span class="sr-only"> a {{ client.name }}</span></button>
              </td>
            </tr>
            <tr v-if="clients.length === 0">
              <td colspan="5" class="px-6 py-10 text-center text-slate-600 italic">No hay clientes registrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 backdrop-blur-sm p-4" role="dialog" aria-modal="true" :aria-labelledby="editingId ? 'modal-title-edit' : 'modal-title-new'">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200 border border-slate-300">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
          <h2 :id="editingId ? 'modal-title-edit' : 'modal-title-new'" class="text-xl font-bold text-slate-900">{{ editingId ? 'Editar Cliente' : 'Nuevo Cliente' }}</h2>
          <button @click="showModal = false" class="text-slate-600 hover:text-slate-900 p-1 rounded focus:ring-2 focus:ring-primary-500" aria-label="Cerrar modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <form @submit.prevent="saveClient" class="p-6 space-y-4">
          <div>
            <label for="client-name" class="block text-sm font-bold text-slate-900 mb-1">Nombre *</label>
            <input id="client-name" v-model="form.name" type="text" required class="w-full px-4 py-2 border border-slate-400 rounded-xl text-slate-900 focus:ring-4 focus:ring-primary-500/30 focus:border-primary-600 outline-none transition" aria-required="true">
          </div>
          <div>
            <label for="client-email" class="block text-sm font-bold text-slate-900 mb-1">Email</label>
            <input id="client-email" v-model="form.email" type="email" class="w-full px-4 py-2 border border-slate-400 rounded-xl text-slate-900 focus:ring-4 focus:ring-primary-500/30 focus:border-primary-600 outline-none transition">
          </div>
          <div>
            <label for="client-phone" class="block text-sm font-bold text-slate-900 mb-1">Teléfono</label>
            <input id="client-phone" v-model="form.phone" type="text" class="w-full px-4 py-2 border border-slate-400 rounded-xl text-slate-900 focus:ring-4 focus:ring-primary-500/30 focus:border-primary-600 outline-none transition">
          </div>
          <div>
            <label for="client-address" class="block text-sm font-bold text-slate-900 mb-1">Dirección</label>
            <input id="client-address" v-model="form.address" type="text" class="w-full px-4 py-2 border border-slate-400 rounded-xl text-slate-900 focus:ring-4 focus:ring-primary-500/30 focus:border-primary-600 outline-none transition">
          </div>
          <div class="pt-4 flex space-x-3">
            <button type="button" @click="showModal = false" class="flex-1 px-4 py-2 border-2 border-slate-300 rounded-xl font-bold text-slate-700 hover:bg-slate-100 focus:ring-4 focus:ring-slate-200 transition">
              Cancelar
            </button>
            <button type="submit" class="flex-1 px-4 py-2 bg-primary-700 text-white rounded-xl font-bold hover:bg-primary-800 focus:ring-4 focus:ring-primary-500 transition">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const clients = ref([])
const showModal = ref(false)
const editingId = ref(null)
const form = ref({
  name: '',
  email: '',
  phone: '',
  address: ''
})

const fetchClients = async () => {
  const res = await axios.get('/clients')
  clients.value = res.data
}

const openModal = (client = null) => {
  if (client) {
    editingId.value = client.id
    form.value = { ...client }
  } else {
    editingId.value = null
    form.value = { name: '', email: '', phone: '', address: '' }
  }
  showModal.value = true
}

const saveClient = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/clients/${editingId.value}`, form.value)
    } else {
      await axios.post('/clients', form.value)
    }
    showModal.value = false
    fetchClients()
  } catch (error) {
    alert('Error al guardar el cliente. Verifique los datos.')
  }
}

const deleteClient = async (id) => {
  if (confirm('¿Estás seguro de eliminar este cliente?')) {
    await axios.delete(`/clients/${id}`)
    fetchClients()
  }
}

onMounted(fetchClients)
</script>
