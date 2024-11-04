import { defineStore } from 'pinia';

export const useAssetClassStore = defineStore('assetClassStore', {
    state: () => {
        return {
            assetClasses: []
        }
    },
    actions: {
        async getAssetClasses() {
            if (this.assetClasses.length > 0) {
                return Promise.resolve();
            }

            await axios.get('/api/asset-classes', {
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
            })
            .then(response => {
                this.assetClasses = response.data.data.map(assetClass => {
                    return {
                        name: assetClass.name,
                        slug: assetClass.slug,
                        percentage: 0
                    };
                });
            })
            .catch(() => {
                return Promise.reject(error);
            });
        }
    }
});
