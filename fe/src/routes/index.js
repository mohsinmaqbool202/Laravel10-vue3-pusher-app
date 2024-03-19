import { createRouter, createWebHistory } from "vue-router";

import Login from '../views/Login.vue'
import Register from '../views/Register.vue';
import Chat from '../views/Chat.vue';

const routes = [
    {
       path: '/login',
       name: 'Login',
       component: Login,
       meta: { requiresAuth: false },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { requiresAuth: false },
    },
    {
        path: '/chat',
        name: 'Chat',
        component: Chat,
        meta: { requiresAuth: true },
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    if(to.meta.requiresAuth) {
        if (token) {
            next();
        }
        else {
            next('/login');
        }
    }
    else {
        if (token) {
            next('/chat');
        }
        else {
            next();
        }
    }
});

export default router;