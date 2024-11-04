<template>
    <main id="profile-page">
        <h1 class="page-title">Perfil</h1>

        <form method="PUT" class="form" @submit.prevent="updateProfile()">
            <div class="form__section-title">
                <h2>Dados pessoais</h2>
            </div>

            <div class="padding-1">
                <div class="form__field">
                    <label for="name" class="form__field__label">Nome</label>
                    <input type="text" name="name" v-model="userStore.user.name" placeholder="Charlie Munger" class="form__field__input" required />
                </div>

                <div class="form__field">
                    <label for="email" class="form__field__label">E-mail</label>
                    <input type="email" name="email" v-model="userStore.user.email" placeholder="charlie.munger@example.com" class="form__field__input" required />
                </div>
            </div>

            <div class="border-top padding-1">
                <div class="form__field">
                    <button type="submit" class="form__field__submit-button">Atualizar perfil</button>
                </div>
            </div>
        </form>

        <form method="PUT" class="form" @submit.prevent="updatePassword()">
            <div class="form__section-title">
                <h2>Senha</h2>
            </div>

            <div class="padding-1">
                <div class="form__field">
                    <label for="current_password" class="form__field__label">Senha atual</label>
                    <input type="password" name="current_password" v-model="currentPassword" placeholder="************" class="form__field__input" required />
                </div>

                <div class="form__field">
                    <label for="password" class="form__field__label">Nova senha</label>
                    <input type="password" name="password" v-model="password" placeholder="************" class="form__field__input" required />
                </div>

                <div class="form__field">
                    <label for="password_confirmation" class="form__field__label">Confirmar nova senha</label>
                    <input type="password" name="password_confirmation" v-model="passwordConfirmation" placeholder="************" class="form__field__input" required />
                </div>
            </div>

            <div class="border-top padding-1">
                <div class="form__field">
                    <button type="submit" class="form__field__submit-button">Atualizar senha</button>
                </div>
            </div>
        </form>

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>
import Modal from '@/components/Modal.vue';
import Notification from '@/components/Notification.vue';

import { useUserStore } from '@/stores/user';

export default {
    components: {
        Modal,
        Notification
    },
    data() {
        return {
            currentPassword: '',
            password: '',
            passwordConfirmation: ''
        }
    },
    computed: {
        userStore() {
            return useUserStore();
        }
    },
    methods: {
        updateProfile() {
            if (!this.userStore.user.name || !this.userStore.user.email) {
                return;
            }

            const data = {
                name: this.userStore.user.name,
                email: this.userStore.user.email
            };

            this.userStore.updateProfile(data)
                .then(() => {
                    this.$refs.notification.showSuccess('Perfil atualizado com sucesso.');
                })
                .catch((error) => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        updatePassword() {
            if (!this.validatePassword()) {
                return;
            }

            const data = {
                current_password: this.currentPassword,
                password: this.password,
                password_confirmation: this.passwordConfirmation
            };

            this.userStore.updatePassword(data)
                .then(() => {
                    this.$refs.notification.showSuccess('Senha atualizada com sucesso.');
                })
                .catch((error) => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        validatePassword() {
            if (!this.currentPassword || !this.password || !this.passwordConfirmation) {
                return false;
            }

            if (this.password !== this.passwordConfirmation) {
                this.$refs.notification.showError('As senhas não conferem.');
                return false;
            }

            return true;
        }
    },
    created () {
        this.userStore.getData()
            .catch(() => {
                this.$refs.notification.showError('Ocorreu um erro ao carregar seus dados.');
            });
    },
    updated () {
        // this.$refs.loader.show = false;
    }
};
</script>
