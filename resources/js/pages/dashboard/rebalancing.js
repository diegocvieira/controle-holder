import HeaderComponent from '../../components/header-component.vue';
import AlertMessageComponent from '../../components/alert-message-component.vue';
import ModalComponent from '../../components/modal-component.vue';
import LoaderComponent from '../../components/loader-component.vue';
import MoneyFormatPlugin from '../../plugins/money-format-plugin';

Vue.use(MoneyFormatPlugin);

export default new Vue({
    el: '#rebalancing-page',
    data () {
        return {
            wallet: [],
            investmentAmount: null
        }
    },
    methods: {
        formatMoney() {
            this.investmentAmount = this.$moneyFormat(this.investmentAmount);
        },
        invest(ticker) {
            const assetIndex = this.wallet.findIndex((data => data.ticker == ticker));
            const investmentQuantity = this.wallet[assetIndex].investmentQuantity;

            if (investmentQuantity === 0) {
                return;
            }

            const currentInvestmentAmount = this.$moneyFormat(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            const newInvestmentAmount = (currentInvestmentAmount - this.wallet[assetIndex].investmentAmount).toFixed(2);
            const newQuantity = investmentQuantity + this.wallet[assetIndex].quantity;

            this.investmentAmount = newInvestmentAmount;
            this.wallet[assetIndex].quantity = newQuantity;
            this.wallet[assetIndex].investmentQuantity = 0;
            this.wallet[assetIndex].investmentAmount = 0;

            const data = {
                ticker: ticker,
                quantity: investmentQuantity
            };

            axios.put('/api/rebalancing/buy', data).then(response => {
                console.log(response);
            }).catch(error => console.log(error));
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
            }

            const totalValue = this.$moneyFormat(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            let totalInvestedValue = 0;
            let remainingAmount = 0;
            let stopCalculating = false;
            let assets = JSON.parse(JSON.stringify(this.wallet));

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
                        return accumulator + parseInt(currentValue.quantity) * currentValue.price;
                    }, 0);
                    asset.currentPercentage = (parseInt(asset.quantity) * asset.price / totalAmount * 100).toFixed(2);

                    this.sortAssetsByInvestmentDifference(assets, remainingAmount);
                }
            }

            let wallet = this.wallet;
            assets.forEach(function(asset) {
                const assetIndex = wallet.findIndex((data => data.ticker == asset.ticker));
                wallet[assetIndex].investmentQuantity = asset.quantity - wallet[assetIndex].quantity;
                wallet[assetIndex].investmentAmount = (wallet[assetIndex].investmentQuantity * asset.price).toFixed(2);
            });
        },
        formatPrice(value) {
            return this.$moneyFormat(value);
        },
        getTickets() {
            axios.get('/api/assets').then(response => {
                const assets = response.data.data;
                const totalRatings = assets.reduce((accumulator, currentValue) => {
                    return accumulator + parseInt(currentValue.rating);
                }, 0);

                this.wallet = assets.map(asset => {
                    return {
                        ticker: asset.ticker,
                        quantity: asset.quantity,
                        idealPercentage: ((parseInt(asset.rating) / totalRatings) * 100).toFixed(2),
                        currentPercentage: 0,
                        rating: asset.rating,
                        price: asset.price ? asset.price : null,
                        investedAmount: null,
                        asset_class: {
                            name: asset.asset_class.name,
                            slug: asset.asset_class.slug
                        },
                        showInputs: false,
                        investmentQuantity: 0,
                        investmentAmount: 0
                    };
                });

                this.getAssetsPrice();
            }).catch(error => console.log(error));
        },
        getAssetsPrice() {
            this.wallet.forEach(function (asset) {
                if (asset.price) {
                    return;
                }

                const data = {
                    ticker: asset.ticker,
                    asset_class: asset.asset_class.slug
                };

                axios.post('/api/prices', data).then(response => {
                    asset.price = response.data.price;
                }).catch(error => console.log(error));
            });
        },
        operations(ticker) {
            this.$refs.modal.title = 'Comprar ' + ticker;
            this.$refs.modal.data.ticker = ticker;
            this.$refs.modal.data.showManualInvestment = true;
            this.$refs.modal.data.quantity = 0;
            this.$refs.modal.data.operation = 'buy';
            this.$refs.modal.confirmMethod = this.handleOperations;
            this.$refs.modal.show = true;
        },
        handleOperations(data) {
            console.log(data);

            const dataRequest = {
                ticker: data.ticker,
                quantity: data.quantity
            };

            axios.put('/api/rebalancing/' + data.operation, dataRequest).then(response => {
                const assetIndex = this.wallet.findIndex((asset => asset.ticker == data.ticker));
                const asset = this.wallet[assetIndex];
                const newQuantity = data.operation == 'buy' ? asset.quantity + parseInt(data.quantity) : asset.quantity - parseInt(data.quantity);

                asset.quantity = newQuantity;

                console.log(response);
            }).catch(error => console.log(error));
        }
    },
    created () {
        this.getTickets();
    },
    updated () {
        this.$refs.loader.show = false;
    },
    watch: {
        wallet: {
            handler(assets) {
                const totalAmount = assets.reduce((accumulator, currentValue) => {
                    return accumulator + parseInt(currentValue.quantity) * currentValue.price;
                }, 0);

                assets.forEach(function(asset) {
                    asset.currentPercentage = asset.price ? (parseInt(asset.quantity) * asset.price / totalAmount * 100).toFixed(2) : null;
                    asset.investedAmount = asset.price ? (asset.quantity * asset.price).toFixed(2) : null;
                });
            },
            deep: true
        }
    },
    components: {
        HeaderComponent,
        AlertMessageComponent,
        ModalComponent,
        LoaderComponent
    }
});
