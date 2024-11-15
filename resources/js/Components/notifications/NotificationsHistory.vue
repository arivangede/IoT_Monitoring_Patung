<script setup lang="ts">
import NotificationCard from './NotificationCard.vue';
</script>

<template>
    <div class="card w-full bg-base-300 shadow-xl">
        <div class="card-body flex flex-col h-full">
            <h1 class="card-title">Riwayat Notifikasi</h1>
            <div class="h-96 overflow-y-scroll flex flex-col items-center gap-4">
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
                <NotificationCard />
            </div>
        </div>
    </div>
</template>