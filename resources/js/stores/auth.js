import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    loading: true,
  }),

  actions: {
    async fetchUser() {
      try {
        const res = await axios.get('/user')
        this.user = res.data
      } catch {
        this.user = null
      } finally {
        this.loading = false
      }
    },

    async login(email, password) {
      const res = await axios.post('/gestor-privado', { email, password })
      // Si Laravel redirige, axios puede manejarlo o fallar si no hay JSON.
      // Pero para asegurar que el estado se actualice, intentamos obtener el usuario.
      await this.fetchUser()
    },

    async logout() {
      await axios.post('/logout')
      this.user = null
    }
  }
})
