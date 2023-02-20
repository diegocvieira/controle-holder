import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm.js',
        }
    },
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/target.js'],
            refresh: true
        })
    ],
    build: {
        commonjsOptions: {
           requireReturnsDefault: true, // Setting to make prod-build working with vue-slider-component
        }
      }
});
