<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
// Tidak perlu import apa-apa di sini, karena v-motion akan otomatis tersedia setelah instalasi

defineProps({
    barbershops: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
             <h2 class="font-bold text-2xl text-black leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.auth.user.role === 'mitra'" class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000]">
                    <h3 class="text-2xl font-bold">Selamat Datang Kembali, Mitra!</h3>
                    <p class="mt-2 text-gray-700">Ini adalah dashboard Anda. Gunakan menu navigasi di atas untuk mengelola layanan Anda.</p>
                </div>

                <div v-if="$page.props.auth.user.role === 'customer'">
                    <h2
                        v-motion
                        :initial="{ opacity: 0, y: -50 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 500, type: 'spring', stiffness: 100 } }"
                        class="text-3xl font-black text-center mb-8"
                    >
                        PILIH BARBERSHOP ANDALANMU
                    </h2>
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div
                            v-for="(barber, index) in barbershops"
                            :key="barber.id"
                            v-motion
                            :initial="{ opacity: 0, y: 50 }"
                            :enter="{ opacity: 1, y: 0, transition: { duration: 500, delay: index * 100 } }"
                        >
                            <Link :href="route('barbershops.show', barber.id)" class="block bg-white border-2 border-black p-6 shadow-[8px_8px_0_0_#000] hover:shadow-[4px_4px_0_0_#000] hover:translate-x-px hover:translate-y-px transition-all h-full">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
