import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js'
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
