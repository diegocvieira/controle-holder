import { createRouter, createWebHistory } from 'vue-router';

import authRoutes from './routes/auth.js';
import dashboardRoutes from './routes/dashboard.js';

import { useAuthStore } from '@/stores/auth.js';

const routes = [
    ...authRoutes,
    ...dashboardRoutes,
    // {
    //     path: '/:pathMatch(.*)*',
    //     name: 'notFound',
    //     component: () => Promise.resolve(import('@/views/error/NotFound.vue')),
    //     meta: {
    //         title: 'Página não encontrada | Tripwall'
    //     }
    // }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 }
    }
});

router.beforeEach(async (to, from, next) => {
    document.title = to.meta.title || 'Longview';

    const authStore = useAuthStore();

    // if (!authStore.user) {
    //     await authStore.getUser();
    // }

    if (!to.meta.requiresAuth || to.meta.requiresAuth && authStore.check) {
        next();
    } else {
        next('/login');
    }
});

export default router;
