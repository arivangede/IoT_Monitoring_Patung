<script setup lang="js">
const props = defineProps({
    name: {
        type: String,
        default: 'Dust'
    }
})
</script>

<template>
    <div class="card bg-base-100">
        <div class="card-body flex flex-col justify-center items-center">
            <h1 class="card-title text-sm text-center">{{ name }}</h1>
            <span class="text-xl md:text-3xl">50µg/m³</span>
            <span class="text-sm">(mikrogram)</span>
        </div>
    </div>
</template>