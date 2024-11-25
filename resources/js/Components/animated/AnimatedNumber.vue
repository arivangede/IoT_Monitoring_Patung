<script setup lang="js">
import { ref, watch, onMounted } from 'vue';
import anime from 'animejs';

const props = defineProps({
    value: {
        type: Number,
        required: true
    },
    duration: {
        type: Number,
        default: 1000
    },
    uom: {
        type: String,
        default: ''
    }
});

// Ref untuk menyimpan nilai yang dianimasikan
const animatedValue = ref(0);

// Fungsi untuk melakukan animasi pada angka
const animateNumber = (targetValue) => {
    anime({
        targets: animatedValue,
        value: targetValue,
        easing: 'easeInOutQuad',
        duration: props.duration,
        round: 10, // Membulatkan angka
    });
};

// Watcher untuk mendeteksi perubahan nilai
watch(() => props.value, (newValue) => {
    animateNumber(newValue);
});

// Inisialisasi animasi saat komponen pertama kali dipasang
onMounted(() => {
    animateNumber(props.value);
});
</script>
<template>
    <span class="text-xl md:text-3xl font-semibold">{{ animatedValue }}{{ uom }}</span>
</template>