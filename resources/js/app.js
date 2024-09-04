import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import LinkPage from './components/LinkPage.vue';
import Register from './components/Register.vue';

const routes = [
    { path: '/', component: Register },
    { path: '/link/:token', component: LinkPage }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp({});
app.use(router);
app.mount('#app');

