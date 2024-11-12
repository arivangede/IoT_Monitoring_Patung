<script setup lang="js">
import Navbar from '@/Components/Navbar.vue';
import Alert from '@/Components/Alert.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage()

const alertMessage = ref(props.flash.success || '')
const alertType = ref(props.flash.success ? 'success' : '')
</script>

<template>
    <div class="min-h-screen w-full flex flex-col items-center">
        <div class="fixed top-0 w-full">
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
