<script setup lang="js">
import { ref, computed } from 'vue';
import formatDate from '@/utils/formatDate';
import formatNumber from '@/utils/formatNumber';

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    data: {
        type: Array,
        required: true
    },
    hideTime: {
        type: Boolean,
        default: false
    }
});

// Konfigurasi paginasi
const itemsPerPage = 10;
const currentPage = ref(1);

// Total halaman
const totalPages = computed(() => {
    return Math.ceil(props.data.length / itemsPerPage);
});

// Data yang ditampilkan pada halaman saat ini
const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.data.slice(start, end);
});

// Fungsi untuk ke halaman berikutnya
const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value += 1;
    }
};

// Fungsi untuk ke halaman sebelumnya
const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value -= 1;
    }
};
</script>

<template>
    <div class="overflow-x-auto w-full max-w-xs sm:max-w-none">
        <table class="table table-zebra ">
            <thead>
                <tr>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Dust_1</th>
                    <th>Dust_2</th>
                    <th>DateTime</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="!loading && paginatedData.length > 0">
                    <tr v-for="(item, index) in paginatedData" :key="index">
                        <td>{{ formatNumber(item.temperature) }}</td>
                        <td>{{ formatNumber(item.humidity) }}</td>
                        <td>{{ formatNumber(item.dust_1) }}</td>
                        <td>{{ formatNumber(item.dust_2) }}</td>
                        <td>{{ formatDate(item.time_group, hideTime ? "D MMM YYYY" : "D MMM YYYY HH:mm:ss") }}</td>
                    </tr>
                </template>
                <template v-else-if="!loading && props.data.length == 0">
                    <tr>
                        <td colspan="5">
                            <div class="w-full flex justify-center items-center">
                                <span>Belum ada data sensor</span>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-else>
                    <tr>
                        <td colspan="5">
                            <div class="w-full flex justify-center items-center">
                                <span class="loading loading-bars loading-md"></span>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-4">
        <button class="btn btn-secondary" :disabled="currentPage === 1" @click="prevPage">
            Previous
        </button>
        <div class="text-center">
            Page {{ currentPage }} of {{ totalPages }}
        </div>
        <button class="btn btn-secondary" :disabled="currentPage === totalPages" @click="nextPage">
            Next
        </button>
    </div>
</template>
