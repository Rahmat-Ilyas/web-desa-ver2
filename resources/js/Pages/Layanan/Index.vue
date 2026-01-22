<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const services = [
    {
        title: 'KTP, KK & Surat Pindah',
        desc: 'Pengurusan surat pengantar untuk pembuatan KTP baru, perpanjangan KK, maupun surat pindah datang/keluar.',
        icon: 'fa-id-card',
        color: 'bg-orange-50 text-orange-600',
        requirements: [
            'Kartu Keluarga (KK) Asli & Fotokopi',
            'KTP lama (untuk perpanjangan)',
            'Surat Pengantar dari RT/RW setempat',
            'Pas foto terbaru (jika diperlukan untuk dokumen fisik)',
            'Akta Kelahiran (untuk pembuatan KTP baru)'
        ]
    },
    {
        title: 'Akta Kelahiran & Nikah',
        desc: 'Layanan pengantar untuk penerbitan akta kelahiran anak dan surat pengantar nikah (NA).',
        icon: 'fa-file-signature',
        color: 'bg-blue-50 text-blue-600',
        requirements: [
            'Surat Keterangan Lahir dari Bidan/RS',
            'Buku Nikah/Akta Perkawinan Orang Tua',
            'KTP & KK Orang Tua',
            'Fotokopi KTP 2 orang saksi kelahiran',
            'Surat Pengantar RT/RW'
        ]
    },
    {
        title: 'Ahli Waris & Surat Kuasa',
        desc: 'Pembuatan surat pernyataan ahli waris dan legalitas surat kuasa untuk berbagai keperluan hukum.',
        icon: 'fa-users',
        color: 'bg-emerald-50 text-emerald-600',
        requirements: [
            'Surat Kematian Pewaris',
            'Fotokopi KTP & KK seluruh Ahli Waris',
            'Surat Pernyataan Ahli Waris (bermaterai)',
            'Saksi minimum 2 orang (beserta fotokopi KTP)',
            'Surat Pengantar dari RT/RW'
        ]
    },
    {
        title: 'SKCK & Ijin Keramaian',
        desc: 'Pengurusan pengantar SKCK untuk melamar pekerjaan dan ijin pelaksanaan kegiatan/keramaian.',
        icon: 'fa-shield-alt',
        color: 'bg-red-50 text-red-600',
        requirements: [
            'Fotokopi KTP & KK',
            'Fotokopi Akta Kelahiran/Ijazah',
            'Surat Pengantar dari RT/RW',
            'Pas Foto 4x6 latar merah (3 lembar)',
            'Proposal kegiatan (khusus ijin keramaian)'
        ]
    },
    {
        title: 'Pengantar IMB',
        desc: 'Surat pengantar untuk pengurusan Ijin Mendirikan Bangunan (IMB) atau PBG.',
        icon: 'fa-building',
        color: 'bg-amber-50 text-amber-600',
        requirements: [
            'Fotokopi Sertifikat Tanah',
            'Fotokopi KTP Pemohon',
            'Fotokopi PBB Tahun Terakhir',
            'Gambar Denah Bangunan',
            'Surat Persetujuan Tetangga (jika diperlukan)'
        ]
    },
    {
        title: 'Akta Kematian',
        desc: 'Layanan pelaporan kematian warga untuk penerbitan akta kematian dari Disdukcapil.',
        icon: 'fa-book-reader',
        color: 'bg-gray-50 text-gray-600',
        requirements: [
            'Surat Kematian dari RS/Puskesmas/Kelurahan',
            'KTP & KK Asli Almarhum/Almarhumah',
            'Fotokopi KTP Pelapor (Ahli Waris)',
            'Fotokopi KTP 2 orang saksi',
            'Surat Pengantar RT/RW'
        ]
    },
    {
        title: 'SITU & Keterangan Usaha',
        desc: 'Pembuatan Surat Keterangan Usaha (SKU) untuk pengajuan modal atau legalitas IKM/UMKM.',
        icon: 'fa-store',
        color: 'bg-indigo-50 text-indigo-600',
        requirements: [
            'Fotokopi KTP & KK Pemilik Usaha',
            'Surat Pengantar dari RT/RW',
            'Foto lokasi atau tempat usaha',
            'Surat pernyataan tidak keberatan tetangga',
            'Dokumen legalitas tanah lokasi (jika perlu)'
        ]
    },
    {
        title: 'Keterangan Tidak Mampu',
        desc: 'Penerbitan SKTM untuk keperluan keringanan biaya sekolah, kesehatan, atau bantuan sosial.',
        icon: 'fa-hand-holding-heart',
        color: 'bg-rose-50 text-rose-600',
        requirements: [
            'Fotokopi KTP & KK',
            'Surat Pengantar dari RT/RW (mencantumkan keterangan tidak mampu)',
            'Surat pernyataan penghasilan orang tua',
            'Foto kondisi rumah (opsional)',
            'Tujuan penggunaan SKTM (Sekolah/RS/Bansos)'
        ]
    }
];

