<script setup lang="js">
const props = defineProps({
    transparent:{
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <div
        :class="`card bg-base-100 w-full shadow-xl ${
            transparent && 'bg-opacity-60'
        }`"
    >
        <div class="card-body">
            <slot />
        </div>
    </div>
</template>
