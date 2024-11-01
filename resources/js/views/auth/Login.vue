<template>
    <main id="login-page" class="is-relative h-screen is-flex">
        <a href="#" class="back-link">
            <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M13.25 8.75L9.75 12L13.25 15.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
            Página inicial
        </a>

        <div class="container max-w-450">
            <div class="">
                <h1 class="page-title">Acesse sua conta no Longview</h1>
                <p class="page-description">Não tem uma conta? <router-link :to="{ name: 'register' }" class="link">Cadastre-se</router-link>.</p>
            </div>

            <form class="form" @submit.prevent="authenticate">
                <div class="form__field">
                    <label for="email" class="form__field__label">E-mail</label>
                    <input type="email" name="email" placeholder="charlie.munger@example.com" id="email" class="form__field__input" required v-model="email" />
                </div>

                <div class="form__field">
                    <label for="password" class="form__field__label">Senha</label>
                    <input type="password" name="password" placeholder="************" id="password" class="form__field__input" required v-model="password" />
                </div>

                <div class="form__field mt-10">
                    <button type="submit" class="form__field__submit-button">
                        Continuar
                        <svg class="ml-5" fill="none" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.75 6.75L19.25 12L13.75 17.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M19 12H4.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
import { useAuthStore } from '@/stores/auth';
// import { useLoaderStore } from '@/stores/loader';

export default {
    computed: {
        // loaderStore() {
        //     return useLoaderStore();
        // },
        authStore() {
            return useAuthStore();
        }
    },
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        authenticate() {
            if (!this.email || !this.password) {
                return;
            }

            const data = {
                email: this.email,
                password: this.password
            };

            this.authStore.authenticate(data);
        }
    },
    mounted() {
        // this.loaderStore.hide();
    }
};
</script>
