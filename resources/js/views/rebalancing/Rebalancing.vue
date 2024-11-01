<template>
    <main id="target-assets-page">
        <h1 class="page-title">Rebalanceamento</h1>

        <form method="POST" class="form inline-form" @submit.prevent="calculateInvestment">
            <div class="form__field">
                <input type="text" name="investment_amount" v-model="investmentAmount" @input="formatMoney()" placeholder="Valor do aporte" class="form__field__input" required />
            </div>

            <div class="form__field">
                <button type="submit" class="form__field__submit-button">Calcular investimento</button>
            </div>
        </form>

        <template v-if="assets.length > 0">
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
                        <tr v-for="(asset, assetKey) in assets" :key="assetKey">
                            <td>{{ assetKey + 1 }}</td>
                            <td><span :class="'asset-class ' + asset.assetClass.slug">{{ asset.assetClass.name }}</span></td>
                            <td>{{ asset.ticker }}</td>
                            <td>{{ asset.price ? formatPrice(asset.price) : '-' }}</td>
                            <td>{{ asset.quantity }}</td>
                            <td>{{ asset.investedAmount ? formatPrice(asset.investedAmount) : '-' }}</td>
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

export default {
    components: {
        Modal,
        Notification
    },
    data() {
        return {
            assets: [],
            investmentAmount: 'R$ 0,00'
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
            axios.get('/api/user/assets', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(response => {
                    const assets = response.data.data;
                    const totalRatings = assets.reduce((accumulator, currentValue) => {
                        return accumulator + currentValue.rating;
                    }, 0);

                    assets.map(asset => {
                        this.assets.push({
                            ticker: asset.ticker,
                            quantity: asset.quantity,
                            rating: asset.rating,
                            idealPercentage: ((asset.rating / totalRatings) * 100).toFixed(2),
                            currentPercentage: 0,
                            investedAmount: null,
                            price: asset.price ? asset.price : null,
                            assetClass: {
                                name: asset.asset_class.name,
                                slug: asset.asset_class.slug
                            },
                            investmentQuantity: 0,
                            investmentAmount: 0
                        });
                    });

                    this.getAssetsPrice();
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar seus ativos.');
                });
        },
        getAssetsPrice() {
            this.assets.forEach(asset => {
                if (asset.price) {
                    return;
                }

                const data = {
                    ticker: asset.ticker,
                    asset_class: asset.assetClass.slug
                };

                axios.post('/api/prices', data, {
                        headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                    })
                    .then(response => {
                        asset.price = response.data.data.price;
                    })
                    .catch(() => {
                        this.$refs.notification.showError(`Não foi possível carregar o preço do ativo ${asset.ticker}.`);
                    });
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
            } else if (this.assets.length === 0) {
                this.$refs.notification.showError('Você ainda não tem nenhum ativo cadastrado.');
                return;
            }

            const totalValue = this.formatPrice(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            let totalInvestedValue = 0;
            let remainingAmount = 0;
            let stopCalculating = false;
            const assets = JSON.parse(JSON.stringify(this.assets));

            this.sortAssetsByInvestmentDifference(assets, remainingAmount);

            while (!stopCalculating) {
                let asset = assets[0];

                if (Number(asset.price) + Number(totalInvestedValue) > totalValue) {
                    stopCalculating = true;
                } else {
                    asset.quantity++;
                    totalInvestedValue += Number(asset.price);
                    remainingAmount = totalValue - totalInvestedValue;

                    const totalAmount = assets.reduce((accumulator, currentValue) => {
                        return accumulator + currentValue.quantity * currentValue.price;
                    }, 0);
                    asset.currentPercentage = (asset.quantity * asset.price / totalAmount * 100).toFixed(2);

                    this.sortAssetsByInvestmentDifference(assets, remainingAmount);
                }
            }

            assets.forEach(asset => {
                const assetSelected = this.assets.find(data => data.ticker === asset.ticker);
                assetSelected.investmentQuantity = asset.quantity - assetSelected.quantity;
                assetSelected.investmentAmount = (assetSelected.investmentQuantity * asset.price).toFixed(2);
            });
        },
    },
    async created () {
        this.getAssets();
    },
    updated () {
        // this.$refs.loader.show = false;
    },
    watch: {
        assets: {
            handler(assets) {
                const totalAmount = assets.reduce((accumulator, currentValue) => {
                    return accumulator + currentValue.quantity * currentValue.price;
                }, 0);

                assets.forEach(function(asset) {
                    console.log(asset);
                    asset.currentPercentage = asset.price ? (asset.quantity * asset.price / totalAmount * 100).toFixed(2) : null;
                    asset.investedAmount = asset.price ? (asset.quantity * asset.price).toFixed(2) : null;
                });

                assets.sort((a, b) => {
                    if (a.assetClass.slug !== b.assetClass.slug) {
                        return a.assetClass.slug.localeCompare(b.assetClass.slug);
                    }

                    return b.rating - a.rating;
                });
            },
            deep: true
        }
    }
};
</script>
