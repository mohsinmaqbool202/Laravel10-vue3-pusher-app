import './style.css';
import App from './App.vue';
import router from './routes';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import 'vue3-toastify/dist/index.css';
import Vue3Toasity from 'vue3-toastify';
import './plugins/pusher';  

const pinia = createPinia();
const app = createApp(App);

// Use Vue3Toasity plugin
app.use(Vue3Toasity, {
    autoClose: 5000,
    position: 'bottom-right',
    theme: 'colored'
});

app.use(pinia);
app.use(router);
app.mount('#app');
