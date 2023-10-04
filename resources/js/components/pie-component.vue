<template>
    <v-chart v-if="data.data.length > 0" :option="option" autoresize />
</template>

<script>
    import { use } from 'echarts/core';
    import { CanvasRenderer } from 'echarts/renderers';
    import { PieChart } from 'echarts/charts';
    import { GridComponent, TooltipComponent, LegendComponent, TitleComponent } from 'echarts/components';
    import VChart from 'vue-echarts';

    use([CanvasRenderer, PieChart, GridComponent, TitleComponent, TooltipComponent, LegendComponent]);

    export default {
        name: 'pie-component',
        props: ['data'],
        components: { VChart },
        data() {
            return {
                option: {
                    textStyle: {
                        fontFamily: 'Inter, "Helvetica Neue", Arial, sans-serif'
                    },
                    title: {
                        text: '',
                        left: 'center',
                        textStyle: {
                            color: 'white',
                            fontWeight: 'normal'
                        }
                    },
                    tooltip: {
                        formatter: params => {
                            return this.formatTooltip(params.data);
                        }
                    },
                    legend: {
                        orient: 'horizontal',
                        left: 'center',
                        bottom: '0',
                        textStyle: {
                            color: 'white'
                        }
                    },
                    label: {
                        formatter: '{b} ({d}%)',
                        color: '#ffffff',
                    },
                    series: [{
                        name: '',
                        type: 'pie',
                        radius: '55%',
                        data: [],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                }
            }
        },
        watch: {
            data: {
                handler(newData) {
                    this.option.title.text = newData.title;
                    this.option.series[0].data = newData.data;
                },
                deep: true
            }
        },
        methods: {
            formatTooltip(data) {
                if (this.data.tooltipType === 'rating') {
                    return `${data.name} (Nota: ${data.value})`;
                } else if (this.data.tooltipType === 'percentage') {
                    return `${data.name} (${data.value}%)`;
                }

                return `${data.name} (${this.$moneyFormat(data.value)})`;
            }
        }
    }
</script>
