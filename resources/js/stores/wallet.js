import { defineStore } from 'pinia';

export const useWalletStore = defineStore('walletStore', {
    state: () => {
        return {
            wallets: [],
            selectedWallet: {}
        }
    },
    actions: {
        async getWallets() {
            await axios.get('/api/user/wallets', {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
                })
                .then((response) => {
                    this.wallets = response.data.data;
                    this.selectedWallet = JSON.parse(localStorage.getItem('longview-wallet')) || this.wallets[0];
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        async createWallet(name) {
            const data = {
                name: name
            };

            await axios.post('/api/user/wallets', data, {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') }
                })
                .then((response) => {
                    this.wallets.push(response.data.data);
                })
                .catch((error) => {
                    return Promise.reject(error);
                });
        },
        setWallet(wallet) {
            this.selectedWallet = wallet;
            localStorage.setItem('longview-wallet', JSON.stringify(wallet));
        }
    }
});
