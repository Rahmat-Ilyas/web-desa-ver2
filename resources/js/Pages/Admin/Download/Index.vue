<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch, computed } from 'vue';
import { debounce } from 'lodash';

const props = defineProps({
    downloads: Object,
    filters: Object,
});

const isDeleteModalOpen = ref(false);
const itemToDelete = ref(null);
const search = ref(props.filters.search || '');

// Notification logic
const notification = ref({ show: false, message: '', type: 'success' });
const page = usePage();

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
}, { immediate: true });

// Search logic
watch(search, debounce((value) => {
    router.get(route('admin.download.index'), { search: value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}, 300));

// Delete modal logic
const openDeleteModal = (item) => {
    itemToDelete.value = item;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.download.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
                showNotification('Dokumen berhasil dihapus.', 'success');
            },
        });
    }
};

const getFileIcon = (type) => {
    switch (type?.toLowerCase()) {
        case 'pdf': return 'fa-file-pdf text-rose-500';
        case 'docx':
        case 'doc': return 'fa-file-word text-blue-500';
        case 'xlsx':
        case 'xls': return 'fa-file-excel text-emerald-500';
        case 'jpg':
        case 'jpeg':
        case 'png': return 'fa-file-image text-purple-500';
        default: return 'fa-file-alt text-slate-400';
    }
};
</script>

<template>
    <Head title="Manajemen Download" />

    <AdminLayout>
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-cloud-download-alt"></i> Pusat Download
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Manajemen Dokumen</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola file dan dokumen publik untuk diunduh warga.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        <!-- Search Input -->
                        <div class="relative w-full sm:w-80">
                            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input v-model="search" type="text" placeholder="Cari dokumen..."
                                class="w-full pl-12 pr-5 py-4 bg-white border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-bold text-sm text-slate-900 shadow-sm">
                        </div>
                    </div>

                    <Link :href="route('admin.download.create')"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> UPLOAD DOKUMEN
                    </Link>
                </div>
            </div>

        <!-- Success Notification Popover -->
        <transition enter-active-class="transform transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-10 z-[60] p-6 bg-white border border-emerald-100 rounded-2xl flex items-center gap-4 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] min-w-[300px]">
                <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-sm uppercase tracking-wide">Berhasil!</p>
                    <p class="text-slate-500 text-xs font-bold mt-0.5">{{ notification.message }}</p>
                </div>
                <button @click="notification.show = false" class="ml-auto text-slate-300 hover:text-slate-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </transition>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-6">Kategori</th>
                            <th class="px-8 py-6">Dokumen</th>
                            <th class="px-8 py-6">Info File</th>
                            <th class="px-8 py-6 text-center">Tanggal</th>
                            <th class="px-8 py-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="item in downloads.data" :key="item.id" class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-5">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border bg-slate-100/50 text-slate-600 border-slate-200">
                                    {{ item.kategori }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center">
                                        <i :class="['fas text-lg', getFileIcon(item.type)]"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors line-clamp-1">{{ item.judul }}</p>
                                        <p class="text-xs text-slate-400 font-medium line-clamp-1 mt-0.5">{{ item.deskripsi || 'Tidak ada deskripsi' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs font-bold text-slate-600 uppercase">{{ item.type }}</p>
                                <p class="text-xs text-slate-400 font-bold">{{ item.size }}</p>
                            </td>
                            <td class="px-8 py-5 text-center font-bold text-slate-500 text-xs">
                                {{ new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    <a :href="'/storage/' + item.file_path" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-emerald-200" title="Preview/Download">
                                        <i class="fas fa-download text-xs"></i>
                                    </a>
                                    <Link :href="route('admin.download.edit', item.id)" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-blue-200" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </Link>
                                    <button @click="openDeleteModal(item)" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-rose-200" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="downloads.data.length === 0">
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                    <i class="fas fa-folder-open text-3xl"></i>
                                </div>
                                <p class="text-slate-900 font-bold text-lg mb-1">Tidak ada dokumen</p>
                                <p class="text-slate-500 text-sm">Belum ada file yang diunggah.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div v-if="downloads.links.length > 3" class="px-8 py-6 border-t border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Link v-for="(link, k) in downloads.links" :key="k" 
                        :href="link.url || '#'" 
                        v-html="link.label"
                        :class="['px-4 py-2 rounded-xl text-xs font-bold transition-colors', 
                            link.active ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-50 text-slate-600 hover:bg-slate-100',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]" 
                        :preserve-scroll="true"
                    />
                </div>
                <p class="text-xs text-slate-400 font-bold">Menampilkan {{ downloads.from }} - {{ downloads.to }} dari {{ downloads.total }} data</p>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <transition enter-active-class="transition duration-200 ease-out" 
            enter-from-class="opacity-0 scale-95" 
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-150 ease-in" 
            leave-from-class="opacity-100 scale-100" 
            leave-to-class="opacity-0 scale-95">
            <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="closeDeleteModal"></div>
                
                <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative z-10 text-center">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                        <i class="fas fa-trash-alt text-3xl"></i>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-900 mb-2">Hapus Dokumen?</h3>
                    <p class="text-slate-500 font-medium text-sm mb-8 leading-relaxed">
                        Anda yakin ingin menghapus <strong class="text-slate-800">{{ itemToDelete?.judul }}</strong>? 
                        <br>File fisik juga akan dihapus dari server.
                    </p>

                    <div class="flex gap-4">
                        <button type="button" @click="closeDeleteModal" class="flex-1 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-slate-200 transition-colors">
                            Batalkan
                        </button>
                        <button type="button" @click="confirmDelete" class="flex-1 bg-rose-600 text-white font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-rose-500 transition-all shadow-xl shadow-rose-500/30 active:scale-95">
                            Ya, Hapus!
                        </button>
                    </div>
                </div>
            </div>
        </transition>
        </div>
    </AdminLayout>
</template>
