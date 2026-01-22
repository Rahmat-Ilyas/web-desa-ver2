<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const religions = [
    { label: 'Islam', value: '4.150', percentage: '97.6', color: 'bg-emerald-600', icon: 'fa-mosque' },
    { label: 'Kristen Protestan', value: '65', percentage: '1.5', color: 'bg-blue-600', icon: 'fa-church' },
    { label: 'Katolik', value: '25', percentage: '0.6', color: 'bg-indigo-600', icon: 'fa-cross' },
    { label: 'Hindu / Budha / Lainnya', value: '10', percentage: '0.3', color: 'bg-orange-500', icon: 'fa-om' },
];
</script>

<template>

    <Head title="Statistik Agama" />

    <MainLayout>
        <div class="bg-emerald-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Statistik Agama</h1>
                <p class="text-emerald-100 text-lg max-w-2xl mx-auto">Keberagaman keyakinan penduduk Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="space-y-12">
                    <div v-for="rel in religions" :key="rel.label" class="group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div
                                    :class="[rel.color, 'w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg mr-4 group-hover:scale-110 transition-transform']">
                                    <i :class="['fas', rel.icon]"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ rel.label }}</h3>
                                    <div class="text-2xl font-black text-emerald-600">{{ rel.value }} <span
                                            class="text-xs font-bold text-gray-400">JIWA</span></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-4xl font-black text-gray-200 group-hover:text-emerald-100 transition-colors">{{
                                    rel.percentage }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div :class="[rel.color, 'h-full rounded-full transition-all duration-1000']"
                                :style="{ width: rel.percentage + '%' }"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-20 p-10 bg-emerald-50 rounded-3xl border border-emerald-100 text-center">
                    <i class="fas fa-hand-holding-heart text-5xl text-emerald-500 mb-6 block"></i>
                    <h3 class="text-2xl font-bold text-emerald-900 mb-4">Harmoni dalam Keberagaman</h3>
                    <p class="text-emerald-800 leading-relaxed max-w-2xl mx-auto italic">"Kami berkomitmen menjaga
                        kerukunan antar umat beragama demi menciptakan lingkungan yang damai dan tenteram di seluruh
                        wilayah Kelurahan Ujung Sabbang."</p>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
