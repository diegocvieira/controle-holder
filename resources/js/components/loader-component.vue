<template id="alert-message-template">
    <div id="preloader" v-if="show">
        <div id="loader"></div>
    </div>
</template>

<script>
    export default {
        name: 'loader-component',
        template: '#loader-template',
        data () {
            return {
                show: true
            }
        }
    }
</script>
