<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    settings: Object,
});

const defaultGroups = [
    { label: '0 - 5 Tahun (Balita)', value: '350', color: 'bg-rose-500' },
    { label: '6 - 12 Tahun (Anak)', value: '480', color: 'bg-orange-500' },
    { label: '13 - 17 Tahun (Remaja)', value: '420', color: 'bg-yellow-500' },
    { label: '18 - 40 Tahun (Pemuda)', value: '1450', color: 'bg-green-500' },
    { label: '41 - 60 Tahun (Dewasa)', value: '1150', color: 'bg-blue-500' },
    { label: '60+ Tahun (Lansia)', value: '400', color: 'bg-purple-500' },
];

const rawTotal = props.settings?.statistik_umum?.find(s => s.label === 'Total Penduduk')?.value || '1';
const totalPenduduk = parseInt(rawTotal.toString().replace(/\D/g, '')) || 1;

const ageGroups = (props.settings?.statistik_umur || defaultGroups).map(item => {
    const val = parseInt(item.value.toString().replace(/\D/g, '')) || 0;
    return {
        ...item,
        percentage: ((val / totalPenduduk) * 100).toFixed(1)
    };
});
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
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Distribusi populasi {{
                    $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah ||
                    '[Nama Wilayah]' }}
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
                    <div class="p-8 space-y-6">
                        <div v-for="group in ageGroups" :key="group.label"
                            class="group p-6 rounded-[2rem] hover:bg-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 border border-transparent hover:border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-xs font-black text-gray-400 uppercase tracking-widest group-hover:text-slate-900 transition-colors">{{
                                        group.label }}</span>
                                    <span
                                        class="px-2 py-0.5 rounded-md bg-slate-100 text-[10px] font-black text-slate-500 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300">
                                        {{ group.percentage }}%
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="text-3xl font-black text-slate-800 block leading-none tracking-tight">{{
                                        group.value }}
                                        <span class="text-[10px] font-bold text-gray-300">JIWA</span></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-50 rounded-full h-4 overflow-hidden p-1 shadow-inner relative">
                                <div :class="[group.color, 'h-full rounded-full transition-all duration-[2s] ease-out group-hover:brightness-110']"
                                    :style="{ width: group.percentage + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
