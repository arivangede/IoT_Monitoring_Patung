<script setup lang="js">
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const { url } = usePage()

const routeName = ref('')

switch (url) {
    case '/dashboard':
        routeName.value = 'dashboard'
        break
    case '/notifications':
        routeName.value = 'notifications'
        break
    case '/user-settings':
        routeName.value = 'settings'
        break
}
</script>

<template>
    <div className="navbar bg-base-100">
        <div className="flex-1">
            <a className="btn btn-ghost text-xl">Sistem Monitoring Patung</a>
        </div>
        <div className="flex-none">
            <ul className="menu menu-horizontal px-1">
                <li>
                    <Link :href="route('login')" :class="`${routeName == 'dashboard' && 'text-primary'}`">
                    Dashboard
                    </Link>
                </li>
                <li>
                    <Link :href="route('notifications')" :class="`${routeName == 'notifications' && 'text-primary'}`">
                    Notifications
                    </Link>
                </li>
                <li>
                    <Link :href="route('user-settings')" :class="`${routeName == 'settings' && 'text-primary'}`">
                    Settings
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>