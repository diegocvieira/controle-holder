<template>
    <div class="modal" v-if="isOpen" @click="hide">
        <div class="modal__content" @click.stop>
            <div class="modal__content__header">
                <h2 class="modal__content__header__title">{{ title }}</h2>

                <button type="button" class="modal__content__header__close-button" @click="hide">
                    <svg fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.25 6.75L6.75 17.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M6.75 6.75L17.25 17.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </button>
            </div>

            <div class="modal__content__body">
                <slot name="body">
                    <p class="modal__content__body__description" v-html="description"></p>
                </slot>
            </div>

            <div class="modal__content__footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        description: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        show() {
            this.isOpen = true;
        },
        hide() {
            this.isOpen = false;
        }
    }
};
</script>
