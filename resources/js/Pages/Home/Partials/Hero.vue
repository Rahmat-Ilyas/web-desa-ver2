<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';


const page = usePage();
const settings = computed(() => page.props.settings);

// Slider logic
const currentSlide = ref(0);
let slideInterval = null;

const startSlider = () => {
    if (slideInterval) clearInterval(slideInterval);
    if (settings.value?.hero_bg_type === 'slider' && settings.value?.hero_slider?.length > 0) {
        slideInterval = setInterval(() => {
            currentSlide.value = (currentSlide.value + 1) % settings.value.hero_slider.length;
        }, 5000);
    }
};

watch(() => settings.value?.hero_slider, () => {
    currentSlide.value = 0;
    startSlider();
}, { deep: true });

onMounted(() => {
    startSlider();
});

onUnmounted(() => {
    if (slideInterval) clearInterval(slideInterval);
});
</script>

<template>
    <div class="relative bg-gray-900 border-b border-gray-800 h-[85vh] overflow-hidden group">

        <!-- Background: Video -->
        <div v-if="(settings?.hero_bg_type || 'video') === 'video'" class="absolute inset-0 w-full h-full">
            <video class="w-full h-full object-cover object-top" autoplay muted loop playsinline
                :key="settings?.hero_video || '/assets/bg.mp4'">
                <source :src="settings?.hero_video || '/assets/bg.mp4'" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Background: Slider -->
        <div v-else-if="settings?.hero_bg_type === 'slider'" class="absolute inset-0 w-full h-full">
            <template v-if="settings?.hero_slider?.length">
                <transition-group name="fade">
                    <div v-for="(img, idx) in settings.hero_slider" :key="idx" v-show="currentSlide === idx"
                        class="absolute inset-0 w-full h-full bg-cover bg-center transition-transform duration-[10000ms] scale-110"
                        :class="{ 'scale-100': currentSlide === idx }" :style="{ backgroundImage: `url(${img})` }">
                    </div>
                </transition-group>
            </template>
            <div v-else
                class="absolute inset-0 bg-slate-800 flex items-center justify-center text-white/20 font-black text-4xl uppercase tracking-widest">
                No Images Uploaded
            </div>
        </div>

        <!-- Gradient Overlay & Content -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-gray-900/30"></div>

        <div
            class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center justify-center h-full">

            <div class="opacity-0 animate-fade-in-up" style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-blue-900/40 border border-blue-500/30 backdrop-blur-md mb-8">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-blue-100 font-bold tracking-widest uppercase text-xs sm:text-sm">Portal Resmi
                        Pemerintahan</span>
                </div>
            </div>

            <h1 class="text-white drop-shadow-2xl opacity-0 animate-fade-in-up"
                style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                <span class="block text-3xl md:text-5xl lg:text-6xl font-black mb-2 uppercase tracking-tight">
                    {{ settings?.hero_title || 'Pelayanan Profesional & Inovatif' }}
                </span>
                <span class="text-xl md:text-3xl lg:text-4xl font-bold text-white/80">
                    {{ settings?.hero_subtitle || 'Mewujudkan Masyarakat Peduli' }}
                </span>
            </h1>

            <p class="max-w-2xl text-base md:text-lg text-gray-200 font-medium mt-8 mb-12 drop-shadow-md opacity-0 animate-fade-in-up"
                style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                {{ settings?.hero_description || `Selamat datang di platform digital ${settings?.sebutan_wilayah ||
                    'Kelurahan'}
                ${settings?.nama_wilayah || '[Nama Wilayah]'}. Pusat informasi terkini dan layanan administrasi terpadu
                untuk
                warga masyarakat.` }}
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-5 opacity-0 animate-fade-in-up"
                style="animation-delay: 0.8s; animation-fill-mode: forwards;">
                <Link v-if="settings?.module_status?.modul_pengaduan !== false" :href="route('pengaduan')"
                    class="inline-flex items-center justify-center px-10 py-4 border border-transparent text-sm font-black rounded-2xl text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 shadow-xl shadow-blue-600/30 hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                    <i class="fas fa-bullhorn mr-3"></i> Buat Laporan
                </Link>
                <Link v-if="settings?.module_status?.modul_layanan !== false" :href="route('layanan')"
                    class="inline-flex items-center justify-center px-10 py-4 border-2 border-white/20 hover:border-white text-sm font-black rounded-2xl text-white bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                    Layanan Mandiri
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

.fade-enter-active,
.fade-leave-active {
    transition: opacity 1.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
