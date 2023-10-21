import.meta.glob(['../images/**']);

import { createApp } from 'vue';
import axios from 'axios';

import VueSliderComponent from 'vue-slider-component';

import HeaderComponent from './components/header-component.vue';
import PieComponent from './components/pie-component.vue';
import AlertComponent from './components/alert-component.vue';
import ModalComponent from './components/modal-component.vue';
import LoaderComponent from './components/loader-component.vue';

import MoneyFormatPlugin from './plugins/money-format-plugin';

import Dashboard from './pages/dashboard/dashboard.js';
import TargetAssets from './pages/dashboard/target-assets.js';
import TargetAssetClasses from './pages/dashboard/target-asset-classes.js';
import Reabalancing from './pages/dashboard/rebalancing.js';
import Profile from './pages/dashboard/profile.js';
import Login from './pages/auth/login.js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

loadPageScript();

function loadPageScript() {
    const mainElement = document.querySelector('main');
    const mainId = mainElement.getAttribute('id');

    const pages = {
        'target-asset-classes-page': {
            component: TargetAssetClasses,
            extraComponents: {
                'VueSliderComponent': VueSliderComponent,
                'LoaderComponent': LoaderComponent,
                'HeaderComponent': HeaderComponent
            }
        },
        'target-assets-page': {
            component: TargetAssets,
            extraComponents: {
                'AlertComponent': AlertComponent,
                'ModalComponent': ModalComponent,
                'LoaderComponent': LoaderComponent,
                'HeaderComponent': HeaderComponent
            }
        },
        'rebalancing-page': {
            component: Reabalancing,
            extraComponents: {
                'AlertComponent': AlertComponent,
                'ModalComponent': ModalComponent,
                'LoaderComponent': LoaderComponent,
                'HeaderComponent': HeaderComponent
            },
            plugins: [MoneyFormatPlugin]
        },
        'dashboard-page': {
            component: Dashboard,
            extraComponents: {
                'PieComponent': PieComponent,
                'HeaderComponent': HeaderComponent
            },
            plugins: [MoneyFormatPlugin]
        },
        'profile-page': {
            component: Profile,
            extraComponents: {
                'AlertComponent': AlertComponent,
                'LoaderComponent': LoaderComponent,
                'HeaderComponent': HeaderComponent
            }
        },
        'login-page': {
            component: Login,
            extraComponents: {
                'AlertComponent': AlertComponent
            }
        },
        'terms-of-service-page': {
            component: {},
            extraComponents: {
                'HeaderComponent': HeaderComponent
            }
        },
        'privacy-policy-page': {
            component: {},
            extraComponents: {
                'HeaderComponent': HeaderComponent
            }
        },
        'pricing-page': {
            component: {},
            extraComponents: {
                'HeaderComponent': HeaderComponent
            }
        }
    };

    const appConfig = pages[mainId];

    if (appConfig) {
        const app = createApp(appConfig.component);

        for (const componentName in appConfig.extraComponents) {
            app.component(componentName, appConfig.extraComponents[componentName]);
        }

        for (const plugin in appConfig.plugins) {
            app.use(appConfig.plugins[plugin]);
        }

        app.mount('#' + mainId);
    }
}
