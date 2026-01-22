<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const rts = [
    { no: '001', ketua: 'Bapak Ahmad', wilayah: 'Lingkungan 1' },
    { no: '002', ketua: 'Bapak Supardi', wilayah: 'Lingkungan 1' },
    { no: '003', ketua: 'Bapak Junaedi', wilayah: 'Lingkungan 1' },
    { no: '004', ketua: 'Ibu Ratna', wilayah: 'Lingkungan 2' },
    { no: '005', ketua: 'Bapak Jamal', wilayah: 'Lingkungan 2' },
    { no: '006', ketua: 'Bapak Hendra', wilayah: 'Lingkungan 2' },
    { no: '007', ketua: 'Bapak Syamsul', wilayah: 'Lingkungan 2' },
    { no: '008', ketua: 'Ibu Murni', wilayah: 'Lingkungan 3' },
    { no: '009', ketua: 'Bapak Rizal', wilayah: 'Lingkungan 3' },
    { no: '010', ketua: 'Bapak Anto', wilayah: 'Lingkungan 3' },
    { no: '011', ketua: 'Bapak Basri', wilayah: 'Lingkungan 4' },
    { no: '012', ketua: 'Ibu Haryati', wilayah: 'Lingkungan 4' },
    { no: '013', ketua: 'Bapak Ridwan', wilayah: 'Lingkungan 4' },
    { no: '014', ketua: 'Bapak Lukman', wilayah: 'Lingkungan 4' },
];
</script>

<template>

    <Head title="Lembaga RT" />

    <MainLayout>
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Rukun Tetangga (RT)</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Daftar Ketua RT dan Wilayah Administrasi di Kelurahan
                    Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="rt in rts" :key="rt.no"
                        class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow border-l-4 border-l-blue-500">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold text-gray-800">RT {{ rt.no }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{
                                rt.wilayah }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-tie w-6 text-center mr-2 text-blue-500"></i>
                            <div>
                                <span class="text-xs text-gray-400 uppercase block tracking-wider">Ketua RT</span>
                                <span class="font-medium">{{ rt.ketua }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
