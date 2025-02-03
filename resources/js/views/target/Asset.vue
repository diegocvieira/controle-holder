<template>
    <main id="target-assets-page">
        <h1 class="page-title">Meta de ativos</h1>

        <div class="asset-classes">
            <div class="asset-class" v-for="(assetClass, index) in userAssetClassStore.assetClasses" :key="index">
                <input type="radio" name="asset_class" :value="assetClass.slug" v-model="selectedAssetClass" :id="assetClass.slug" class="is-hidden asset-class__input" />
                <label :for="assetClass.slug" class="asset-class__label">{{ assetClass.name }}</label>
            </div>
        </div>

        <form method="POST" class="form inline-form" @submit.prevent="addAsset">
            <div class="form__field">
                <input type="text" name="ticker" v-model="form.ticker" placeholder="Código" class="form__field__input is-uppercase" required />
            </div>

            <div class="form__field">
                <input type="text" name="rating" v-model="form.rating" placeholder="Nota" class="form__field__input" required />
            </div>

            <div class="form__field">
                <input type="text" name="quantity" v-model="form.quantity" placeholder="Quantidade" class="form__field__input" required />
            </div>

            <div class="form__field">
                <button type="submit" class="form__field__submit-button">Adicionar ativo</button>
            </div>
        </form>

        <template v-if="filteredAssets.length > 0">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Quantidade</th>
                            <th>Nota</th>
                            <th>% Classe</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(asset, assetKey) in filteredAssets" :key="assetKey">
                            <td>{{ assetKey + 1 }}</td>
                            <td>{{ asset.ticker }}</td>
                            <td>{{ asset.quantity }}</td>
                            <td>{{ asset.rating }}</td>
                            <td>{{ asset.idealPercentage }}%</td>
                            <td>
                                <button type="button" title="Editar" @click="showEditAssetModal(asset)" class="button">
                                    <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>
                                </button>

                                <button type="button" title="Excluir" @click="showDeleteAssetModal(asset)" class="button">
                                    <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <div class="empty-content" v-else>
            <h2>Ainda não há ativos</h2>
            <p>Adicione ativos e eles aparecerão aqui.</p>
        </div>

        <Modal ref="editAssetModal" :title="`Editar ${selectedAsset.ticker}`" :showFooter="false">
            <template #body>
                <form method="POST" class="form" @submit.prevent="saveEditAsset">
                    <div class="form__field">
                        <label for="rating" class="form__field__label">Nota</label>
                        <input type="text" name="rating" v-model="selectedAsset.rating" placeholder="Nota" id="rating" class="form__field__input" required />
                    </div>

                    <div class="form__field">
                        <label for="quantity" class="form__field__label">Quantidade</label>
                        <input type="text" name="quantity" v-model="selectedAsset.quantity" placeholder="Quantidade" id="quantity" class="form__field__input" required />
                    </div>

                    <div class="form__field">
                        <button type="submit" class="form__field__submit-button">SALVAR</button>
                    </div>
                </form>
            </template>
        </Modal>

        <Modal ref="deleteAssetModal" :title="`Excluir ${selectedAsset.ticker}`" :description="`Tem certeza que deseja excluir o ativo ${selectedAsset.ticker}?`">
            <template #footer>
                <button type="submit" class="modal__content__footer__button is-red-button" @click="deleteAsset()">Excluir ativo</button>
                <button type="submit" class="modal__content__footer__button" @click="$refs.deleteAssetModal.hide()">Cancelar</button>
            </template>
        </Modal>

        <Notification ref="notification"></Notification>
    </main>
</template>

<script>
import Modal from '@/components/Modal.vue';
import Notification from '@/components/Notification.vue';

import { useUserAssetClassStore } from '@/stores/userAssetClass';
import { useUserAssetStore } from '@/stores/userAsset';

export default {
    components: {
        Modal,
        Notification
    },
    data() {
        return {
            selectedAssetClass: '',
            selectedAsset: {},
            form: {
                ticker: '',
                quantity: '',
                rating: ''
            }
        }
    },
    computed: {
        userAssetClassStore() {
            return useUserAssetClassStore();
        },
        userAssetStore() {
            return useUserAssetStore();
        },
        filteredAssets() {
            return this.userAssetStore.assets.filter(asset => asset.assetClass.slug === this.selectedAssetClass);
        }
    },
    methods: {
        addAsset() {
            const assetClass = this.userAssetClassStore.assetClasses.find(assetClass => assetClass.slug === this.selectedAssetClass);
            const data = {
                ticker: this.form.ticker.toUpperCase(),
                quantity: this.form.quantity,
                rating: this.form.rating,
                asset_class: this.selectedAssetClass
            };

            this.userAssetStore.create(data, assetClass)
                .then(() => {
                    this.form = { ticker: '', quantity: '', rating: '' };

                    this.$refs.notification.showSuccess('Ativo adicionado com sucesso.');
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        showEditAssetModal(asset) {
            this.selectedAsset = { ...asset };
            this.$refs.editAssetModal.show();
        },
        saveEditAsset() {
            const data = {
                'ticker': this.selectedAsset.ticker,
                'quantity': this.selectedAsset.quantity,
                'rating': this.selectedAsset.rating
            };

            this.userAssetStore.update(data)
                .then(() => {
                    this.$refs.notification.showSuccess('Ativo alterado com sucesso.');
                    this.$refs.editAssetModal.hide();
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        showDeleteAssetModal(asset) {
            this.selectedAsset = { ...asset };
            this.$refs.deleteAssetModal.show();
        },
        deleteAsset() {
            this.userAssetStore.delete(this.selectedAsset.ticker)
                .then(() => {
                    this.$refs.notification.showSuccess('Ativo excluído com sucesso.');
                    this.$refs.deleteAssetModal.hide();
                })
                .catch(error => {
                    this.$refs.notification.showError(error.response?.data?.message ?? 'Ocorreu um erro inesperado.');
                });
        },
        getAssetClasses() {
            return this.userAssetClassStore.getAssetClasses()
                .then(() => {
                    this.selectedAssetClass = this.userAssetClassStore.assetClasses[0]?.slug;
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar suas classes de ativos.');
                });
        },
        getAssets() {
            return this.userAssetStore.getAssets()
                .then(() => {
                    this.setAssetsIdealPercentage();
                    this.sortAssetsByRating();
                })
                .catch(() => {
                    this.$refs.notification.showError('Ocorreu um erro ao carregar seus ativos.');
                });
        },
        setAssetsIdealPercentage() {
            this.userAssetStore.assets.forEach(asset => {
                const totalRatings = this.userAssetStore.assets.reduce((accumulator, currentValue) => {
                    if (currentValue.assetClass.slug === asset.assetClass.slug) {
                        return accumulator + parseFloat(currentValue.rating);
                    } else {
                        return accumulator;
                    }
                }, 0);

                asset.idealPercentage = ((parseFloat(asset.rating) / totalRatings) * 100).toFixed(2);
            });
        },
        sortAssetsByRating() {
            this.userAssetStore.assets.sort((a, b) => b.rating - a.rating);
        }
    },
    async created () {
        await this.getAssetClasses();
        this.getAssets();
    },
    updated () {
        // this.$refs.loader.show = false;
    },
    watch: {
        'userAssetStore.assets': {
            handler() {
                this.setAssetsIdealPercentage();
                this.sortAssetsByRating();
            },
            deep: true
        }
    }
};
</script>
