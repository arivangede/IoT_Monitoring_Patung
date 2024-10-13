<script setup lang="ts">
import AuthForm from "@/Components/Auth/AuthForm.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Login" />

    <GuestLayout>
        <div
            class="flex flex-col justify-center items-center w-full max-w-screen-lg"
        >
            <AuthForm>
                <h1 class="font-semibold text-xl">Login</h1>

                <div>
                    <label for="username" class="ml-3">Username</label>
                    <input
                        type="text"
                        placeholder="Username / Email"
                        class="input input-bordered w-full max-w-sm"
                    />
                </div>
                <div>
                    <label for="password" class="ml-3">Password</label>
                    <input
                        type="password"
                        placeholder="Password"
                        class="input input-bordered w-full max-w-sm"
                    />
                </div>
            </AuthForm>

            <p class="text-primary">
                Belum Punya Akun?
                <Link href="#" class="underline font-semibold"
                    >Daftar Sekarang</Link
                >
            </p>
        </div>
    </GuestLayout>
</template>
