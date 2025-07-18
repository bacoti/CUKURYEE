<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    mitraProfile: Object,
});

const form = useForm({
    barbershop_name: props.mitraProfile.barbershop_name,
    address: props.mitraProfile.address,
    city: props.mitraProfile.city,
    phone_number: props.mitraProfile.phone_number,
    description: props.mitraProfile.description,
});

const submit = () => {
    form.patch(route('mitra.profile.update'));
};
</script>

<template>
    <Head title="Edit Profil Barbershop" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-black leading-tight">Edit Profil Barbershop</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-200 text-green-800 border-2 border-green-800 p-4 font-bold">
                    {{ $page.props.flash.success }}
                </div>

                <div class="bg-white border-2 border-black p-8 shadow-[8px_8px_0_0_#000]">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="barbershop_name" value="Nama Barbershop" />
                            <TextInput id="barbershop_name" type="text" class="mt-1 block w-full" v-model="form.barbershop_name" required />
                            <InputError class="mt-2" :message="form.errors.barbershop_name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="address" value="Alamat Lengkap" />
                            <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="city" value="Kota" />
                            <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" required />
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="phone_number" value="Nomor Telepon Aktif" />
                            <TextInput id="phone_number" type="tel" class="mt-1 block w-full" v-model="form.phone_number" required />
                            <InputError class="mt-2" :message="form.errors.phone_number" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Deskripsi Singkat (Opsional)" />
                            <textarea v-model="form.description" id="description" class="w-full mt-1 h-24 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2 transition-all duration-200"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Simpan Perubahan
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
