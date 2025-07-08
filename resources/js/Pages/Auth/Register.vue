<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'customer', // Nilai default role adalah 'customer'
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel value="Daftar Sebagai" />
                <div class="mt-2 flex w-full border-2 border-black font-bold">
                    <button
                        type="button"
                        @click="form.role = 'customer'"
                        :class="[
                            'w-1/2 p-3 text-center transition-all duration-200',
                            form.role === 'customer' ? 'bg-yellow-400 text-black' : 'bg-white text-gray-500'
                        ]"
                    >
                        PELANGGAN
                    </button>
                    <button
                        type="button"
                        @click="form.role = 'mitra'"
                        :class="[
                            'w-1/2 p-3 text-center transition-all duration-200',
                            form.role === 'mitra' ? 'bg-yellow-400 text-black' : 'bg-white text-gray-500' 
                        ]"
                    >
                        MITRA
                    </button>
                </div>
            </div>

            <div class="mt-4">
                <InputLabel for="name" value="Nama Lengkap" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Konfirmasi Password" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    REGISTER
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
