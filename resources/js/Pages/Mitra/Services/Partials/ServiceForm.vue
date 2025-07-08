<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    service: {
        type: Object,
        default: () => ({
            name: '',
            description: '',
            price: '',
            duration_minutes: '',
        }),
    },
    isUpdating: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({ ...props.service });

const submit = () => {
    if (props.isUpdating) {
        form.put(route('mitra.services.update', props.service.id));
    } else {
        form.post(route('mitra.services.store'));
    }
};
</script>
<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Nama Layanan" />
            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mt-4">
            <InputLabel for="description" value="Deskripsi Singkat (Opsional)" />
            <textarea v-model="form.description" id="description" class="w-full mt-1 h-24 border-2 border-black focus:border-yellow-500 focus:ring-yellow-500 p-2"></textarea>
            <InputError class="mt-2" :message="form.errors.description" />
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div>
                <InputLabel for="price" value="Harga (Rp)" />
                <TextInput id="price" type="number" class="mt-1 block w-full" v-model="form.price" required />
                <InputError class="mt-2" :message="form.errors.price" />
            </div>
            <div>
                <InputLabel for="duration_minutes" value="Durasi (menit)" />
                <TextInput id="duration_minutes" type="number" class="mt-1 block w-full" v-model="form.duration_minutes" required />
                <InputError class="mt-2" :message="form.errors.duration_minutes" />
            </div>
        </div>
        <div class="flex items-center justify-end mt-6">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ isUpdating ? 'Update Layanan' : 'Simpan Layanan' }}
            </PrimaryButton>
        </div>
    </form>
</template>
