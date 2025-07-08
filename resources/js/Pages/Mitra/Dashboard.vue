<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Menerima data 'mitra' dan 'services' yang dikirim dari DashboardController
const props = defineProps({
    mitra: Object,
    services: Array,
});
</script>

<template>
    <Head title="Mitra Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mitra Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-black p-6 shadow-[8px_8px_0_0_#000] mb-8 transition-all hover:shadow-[4px_4px_0_0_#000]">
                    <h3 class="text-2xl font-bold text-black mb-2">{{ mitra.barbershop_name }}</h3>
                    <p class="text-gray-600">{{ mitra.address }}, {{ mitra.city }}</p>
                    <p class="mt-4 text-gray-800">{{ mitra.description }}</p>
                </div>

                <div class="bg-white border-2 border-black p-6 shadow-[8px_8px_0_0_#000]">
                    <div class="flex justify-between items-center mb-4">
                         <h3 class="text-xl font-bold text-black">Layanan Kami</h3>
                         <button class="bg-yellow-400 text-black font-bold py-2 px-4 border-2 border-black shadow-[4px_4px_0_0_#000] hover:shadow-none transition-all">
                            Tambah Layanan
                         </button>
                    </div>

                    <div class="space-y-4">
                        <div v-for="service in services" :key="service.id" class="flex justify-between items-center p-4 border border-gray-300">
                            <div>
                                <p class="font-bold">{{ service.name }}</p>
                                <p class="text-sm text-gray-500">{{ service.duration_minutes }} menit</p>
                            </div>
                            <p class="font-bold text-lg">Rp {{ service.price.toLocaleString('id-ID') }}</p>
                        </div>

                        <div v-if="services.length === 0" class="text-center py-8 text-gray-500">
                            Kamu belum memiliki layanan. Ayo tambahkan sekarang!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>