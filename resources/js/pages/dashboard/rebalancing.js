export default {
    data () {
        return {
            wallet: [],
            investmentAmount: 'R$ 0,00'
        }
    },
    methods: {
        formatMoney() {
            this.investmentAmount = this.$moneyFormat(this.investmentAmount);
        },
        invest(ticker) {
            const asset = this.wallet.find(asset => asset.ticker === ticker);
            const investmentQuantity = asset.investmentQuantity;

            if (investmentQuantity === 0) {
                return;
            }

            const currentInvestmentAmount = this.$moneyFormat(this.investmentAmount, 'USD').replace(/[^0-9.-]/g, '');
            const newInvestmentAmount = (currentInvestmentAmount - asset.investmentAmount).toFixed(2);
            const newQuantity = investmentQuantity + asset.quantity;

            this.investmentAmount = this.$moneyFormat(newInvestmentAmount);
            asset.quantity = newQuantity;
            asset.investmentQuantity = 0;
            asset.investmentAmount = 0;

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
            } else if (this.wallet.length === 0) {
                this.$refs.alert.showWarning('Você ainda não tem nenhum ativo cadastrado.');
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
                        return accumulator + currentValue.quantity * currentValue.price;
                    }, 0);
                    asset.currentPercentage = (asset.quantity * asset.price / totalAmount * 100).toFixed(2);

                    this.sortAssetsByInvestmentDifference(assets, remainingAmount);
                }
            }

            assets.forEach(asset => {
                const assetSelected = this.wallet.find(data => data.ticker === asset.ticker);
                assetSelected.investmentQuantity = asset.quantity - assetSelected.quantity;
                assetSelected.investmentAmount = (assetSelected.investmentQuantity * asset.price).toFixed(2);
            });
        },
        formatPrice(value) {
            return this.$moneyFormat(value);
        },
        getAssets() {
            axios.get('/api/user/assets').then(response => {
                const assets = response.data.data;
                const totalRatings = assets.reduce((accumulator, currentValue) => {
                    return accumulator + currentValue.rating;
                }, 0);

                this.wallet = assets.map(asset => {
                    return {
                        ticker: asset.ticker,
                        quantity: asset.quantity,
                        idealPercentage: ((asset.rating / totalRatings) * 100).toFixed(2),
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
                this.sortAssetsByAssetClass();
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
            this.$refs.modal.data = { ticker: ticker, showManualInvestment: true, quantity: 0, operation: 'buy' };
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
                const asset = this.wallet.find(asset => asset.ticker === data.ticker);

                if (data.operation === 'buy') {
                    asset.quantity = asset.quantity + data.quantity;
                } else {
                    asset.quantity = asset.quantity - data.quantity;
                }

                console.log(response);
            }).catch(error => {
                this.$refs.alert.showError(error.response.data.message);
            });
        },
        sortAssetsByAssetClass() {
            this.wallet.sort((a, b) => {
                if (a.asset_class.slug !== b.asset_class.slug) {
                    return a.asset_class.slug.localeCompare(b.asset_class.slug);
                }

                return b.rating - a.rating;
            });
        }
    },
    created () {
        this.getAssets();
    },
    updated () {
        this.$refs.loader.show = false;
    },
    watch: {
        wallet: {
            handler(assets) {
                const totalAmount = assets.reduce((accumulator, currentValue) => {
                    return accumulator + currentValue.quantity * currentValue.price;
                }, 0);

                assets.forEach(function(asset) {
                    asset.currentPercentage = asset.price ? (asset.quantity * asset.price / totalAmount * 100).toFixed(2) : null;
                    asset.investedAmount = asset.price ? (asset.quantity * asset.price).toFixed(2) : null;
                });
            },
            deep: true
        }
    }
};
