import axios from 'axios'

window.axios = axios;

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Dejamos que Axios maneje el token CSRF automáticamente a través de la cookie XSRF-TOKEN
// que Laravel envía. Esto es más robusto para aplicaciones Vue/SPA.
