<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    settings: Object,
});

const defaultReligions = [
    { label: 'Islam', value: '4.150', color: 'bg-emerald-600', icon: 'fa-mosque' },
    { label: 'Kristen Protestan', value: '65', color: 'bg-blue-600', icon: 'fa-church' },
    { label: 'Katolik', value: '25', color: 'bg-indigo-600', icon: 'fa-cross' },
    { label: 'Hindu / Budha / Lainnya', value: '10', color: 'bg-orange-500', icon: 'fa-om' },
];

const rawTotal = props.settings?.statistik_umum?.find(s => s.label === 'Total Penduduk')?.value || '1';
const totalPenduduk = parseInt(rawTotal.toString().replace(/\D/g, '')) || 1;

const religions = (props.settings?.statistik_agama || defaultReligions).map(item => {
    const val = parseInt(item.value.toString().replace(/\D/g, '')) || 0;
    return {
        ...item,
        percentage: ((val / totalPenduduk) * 100).toFixed(1)
    };
});
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

                <div class="space-y-8">
                    <div v-for="rel in religions" :key="rel.label"
                        class="group bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div
                                    :class="[rel.color, 'w-16 h-16 rounded-[1.5rem] flex items-center justify-center text-white text-2xl shadow-lg mr-6 group-hover:rotate-12 transition-transform duration-500']">
                                    <i :class="['fas', rel.icon]"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">{{
                                        rel.label }}</h3>
                                    <div class="text-3xl font-black text-slate-800">{{ rel.value }} <span
                                            class="text-xs font-bold text-gray-300">JIWA</span></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-5xl font-black text-gray-100 group-hover:text-emerald-500/20 transition-colors duration-500">{{
                                        rel.percentage }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-50 rounded-full h-4 overflow-hidden p-1 shadow-inner">
                            <div :class="[rel.color, 'h-full rounded-full transition-all duration-[1.5s] ease-out group-hover:brightness-110']"
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
