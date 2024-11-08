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
        class="alert alert-error flex flex-row justify-between items-center flex-nowrap absolute top-2 max-w-xs"
        v-if="visible">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-xs">{{ message }}</span>
        <button @click="closeAlert" class="px-4 flex justify-center items-center">&times;</button>
    </div>
</template>