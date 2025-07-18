<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    barbershops: Array,
    cities: Array,
    filters: Object,
});

// State untuk form pencarian dan filter
const search = ref(props.filters.search);
const city = ref(props.filters.city);

// Gunakan watch dan debounce untuk mengirim request setelah user berhenti mengetik
watch([search, city], debounce(function ([newSearch, newCity]) {
    router.get(route('barbershops.index'), {
        search: newSearch,
        city: newCity,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));
</script>

<template>
    <Head title="Cari Barbershop" />
    <GuestLayout>
        <div class="p-6 max-w-7xl mx-auto">
            <h1 class="text-4xl font-black text-center mb-4">TEMUKAN GAYA ANDA</h1>

            <div class="mb-12 p-4 bg-white border-2 border-black shadow-[4px_4px_0_0_#000] flex flex-col md:flex-row gap-4">
                <input
                    type="text"
                    v-model="search"
                    placeholder="Cari nama barbershop..."
                    class="w-full md:w-2/3 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2"
                />
                <select
                    v-model="city"
                    class="w-full md:w-1/3 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2"
                >
                    <option value="">Semua Kota</option>
                    <option v-for="c in cities" :key="c" :value="c">{{ c }}</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="barber in barbershops" :key="barber.id">
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
                    <p class="text-xl font-bold">Yah, barbershop tidak ditemukan.</p>
                    <p>Coba cek lagi nanti atau ubah kata kunci pencarian Anda!</p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
