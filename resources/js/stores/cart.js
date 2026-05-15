import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: JSON.parse(localStorage.getItem('cart')) || [],
  }),
  
  getters: {
    totalItems: (state) => state.items.reduce((sum, item) => sum + item.quantity, 0),
    totalPrice: (state) => state.items.reduce((sum, item) => sum + (item.price * item.quantity), 0),
  },

  actions: {
    saveToLocalStorage() {
      localStorage.setItem('cart', JSON.stringify(this.items))
    },
    addItem(product) {
      const existing = this.items.find(i => i.id === product.id)
      if (existing) {
        existing.quantity++
      } else {
        this.items.push({ ...product, quantity: 1 })
      }
      this.saveToLocalStorage()
    },
    removeItem(productId) {
      this.items = this.items.filter(i => i.id !== productId)
      this.saveToLocalStorage()
    },
    clearCart() {
      this.items = []
      localStorage.removeItem('cart')
    }
  }
})
