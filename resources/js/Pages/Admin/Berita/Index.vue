<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    beritas: Object,
    categories: Array,
    filters: Object
});

const search = ref(props.filters?.search || '');
const kategori = ref(props.filters?.kategori || '');

watch([search, kategori], ([searchValue, kategoriValue]) => {
    router.get(route('admin.berita.index'), {
        search: searchValue,
        kategori: kategoriValue
    }, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
});

const page = usePage();
const notification = ref({ show: false, message: '', type: 'success' });

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

// Check for flash messages on load or change
watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
}, { immediate: true });

const deleteBerita = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
        router.delete(route('admin.berita.destroy', id), {
            preserveScroll: true,
            onSuccess: () => showNotification('Berita berhasil dihapus', 'success')
        });
    }
};

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/100x100?text=No+Photo';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/100x100?text=No+Photo';
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>
    <AdminLayout>

        <Head title="Kelola Berita" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-newspaper"></i> Informasi Publik
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Berita & Informasi</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Daftar seluruh kabar terbaru dan informasi resmi
                        kelurahan.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        <!-- Search Input -->
                        <div class="relative w-full sm:w-80">
                            <i
                                class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input v-model="search" type="text" placeholder="Cari berita..."
                                class="w-full pl-12 pr-5 py-4 bg-white border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-bold text-sm text-slate-900 shadow-sm">
                        </div>

                        <!-- Category Filter -->
                        <div class="relative w-full sm:w-64">
                            <i
                                class="fas fa-filter absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <select v-model="kategori"
                                class="w-full pl-12 pr-10 py-4 bg-white border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-bold text-sm text-slate-900 shadow-sm appearance-none cursor-pointer">
                                <option value="">Semua Kategori</option>
                                <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <Link :href="route('admin.berita.create')"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> BUAT BERITA BARU
                    </Link>
                </div>
            </div>

            <!-- Success Notification Popover -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="notification.show"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil!</p>
                        <p class="text-slate-500 text-xs font-bold">{{ notification.message }}</p>
                    </div>
                </div>
            </transition>

            <!-- News Table / List -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Berita</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Kategori</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Statistik</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr v-for="berita in beritas.data" :key="berita.id"
                                class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm bg-slate-100 shrink-0">
                                            <img :src="getPhotoUrl(berita.image)" :alt="berita.judul"
                                                @error="handleImageError" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4
                                                class="font-black text-slate-900 text-sm line-clamp-1 group-hover:text-blue-600 transition-colors uppercase">
                                                {{ berita.judul }}
                                            </h4>
                                            <p class="text-[10px] font-bold text-slate-400 mt-1">
                                                Diterbitkan: {{ formatDate(berita.created_at) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-tight">
                                        {{ berita.kategori }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4 text-slate-400">
                                        <div class="flex items-center gap-1.5 tooltip" title="Jumlah Pembaca">
                                            <i class="far fa-eye text-xs"></i>
                                            <span class="text-[10px] font-black">{{ berita.view_count }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-2 text-right">
                                        <a :href="route('informasi.berita.show', berita.slug)" target="_blank"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 flex items-center justify-center transition-all"
                                            title="Lihat di Web">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                        <Link :href="route('admin.berita.edit', berita.id)"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-amber-600 hover:bg-amber-50 flex items-center justify-center transition-all"
                                            title="Edit Berita">
                                            <i class="fas fa-edit text-xs"></i>
                                        </Link>
                                        <button @click="deleteBerita(berita.id)"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all"
                                            title="Hapus Berita">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="beritas.data.length === 0">
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                        <i class="fas fa-newspaper text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm">Belum ada berita yang diterbitkan.</p>
                                    <Link :href="route('admin.berita.create')"
                                        class="mt-4 inline-flex text-blue-600 font-black text-xs uppercase tracking-widest hover:underline">
                                        Buat Berita Pertama Anda
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="beritas.links.length > 3"
                    class="px-8 py-6 border-t border-slate-50 flex justify-center bg-slate-50/30">
                    <div class="flex gap-1">
                        <template v-for="(link, k) in beritas.links" :key="k">
                            <div v-if="link.url === null"
                                class="px-4 py-2 rounded-xl text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed"
                                v-html="link.label" />
                            <Link v-else
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
                                :class="link.active ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-blue-50'"
                                :href="link.url" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
