<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const educationLevels = [
    { label: 'Tidak/Belum Sekolah', value: '850', color: 'bg-emerald-500' },
    { label: 'SD / Sederajat', value: '1.200', color: 'bg-blue-500' },
    { label: 'SMP / Sederajat', value: '750', color: 'bg-indigo-500' },
    { label: 'SMA / Sederajat', value: '980', color: 'bg-violet-500' },
    { label: 'Diploma / Sarjana (S1)', value: '420', color: 'bg-purple-500' },
    { label: 'Pascasarjana (S2/S3)', value: '50', color: 'bg-pink-500' },
];
</script>

<template>

    <Head title="Statistik Pendidikan" />

    <MainLayout>
        <div class="bg-violet-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Statistik Pendidikan</h1>
                <p class="text-violet-100 text-lg max-w-2xl mx-auto">Tingkat pendidikan masyarakat Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-6">
                        <div v-for="level in educationLevels" :key="level.label" class="relative">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-gray-700">{{ level.label }}</span>
                                <span class="text-sm font-black text-violet-700">{{ level.value }} <span
                                        class="text-[10px] text-gray-400">Jiwa</span></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-8 overflow-hidden p-1 shadow-inner">
                                <div :class="[level.color, 'h-full rounded-full flex items-center justify-end px-3 transition-all duration-1000']"
                                    :style="{ width: (parseInt(level.value) / 4250 * 100 * 3) + '%' }">
                                    <span class="text-[10px] text-white font-bold">{{ Math.round(parseInt(level.value) /
                                        4250 * 100) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-[40px] p-12 border border-violet-100 relative">
                        <div
                            class="absolute -top-6 -right-6 w-24 h-24 bg-white rounded-3xl shadow-xl flex items-center justify-center rotate-12">
                            <i class="fas fa-graduation-cap text-4xl text-violet-600"></i>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-6 leading-tight">Membangun Masa Depan Melalui
                            Pendidikan</h3>
                        <p class="text-gray-600 leading-relaxed mb-8">Data statistik menunjukkan pertumbuhan tingkat
                            pendidikan yang positif di Kelurahan Ujung Sabbang, mencerminkan tingginya kesadaran warga
                            akan pentingnya pendidikan bagi kemajuan wilayah.</p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-violet-50">
                                <div class="text-xs font-bold text-violet-400 uppercase tracking-widest mb-1">Melek
                                    Huruf</div>
                                <div class="text-2xl font-black text-gray-900 text-right">99.2%</div>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-violet-50">
                                <div class="text-xs font-bold text-violet-400 uppercase tracking-widest mb-1">Rata-rata
                                    Lama Sekolah</div>
                                <div class="text-2xl font-black text-gray-900 text-right">10.5 <span
                                        class="text-xs">THN</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
