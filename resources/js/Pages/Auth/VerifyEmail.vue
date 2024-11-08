<script setup lang="js">
import AlertError from '@/Components/alerts/AlertError.vue';
import AlertInfo from '@/Components/alerts/AlertInfo.vue';
import AlertSuccess from '@/Components/alerts/AlertSuccess.vue';
import Card from '@/Components/Card.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

// Mengambil data dari props
const { props } = usePage();
console.log(props);


// Status tombol dan countdown
const isDisabled = ref(false);
const countdown = ref(0);

const infoMessage = ref(null)
const successMessage = ref(null)
const errorMessage = ref(null)

// Fungsi untuk mengirim ulang email verifikasi
const sendEmailRequest = () => {
    isDisabled.value = true;
    countdown.value = 60;

    const interval = setInterval(() => {
        countdown.value--;
        if (countdown.value <= 0) {
            clearInterval(interval);
            isDisabled.value = false;
        }
    }, 1000);

    // Mengirim POST request
    router.post(route('verify.email.send'), {}, {
        onError: () => {
            isDisabled.value = false;
            countdown.value = 0;
        },
        onSuccess: (res) => {
            if (res.props.flash.info) {
                infoMessage.value = res.props.flash.info
            }
            if (res.props.flash.success) {
                successMessage.value = res.props.flash.success
            }
            if (res.props.flash.error) {
                errorMessage.value = res.props.flash.error
            }
        }
    });
};
</script>

<template>

    <Head title="Verify Email" />

    <GuestLayout>
        <AlertSuccess v-if="props.flash.success || successMessage" :message="props.flash.success || successMessage" />
        <AlertInfo v-if="props.flash.info || infoMessage" :message="props.flash.info || infoMessage" />
        <AlertError v-if="props.flash.error || errorMessage" :message="props.flash.error || errorMessage" />

        <Card>
            <h1 class="card-title">Verifikasi Email Anda</h1>
            <p class="text-sm">Mohon periksa kotak masuk email Anda. Jika belum menerima email, Anda dapat mengirim
                ulang verifikasi.</p>

            <button class="btn btn-primary mt-4" @click="sendEmailRequest" :disabled="isDisabled">
                <span v-if="isDisabled">Kirim ulang dalam {{ countdown }} detik</span>
                <span v-else>Kirim Ulang Verifikasi Email</span>
            </button>
        </Card>
    </GuestLayout>
</template>
