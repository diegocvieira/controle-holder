import HeaderComponent from '../../components/header-component.vue';
import AlertComponent from '../../components/alert-component.vue';
import ModalComponent from '../../components/modal-component.vue';
import LoaderComponent from '../../components/loader-component.vue';

export default new Vue({
    el: '#target-assets-page',
    data () {
        return {
            filterOptions: [
                {
                    name: 'Todos',
                    slug: 'all'
                }
            ],
            classFilter: 'all',
            wallet: [],
            form: {
                asset_class: '',
                ticker: '',
                quantity: '',
                rating: ''
            }
        }
    },
    methods: {
        addAsset() {
            const { ticker, quantity, rating } = this.form;

            if (!ticker || !quantity || !rating) {
                this.$refs.alert.showWarning('Preencha todos os campos.');
                return false;
            }

            const data = { ticker, quantity, rating };
            this.form = { ticker: '', quantity: '', rating: '' };

            axios.post('/api/assets', data).then(response => {
                const responseData = response.data.data;

                this.wallet.push({
                    ticker: responseData.ticker,
                    quantity: responseData.quantity,
                    idealPercentage: 0,
                    rating: responseData.rating,
                    asset_class: {
                        name: responseData.asset_class_name,
                        slug: responseData.asset_class_slug
                    },
                    showInputs: false
                });

                this.sortAssetsByAssetClass();
                this.$refs.alert.showSuccess(response.data.message);
            }).catch(error => {
                this.$refs.alert.showWarning(error.response.data.message);
            });
        },
        editAsset(ticker) {
            const assetIndex = this.wallet.findIndex((asset => asset.ticker == ticker));
            this.wallet[assetIndex].showInputs = true
        },
        saveEditAsset(ticker) {
            const assetIndex = this.wallet.findIndex((asset => asset.ticker == ticker));
            const asset = this.wallet[assetIndex];

            asset.showInputs = false;

            const data = {
                'ticker': asset.ticker,
                'quantity': asset.quantity,
                'rating': asset.rating
            }

            axios.put('/api/assets', data).then(response => {
                this.$refs.alert.showSuccess('Ativo alterado com sucesso!');
            }).catch(error => console.log(error));
        },
        deleteAsset(ticker) {
            const assetIndex = this.wallet.findIndex((asset => asset.ticker == ticker));
            const asset = this.wallet[assetIndex];

            this.$refs.modal.title = 'Excluir ativo';
            this.$refs.modal.message = 'Tem certeza que deseja excluir o ativo ' + asset.ticker + '?';
            this.$refs.modal.confirmMethod = this.deleteConfirm;
            this.$refs.modal.data = ticker;
            this.$refs.modal.show = true;
        },
        deleteConfirm(ticker) {
            console.log(ticker);
        },
        filterTickets(value) {
            this.classFilter = value;

            if (value != 'all') {
                this.form.asset_class = value;
            }
        },
        getAssets() {
            axios.get('/api/assets').then(response => {
                response.data.data.map(asset => {
                    if (!this.filterOptions.some(item => item.slug === asset.asset_class.slug)) {
                        this.filterOptions.push({
                            name: asset.asset_class.name,
                            slug: asset.asset_class.slug
                        });
                    }

                    this.wallet.push({
                        ticker: asset.ticker,
                        quantity: asset.quantity,
                        idealPercentage: 0,
                        rating: asset.rating,
                        asset_class: {
                            name: asset.asset_class.name,
                            slug: asset.asset_class.slug
                        },
                        showInputs: false
                    });
                });

                this.sortAssetsByAssetClass();

                this.form.asset_class = this.filterOptions[1].slug;
            }).catch(error => console.log(error));
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
    computed: {
        filteredWallet() {
            if (this.classFilter == 'all') {
                return this.wallet;
            } else {
                return this.wallet.filter(item => item.asset_class.slug == this.classFilter);
            }
        }
    },
    watch: {
        wallet: {
            handler(assets) {
                assets.map((asset) => {
                    const totalRatings = assets.reduce((accumulator, currentValue) => {
                        if (currentValue.asset_class.slug === asset.asset_class.slug) {
                            return accumulator + parseInt(currentValue.rating);
                        } else {
                            return accumulator;
                        }
                    }, 0);

                    asset.idealPercentage = ((parseInt(asset.rating) / totalRatings) * 100).toFixed(2);
                });
            },
            deep: true
        }
    },
    components: {
        HeaderComponent,
        AlertComponent,
        ModalComponent,
        LoaderComponent
    }
});
