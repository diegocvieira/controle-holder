import Vue from 'vue';
import axios from 'axios';

window.Vue = Vue;
window.Vue.prototype.asset = window.asset;

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

loadPageScript();

function loadPageScript() {
    const mainElement = document.querySelector('main');
    const mainId = mainElement.getAttribute('id');

    switch (mainId) {
        case 'target-assets-page':
            import('./pages/dashboard/target-assets.js');
            break;
        case 'rebalancing-page':
            import('./pages/dashboard/rebalancing.js');
            break;
        case 'login-page':
            import('./pages/auth/login.js');
            break;
        case 'dashboard-page':
            import('./pages/dashboard/dashboard.js');
            break;
        case 'target-asset-classes-page':
            import('./pages/dashboard/target-asset-classes.js');
            break;
        case 'profile-page':
            import('./pages/dashboard/profile.js');
            break;
        default:
            break;
    }
}
