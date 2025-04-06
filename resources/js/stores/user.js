import { defineStore } from 'pinia';

import { useSubscriptionStore } from '@/stores/subscription';

export const useUserStore = defineStore('userStore', {
    state: () => {
        return {
            user: {
                name: '',
                email: '',
                id: ''
            }
        }
    },
    actions: {
        async getData() {
            if (this.user.email) {
                return Promise.resolve();
            }

            await axios.get('/api/user', {
                    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
                })
                .then(response => {
                    const data = response.data.data;

                    this.user = data;

                    const subscriptionStore = useSubscriptionStore();
                    subscriptionStore.currentPlan = data.current_plan;
                    subscriptionStore.cancelAt = data.current_plan_cancel_at;
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async updateProfile(data) {
            await axios.put('/api/user', data, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
            })
            .catch((error) => {
                return Promise.reject(error);
            });
        },
        async updatePassword(data) {
            await axios.put('/api/user/password', data, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
            })
            .catch((error) => {
                return Promise.reject(error);
            });
        },
        resetData() {
            Object.keys(this.user).forEach(key => {
                this.user[key] = null;
            });
        }
    }
});
