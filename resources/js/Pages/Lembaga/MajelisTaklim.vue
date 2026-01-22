<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>

    <Head title="Lembaga Majelis Taklim" />

    <MainLayout>
        <div class="bg-emerald-800 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-quran text-3xl text-emerald-800"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Majelis Taklim</h1>
                <p class="text-emerald-100 text-lg max-w-2xl mx-auto">Wadah pembinaan keagamaan dan silaturahmi warga
                    Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://placehold.co/600x400?text=Pengajian+Rutin" alt="Kegiatan Pengajian"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-8">
                            <div>
                                <h3 class="text-white font-bold text-2xl mb-1">Pengajian Rutin</h3>
                                <p class="text-gray-300 text-sm">Dilaksanakan setiap hari Jumat sore di Masjid Nurul
                                    Iman.</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://placehold.co/600x400?text=Kegiatan+Sosial" alt="Kegiatan Sosial"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-8">
                            <div>
                                <h3 class="text-white font-bold text-2xl mb-1">Bakti Sosial</h3>
                                <p class="text-gray-300 text-sm">Santunan kaum dhuafa dan kegiatan sosial keagamaan
                                    lainnya.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-emerald-50 rounded-2xl p-8 border border-emerald-100 text-center max-w-3xl mx-auto">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Jadwal Kegiatan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-emerald-100 flex items-start">
                            <div
                                class="bg-emerald-100 text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1 font-bold">
                                1</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Yasinan & Tahlil</h4>
                                <p class="text-sm text-gray-600">Setiap Kamis Malam (Malam Jumat)</p>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-emerald-100 flex items-start">
                            <div
                                class="bg-emerald-100 text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 mt-1 font-bold">
                                2</div>
                            <div>
                                <h4 class="font-bold text-gray-800">Kajian Fiqih Wanita</h4>
                                <p class="text-sm text-gray-600">Sabtu Pekan Ke-2 (Bulanan)</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
