<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const documents = [
    { name: 'Formulir Keterangan Tidak Mampu (SKTM)', type: 'PDF', size: '245 KB', category: 'Layanan Umum' },
    { name: 'Formulir Pengantar Nikah (N1-N4)', type: 'DOCX', size: '156 KB', category: 'Layanan Umum' },
    { name: 'Laporan Realisasi Anggaran 2023', type: 'PDF', size: '1.2 MB', category: 'Transparansi' },
    { name: 'Peraturan Daerah No. 5 Tahun 2022', type: 'PDF', size: '850 KB', category: 'Hukum' },
    { name: 'Formulir Perubahan Data KK', type: 'PDF', size: '312 KB', category: 'Kependudukan' },
    { name: 'Surat Keterangan Usaha (SKU)', type: 'DOCX', size: '128 KB', category: 'Layanan Umum' },
];
</script>

<template>
    <Head title="Pusat Download Dokumen" />

    <MainLayout>
        <div class="bg-gray-800 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                 <div class="w-16 h-16 mx-auto bg-white/10 backdrop-blur rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-download text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Pusat Download</h1>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">Unduh berbagai formulir layanan, peraturan, dan laporan Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-gray-50 min-h-screen">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                        <h2 class="text-xl font-bold text-gray-900">Daftar Dokumen</h2>
                        <span class="text-sm text-gray-500">{{ documents.length }} Dokumen tersedia</span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div v-for="doc in documents" :key="doc.name" class="p-6 hover:bg-gray-50 transition-colors flex items-center group">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center text-xl mr-6 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                <i :class="[doc.type === 'PDF' ? 'fas fa-file-pdf' : 'fas fa-file-word']"></i>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ doc.name }}</h3>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ doc.category }}</span>
                                    <span class="text-xs text-gray-300">•</span>
                                    <span class="text-xs text-gray-500">{{ doc.type }} ({{ doc.size }})</span>
                                </div>
                            </div>
                            <button class="ml-4 p-3 bg-gray-100 text-gray-600 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-12 p-8 bg-blue-900 rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
                    <div class="text-center md:text-left">
                        <h4 class="text-xl font-bold mb-1">Butuh dokumen lain?</h4>
                        <p class="text-blue-100 text-sm">Jika dokumen yang Anda cari tidak tersedia, silakan hubungi layanan pengaduan kami.</p>
                    </div>
                    <a href="#" class="px-8 py-3 bg-white text-blue-900 font-bold rounded-full hover:bg-blue-50 transition-colors shadow-lg">
                        Hubungi Petugas
                    </a>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
