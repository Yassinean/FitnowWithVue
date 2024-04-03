import { createWebHistory, createRouter } from "vue-router";

import home from './pages/home.vue';
import login from './pages/login.vue';
import register from './pages/register.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: home
    },
    {
        path: '/',
        name: 'login',
        component: login
    },
    {
        path: '/',
        name: 'register',
        component: register
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;