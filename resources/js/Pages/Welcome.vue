<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome to CUKURYEE" />
    <div class="bg-yellow-400 min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">

        <div class="shape-1"></div>
        <div class="shape-2"></div>
        <div class="shape-3"></div>

        <div class="z-10 text-center text-black max-w-2xl">
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter title-animate">
                CUKUR<span class="text-white">YEE</span>.
            </h1>
            <p class="mt-4 text-lg md:text-xl font-semibold subtitle-animate">
                Potongan Terbaik, Tepat di Ujung Jari. Temukan barbershop favoritmu atau kelola bisnismu dengan mudah.
            </p>
        </div>

        <div v-if="canLogin" class="z-10 mt-12 flex space-x-4">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="btn-style bg-purple-500 text-white"
                >Dashboard</Link
            >
            <template v-else>
                <Link
                    :href="route('login')"
                    class="btn-style bg-white text-black"
                    >Log in</Link
                >
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="btn-style bg-black text-white"
                    >Register</Link
                >
            </template>
        </div>

    </div>
</template>

<style>
/* Import Font Keren (opsional, pastikan ada koneksi internet) */
@import url('https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;800;900&display=swap');

body {
    font-family: 'Inter', sans-serif;
}

h1 {
    font-family: 'Anton', sans-serif;
}

.btn-style {
    display: inline-block;
    padding: 1rem 2.5rem;
    font-weight: 800;
    text-transform: uppercase;
    border: 3px solid black;
    box-shadow: 6px 6px 0 0 #000;
    transition: all 0.2s ease-in-out;
}

.btn-style:hover {
    box-shadow: 3px 3px 0 0 #000;
    transform: translate(3px, 3px);
}

/* Animasi untuk Judul dan Subjudul */
.title-animate {
    animation: slide-in-down 0.8s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}
.subtitle-animate {
    animation: slide-in-up 0.8s cubic-bezier(0.250, 0.460, 0.450, 0.940) 0.2s both;
}

/* Animasi untuk Background */
.shape-1, .shape-2, .shape-3 {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.05);
    border-radius: 20%;
    animation: float 20s infinite linear;
}
.shape-1 {
    width: 300px;
    height: 300px;
    top: -50px;
    left: -80px;
}
.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -50px;
    right: -50px;
    animation-delay: 5s;
    animation-duration: 25s;
}
.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    right: 10%;
    animation-delay: 2s;
    animation-duration: 15s;
}

/* Keyframes Animasi */
@keyframes slide-in-down {
  0% { transform: translateY(-100px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}
@keyframes slide-in-up {
  0% { transform: translateY(100px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}
@keyframes float {
    0% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
    100% { transform: translateY(0) rotate(360deg); }
}
</style>
