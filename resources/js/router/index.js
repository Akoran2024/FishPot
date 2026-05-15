import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import Home from '../views/Home.vue'
import Tides from '../views/Tides.vue'
import Species from '../views/Species.vue'
import Shop from '../views/Shop.vue'
import Cart from '../views/Cart.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import Clients from '../views/Clients.vue'
import Orders from '../views/Orders.vue'
import Products from '../views/Products.vue'
import Users from '../views/Users.vue'
import UserCreate from '../views/UserCreate.vue'
import Locations from '../views/Locations.vue'
import License from '../views/License.vue'
import MyOrders from '../views/MyOrders.vue'
import AdminDashboard from '../views/admin/Dashboard.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/mareas', name: 'tides', component: Tides },
  { path: '/especies', name: 'species', component: Species },
  { path: '/lugares', name: 'locations', component: Locations },
  { path: '/licencia', name: 'license', component: License },
  { path: '/tienda', name: 'shop', component: Shop },
  { path: '/carrito', name: 'cart', component: Cart },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/forgot-password', name: 'forgot-password', component: ForgotPassword },
  { path: '/reset-password/:token', name: 'reset-password', component: ResetPassword },
  { path: '/mis-pedidos', name: 'my-orders', component: MyOrders, meta: { requiresAuth: true } },
  { path: '/admin', name: 'admin.dashboard', component: AdminDashboard, meta: { requiresAuth: true } },
  { path: '/admin/pedidos', name: 'admin.orders', component: Orders, meta: { requiresAuth: true } },
  { path: '/admin/productos', name: 'admin.products.index', component: Products, meta: { requiresAuth: true } },
  { path: '/admin/usuarios', name: 'admin.users.index', component: Users, meta: { requiresAuth: true } },
  { path: '/admin/usuarios/crear', name: 'admin.users.create', component: UserCreate, meta: { requiresAuth: true } },
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
