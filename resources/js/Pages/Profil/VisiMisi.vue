<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    lurah: Object,
    visimisi: Object
});
</script>

<template>

    <Head title="Visi & Misi" />

    <MainLayout>
        <!-- Hero Title -->
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Visi & Misi</h1>
                <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto font-medium leading-relaxed">
                    Arah kebijakan dan tujuan strategis pembangunan Kel. Ujung Sabbang.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-24 bg-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- VISI -->
                <div class="mb-16">
                    <div class="text-center mb-16">
                        <span
                            class="inline-block px-4 py-1 rounded-full bg-blue-50 text-blue-600 font-black text-xs uppercase tracking-widest mb-2">Cita-Cita
                            Utama</span>
                        <h2 class="text-4xl font-black text-slate-900">Visi Kelurahan</h2>
                    </div>

                    <div
                        class="relative pt-16 pb-12 px-6 md:px-10 bg-slate-50 rounded-[3rem] border border-slate-100 text-center group hover:shadow-xl transition-shadow duration-300">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg ring-8 ring-white">
                            <i class="fas fa-eye"></i>
                        </div>

                        <p v-if="visimisi?.visi"
                            class="text-2xl md:text-3xl font-bold text-slate-800 italic leading-relaxed mt-4">
                            "{{ visimisi.visi }}"
                        </p>
                        <div v-else class="text-slate-400 italic flex items-center justify-center gap-2 mt-4">
                            <i class="fas fa-info-circle"></i> Visi belum diatur.
                        </div>
                    </div>
                </div>

                <!-- MISI -->
                <div class="relative">
                    <div class="text-center mb-16">
                        <span
                            class="inline-block px-4 py-1 rounded-full bg-indigo-50 text-indigo-600 font-black text-xs uppercase tracking-widest mb-2">Langkah
                            Strategis</span>
                        <h2 class="text-4xl font-black text-slate-900">Misi Kelurahan</h2>
                    </div>

                    <div
                        class="relative pt-16 pb-12 px-6 md:px-10 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 leading-relaxed">
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg ring-8 ring-white">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div v-if="visimisi?.misi && visimisi.misi.length > 0">
                            <ol class="list-none space-y-6">
                                <li v-for="(item, index) in visimisi.misi" :key="index" class="relative pl-14">
                                    <span
                                        class="absolute left-0 top-0 w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center font-bold shadow-lg shadow-blue-600/30">
                                        {{ index + 1 }}
                                    </span>
                                    <p class="text-lg text-slate-600 font-medium leading-relaxed pt-1.5">{{ item }}</p>
                                </li>
                            </ol>
                        </div>
                        <div v-else
                            class="text-slate-400 italic text-center py-10 flex flex-col items-center gap-4 border-2 border-dashed border-slate-100 rounded-3xl">
                            <i class="fas fa-clipboard-list text-4xl text-slate-200"></i>
                            <p>Misi belum diatur oleh admin.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
