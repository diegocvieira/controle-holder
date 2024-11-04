<template>
    <main id="target-assets-page" class="max-width-70">
        <h1 class="page-title">Rebalanceamento</h1>

        <form method="POST" class="form inline-form" @submit.prevent="calculateInvestment">
            <div class="form__field">
                <input type="text" name="investment_amount" v-model="investmentAmount" @input="formatMoney()" placeholder="Valor do aporte" class="form__field__input" required />
            </div>

            <div class="form__field">
                <button type="submit" class="form__field__submit-button">Calcular investimento</button>
            </div>
        </form>

        <template v-if="userAssetStore.assets.length > 0">
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
                            <th>% Diferença</th>
                            <th>Quantidade aporte</th>
                            <th>Valor aporte</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(asset, assetKey) in userAssetStore.assets" :key="assetKey">
                            <td>{{ assetKey + 1 }}</td>
                            <td><span :class="'asset-class ' + asset.assetClass.slug">{{ asset.assetClass.name }}</span></td>
                            <td>{{ asset.ticker }}</td>
                            <td>{{ asset.price ? formatPrice(asset.price) : '-' }}</td>
                            <td>{{ asset.quantity }}</td>
                            <td>{{ asset.price ? formatPrice((asset.quantity * asset.price).toFixed(2)) : '-' }}</td>
                            <td>{{ asset.idealPercentage }}%</td>
                            <td>{{ asset.currentPercentage ? asset.currentPercentage + '%' : '-' }}</td>
                            <td>{{ asset.currentPercentage ? (asset.idealPercentage - asset.currentPercentage).toFixed(2) + '%' : '-' }}</td>
                            <td :class="{'font-bold': asset.investmentQuantity}">{{ asset.investmentQuantity }}</td>
                            <td :class="{'font-bold': asset.investmentAmount > 0}">{{ formatPrice(asset.investmentAmount) }}</td>
                            <td>
                                <!-- <button type="button" title="OP" @click="operations(asset.ticker)">OP</button>
                                <button type="button" title="Lançar" @click="invest(asset.ticker)">LANÇAR</button> -->
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

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>
import Modal from '@/components/Modal.vue';
import Notification from '@/components/Notification.vue';

import { useUserAssetStore } from '@/stores/userAsset';

export default {
    components: {
        Modal,
        Notification
    },
    data() {
        return {
            investmentAmount: 'R$ 0,00'
        }
    },
    computed: {
        userAssetStore() {
            return useUserAssetStore();
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
        calculateInvestment() {
            if (!this.investmentAmount) {
                return;
            } else if (this.userAssetStore.assets.length === 0) {
                this.$refs.notification.showError('Você ainda não tem nenhum ativo cadastrado.');
                return;
            }

            const totalValue = this.formatPrice(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            let totalInvestedValue = 0;
            let remainingAmount = 0;
            let stopCalculating = false;
            const assets = JSON.parse(JSON.stringify(this.userAssetStore.assets));

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
                const assetSelected = this.userAssetStore.assets.find(data => data.ticker === asset.ticker);
                assetSelected.investmentQuantity = asset.quantity - assetSelected.quantity;
                assetSelected.investmentAmount = (assetSelected.investmentQuantity * asset.price).toFixed(2);
            });
        },
        setAssetsPercentages() {
            const totalRatings = this.userAssetStore.assets.reduce((accumulator, currentValue) => accumulator + currentValue.rating, 0);
            const totalAmount = this.userAssetStore.assets.reduce((accumulator, currentValue) => accumulator + currentValue.quantity * currentValue.price, 0);

            this.userAssetStore.assets.forEach(function(asset) {
                asset.currentPercentage = asset.price ? (asset.quantity * asset.price / totalAmount * 100).toFixed(2) : null;
                asset.idealPercentage = ((asset.rating / totalRatings) * 100).toFixed(2);
            });
        },
        sortAssetsByClass() {
            this.userAssetStore.assets.sort((a, b) => {
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
        'userAssetStore.assets': {
            handler() {
                this.setAssetsPercentages();
                this.sortAssetsByClass();
            },
            deep: true
        }
    }
};
</script>
