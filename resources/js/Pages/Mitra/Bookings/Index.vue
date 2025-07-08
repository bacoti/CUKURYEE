<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    bookings: Array,
});

// Helper untuk format tanggal
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Fungsi untuk mengubah status
const updateStatus = (bookingId, newStatus) => {
    const form = useForm({
        status: newStatus,
    });
    form.patch(route('mitra.bookings.updateStatus', bookingId), {
        preserveScroll: true, // Agar halaman tidak scroll ke atas
    });
};
</script>

<template>
    <Head title="Kelola Booking" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Kelola Booking Masuk</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-200 text-green-800 border-2 border-green-800 p-4 font-bold">
                    {{ $page.props.flash.success }}
                </div>

                <div class="bg-white border-2 border-black shadow-[8px_8px_0_0_#000] overflow-hidden">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-black">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Pelanggan & Jadwal</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-black text-black uppercase tracking-wider">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="booking in bookings" :key="booking.id" class="border-b border-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-black">{{ booking.customer.name }}</div>
                                    <div class="text-xs text-gray-500">{{ formatDate(booking.booking_time) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ booking.service.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold" :class="{
                                    'text-yellow-600': booking.status === 'pending',
                                    'text-blue-600': booking.status === 'confirmed',
                                    'text-green-600': booking.status === 'completed',
                                    'text-red-600': booking.status === 'cancelled',
                                }">{{ booking.status.toUpperCase() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-1">
                                    <button @click="updateStatus(booking.id, 'confirmed')" class="text-xs bg-blue-100 text-blue-800 font-bold py-1 px-2 border border-blue-800 hover:bg-blue-200">Confirm</button>
                                    <button @click="updateStatus(booking.id, 'completed')" class="text-xs bg-green-100 text-green-800 font-bold py-1 px-2 border border-green-800 hover:bg-green-200">Complete</button>
                                    <button @click="updateStatus(booking.id, 'cancelled')" class="text-xs bg-red-100 text-red-800 font-bold py-1 px-2 border border-red-800 hover:bg-red-200">Cancel</button>
                                </td>
                            </tr>
                            <tr v-if="bookings.length === 0">
                                <td colspan="4" class="text-center py-12 text-gray-500">Belum ada booking yang masuk.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
