<script setup lang="ts">
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const state = reactive({
    logout_processing: false
})

const handleLogout = () => {
    state.logout_processing = true

    router.post(route('logout'), {}, {
        onFinish: () => {
            state.logout_processing = false
        }
    });
};
</script>

<template>
    <UserLayout>

        <Head title="Pengaturan" />
        <div class="w-full min-h-screen flex justify-center items-center p-20">
            <div class="card bg-base-300 max-w-xl shadow-xl w-full">
                <div class="card-body items-center">
                    <h1 class="card-title w-full">Pengaturan</h1>
                    <div class="w-full flex flex-row justify-between items-center">
                        <h2 class="card-title font-light">Halo!, Test User</h2>
                        <button class="btn btn-accent" @click.prevent="handleLogout">
                            <span>Logout</span>
                            <i class="pi pi-sign-out"></i>
                        </button>
                    </div>
                    <div class="flex flex-col w-full mt-6 gap-4">
                        <div class="card bg-base-100">
                            <div class="card-body flex-row justify-between items-center p-6">
                                <h3>Atur Alamat Email</h3>
                                <button class="btn btn-ghost btn-circle">
                                    <i class="pi pi-pencil"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card bg-base-100">
                            <div class="card-body flex-row justify-between items-center p-6">
                                <h3>Ganti Password</h3>
                                <button class="btn btn-ghost btn-circle">
                                    <i class="pi pi-pencil"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-error">
                            <span>Hapus Akun</span>
                            <i class="pi pi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>