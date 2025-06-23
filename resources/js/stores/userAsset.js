import { defineStore } from 'pinia';

import { useWalletStore } from '@/stores/wallet';

export const useUserAssetStore = defineStore('userAssetStore', {
    state: () => {
        return {
            assets: []
        }
    },
    getters: {
        filteredAssets: (state) => {
            const walletStore = useWalletStore();

            return state.assets.filter(asset => {
                return asset.assetClass.wallet_slug === walletStore.selectedWallet.slug;
            });
        }
    },
    actions: {
        async getAssets() {
            if (this.filteredAssets.length > 0) {
                return Promise.resolve();
            }

            await axios.get('/api/user/assets', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(response => {
                    this.assets = response.data.data.map((asset) => {
                        return {
                            ticker: asset.ticker,
                            quantity: asset.quantity,
                            rating: asset.rating,
                            idealPercentage: 0,
                            currentPercentage: 0,
                            investedAmount: null,
                            price: asset.price,
                            assetClass: {
                                name: asset.asset_class.name,
                                slug: asset.asset_class.slug,
                                wallet_slug: asset.asset_class.wallet
                            },
                            investmentQuantity: 0,
                            investmentAmount: 0,
                            isInvesting: true
                        };
                    });
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async getPrices() {
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
        async create(data, selectedAssetClass) {
            const walletStore = useWalletStore();
            data.wallet_slug = walletStore.selectedWallet.slug;

            await axios.post('/api/user/assets', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(() => {
                    this.assets.push({
                        ticker: data.ticker,
                        quantity: data.quantity,
                        rating: data.rating,
                        assetClass: selectedAssetClass,
                        price: null,
                        idealPercentage: 0,
                        currentPercentage: 0,
                        investedAmount: null,
                        investmentQuantity: 0,
                        investmentAmount: 0,
                        isInvesting: true
                    });
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async update(data) {
            const walletStore = useWalletStore();
            data.wallet_slug = walletStore.selectedWallet.slug;

            await axios.put('/api/user/assets', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(() => {
                    const asset = this.assets.find(asset => asset.ticker === data.ticker);
                    Object.assign(asset, data);
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async delete(ticker) {
            const walletStore = useWalletStore();
            const data = {
                wallet_slug: walletStore.selectedWallet.slug
            };

            await axios.delete(`/api/user/assets/${ticker}`, {
                data: data,
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(() => {
                    this.assets = this.assets.filter(asset => asset.ticker !== ticker);
                })
                .catch(error => {
                    return Promise.reject(error);
                });
        }
    }
});
