export default {
    data() {
        return {
            wallet: [],
            filter: 'asset-classes',
            filterOptions: [{
                name: 'Classes',
                slug: 'asset-classes'
            }],
            chartCurrent: {
                data: [],
                title: 'Atual',
                tooltipType: ''
            },
            chartIdeal: {
                data: [],
                title: 'Meta',
                tooltipType: 'percentage'
            }
        };
    },
    methods: {
        applyFilter(value) {
            this.filter = value;
            this.chartIdeal.tooltipType = value === 'asset-classes' ? 'percentage' : 'rating';
            this.loadGraphs();
        },
        getAssetClasses() {
            return axios.get('/api/user/asset-classes').then(response => {
                response.data.data.forEach(assetClass => {
                    if (assetClass.percentage === 0) {
                        return;
                    }

                    const price = this.wallet.filter(asset => asset.assetClassSlug === assetClass.slug).reduce((acc, asset) => acc + parseFloat(asset.totalAmount), 0);

                    this.wallet.push({
                        ticker: assetClass.name,
                        rating: assetClass.percentage,
                        totalAmount: price.toFixed(2),
                        assetClassSlug: 'asset-classes'
                    });
                });
            }).catch(error => console.log(error));
        },
        getAssets() {
            return axios.get('/api/user/assets').then(async response => {
                for (const asset of response.data.data) {
                    if (!this.filterOptions.some(item => item.slug === asset.asset_class.slug)) {
                        this.filterOptions.push({
                            name: asset.asset_class.name,
                            slug: asset.asset_class.slug
                        });
                    }

                    if (!asset.price) {
                        const dataPayload = {
                            ticker: asset.ticker,
                            asset_class: asset.asset_class.slug
                        };

                        await axios.post('/api/prices', dataPayload).then(response => {
                            asset.price = response.data.price;
                        }).catch(error => console.log(error));
                    }

                    this.wallet.push({
                        ticker: asset.ticker,
                        rating: asset.rating,
                        totalAmount: (parseInt(asset.quantity) * asset.price).toFixed(2),
                        assetClassSlug: asset.asset_class.slug
                    });
                };
            }).catch(error => console.log(error));
        },
        loadGraphs() {
            this.chartCurrent.data = this.filteredWallet.map(asset => ({
                name: asset.ticker,
                value: asset.totalAmount
            }));

            this.chartIdeal.data = this.filteredWallet.map(asset => ({
                name: asset.ticker,
                value: asset.rating
            }));
        }
    },
    async created() {
        await this.getAssets();
        await this.getAssetClasses();
        this.loadGraphs();
    },
    computed: {
        filteredWallet() {
            return this.wallet.filter(item => item.assetClassSlug === this.filter);
        }
    }
};
