<script setup lang="js">
const props = defineProps({
    transparent: {
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <div :class="`card w-full shadow-xl max-w-sm bg-base-300 ${transparent && 'bg-opacity-60'
        }`">
        <div class="card-body">
            <slot />
        </div>
    </div>
</template>
