<script setup lang="js">
import Card from '@/Components/Card.vue';
import DustSensor from '@/Components/iot/DustSensor.vue';
import TemperatureAndHumiditySensor from '@/Components/iot/TemperatureAndHumiditySensor.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const { props } = usePage();
</script>

<template>

    <Head title="Dashboard" />
    <UserLayout>
        <div class="flex flex-col justify-center items-center p-0 sm:p-4 lg:p-20">
            <Card class="w-full" custom-padding="p-4 sm:p-4 lg:p-8">
                <div class="flex w-full justify-between sm:justify-center items-end gap-4 px-2">
                    <TemperatureAndHumiditySensor />
                    <div class="flex flex-col sm:flex-row gap-2">
                        <DustSensor name="Sensor Debu 1" />
                        <DustSensor name="Sensor Debu 2" />
                    </div>
                </div>
            </Card>
        </div>
    </UserLayout>
</template>
