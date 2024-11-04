import { defineStore } from 'pinia';

export const useUserAssetClassStore = defineStore('userAssetClassStore', {
    state: () => {
        return {
            assetClasses: []
        }
    },
    actions: {
        async getAssetClasses() {
            if (this.assetClasses.length > 0) {
                return;
            }

            await axios.get('/api/user/asset-classes', {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
            })
            .then(response => {
                this.assetClasses = response.data.data.map(assetClass => {
                    return {
                        name: assetClass.asset_class.name,
                        slug: assetClass.asset_class.slug,
                        percentage: assetClass.percentage
                    };
                });
            })
            .catch(() => {
                return Promise.reject(error);
            });
        },
        async save(data) {
            await axios.post('/api/user/asset-classes', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        }
    }
});
