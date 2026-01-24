<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    pengaduans: Object,
});

const page = usePage();
const notification = ref({ show: false, message: '', type: 'success' });

// Modal State
const showDetailModal = ref(false);
const selectedAduan = ref(null);

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
});

const openDetail = (aduan) => {
    selectedAduan.value = aduan;
    showDetailModal.value = true;
};

const closeDetail = () => {
    showDetailModal.value = false;
    selectedAduan.value = null;
};

const updateStatus = (id, status) => {
    router.put(route('admin.pengaduan.update', id), { status }, {
        preserveScroll: true,
        onSuccess: () => {
            showNotification('Status aduan berhasil diperbarui');
            if (selectedAduan.value) {
                selectedAduan.value.status = status;
            }
        }
    });
};

const deleteAduan = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus aduan ini?')) {
        router.delete(route('admin.pengaduan.destroy', id), {
            preserveScroll: true,
            onSuccess: () => showNotification('Aduan berhasil dihapus')
        });
    }
};

const getStatusClass = (status) => {
    switch (status) {
        case 'pending': return 'bg-amber-50 text-amber-600 border-amber-100';
        case 'proses': return 'bg-blue-50 text-blue-600 border-blue-100';
        case 'selesai': return 'bg-emerald-50 text-emerald-600 border-emerald-100';
        case 'ditolak': return 'bg-rose-50 text-rose-600 border-rose-100';
        default: return 'bg-slate-50 text-slate-600 border-slate-100';
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
};

const getReplyWAUrl = (item) => {
    // Clean phone number: remove non-digits and ensure 62 prefix
    let phone = item.phone.replace(/\D/g, '');
    if (phone.startsWith('0')) {
        phone = '62' + phone.substring(1);
    } else if (phone.startsWith('8')) {
        phone = '62' + phone;
    }

    const message = `Halo Bapak/Ibu ${item.nama},
    
Saya admin Kelurahan Ujung Sabbang ingin menindaklanjuti aduan Anda (${item.kode}).
    
Isi Aduan: "${item.pesan}"

Tanggapan Admin: `;
    return `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
};
</script>

<template>
    <AdminLayout>

        <Head title="Kelola Pengaduan Warga" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-exclamation-circle"></i> Layanan Warga
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Pengaduan Warga</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Pantau dan tindak lanjuti laporan serta aspirasi
                        dari masyarakat.</p>
                </div>
            </div>

            <!-- Success Notification -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="notification.show"
                    class="fixed bottom-10 right-10 z-[70] p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
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

            <!-- Complaint Table -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Kode</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Waktu & Pelapor</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Kategori</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Pesan</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr v-for="item in pengaduans.data" :key="item.id"
                                class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-black rounded-lg tracking-tighter border border-slate-200">
                                        {{ item.kode }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-[10px] font-bold text-slate-400 mb-1">{{ formatDate(item.created_at)
                                    }}</p>
                                    <p class="font-black text-slate-900 text-sm whitespace-nowrap">{{ item.nama }}</p>
                                    <p class="text-[10px] font-bold text-blue-500 tracking-wider">{{ item.phone }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-tight">
                                        {{ item.kategori }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs font-bold text-slate-500 line-clamp-2 max-w-xs">{{ item.pesan }}
                                    </p>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        :class="['px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border', getStatusClass(item.status)]">
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                        <a :href="getReplyWAUrl(item)" target="_blank"
                                            class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-emerald-200"
                                            title="Respon via WhatsApp">
                                            <i class="fab fa-whatsapp text-xs"></i>
                                        </a>
                                        <button @click="openDetail(item)"
                                            class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-blue-200"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button @click="deleteAduan(item.id)"
                                            class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-rose-200"
                                            title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="pengaduans.data.length === 0">
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-inbox text-2xl text-slate-200"></i>
                                    </div>
                                    <p class="font-bold text-sm">Belum ada aduan warga saat ini.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="pengaduans.links.length > 3"
                    class="px-8 py-6 border-t border-slate-50 flex justify-center bg-slate-50/30">
                    <div class="flex gap-1">
                        <template v-for="(link, k) in pengaduans.links" :key="k">
                            <div v-if="link.url === null"
                                class="px-4 py-2 rounded-xl text-slate-300 text-[10px] font-black uppercase tracking-widest cursor-not-allowed"
                                v-html="link.label" />
                            <Link v-else
                                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
                                :class="link.active ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'text-slate-500 hover:bg-rose-50'"
                                :href="link.url" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>

            <!-- Detail Modal -->
            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="showDetailModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        @click="closeDetail"></div>

                    <div
                        class="bg-white rounded-[3rem] w-full max-w-2xl max-h-[85vh] flex flex-col shadow-2xl relative z-10 overflow-hidden">
                        <!-- Fixed Header -->
                        <div class="p-8 md:p-10 pb-6 border-b border-slate-50 bg-white relative z-20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        :class="['px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border mb-2 inline-block', getStatusClass(selectedAduan.status)]">
                                        {{ selectedAduan.status }}
                                    </span>
                                    <h3 class="text-2xl font-black text-slate-900">Detail Aduan</h3>
                                </div>
                                <button @click="closeDetail"
                                    class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 flex items-center justify-center transition-all shadow-sm">
                                    <i class="fas fa-times text-lg"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Scrollable Content -->
                        <div class="flex-grow overflow-y-auto p-8 md:p-10 custom-scrollbar">
                            <div class="space-y-10">
                                <div class="grid grid-cols-2 gap-8 border-b border-slate-50 pb-8">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                            Kode Aduan
                                        </p>
                                        <p
                                            class="font-black text-rose-600 bg-rose-50 px-4 py-2 rounded-2xl text-xl inline-block tracking-tighter border border-rose-100 italic shadow-sm shadow-rose-500/5">
                                            {{ selectedAduan.kode }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                            Waktu Laporan</p>
                                        <p class="font-black text-slate-700 text-sm bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100 inline-block">{{
                                            formatDate(selectedAduan.created_at) }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-8 border-b border-slate-50 pb-8">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                            Identitas Pelapor</p>
                                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-[2rem] border border-slate-100">
                                            <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-blue-500 shadow-sm border border-slate-100 flex-shrink-0">
                                                <i class="fas fa-user-circle text-2xl"></i>
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900 leading-none mb-1">{{ selectedAduan.nama }}</p>
                                                <a :href="getReplyWAUrl(selectedAduan)" target="_blank"
                                                    class="text-xs font-bold text-blue-500 hover:text-blue-600 flex items-center gap-1 transition-colors">
                                                    <i class="fab fa-whatsapp text-sm"></i> {{ selectedAduan.phone }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Isi Aduan</p>
                                    <div class="p-8 bg-slate-50/50 rounded-[2.5rem] border border-slate-100 text-slate-600 font-bold text-sm leading-relaxed italic relative">
                                        <i class="fas fa-quote-left absolute top-4 left-4 text-slate-100 text-3xl"></i>
                                        <span class="relative z-10">"{{ selectedAduan.pesan }}"</span>
                                    </div>
                                </div>

                                <div v-if="selectedAduan.photos && selectedAduan.photos.length">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                                        Dokumentasi Lapangan</p>
                                    <div class="grid grid-cols-3 gap-4">
                                        <a v-for="(photo, idx) in selectedAduan.photos" :key="idx"
                                            :href="'/storage/' + photo" target="_blank"
                                            class="aspect-square rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:ring-8 hover:ring-blue-50 transition-all group relative">
                                            <img :src="'/storage/' + photo" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-blue-600/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <i class="fas fa-search-plus text-white text-xl"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fixed Footer Action -->
                        <div class="p-8 md:p-10 border-t border-slate-100 bg-slate-50/50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5">
                                Tindakan Cepat
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <button v-if="selectedAduan.status !== 'proses'"
                                    @click="updateStatus(selectedAduan.id, 'proses')"
                                    class="px-6 py-4 rounded-2xl bg-blue-600 text-white font-black text-xs uppercase tracking-widest hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/20 transition-all flex items-center gap-2">
                                    <i class="fas fa-spinner"></i> Proses Aduan
                                </button>
                                <button v-if="selectedAduan.status !== 'selesai'"
                                    @click="updateStatus(selectedAduan.id, 'selesai')"
                                    class="px-6 py-4 rounded-2xl bg-emerald-600 text-white font-black text-xs uppercase tracking-widest hover:bg-emerald-700 hover:shadow-xl hover:shadow-emerald-600/20 transition-all flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Selesaikan
                                </button>
                                <button v-if="selectedAduan.status !== 'ditolak'"
                                    @click="updateStatus(selectedAduan.id, 'ditolak')"
                                    class="px-6 py-4 rounded-2xl bg-rose-600 text-white font-black text-xs uppercase tracking-widest hover:bg-rose-700 hover:shadow-xl hover:shadow-rose-600/20 transition-all flex items-center gap-2">
                                    <i class="fas fa-times-circle"></i> Tolak Aduan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </AdminLayout>
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

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
