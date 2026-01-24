<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    programs: Array
});

// Filter Categories
const selectedCategory = ref('Semua');
const categories = ['Semua', 'Pembangunan Infrastruktur', 'Pemberdayaan Masyarakat', 'Keagamaan & Budaya', 'Kesehatan & Posyandu'];

const filteredItems = computed(() => {
    if (selectedCategory.value === 'Semua') {
        return props.programs;
    }
    // Simple filter, or advanced if strict category match needed
    // Assuming backend category string matches exactly or contains
    return props.programs.filter(item => item.kategori === selectedCategory.value);
});

const getStatusColor = (status) => {
    switch (status) {
        case 'Selesai': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'Berjalan': return 'bg-blue-100 text-blue-700 border-blue-200';
        default: return 'bg-slate-100 text-slate-600 border-slate-200';
    }
};

const getProgressBarColor = (status) => {
    switch (status) {
        case 'Selesai': return 'bg-emerald-500';
        case 'Berjalan': return 'bg-blue-600';
        default: return 'bg-slate-400';
    }
};
</script>

<template>

    <Head title="Program Kerja Desa" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-indigo-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30 rotate-3">
                    <i class="fas fa-tasks text-3xl text-indigo-100"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Program Kerja</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto font-medium">Transparansi kegiatan pembangunan dan
                    pemberdayaan masyarakat Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-slate-50 min-h-screen">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Filters (Optional, can be expanded) -->
                <!-- <div class="flex flex-wrap gap-2 justify-center mb-12">...</div> -->

                <!-- Program List -->
                <div class="space-y-6">
                    <div v-for="item in filteredItems" :key="item.id"
                        class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row gap-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">

                        <!-- Icon Box -->
                        <div
                            :class="[item.color, 'w-16 h-16 md:w-20 md:h-20 rounded-2xl flex flex-col items-center justify-center text-3xl shadow-sm shrink-0']">
                            <i :class="['fas', item.icon]"></i>
                        </div>

                        <div class="flex-grow w-full">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-3">
                                <div>
                                    <span
                                        class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                        {{ item.kategori }}
                                    </span>
                                    <h3
                                        class="text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                                        {{ item.judul }}
                                    </h3>
                                </div>
                                <span
                                    :class="['px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border shrink-0', getStatusColor(item.status)]">
                                    {{ item.status }}
                                </span>
                            </div>

                            <p class="text-slate-500 font-medium leading-relaxed mb-6">
                                {{ item.deskripsi }}
                            </p>

                            <!-- Progress & Meta -->
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <div class="flex justify-between items-center mb-2 text-xs font-bold text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-indigo-500"></i>
                                        {{ item.waktu_pelaksanaan || 'Waktu belum ditentukan' }}
                                    </div>
                                    <span class="text-slate-900 font-black">{{ item.progress }}% Selesai</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                                    <div :class="['h-3 rounded-full transition-all duration-1000 relative overflow-hidden', getProgressBarColor(item.status)]"
                                        :style="{ width: item.progress + '%' }">
                                        <div
                                            class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_2s_infinite]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-if="filteredItems.length === 0" class="text-center py-20">
                        <div
                            class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <i class="fas fa-clipboard-list text-3xl"></i>
                        </div>
                        <p class="text-slate-500 font-bold">Belum ada program kerja yang ditampilkan.</p>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(100%);
    }
}
</style>
