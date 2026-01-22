<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const tahun = new Date().getFullYear();
</script>

<template>

    <Head title="Transparansi Anggaran" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-green-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 mx-auto bg-white/20 backdrop-blur rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-coins text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">APBDes {{ tahun }}</h1>
                <p class="text-green-100 text-lg max-w-2xl mx-auto">Transparansi Anggaran Pendapatan dan Belanja
                    Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Ringkasan Anggaran Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <!-- Pendapatan -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-l-green-500 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-600">Total Pendapatan</h3>
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900 mb-2">Rp 1.250.000.000</div>
                        <p class="text-sm text-green-600 font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 100% Terealisasi
                        </p>
                    </div>
                    <!-- Belanja -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-l-red-500 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-600">Total Belanja</h3>
                            <div
                                class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900 mb-2">Rp 1.180.500.000</div>
                        <p class="text-sm text-gray-500 font-medium">
                            94.4% Terserap
                        </p>
                    </div>
                    <!-- Silpa -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-l-blue-500 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-600">SiLPA</h3>
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900 mb-2">Rp 69.500.000</div>
                        <p class="text-sm text-gray-500 font-medium">
                            Sisa Lebih Anggaran
                        </p>
                    </div>
                </div>

                <!-- Grafik Batang Realisasi -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <!-- Grafik Pendapatan -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Rincian Pendapatan</h3>
                        <div class="space-y-6">

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Dana Desa (DD)</span>
                                    <span class="text-sm font-bold text-gray-900">Rp 800.000.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Alokasi Dana Desa (ADD)</span>
                                    <span class="text-sm font-bold text-gray-900">Rp 350.000.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Pendapatan Asli Desa (PAD)</span>
                                    <span class="text-sm font-bold text-gray-900">Rp 50.000.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-400 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Bagi Hasil Pajak & Retribusi</span>
                                    <span class="text-sm font-bold text-gray-900">Rp 50.000.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-300 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Grafik Belanja -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Rincian Belanja</h3>
                        <div class="space-y-6">

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Bidang Penyelenggaraan Pemdes</span>
                                    <span class="text-sm font-bold text-gray-900">35%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-red-500 h-2.5 rounded-full" style="width: 35%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Bidang Pembangunan Desa</span>
                                    <span class="text-sm font-bold text-gray-900">45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Bidang Pembinaan
                                        Kemasyarakatan</span>
                                    <span class="text-sm font-bold text-gray-900">15%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: 15%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Bidang Pemberdayaan
                                        Masyarakat</span>
                                    <span class="text-sm font-bold text-gray-900">5%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-purple-500 h-2.5 rounded-full" style="width: 5%"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </MainLayout>
</template>
