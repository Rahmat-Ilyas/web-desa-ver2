<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const ageGroups = [
    { label: '0 - 5 Tahun (Balita)', value: '350', percentage: '8.2', color: 'bg-rose-500' },
    { label: '6 - 12 Tahun (Anak)', value: '480', percentage: '11.3', color: 'bg-orange-500' },
    { label: '13 - 17 Tahun (Remaja)', value: '420', percentage: '9.9', color: 'bg-yellow-500' },
    { label: '18 - 40 Tahun (Pemuda)', value: '1450', percentage: '34.1', color: 'bg-green-500' },
    { label: '41 - 60 Tahun (Dewasa)', value: '1150', percentage: '27.1', color: 'bg-blue-500' },
    { label: '60+ Tahun (Lansia)', value: '400', percentage: '9.4', color: 'bg-purple-500' },
];
</script>

<template>

    <Head title="Data Berdasarkan Umur" />

    <MainLayout>
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Demografi Berdasarkan
                    Umur</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Distribusi populasi Kelurahan Ujung Sabbang
                    berdasarkan kelompok usia.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-2xl font-bold text-gray-900">Rincian Kelompok Usia</h2>
                        <p class="text-gray-500 text-sm">Data dihitung berdasarkan tahun berjalan.</p>
                    </div>
                    <div class="p-8 space-y-8">
                        <div v-for="group in ageGroups" :key="group.label">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-gray-700 font-bold">{{ group.label }}</span>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-gray-900 block leading-none">{{ group.value }}
                                        <span class="text-sm font-medium text-gray-400">Jiwa</span></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
                                <div :class="[group.color, 'h-full rounded-full transition-all duration-[1.5s] ease-out']"
                                    :style="{ width: group.percentage + '%' }"></div>
                            </div>
                            <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">{{
                                group.percentage }}% DARI TOTAL POPULASI</div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                        <h4 class="font-bold text-blue-900 mb-2 flex items-center">
                            <i class="fas fa-baby mr-2"></i> Usia Produktif
                        </h4>
                        <p class="text-blue-800 text-sm">Populasi usia produktif (18-60 thn) mendominasi sebesar 61.2%
                            dari total penduduk.</p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100">
                        <h4 class="font-bold text-purple-900 mb-2 flex items-center">
                            <i class="fas fa-wheelchair mr-2"></i> Angka Ketergantungan
                        </h4>
                        <p class="text-purple-800 text-sm">Rasio penduduk tidak produktif terhadap penduduk produktif
                            berada pada level yang stabil.</p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
