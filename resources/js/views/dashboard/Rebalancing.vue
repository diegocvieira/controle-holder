<template>
    <main id="rebalancing-page" class="max-width-70">
        <h1 class="page-title">Rebalanceamento</h1>

        <form method="POST" class="form inline-form" @submit.prevent="calculateInvestment">
            <div class="form__field">
                <input type="text" name="investment_amount" v-model="investmentAmount" @input="formatMoney()" placeholder="Valor do aporte" class="form__field__input" required />
            </div>

            <div class="form__field">
                <button type="submit" class="form__field__submit-button">Calcular investimento</button>
            </div>
        </form>

        <template v-if="userAssetStore.filteredAssets.length > 0">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Classe</th>
                            <th>Código</th>
                            <th>Cotação</th>
                            <th>Quantidade</th>
                            <th>Valor investido</th>
                            <th>% Meta</th>
                            <th>% Atual</th>
                            <th>Aportar?</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(asset, assetKey) in userAssetStore.filteredAssets" :key="assetKey">
                            <td>{{ assetKey + 1 }}</td>
                            <td><span :class="'asset-class ' + asset.assetClass.slug">{{ asset.assetClass.name }}</span></td>
                            <td>{{ asset.ticker }}</td>
                            <td>{{ asset.price ? formatPrice(asset.price) : '-' }}</td>
                            <td>
                                {{ asset.quantity }}
                                <span class="investment" v-if="asset.investmentQuantity">
                                    + {{ asset.investmentQuantity }}
                                </span>
                            </td>
                            <td>
                                {{ asset.price ? formatPrice((asset.quantity * asset.price).toFixed(2)) : '-' }}
                                <span class="investment" v-if="asset.investmentAmount > 0">
                                    + {{ formatPrice(asset.investmentAmount) }}
                                </span>
                            </td>
                            <td>{{ asset.idealPercentage }}%</td>
                            <td>{{ asset.currentPercentage ? asset.currentPercentage + '%' : '-' }}</td>
                            <td>
                                <div class="switch">
                                    <span :class="['switch__slider', {'is-active': asset.isInvesting}]" @click="toggleInvesting(asset)"></span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="action-button action-buy-button" title="Comprar" @click="invest(asset.ticker)">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cart-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor" d="M504.717 320H211.572l6.545 32h268.418c15.401 0 26.816 14.301 23.403 29.319l-5.517 24.276C523.112 414.668 536 433.828 536 456c0 31.202-25.519 56.444-56.824 55.994-29.823-.429-54.35-24.631-55.155-54.447-.44-16.287 6.085-31.049 16.803-41.548H231.176C241.553 426.165 248 440.326 248 456c0 31.813-26.528 57.431-58.67 55.938-28.54-1.325-51.751-24.385-53.251-52.917-1.158-22.034 10.436-41.455 28.051-51.586L93.883 64H24C10.745 64 0 53.255 0 40V24C0 10.745 10.745 0 24 0h102.529c11.401 0 21.228 8.021 23.513 19.19L159.208 64H551.99c15.401 0 26.816 14.301 23.403 29.319l-47.273 208C525.637 312.246 515.923 320 504.717 320zM408 168h-48v-40c0-8.837-7.163-16-16-16h-16c-8.837 0-16 7.163-16 16v40h-48c-8.837 0-16 7.163-16 16v16c0 8.837 7.163 16 16 16h48v40c0 8.837 7.163 16 16 16h16c8.837 0 16-7.163 16-16v-40h48c8.837 0 16-7.163 16-16v-16c0-8.837-7.163-16-16-16z"></path>
                                    </svg>
                                </button>

                                <button type="button" class="action-button action-trade-button" title="Negociar" @click="showOperationsModal(asset)">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exchange-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M0 168v-16c0-13.255 10.745-24 24-24h360V80c0-21.367 25.899-32.042 40.971-16.971l80 80c9.372 9.373 9.372 24.569 0 33.941l-80 80C409.956 271.982 384 261.456 384 240v-48H24c-13.255 0-24-10.745-24-24zm488 152H128v-48c0-21.314-25.862-32.08-40.971-16.971l-80 80c-9.372 9.373-9.372 24.569 0 33.941l80 80C102.057 463.997 128 453.437 128 432v-48h360c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <div class="empty-content" v-else>
            <h2>Ainda não há ativos</h2>
            <p>Adicione ativos e eles aparecerão aqui.</p>
        </div>

        <Modal ref="operationsModal" :title="`Negociar ${selectedAsset.ticker}`">
            <template #body>
                <form method="POST" class="form">
                    <div class="padding-1">
                        <div class="form__field">
                            <label for="current_password" class="form__field__label">Quantidade</label>
                            <input type="text" name="quantity" v-model="investmentQuantity" placeholder="0" class="form__field__input" required />
                        </div>
                    </div>
                </form>
            </template>
            <template #footer>
                <button type="submit" class="modal__content__footer__button is-green-button" @click="buyAsset()">Comprar ativo</button>
                <button type="submit" class="modal__content__footer__button is-red-button" @click="sellAsset()">Vender ativo</button>
            </template>
        </Modal>

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>

