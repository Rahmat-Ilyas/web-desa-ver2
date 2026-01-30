<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    latestGaleris: {
        type: Array,
        default: () => []
    }
});

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/600x600?text=No+Photo';
    if (path.startsWith('http')) return path;
    return path;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/600x600?text=No+Photo';
    e.target.classList.add('opacity-50');
};
</script>

<template>
    <section class="py-24 bg-slate-50 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-4">
                        <i class="fas fa-camera-retro"></i> Momen Kami
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Dokumentasi Kegiatan</h2>
                    <p class="mt-4 text-slate-500 font-medium leading-relaxed">Kebersamaan warga dan denyut nadi kegiatan positif di lingkungan {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
                </div>
                <Link :href="route('galeri')" class="group inline-flex items-center px-6 py-3 bg-white border border-slate-200 shadow-sm hover:shadow-md rounded-2xl text-sm font-bold text-slate-600 hover:text-blue-600 transition-all">
                    Lihat Galeri Lengkap
                    <i class="fas fa-chevron-right ml-2 text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </Link>
            </div>

            <!-- Bento Grid Gallery -->
            <div v-if="latestGaleris.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 auto-rows-[200px] md:auto-rows-[240px]">
                
                <!-- Main Featured Item (First item takes 2x2 space) -->
                <div v-if="latestGaleris[0]" class="col-span-2 row-span-2 relative group overflow-hidden rounded-[2rem] cursor-pointer shadow-xl">
                    <img :src="getPhotoUrl(latestGaleris[0].image)" :alt="latestGaleris[0].judul" @error="handleImageError"
                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-0 left-0 p-6 md:p-8 transform group-hover:translate-y-[-8px] transition-transform">
                        <span class="px-3 py-1 bg-blue-500 text-white text-[10px] font-bold rounded-full uppercase tracking-tighter mb-3 inline-block">Terbaru</span>
                        <h3 class="text-xl md:text-2xl font-black text-white leading-tight line-clamp-2">{{ latestGaleris[0].judul }}</h3>
                        <p class="text-slate-300 text-xs mt-2 line-clamp-2 hidden md:block" v-if="latestGaleris[0].deskripsi">{{ latestGaleris[0].deskripsi }}</p>
                    </div>
                </div>

                <!-- Secondary Items (Smaller Grid) -->
                <template v-for="(photo, index) in latestGaleris.slice(1, 5)" :key="photo.id">
                    <div class="relative group overflow-hidden rounded-[1.5rem] cursor-pointer shadow-lg hover:shadow-2xl transition-all">
                        <img :src="getPhotoUrl(photo.image)" :alt="photo.judul" @error="handleImageError"
                            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-1">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                        
                        <!-- Tooltip-like caption on hover -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-gradient-to-t from-black/80 to-transparent">
                            <p class="text-white text-xs font-bold line-clamp-1">{{ photo.judul }}</p>
                        </div>
                    </div>
                </template>

            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <i class="fas fa-images text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 font-bold">Belum ada dokumentasi terbaru.</p>
            </div>
            
        </div>
    </section>
</template>
