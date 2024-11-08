<script setup lang="js">
import { computed, defineProps, ref, watchEffect } from 'vue';

const props = defineProps({
    alertData: {
        type: Object,
        required: false,
    },
});

const visible = ref(true);

const alert = computed(() => {
    const type = Object.keys(props.alertData)[0];
    const message = props.alertData[type] || '';
    const classAlert = `alert-${type}`

    return { type, message, classAlert };
});

const closeAlert = () => {
    visible.value = false;
};

watchEffect(() => {
    visible.value = !!alert.value.message;
});
</script>

<template>
    <div
        role="alert"
        :class="[
            'alert',
            alert.classAlert,
            'flex',
            'flex-row',
            'justify-center',
            'items-center',
            'flex-nowrap',
            'absolute',
            'top-2',
            'max-w-xs',
        ]"
        v-if="visible"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 shrink-0 stroke-current"
            fill="none"
            viewBox="0 0 24 24"
            v-if="alert.type === 'success'"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="h-6 w-6 shrink-0 stroke-current"
            v-if="alert.type === 'info'"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
        </svg>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 shrink-0 stroke-current"
            fill="none"
            viewBox="0 0 24 24"
            v-if="alert.type === 'warning'"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
        </svg>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 shrink-0 stroke-current"
            fill="none"
            viewBox="0 0 24 24"
            v-if="alert.type === 'error'"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>
        <span class="text-xs">{{ alert.message }}</span>
        <button @click="closeAlert">&times;</button>
    </div>
</template>
