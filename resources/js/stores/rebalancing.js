import { defineStore } from 'pinia';

export const useRebalancingStore = defineStore('rebalancingStore', {
    state: () => {
        return {

        }
    },
    actions: {
        async buyAsset(data) {
            await axios.post('/api/user/rebalancing/buy', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async sellAsset(data) {
            await axios.post('/api/user/rebalancing/sell', data, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        }
    }
});
