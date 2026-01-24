<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    settings: Object,
});

const defaultPemilih = {
    total: '2.990',
    laki: '1.450',
    perempuan: '1.540'
};

const pemilih = props.settings?.statistik_pemilih || defaultPemilih;

const voterStats = [
    { label: 'Pemilih Laki-laki', value: pemilih.laki, percentage: ((parseInt(pemilih.laki.replace(/\D/g, '')) / parseInt(pemilih.total.replace(/\D/g, ''))) * 100).toFixed(1), color: 'bg-blue-600', icon: 'fa-male' },
    { label: 'Pemilih Perempuan', value: pemilih.perempuan, percentage: ((parseInt(pemilih.perempuan.replace(/\D/g, '')) / parseInt(pemilih.total.replace(/\D/g, ''))) * 100).toFixed(1), color: 'bg-pink-500', icon: 'fa-female' },
];
</script>

<template>

    <Head title="Daftar Pemilih Tetap (DPT)" />

    <MainLayout>
        <div class="bg-red-800 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30">
                    <i class="fas fa-vote-yea text-4xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Daftar Pemilih Tetap
                    (DPT)</h1>
                <p class="text-red-100 text-lg max-w-2xl mx-auto">Data pemilih tetap Kelurahan Ujung Sabbang untuk
                    keperluan Pemilu/Pilkada.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Left Column: Big Total -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-10 text-white shadow-2xl relative overflow-hidden group/main hover:-translate-y-4 transition-transform duration-700 h-full">
                            <div
                                class="absolute -right-10 -bottom-10 opacity-10 group-hover/main:rotate-12 transition-transform duration-1000">
                                <i class="fas fa-id-card text-[200px]"></i>
                            </div>
                            <h3
                                class="text-red-200 font-bold uppercase tracking-widest text-sm mb-2 group-hover/main:text-white transition-colors">
                                Total Daftar
                                Pemilih</h3>
                            <div
                                class="text-6xl font-black mb-4 tracking-tighter group-hover/main:scale-105 origin-left transition-transform duration-500">
                                {{ pemilih.total }}</div>
                            <div class="text-red-100 font-medium leading-relaxed mb-10">Wajib Pilih yang telah terdaftar
                                secara sah di sistem administrasi kependudukan.</div>

                            <div class="space-y-4">
                                <div v-for="stat in voterStats" :key="stat.label"
                                    class="bg-black/20 backdrop-blur p-5 rounded-3xl flex items-center group/item hover:bg-white/10 transition-all duration-300">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mr-5 group-hover/item:rotate-12 transition-transform">
                                        <i :class="['fas', stat.icon, 'text-xl text-white']"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="text-[10px] text-red-200 uppercase font-bold tracking-widest">{{
                                            stat.label }}</div>
                                        <div class="text-lg font-bold">{{ stat.value }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-black">{{ stat.percentage }}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Info & Table -->
                    <div class="lg:col-span-2 space-y-8">
                        <div
                            class="bg-white border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center flex flex-col items-center justify-center min-h-[400px]">
                            <div
                                class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6 text-gray-400">
                                <i class="fas fa-file-contract text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Rincian per TPS</h3>
                            <p class="text-gray-500 max-w-md mb-8">Data rincian pemilih per Tempat Pemungutan Suara
                                (TPS) tersedia untuk dilihat oleh warga yang berkepentingan.</p>
                            <button
                                class="px-8 py-3 bg-red-600 text-white font-bold rounded-full hover:bg-red-700 shadow-lg transition-colors flex items-center">
                                <i class="fas fa-download mr-2"></i> Unduh Data DPT (PDF)
                            </button>
                        </div>

                        <div class="bg-yellow-50 rounded-2xl p-6 border border-yellow-100">
                            <h4 class="font-bold text-yellow-900 mb-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Penting
                            </h4>
                            <p class="text-yellow-800 text-sm">Pastikan nama Anda terdaftar dalam DPT. Jika belum
                                terdaftar, silakan hubungi Kantor Lurah atau petugas PPS setempat dengan membawa KTP-el
                                dan Kartu Keluarga.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
