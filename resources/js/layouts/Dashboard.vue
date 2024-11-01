<template>
    <Aside></Aside>

    <div id="layout-content">
        <Header></Header>

        <router-view v-slot="{ Component }">
            <transition name="slide-fade" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
    </div>
</template>

<script>
import Aside from '@/components/Aside.vue';
import Header from '@/components/Header.vue';

export default {
    components: {
        Aside,
        Header
    },
    computed: {
        // loaderStore() {
        //     return useLoaderStore();
        // }
    },
    created() {
        // this.loaderStore.show();
    }
};
</script>
