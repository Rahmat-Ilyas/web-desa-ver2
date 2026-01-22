<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <Head title="Lembaga Karang Taruna" />

    <MainLayout>
        <div class="bg-gray-800 py-16 relative overflow-hidden">
             <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                 <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-fist-raised text-3xl text-gray-800"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Karang Taruna</h1>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">Wadah pengembangan generasi muda Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

         <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                    <div>
                         <span class="text-blue-600 font-bold tracking-wider uppercase text-sm mb-2 block">Tentang Kami</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Muda, Berkarya, & Berdaya</h2>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">
                            Karang Taruna Ujung Sabbang adalah organisasi sosial kemasyarakatan sebagai wadah dan sarana pengembangan setiap anggota masyarakat yang tumbuh dan berkembang atas dasar kesadaran dan tanggung jawab sosial dari, oleh dan untuk masyarakat terutama generasi muda.
                        </p>
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-100 min-w-[100px]">
                                <span class="block text-2xl font-bold text-gray-800">30+</span>
                                <span class="text-xs text-gray-500 uppercase">Anggota Aktif</span>
                            </div>
                             <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-100 min-w-[100px]">
                                <span class="block text-2xl font-bold text-gray-800">10+</span>
                                <span class="text-xs text-gray-500 uppercase">Program Kerja</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-blue-600 rounded-2xl transform rotate-3 scale-100 opacity-10"></div>
                        <img src="https://placehold.co/600x400?text=Kegiatan+Pemuda" alt="Karang Taruna" class="rounded-2xl shadow-xl relative z-10 w-full object-cover">
                    </div>
                </div>

                <!-- Program Unggulan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border rounded-xl p-6 hover:shadow-lg transition-all duration-300 text-center">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-volleyball-ball text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Olahraga & Seni</h3>
                        <p class="text-sm text-gray-600">Turnamen futsal, voli, dan pentas seni pemuda tahunan.</p>
                    </div>
                     <div class="bg-white border rounded-xl p-6 hover:shadow-lg transition-all duration-300 text-center">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tree text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Lingkungan Hidup</h3>
                        <p class="text-sm text-gray-600">Kerja bakti pembersihan pantai dan penanaman pohon.</p>
                    </div>
                     <div class="bg-white border rounded-xl p-6 hover:shadow-lg transition-all duration-300 text-center">
                        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-hands-helping text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sosial Kemanusiaan</h3>
                        <p class="text-sm text-gray-600">Bantuan bencana alam dan santunan yatim piatu.</p>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
