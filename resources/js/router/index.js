import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Home from '../views/Home.vue'
import Mareas from '../views/Mareas.vue'
import Especies from '../views/Especies.vue'
import Tienda from '../views/Tienda.vue'
import Carrito from '../views/Carrito.vue'
import Login from '../views/Login.vue'
import Clientes from '../views/Clientes.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/mareas', name: 'mareas', component: Mareas },
  { path: '/especies', name: 'especies', component: Especies },
  { path: '/tienda', name: 'tienda', component: Tienda },
  { path: '/carrito', name: 'carrito', component: Carrito },
  { path: '/login', name: 'login', component: Login },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  
  if (authStore.loading) {
    await authStore.fetchUser()
  }

  if (to.meta.requiresAuth && !authStore.user) {
    next('/login')
  } else {
    next()
  }
})

export default router