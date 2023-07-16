import VueSlider from 'vue-slider-component';
import HeaderComponent from '../../components/header-component.vue';
import LoaderComponent from '../../components/loader-component.vue';

export default new Vue({
    el: '#target-asset-classes-page',
    data () {
        return {
            progressBar: 0,
            assetClasses: [
                {
                    name: 'Ações',
                    slug: 'acoes',
                    percentage: 0,
                    last_percentage: 0,
                    slider: 'sliderAcoes',
                    icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M475.115 163.781L336 252.309v-68.28c0-18.916-20.931-30.399-36.885-20.248L160 252.309V56c0-13.255-10.745-24-24-24H24C10.745 32 0 42.745 0 56v400c0 13.255 10.745 24 24 24h464c13.255 0 24-10.745 24-24V184.029c0-18.917-20.931-30.399-36.885-20.248z"></path>
                    </svg>`
                },
                {
                    name: 'FIIs',
                    slug: 'fiis',
                    percentage: 0,
                    last_percentage: 0,
                    slider: 'sliderFiis',
                    icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M436 480h-20V24c0-13.255-10.745-24-24-24H56C42.745 0 32 10.745 32 24v456H12c-6.627 0-12 5.373-12 12v20h448v-20c0-6.627-5.373-12-12-12zM128 76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76zm0 96c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40zm52 148h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12zm76 160h-64v-84c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v84zm64-172c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40z"></path>
                    </svg>`
                },
                {
                    name: 'Criptomoedas',
                    slug: 'criptomoedas',
                    slider: 'sliderCriptomoedas',
                    percentage: 0,
                    last_percentage: 0,
                    icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zm-141.651-35.33c4.937-32.999-20.191-50.739-54.55-62.573l11.146-44.702-27.213-6.781-10.851 43.524c-7.154-1.783-14.502-3.464-21.803-5.13l10.929-43.81-27.198-6.781-11.153 44.686c-5.922-1.349-11.735-2.682-17.377-4.084l.031-.14-37.53-9.37-7.239 29.062s20.191 4.627 19.765 4.913c11.022 2.751 13.014 10.044 12.68 15.825l-12.696 50.925c.76.194 1.744.473 2.829.907-.907-.225-1.876-.473-2.876-.713l-17.796 71.338c-1.349 3.348-4.767 8.37-12.471 6.464.271.395-19.78-4.937-19.78-4.937l-13.51 31.147 35.414 8.827c6.588 1.651 13.045 3.379 19.4 5.006l-11.262 45.213 27.182 6.781 11.153-44.733a1038.209 1038.209 0 0 0 21.687 5.627l-11.115 44.523 27.213 6.781 11.262-45.128c46.404 8.781 81.299 5.239 95.986-36.727 11.836-33.79-.589-53.281-25.004-65.991 17.78-4.098 31.174-15.792 34.747-39.949zm-62.177 87.179c-8.41 33.79-65.308 15.523-83.755 10.943l14.944-59.899c18.446 4.603 77.6 13.717 68.811 48.956zm8.417-87.667c-7.673 30.736-55.031 15.12-70.393 11.292l13.548-54.327c15.363 3.828 64.836 10.973 56.845 43.035z"></path>
                    </svg>`
                }
            ],
            sliderOptions: {
                dotSize: 14,
                width: 'auto',
                height: 4,
                contained: false,
                direction: 'ltr',
                data: null,
                dataLabel: 'label',
                dataValue: 'value',
                min: 0,
                max: 100,
                interval: 1,
                disabled: false,
                clickable: false,
                duration: 0.5,
                adsorb: false,
                lazy: false,
                tooltip: 'active',
                tooltipPlacement: 'top',
                tooltipFormatter: void 0,
                useKeyboard: false,
                keydownHook: null,
                dragOnClick: false,
                enableCross: true,
                fixed: false,
                minRange: void 0,
                maxRange: void 0,
                order: true,
                marks: false,
                dotOptions: void 0,
                dotAttrs: void 0,
                process: true,
                dotStyle: void 0,
                railStyle: void 0,
                processStyle: void 0,
                tooltipStyle: void 0,
                stepStyle: void 0,
                stepActiveStyle: void 0,
                labelStyle: void 0,
                labelActiveStyle: void 0
            }
        }
    },
    methods: {
        getAssetClasses() {
            axios.get('/api/asset-classes').then(response => {
                response.data.data.forEach(data => {
                    const assetClass = this.assetClasses.find(assetClass => assetClass.slug === data.slug);
                    assetClass.percentage = data.percentage;
                    assetClass.last_percentage = data.percentage;
                });
            }).catch(error => console.log(error));
        }
    },
    created() {
        this.getAssetClasses();
    },
    updated() {
        this.$refs.loader.show = false;
    },
    watch: {
        assetClasses: {
            handler(assetClasses) {
                let indexChanged = null;
                this.progressBar = 0;

                assetClasses.map((assetClass, index) => {
                    if (assetClass.percentage != assetClass.last_percentage) {
                        indexChanged = index;
                    }

                    assetClass.last_percentage = assetClass.percentage;
                    this.progressBar += assetClass.percentage;
                });

                if (this.progressBar > 100 && indexChanged != null) {
                    const assetChanged = assetClasses[indexChanged];
                    const newPercentage = parseInt(assetChanged.percentage) - 1;

                    assetChanged.percentage = newPercentage;

                    this.$nextTick(() => {
                        this.$refs[assetChanged.slider][0].setValue(newPercentage);
                    });
                }
            },
            deep: true
        }
    },
    components: {
        VueSlider,
        HeaderComponent,
        LoaderComponent
    }
});