import Notification from '@/components/Notification.vue';
import Modal from '@/components/Modal.vue';

import { useUserAssetStore } from '@/stores/userAsset';
import { useRebalancingStore } from '@/stores/rebalancing';
import { useSubscriptionStore } from '@/stores/subscription';
import { useWalletStore } from '@/stores/wallet';

export default {
    components: {
        Notification,
        Modal
    },
    data() {
        return {
            investmentAmount: 'R$ 0,00',
            investmentQuantity: 0,
            selectedAsset: {}
        }
    },
    computed: {
        userAssetStore() {
            return useUserAssetStore();
        },
        rebalancingStore() {
            return useRebalancingStore();
        },
        subscriptionStore() {
            return useSubscriptionStore();
        }
    },
    methods: {
        formatMoney() {
            this.investmentAmount = this.formatPrice(this.investmentAmount);
        },
        formatPrice(number, currency = 'BRL') {
            const numericValue = number.toString().replace(/\D/g, '');
            const locale = currency === 'BRL' ? 'pt-BR' : 'en-US';

            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2
            }).format(numericValue / 100);
        },
        getAssets() {
            this.userAssetStore.getAssets()
                .then(() => {
                    this.setAssetsPercentages();
                    this.sortAssetsByClass();
                    this.userAssetStore.getPrices();
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar seus ativos.');
                });
        },
        sortAssetsByInvestmentDifference(assets, remainingAmount) {
            return assets.sort((a, b) => {
                if (a.price >= remainingAmount && b.price >= remainingAmount) {
                    return 0;
                } else if (a.price >= remainingAmount) {
                    return 1;
                } else if (b.price >= remainingAmount) {
                    return -1;
                } else {
                    return (b.idealPercentage - b.currentPercentage) - (a.idealPercentage - a.currentPercentage);
                }
            });
        },
        toggleInvesting(asset) {
            if (this.subscriptionStore.isFree) {
                this.$refs.notification.showError('Atualize seu plano para ter acesso a essa funcionalidade.');
                return;
            }

            asset.isInvesting = !asset.isInvesting;
        },
        calculateInvestment() {
            if (!this.investmentAmount) {
                return;
            } else if (this.userAssetStore.filteredAssets.length === 0) {
                this.$refs.notification.showError('Você ainda não tem nenhum ativo cadastrado.');
                return;
            }

            const totalValue = this.formatPrice(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            let totalInvestedValue = 0;
            let remainingAmount = 0;
            let stopCalculating = false;
            const assets = JSON.parse(JSON.stringify(this.userAssetStore.filteredAssets)).filter(asset => asset.isInvesting === true);

            this.sortAssetsByInvestmentDifference(assets, remainingAmount);

            while (!stopCalculating) {
                let asset = assets[0];

                if (Number(asset.price) + Number(totalInvestedValue) > totalValue) {
                    stopCalculating = true;
                } else {
                    asset.quantity++;
                    totalInvestedValue += Number(asset.price);
                    remainingAmount = totalValue - totalInvestedValue;

                    const totalAmount = assets.reduce((accumulator, currentValue) => accumulator + currentValue.quantity * currentValue.price, 0);
                    asset.currentPercentage = (asset.quantity * asset.price / totalAmount * 100).toFixed(2);

                    this.sortAssetsByInvestmentDifference(assets, remainingAmount);
                }
            }

            assets.forEach(asset => {
                const assetSelected = this.userAssetStore.filteredAssets.find(data => data.ticker === asset.ticker);
                assetSelected.investmentQuantity = asset.quantity - assetSelected.quantity;
                assetSelected.investmentAmount = (assetSelected.investmentQuantity * asset.price).toFixed(2);
            });
        },
        showOperationsModal(asset) {
            this.selectedAsset = asset;
            this.investmentQuantity = asset.investmentQuantity;
            this.$refs.operationsModal.show();
        },
        buyAsset() {
            const data = {
                ticker: this.selectedAsset.ticker,
                quantity: this.investmentQuantity
            };

            this.rebalancingStore.buyAsset(data)
                .then(() => {
                    this.selectedAsset.quantity += parseFloat(data.quantity);
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        sellAsset() {
            if (this.investmentQuantity > this.selectedAsset.quantity) {
                this.$refs.notification.showError('Quantidade insuficiente para vender.');
                return;
            }

            const data = {
                ticker: this.selectedAsset.ticker,
                quantity: this.investmentQuantity
            };

            this.rebalancingStore.sellAsset(data)
                .then(() => {
                    this.selectedAsset.quantity -= parseFloat(data.quantity);
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        invest(ticker) {
            const asset = this.userAssetStore.filteredAssets.find(asset => asset.ticker === ticker);
            const investmentQuantity = asset.investmentQuantity;

            if (investmentQuantity === 0) {
                return;
            }

            const data = {
                ticker: ticker,
                quantity: investmentQuantity
            };

            this.rebalancingStore.buyAsset(data)
                .then(() => {
                    const currentInvestmentAmount = this.formatPrice(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
                    const newInvestmentAmount = (currentInvestmentAmount - asset.investmentAmount).toFixed(2);
                    const newQuantity = investmentQuantity + asset.quantity;

                    this.investmentAmount = this.formatPrice(newInvestmentAmount);
                    asset.quantity = newQuantity;
                    asset.investmentQuantity = 0;
                    asset.investmentAmount = 0;

                    this.$refs.notification.showSuccess(`Você comprou ${investmentQuantity} ${ticker}`);
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        setAssetsPercentages() {
            const totalRatings = this.userAssetStore.filteredAssets.reduce((accumulator, currentValue) => accumulator + currentValue.rating, 0);
            const totalAmount = this.userAssetStore.filteredAssets.reduce((accumulator, currentValue) => accumulator + currentValue.quantity * currentValue.price, 0);

            this.userAssetStore.filteredAssets.forEach(function(asset) {
                asset.currentPercentage = asset.price ? (asset.quantity * asset.price / totalAmount * 100).toFixed(2) : null;
                asset.idealPercentage = ((asset.rating / totalRatings) * 100).toFixed(2);
            });
        },
        sortAssetsByClass() {
            this.userAssetStore.filteredAssets.sort((a, b) => {
                if (a.assetClass.slug !== b.assetClass.slug) {
                    return a.assetClass.slug.localeCompare(b.assetClass.slug);
                }

                return b.rating - a.rating;
            });
        }
    },
    async created () {
        this.getAssets();
    },
    updated () {
        // this.$refs.loader.show = false;
    },
    watch: {
        'userAssetStore.filteredAssets': {
            handler() {
                this.setAssetsPercentages();
                this.sortAssetsByClass();
            },
            deep: true
        },
        'walletStore.selectedWallet': {
            handler() {
                this.setAssetsPercentages();
                this.sortAssetsByClass();
            }
        }
    }
};

</script>
