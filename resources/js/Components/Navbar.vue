<script setup lang="js">
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';

const { url } = usePage();

const routeName = ref('');
const showMenus = ref(false);

// Menetapkan nama rute berdasarkan URL
switch (url) {
    case '/dashboard':
        routeName.value = 'dashboard';
        break;
    case '/notifications':
        routeName.value = 'notifications';
        break;
    case '/user-settings':
        routeName.value = 'settings';
        break;
}

const toogleMenu = () => {
    showMenus.value = !showMenus.value
}

onMounted(() => {
    const storedShowMenus = localStorage.getItem('showMenus');
    if (storedShowMenus !== null) {
        showMenus.value = JSON.parse(storedShowMenus);
    }
});

watch(showMenus, (newValue) => {
    localStorage.setItem('showMenus', JSON.stringify(newValue));
});
</script>

<template>
    <div class="navbar bg-base-300 md:bg-base-100 flex flex-col md:flex-row justify-between items-center md:px-20">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Sistem Monitoring Patung</a>
        </div>
        <div class="flex-none">
            <div class="md:hidden flex flex-col items-center justify-center w-full">
                <div class="flex justify-center items-center">
                    <label class="btn btn-ghost w-full swap swap-rotate">
                        <!-- Checkbox menggunakan v-model dengan isChecked -->
                        <input type="checkbox" class="hidden" :checked="showMenus" @change="toogleMenu" />

                        <!-- hamburger icon -->
                        <svg class="swap-off fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                            viewBox="0 0 512 512">
                            <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                        </svg>

                        <!-- close icon -->
                        <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                            viewBox="0 0 512 512">
                            <polygon
                                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
                        </svg>
                    </label>
                </div>
                <ul v-if="showMenus" class="flex flex-col justify-center items-center gap-4 text-sm md:hidden">
                    <li>
                        <Link :href="route('login')" :class="{ 'text-primary': routeName === 'dashboard' }">
                        Dashboard
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('notifications')" :class="{ 'text-primary': routeName === 'notifications' }">
                        Notifications
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('user-settings')" :class="{ 'text-primary': routeName === 'settings' }">
                        Settings
                        </Link>
                    </li>
                </ul>
            </div>

            <!-- Menu untuk desktop -->
            <ul class="md:flex justify-center items-center gap-4 text-sm hidden">
                <li>
                    <Link :href="route('login')" :class="{ 'text-primary': routeName === 'dashboard' }">
                    Dashboard
                    </Link>
                </li>
                <li>
                    <Link :href="route('notifications')" :class="{ 'text-primary': routeName === 'notifications' }">
                    Notifications
                    </Link>
                </li>
                <li>
                    <Link :href="route('user-settings')" :class="{ 'text-primary': routeName === 'settings' }">
                    Settings
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>
