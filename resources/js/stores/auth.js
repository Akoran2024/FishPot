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
      try {
        console.log('Solicitando token CSRF...')
        await axios.get('/sanctum/csrf-cookie')
        
        console.log('Intentando login para:', email)
        const res = await axios.post('/gestor-privado', { email, password })
        console.log('Respuesta de login exitosa:', res.status)
        await this.fetchUser()
      } catch (error) {
        console.error('Error detallado en login:', {
          status: error.response?.status,
          data: error.response?.data,
          message: error.message
        })
        throw error
      }
    },

    async register(userData) {
      await axios.post('/register', userData)
      await this.fetchUser()
    },

    async logout() {
      try {
        await axios.post('/logout')
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.user = null
      }
    },

    async forgotPassword(email) {
      await axios.get('/sanctum/csrf-cookie')
      return await axios.post('/forgot-password', { email })
    },

    async resetPassword(data) {
      await axios.get('/sanctum/csrf-cookie')
      return await axios.post('/reset-password', data)
    }
  }
})
