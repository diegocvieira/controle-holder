<template id="alert-message-template">
    <transition name="alert-message-slide">
        <div class="alert-message" :class="type" v-if="show">
            <svg viewBox="0 0 24 24" v-if="type == 'success'">
                <path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"></path>
            </svg>
            <svg viewBox="0 0 24 24" v-else-if="type == 'error'">
                <path fill="currentColor" d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"></path>
            </svg>
            <svg viewBox="0 0 24 24" v-else>
                <path fill="currentColor" d="M13 14H11V9H13M13 18H11V16H13M1 21H23L12 2L1 21Z"></path>
            </svg>

            <p v-html="message"></p>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'alert-message-component',
        template: '#alert-message-template',
        data () {
            return {
                show: false,
                message: '',
                type: '',
                timeToDisappear: 3000
            }
        },
        watch: {
            show: function (value) {
                if (value === true && this.timeToDisappear > 0) {
                    setTimeout(() => {
                        this.closeModal();
                    }, this.timeToDisappear);
                }
            }
        },
        methods: {
            closeModal() {
                this.show = false;
            }
        }
    }
</script>
