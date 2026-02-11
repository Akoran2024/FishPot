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
      const res = await axios.post('/login', { email, password })
      this.user = res.data.user
    },

    async logout() {
      await axios.post('/logout')
      this.user = null
    }
  }
})
