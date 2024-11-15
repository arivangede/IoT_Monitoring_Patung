<script setup lang="js">
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/form/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
    email: {
        type: String,
        required: true
    }
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: ''
})

const submit = () => {
    form.post(route('password.update'))
}
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />
        <Card class="max-w-sm">
            <h1 class="card-title">Atur Ulang Password</h1>
            <form @submit.prevent="submit" class="flex flex-col justify-center items-center gap-4 pt-4">
                <TextInput icon="pi-envelope" v-model="form.email" :disabled="true" />
                <TextInput :error="form.errors.password" :show-error-message="true" icon="pi-lock"
                    v-model="form.password" placeholder="New Password" :required="true" type="password" />
                <TextInput :error="form.errors.password" icon="pi-lock" v-model="form.password_confirmation"
                    placeholder="Confirm Password" :required="true" type="password" />

                <button class="btn btn-primary w-full" :disabled="form.processing">
                    <span v-if="!form.processing">Submit</span>
                    <span v-else class="loading loading-bars loading-md"></span>
                </button>
            </form>
        </Card>
    </GuestLayout>
</template>