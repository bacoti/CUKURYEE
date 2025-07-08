<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    service: Object,
});

const form = useForm({
    service_id: props.service.id,
    booking_date: '',
    booking_time: '',
});

const availableSlots = ref([]);
const isLoadingSlots = ref(false);

const fetchAvailableSlots = async (date) => {
    if (!date) return;
    isLoadingSlots.value = true;
    availableSlots.value = [];
    form.booking_time = '';
    try {
        const response = await axios.get(route('availability.show', {
            service: props.service.id,
            date: date
        }));
        availableSlots.value = response.data;
    } catch (error) {
        console.error("Gagal mengambil slot waktu:", error);
    } finally {
        isLoadingSlots.value = false;
    }
};

watch(() => form.booking_date, (newDate) => {
    fetchAvailableSlots(newDate);
});

const submit = () => {
    form.post(route('booking.store'));
};
</script>

<template>
    <Head title="Konfirmasi Booking" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Konfirmasi Booking</h2>
        </template>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000]">
                    <h3 class="text-2xl font-black border-b-2 border-black pb-4">Detail Pesanan Anda</h3>

                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Barbershop:</span>
                            <span class="font-bold">{{ service.mitra_profile.barbershop_name }}</span>
                        </div>
                            <div class="flex justify-between">
                            <span class="text-gray-500">Layanan:</span>
                            <span class="font-bold">{{ service.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Harga:</span>
                            <span class="font-bold">Rp {{ service.price.toLocaleString('id-ID') }}</span>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="mt-8">
                            <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="booking_date" value="Pilih Tanggal" />
                                <input type="date" id="booking_date" v-model="form.booking_date" class="mt-1 block w-full border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2" required>
                                <InputError class="mt-2" :message="form.errors.booking_date" />
                            </div>
                            <div>
                                <InputLabel for="booking_time" value="Pilih Jam" />
                                <select id="booking_time" v-model="form.booking_time" class="mt-1 block w-full border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2" required :disabled="isLoadingSlots || availableSlots.length === 0">
                                    <option v-if="isLoadingSlots" value="">Memuat slot...</option>
                                    <option v-else-if="!form.booking_date" value="">Pilih tanggal dulu</option>
                                    <option v-else-if="availableSlots.length === 0" value="">Tidak ada slot tersedia</option>
                                    <option v-for="slot in availableSlots" :key="slot" :value="slot">{{ slot }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.booking_time" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Konfirmasi Booking
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
