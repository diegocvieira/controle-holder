import { defineStore } from 'pinia';

export const useSubscriptionStore = defineStore('subscriptionStore', {
    state: () => {
        return {
            currentPlan: '',
            cancelAt: ''
        }
    },
    getters: {
        isFree: (state) => state.currentPlan === 'FREE',
        isPro: (state) => state.currentPlan === 'PROMENSAL',
        isCancelAt: (state) => state.cancelAt !== ''
    },
    actions: {
        async scheduleCancelation() {
            await axios.post('/api/subscriptions/schedule-cancelation', {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(response => {
                    this.cancelAt = response.data.data.cancel_at;
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async resumeSubscription() {
            await axios.post('/api/subscriptions/resume', {}, {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(response => {
                    this.cancelAt = '';
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        resetData() {
            this.currentPlan = '';
            this.cancelAt = '';
        }
    }
});
