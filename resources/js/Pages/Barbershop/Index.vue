<script setup>
import { Head, Link } from '@inertiajs/vue3';
// Kita akan gunakan GuestLayout agar bisa diakses siapa saja
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    barbershops: Array,
});
</script>

<template>
    <Head title="Cari Barbershop" />
    <GuestLayout>
        <div class="p-6">
            <h1 class="text-4xl font-black text-center mb-12">TEMUKAN GAYA ANDA</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="barber in barbershops" :key="barber.id">
                    <Link :href="route('barbershops.show', barber.id)" class="block bg-white border-2 border-black p-6 shadow-[8px_8px_0_0_#000] hover:shadow-[4px_4px_0_0_#000] hover:translate-x-px hover:translate-y-px transition-all">
                        <div class="font-bold text-2xl truncate">{{ barber.barbershop_name }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ barber.city }}</div>
                        <p class="mt-4 text-sm h-16 overflow-hidden">
                            {{ barber.description }}
                        </p>
                        <div class="mt-4 text-right font-bold text-yellow-500">
                            Lihat Detail &rarr;
                        </div>
                    </Link>
                </div>

                <div v-if="barbershops.length === 0" class="col-span-full text-center py-20 text-gray-500">
                    <p class="text-xl font-bold">Yah, belum ada mitra barbershop.</p>
                    <p>Coba cek lagi nanti ya!</p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
