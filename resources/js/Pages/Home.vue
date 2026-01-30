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
    lurah: Object,
    structures: Array,
    sambutan: Object,
    visimisi: Object,
    latestBeritas: Array,
    latestGaleris: Array
});
</script>

<template>

    <Head title="Beranda" />

    <MainLayout :latestGaleris="latestGaleris">
        <!-- Hero Section -->
        <Hero />

        <!-- Sambutan Lurah -->
        <Sambutan :lurah="lurah" :sambutan="sambutan" />

        <!-- Stats / Feature Grid -->
        <Features />

        <!-- News / Berita -->
        <News v-if="$page.props.settings?.module_status?.modul_berita !== false" :latestBeritas="latestBeritas" />

        <!-- Struktur Pemerintahan -->
        <Structure :structures="structures" />

        <!-- Galeri Kegiatan -->
        <Gallery v-if="$page.props.settings?.module_status?.modul_galeri !== false" :latestGaleris="latestGaleris" />

        <!-- CTA Pengaduan -->
        <CallToAction v-if="$page.props.settings?.module_status?.modul_pengaduan !== false" />

        <!-- Peta Wilayah -->
        <Map />
    </MainLayout>
</template>
