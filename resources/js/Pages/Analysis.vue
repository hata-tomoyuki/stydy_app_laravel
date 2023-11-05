<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Chart from '@/Components/Chart.vue';
import { reactive, ref } from 'vue';

const studyData = ref([]);

const props = defineProps({
    "studies": Array,
});

const form = reactive({
    type: 'perWeek',
});

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                type: form.type,
            }
        })
            .then(res => {
                studyData.value = res.data;
            })
    } catch (error) {
        console.log(error);
    }
}

getData();

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                データ分析
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Chart :studies="studyData" :type=form.type />
                </div>
                <form @submit.prevent="getData">
                    <input type="radio" v-model="form.type" value="perWeek" checked>日別
                    <input type="radio" v-model="form.type" value="perMonth">月別
                    <button
                        class="flex mt-4 mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">分析</button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