import { ref } from 'vue';
const selectedService = ref(null);
const isModalOpen = ref(false);

const openModal = (service) => {
    selectedService.value = service;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = 'auto';
};
</script>

<template>

    <Head title="Layanan Administrasi" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-orange-600 py-20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center text-white">
                <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">Pusat Layanan Warga</h1>
                <p class="text-orange-50 text-xl max-w-2xl mx-auto">Informasi persyaratan dan prosedur pengurusan
                    administrasi di Kelurahan Ujung Sabbang secara transparan dan cepat.</p>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="service in services" :key="service.title"
                        class="bg-white rounded-3xl p-8 shadow-xl shadow-orange-900/5 hover:shadow-2xl transition-all duration-500 group border border-gray-100 flex flex-col items-start">
                        <div
                            :class="[service.color, 'w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-500 shadow-sm']">
                            <i :class="['fas', service.icon]"></i>
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors leading-tight">
                            {{ service.title }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow">
                            {{ service.desc }}
                        </p>
                        <button @click="openModal(service)"
                            class="w-full py-3 bg-gray-50 text-gray-700 font-bold rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 flex items-center justify-center">
                            Lihat Syarat <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Assistance Section -->
                <div
                    class="mt-24 p-12 bg-white rounded-[3rem] border border-gray-100 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-10">
                    <div class="flex items-center gap-8">
                        <div
                            class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center text-4xl text-orange-600 shadow-inner">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-gray-900 mb-2 font-poppins">Butuh bantuan pengurusan?
                            </h4>
                            <p class="text-gray-500">Petugas kami siap membantu Anda memberikan informasi lebih detail
                                setiap hari kerja.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="#"
                            class="px-8 py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 transition-colors shadow-lg shadow-green-600/20">
                            <i class="fab fa-whatsapp mr-2 text-xl"></i>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requirements Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="closeModal">
                </div>

                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <transition enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div
                            class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                            <div class="bg-white p-8 sm:p-10">
                                <div class="flex justify-between items-start mb-8">
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="[selectedService.color, 'w-14 h-14 rounded-2xl flex items-center justify-center text-xl shadow-sm']">
                                            <i :class="['fas', selectedService.icon]"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-slate-900 leading-tight">Syarat & Berkas
                                            </h3>
                                            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-1">
                                                {{ selectedService.title }}</p>
                                        </div>
                                    </div>
                                    <button @click="closeModal"
                                        class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-400">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div v-for="(req, index) in selectedService.requirements" :key="index"
                                        class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-orange-200 hover:bg-orange-50/30 transition-all">
                                        <div
                                            class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] font-black text-slate-400 shrink-0 group-hover:border-orange-500 group-hover:text-orange-600 transition-colors">
                                            {{ index + 1 }}
                                        </div>
                                        <p class="text-slate-600 font-semibold text-sm leading-relaxed">{{ req }}</p>
                                    </div>
                                </div>

                                <div class="mt-10">
                                    <button @click="closeModal"
                                        class="w-full py-4 bg-orange-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-orange-700 transition-all shadow-xl shadow-orange-600/20">
                                        SAYA MENGERTI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </transition>
    </MainLayout>
</template>
