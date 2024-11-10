<script setup lang="js">
import Alert from "@/Components/Alert.vue";
import Card from "@/Components/Card.vue";
import TextInput from "@/Components/form/TextInput.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const { props } = usePage()

const form = useForm({
    email: "",
    password: ''
})

const alertMessage = ref(props.flash.success || '')
const alertType = ref(props.flash.success ? 'success' : '')

const submitForm = () => {
    form.post(route('login'), {
        onSuccess: (res) => {
            if (res.props.flash.success) {
                alertMessage.value = res.props.flash.success
                alertType.value = 'success'
            }
        },
        onError: (err) => {
            if (err.error) {
                alertMessage.value = err.error
                alertType.value = 'error'
            }
            form.reset('password')
        }
    })
}

</script>

<template>

    <Head title="Login" />
    <AuthLayout>
        <Alert :message="alertMessage" :type="alertType" @update:message="alertMessage = $event" />
        <Card :transparent="true">
            <form @submit.prevent="submitForm" class="flex flex-col justify-center items-center gap-5">
                <h1 class="card-title">Login</h1>

                <TextInput type="email" icon="pi-envelope" v-model="form.email" placeholder="Email"
                    :error="form.errors.error" :required="true" />
                <TextInput type="password" icon="pi-lock" v-model="form.password" placeholder="Password"
                    :error="form.errors.error" :required="true" />
                <div class="w-full flex justify-end items-center">
                    <Link :href="route('forgot.password.index')" class="text-xs text-secondary underline">Lupa Password?
                    </Link>
                </div>

                <div class="w-full flex items-center justify-center mt-4">
                    <button type="submit" class="btn btn-primary w-40" :disabled="form.processing">
                        <span class="loading loading-bars loading-md" v-if="form.processing"></span>
                        <span v-else>Submit</span>
                    </button>
                </div>

                <p class="text-primary">
                    Belum Punya Akun?
                    <Link :href="route('register')" class="underline font-semibold">Daftar Sekarang</Link>
                </p>
            </form>
        </Card>
    </AuthLayout>
</template>
