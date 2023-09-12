<template>
    <div v-if="chartdata != null">
        <Pie id="my-chart-id" :options="chartOptions" :data="chartdata" />
    </div>
</template>

<script>
    import { Pie } from 'vue-chartjs';

    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
        ArcElement,
        CategoryScale
    } from 'chart.js';

    ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

    export default {
        name: 'pie-component',
        props: ['chartdata'],
        components: { Pie },
        data() {
            return {
                chartOptions: {
                    responsive: true
                }
            }
        }
    }
</script>
