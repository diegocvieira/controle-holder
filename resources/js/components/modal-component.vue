<template id="modal-template">
    <div class="modal-container" v-if="show">
        <div class="modal-backdrop" @click="closeModal"></div>

        <div class="modal" v-if="show">
            <div class="modal-header">
                <h3 v-html="title"></h3>

                <button type="button" class="modal-close" @click="closeModal">
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path>
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <p v-html="message"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="button bg-filled" @click="confirmButton">SIM</button>
                <button type="button" class="button" @click="closeModal">NÃO</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'modal-component',
        template: '#modal-template',
        data () {
            return {
                show: false,
                title: '',
                message: '',
                confirmMethod: null,
                data: null
            }
        },
        methods: {
            confirmButton() {
                this.confirmMethod(this.data);
                this.closeModal();
            },
            closeModal() {
                this.show = false;
            }
        }
    }
</script>
