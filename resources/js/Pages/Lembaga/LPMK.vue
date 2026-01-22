<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>

    <Head title="Lembaga LPMK" />

    <MainLayout>
        <div class="bg-teal-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-handshake text-3xl text-teal-700"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">LPMK</h1>
                <p class="text-teal-100 text-lg max-w-2xl mx-auto">Lembaga Pemberdayaan Masyarakat Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col lg:flex-row gap-12">
                    <!-- Main Content -->
                    <div class="lg:w-2/3">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Profil & Fungsi</h2>
                        <div class="prose prose-blue max-w-none text-gray-600">
                            <p>
                                <strong>LPMK (Lembaga Pemberdayaan Masyarakat Kelurahan)</strong> adalah lembaga
                                kemasyarakatan yang tumbuh dari, oleh, dan untuk masyarakat, merupakan mitra kerja Lurah
                                dalam menampung dan menyalurkan aspirasi masyarakat dibidang pembangunan.
                            </p>
                            <p>
                                Tugas utama LPMK meliputi:
                            </p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Menyusun rencana pembangunan yang partisipatif (Musrenbang).</li>
                                <li>Menggerakkan swadaya gotong royong masyarakat.</li>
                                <li>Melaksanakan dan mengendalikan pembangunan.</li>
                                <li>Menampung dan menyalurkan aspirasi masyarakat.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Sidebar: Structure -->
                    <div class="lg:w-1/3 space-y-6">
                        <div class="bg-teal-50 rounded-xl p-6 border border-teal-100">
                            <h3 class="font-bold text-teal-800 mb-4 flex items-center">
                                <i class="fas fa-sitemap mr-2"></i> Struktur Pengurus
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 mr-3">
                                        <img src="https://placehold.co/100x100?text=Ketua" alt="Ketua"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400 uppercase font-bold">Ketua LPMK</div>
                                        <div class="font-semibold text-gray-800">Bapak H. Rahman</div>
                                    </div>
                                </li>
                                <li class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 mr-3">
                                        <img src="https://placehold.co/100x100?text=Sekrt" alt="Sekretaris"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400 uppercase font-bold">Sekretaris</div>
                                        <div class="font-semibold text-gray-800">Ibu Siti Aminah</div>
                                    </div>
                                </li>
                                <li class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 mr-3">
                                        <img src="https://placehold.co/100x100?text=Benda" alt="Bendahara"
                                            class="w-full h-full rounded-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-400 uppercase font-bold">Bendahara</div>
                                        <div class="font-semibold text-gray-800">Bapak Faisal</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
