<script setup lang="ts">
import NotificationsHistory from '@/Components/notifications/NotificationsHistory.vue';
import NotificationsReceiver from '@/Components/notifications/NotificationsReceiver.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <UserLayout>

        <Head title="Notifikasi" />
        <div class="px-4 pt-40 pb-20 md:p-20 w-full flex flex-col md:flex-row justify-center items-center gap-8">
            <NotificationsHistory />
            <NotificationsReceiver />
        </div>
    </UserLayout>
</template>