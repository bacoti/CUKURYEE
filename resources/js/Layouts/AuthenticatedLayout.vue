<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b-4 border-black">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.role === 'admin'" :href="route('admin.mitra.index')" :active="route().current('admin.mitra.index')">
                                    Manajemen Mitra
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.role === 'mitra'" :href="route('mitra.services.index')" :active="route().current('mitra.services.*')">
                                    Layanan
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.role === 'mitra'" :href="route('mitra.schedule.index')" :active="route().current('mitra.schedule.index')">
                                    Jadwal
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.role === 'mitra'" :href="route('mitra.bookings.index')" :active="route().current('mitra.bookings.index')">
                                    Kelola Booking
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.role === 'customer'" :href="route('my-bookings.index')" :active="route().current('my-bookings.index')">
                                    Booking Saya
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border-2 border-black text-sm leading-4 font-bold rounded-none text-black bg-yellow-400 hover:bg-yellow-500 focus:outline-none transition ease-in-out duration-150 shadow-[4px_4px_0_0_#000] hover:shadow-none hover:translate-x-px hover:translate-y-px"
                                            >
                                                {{ $page.props.auth.user.name }}
                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profil Akun </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            </div>
                    </div>
                </div>
            </nav>

            <header class="bg-white shadow-[0_4px_0_0_#000]" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
