<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({});
</script>

<template>

    <Head title="Peta Lokasi" />

    <MainLayout>
        <!-- Hero Title -->
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Peta Lokasi</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Jelajahi Peta Digital Wilayah Kelurahan Ujung Sabbang
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-0 bg-white min-h-[650px] relative">
            <div class="absolute inset-0 z-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9527.202328973425!2d119.62448159591297!3d-4.006293250198694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d95bb208f7b8ec9%3A0x1cb3b51f736846e9!2sUjung%20Sabbang%2C%20Kec.%20Ujung%2C%20Kota%20Parepare%2C%20Sulawesi%20Selatan!5e0!3m2!1sid!2sid!4v1768976092960!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="Peta Wilayah Kelurahan Ujung Sabbang">
                </iframe>
            </div>
        </div>
    </MainLayout>
</template>
