<template>
    <DoughnutChart ref="doughnutRef" :chartData="chartData" @chart:render="handleChartRender" />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default defineComponent({
props: {
    chartData: Object
},
components: { DoughnutChart },
data() {
    return {
    };
},
methods: {
    handleChartRender(chart) {
    console.log(chart);
    },
},
});
</script>
