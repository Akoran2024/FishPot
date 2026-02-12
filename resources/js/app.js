import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount('#app');
