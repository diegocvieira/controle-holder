import AuthLayout from '@/layouts/Auth.vue';

export default [
    {
        path: '/login',
        name: 'login',
        component: () => Promise.resolve(import('@/views/auth/Login.vue')),
        meta: {
            title: 'Login | Longview',
            layout: AuthLayout
        }
    }, {
        path: '/cadastro',
        name: 'register',
        component: () => Promise.resolve(import('@/views/auth/Register.vue')),
        meta: {
            title: 'Cadastro | Longview',
            layout: AuthLayout
        }
    }
];
