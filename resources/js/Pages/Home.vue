<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

// Import Partials
import Hero from './Home/Partials/Hero.vue';
import Sambutan from './Home/Partials/Sambutan.vue';
import Features from './Home/Partials/Features.vue';
import News from './Home/Partials/News.vue';
import Structure from './Home/Partials/Structure.vue';
import Gallery from './Home/Partials/Gallery.vue';
import CallToAction from './Home/Partials/CallToAction.vue';
import Map from './Home/Partials/Map.vue';

defineProps({
    villageName: String,
    lurah: Object,
    structures: Array,
    sambutan: Object,
    visimisi: Object,
    latestBeritas: Array
});
</script>

<template>

    <Head title="Beranda" />

    <MainLayout>
        <!-- Hero Section -->
        <Hero :villageName="villageName" />

        <!-- Sambutan Lurah -->
        <Sambutan :lurah="lurah" :sambutan="sambutan" />

        <!-- Stats / Feature Grid -->
        <Features />

        <!-- News / Berita -->
        <News :latestBeritas="latestBeritas" />

        <!-- Struktur Pemerintahan -->
        <Structure :structures="structures" />

        <!-- Galeri Kegiatan -->
        <Gallery />

        <!-- CTA Pengaduan -->
        <CallToAction />

        <!-- Peta Wilayah -->
        <Map />
    </MainLayout>
</template>
