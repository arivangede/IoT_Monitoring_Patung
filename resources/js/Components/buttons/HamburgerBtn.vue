<script setup lang="js">
import { computed } from 'vue';

const props = defineProps({
    value: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:value']);

// Computed property untuk mengelola nilai `value` dengan logging
const isChecked = computed({
    get: () => props.value,
    set: (newValue) => {
        console.log('Emitting update:value with:', newValue); // Log untuk memastikan emit berjalan
        emit('update:value', newValue);
    }
});
</script>

<template>

</template>
