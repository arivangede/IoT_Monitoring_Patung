<script setup lang="js">
import formatDate from '@/utils/formatDate';

const props = defineProps({
    index: {
        type: Number,
        required: true
    },
    history: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="card w-full bg-base-100">
        <div class="card-body flex flex-row justify-between items-center p-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:gap-20">
                <h1 class="font-semibold">{{ history.title }}</h1>
                <span class="text-sm font-light">{{ formatDate(history.created_at) }}</span>
            </div>
            <button class="btn btn-ghost btn-circle"
                :onclick="`document.getElementById('history_details${index}').showModal()`">
                <i class="pi pi-chevron-right"></i>
            </button>
            <dialog :id="`history_details${index}`" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">{{ history.title }}</h3>
                    <p>{{ history.text }}</p>
                    <p>status : {{ history.status }}</p>
                    <p>terkirim pada : {{ formatDate(history.created_at) }}</p>
                    <div class="modal-action">
                        <form method="dialog" class="flex items-center gap-3">
                            <button class="btn btn-accent">tutup</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
</template>