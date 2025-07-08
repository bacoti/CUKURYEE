<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-4 border-yellow-400 text-lg font-black text-black transition-all duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-4 border-transparent text-lg font-medium text-gray-500 hover:border-gray-300 hover:text-black focus:outline-none focus:text-gray-700 focus:border-gray-300 transition-all duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
