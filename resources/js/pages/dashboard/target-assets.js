import HeaderComponent from '../../components/header-component.vue';
import AlertMessageComponent from '../../components/alert-message-component.vue';
import ModalComponent from '../../components/modal-component.vue';

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
        addAsset(event) {
            if (!this.form.asset_class || !this.form.ticker || !this.form.quantity || !this.form.rating) {
                this.$refs.alertMessage.type = 'warning';
                this.$refs.alertMessage.message = 'Preencha todos os campos.';
                this.$refs.alertMessage.show = true;

                return false;
            }

            const assetClass = this.filterOptions.find(item => item.slug === this.form.asset_class);

            this.sortAssetsByAssetClass();

            let data = {
                ticker: this.form.ticker,
                quantity: this.form.quantity,
                asset_class_slug: assetClass.slug,
                rating: this.form_rating
            };

            event.target.reset();

            axios.post('/api/assets', data).then(response => {
                console.log(response.data);

                this.wallet.push({
                    ticker: this.form.ticker,
                    quantity: this.form.quantity,
                    idealPercentage: 0,
                    rating: this.form.rating,
                    asset_class: {
                        name: assetClass.name,
                        slug: assetClass.slug
                    },
                    showInputs: false
                });

                this.$refs.alertMessage.type = 'success';
                this.$refs.alertMessage.message = 'Ativo adicionado com sucesso!';
                this.$refs.alertMessage.show = true;
            }).catch(error => {
                if (error.response?.status === 404) {
                    this.$refs.alertMessage.type = 'warning';
                    this.$refs.alertMessage.message = 'Ativo não encontrado. Por favor, entre em contato <a href="#">por aqui</a> e peça a inclusão dele no sistema.';
                    this.$refs.alertMessage.show = true;
                }
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
                this.$refs.alertMessage.type = 'success';
                this.$refs.alertMessage.message = 'Ativo alterado com sucesso!';
                this.$refs.alertMessage.show = true;
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
        AlertMessageComponent,
        ModalComponent
    }
});
