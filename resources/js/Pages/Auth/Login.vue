<script setup lang="js">
import Alert from "@/Components/Alert.vue";
import Card from "@/Components/Card.vue";
import TextInput from "@/Components/form/TextInput.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const { props } = usePage();
console.log(props)

const form = useForm({
    email: "",
    password: ''
})

const submitForm = () => {
    form.post(route('login'), {
        onError: () => {
            form.reset('password')
        }
    })
}
</script>

<template>
    <Head title="Login" />
    <GuestLayout>
        <Alert :alert-data="form.errors" />

        <Card :transparent="true">
            <form
                @submit.prevent="submitForm"
                class="flex flex-col justify-center items-center gap-5"
            >
                <h1 class="card-title">Login</h1>

                <TextInput
                    type="email"
                    icon="pi-envelope"
                    v-model="form.email"
                    placeholder="Email"
                    :error="form.errors.error"
                    :required="true"
                />
                <TextInput
                    type="password"
                    icon="pi-lock"
                    v-model="form.password"
                    placeholder="Password"
                    :error="form.errors.error"
                    :required="true"
                />

                <div class="w-full flex items-center justify-center mt-4">
                    <button
                        type="submit"
                        class="btn btn-primary w-40"
                        :disabled="form.processing"
                    >
                        <span
                            class="loading loading-bars loading-md"
                            v-if="form.processing"
                        ></span>
                        <span v-else>Submit</span>
                    </button>
                </div>

                <p class="text-primary">
                    Belum Punya Akun?
                    <Link
                        :href="route('register')"
                        class="underline font-semibold"
                        >Daftar Sekarang</Link
                    >
                </p>
            </form>
        </Card>
    </GuestLayout>
</template>
