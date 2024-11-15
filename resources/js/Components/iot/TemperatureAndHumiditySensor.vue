<template>
    <div class="card shadow-xl flex flex-col justify-center items-center gap-2">
        <h1 class="card-title text-sm text-center max-w-xs w-40 sm:w-auto">Temperatur dan Kelembaban</h1>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
            <div class="card bg-base-100 w-40">
                <div class="card-body flex flex-col justify-center items-center">
                    <span class="text-3xl">30ºC</span>
                    <span>Temperatur</span>
                </div>
            </div>
            <div class="card bg-base-100 w-40">
                <div class="card-body flex flex-col justify-center items-center">
                    <span class="text-3xl">90 RH</span>
                    <span>Kelembaban</span>
                </div>
            </div>
        </div>
    </div>
</template>