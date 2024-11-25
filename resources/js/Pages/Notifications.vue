<script setup lang="js">
import TextInput from '@/Components/form/TextInput.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import formatDate from '@/utils/formatDate';
import { Head, router, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, reactive, watchEffect } from 'vue';

const state = reactive({
    loading_receiver: false,
    loading_history: false,
    emailReceivers: [],
    filteredEmailReceivers: [],
    emailHistories: [],
    searchEmail: ''
})

const form = useForm({
    email_address: ''
})

const loadHistories = async () => {
    state.loading_history = true

    try {
        const response = await axios.get(route('email.histories'))
        const histories = response.data
        state.emailHistories = histories
    } catch (error) {
        console.error('error load histories:', error)
    } finally {
        setTimeout(() => {
            state.loading_history = false
        }, 1000);
    }
}

const loadReceivers = async () => {
    state.loading_receiver = true

    try {
        const response = await axios.get(route('email.receivers'))
        const receivers = response.data
        state.emailReceivers = receivers
        state.filteredEmailReceivers = receivers
    } catch (error) {
        console.error('error load receivers:', error)
    } finally {
        setTimeout(() => {
            state.loading_receiver = false
        }, 1000);
    }
}

const createReceiver = () => {
    form.post(route('email.receiver.create'), {
        onSuccess: () => {
            loadReceivers()
            loadHistories()
        }
    })
}

const deleteReceiver = (receiverId) => {
    router.post(route('email.receiver.destroy', receiverId), {}, {
        onSuccess: () => {
            loadReceivers()
            loadHistories()
        }
    })
}

const deleteHistory = (historyId) => {
    router.post(route('email.history.destroy', historyId), {}, {
        onSuccess: () => {
            loadHistories()
        }
    })
}

const handleSearchEmail = () => {
    if (state.searchEmail === '') {
        // Jika input kosong, tampilkan semua email
        state.filteredEmailReceivers = state.emailReceivers;
    } else {
        // Filter email berdasarkan query
        const query = state.searchEmail.toLowerCase();
        state.filteredEmailReceivers = state.emailReceivers.filter(receiver =>
            receiver.email_address.toLowerCase().includes(query)
        );
    }
}

onMounted(() => {
    loadReceivers()
    loadHistories()
})
</script>

<template>
    <UserLayout>

        <Head title="Notifikasi" />
        <div class="px-4 pt-40 pb-20 md:p-20 w-full flex flex-col md:flex-row justify-center items-center gap-8">

            <!-- Notification History Card -->
            <div class="card w-full bg-base-300 shadow-xl">
                <div class="card-body flex flex-col h-full">
                    <h1 class="card-title">Riwayat Notifikasi</h1>
                    <div class="h-96 overflow-y-scroll flex flex-col items-center gap-4">
                        <div v-if="state.loading_history" class="w-full h-full flex justify-center items-center">
                            <span class="loading loading-bars loading-md"></span>
                        </div>
                        <template v-else-if="!state.loading_history && state.emailHistories.length > 0">
                            <template v-for="(history, index) in state.emailHistories">
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
                                                        <button class="btn btn-error"
                                                            @click="deleteHistory(history.id)">Hapus Riwayat</button>
                                                        <button class="btn btn-accent">Tutup</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </dialog>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <div v-else class="w-full h-full flex justify-center items-center">
                            <span class="text-center">Belum ada data riwayat notifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Receiver Card -->
            <div class="card bg-base-300 w-full shadow-xl">
                <div class="card-body">
                    <h1 class="card-title">Daftar Penerima Notifikasi</h1>
                    <div class="w-full flex flex-col p-4 gap-4">
                        <div class="w-full flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                            <div class="flex flex-row items-center w-full">
                                <label
                                    class="w-full input input-bordered flex items-center gap-2 relative overflow-hidden">
                                    <input type="text" class="grow border-none focus:ring-0 pr-10"
                                        placeholder="Cari alamat email..." v-model="state.searchEmail"
                                        @input="handleSearchEmail" />
                                    <i class="pi pi-search"></i>
                                </label>
                            </div>
                            <button :disabled="form.processing" class="btn btn-secondary"
                                onclick="add_receiver.showModal()">
                                <template v-if="!form.processing">
                                    <span>Tambah</span>
                                    <i class="pi pi-plus"></i>
                                </template>
                                <template v-else>
                                    <span class="loading loading-bars loading-md"></span>
                                </template>
                            </button>
                            <dialog id="add_receiver" class="modal">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Tambah Penerima Notifikasi</h3>
                                    <div class="p-4 flex flex-col gap-4">
                                        <p>Masukan alamat email yang akan dikirimkan notifikasi di kolom dibawah ini:
                                        </p>
                                        <TextInput v-model="form.email_address" placeholder="Alamat Email" />
                                    </div>
                                    <div class="modal-action">
                                        <form method="dialog" class="flex items-center gap-3">
                                            <button class="btn btn-accent" @click="createReceiver">Tambah & Kirim
                                                Verifikasi</button>
                                            <button class="btn btn-error">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        </div>
                        <div class="h-60 flex flex-col items-center gap-4 overflow-y-scroll overflow-x-clip">
                            <div v-if="state.loading_receiver" class="w-full h-full flex justify-center items-center">
                                <span class="loading loading-bars loading-md"></span>
                            </div>
                            <template v-else-if="!state.loading_receiver && state.emailReceivers.length > 0">
                                <!-- Email Card -->
                                <template v-for="(receiver, index) in state.filteredEmailReceivers">
                                    <div class="card bg-base-100 w-full">
                                        <div class="card-body flex flex-row justify-between items-center p-4">
                                            <div
                                                class="w-full flex flex-col lg:flex-row lg:justify-between lg:items-center">
                                                <div class="w-full lg:max-w-none">
                                                    <h1 class="font-semibold">{{ receiver.email_address }}</h1>
                                                </div>
                                                <div class="w-36 flex lg:justify-center lg:items-center lg:max-w-none">
                                                    <span class="text-sm font-light capitalize lg:text-center">{{
                                                        receiver.status }}</span>
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
                                                    <p v-if="receiver.status == 'Aktif'">tervalidasi pada tanggal: {{
                                                        formatDate(receiver.email_verified_at)
                                                        }}</p>
                                                    <p>Didaftarkan pada tanggal: {{ formatDate(receiver.created_at) }}
                                                    </p>
                                                    <div class="modal-action">
                                                        <form method="dialog" class="flex items-center gap-3">
                                                            <button class="btn btn-error"
                                                                @click="deleteReceiver(receiver.id)">Hapus
                                                                Alamat
                                                                Email</button>
                                                            <button class="btn btn-accent">Tutup</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </div>
                                    </div>
                                </template>
                            </template>
                            <div v-else-if="state.emailReceivers.length == 0 && state.searchEmail !== ''"
                                class="w-full h-full flex justify-center items-center">
                                <span class="text-center">Alamat email tidak ditemukan</span>
                            </div>
                            <div v-else class="w-full h-full flex justify-center items-center">
                                <span>Belum ada data penerima email</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>