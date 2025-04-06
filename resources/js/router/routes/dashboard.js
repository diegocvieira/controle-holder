import DashboardLayout from '@/layouts/Dashboard.vue';

export default [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => Promise.resolve(import('@/views/dashboard/Dashboard.vue')),
        meta: {
            title: 'Dashboard | Longview',
            layout: DashboardLayout,
            menuSection: 'dashboard',
            requiresAuth: true
        }
    }, {
        path: '/dashboard/meta/classes-de-ativos',
        name: 'targetAssetClasses',
        component: () => Promise.resolve(import('@/views/target/AssetClasses.vue')),
        meta: {
            title: 'Meta de classes de ativos | Longview',
            layout: DashboardLayout,
            menuSection: 'target-asset-classes',
            requiresAuth: true
        }
    }, {
        path: '/dashboard/meta/ativos',
        name: 'targetAsset',
        component: () => Promise.resolve(import('@/views/target/Asset.vue')),
        meta: {
            title: 'Meta de ativos | Longview',
            layout: DashboardLayout,
            menuSection: 'target-assets',
            requiresAuth: true
        }
    }, {
        path: '/dashboard/rebalanceamento',
        name: 'rebalancing',
        component: () => Promise.resolve(import('@/views/rebalancing/Rebalancing.vue')),
        meta: {
            title: 'Rebalanceamento | Longview',
            layout: DashboardLayout,
            menuSection: 'rebalancing',
            requiresAuth: true
        }
    }, {
        path: '/dashboard/premium',
        name: 'plans',
        component: () => Promise.resolve(import('@/views/plan/Plan.vue')),
        meta: {
            title: 'PREMIUM | Longview',
            layout: DashboardLayout,
            menuSection: 'plans',
            requiresAuth: true
        }
    }
];
