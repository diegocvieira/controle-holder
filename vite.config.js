import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm.js',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/target-asset-classes.js',
                'resources/js/target-assets.js',
                'resources/js/rebalancing.js',
                'resources/js/auth/login.js'
            ],
            refresh: true
        }),
        vue()
    ],
    build: {
        commonjsOptions: {
           requireReturnsDefault: true, // Setting to make prod-build working with vue-slider-component
        }
      }
});
