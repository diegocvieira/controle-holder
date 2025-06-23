<template>
    <div class="wallets">
        <button type="button" class="wallets-button" @click="toggleWallets">
            <div class="wallets-button-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" class="wallets-button-icon-background"><g clip-path="url(#avatar-team-fallback-clip)"><rect width="20" height="20" fill="#000" rx="4.5"></rect><rect width="20" height="20" fill="url(#avatar-team-fallback-gradient)" fill-opacity="0.2" rx="4.5"></rect><g filter="url(#avatar-team-fallback-blur-1)" opacity="0.3"><circle cx="16" cy="17" r="6" fill="#9176FE" fill-opacity="0.671"></circle></g><g filter="url(#avatar-team-fallback-blur-2)" opacity="0.1"><circle cx="16" cy="16" r="6" fill="#9176FE" fill-opacity="0.671"></circle></g><g filter="url(#avatar-team-fallback-blur-3)" opacity="0.4"><circle cx="17" cy="19" r="6" fill="#9176FE" fill-opacity="0.671"></circle></g><rect width="20" height="20" fill="#9176FE" fill-opacity="0.15" rx="4.5"></rect><g style="mix-blend-mode: hard-light;"><rect width="20" height="20" fill="#6A62FF" fill-opacity="0.1" rx="4.5"></rect></g></g><rect width="19" height="19" x="0.5" y="0.5" stroke="#fff" stroke-opacity="0.15" rx="4"></rect><defs><filter id="avatar-team-fallback-blur-1" width="32" height="32" x="0" y="1" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur result="effect1_foregroundBlur_5_17" stdDeviation="5"></feGaussianBlur></filter><filter id="avatar-team-fallback-blur-2" width="22" height="22" x="5" y="5" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur result="effect1_foregroundBlur_5_17" stdDeviation="2.5"></feGaussianBlur></filter><filter id="avatar-team-fallback-blur-3" width="22" height="22" x="6" y="8" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur result="effect1_foregroundBlur_5_17" stdDeviation="2.5"></feGaussianBlur></filter><linearGradient id="avatar-team-fallback-gradient" x1="10" x2="10" y1="0" y2="20" gradientUnits="userSpaceOnUse"><stop stop-color="#fff"></stop><stop offset="1" stop-color="#fff" stop-opacity="0"></stop></linearGradient><clipPath id="avatar-team-fallback-clip"><rect width="20" height="20" fill="#fff" rx="4.5"></rect></clipPath></defs></svg>
                <span class="wallets-button-icon-letter">{{ walletStore.selectedWallet.name ? walletStore.selectedWallet.name[0] : '' }}</span>
            </div>
            <span class="wallets-button-text">{{ walletStore.selectedWallet.name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 15 5 5 5-5"></path><path d="m7 9 5-5 5 5"></path></svg>
        </button>

        <div class="wallets-content" v-if="isOpenWallets">
            <p class="wallets-content-title">Carteiras</p>

            <div class="wallets-content-list">
                <div class="wallets-content-list-item" v-for="(wallet, index) in walletStore.wallets" :key="index" @click="walletStore.setWallet(wallet)">
                    <p class="wallets-content-list-item-name">{{ wallet.name }}</p>
                    <svg v-if="wallet.slug === walletStore.selectedWallet.slug" class="wallets-content-list-item-checked" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M16.25 8.75L10.406 15.25L7.75 12.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
            </div>

            <div class="wallets-content-create-wallet-container">
                <button type="button" class="wallets-content-create-wallet-container-button" @click="$refs.createWalletModal.show()">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-auto"><path d="M8 2.75C8 2.47386 7.77614 2.25 7.5 2.25C7.22386 2.25 7 2.47386 7 2.75V7H2.75C2.47386 7 2.25 7.22386 2.25 7.5C2.25 7.77614 2.47386 8 2.75 8H7V12.25C7 12.5261 7.22386 12.75 7.5 12.75C7.77614 12.75 8 12.5261 8 12.25V8H12.25C12.5261 8 12.75 7.77614 12.75 7.5C12.75 7.22386 12.5261 7 12.25 7H8V2.75Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    Criar Carteira
                </button>
            </div>
        </div>
    </div>

    <Modal ref="createWalletModal" title="Criar nova carteira">
        <template #body>
            <form method="POST" class="form">
                <div class="form__field">
                    <label for="newWalletName" class="form__field__label">Nome da carteira</label>
                    <input type="text" name="newWalletName" v-model="newWalletName" placeholder="Carteira global" id="newWalletName" class="form__field__input" required />
                </div>
            </form>
        </template>
        <template #footer>
            <button type="submit" class="modal__content__footer__button is-green-button" @click="createWallet()">Criar carteira</button>
            <button type="submit" class="modal__content__footer__button" @click="$refs.createWalletModal.hide()">Cancelar</button>
        </template>
    </Modal>

    <Notification ref="notification"></Notification>
</template>

<script>

import Modal from '@/components/Modal.vue';
import Notification from '@/components/Notification.vue';

import { useWalletStore } from '@/stores/wallet';
import { useSubscriptionStore } from '@/stores/subscription';

export default {
    components: {
        Modal,
        Notification
    },
    computed: {
        walletStore() {
            return useWalletStore();
        },
        subscriptionStore() {
            return useSubscriptionStore();
        }
    },
    data() {
        return {
            isOpenWallets: false,
            newWalletName: ''
        }
    },
    methods: {
        toggleWallets() {
            this.isOpenWallets = !this.isOpenWallets;
        },
        handleClickOutside(event) {
            if (this.isOpenWallets && !event.target.closest('.wallets')) {
                this.isOpenWallets = false;
            }
        },
        createWallet() {
            if (!this.subscriptionStore.isPro) {
                this.$refs.notification.showError('Atualize seu plano para criar quantas carteiras quiser.');
                return;
            }

            this.walletStore.createWallet(this.newWalletName)
                .then(() => {
                    this.newWalletName = '';
                    this.isOpenWallets = false;
                    this.$refs.createWalletModal.hide();
                })
                .catch((error) => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro ao criar a carteira.');
                });
        }
    },
    mounted() {
        this.walletStore.getWallets();
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside);
    }
};

</script>
