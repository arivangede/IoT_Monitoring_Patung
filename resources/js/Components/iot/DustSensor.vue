<script setup lang="js">
import AnimatedNumber from '../animated/AnimatedNumber.vue';

const props = defineProps({
    name: {
        type: String,
        default: 'Dust'
    },
    data: {
        type: Number,
        default: 0.0
    },
    loading: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div class="card bg-base-100">
        <div class="card-body flex flex-col justify-center items-center w-36 md:w-52">
            <h1 class="card-title text-sm text-center">{{ name }}</h1>
            <template v-if="loading">
                <span class="loading loading-bars loading-md"></span>
            </template>
            <template v-else>
                <AnimatedNumber :value="data" :duration="2000" uom="µg/m³" />
            </template>
            <span class="text-sm">(mikrogram)</span>
        </div>
    </div>
</template>