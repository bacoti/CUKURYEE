<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    services: Array,
});
</script>

<template>
    <Head title="Kelola Layanan" />

    <AuthenticatedLayout>
        <template #header>
            <div
                v-motion
                :initial="{ opacity: 0, y: -20 }"
                :enter="{ opacity: 1, y: 0, transition: { duration: 400 } }"
                class="flex justify-between items-center"
            >
                <h2 class="font-bold text-2xl text-black leading-tight">Kelola Layanan</h2>
                <Link :href="route('mitra.services.create')" class="inline-flex items-center px-4 py-2 bg-yellow-400 border-2 border-black text-black font-bold text-xs uppercase tracking-widest shadow-[4px_4px_0_0_#000] hover:shadow-none hover:translate-x-px hover:translate-y-px transition-all">
                    + Tambah Layanan
                </Link>
            </div>
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
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Nama Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-right text-xs font-black text-black uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(service, index) in services"
                                :key="service.id"
                                v-motion
                                :initial="{ opacity: 0, y: 20 }"
                                :enter="{ opacity: 1, y: 0, transition: { duration: 500, delay: index * 50 } }"
                                class="border-b border-gray-200"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-black">{{ service.name }}</div>
                                    <div class="text-xs text-gray-500">{{ service.description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Rp {{ service.price.toLocaleString('id-ID') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ service.duration_minutes }} menit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <Link :href="route('mitra.services.edit', service.id)" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</Link>
                                    <Link :href="route('mitra.services.destroy', service.id)" method="delete" as="button" class="text-red-600 hover:text-red-900 font-bold" onbeforeunload="return confirm('Anda yakin ingin menghapus layanan ini?');" preserve-scroll>Hapus</Link>
                                </td>
                            </tr>
                            <tr v-if="services.length === 0">
                                <td colspan="4" class="text-center py-12 text-gray-500">Anda belum memiliki layanan. Silakan tambah layanan baru.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
