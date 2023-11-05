<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
import { LineChart } from 'vue-chart-3';
import { defineProps } from '@vue/runtime-core';
import dayjs from 'dayjs';

Chart.register(...registerables);

const props = defineProps({
    studies: Object,
    type: String,
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

watch(() => props.studies.studies, (newStudies) => {
    if (!newStudies) {
        return;
    }

    let startDate, endDate, dateRange;
    if (props.type === 'perMonth') {
        startDate = dayjs().startOf('month').format('YYYY-MM-DD');
        endDate = dayjs().endOf('month').format('YYYY-MM-DD');
        dateRange = generateDateRange(startDate, endDate);
    } else {
        // 既存の週表示のロジックを保持
        startDate = dayjs().startOf('week').format('YYYY-MM-DD');
        endDate = dayjs().endOf('week').format('YYYY-MM-DD');
        dateRange = generateDateRange(startDate, endDate);
    }

    const labels = [];
    const data = [];

    if (props.type === 'perWeek') {
        dateRange.forEach((date) => {
            labels.push(date);
            const studySession = newStudies.find(session => session.study_date === date);
            data.push(studySession ? studySession.duration : 0);
        });
    }

    if (props.type === 'perMonth') {
        // 月ごとのラベルとデータを集計
        dateRange.forEach((date) => {
            labels.push(dayjs(date).format('MM-DD'));
            // その日の学習セッションを探す
            const studySession = newStudies.find(session =>
                dayjs(session.study_date).format('YYYY-MM-DD') === date
            );
            // その日の学習時間を取得、もしセッションが存在しなければ0を追加
            const duration = studySession ? studySession.duration : 0;
            data.push(duration);
        });
    }




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
