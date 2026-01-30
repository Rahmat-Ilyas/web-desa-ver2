<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    beritas: Object,
    categories: Array,
    currentCategory: String,
    filters: Object
});

const search = ref(props.filters?.search || '');

watch(search, (value) => {
    router.get(route('informasi.berita'), { search: value, kategori: props.currentCategory }, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
});

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/800x600?text=Berita+Kelurahan';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/800x600?text=Berita+Kelurahan';
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>

    <Head title="Kabar & Berita Kelurahan" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-blue-600 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-50 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30 rotate-3">
                    <i class="fas fa-newspaper text-3xl text-blue-100"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Informasi & Berita</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto font-medium">Kumpulan kabar terbaru, pengumuman resmi,
                    dan dokumentasi kegiatan di lingkungan {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{
                        $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
            </div>
        </div>

        <div class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12">

                    <!-- Sidebar (Left on Desktop, Top on Mobile) -->
                    <div class="lg:w-1/3 space-y-8 order-2 lg:order-1">

                        <!-- Categories Card -->
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                            <h3 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <i class="fas fa-layer-group text-blue-600"></i> Kategori Berita
                            </h3>
                            <div class="flex flex-col gap-2">
                                <Link :href="route('informasi.berita')"
                                    class="px-5 py-3.5 rounded-2xl font-bold transition-all flex items-center justify-between group"
                                    :class="!currentCategory ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'">
                                    <span>Semua Berita</span>
                                    <i
                                        class="fas fa-chevron-right text-[10px] opacity-50 group-hover:translate-x-1 transition-transform"></i>
                                </Link>
                                <Link v-for="cat in categories" :key="cat"
                                    :href="route('informasi.berita', { kategori: cat })"
                                    class="px-5 py-3.5 rounded-2xl font-bold transition-all flex items-center justify-between group"
                                    :class="currentCategory === cat ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'">
                                    <span>{{ cat }}</span>
                                    <i
                                        class="fas fa-chevron-right text-[10px] opacity-50 group-hover:translate-x-1 transition-transform"></i>
                                </Link>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-blue-900/20">
                            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl">
                            </div>
                            <h3 class="text-2xl font-black mb-4 relative z-10">Punya Informasi?</h3>
                            <p class="text-blue-100 font-medium text-sm mb-6 leading-relaxed relative z-10">
                                Sampaikan berita atau kegiatan di lingkungan sekitar Anda untuk kami publikasikan di
                                sini.
                            </p>
                            <a v-if="$page.props.settings?.info_umum?.whatsapp"
                                :href="'https://wa.me/' + $page.props.settings.info_umum.whatsapp" target="_blank"
                                class="flex items-center justify-center gap-3 w-full py-4 bg-white text-emerald-600 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-emerald-50 hover:-translate-y-1 transition-all shadow-xl shadow-blue-900/10 active:scale-[0.98] relative z-10 border border-emerald-100/50">
                                <i class="fab fa-whatsapp text-lg"></i>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Main News List (Right on Desktop) -->
                    <div class="lg:w-2/3 order-1 lg:order-2">
                        <!-- Search Bar -->
                        <div class="mb-10 relative">
                            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input v-model="search" type="text" placeholder="Cari berita atau informasi..."
                                class="w-full pl-14 pr-6 py-5 bg-white border border-slate-100 rounded-[2rem] focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-medium text-slate-900 shadow-sm">
                        </div>

                        <div v-if="beritas.data.length > 0" class="space-y-10">
                            <!-- News Cards -->
                            <div v-for="berita in beritas.data" :key="berita.id"
                                class="group flex flex-col md:flex-row gap-8 bg-white p-6 rounded-[2.5rem] border border-slate-100 hover:shadow-2xl hover:shadow-slate-900/5 transition-all duration-500">
                                <div
                                    class="md:w-2/5 h-64 md:h-auto min-h-[250px] rounded-[2rem] overflow-hidden shrink-0 relative shadow-sm bg-slate-100">
                                    <img :src="getPhotoUrl(berita.image)" :alt="berita.judul" @error="handleImageError"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="px-4 py-1.5 bg-white/90 backdrop-blur rounded-full text-[10px] font-black text-blue-600 uppercase tracking-widest shadow-sm">
                                            {{ berita.kategori }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center py-2">
                                    <div
                                        class="flex items-center gap-3 mb-3 text-slate-400 font-bold text-xs uppercase tracking-widest">
                                        <i class="far fa-calendar-alt text-blue-500"></i>
                                        <span>{{ formatDate(berita.created_at) }}</span>
                                    </div>
                                    <Link :href="route('informasi.berita.show', berita.slug)"
                                        class="group-hover:text-blue-600 transition-colors">
                                        <h2
                                            class="text-2xl font-black text-slate-900 mb-4 line-clamp-2 leading-tight tracking-tight">
                                            {{ berita.judul }}
                                        </h2>
                                    </Link>
                                    <!-- Use v-html carefully, here we strip tags or limit for excerpt if needed, 
                                         but we can also use a helper to strip tags for the preview -->
                                    <p class="text-slate-500 font-medium line-clamp-2 mb-6 text-sm leading-relaxed">
                                        {{ berita.konten.replace(/<[^>]*>?/gm, '').substring(0, 150) }}...
                                    </p>
                                    <Link :href="route('informasi.berita.show', berita.slug)"
                                        class="inline-flex items-center gap-2 text-blue-600 font-black text-xs uppercase tracking-[0.2em] group/btn hover:gap-3 transition-all">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div v-if="beritas.links.length > 3" class="pt-10 flex justify-center">
                                <div class="flex flex-wrap gap-2">
                                    <template v-for="(link, k) in beritas.links" :key="k">
                                        <div v-if="link.url === null"
                                            class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-400 font-black text-xs uppercase tracking-widest cursor-not-allowed"
                                            v-html="link.label" />
                                        <Link v-else
                                            class="px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all"
                                            :class="link.active ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20' : 'bg-white border border-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600'"
                                            :href="link.url" v-html="link.label" />
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else
                            class="bg-white rounded-[3rem] p-20 text-center border border-dashed border-slate-200">
                            <div
                                class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                                <i class="fas fa-folder-open text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Belum Ada Berita</h3>
                            <p class="text-slate-500 font-medium">Mohon maaf, saat ini sedang belum ada berita untuk
                                kategori ini.</p>
                            <Link :href="route('informasi.berita')"
                                class="mt-8 inline-flex px-8 py-3 bg-blue-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20">
                                Lihat Semua Berita
                            </Link>
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
</style>
