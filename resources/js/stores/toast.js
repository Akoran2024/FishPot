import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', {
  state: () => ({
    toasts: []
  }),
  actions: {
    add(message, type = 'success', duration = 4000) {
      const id = Date.now()
      this.toasts.push({ id, message, type })
      setTimeout(() => {
        this.remove(id)
      }, duration)
    },
    remove(id) {
      this.toasts = this.toasts.filter(t => t.id !== id)
    }
  }
})
