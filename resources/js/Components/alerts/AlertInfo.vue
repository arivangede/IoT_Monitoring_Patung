<script setup lang="js">
import { ref, watchEffect } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: '',
    }
})

const visible = ref(true);

const closeAlert = () => {
    visible.value = false;
};

watchEffect(() => {
    visible.value = !!props.message;
});
</script>

<template>
    <div role="alert"
        class="alert alert-info flex flex-row justify-between items-center flex-nowrap absolute top-2 max-w-xs"
        v-if="visible">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-xs">{{ message }}</span>
        <button @click="closeAlert" class="px-4 flex justify-center items-center">&times;</button>
    </div>
</template>