<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ServiceForm from './Partials/ServiceForm.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Tambah Layanan Baru" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Tambah Layanan Baru</h2>
        </template>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000]">
                    <ServiceForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
