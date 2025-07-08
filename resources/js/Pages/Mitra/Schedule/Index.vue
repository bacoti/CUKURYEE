<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    availabilities: Object,
});

const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

// Siapkan form dengan data dari props
const form = useForm({
    schedule: Object.values(props.availabilities).map(a => ({
        is_active: a.is_active || false,
        start_time: a.start_time ? a.start_time.substring(0, 5) : '09:00',
        end_time: a.end_time ? a.end_time.substring(0, 5) : '21:00',
    })),
});

const submit = () => {
    form.post(route('mitra.schedule.store'));
};
</script>
<template>
    <Head title="Atur Jadwal" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Atur Jadwal Mingguan</h2>
        </template>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-200 text-green-800 border-2 border-green-800 p-4 font-bold">
                    {{ $page.props.flash.success }}
                </div>
                <form @submit.prevent="submit" class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000]">
                    <div class="space-y-6">
                        <div v-for="(day, index) in form.schedule" :key="index" class="grid grid-cols-4 items-center gap-4 p-4 border border-gray-200">
                            <label class="font-bold col-span-1 flex items-center">
                                <input type="checkbox" v-model="day.is_active" class="mr-3 rounded border-2 border-black text-black shadow-sm focus:ring-yellow-500">
                                {{ days[index] }}
                            </label>
                            <div class="col-span-3 grid grid-cols-2 gap-4" :class="{'opacity-40': !day.is_active}">
                                <div>
                                    <label class="text-xs">Jam Buka</label>
                                    <input type="time" v-model="day.start_time" :disabled="!day.is_active" class="w-full mt-1 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2">
                                </div>
                                <div>
                                    <label class="text-xs">Jam Tutup</label>
                                    <input type="time" v-model="day.end_time" :disabled="!day.is_active" class="w-full mt-1 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 text-right">
                        <PrimaryButton :disabled="form.processing">Simpan Jadwal</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
