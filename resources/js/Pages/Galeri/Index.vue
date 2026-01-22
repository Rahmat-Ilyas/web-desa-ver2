<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from 'vue';

const categories = ['Semua', 'Kegiatan', 'Pembangunan', 'Sosial', 'Keagamaan'];
const activeCategory = ref('Semua');

const photos = [
    { id: 1, title: 'Musrenbang Kelurahan', category: 'Kegiatan', image: 'https://placehold.co/600x400?text=Musrenbang' },
    { id: 2, title: 'Pembangunan Drainase', category: 'Pembangunan', image: 'https://placehold.co/600x400?text=Pembangunan' },
    { id: 3, title: 'Penyaluran Bantuan Sosial', category: 'Sosial', image: 'https://placehold.co/600x400?text=Sosial' },
    { id: 4, title: 'Pengajian Rutin Majelis Taklim', category: 'Keagamaan', image: 'https://placehold.co/600x400?text=Keagamaan' },
    { id: 5, title: 'Kerja Bakti Lingkungan', category: 'Kegiatan', image: 'https://placehold.co/600x400?text=Kerja+Bakti' },
    { id: 6, title: 'Perbaikan Jalan Lingkungan', category: 'Pembangunan', image: 'https://placehold.co/600x400?text=Jalan' },
    { id: 7, title: 'Posyandu Balita', category: 'Sosial', image: 'https://placehold.co/600x400?text=Posyandu' },
    { id: 8, title: 'Peringatan Hari Besar Islam', category: 'Keagamaan', image: 'https://placehold.co/600x400?text=PHBI' },
];

const filteredPhotos = () => {
    if (activeCategory.value === 'Semua') return photos;
    return photos.filter(p => p.category === activeCategory.value);
};
</script>

<template>

    <Head title="Galeri Kegiatan" />

    <MainLayout>
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Galeri Dokumentasi</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Dokumentasi visual berbagai kegiatan dan pembangunan
                    di Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Filters -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <button v-for="cat in categories" :key="cat" @click="activeCategory = cat" :class="[
                        'px-6 py-2 rounded-full font-bold transition-all duration-300 shadow-sm border',
                        activeCategory === cat ? 'bg-blue-600 text-white border-blue-600 scale-105' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400 hover:text-blue-600'
                    ]">
                        {{ cat }}
                    </button>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="photo in filteredPhotos()" :key="photo.id"
                        class="group relative overflow-hidden rounded-2xl aspect-square bg-gray-100 shadow-lg border border-gray-100">
                        <img :src="photo.image" :alt="photo.title"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <span class="text-blue-400 text-xs font-bold uppercase tracking-widest mb-1">{{
                                photo.category }}</span>
                            <h3 class="text-white font-bold text-sm leading-tight">{{ photo.title }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="filteredPhotos().length === 0" class="py-20 text-center">
                    <i class="fas fa-image text-6xl text-gray-200 mb-4 block"></i>
                    <p class="text-gray-400">Belum ada foto dalam kategori ini.</p>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
