<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, watch, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    galeris: Object, // Changed to Object to accept Paginated Resource
    currentCategory: String
});

const categories = ['Semua', 'Kegiatan', 'Pembangunan', 'Sosial', 'Keagamaan'];
const activeCategory = ref(props.currentCategory || 'Semua');
const selectedPhoto = ref(null);
const selectedPhotoIndex = ref(-1);

// Watch for category changes to trigger server-side filtering
watch(activeCategory, (newCategory) => {
    router.get(route('galeri'), {
        kategori: newCategory === 'Semua' ? null : newCategory
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['galeris', 'currentCategory']
    });
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

// Lightbox Functions
const openLightbox = (photo, index) => {
    selectedPhoto.value = photo;
    selectedPhotoIndex.value = index;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    selectedPhoto.value = null;
    selectedPhotoIndex.value = -1;
    document.body.style.overflow = '';
};

const nextPhoto = () => {
    if (selectedPhotoIndex.value < props.galeris.data.length - 1) {
        selectedPhotoIndex.value++;
        selectedPhoto.value = props.galeris.data[selectedPhotoIndex.value];
    }
};

const prevPhoto = () => {
    if (selectedPhotoIndex.value > 0) {
        selectedPhotoIndex.value--;
        selectedPhoto.value = props.galeris.data[selectedPhotoIndex.value];
    }
};

// Keyboard navigation
const handleKeydown = (e) => {
    if (!selectedPhoto.value) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextPhoto();
    if (e.key === 'ArrowLeft') prevPhoto();
};

onMounted(() => window.addEventListener('keydown', handleKeydown));
onUnmounted(() => window.removeEventListener('keydown', handleKeydown));

</script>

<template>

    <Head title="Galeri Kegiatan" />

    <MainLayout>
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center p-3 mb-6 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl">
                    <i class="fas fa-images text-3xl text-blue-200"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4 drop-shadow-sm">
                    Galeri Dokumentasi
                </h1>
                <p class="text-blue-100 text-lg font-medium max-w-2xl mx-auto leading-relaxed">
                    Arsip visual kegiatan pemerintahan, pembangunan infrastruktur, dan aktivitas sosial kemasyarakatan
                    di Kelurahan Ujung Sabbang.
                </p>
            </div>
        </div>

        <div class="py-16 bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Filters -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <button v-for="cat in categories" :key="cat" @click="activeCategory = cat" :class="[
                        'px-6 py-2 rounded-full font-bold transition-all duration-300 shadow-sm border',
                        activeCategory === cat ? 'bg-blue-600 text-white border-blue-600 scale-105' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-400 hover:text-blue-600'
                    ]">
                        {{ cat }}
                    </button>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div v-for="(photo, index) in galeris.data" :key="photo.id"
                        @click="openLightbox(photo, index)"
                        class="group relative overflow-hidden rounded-2xl aspect-square bg-gray-100 shadow-lg border border-gray-100 cursor-pointer">
                        <img :src="getPhotoUrl(photo.image)" :alt="photo.judul" @error="handleImageError"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <span class="text-blue-400 text-xs font-bold uppercase tracking-widest mb-1">{{
                                photo.kategori }}</span>
                            <h3 class="text-white font-bold text-sm leading-tight">{{ photo.judul }}</h3>
                            <p v-if="photo.deskripsi" class="text-gray-300 text-[10px] mt-1 line-clamp-2">{{
                                photo.deskripsi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="galeris.data.length === 0" class="py-20 text-center">
                    <i class="fas fa-image text-6xl text-gray-200 mb-4 block"></i>
                    <p class="text-gray-400">Belum ada foto dalam kategori ini.</p>
                </div>

                <!-- Pagination -->
                <div v-if="galeris.links.length > 3" class="flex justify-center mt-12">
                    <div class="flex gap-1 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                        <template v-for="(link, k) in galeris.links" :key="k">
                            <div v-if="link.url === null" class="px-4 py-2 rounded-xl text-gray-300 text-xs font-bold"
                                v-html="link.label" />
                            <Link v-else class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                                :class="link.active ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600'"
                                :href="link.url" v-html="link.label" preserve-scroll />
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="selectedPhoto" class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4">
                
                <!-- Close Button -->
                <button @click="closeLightbox"
                    class="absolute top-4 right-4 text-white/50 hover:text-white transition-colors z-[110]">
                    <i class="fas fa-times text-2xl"></i>
                </button>

                <!-- Navigation Buttons -->
                <button v-if="selectedPhotoIndex > 0" @click.stop="prevPhoto"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-[110]">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button v-if="selectedPhotoIndex < galeris.data.length - 1" @click.stop="nextPhoto"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-[110]">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Main Content -->
                <div class="relative max-w-5xl w-full max-h-screen flex flex-col items-center">
                    <div class="relative w-auto h-auto max-h-[80vh] overflow-hidden rounded-lg shadow-2xl">
                        <img :src="getPhotoUrl(selectedPhoto.image)" :alt="selectedPhoto.judul"
                            class="max-w-full max-h-[80vh] object-contain mx-auto" @error="handleImageError">
                    </div>
                    
                    <div class="mt-4 text-center text-white max-w-2xl">
                        <span class="inline-block px-3 py-1 rounded-full bg-blue-600/80 text-[10px] font-black uppercase tracking-widest mb-2 border border-blue-400/30">
                            {{ selectedPhoto.kategori }}
                        </span>
                        <h2 class="text-2xl font-bold mb-2">{{ selectedPhoto.judul }}</h2>
                        <p class="text-gray-300 text-sm leading-relaxed">{{ selectedPhoto.deskripsi }}</p>
                        <p class="text-gray-500 text-xs mt-2 font-mono">
                             {{ new Date(selectedPhoto.tanggal).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) }}
                        </p>
                    </div>
                </div>
            </div>
        </transition>

    </MainLayout>
</template>
