<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    potensis: Array,
    categories: Array
});

const selectedCategory = ref('Semua');
const categories = computed(() => {
    const cats = props.categories && props.categories.length > 0 ? props.categories : ['Wisata Alam', 'UMKM & Produk', 'Pertanian', 'Seni Budaya', 'Kuliner'];
    return ['Semua', ...cats];
});

const filteredItems = computed(() => {
    if (selectedCategory.value === 'Semua') {
        return props.potensis;
    }
    return props.potensis.filter(item => item.kategori === selectedCategory.value);
});

// Modal State
const selectedItem = ref(null);
const isModalOpen = ref(false);

const openModal = (item) => {
    selectedItem.value = item;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';

    // Update URL hash/query without reload
    const url = new URL(window.location);
    url.searchParams.set('id', item.id);
    window.history.pushState({}, '', url);
};

const closeModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = 'auto';

    // Remove query param
    const url = new URL(window.location);
    url.searchParams.delete('id');
    window.history.pushState({}, '', url);
};

const getImage = (path) => {
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};

const shareTo = (platform, item) => {
    const url = `${window.location.origin}${window.location.pathname}?id=${item.id}`;
    const text = `Cek Potensi Unggulan ${usePage().props.settings?.nama_wilayah || '[Nama Wilayah]'}: ${item.judul}\n`;

    if (platform === 'wa') {
        window.open(`https://wa.me/?text=${encodeURIComponent(text + url)}`, '_blank');
    } else if (platform === 'fb') {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(text)}`, '_blank');
    } else if (platform === 'copy') {
        navigator.clipboard.writeText(text + url).then(() => {
            alert('Link berhasil disalin!');
        });
    }
};

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (id) {
        const item = props.potensis.find(p => p.id == id);
        if (item) {
            openModal(item);
        }
    }
});
</script>

<template>

    <Head title="Potensi Unggulan" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-emerald-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30 rotate-3">
                    <i class="fas fa-tree text-3xl text-emerald-100"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Potensi Unggulan</h1>
                <p class="text-emerald-100 text-lg max-w-2xl mx-auto font-medium">Jelajahi kekayaan alam, budaya, dan
                    kreativitas warga yang menjadi kebanggaan kami.</p>
            </div>
        </div>

        <div class="py-16 bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Category Filter -->
                <div class="flex flex-wrap justify-center gap-3 mb-16">
                    <button v-for="cat in categories" :key="cat" @click="selectedCategory = cat"
                        class="px-6 py-3 rounded-full text-sm font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-lg border-2"
                        :class="selectedCategory === cat ? 'bg-emerald-600 text-white border-emerald-600 shadow-emerald-500/30' : 'bg-white text-slate-500 border-slate-100 hover:border-emerald-200'">
                        {{ cat }}
                    </button>
                </div>

                <!-- Masonry Grid -->
                <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
                    <div v-for="item in filteredItems" :key="item.id"
                        class="break-inside-avoid bg-white rounded-[2rem] border border-slate-100 shadow-lg shadow-emerald-900/5 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group overflow-hidden cursor-pointer"
                        @click="openModal(item)">

                        <div class="relative h-64 overflow-hidden">
                            <img :src="getImage(item.image)" :alt="item.judul"
                                @error="e => e.target.src = 'https://placehold.co/800x600/e2e8f0/94a3b8?text=No+Image'"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60 group-hover:opacity-40 transition-opacity">
                            </div>
                            <span
                                class="absolute top-4 right-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-800 shadow-lg">
                                {{ item.kategori }}
                            </span>
                        </div>

                        <div class="p-8">
                            <h3
                                class="text-2xl font-black text-slate-900 mb-3 leading-tight group-hover:text-emerald-600 transition-colors">
                                {{ item.judul }}</h3>
                            <div v-if="item.lokasi"
                                class="flex items-center gap-2 text-rose-500 text-xs font-bold mb-4 uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt"></i> {{ item.lokasi }}
                            </div>
                            <p class="text-slate-500 line-clamp-3 text-sm font-medium leading-relaxed mb-6">{{
                                item.deskripsi }}</p>

                            <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-50">
                                <div
                                    class="flex items-center text-emerald-600 font-black text-xs uppercase tracking-widest group-hover:gap-2 transition-all">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                                </div>
                                <button @click.stop="shareTo('wa', item)"
                                    class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm"
                                    title="Bagikan ke WhatsApp">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="filteredItems.length === 0" class="text-center py-20">
                    <div
                        class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                        <i class="fas fa-search text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Tidak ada data ditemukan.</h3>
                    <p class="text-slate-500">Coba pilih kategori lain.</p>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" role="dialog">
                <div class="fixed inset-0 bg-slate-900/90 backdrop-blur transition-opacity" @click="closeModal"></div>

                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="relative bg-white rounded-[3rem] w-full max-w-4xl overflow-hidden shadow-2xl transform transition-all flex flex-col md:flex-row">
                        <button @click="closeModal"
                            class="absolute top-4 right-4 z-20 w-10 h-10 bg-white/20 backdrop-blur hover:bg-white text-white hover:text-slate-900 rounded-full flex items-center justify-center transition-all">
                            <i class="fas fa-times"></i>
                        </button>

                        <!-- Image Side -->
                        <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-slate-900">
                            <img v-if="selectedItem" :src="getImage(selectedItem.image)" :alt="selectedItem.judul"
                                @error="e => e.target.src = 'https://placehold.co/800x600/e2e8f0/94a3b8?text=No+Image'"
                                class="w-full h-full object-cover opacity-90">
                        </div>

                        <!-- Content Side -->
                        <div
                            class="w-full md:w-1/2 p-8 md:p-12 md:max-h-[85vh] overflow-y-auto custom-scrollbar bg-white">
                            <div v-if="selectedItem">
                                <span
                                    class="inline-block px-4 py-2 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest mb-6">
                                    {{ selectedItem.kategori }}
                                </span>

                                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-6 leading-tight">{{
                                    selectedItem.judul }}</h2>

                                <div v-if="selectedItem.lokasi"
                                    class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
                                    <div
                                        class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-500 shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Lokasi</p>
                                        <p class="font-bold text-slate-900 text-sm">{{ selectedItem.lokasi }}</p>
                                    </div>
                                </div>

                                <div class="prose prose-slate prose-lg max-w-none mb-8">
                                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{
                                        selectedItem.deskripsi }}</p>
                                </div>

                                <div class="flex items-center gap-4 mb-8">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bagikan:
                                    </p>
                                    <div class="flex gap-2">
                                        <button @click="shareTo('wa', selectedItem)"
                                            class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all"
                                            title="Share ke WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <button @click="shareTo('fb', selectedItem)"
                                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"
                                            title="Share ke Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                        <button @click="shareTo('copy', selectedItem)"
                                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-600 hover:text-white transition-all"
                                            title="Salin Link">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-10 pt-8 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-xs font-bold text-slate-400">Diposting pada {{ new
                                        Date(selectedItem.created_at).toLocaleDateString('id-ID', {
                                            day: 'numeric',
                                            month: 'long', year: 'numeric'
                                        }) }}</span>
                                    <button @click="closeModal"
                                        class="text-emerald-600 font-black text-xs uppercase tracking-widest hover:underline">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </MainLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
