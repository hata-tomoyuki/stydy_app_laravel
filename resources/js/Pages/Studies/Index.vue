<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { reactive, toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    studies: Object,
})
const { studies } = toRefs(props);

const goToEditPage = (id) => {
    Inertia.visit(`/studies/${studies.id}`, { method: 'get' });
};

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ダッシュボード
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link as="button" :href="route('studies.create')"
                    class="flex ml-auto mb-4 text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                学習登録</Link>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-calendar class="custom-calendar max-w-full" disable-page-swipe is-expanded>
                        <template v-slot:day-content="{ day }">
                            <div class="flex flex-col h-full z-10 overflow-hidden cursor-pointer">
                                <span class="day-label text-sm text-gray-900">{{ day.day }}</span>
                                <div class="flex-grow overflow-y-auto overflow-x-auto">
                                    <div v-for="study in studies.filter(s => {
                                        const studyDateParts = s.study_date.split('-');
                                        const studyDate = new Date(studyDateParts[0], studyDateParts[1] - 1, studyDateParts[2]);
                                        return studyDate.toDateString() === day.date.toDateString();
                                    })" :key="study.id" class="h-full">
                                        <Link :href="route('studies.show', { study: study.id })" class="h-full block">
                                        <p class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1">
                                            学習項目：{{ study.subject }}<br>
                                            学習時間：{{ study.duration }}分
                                        </p>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </v-calendar>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

