<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Verified" />
    <GuestLayout>
        <div class="p-8 flex flex-col justify-center items-center gap-4 max-w-lg">
            <div class="flex flex-col justify-center items-center gap-2">
                <i class="pi pi-check-circle text-6xl text-primary"></i>
                <span class="text-primary text-2xl">Verifikasi Berhasil!</span>
            </div>
            <h1 class="text-xl text-center">Email anda berhasil terverifikasi, anda sekarang dapat menerima email
                notifikasi dari <span class="text-secondary whitespace-nowrap">Sistem Monitoring Patung</span></h1>
        </div>
    </GuestLayout>
</template>