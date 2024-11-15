<script setup lang="js">
import Alert from '@/Components/Alert.vue';
import Card from '@/Components/Card.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// Status tombol dan countdown
const isDisabled = ref(false);
const isProcessing = ref(false)
const countdown = ref(0);

const alertMessage = ref('')
const alertType = ref('')

// Fungsi untuk mengirim ulang email verifikasi
const sendEmailRequest = () => {
    isDisabled.value = true;
    isProcessing.value = true;
    countdown.value = 60;

    // Mengirim POST request
    router.post(route('verify.email.send'), {}, {
        onError: (err) => {
            if (err.error) {
                alertMessage.value = err.error
                alertType.value = 'error'
            }
            isDisabled.value = false;
            isProcessing.value = false;
            countdown.value = 0;
        },
        onSuccess: (res) => {
            isProcessing.value = false

            if (res.props.flash.info) {
                alertMessage.value = res.props.flash.info
                alertType.value = 'info'
            }
            if (res.props.flash.success) {
                alertMessage.value = res.props.flash.success
                alertType.value = 'success'
            }

            const interval = setInterval(() => {
                countdown.value--;
                if (countdown.value <= 0) {
                    clearInterval(interval);
                    isDisabled.value = false;
                }
            }, 1000);
        }
    });
};

const backToLogin = () => {
    router.post('logout')
}
</script>

<template>

    <Head title="Verify Email" />

    <GuestLayout>
        <div class="absolute top-2">
            <Alert :message="alertMessage" :type="alertType" @update:message="alertMessage = $event" />
        </div>
        <Card class="max-w-sm">
            <h1 class="card-title">Verifikasi Email Anda</h1>
            <p class="text-sm">Mohon periksa kotak masuk email Anda. Jika belum menerima email, Anda dapat mengirim
                ulang verifikasi.</p>

            <button class="btn btn-primary mt-4" @click="sendEmailRequest" :disabled="isDisabled">
                <span v-if="isDisabled && !isProcessing">Kirim ulang dalam {{ countdown }} detik</span>
                <div v-else-if="isDisabled && isProcessing" class="flex justify-center items-center">
                    <p>Mengirim ulang verifikasi </p>
                    <span class="loading loading-spinner loading-md"></span>
                </div>

                <span v-else>Kirim Ulang Verifikasi Email</span>
            </button>
            <div class="w-full flex justify-start pt-4">
                <button @click.prevent="backToLogin" class="text-sm underline text-secondary">Logout dan kembali ke
                    Login</button>
            </div>
        </Card>
    </GuestLayout>
</template>
