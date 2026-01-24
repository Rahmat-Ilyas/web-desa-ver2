<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    deskripsi: String,
    umum: Object,
    batas: Object,
    lahan: Array,
    iklim: Object,
});

const getColorClass = (color) => {
    const colors = {
        blue: 'bg-blue-500',
        emerald: 'bg-emerald-500',
        rose: 'bg-rose-500',
        violet: 'bg-violet-500',
        amber: 'bg-amber-500',
    };
    return colors[color] || colors.blue;
};

const getBgClass = (color) => {
    const colors = {
        blue: 'bg-blue-200',
        emerald: 'bg-emerald-200',
        rose: 'bg-rose-200',
        violet: 'bg-violet-200',
        amber: 'bg-amber-200',
    };
    return colors[color] || colors.blue;
};

const getTextClass = (color) => {
    const colors = {
        blue: 'text-blue-600',
        emerald: 'text-emerald-600',
        rose: 'text-rose-600',
        violet: 'text-violet-600',
        amber: 'text-amber-600',
    };
    return colors[color] || colors.blue;
};
</script>

<template>

    <Head title="Kondisi Kelurahan" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative bg-slate-900 py-16 overflow-hidden border-b border-white/5">
            <div
                class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px]">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6 drop-shadow-2xl">
                    Geografis & Demografis
                </h1>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto font-medium leading-relaxed opacity-80">
                    Eksplorasi mendalam mengenai bentang alam, statistik kependudukan, dan pemanfaatan wilayah Kelurahan
                    Ujung Sabbang.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">

                    <!-- Left Column: Statistics & Boundaries -->
                    <div class="lg:col-span-5 space-y-10">
                        <!-- Data Wilayah Card -->
                        <div
                            class="group bg-blue-50/50 rounded-[2.5rem] p-10 border border-blue-100/50 shadow-sm transition-all hover:shadow-2xl hover:shadow-blue-500/5">
                            <h3 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-4">
                                <i class="fas fa-map-marked-alt text-blue-600"></i> Data Wilayah
                            </h3>
                            <ul class="space-y-6">
                                <li class="flex justify-between items-center py-2 border-b border-blue-100/50">
                                    <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Luas
                                        Wilayah</span>
                                    <span class="font-black text-blue-600 bg-white px-4 py-1.5 rounded-xl shadow-sm">{{
                                        umum.luas_wilayah || '± 0 Km²' }}</span>
                                </li>
                                <li class="flex justify-between items-center py-2 border-b border-blue-100/50">
                                    <span
                                        class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Kecamatan</span>
                                    <span class="font-black text-slate-800">{{ umum.kecamatan || '-' }}</span>
                                </li>
                                <li class="flex justify-between items-center py-2 border-b border-blue-100/50">
                                    <span
                                        class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Kota</span>
                                    <span class="font-black text-slate-800">{{ umum.kota || '-' }}</span>
                                </li>
                                <li class="flex justify-between items-center py-2 border-b border-blue-100/50">
                                    <span
                                        class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Lingkungan</span>
                                    <span class="font-black text-slate-800">{{ umum.jumlah_lingkungan || '0' }}
                                        Lingkungan</span>
                                </li>
                                <li class="flex justify-between items-center py-2">
                                    <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Jumlah
                                        RT / RW</span>
                                    <span class="font-black text-slate-800">{{ umum.rt || '0' }} RT / {{ umum.rw || '0'
                                        }} RW</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Batas Wilayah Card -->
                        <div class="bg-orange-50/50 rounded-[2.5rem] p-10 border border-orange-100/50 shadow-sm">
                            <h3 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-4">
                                <i class="fas fa-compass text-orange-600"></i> Batas Wilayah
                            </h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div v-for="(val, dir) in batas" :key="dir" class="flex gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center shrink-0">
                                        <i class="fas fa-arrow-right text-orange-400 text-xs" :class="{
                                            '-rotate-90': dir === 'utara',
                                            'rotate-0': dir === 'timur',
                                            'rotate-90': dir === 'selatan',
                                            'rotate-180': dir === 'barat'
                                        }"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-1">
                                            {{ dir }}</p>
                                        <p class="text-slate-600 font-medium text-sm leading-relaxed">{{ val || 'Belum terdata' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Narrative & Land Use -->
                    <div class="lg:col-span-7 space-y-12">
                        <div class="prose prose-slate max-w-none">
                            <div class="text-slate-600 text-lg leading-loose font-medium space-y-6 intro-rich-text whitespace-pre-wrap"
                                v-html="deskripsi || 'Sedang proses pengisian data...'"></div>
                        </div>

                        <div class="relative pt-6">
                            <div class="flex items-center gap-5 mb-10">
                                <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-xl shadow-blue-500/20 shrink-0">
                                    <i class="fas fa-chart-area text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-black text-slate-900 tracking-tight leading-none mb-2">Penggunaan Lahan</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Distribusi Pemanfaatan Wilayah</p>
                                </div>
                            </div>

                            <div class="space-y-8">
                                <div v-for="(item, index) in lahan" :key="index" class="space-y-3">
                                    <div class="flex justify-between items-end">
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"
                                            :class="[getBgClass(item.color), getTextClass(item.color)]">
                                            {{ item.label }}
                                        </span>
                                        <span class="text-sm font-black text-slate-800">{{ item.percentage }}%</span>
                                    </div>
                                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                                        <div :class="getColorClass(item.color)"
                                            class="h-full rounded-full transition-all duration-1000"
                                            :style="{ width: item.percentage + '%' }"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Climate Banner -->
                <div class="mt-24 relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[3rem] blur-xl opacity-20 group-hover:opacity-40 transition duration-700">
                    </div>
                    <div
                        class="relative bg-gradient-to-r from-slate-900 to-blue-900 rounded-[3.5rem] p-10 md:p-16 text-white overflow-hidden shadow-2xl">
                        <!-- BG Icon -->
                        <div class="absolute right-[-2%] top-[-10%] opacity-5 transform rotate-12 scale-150">
                            <i class="fas fa-cloud-sun text-[20rem]"></i>
                        </div>

                        <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-12 text-center divider-x">
                            <div class="animate-float">
                                <i class="fas fa-thermometer-half text-blue-400 text-3xl mb-4"></i>
                                <div class="text-3xl font-black mb-2 tracking-tight">{{ iklim.suhu_min || '0' }}°C - {{
                                    iklim.suhu_max || '0' }}°C</div>
                                <div class="text-blue-200 text-xs font-black uppercase tracking-[0.2em]">Suhu Rata-rata
                                </div>
                            </div>
                            <div class="animate-float" style="animation-delay: 0.5s;">
                                <i class="fas fa-sun text-amber-400 text-3xl mb-4"></i>
                                <div class="text-3xl font-black mb-2 tracking-tight">{{ iklim.iklim || '-' }}</div>
                                <div class="text-blue-200 text-xs font-black uppercase tracking-[0.2em]">Iklim Wilayah
                                </div>
                            </div>
                            <div class="animate-float" style="animation-delay: 1s;">
                                <i class="fas fa-cloud-showers-heavy text-indigo-300 text-3xl mb-4"></i>
                                <div class="text-3xl font-black mb-2 tracking-tight">{{ iklim.curah_hujan || '-' }}
                                </div>
                                <div class="text-blue-200 text-xs font-black uppercase tracking-[0.2em]">Curah Hujan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fadeInDown 1s ease-out forwards;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 4s ease-in-out infinite;
}

@media (min-width: 768px) {
    .divider-x>div:not(:last-child) {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }
}

.intro-rich-text::first-letter,
.intro-rich-text :deep(p:first-of-type)::first-letter {
    font-size: 4.5rem;
    font-weight: 900;
    color: #2563eb;
    margin-right: 1.2rem;
    float: left;
    line-height: 1;
    text-shadow: 4px 4px 0px rgba(37, 99, 235, 0.1);
}
</style>
