<script setup lang="ts">
import EmailCard from './EmailCard.vue';
</script>

<template>
    <div class="card bg-base-300 w-full shadow-xl">
        <div class="card-body">
            <h1 class="card-title">Daftar Penerima Notifikasi</h1>
            <div class="w-full flex flex-col p-4 gap-4">
                <div class="w-full flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                    <form class="flex flex-row items-center w-full">
                        <label class="w-full input input-bordered flex items-center gap-2 relative overflow-hidden">
                            <input type="text" class="grow border-none focus:ring-0 pr-10"
                                placeholder="Cari alamat email..." />
                            <button class="btn btn-secondary absolute right-0 rounded-none">
                                <i class="pi pi-search"></i>
                            </button>
                        </label>
                    </form>
                    <button class="btn btn-secondary">
                        <span>Tambah</span>
                        <i class="pi pi-plus"></i>
                    </button>
                </div>
                <div class="h-60 flex flex-col items-center gap-4 overflow-y-scroll overflow-x-clip">
                    <EmailCard />
                    <EmailCard />
                    <EmailCard />
                    <EmailCard />
                    <EmailCard />
                </div>
            </div>
        </div>
    </div>
</template>