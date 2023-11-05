<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
import { BarChart } from 'vue-chart-3';
import { LineChart } from 'vue-chart-3';
import { defineProps } from '@vue/runtime-core';
import dayjs from 'dayjs';

Chart.register(...registerables);

const props = defineProps({
    studies: Array
});

const graphData = ref({
    labels: [],
    datasets: []
});

function generateDateRange(start, end) {
    let dates = [];
    let currentDate = dayjs(start);

    while (currentDate.isBefore(dayjs(end).add(1, 'day'))) {
        dates.push(currentDate.format('YYYY-MM-DD'));
        currentDate = currentDate.add(1, 'day');
    }

    return dates;
}

const chartOptions = ref({
    scales: {
        y: {
            beginAtZero: true,
            max: 300
        }
    }
});

watch(() => props.studies, (newStudies) => {
    const startDate = dayjs().startOf('week').format('YYYY-MM-DD'); // 週の初め
    const endDate = dayjs().endOf('week').format('YYYY-MM-DD'); // 週の終わり
    const dateRange = generateDateRange(startDate, endDate);

    const labels = [];
    const data = [];

    dateRange.forEach((date) => {
        labels.push(date);
        const studySession = newStudies.find(session => session.study_date === date);
        data.push(studySession ? studySession.duration : 0);
    });

    graphData.value = {
        labels,
        datasets: [{
            label: 'Study Duration',
            data,
            backgroundColor: 'rgba(54, 162, 235, 0.5)'
        }]
    };
}, {
    immediate: true
});
</script>

<template>
    <div>
        <LineChart :chartData="graphData" :options="chartOptions" />
    </div>
</template>
