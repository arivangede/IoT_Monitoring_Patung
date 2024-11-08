<script setup lang="js">
import Navbar from '@/Components/Navbar.vue';


</script>

<template>
    <div class="min-h-screen w-full flex flex-col items-center">
        <Navbar />
        <slot />
    </div>
</template>
