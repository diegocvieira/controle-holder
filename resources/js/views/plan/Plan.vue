<template>
    <main id="plans-page" class="max-width-70">
        <h1 class="page-title">Planos</h1>

        <div class="cancel-at" v-if="subscriptionStore.isCancelAt">
            <h2>Assinatura agendada para cancelamento</h2>

            <p>Você continuará tendo acesso ao seu plano atual até o dia <b>{{ subscriptionStore.cancelAt }}</b>. Após essa data, sua conta será migrada automaticamente para o plano gratuito.</p>

            <div class="is-flex">
                <button type="button" @click="resumeSubscription()">Manter assinatura ativa</button>
            </div>
        </div>

        <div class="plans">
            <div class="plan">
                <h3>Gratuito</h3>
                <span>R$0 / mês</span>
                <ul>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Acesso a plataforma
                    </li>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Portfólio consolidado
                    </li>
                    <li>
                        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM9.46875 9.46875C9.7625 9.175 10.2375 9.175 10.5281 9.46875L11.9969 10.9375L13.4656 9.46875C13.7594 9.175 14.2344 9.175 14.525 9.46875C14.8156 9.7625 14.8187 10.2375 14.525 10.5281L13.0562 11.9969L14.525 13.4656C14.8187 13.7594 14.8187 14.2344 14.525 14.525C14.2312 14.8156 13.7562 14.8187 13.4656 14.525L11.9969 13.0562L10.5281 14.525C10.2344 14.8187 9.75938 14.8187 9.46875 14.525C9.17812 14.2312 9.175 13.7562 9.46875 13.4656L10.9375 11.9969L9.46875 10.5281C9.175 10.2344 9.175 9.75938 9.46875 9.46875Z" fill="currentColor"></path></svg>
                        Cadastro ilimitado de ativos
                    </li>
                    <li>
                        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM9.46875 9.46875C9.7625 9.175 10.2375 9.175 10.5281 9.46875L11.9969 10.9375L13.4656 9.46875C13.7594 9.175 14.2344 9.175 14.525 9.46875C14.8156 9.7625 14.8187 10.2375 14.525 10.5281L13.0562 11.9969L14.525 13.4656C14.8187 13.7594 14.8187 14.2344 14.525 14.525C14.2312 14.8156 13.7562 14.8187 13.4656 14.525L11.9969 13.0562L10.5281 14.525C10.2344 14.8187 9.75938 14.8187 9.46875 14.525C9.17812 14.2312 9.175 13.7562 9.46875 13.4656L10.9375 11.9969L9.46875 10.5281C9.175 10.2344 9.175 9.75938 9.46875 9.46875Z" fill="currentColor"></path></svg>
                        Acesso ao suporte
                    </li>
                </ul>
                <a href="#" :class="['subscription-button', {'is-disabled': subscriptionStore.isFree}]" @click="this.$refs.scheduleCancelationModal.show()">Mudar para Gratuito</a>
            </div>

            <div class="plan">
                <h3>Pro</h3>
                <span>R$9,97 / mês</span>
                <ul>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Acesso a plataforma
                    </li>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Portfólio consolidado
                    </li>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Cadastro ilimitado de ativos
                    </li>
                    <li>
                        <svg class="is-active" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20C16.4187 20 20 16.4187 20 12C20 7.58125 16.4187 4 12 4C7.58125 4 4 7.58125 4 12C4 16.4187 7.58125 20 12 20ZM15.5312 10.5312L11.5312 14.5312C11.2375 14.825 10.7625 14.825 10.4719 14.5312L8.47188 12.5312C8.17813 12.2375 8.17813 11.7625 8.47188 11.4719C8.76563 11.1813 9.24062 11.1781 9.53125 11.4719L11 12.9406L14.4688 9.46875C14.7625 9.175 15.2375 9.175 15.5281 9.46875C15.8187 9.7625 15.8219 10.2375 15.5281 10.5281L15.5312 10.5312Z" fill="currentColor"></path></svg>
                        Acesso ao suporte
                    </li>
                </ul>
                <a :href="'https://buy.stripe.com/test_bIY7uJaLm5x9b60144?locale=pt&client_reference_id=' + userStore.user.id" :class="['subscription-button', {'is-disabled': subscriptionStore.isPro}]" target="_blank">Mudar para Pro</a>
            </div>
        </div>

        <Modal ref="scheduleCancelationModal" title="Cancelar assinatura" description="Tem certeza de que deseja cancelar sua assinatura do plano atual?">
            <template #footer>
                <button type="submit" class="modal__content__footer__button is-red-button" @click="scheduleCancelation()">Confirmar cancelamento</button>
                <button type="submit" class="modal__content__footer__button" @click="$refs.scheduleCancelationModal.hide()">Manter plano atual</button>
            </template>
        </Modal>

        <Modal ref="scheduleCancelationSuccessModal" title="Assinatura agendada para cancelamento" :description="`Você continuará tendo acesso ao seu plano atual até o dia <b>${subscriptionStore.cancelAt}</b>. Após essa data, sua conta será migrada automaticamente para o plano gratuito.`"></Modal>

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>

import Modal from '@/components/Modal.vue';
import Notification from '@/components/Notification.vue';

import { useUserStore } from '@/stores/user';
import { useSubscriptionStore } from '@/stores/subscription';

export default {
    components: {
        Modal,
        Notification
    },
    data() {
        return {

        };
    },
    computed: {
        userStore() {
            return useUserStore();
        },
        subscriptionStore() {
            return useSubscriptionStore();
        }
    },
    methods: {
        scheduleCancelation() {
            this.subscriptionStore.scheduleCancelation()
                .then(() => {
                    this.$refs.scheduleCancelationModal.hide();
                    this.$refs.scheduleCancelationSuccessModal.show();
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        resumeSubscription() {
            this.subscriptionStore.resumeSubscription()
                .then(() => {
                    this.$refs.notification.showSuccess('Assinatura mantida com sucesso.');
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        }
    }
};

</script>
