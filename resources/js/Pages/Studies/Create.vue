<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';
import { DatePicker as VDatePicker } from 'v-calendar';

const form = reactive({
    subject: null,
    duration: null,
    memo: null,
    date: new Date().toISOString().substr(0, 10),
})


const storeStudy = () => {
    Inertia.post('/studies', form)
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                学習内容の登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <form @submit.prevent="storeStudy">
                            <div class="container px-5 py-24 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                                <v-date-picker v-model="form.date" :is-inline="false"
                                                    :show-calendar-on-focus="true" :input-debounce="0" mode="single"
                                                    format="YYYY-MM-DD">
                                                    <!-- テキストフィールドのスロットをカスタマイズ -->
                                                    <template v-slot="{ inputValue, togglePopover }">
                                                        <input readonly type="text" id="date" name="date"
                                                            :value="inputValue" @focus="togglePopover"
                                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                                    </template>
                                                </v-date-picker>
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="subject" class="leading-7 text-sm text-gray-600">学習内容</label>
                                                <input type="text" id="subject" name="subject" v-model="form.subject"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="duration"
                                                    class="leading-7 text-sm text-gray-600">学習時間(分)</label>
                                                <input type="number" id="duration" name="duration" v-model="form.duration"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                <textarea id="memo" name="memo" v-model="form.memo"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <button
                                                class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">登録</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
