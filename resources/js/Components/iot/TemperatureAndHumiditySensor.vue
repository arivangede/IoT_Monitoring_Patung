<script setup lang="js">
import AnimatedNumber from '../animated/AnimatedNumber.vue';

defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    temperature: {
        type: Number,
        default: 0.0
    },
    humidity: {
        type: Number,
        default: 0.0
    }
})
</script>

<template>
    <div class="card shadow-xl flex flex-col justify-center items-center gap-2">
        <h1 class="card-title text-sm text-center max-w-xs w-36 sm:w-auto">Temperatur dan Kelembaban</h1>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
            <div class="card bg-base-100 w-36">
                <div class="card-body flex flex-col justify-center items-center">
                    <template v-if="loading">
                        <span class="loading loading-bars loading-md"></span>
                    </template>
                    <template v-else>
                        <AnimatedNumber :value="temperature" :duration="2000" uom="ºC" />
                    </template>
                    <span>Temperatur</span>
                </div>
            </div>
            <div class="card bg-base-100 w-36">
                <div class="card-body flex flex-col justify-center items-center">
                    <template v-if="loading">
                        <span class="loading loading-bars loading-md"></span>
                    </template>
                    <template v-else>
                        <AnimatedNumber :value="humidity" :duration="2000" uom="%" />
                    </template>
                    <span>Kelembaban</span>
                </div>
            </div>
        </div>
    </div>
</template>