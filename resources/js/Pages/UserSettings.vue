<script setup lang="js">
import TextInput from '@/Components/form/TextInput.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';

const { props } = usePage()
const { user } = props.auth

const form = useForm({
    name: user.name,
    email: user.email,
    oldPassword: '',
    password: '',
    password_confirmation: ''
})

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

const changeName = () => {
    form
        .transform((data) => ({ name: data.name }))
        .patch(route('user.update', user.id), {
            onError: () => {
                form.reset('name')
            }
        })
}

const changeEmail = () => {
    form
        .transform((data) => ({ email: data.email }))
        .patch(route('user.update', user.id), {
            onError: () => {
                form.reset('email')
            }
        })
}

const changePassword = () => {
    form
        .transform((data) => ({ oldPassword: data.oldPassword, password: data.password, password_confirmation: data.password_confirmation }))
        .patch(route('user.change.password', user.id), {
            onFinish: () => {
                form.reset('oldPassword', 'password', 'password_confirmation')
            }
        })
}
const deleteAccount = () => {
    form
        .patch(route('user.delete.account', user.id))
}
</script>

<template>
    <UserLayout>

        <Head title="Pengaturan" />
        <div class="w-full min-h-screen flex justify-center items-center p-0 md:p-4 lg:p-20">
            <div class="card bg-base-300 max-w-xl shadow-xl w-full">
                <div class="card-body items-center">
                    <h1 class="card-title w-full">Pengaturan</h1>
                    <div class="w-full flex flex-row justify-between items-center">
                        <div class="flex items-center gap-2">
                            <h2 class="card-title font-light capitalize">Halo!, {{ form.name }}</h2>
                            <button class="btn btn-ghost btn-circle" onclick="change_name.showModal()">
                                <i class="pi pi-pencil"></i>
                            </button>
                            <dialog id="change_name" class="modal">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Ubah Nama Pengguna</h3>
                                    <div class="p-4">
                                        <TextInput v-model="form.name" />
                                    </div>
                                    <div class="modal-action">
                                        <form method="dialog" class="flex items-center gap-3">
                                            <button class="btn btn-secondary" @click="changeName">Simpan</button>
                                            <button class="btn btn-error">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        </div>
                        <button class="btn btn-accent" @click="handleLogout">
                            <span>Logout</span>
                            <i class="pi pi-sign-out"></i>
                        </button>
                    </div>
                    <div class="flex flex-col w-full mt-6 gap-4">
                        <div class="card bg-base-100">
                            <div class="card-body flex-row justify-between items-center p-6">
                                <h3>Atur Alamat Email</h3>
                                <button class="btn btn-ghost btn-circle" onclick="change_email.showModal()">
                                    <i class="pi pi-pencil"></i>
                                </button>
                                <dialog id="change_email" class="modal">
                                    <div class="modal-box">
                                        <h3 class="text-lg font-bold">Atur Alamat Email</h3>
                                        <div class="p-4">
                                            <TextInput v-model="form.email" />
                                        </div>
                                        <div class="modal-action">
                                            <form method="dialog" class="flex items-center gap-3">
                                                <button class="btn btn-secondary" @click="changeEmail">Simpan</button>
                                                <button class="btn btn-error">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            </div>
                        </div>
                        <div class="card bg-base-100">
                            <div class="card-body flex-row justify-between items-center p-6">
                                <h3>Ganti Password</h3>
                                <button class="btn btn-ghost btn-circle" onclick="change_password.showModal()">
                                    <i class="pi pi-pencil"></i>
                                </button>
                                <dialog id="change_password" class="modal">
                                    <div class="modal-box">
                                        <h3 class="text-lg font-bold">Ganti Password</h3>
                                        <div class="p-4 flex flex-col gap-4">
                                            <TextInput type="password" v-model="form.oldPassword"
                                                placeholder="Password Lama" />
                                            <TextInput type="password" v-model="form.password"
                                                placeholder="Password Baru" />
                                            <TextInput type="password" v-model="form.password_confirmation"
                                                placeholder="Konfirmasi Password Baru" />
                                        </div>
                                        <div class="modal-action">
                                            <form method="dialog" class="flex items-center gap-3">
                                                <button class="btn btn-secondary"
                                                    @click="changePassword">Simpan</button>
                                                <button class="btn btn-error">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            </div>
                        </div>
                        <button class="btn btn-error" onclick="delete_account.showModal()">
                            <span>Hapus Akun</span>
                            <i class="pi pi-trash"></i>
                        </button>
                        <dialog id="delete_account" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold">Konfirmasi Penghapusan Akun</h3>
                                <p>Apakah Anda yakin ingin menghapus akun ini? Proses ini tidak dapat dibatalkan.</p>
                                <div class="modal-action">
                                    <form method="dialog" class="flex items-center gap-3">
                                        <button class="btn btn-error" @click="deleteAccount">Hapus
                                            Akun</button>
                                        <button class="btn btn-accent" @click="closeDialog">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>