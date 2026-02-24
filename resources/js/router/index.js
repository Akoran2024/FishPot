import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Home from '../views/Home.vue'
import Mareas from '../views/Mareas.vue'
import Especies from '../views/Especies.vue'
import Tienda from '../views/Tienda.vue'
import Carrito from '../views/Carrito.vue'
import Login from '../views/Login.vue'
import Clientes from '../views/Clientes.vue'
import Pedidos from '../views/Pedidos.vue'
import Productos from '../views/Productos.vue'
import Usuarios from '../views/Usuarios.vue'
import Lugares from '../views/Lugares.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/mareas', name: 'mareas', component: Mareas },
  { path: '/especies', name: 'especies', component: Especies },
  { path: '/lugares', name: 'lugares', component: Lugares },
  { path: '/tienda', name: 'tienda', component: Tienda },
  { path: '/carrito', name: 'carrito', component: Carrito },
  { path: '/login', name: 'login', component: Login },
  { path: '/admin/pedidos', name: 'admin.pedidos', component: Pedidos, meta: { requiresAuth: true } },
  { path: '/admin/productos', name: 'admin.productos.index', component: Productos, meta: { requiresAuth: true } },
  { path: '/admin/usuarios', name: 'admin.usuarios.index', component: Usuarios, meta: { requiresAuth: true } },
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
  
  // Solo intentamos cargar el usuario si no está cargado y no hay una carga en curso
  if (!authStore.user && authStore.loading) {
    await authStore.fetchUser()
  }

  if (to.meta.requiresAuth && !authStore.user) {
    next('/login')
  } else {
    next()
  }
})

export default router