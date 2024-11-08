<script setup lang="js">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/form/TextInput.vue";
import Card from "@/Components/Card.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const submitForm = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        }
    });
};
</script>

<template>

    <Head title="Register" />

    <AuthLayout>
        <Card :transparent="true">
            <form @submit.prevent="submitForm" class="flex flex-col justify-center items-center gap-5">
                <h1 class="card-title">Register</h1>

                <TextInput v-model="form.name" placeholder="Username" type="text" icon="pi-user"
                    :error="form.errors.name" :required="true" :show-error-message="true" />

                <TextInput v-model="form.email" placeholder="Email" type="email" icon="pi-envelope"
                    :error="form.errors.email" :required="true" :show-error-message="true" />

                <TextInput v-model="form.password" placeholder="Password" type="password" icon="pi-lock"
                    :error="form.errors.password" :required="true" :show-error-message="true" />

                <TextInput v-model="form.password_confirmation" placeholder="Confirm Password" type="password"
                    icon="pi-lock" :error="form.errors.password_confirmation" :required="true"
                    :show-error-message="true" />

                <div class="w-full flex items-center justify-center mt-4">
                    <button type="submit" class="btn btn-primary w-40" :disabled="form.processing">
                        <span class="loading loading-bars loading-md" v-if="form.processing"></span>
                        <span v-else>Submit</span>
                    </button>
                </div>

                <p class="text-primary">
                    Sudah Punya Akun?
                    <Link :href="route('login')" class="underline font-semibold">
                    Login
                    </Link>
                </p>
            </form>
        </Card>
    </AuthLayout>
</template>
