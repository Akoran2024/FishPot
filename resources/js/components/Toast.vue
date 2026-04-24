<template>
  <div class="fixed top-24 right-4 z-[100] flex flex-col gap-3 pointer-events-none">
    <transition-group name="toast">
      <div v-for="toast in toastStore.toasts" :key="toast.id" 
           :class="[
             'pointer-events-auto px-6 py-4 rounded-lg shadow-2xl border-l-4 flex items-center space-x-4 min-w-[300px] backdrop-blur-md transition-all duration-300',
             toast.type === 'success' ? 'bg-emerald-50/90 border-emerald-500 text-emerald-900' : 'bg-red-50/90 border-red-500 text-red-900'
           ]">
        <div class="flex-shrink-0">
          <svg v-if="toast.type === 'success'" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          <svg v-else class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <p class="font-serif italic font-bold text-sm">{{ toast.message }}</p>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useToastStore } from '../stores/toast'
const toastStore = useToastStore()
</script>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
.toast-enter-from { opacity: 0; transform: translateX(100px); }
.toast-leave-to { opacity: 0; transform: scale(0.9); }
</style>
