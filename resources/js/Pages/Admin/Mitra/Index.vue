<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    mitra: Array,
});
</script>

<template>
    <Head title="Manajemen Mitra" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                v-motion
                :initial="{ opacity: 0, y: -20 }"
                :enter="{ opacity: 1, y: 0, transition: { duration: 400 } }"
                class="font-bold text-2xl text-black leading-tight"
            >
                Manajemen Mitra
            </h2>
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
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Nama Barbershop</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-black text-black uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-black text-black uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(m, index) in mitra"
                                :key="m.id"
                                v-motion
                                :initial="{ opacity: 0, y: 20 }"
                                :enter="{ opacity: 1, y: 0, transition: { duration: 500, delay: index * 50 } }"
                                class="border-b border-gray-200"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-black">{{ m.barbershop_name }}</div>
                                    <div class="text-xs text-gray-500">{{ m.city }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ m.user.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="m.is_verified" class="text-xs font-bold uppercase px-2 py-1 bg-green-200 text-green-800">Verified</span>
                                    <span v-else class="text-xs font-bold uppercase px-2 py-1 bg-yellow-200 text-yellow-800">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <Link v-if="!m.is_verified" :href="route('admin.mitra.verify', m.id)" method="patch" as="button" class="text-blue-600 hover:text-blue-900 font-bold" preserve-scroll>Setujui</Link>
                                    <Link :href="route('admin.mitra.destroy', m.id)" method="delete" as="button" class="text-red-600 hover:text-red-900 font-bold" onbeforeunload="return confirm('Anda yakin ingin menolak & menghapus mitra ini?');" preserve-scroll>Tolak</Link>
                                </td>
                            </tr>
                            <tr v-if="mitra.length === 0">
                                <td colspan="4" class="text-center py-12 text-gray-500">Tidak ada mitra yang mendaftar.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
