// import.meta.glob([
//     '../images/favicons/*',
//     '../images/cover.webp'
// ]);

import { createApp, markRaw } from 'vue';
import axios from 'axios';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router/index.js';
// import HelperPlugin from './plugins/helper-plugin.js';
// import dateFormatter from './plugins/dateFormatter.js';
// import { clickOutside } from './directives/clickOutside.js';

// import './echo.js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

const app = createApp(App);
const pinia = createPinia();

pinia.use(({ store }) => {
    store.router = markRaw(router);
    // store.plugins = app.config.globalProperties;
});

// app.directive('click-outside', clickOutside);

// app.use(dateFormatter);
// app.use(HelperPlugin);
app.use(pinia);
app.use(router);

app.mount('#app');
