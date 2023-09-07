import HeaderComponent from '../../components/header-component.vue';
import PieComponent from '../../components/pie-component.vue';

export default new Vue({
    el: '#dashboard-page',
    data() {
        return {
            chartdata: null
        };
    },
    mounted() {
        setTimeout(() => {
            console.log("Delayed for 2 second.");

            this.chartdata = {
                labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
                datasets: [{
                    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                    data: [40, 20, 80, 10]
                }]
            }
          }, "2000");
    },
    components: {
        HeaderComponent,
        PieComponent
    }
});
