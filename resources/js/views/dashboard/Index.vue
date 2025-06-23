<template>
    <main id="dashboard-page" class="max-width-70">
        <h1 class="page-title">Visão geral</h1>

        <div class="asset-classes">
            <div class="asset-class" v-for="(assetClass, index) in userAssetClassStore.filteredAssetClasses" :key="index">
                <input type="radio" name="asset_class" :value="assetClass.slug" v-model="selectedAssetClass" :id="assetClass.slug" class="is-hidden asset-class__input" />
                <label :for="assetClass.slug" class="asset-class__label">{{ assetClass.name }}</label>
            </div>
        </div>

        <div v-if="filteredAssets.length > 0">
            <div class="charts">
                <div class="chart">
                    <div class="chart__title">
                        <h2>Atual</h2>
                    </div>

                    <PieChart :data="chartCurrent"></PieChart>
                </div>

                <div class="chart">
                    <div class="chart__title">
                        <h2>Meta</h2>
                    </div>

                    <PieChart :data="chartIdeal"></PieChart>
                </div>
            </div>
        </div>
        <div class="empty-content" v-else>
            <h2>Ainda não há ativos</h2>
            <p>Adicione ativos e eles aparecerão aqui.</p>
        </div>

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>
import Notification from '@/components/Notification.vue';
import PieChart from '@/components/PieChart.vue';

import { useUserAssetClassStore } from '@/stores/userAssetClass';
import { useUserAssetStore } from '@/stores/userAsset';
import { useWalletStore } from '@/stores/wallet';

export default {
    components: {
        Notification,
        PieChart
    },
    data() {
        return {
            selectedAssetClass: '',
            chartCurrent: {
                data: [],
                tooltipType: ''
            },
            chartIdeal: {
                data: [],
                tooltipType: 'percentage'
            }
        }
    },
    computed: {
        userAssetClassStore() {
            return useUserAssetClassStore();
        },
        userAssetStore() {
            return useUserAssetStore();
        },
        walletStore() {
            return useWalletStore();
        },
        filteredAssets() {
            return this.userAssetStore.filteredAssets.filter(asset => asset.assetClass.slug === this.selectedAssetClass);
        }
    },
    methods: {
        getAssetClasses() {
            return this.userAssetClassStore.getAssetClasses()
                .then(() => {
                    this.selectedAssetClass = this.userAssetClassStore.filteredAssetClasses[0]?.slug;
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar suas classes de ativos.');
                });
        },
        getAssets() {
            return this.userAssetStore.getAssets()
                .then(() => {
                    this.userAssetStore.getPrices();
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar seus ativos.');
                });
        },
        loadGraphs() {
            this.$nextTick(() => {
                this.chartCurrent.data = this.filteredAssets.map(asset => ({
                    name: asset.ticker,
                    value: (asset.quantity * asset.price).toFixed(2)
                }));

                this.chartIdeal.data = this.filteredAssets.map(asset => ({
                    name: asset.ticker,
                    value: asset.rating
                }));
            });
        }
    },
    async created () {
        await this.getAssetClasses();
        await this.getAssets();
        this.loadGraphs();
    },
    updated () {
        // this.$refs.loader.show = false;
    },
    watch: {
        selectedAssetClass: {
            handler(assetClass) {
                this.chartIdeal.tooltipType = assetClass === 'asset-classes' ? 'percentage' : 'rating';
                this.loadGraphs();
            }
        },
        'walletStore.selectedWallet': {
            handler() {
                this.selectedAssetClass = this.userAssetClassStore.filteredAssetClasses[0]?.slug;
            }
        }
    }
};
</script>
