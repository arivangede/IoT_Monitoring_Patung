<script setup lang="js">
import Alert from '@/Components/Alert.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';

const { props } = usePage();
console.log(props)

const state = reactive({
    logout_processing: false
})

// Function to handle logout
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
    <Head title="Dashboard" />
    <AdminLayout>
        <Alert :alert-data="props.flash" />

        <div class="w-full flex justify-center items-center">
            <h1>Ini dashboard ya</h1>

            <button
                class="btn btn-ghost"
                @click="handleLogout"
                :disabled="state.logout_processing"
            >
                <span
                    class="loading loading-bars loading-md"
                    v-if="state.logout_processing"
                ></span>
                <span v-else>Logout</span>
            </button>
        </div>
    </AdminLayout>
</template>
