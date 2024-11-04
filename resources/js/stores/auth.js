import { defineStore } from 'pinia';

// import { useLoaderStore } from '@/stores/loader';
// import { useModalStore } from '@/stores/modal';
// import { getErrorMessage } from '@/utils/errorHandler';
import { useUserStore } from '@/stores/user';

export const useAuthStore = defineStore('authStore', {
    state: () => {
        return {
            token: null,
            user: null
        }
    },
    getters: {
        check(state) {
            return localStorage.getItem('token') ? true : false;
        }
    },
    actions: {
        async generateCSRF() {
            await axios.get('/sanctum/csrf-cookie');
        },
        async register(data) {
            // const loaderStore = useLoaderStore();
            // const modalStore = useModalStore();

            // loaderStore.show();

            await axios.post('/api/auth/register', data)
                .then(() => this.authenticate(data));
                // .catch(error => modalStore.show(getErrorMessage(error)))
                // .finally(() => loaderStore.hide());
        },
        async authenticate(data) {
            // const loaderStore = useLoaderStore();
            // const modalStore = useModalStore();

            // loaderStore.show();

            await this.generateCSRF();

            await axios.post('/api/auth/login', data)
                .then(response => {
                    this.token = response.data.data.token;
                    localStorage.setItem('token', response.data.data.token);

                    this.router.push({ name: 'dashboard' });
                });
                // .catch(error => modalStore.show(getErrorMessage(error)))
                // .finally(() => loaderStore.hide());
        },
        async logout() {
            // const loaderStore = useLoaderStore();
            // const modalStore = useModalStore();
            const userStore = useUserStore();

            // loaderStore.show();

            await axios.post('/api/auth/logout', {}, {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
                })
                .then(() => {
                    this.token = null;
                    this.user = null;
                    localStorage.removeItem('token');
                    userStore.resetData();

                    this.router.push({ name: 'login' });
                });
                // .catch(error => modalStore.show(getErrorMessage(error)))
                // .finally(() => loaderStore.hide());
        },
        async forgotPassword(data) {
            // const loaderStore = useLoaderStore();
            // const modalStore = useModalStore();

            // loaderStore.show();

            // await axios.post('/api/forgot-password', data)
            //     .then(() => modalStore.show('Confira seu e-mail e siga as instruções para redefinir sua senha.'))
            //     .catch(error => {
            //         modalStore.show(getErrorMessage(error));
            //         throw error;
            //     })
            //     .finally(() => loaderStore.hide());
        },
        async resetPassword(data) {
            // const loaderStore = useLoaderStore();
            // const modalStore = useModalStore();

            // loaderStore.show();

            // await axios.post('/api/reset-password', data)
            //     .then(() => modalStore.show('Senha alterada com sucesso! Vá para a página de login e acesse sua conta.'))
            //     .catch(error => {
            //         modalStore.show(getErrorMessage(error));
            //         throw error;
            //     })
            //     .finally(() => loaderStore.hide());
        }
    }
});
