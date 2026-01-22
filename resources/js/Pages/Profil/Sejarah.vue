<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    intro: String,
    timelines: Array
});

const getColors = (index) => {
    const themes = [
        { 
            dot: 'bg-blue-600', border: 'border-blue-100', text: 'text-blue-600', bg: 'bg-blue-50', 
            hover: 'hover:border-blue-400', glow: 'shadow-blue-500/10', tint: 'bg-blue-50/30', 
            accent: 'bg-blue-600', icon: 'fa-landmark' 
        },
        { 
            dot: 'bg-indigo-600', border: 'border-indigo-100', text: 'text-indigo-600', bg: 'bg-indigo-50', 
            hover: 'hover:border-indigo-400', glow: 'shadow-indigo-500/10', tint: 'bg-indigo-50/30', 
            accent: 'bg-indigo-600', icon: 'fa-monument' 
        },
        { 
            dot: 'bg-violet-600', border: 'border-violet-100', text: 'text-violet-600', bg: 'bg-violet-50', 
            hover: 'hover:border-violet-400', glow: 'shadow-violet-500/10', tint: 'bg-violet-50/30', 
            accent: 'bg-violet-600', icon: 'fa-scroll' 
        },
        { 
            dot: 'bg-emerald-600', border: 'border-emerald-100', text: 'text-emerald-600', bg: 'bg-emerald-50', 
            hover: 'hover:border-emerald-400', glow: 'shadow-emerald-500/10', tint: 'bg-emerald-50/30', 
            accent: 'bg-emerald-600', icon: 'fa-leaf' 
        },
        { 
            dot: 'bg-rose-600', border: 'border-rose-100', text: 'text-rose-600', bg: 'bg-rose-50', 
            hover: 'hover:border-rose-400', glow: 'shadow-rose-500/10', tint: 'bg-rose-50/30', 
            accent: 'bg-rose-600', icon: 'fa-flag' 
        },
        { 
            dot: 'bg-amber-600', border: 'border-amber-100', text: 'text-amber-600', bg: 'bg-amber-50', 
            hover: 'hover:border-amber-400', glow: 'shadow-amber-500/10', tint: 'bg-amber-50/30', 
            accent: 'bg-amber-600', icon: 'fa-star' 
        },
    ];
    return themes[index % themes.length];
};
</script>

<template>

    <Head title="Sejarah Kelurahan" />

    <MainLayout>
        <!-- Hero Title -->
        <div class="bg-blue-900 py-20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4">Sejarah Kelurahan</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto font-medium">
                    Menelusuri warisan budaya dan perkembangan Kelurahan Ujung Sabbang dari masa ke masa.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-24 bg-slate-50 relative overflow-hidden">
            <!-- Background Shape -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">

                <!-- Intro Card -->
                <div v-if="intro" class="mb-32 relative group">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[3rem] blur opacity-10 group-hover:opacity-20 transition duration-500"></div>
                    <div class="relative bg-white/80 backdrop-blur-xl p-10 md:p-14 rounded-[2.5rem] border border-white shadow-2xl">
                        <div class="prose prose-lg max-w-none text-slate-700 intro-rich-text whitespace-pre-wrap leading-relaxed"
                            v-html="intro"></div>
                    </div>
                </div>

                <!-- Modern Multi-colored Timeline -->
                <div v-if="timelines && timelines.length > 0" class="relative">
                    <!-- Central Animated Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1.5 h-full bg-slate-200 hidden md:block rounded-full">
                        <div class="absolute inset-0 bg-gradient-to-b from-blue-600 via-indigo-500 to-emerald-500 opacity-20 rounded-full"></div>
                    </div>

                    <div class="space-y-24">
                        <div v-for="(t, index) in timelines" :key="t.id"
                            class="relative flex flex-col md:flex-row items-center justify-between group"
                            :class="index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'">

                            <!-- Timeline dot with pulse effect -->
                            <div class="absolute left-1/2 transform -translate-x-1/2 hidden md:flex items-center justify-center z-10 transition-transform duration-500 group-hover:scale-110">
                                <div class="w-10 h-10 rounded-full bg-white shadow-xl border-4 flex items-center justify-center" :class="getColors(index).border">
                                    <i :class="['fas', getColors(index).icon, 'text-xs', getColors(index).text]"></i>
                                    <div class="absolute inset-0 rounded-full animate-ping opacity-20" :class="getColors(index).dot"></div>
                                </div>
                            </div>

                            <!-- Year Label (Desktop side) -->
                            <div class="hidden md:flex flex-col items-center w-[45%]" :class="index % 2 === 0 ? 'items-end pr-12' : 'items-start pl-12'">
                                <div class="px-6 py-2 rounded-2xl bg-white shadow-lg border-2 font-black text-xl tracking-tighter" :class="[getColors(index).border, getColors(index).text]">
                                    {{ t.year }}
                                </div>
                            </div>

                            <!-- Content Card -->
                            <div class="w-full md:w-[45%]">
                                <div class="relative overflow-hidden bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl transition-all duration-500 border border-slate-100 group-hover:-translate-y-2 group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)]"
                                    :class="[getColors(index).glow]">
                                    
                                    <!-- Background Tint -->
                                    <div class="absolute inset-0 opacity-40" :class="getColors(index).tint"></div>
                                    
                                    <!-- Side Accent Bar -->
                                    <div class="absolute top-0 bottom-0 w-2 transition-all duration-500 group-hover:w-3" 
                                        :class="[index % 2 === 0 ? 'right-0' : 'left-0', getColors(index).accent]"></div>

                                    <div class="relative">
                                        <!-- Mobile Year Badge -->
                                        <div class="md:hidden inline-block px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4"
                                            :class="[getColors(index).bg, getColors(index).text]">
                                            {{ t.year }}
                                        </div>

                                        <h3 class="text-2xl font-black text-slate-900 mb-6 leading-tight group-hover:translate-x-2 transition-transform duration-500">
                                            {{ t.title }}
                                        </h3>
                                        
                                        <div class="text-slate-600 leading-relaxed text-justify timeline-content whitespace-pre-wrap text-sm md:text-base border-l-2 border-slate-100 pl-6 ml-1"
                                            v-html="t.content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else-if="!intro" class="text-center py-20 bg-white rounded-[4rem] border-4 border-dashed border-slate-100">
                    <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-history text-4xl text-slate-200"></i>
                    </div>
                    <p class="text-slate-400 font-bold text-lg tracking-wide uppercase">Data sejarah belum tersedia</p>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.intro-rich-text :deep(p) {
    margin-bottom: 2rem;
    line-height: 2;
    text-align: justify;
    font-size: 1.125rem;
}

.intro-rich-text :deep(p:first-of-type)::first-letter {
    font-size: 4.5rem;
    font-weight: 900;
    color: #2563eb;
    margin-right: 1.2rem;
    float: left;
    line-height: 1;
    text-shadow: 4px 4px 0px rgba(37, 99, 235, 0.1);
}

.timeline-content :deep(p) {
    margin-bottom: 1.25rem;
}

.timeline-content :deep(strong) {
    color: #0f172a;
    font-weight: 800;
}
</style>
