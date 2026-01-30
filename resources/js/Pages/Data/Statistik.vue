<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    settings: Object,
});

const defaultStats = [
    { label: 'Total Penduduk', value: '4.250', unit: 'Jiwa', icon: 'fa-users', color: 'blue' },
    { label: 'Laki-laki', value: '2.100', unit: 'Jiwa', icon: 'fa-male', color: 'indigo' },
    { label: 'Perempuan', value: '2.150', unit: 'Jiwa', icon: 'fa-female', color: 'pink' },
];

const stats = props.settings?.statistik_umum || defaultStats;

// Gender logic
const totalJiwaStr = stats.find(s => s.label === 'Total Penduduk')?.value || '1';
const totalJiwa = parseInt(totalJiwaStr.replace(/\D/g, ''));
const lakiJiwaStr = stats.find(s => s.label === 'Laki-laki')?.value || '0';
const lakiJiwa = parseInt(lakiJiwaStr.replace(/\D/g, ''));
const prJiwaStr = stats.find(s => s.label === 'Perempuan')?.value || '0';
const prJiwa = parseInt(prJiwaStr.replace(/\D/g, ''));

const lakiPercent = ((lakiJiwa / totalJiwa) * 100).toFixed(1);
const prPercent = ((prJiwa / totalJiwa) * 100).toFixed(1);
</script>

<template>

    <Head title="Statistik Penduduk" />

    <MainLayout>
        <div class="bg-indigo-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Statistik Penduduk</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Gambaran umum data demografi {{
                    $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah ||
                    '[Nama Wilayah]' }} secara real-time.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div v-for="stat in stats" :key="stat.label"
                        class="bg-white rounded-3xl p-8 shadow-lg border border-gray-50 hover:shadow-2xl transition-all duration-500 group">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                :class="[`bg-${stat.color}-50 text-${stat.color}-500`, 'w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform']">
                                <i :class="['fas', stat.icon]"></i>
                            </div>
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">{{ stat.unit
                            }}</span>
                        </div>
                        <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest mb-2">{{ stat.label }}
                        </h3>
                        <div class="text-4xl font-black text-slate-900 tracking-tight">{{ stat.value }}</div>
                    </div>
                </div>

                <!-- Gender Distribution Chart (Simple Visualization) -->
                <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-50 shadow-xl">
                    <h3 class="text-xl font-black text-slate-900 mb-10 text-center italic tracking-tight">Komposisi
                        Penduduk Berdasarkan Jenis Kelamin</h3>
                    <div class="relative h-14 w-full bg-pink-400 rounded-full overflow-hidden flex shadow-inner group">
                        <div class="h-full bg-indigo-500 flex items-center justify-center text-white text-[10px] font-black tracking-widest transition-all duration-1000 hover:brightness-110"
                            :style="{ width: lakiPercent + '%' }">
                            LAKI-LAKI ({{ lakiPercent }}%)
                        </div>
                        <div class="h-full flex items-center justify-center text-white text-[10px] font-black tracking-widest transition-all duration-1000 hover:brightness-110"
                            :style="{ width: prPercent + '%' }">
                            PEREMPUAN ({{ prPercent }}%)
                        </div>
                    </div>
                    <div
                        class="flex justify-between mt-6 text-[10px] font-black text-slate-400 px-4 uppercase tracking-[0.2em]">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-indigo-500 rounded-full shadow-sm"></div>
                            {{ lakiJiwaStr }} JIWA
                        </div>
                        <div class="flex items-center gap-3">
                            {{ prJiwaStr }} JIWA
                            <div class="w-3 h-3 bg-pink-400 rounded-full shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
