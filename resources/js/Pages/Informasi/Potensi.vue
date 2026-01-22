<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const potentials = [
    {
        title: 'UMKM Kerajinan Tangan',
        desc: 'Pemanfaatan limbah laut menjadi produk bernilai seni tinggi oleh warga lokal.',
        icon: 'fa-hand-sparkles',
        color: 'bg-amber-100 text-amber-600'
    },
    {
        title: 'Kuliner Pesisir',
        desc: 'Berbagai produk olahan ikan segar yang menjadi daya tarik wisatawan kuliner.',
        icon: 'fa-utensils',
        color: 'bg-orange-100 text-orange-600'
    },
    {
        title: 'Wisata Budaya',
        desc: 'Pelestarian rumah adat dan tradisi pesisir yang masih terjaga dengan baik.',
        icon: 'fa-landmark',
        color: 'bg-blue-100 text-blue-600'
    },
    {
        title: 'Ekonomi Digital',
        desc: 'Pertumbuhan start-up lokal dan pemanfaatan marketplace oleh pemuda daerah.',
        icon: 'fa-laptop-code',
        color: 'bg-indigo-100 text-indigo-600'
    }
];
</script>

<template>

    <Head title="Potensi Wilayah" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-amber-600 to-orange-700 py-20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Potensi Ujung Sabbang
                    </h1>
                    <p class="text-amber-50 text-xl leading-relaxed">Mengenali kekayaan sumber daya, kreativitas
                        masyarakat, dan peluang ekonomi yang ada di kelurahan kita.</p>
                </div>
            </div>
        </div>

        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="item in potentials" :key="item.title"
                        class="p-8 rounded-[2rem] border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                        <div
                            :class="[item.color, 'w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm group-hover:scale-110 transition-transform duration-500']">
                            <i :class="['fas', item.icon]"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ item.title }}</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">{{ item.desc }}</p>
                    </div>
                </div>

                <!-- Detail Section -->
                <div class="mt-24 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-orange-100 rounded-full blur-3xl opacity-50">
                        </div>
                        <img src="https://placehold.co/800x600?text=Produk+Lokal" alt="Produk Lokal"
                            class="rounded-[3rem] shadow-2xl relative z-10">
                        <div
                            class="absolute -bottom-8 -right-8 w-48 h-48 bg-amber-600/10 rounded-full backdrop-blur-3xl border border-white/20 z-0">
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-8 leading-tight">Mendukung Ekonomi
                            Lokal Berkembang</h2>
                        <p class="text-gray-600 text-lg leading-relaxed mb-8">
                            Pemerintah Kelurahan Ujung Sabbang terus berkomitmen memberikan fasilitas, pelatihan, dan
                            pendampingan bagi para pelaku usaha lokal agar mampu bersaing di pasar nasional maupun
                            global.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <div class="text-3xl font-black text-orange-600 mb-1">50+</div>
                                <div class="text-sm font-bold text-gray-400 uppercase tracking-widest">UMKM Aktif</div>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <div class="text-3xl font-black text-orange-600 mb-1">12</div>
                                <div class="text-sm font-bold text-gray-400 uppercase tracking-widest">Sentra Produksi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
