<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({});
</script>

<template>

    <Head title="Lokasi Kantor Lurah" />

    <MainLayout>
        <!-- Hero Title -->
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Lokasi Kantor Lurah</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Informasi alamat lengkap, kontak, dan jam operasional
                    pelayanan.</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                    <!-- Sidebar: Info Kantor -->
                    <div class="lg:col-span-1 space-y-8">
                        <!-- Card Alamat -->
                        <div
                            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                            <div class="h-2 bg-blue-600"></div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                    <span class="bg-blue-100 p-2 rounded-lg text-blue-600 mr-3">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    Kantor Kelurahan
                                </h3>

                                <address class="not-italic text-gray-600 space-y-4">
                                    <div v-if="$page.props.settings?.info_umum?.alamat" class="flex items-start">
                                        <i class="fas fa-map-marker-alt mt-1.5 w-6 text-red-500"></i>
                                        <div>
                                            <span class="block font-semibold text-gray-900">Alamat:</span>
                                            {{ $page.props.settings.info_umum.alamat }}
                                        </div>
                                    </div>

                                    <div v-if="$page.props.settings?.info_umum?.telepon" class="flex items-center">
                                        <i class="fas fa-phone-alt w-6 text-green-500"></i>
                                        <div>
                                            <span class="block font-semibold text-gray-900">Telepon:</span>
                                            {{ $page.props.settings.info_umum.telepon }}
                                        </div>
                                    </div>

                                    <div v-if="$page.props.settings?.info_umum?.whatsapp" class="flex items-center">
                                        <i class="fab fa-whatsapp w-6 text-emerald-500"></i>
                                        <div>
                                            <span class="block font-semibold text-gray-900">WhatsApp:</span>
                                            {{ $page.props.settings.info_umum.whatsapp }}
                                        </div>
                                    </div>

                                    <div v-if="$page.props.settings?.info_umum?.email" class="flex items-center">
                                        <i class="fas fa-envelope w-6 text-orange-500"></i>
                                        <div>
                                            <span class="block font-semibold text-gray-900">Email:</span>
                                            {{ $page.props.settings.info_umum.email }}
                                        </div>
                                    </div>
                                </address>

                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <h4 class="font-bold text-gray-900 mb-3 text-sm uppercase tracking-wide">Jam
                                        Operasional</h4>
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex justify-between">
                                            <span>Senin - Kamis</span>
                                            <span class="font-medium">07.30 - 16.00 WITA</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span>Jumat</span>
                                            <span class="font-medium">07.30 - 16.30 WITA</span>
                                        </li>
                                        <li class="flex justify-between text-red-500">
                                            <span>Sabtu - Minggu</span>
                                            <span class="font-medium">Tutup</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Card Rute -->
                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white text-center">
                            <h3 class="text-lg font-bold mb-2">Ingin berkunjung?</h3>
                            <p class="text-blue-100 text-sm mb-4">Dapatkan petunjuk arah langsung melalui Google Maps.
                            </p>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=Kantor+Kelurahan+Ujung+Sabbang,+Parepare"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-full font-bold text-sm hover:bg-blue-50 transition-colors shadow-sm">
                                <i class="fas fa-directions mr-2"></i> Buka Rute
                            </a>
                        </div>
                    </div>

                    <!-- Main: Peta Digital -->
                    <div class="lg:col-span-2">
                        <div
                            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden h-full min-h-[500px] relative group">
                            <!-- Overlay Hint -->
                            <div
                                class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-600 shadow-sm border border-gray-200 pointer-events-none">
                                <i class="fas fa-mouse-pointer mr-1"></i> Interaktif
                            </div>

                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4763.601164486712!2d119.62448159591297!3d-4.006293250198694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d95bb20dd444f57%3A0xb7935a727e1e2e6c!2sKantor%20Kelurahan%20Ujung%20Sabbang!5e0!3m2!1sid!2sid!4v1768976236852!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" class="w-full h-full min-h-[500px]"
                                title="Peta Lokasi Kelurahan Ujung Sabbang">
                            </iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>
