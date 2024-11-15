<script setup lang="js">
import Alert from '@/Components/Alert.vue';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/form/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const form = useForm({
    email: ''
})

const alertMessage = ref('')
const alertType = ref('')

const sendResetPassword = () => {
    form.post(route('forgot.password.request'), {
        onSuccess: (res) => {
            if (res.props.flash.success) {
                alertMessage.value = res.props.flash.success,
                    alertType.value = 'success'
            }
        },
        onError: (err) => {
            if (err.error) {
                alertMessage.value = err.error,
                    alertType.value = 'error'
            }
            form.reset('email')
        }
    })
}
</script>

<template>
    <GuestLayout>

        <Head title="Lupa Password" />

        <div class="absolute top-2">
            <Alert v-if="alertMessage" :message="alertMessage" :type="alertType"
                @update:message="alertMessage = $event" />
        </div>

        <Card class="max-w-sm">
            <h1 class="card-title">Lupa Password?</h1>
            <p>Tenang, kami akan kirimkan link reset password ke email anda.</p>
            <form @submit.prevent="sendResetPassword" class="flex justify-center items-center gap-2 pt-4">
                <TextInput :error="alertType == 'error' ? 'error' : ''" icon="pi-envelope" v-model="form.email"
                    placeholder="Email" :required="true" type="email" />
                <button class="btn btn-primary flex justify-center items-center" :disabled="form.processing">
                    <i v-if="!form.processing" class="pi pi-send" style="font-size: 1.2rem"></i>
                    <span v-else class="loading loading-bars loading-sm"></span>
                </button>
            </form>
            <Link :href="route('login')" class="pt-4 text-sm underline text-secondary">kembali ke login</Link>
        </Card>
    </GuestLayout>
</template>