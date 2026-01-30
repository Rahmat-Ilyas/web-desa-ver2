<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    latestBeritas: Array
});

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/600x400?text=Berita+Kelurahan';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/600x400?text=Berita+Kelurahan';
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div class="max-w-2xl">
                    <span class="text-blue-600 font-bold tracking-wider uppercase text-xs">Kabar {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }}</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight uppercase">Info & Kegiatan
                        Terbaru</h2>
                    <p class="mt-4 text-gray-500 font-medium">Ikuti perkembangan terbaru dan kegiatan pembangunan di
                        lingkungan
                        kami.</p>
                </div>
                <Link :href="route('informasi.berita')"
                    class="inline-flex items-center font-black text-blue-600 hover:text-blue-700 transition-colors text-sm uppercase tracking-widest">
                    Lihat Semua Berita <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </Link>
            </div>

            <div v-if="latestBeritas && latestBeritas.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <article v-for="berita in latestBeritas" :key="berita.id" class="flex flex-col group">
                    <div class="relative overflow-hidden rounded-[2rem] h-64 mb-6 shadow-sm">
                        <div
                            class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-[10px] font-black text-blue-800 shadow-sm z-10 uppercase tracking-widest">
                            {{ formatDate(berita.created_at) }}
                        </div>
                        <img :src="getPhotoUrl(berita.image)" :alt="berita.judul" @error="handleImageError"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="flex-1 px-2">
                        <span class="text-blue-600 font-black text-[10px] uppercase tracking-[0.2em]">{{ berita.kategori
                        }}</span>
                        <Link :href="route('informasi.berita.show', berita.slug)">
                            <h3
                                class="text-xl font-black text-gray-900 mt-3 mb-4 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight">
                                {{ berita.judul }}
                            </h3>
                        </Link>
                        <p class="text-gray-500 text-sm font-medium line-clamp-3 leading-relaxed mb-6">
                            {{ berita.konten.replace(/<[^>]*>?/gm, '').substring(0, 120) }}...
                        </p>
                        <Link :href="route('informasi.berita.show', berita.slug)"
                            class="inline-flex items-center gap-2 text-blue-600 font-black text-[10px] uppercase tracking-widest group/btn">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                        </Link>
                    </div>
                </article>
            </div>

            <div v-else class="py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Belum ada berita terbaru</p>
            </div>
        </div>
    </section>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
