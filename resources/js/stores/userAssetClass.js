import { defineStore } from 'pinia';

import { useWalletStore } from '@/stores/wallet';

export const useUserAssetClassStore = defineStore('userAssetClassStore', {
    state: () => {
        return {
            assetClasses: []
        }
    },
    getters: {
        filteredAssetClasses: (state) => {
            const walletStore = useWalletStore();

            return state.assetClasses.filter(assetClass => {
                return assetClass.wallet_slug === walletStore.selectedWallet.slug;
            });
        }
    },
    actions: {
        async getAssetClasses() {
            if (this.filteredAssetClasses.length > 0) {
                return Promise.resolve();
            }

            await axios.get('/api/user/asset-classes', {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
            })
            .then(response => {
                this.assetClasses = response.data.data.map(assetClass => {
                    return {
                        name: assetClass.asset_class.name,
                        slug: assetClass.asset_class.slug,
                        percentage: assetClass.percentage,
                        wallet_slug: assetClass.wallet_slug
                    };
                });
            })
            .catch(() => {
                return Promise.reject(error);
            });
        },
        async save(data) {
            const walletStore = useWalletStore();
            data.wallet_slug = walletStore.selectedWallet.slug;

            await axios.post('/api/user/asset-classes', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(() => {
                    if (data.percentage === 0) {
                        this.assetClasses = this.assetClasses.filter(assetClass => 
                            !(assetClass.slug === data.slug && assetClass.wallet_slug === data.wallet_slug)
                        );
                    } else {
                        const AssetExists = this.assetClasses.find(assetClass => 
                            assetClass.slug === data.slug && 
                            assetClass.wallet_slug === data.wallet_slug
                        );
    
                        if (!AssetExists) {
                            this.assetClasses.push(data);
                        }
                    }
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        }
    }
});
