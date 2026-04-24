import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Home from '../views/Home.vue'
import Mareas from '../views/Mareas.vue'
import Especies from '../views/Especies.vue'
import Tienda from '../views/Tienda.vue'
import Carrito from '../views/Carrito.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Clientes from '../views/Clientes.vue'
import Pedidos from '../views/Pedidos.vue'
import Productos from '../views/Productos.vue'
import Usuarios from '../views/Usuarios.vue'
import UserCreate from '../views/UserCreate.vue' // Import the new component
import Lugares from '../views/Lugares.vue'
import Licencia from '../views/Licencia.vue'
import MisPedidos from '../views/MisPedidos.vue'
import AdminDashboard from '../views/admin/Dashboard.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/mareas', name: 'mareas', component: Mareas },
  { path: '/especies', name: 'especies', component: Especies },
  { path: '/lugares', name: 'lugares', component: Lugares },
  { path: '/licencia', name: 'licencia', component: Licencia },
  { path: '/tienda', name: 'tienda', component: Tienda },
  { path: '/carrito', name: 'carrito', component: Carrito },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/mis-pedidos', name: 'mis-pedidos', component: MisPedidos, meta: { requiresAuth: true } },
  { path: '/admin', name: 'admin.dashboard', component: AdminDashboard, meta: { requiresAuth: true } },
  { path: '/admin/pedidos', name: 'admin.pedidos', component: Pedidos, meta: { requiresAuth: true } },
  { path: '/admin/productos', name: 'admin.productos.index', component: Productos, meta: { requiresAuth: true } },
  { path: '/admin/usuarios', name: 'admin.usuarios.index', component: Usuarios, meta: { requiresAuth: true } },
  { path: '/admin/usuarios/crear', name: 'admin.usuarios.create', component: UserCreate, meta: { requiresAuth: true } }, // New route
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

// Optimizamos el guardián para que no bloquee la navegación innecesariamente
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  
  // Si es la primera carga y no tenemos usuario, lo intentamos traer
  if (authStore.loading) {
    try {
      await authStore.fetchUser()
    } catch (e) {
      // Ignorar error de carga inicial
    }
  }

  if (to.meta.requiresAuth && !authStore.user) {
    next('/login')
  } else {
    next()
  }
})

export default router
