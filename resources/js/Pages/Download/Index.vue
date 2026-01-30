<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    downloads: Array
});

// Notification State
const notification = ref({
    show: false,
    message: '',
    type: 'error'
});

const showNotification = (msg, type = 'error') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

// Download Handler
const handleDownload = (doc) => {
    // 1. Check if it is a dummy file
    if (doc.file_path.startsWith('dummy/')) {
        showNotification('Mohon maaf, file dokumen ini belum tersedia untuk diunduh saat ini.', 'error');
        return;
    }

    // 2. Check if file exists (optional, simply try to download and handle error if needed, 
    // but detecting 404 client-side before navigation provides better UX)
    const fileUrl = `/storage/${doc.file_path}`;

    // We try to fetch HEAD to check existence
    fetch(fileUrl, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                // Trigger download
                const link = document.createElement('a');
                link.href = fileUrl;
                link.download = doc.judul; // Use doc title as filename
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                showNotification('Maaf, file dokumen tidak ditemukan di server (404).', 'error');
            }
        })
        .catch(() => {
            showNotification('Gagal menghubungi server. Periksa koneksi internet Anda.', 'error');
        });
};

// Helper to get icon class based on file type
const getFileIcon = (type) => {
    switch (type?.toLowerCase()) {
        case 'pdf': return 'fas fa-file-pdf';
        case 'docx':
        case 'doc': return 'fas fa-file-word';
        case 'xlsx':
        case 'xls': return 'fas fa-file-excel';
        default: return 'fas fa-file';
    }
};
</script>

<template>

    <Head title="Pusat Download Dokumen" />

    <MainLayout>
        <div class="bg-gray-800 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 mx-auto bg-white/10 backdrop-blur rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-download text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Pusat Download</h1>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">Unduh berbagai formulir layanan, peraturan, dan
                    laporan {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{
                        $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
            </div>
        </div>

        <!-- Notification Popover -->
        <transition enter-active-class="transform transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-4 md:right-10 z-[60] p-6 bg-white border border-rose-100 rounded-2xl flex items-center gap-4 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] min-w-[300px] max-w-md">
                <div
                    class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-rose-500/30 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-sm uppercase tracking-wide">Gagal Download</p>
                    <p class="text-slate-500 text-xs font-bold mt-0.5">{{ notification.message }}</p>
                </div>
                <button @click="notification.show = false" class="ml-auto text-slate-300 hover:text-slate-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </transition>

        <div class="py-16 bg-gray-50 min-h-screen">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div
                        class="p-8 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                        <h2 class="text-xl font-bold text-gray-900">Daftar Dokumen</h2>
                        <span class="text-sm text-gray-500">{{ downloads.length }} Dokumen tersedia</span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div v-for="doc in downloads" :key="doc.id"
                            class="p-6 hover:bg-gray-50 transition-colors flex items-center group">
                            <div
                                class="w-12 h-12 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center text-xl mr-6 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                <i :class="getFileIcon(doc.type)"></i>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{
                                    doc.judul }}</h3>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{
                                        doc.kategori }}</span>
                                    <span class="text-xs text-gray-300">•</span>
                                    <span class="text-xs text-gray-500">{{ doc.type }} ({{ doc.size }})</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ doc.deskripsi }}</p>
                            </div>
                            <button @click="handleDownload(doc)"
                                class="ml-4 p-3 px-4 bg-gray-100 text-gray-600 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm cursor-pointer"
                                title="Download File">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                        <div v-if="downloads.length === 0" class="p-12 text-center text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-3"></i>
                            <p>Belum ada dokumen yang tersedia.</p>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-12 p-8 bg-blue-900 rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
                    <div class="text-center md:text-left">
                        <h4 class="text-xl font-bold mb-1">Butuh dokumen lain?</h4>
                        <p class="text-blue-100 text-sm">Jika dokumen yang Anda cari tidak tersedia, silakan hubungi
                            layanan pengaduan kami.</p>
                    </div>
                    <a v-if="$page.props.settings?.info_umum?.whatsapp"
                        :href="'https://wa.me/' + $page.props.settings.info_umum.whatsapp" target="_blank"
                        class="px-8 py-3 bg-emerald-500 text-white font-bold rounded-full hover:bg-emerald-600 transition-colors shadow-lg flex items-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i> Hubungi Petugas
                    </a>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
