<script setup lang="js">
import Navbar from '@/Components/Navbar.vue';
import Alert from '@/Components/Alert.vue';
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const props = computed(() => page.props)

const alertMessage = ref(page.props.flash.success || '')
const alertType = ref(page.props.flash.success ? 'success' : '')

watch(props, (newVal) => {
    const { flash, errors } = newVal;

    if (flash.success) {
        setAlert('success', flash.success);
    } else if (flash.info) {
        setAlert('info', flash.info);
    } else if (errors) {
        // Ambil pesan error pertama dari objek errors
        const firstErrorMessage = Object.values(errors).flat()[0];
        setAlert('error', firstErrorMessage);
    }
});

const setAlert = (type, message) => {
    alertType.value = type;
    alertMessage.value = message;
};
</script>

<template>
    <div class="min-h-screen w-full flex flex-col items-center">
        <div class="fixed top-0 w-full z-50">
            <Navbar />
            <div class="absolute top-full mt-2 md:mt-0 w-full px-4 flex justify-center md:justify-end items-center">
                <Alert :message="alertMessage" :type="alertType" @update:message="alertMessage = $event" />
            </div>
        </div>
        <div class="w-full min-h-screen flex justify-center items-center">
            <slot />
        </div>
    </div>
</template>
