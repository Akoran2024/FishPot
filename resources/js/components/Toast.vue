<template>
  <div class="fixed top-24 right-4 z-[100] flex flex-col gap-3 pointer-events-none">
    <transition-group name="toast">
      <div v-for="toast in toastStore.toasts" :key="toast.id" 
           :class="[
             'pointer-events-auto px-6 py-4 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.2)] border flex items-center space-x-4 min-w-[320px] backdrop-blur-xl transition-all duration-500',
             toast.type === 'success' 
               ? 'bg-white/90 dark:bg-primary-900/90 border-emerald-500/30 text-primary-950 dark:text-white' 
               : 'bg-white/90 dark:bg-red-950/90 border-red-500/30 text-red-900 dark:text-red-100'
           ]">
        <div :class="['flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center shadow-inner', toast.type === 'success' ? 'bg-emerald-50 dark:bg-emerald-500/20' : 'bg-red-50 dark:bg-red-500/20']">
          <svg v-if="toast.type === 'success'" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
          <svg v-else class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div class="flex flex-col">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40 mb-0.5">{{ toast.type === 'success' ? 'Bitácora' : 'Alerta' }}</p>
            <p class="font-serif italic font-black text-base leading-tight">{{ toast.message }}</p>
        </div>
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
