<template>
  <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
    <div class="mb-12 flex justify-between items-end border-b border-primary-950/10 pb-8">
      <div>
        <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-1 rounded-full border border-nautical-200 mb-4 shadow-sm">
          <span class="text-primary-800 font-serif italic text-[10px] uppercase tracking-widest font-bold">Tripulación</span>
        </div>
        <h1 class="text-5xl font-serif font-black text-primary-950 italic">Crear Nuevo Usuario</h1>
        <p class="text-nautical-700 mt-2 font-serif italic text-lg leading-relaxed">Añade un nuevo miembro a la comunidad FishPot.</p>
      </div>
      <router-link :to="{ name: 'admin.usuarios.index' }" class="nautical-btn py-3 px-6">
        Volver a Usuarios
      </router-link>
    </div>

    <div class="nautical-card p-12 max-w-2xl mx-auto">
      <form @submit.prevent="createUser" class="space-y-6">
        <div class="space-y-1.5">
          <label for="name" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Nombre Completo</label>
          <input id="name" v-model="form.name" type="text" required class="nautical-input" placeholder="NOMBRE DEL NUEVO USUARIO">
          <span v-if="validationErrors.name" class="text-red-500 text-xs italic">{{ validationErrors.name[0] }}</span>
        </div>

        <div class="space-y-1.5">
          <label for="email" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Correo Electrónico</label>
          <input id="email" v-model="form.email" type="email" required class="nautical-input" placeholder="correo@ejemplo.com">
          <span v-if="validationErrors.email" class="text-red-500 text-xs italic">{{ validationErrors.email[0] }}</span>
        </div>
        
        <div class="space-y-1.5">
          <label for="password" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Contraseña</label>
          <input id="password" v-model="form.password" type="password" required class="nautical-input" placeholder="••••••••">
          <span v-if="validationErrors.password" class="text-red-500 text-xs italic">{{ validationErrors.password[0] }}</span>
        </div>

        <div class="space-y-1.5">
          <label for="password_confirmation" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Confirmar Contraseña</label>
          <input id="password_confirmation" v-model="form.password_confirmation" type="password" required class="nautical-input" placeholder="••••••••">
          <span v-if="validationErrors.password_confirmation" class="text-red-500 text-xs italic">{{ validationErrors.password_confirmation[0] }}</span>
        </div>

        <div class="space-y-1.5">
          <label for="role" class="block text-[10px] font-bold text-nautical-400 uppercase tracking-[0.2em] ml-1 italic">Rol de Usuario</label>
          <select id="role" v-model="form.role" class="nautical-input" required>
            <option value="user">Marinero (Usuario Estándar)</option>
            <option value="admin">Almirante (Administrador)</option>
          </select>
          <span v-if="validationErrors.role" class="text-red-500 text-xs italic">{{ validationErrors.role[0] }}</span>
        </div>
        
        <div class="pt-6">
          <button type="submit" class="nautical-btn w-full py-4 text-center">
            Crear Usuario
          </button>
        </div>
      </form>
    </div>
  </main>
</template>

<script setup>
import { reactive } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'user' // Default role
})

const validationErrors = reactive({})

const createUser = async () => {
  // Clear previous errors
  Object.keys(validationErrors).forEach(key => delete validationErrors[key]);

  try {
    await axios.post('/admin/users', form) // Submit to Laravel's AdminUserController@store
    alert('Usuario creado exitosamente.');
    router.push({ name: 'admin.usuarios.index' });
  } catch (error) {
    if (error.response && error.response.status === 422) {
      Object.assign(validationErrors, error.response.data.errors);
      alert('Error de validación: Por favor, revise los campos marcados.');
    } else {
      console.error('Error al crear usuario:', error);
      alert('Hubo un error al crear el usuario.');
    }
  }
}
</script>

<style scoped>
.nautical-input {
  @apply w-full px-5 py-3 bg-nautical-50 border border-nautical-200 rounded font-serif italic text-sm focus:ring-1 focus:ring-primary-800 focus:border-primary-800 outline-none transition-all placeholder:text-nautical-300;
}
</style>
