export default {
    data () {
        return {
            progressBar: 0,
            assetClasses: [],
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
            axios.get('/api/user/asset-classes').then(response => {
                this.assetClasses = response.data.data.map(assetClass => {
                    return {
                        name: assetClass.name,
                        slug: assetClass.slug,
                        percentage: assetClass.percentage,
                        last_percentage: assetClass.percentage,
                        slider: 'slider_' + assetClass.slug
                    };
                });
            }).catch(error => console.log(error));
        },
        saveAssetClasses(assetClassSlug) {
            const assetClass = this.assetClasses.find(assetClass => assetClass.slug === assetClassSlug);

            if (assetClass.last_percentage === assetClass.percentage) {
                return;
            }

            assetClass.last_percentage = assetClass.percentage;

            const data = {
                slug: assetClass.slug,
                percentage: assetClass.percentage
            };

            axios.post('/api/user/asset-classes', data).then(response => {
                console.log(response);
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
                    if (assetClass.percentage !== assetClass.last_percentage) {
                        indexChanged = index;
                    }

                    this.progressBar += assetClass.percentage;
                });

                if (this.progressBar > 100 && indexChanged !== null) {
                    const assetChanged = assetClasses[indexChanged];
                    const newPercentage = assetChanged.percentage - 1;

                    assetChanged.percentage = newPercentage;

                    this.$nextTick(() => {
                        this.$refs[assetChanged.slider][0].setValue(newPercentage);
                    });
                }
            },
            deep: true
        }
    }
};
