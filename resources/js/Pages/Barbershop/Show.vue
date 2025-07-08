<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    barbershop: Object,
});
</script>

<template>
    <Head :title="barbershop.barbershop_name" />
    <GuestLayout>
        <div class="p-6 max-w-4xl mx-auto">
            <div
                v-motion
                :initial="{ opacity: 0, y: -50 }"
                :enter="{ opacity: 1, y: 0, transition: { duration: 500 } }"
                class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000] text-center"
            >
                <h1 class="text-4xl font-black">{{ barbershop.barbershop_name }}</h1>
                <p class="mt-2 text-lg text-gray-700">{{ barbershop.address }}, {{ barbershop.city }}</p>
                <p class="mt-4 text-gray-600">{{ barbershop.description }}</p>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-center mb-6">DAFTAR LAYANAN</h2>
                <div class="space-y-4">
                    <div
                        v-for="(service, index) in barbershop.services"
                        :key="service.id"
                        v-motion
                        :initial="{ opacity: 0, y: 50 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 500, delay: index * 100 } }"
                        class="bg-white border-2 border-black p-4 flex justify-between items-center transition-all hover:shadow-[4px_4px_0_0_#000]"
                    >
                        <div>
                            <div class="font-bold text-lg">{{ service.name }}</div>
                            <div class="text-sm text-gray-500">{{ service.duration_minutes }} menit</div>
                        </div>
                        <div class="text-right">
                             <div class="font-bold text-xl">Rp {{ service.price.toLocaleString('id-ID') }}</div>
                             <Link :href="route('booking.create', service.id)" class="mt-1 inline-block text-xs text-black bg-yellow-400 font-bold py-1 px-3 border border-black hover:bg-yellow-500">
                                BOOK
                             </Link>
                        </div>
                    </div>
                     <div v-if="barbershop.services.length === 0" class="text-center py-12 text-gray-500">
                        Mitra ini belum menambahkan layanan.
                    </div>
                </div>
                 <div class="text-center mt-8">
                    <Link :href="route('barbershops.index')" class="text-sm font-bold hover:underline">&larr; Kembali ke daftar barbershop</Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
