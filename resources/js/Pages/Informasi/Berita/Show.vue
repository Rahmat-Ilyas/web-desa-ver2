<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    berita: Object,
    latestBeritas: Array,
    categories: Array
});

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/1200x600?text=Berita+Kelurahan';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/1200x600?text=Berita+Kelurahan';
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>

    <Head :title="berita.judul" />

    <MainLayout>
        <!-- Article Header / Hero -->
        <div class="relative bg-slate-900 pt-8 pb-16 overflow-hidden">
            <div
                class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px]">
            </div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-left">
                <Link :href="route('informasi.berita', { kategori: berita.kategori })"
                    class="inline-block px-5 py-2 rounded-full bg-blue-600/20 backdrop-blur-md border border-blue-500/20 text-blue-400 text-[10px] font-black tracking-[0.2em] uppercase mb-5 hover:bg-blue-600/30 transition-all">
                    {{ berita.kategori }}
                </Link>
                <h1
                    class="text-2xl md:text-4xl lg:text-5xl font-black text-white tracking-tight mb-6 leading-[1.2] drop-shadow-2xl max-w-4xl">
                    {{ berita.judul }}
                </h1>

                <div
                    class="flex flex-wrap items-center justify-start gap-6 text-slate-400 font-bold text-xs uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-500"></i>
                        <span class="text-slate-200">{{ berita.user ? berita.user.name : 'Administrator' }}</span>
                    </div>
                    <div class="flex items-center gap-2 border-l border-slate-700 pl-6">
                        <i class="far fa-calendar-alt text-blue-500"></i>
                        <span>{{ formatDate(berita.created_at) }}</span>
                    </div>
                    <div class="flex items-center gap-2 border-l border-slate-700 pl-6">
                        <i class="far fa-eye text-blue-500"></i>
                        <span>{{ berita.view_count }} Dilihat</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-16">

                    <!-- Main Content -->
                    <div class="lg:w-2/3">
                        <!-- Featured Image -->
                        <div
                            class="relative rounded-[3rem] overflow-hidden shadow-2xl mb-12 -mt-32 border-8 border-white bg-slate-100">
                            <img :src="getPhotoUrl(berita.image)" :alt="berita.judul" @error="handleImageError"
                                class="w-full h-[300px] md:h-[480px] object-cover">
                        </div>

                        <!-- Article Content -->
                        <div class="prose prose-slate prose-lg max-w-none">
                            <div class="text-slate-700 leading-relaxed space-y-6 text-lg font-medium article-content"
                                v-html="berita.konten"></div>
                        </div>

                        <!-- Share / Footer -->
                        <div
                            class="mt-20 pt-10 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Share:</span>
                                <div class="flex gap-2">
                                    <button
                                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i class="fab fa-facebook-f text-sm"></i>
                                    </button>
                                    <button
                                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-sky-400 hover:text-white transition-all shadow-sm">
                                        <i class="fab fa-twitter text-sm"></i>
                                    </button>
                                    <button
                                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                                        <i class="fab fa-whatsapp text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <Link :href="route('informasi.berita')"
                                class="flex items-center gap-2 text-slate-400 hover:text-blue-600 font-black text-xs uppercase tracking-widest transition-all">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Berita
                            </Link>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/3 space-y-12">

                        <!-- Recent News -->
                        <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100">
                            <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                                <i class="fas fa-bolt text-amber-500"></i> Berita Terbaru
                            </h3>
                            <div class="space-y-8">
                                <div v-for="recent in latestBeritas" :key="recent.id" class="group flex gap-4">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 shadow-sm">
                                        <img :src="getPhotoUrl(recent.image)" :alt="recent.judul"
                                            @error="handleImageError"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <Link :href="route('informasi.berita.show', recent.slug)"
                                            class="group-hover:text-blue-600 transition-colors">
                                            <h4
                                                class="text-sm font-black text-slate-900 leading-snug line-clamp-2 uppercase">
                                                {{ recent.judul }}
                                            </h4>
                                        </Link>
                                        <span
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                            {{ formatDate(recent.created_at) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Categories List -->
                        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
                            <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                                <i class="fas fa-tags text-blue-600"></i> Kategori
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <Link v-for="cat in categories" :key="cat"
                                    :href="route('informasi.berita', { kategori: cat })"
                                    class="px-4 py-2 bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                                    {{ cat }}
                                </Link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.article-content :deep(p) {
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.article-content :deep(strong) {
    color: #0f172a;
    font-weight: 800;
}

.article-content :deep(img) {
    max-width: 100%;
    height: auto !important;
    border-radius: 2rem;
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    margin: 2rem 0;
}
</style>
