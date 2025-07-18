<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    bookings: Array,
});

// Helper untuk format tanggal
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Helper untuk status style
const statusClass = (status) => {
    if (status === 'completed') return 'bg-green-100 text-green-800';
    if (status === 'cancelled') return 'bg-red-100 text-red-800';
    return 'bg-yellow-100 text-yellow-800'; // pending, confirmed
};
</script>
<template>
    <Head title="Booking Saya" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Riwayat Booking Saya</h2>
        </template>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                 <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-200 text-green-800 border-2 border-green-800 p-4 font-bold">
                    {{ $page.props.flash.success }}
                </div>
                 <div v-if="$page.props.flash && $page.props.flash.error" class="mb-6 bg-red-200 text-red-800 border-2 border-red-800 p-4 font-bold">
                    {{ $page.props.flash.error }}
                </div>

                <div class="space-y-6">
                    <div
                        v-for="(booking, index) in bookings"
                        :key="booking.id"
                        v-motion
                        :initial="{ opacity: 0, y: 50 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 500, delay: index * 100 } }"
                        class="bg-white border-2 border-black p-6 shadow-[8px_8px_0_0_#000]"
                    >
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-sm text-gray-500">Booking di</div>
                                <div class="font-black text-2xl">{{ booking.mitra_profile.barbershop_name }}</div>
                            </div>
                            <div :class="statusClass(booking.status)" class="text-xs font-bold uppercase px-2 py-1">
                                {{ booking.status }}
                            </div>
                        </div>
                        <div class="mt-4 border-t-2 border-dashed border-black pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Jadwal:</span>
                                <span class="font-bold">{{ formatDate(booking.booking_time) }}</span>
                            </div>
                             <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Layanan:</span>
                                <span class="font-bold">{{ booking.service.name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Harga:</span>
                                <span class="font-bold">Rp {{ booking.total_price.toLocaleString('id-ID') }}</span>
                            </div>
                        </div>
                        <div v-if="booking.status === 'pending' || booking.status === 'confirmed'" class="mt-4 pt-4 border-t border-gray-200 text-right">
                            <Link
                                :href="route('my-bookings.cancel', booking.id)"
                                method="patch"
                                as="button"
                                class="text-xs text-red-700 font-bold hover:underline"
                                onbeforeunload="return confirm('Anda yakin ingin membatalkan booking ini?');"
                                preserve-scroll
                            >
                                Batalkan Booking
                            </Link>
                        </div>
                    </div>
                     <div v-if="bookings.length === 0" class="text-center py-20 text-gray-500">
                        <p class="text-xl font-bold">Anda belum punya riwayat booking.</p>
                        <p>Ayo cari barbershop dan booking sekarang!</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>