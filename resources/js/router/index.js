import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Mareas from '../views/Mareas.vue'
import Especies from '../views/Especies.vue'
import Tienda from '../views/Tienda.vue'
import Carrito from '../views/Carrito.vue'
import Login from '../views/Login.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/mareas', name: 'mareas', component: Mareas },
  { path: '/especies', name: 'especies', component: Especies },
  { path: '/tienda', name: 'tienda', component: Tienda },
  { path: '/carrito', name: 'carrito', component: Carrito },
  { path: '/login', name: 'login', component: Login },
]

export default createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})