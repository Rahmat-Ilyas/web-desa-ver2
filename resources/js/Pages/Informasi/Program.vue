<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const programs = [
    {
        title: 'Program Sehat Ceria',
        category: 'Kesehatan',
        status: 'Sedang Berjalan',
        desc: 'Pemberian nutrisi tambahan dan pemeriksaan rutin bagi balita dan lansia setiap bulan.',
        icon: 'fa-heartbeat',
        color: 'rose'
    },
    {
        title: 'Ujung Sabbang Pintar',
        category: 'Pendidikan',
        status: 'Terjadwal',
        desc: 'Bantuan perlengkapan sekolah bagi warga kurang mampu dan bimbingan belajar gratis.',
        icon: 'fa-graduation-cap',
        color: 'indigo'
    },
    {
        title: 'Bedah Rumah Tidak Layak',
        category: 'Infrastruktur',
        status: 'Sedang Berjalan',
        desc: 'Rehabilitasi rumah warga yang kurang layak huni menjadi tempat tinggal yang sehat.',
        icon: 'fa-home',
        color: 'emerald'
    },
    {
        title: 'Digitalisasi Kelurahan',
        category: 'Layanan Publik',
        status: 'Selesai',
        desc: 'Integrasi sistem administrasi kependudukan digital untuk mempercepat pelayanan warga.',
        icon: 'fa-mobile-alt',
        color: 'blue'
    }
];
</script>

<template>

    <Head title="Program Unggulan" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-indigo-800 py-20 relative overflow-hidden">
            <div
                class="absolute inset-x-0 bottom-0 top-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Program & Inovasi</h1>
                <p class="text-indigo-100 text-xl max-w-3xl mx-auto">Mewujudkan visi kelurahan melalui berbagai program
                    kerja strategis demi kesejahteraan masyarakat.</p>
            </div>
        </div>

        <div class="py-20 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div v-for="prog in programs" :key="prog.title"
                        class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-indigo-900/5 flex flex-col items-start border border-gray-100 group hover:shadow-2xl transition-all duration-500">
                        <div
                            :class="[`bg-${prog.color}-100 text-${prog.color}-600`, 'w-20 h-20 rounded-3xl flex items-center justify-center text-3xl mb-8 group-hover:rotate-6 transition-transform']">
                            <i :class="['fas', prog.icon]"></i>
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                :class="[`bg-${prog.color}-50 text-${prog.color}-600`, 'text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest']">{{
                                prog.category }}</span>
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ prog.status
                                }}</span>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-4">{{ prog.title }}</h3>
                        <p class="text-gray-600 leading-relaxed mb-8 flex-grow">
                            {{ prog.desc }}
                        </p>
                        <button :class="[`text-${prog.color}-600`, 'font-bold flex items-center group/btn']">
                            Lihat Rincian <i
                                class="fas fa-chevron-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>

                <!-- Strategic Plan Info -->
                <div
                    class="mt-20 p-12 bg-white rounded-[3rem] border border-gray-100 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full -mr-20 -mt-20 z-0"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
                        <div class="md:w-1/4">
                            <div
                                class="w-32 h-32 bg-indigo-600 rounded-3xl rotate-12 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                                <i class="fas fa-bullseye text-5xl text-white"></i>
                            </div>
                        </div>
                        <div class="md:w-3/4">
                            <h4 class="text-2xl font-black text-gray-900 mb-4">Fokus Pembangunan Berkelanjutan</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                Setiap program yang kami jalankan dirancang untuk memberikan dampak jangka panjang,
                                terukur, dan berbasis pada kebutuhan nyata warga Kelurahan Ujung Sabbang di setiap
                                tingkatan lingkungan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
