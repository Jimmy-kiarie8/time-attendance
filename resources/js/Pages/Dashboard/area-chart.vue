<template>
    <div id="app">
      <LineChart v-bind="lineChartProps" :options="options" />
    </div>
</template>

<script>
import { Chart, registerables } from 'chart.js';
import { LineChart, useLineChart } from 'vue-chart-3';
import { ref, computed, defineComponent } from 'vue';

Chart.register(...registerables);

export default defineComponent({
name: 'App',
components: {
    LineChart,
},
setup() {
    const data = ref([30, 40, 60, 70, 5]);

    const chartData = computed(() => ({
    labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
    datasets: [
        {
        data: data.value,
        borderColor: '#0079AF', // Line color
        backgroundColor: 'rgba(0, 121, 175, 0.3)', // Background color with opacity
        },
    ],
    }));

    const { lineChartProps, lineChartRef } = useLineChart({
    chartData,
    });

    const options = ref({
    responsive: true,
    plugins: {
        legend: {
        position: 'top',
        },
        title: {
        display: true,
        text: 'Delivered',
        },
    },
    scales: {
        x: {
        display: true,
        },
        y: {
        beginAtZero: true,
        },
    },
    });


    const fetchChartData = () => {
      axios.get('/getOrderData')
        .then((response) => {
          chartData.value.values = response.data.values;
          chartData.value.labels = response.data.labels;
        })
        .catch((error) => {
          console.error(error);
        });
    };

    onMounted(() => {
      fetchChartData();
    });

    return { shuffleData, lineChartProps, lineChartRef, options };
},
});
</script>
