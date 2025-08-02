<template>
    <main id="register-page" class="is-relative h-screen is-flex">
        <router-link :to="{ name: 'home' }" class="back-link">
            <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M13.25 8.75L9.75 12L13.25 15.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
            Página inicial
        </router-link>

        <div class="container max-w-450">
            <div class="">
                <h1 class="page-title">Crie uma conta no Longview</h1>
                <p class="page-description">Já tem uma conta? <router-link :to="{ name: 'login' }" class="link">Conecte-se</router-link>.</p>
            </div>

            <form class="form" @submit.prevent="register">
                <div class="form__field">
                    <label for="name" class="form__field__label">Nome</label>
                    <input type="text" name="name" placeholder="Charlie Munger" id="name" class="form__field__input" required v-model="name" />
                </div>

                <div class="form__field">
                    <label for="email" class="form__field__label">E-mail</label>
                    <input type="email" name="email" placeholder="charlie.munger@example.com" id="email" class="form__field__input" required v-model="email" />
                </div>

                <div class="form__field">
                    <label for="password" class="form__field__label">Senha</label>
                    <input type="password" name="password" placeholder="************" id="password" class="form__field__input" required v-model="password" />
                </div>

                <div class="form__field">
                    <label for="password-confirmation" class="form__field__label">Confirmar senha</label>
                    <input type="password" name="password_confirmation" placeholder="************" id="password-confirmation" class="form__field__input" required v-model="passwordConfirmation" />
                </div>

                <div class="form__field mt-10">
                    <button type="submit" class="form__field__submit-button">Criar conta</button>
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
            name: '',
            email: '',
            password: '',
            passwordConfirmation: ''
        }
    },
    methods: {
        register() {
            if (!this.name || !this.email || !this.password || !this.password) {
                return;
            }

            if (this.password !== this.passwordConfirmation) {
                console.log('As senhas não conferem.');
                return;
            }

            const data = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirmation
            };

            this.authStore.register(data);
        }
    },
    mounted() {
        // this.loaderStore.hide();
    }
};
</script>
