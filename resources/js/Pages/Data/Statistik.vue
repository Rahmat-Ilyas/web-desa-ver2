<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const stats = [
    { label: 'Total Penduduk', value: '4.250', unit: 'Jiwa', icon: 'fa-users', color: 'blue' },
    { label: 'Kepala Keluarga', value: '1.120', unit: 'KK', icon: 'fa-home', color: 'green' },
    { label: 'Laki-laki', value: '2.100', unit: 'Jiwa', icon: 'fa-male', color: 'indigo' },
    { label: 'Perempuan', value: '2.150', unit: 'Jiwa', icon: 'fa-female', color: 'pink' },
];
</script>

<template>
    <Head title="Statistik Penduduk" />

    <MainLayout>
        <div class="bg-indigo-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Statistik Penduduk</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Gambaran umum data demografi Kelurahan Ujung Sabbang secara real-time.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                    <div v-for="stat in stats" :key="stat.label" class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div :class="[`bg-${stat.color}-100 text-${stat.color}-600`, 'w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm']">
                                <i :class="['fas', stat.icon]"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ stat.unit }}</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">{{ stat.label }}</h3>
                        <div class="text-3xl font-extrabold text-gray-900">{{ stat.value }}</div>
                    </div>
                </div>

                <!-- Gender Distribution Chart (Simple Visualization) -->
                <div class="max-w-3xl mx-auto bg-gray-50 rounded-3xl p-8 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-8 text-center italic">Komposisi Penduduk Berdasarkan Jenis Kelamin</h3>
                    <div class="relative h-12 w-full bg-pink-400 rounded-full overflow-hidden flex shadow-inner">
                        <div class="h-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold transition-all duration-1000" style="width: 49.4%">
                            LAKI-LAKI (49.4%)
                        </div>
                        <div class="h-full flex items-center justify-center text-white text-xs font-bold transition-all duration-1000" style="width: 50.6%">
                            PEREMPUAN (50.6%)
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 text-sm text-gray-500 px-2 font-medium">
                        <div class="flex items-center"><span class="w-3 h-3 bg-indigo-500 rounded-full mr-2"></span> 2.100 Jiwa</div>
                        <div class="flex items-center"><span class="w-3 h-3 bg-pink-400 rounded-full mr-2"></span> 2.150 Jiwa</div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
