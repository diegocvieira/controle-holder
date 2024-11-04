import DashboardLayout from '@/layouts/Dashboard.vue';

export default [
    {
        path: '/dashboard/perfil',
        name: 'profile',
        component: () => Promise.resolve(import('@/views/user/Profile.vue')),
        meta: {
            title: 'Perfil | Longview',
            layout: DashboardLayout,
            menuSection: 'profile',
            requiresAuth: true
        }
    }
];
