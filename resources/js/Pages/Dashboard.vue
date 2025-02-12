<script setup lang="js">
import Card from '@/Components/Card.vue';
import DustSensor from '@/Components/iot/DustSensor.vue';
import SensorsTable from '@/Components/iot/SensorsTable.vue';
import TemperatureAndHumiditySensor from '@/Components/iot/TemperatureAndHumiditySensor.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onBeforeUnmount, onMounted, reactive, watch } from 'vue';

const state = reactive({
    dust_1: 0.0,
    dust_2: 0.0,
    temperature: 0.0,
    humidity: 0.0,
    sensorsData: [],
    loadingCurrentSensorsData: true,
    loadingSensorsData: true,

    dataDisplay: 'jam'
})

const getCurrentSensorsData = async () => {
    try {
        const response = await axios.get(route('sensors.current.data'));
        const data = response.data
        state.dust_1 = data.dust_1
        state.dust_2 = data.dust_2
        state.temperature = data.temperature
        state.humidity = data.humidity
    } catch (error) {
        console.error('error getCurrentSensorsData:', error);
    } finally {
        setTimeout(() => {
            state.loadingCurrentSensorsData = false
        }, 1000);
    }
}

const getAllSensorsData = async (filter = state.dataDisplay) => {
    try {
        const response = await axios.get(route('sensors.all.data'), {
            params: { filter }
        });
        state.sensorsData = response.data;
    } catch (error) {
        console.error('Error in getAllSensorsData:', error);
    } finally {
        setTimeout(() => {
            state.loadingSensorsData = false;
        }, 1000);
    }
};

let intervalId
let isFetching = false; // State untuk mencegah overlapping requests

const intervalCallback = async () => {
    if (isFetching) return; // Skip jika request sebelumnya belum selesai
    isFetching = true;
    await getCurrentSensorsData();
    await getAllSensorsData();
    isFetching = false;
};

onMounted(() => {
    getCurrentSensorsData();
    getAllSensorsData();
    intervalId = setInterval(intervalCallback, 3000); // Interval untuk memuat ulang data
});

onBeforeUnmount(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
})

const handleChangeDataDisplay = (name) => {
    if (state.dataDisplay !== name) {
        state.dataDisplay = name; // Ini otomatis akan memicu watcher
    }
};

watch(() => state.dataDisplay, (newFilter) => {
    state.loadingSensorsData = true;
    getAllSensorsData(newFilter);
});
</script>

<template>

    <Head title="Dashboard" />
    <UserLayout>
        <div class="flex flex-col justify-center items-center mt-40 md:mt-0 p-0 gap-4 sm:p-4 lg:p-20">
            <Card custom-padding="p-4 sm:p-4 lg:p-8">
                <div class="flex w-full justify-center items-end gap-4 px-2">
                    <TemperatureAndHumiditySensor :loading="state.loadingCurrentSensorsData"
                        :temperature="state.temperature" :humidity="state.humidity" />
                    <div class="flex flex-col sm:flex-row gap-2">
                        <DustSensor name="Sensor Debu 1" :data="state.dust_1"
                            :loading="state.loadingCurrentSensorsData" />
                        <DustSensor name="Sensor Debu 2" :data="state.dust_2"
                            :loading="state.loadingCurrentSensorsData" />
                    </div>
                </div>
            </Card>
            <Card custom-padding="p-4 sm:p-4 lg:p-8">
                <div class="collapse bg-base-200">
                    <input type="checkbox" class="w-full" />
                    <div
                        class="collapse-title text-xl font-medium w-full flex justify-center md:justify-normal items-center gap-4">
                        <span class="break-words">Data Sensor Berdasarkan :</span>
                        <div class="btn btn-primary capitalize">{{ state.dataDisplay }} </div>
                    </div>
                    <div class="collapse-content flex justify-center md:justify-normal items-center">
                        <button class="btn" :class="state.dataDisplay == 'menit' && 'btn-secondary'"
                            @click="handleChangeDataDisplay('menit')">Menit</button>
                        <button class="btn" :class="state.dataDisplay == 'jam' && 'btn-secondary'"
                            @click="handleChangeDataDisplay('jam')">Jam</button>
                        <button class="btn" :class="state.dataDisplay == 'hari' && 'btn-secondary'"
                            @click="handleChangeDataDisplay('hari')">Hari</button>
                        <button class="btn" :class="state.dataDisplay == 'semua' && 'btn-secondary'"
                            @click="handleChangeDataDisplay('semua')">Semua</button>
                    </div>
                </div>
                <SensorsTable :data="state.sensorsData" :loading="state.loadingSensorsData"
                    :hide-time="state.dataDisplay == 'hari' ? true : false" />
            </Card>
        </div>
    </UserLayout>
</template>
