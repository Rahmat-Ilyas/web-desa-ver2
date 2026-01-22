<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    villageName: String
});
</script>

<template>
    <div class="relative bg-gray-900 border-b border-gray-800 h-[85vh] overflow-hidden group">
        <!-- Video Container -->
        <div class="absolute inset-0 w-full h-full">
            <video class="w-full h-full object-cover object-top" autoplay muted loop playsinline>
                <source src="/assets/bg.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Gradient Overlay & Content -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-gray-900/30"></div>

        <div
            class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center justify-center h-full">
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-6 drop-shadow-2xl opacity-0 animate-fade-in-up"
                style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-blue-900/40 border border-blue-500/30 backdrop-blur-md mb-6">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-blue-100 font-bold tracking-widest uppercase text-sm">Portal Resmi
                        Pemerintahan</span>
                </div>
                <span class="block text-3xl md:text-5xl lg:text-6xl text-white">Pelayanan Profesional & Inovatif,</span>
                <span class="text-2xl md:text-4xl lg:text-5xl font-medium mt-2 text-white/90">Mewujudkan Masyarakat
                    Peduli</span>
            </h1>
            <p class="max-w-2xl text-lg md:text-xl text-gray-200 font-light mb-10 drop-shadow-md opacity-0 animate-fade-in-up"
                style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                Selamat datang di platform digital <span class="font-semibold text-white">{{ villageName }}</span>.
                Pusat informasi terkini dan layanan administrasi terpadu untuk warga masyarakat.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 opacity-0 animate-fade-in-up"
                style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                <Link :href="route('pengaduan')"
                    class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 md:text-lg transition-all duration-300 shadow-[0_10px_20px_-10px_rgba(37,99,235,0.5)] hover:shadow-[0_20px_25px_-5px_rgba(37,99,235,0.4)] hover:-translate-y-1">
                    <i class="fas fa-bullhorn mr-2"></i> Pengaduan Warga
                </Link>
                <Link :href="route('layanan')"
                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/20 hover:border-white text-base font-bold rounded-full text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm md:text-lg transition-all duration-300 hover:-translate-y-1">
                    Layanan Kami
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 1s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
