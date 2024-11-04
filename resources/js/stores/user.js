import { defineStore } from 'pinia';

export const useUserStore = defineStore('userStore', {
    state: () => {
        return {
            user: {
                name: '',
                email: ''
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
                    this.user = response.data.data;
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
            this.user.name = null;
            this.user.email = null;
        }
    }
});
