<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const rws = [
    { no: '001', ketua: 'Bapak H. Abdullah', wilayah: 'Meliputi RT 001 - RT 003' },
    { no: '002', ketua: 'Bapak H. Sulaiman', wilayah: 'Meliputi RT 004 - RT 007' },
    { no: '003', ketua: 'Bapak Ruslan', wilayah: 'Meliputi RT 008 - RT 010' },
    { no: '004', ketua: 'Bapak H. Mahfud', wilayah: 'Meliputi RT 011 - RT 014' },
];
</script>

<template>

    <Head title="Lembaga RW" />

    <MainLayout>
        <div class="bg-indigo-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Rukun Warga (RW)</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Daftar Ketua RW dan Cakupan Wilayah di Kelurahan
                    Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div v-for="rw in rws" :key="rw.no"
                        class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 hover:transform hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <i class="fas fa-users text-9xl text-indigo-500"></i>
                        </div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                                <span class="font-bold text-2xl text-indigo-700">{{ rw.no }}</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">RW {{ rw.no }}</h3>
                            <p class="text-gray-500 mb-6">{{ rw.wilayah }}</p>

                            <div class="border-t border-gray-100 pt-4">
                                <span class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Ketua RW</span>
                                <span class="text-lg font-medium text-indigo-700">{{ rw.ketua }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
