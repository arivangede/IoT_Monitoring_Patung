<script setup lang="js">
const props = defineProps({
    transparent: {
        type: Boolean,
        default: false
    },
    customPadding: {
        type: String,
        default: ''
    }
})
</script>
<template>
    <div :class="`card w-full shadow-xl bg-base-300 ${transparent && 'bg-opacity-60'
        }`">
        <div :class="`card-body ${customPadding}`">
            <slot />
        </div>
    </div>
</template>
