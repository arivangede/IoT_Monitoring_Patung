<script setup lang="js">
import formatDate from '@/utils/formatDate';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    index: {
        type: Number,
        required: true
    },
    receiver: {
        type: Object,
        required: true
    }
})

const deleteEmail = () => {
    router.post(route('email.receiver.destroy', props.receiver.id));
}
</script>
<template>
    <div class="card bg-base-100 w-full">
        <div class="card-body flex flex-row justify-between items-center p-4">
            <div class="w-full flex flex-col lg:flex-row lg:justify-between lg:items-center">
                <div class="w-full lg:max-w-none">
                    <h1 class="font-semibold">{{ receiver.email_address }}</h1>
                </div>
                <div class="w-36 flex lg:justify-center lg:items-center lg:max-w-none">
                    <span class="text-sm font-light capitalize lg:text-center">{{ receiver.status }}</span>
                </div>
            </div>
            <button class="btn btn-ghost btn-circle"
                :onclick="`document.getElementById('receiver_details${index}').showModal()`">
                <i class="pi pi-pencil"></i>
            </button>
            <dialog :id="`receiver_details${index}`" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Informasi Penerima Email</h3>
                    <p>{{ receiver.email_address }}</p>
                    <p>Status: {{ receiver.status }}</p>
                    <p>tervalidasi pada tanggal: {{ formatDate(receiver.email_verified_at) }}</p>
                    <p>Didaftarkan pada tanggal: {{ formatDate(receiver.created_at) }}</p>
                    <div class="modal-action">
                        <form method="dialog" class="flex items-center gap-3">
                            <button class="btn btn-error" @click="deleteEmail">Hapus Alamat Email</button>
                            <button class="btn btn-accent">Tutup</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
</template>