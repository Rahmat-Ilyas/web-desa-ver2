<script setup>
import { computed } from 'vue';

const props = defineProps({
    structures: Array
});

const getLurah = computed(() => props.structures?.find(s => s.level === 1));
const getSeklur = computed(() => props.structures?.find(s => s.level === 2));
const getKasis = computed(() => props.structures?.filter(s => s.level === 3));
const getStaffsByParent = (parentId) => {
    return props.structures?.filter(s => s.level === 4 && s.parent_id === parentId) || [];
};

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : 'https://placehold.co/300x300?text=No+Photo';
};
</script>

<template>
    <section class="py-24 bg-slate-900 relative overflow-hidden">
        <!-- Premium Dynamic Background -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:32px_32px]"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-24">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-blue-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-4 shadow-sm">
                    Struktur Organisasi
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight">Hirarki <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Pemerintahan</span></h2>
                <div class="mt-6 flex justify-center">
                    <div class="w-16 h-1.5 bg-blue-600 rounded-full"></div>
                </div>
            </div>

            <div v-if="getLurah" class="flex flex-col items-center">
                <!-- Level 1: Lurah -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-blue-600 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                    <div class="bg-slate-800/80 backdrop-blur-md rounded-2xl p-7 text-center border border-white/10 shadow-2xl transition-all duration-300 w-72 relative z-10">
                        <div class="w-24 h-24 mx-auto mb-5 relative">
                            <img :src="getPhotoUrl(getLurah.photo)" :alt="getLurah.name" class="w-full h-full rounded-2xl object-cover shadow-2xl border-2 border-blue-500 transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xs shadow-lg ring-4 ring-slate-800">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                        <h3 class="text-base font-black text-white leading-tight mb-2 tracking-wide">{{ getLurah.name }}</h3>
                        <div class="px-4 py-1 rounded-full bg-blue-600/20 border border-blue-500/30 text-[10px] font-black text-blue-400 uppercase tracking-[0.1em] inline-block">
                            {{ getLurah.position }}
                        </div>
                    </div>
                </div>

                <div v-if="getSeklur" class="flex flex-col items-center w-full">
                    <div class="h-12 w-px bg-gradient-to-b from-blue-600 to-indigo-600"></div>
                    
                    <!-- Level 2: Seklur -->
                    <div class="group flex flex-col items-center">
                        <div class="bg-slate-800/80 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 shadow-xl hover:border-indigo-500/50 transition-all duration-300 w-64 relative z-10">
                            <div class="w-18 h-18 mx-auto mb-4 relative">
                                <img :src="getPhotoUrl(getSeklur.photo)" :alt="getSeklur.name" class="w-full h-full rounded-xl object-cover shadow-lg border border-indigo-500/30 group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h3 class="text-sm font-black text-white leading-tight mb-2">{{ getSeklur.name }}</h3>
                            <div class="px-3 py-0.5 rounded-full bg-indigo-600/20 border border-indigo-500/30 text-[9px] font-black text-indigo-400 uppercase tracking-widest inline-block">
                                {{ getSeklur.position }}
                            </div>
                        </div>

                        <!-- Staffs under Secretary -->
                        <div v-if="getStaffsByParent(getSeklur.id).length > 0" class="mt-12 w-full max-w-4xl flex flex-wrap justify-center gap-4">
                            <div v-for="staff in getStaffsByParent(getSeklur.id)" :key="staff.id" 
                                class="flex items-center gap-4 p-3 rounded-2xl border border-white/5 bg-white/[0.03] hover:bg-white/[0.08] hover:border-white/10 transition-all group/staff w-full sm:w-72 shrink-0">
                                <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-slate-700 shadow-lg border border-white/10">
                                    <img :src="getPhotoUrl(staff.photo)" class="w-full h-full object-cover group-hover/staff:scale-110 transition-transform duration-500">
                                </div>
                                <div class="overflow-hidden text-left">
                                    <p class="text-[11px] font-black text-white truncate mb-0.5">{{ staff.name }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">{{ staff.position }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kasis Section -->
                    <div v-if="getKasis.length > 0" class="w-full mt-16">
                        <div class="h-px w-full max-w-4xl mx-auto bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
                        
                        <div class="grid grid-cols-1 md:gap-x-8 gap-y-16 mt-16 px-4" :class="`md:grid-cols-${getKasis.length}`">
                            <div v-for="kasi in getKasis" :key="kasi.id" class="flex flex-col items-center group">
                                <!-- Kasi Card -->
                                <div class="bg-slate-800/80 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 shadow-xl group-hover:border-emerald-500/50 transition-all duration-300 w-full max-w-[16rem]">
                                    <div class="w-16 h-16 mx-auto mb-4">
                                        <img :src="getPhotoUrl(kasi.photo)" :alt="kasi.name" class="w-full h-full rounded-xl object-cover shadow-lg border border-emerald-500/30">
                                    </div>
                                    <h4 class="text-sm font-black text-white leading-tight mb-2">{{ kasi.name }}</h4>
                                    <div class="px-3 py-0.5 rounded-full bg-emerald-600/20 border border-emerald-500/30 text-[8px] font-black text-emerald-400 uppercase tracking-widest inline-block">
                                        {{ kasi.position }}
                                    </div>
                                </div>

                                <!-- Staffs Minimalist List -->
                                <div v-if="getStaffsByParent(kasi.id).length > 0" class="mt-8 w-full flex flex-wrap justify-center gap-3">
                                    <div v-for="staff in getStaffsByParent(kasi.id)" :key="staff.id" 
                                        class="flex items-center gap-3 p-3 rounded-2xl border border-white/5 bg-white/[0.03] hover:bg-white/[0.08] hover:border-white/10 transition-all group/staff w-full sm:w-64 shrink-0">
                                        <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 bg-slate-700 border border-white/5">
                                            <img :src="getPhotoUrl(staff.photo)" class="w-full h-full object-cover">
                                        </div>
                                        <div class="overflow-hidden text-left">
                                            <p class="text-[10px] font-black text-slate-200 truncate">{{ staff.name }}</p>
                                            <p class="text-[8px] text-slate-500 font-bold uppercase tracking-wider truncate">{{ staff.position }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-20 bg-slate-800/50 rounded-3xl border border-dashed border-white/10 shadow-2xl">
                <i class="fas fa-sitemap text-3xl text-slate-600 mb-4 animate-bounce"></i>
                <p class="text-slate-400 text-lg font-bold">Data Struktur Sedang Disiapkan</p>
            </div>
        </div>
    </section>
</template>
