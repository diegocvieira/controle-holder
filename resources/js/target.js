import './app'
import 'vue-slider-component/theme/default.css'
import VueSlider from 'vue-slider-component'
import WalletComponent from './components/wallet-component'

new Vue({
    el: '#target-page',
    data () {
        return {
            choice: 'walletActive',
            progressBar: 0,
            acoes: 0,
            fiis: 0,
            criptomoedas: 0,
            options: {
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
        makeActive: function(val) {
            this.choice = val;
        },
        isActiveTab: function(val) {
          return this.choice === val;
        },
        totalSum(percentage, reference) {
            this.progressBar = parseInt(this.acoes) + parseInt(this.fiis) + parseInt(this.criptomoedas)

            if (this.progressBar > 100) {
                this.$nextTick(() => {
                    reference.setValue(parseInt(percentage) - 1)
                })
            }
        }
    },
    watch: {
        acoes (percentage) {
            this.totalSum(percentage, this.$refs.sliderAcoes)
        },
        fiis (percentage) {
            this.totalSum(percentage, this.$refs.sliderFiis)
        },
        criptomoedas (percentage) {
            this.totalSum(percentage, this.$refs.sliderCriptomoedas)
        }
    },
    components: {
        VueSlider, WalletComponent
    }
})
