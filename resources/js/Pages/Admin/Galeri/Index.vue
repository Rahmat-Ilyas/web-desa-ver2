<script setup>
import { Head, Link, router, usePage, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    galeris: Object,
});

const showModal = ref(false);
const isEditing = ref(false);
const notification = ref({ show: false, message: '', type: 'success' });
const page = usePage();

const form = useForm({
    id: null,
    judul: '',
    kategori: 'Kegiatan',
    deskripsi: '',
    tanggal: new Date().toISOString().split('T')[0],
    image: null,
});

const categories = ['Kegiatan', 'Pembangunan', 'Sosial', 'Keagamaan'];

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
});

watch(() => page.props.errors, (errors) => {
    if (Object.keys(errors).length > 0) {
        showNotification('Terdapat kesalahan pada input form', 'error');
    }
});

const openModal = (galeri = null) => {
    isEditing.value = !!galeri;
    if (galeri) {
        form.id = galeri.id;
        form.judul = galeri.judul;
        form.kategori = galeri.kategori;
        form.deskripsi = galeri.deskripsi;
        form.tanggal = galeri.tanggal;
        form.image = null; // Don't prepopulate file input
    } else {
        form.reset();
        form.id = null;
        form.image = null;
        form.tanggal = new Date().toISOString().split('T')[0];
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    if (isEditing.value) {
        form.post(route('admin.galeri.update', form.id), {
            onSuccess: () => closeModal(),
            forceFormData: true, // Important for file upload with PUT/PATCH spoofing in Laravel
            _method: 'PUT'
        });
    } else {
        form.post(route('admin.galeri.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteGaleri = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
        router.delete(route('admin.galeri.destroy', id), {
            preserveScroll: true,
            onSuccess: () => showNotification('Foto berhasil dihapus', 'success')
        });
    }
};

const getPhotoUrl = (path) => {
    if (!path) return 'https://placehold.co/100x100?text=No+Photo';
    if (path.startsWith('http')) return path;
    return path;
};

const handleImageError = (e) => {
    e.target.src = 'https://placehold.co/100x100?text=No+Photo';
    e.target.classList.add('opacity-50');
};
</script>

<template>
    <AdminLayout>

        <Head title="Kelola Galeri" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-images"></i> Media & Dokumentasi
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Galeri Foto</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola dokumentasi kegiatan dan pembangunan
                        kelurahan.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full md:w-auto"></div> <!-- Future Search/Filter -->
                    <button @click="openModal()"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH FOTO
                    </button>
                </div>
            </div>

            <!-- Success Notification -->
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

            <!-- Gallery Table -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Foto</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Kategori</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Tanggal</th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr v-for="item in (galeris?.data || [])" :key="item.id"
                                class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm bg-slate-100 shrink-0">
                                            <img :src="getPhotoUrl(item.image)" :alt="item.judul"
                                                @error="handleImageError" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4
                                                class="font-black text-slate-900 text-sm line-clamp-1 group-hover:text-blue-600 transition-colors uppercase">
                                                {{ item.judul }}</h4>
                                            <p class="text-[10px] font-bold text-slate-400 mt-1 line-clamp-1">{{
                                                item.deskripsi || 'Tidak ada deskripsi' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase tracking-tight">{{
                                        item.kategori }}</span>
                                </td>
                                <td class="px-8 py-6 text-[10px] font-bold text-slate-500">
                                    {{ new Date(item.tanggal).toLocaleDateString('id-ID', {
                                        day: 'numeric', month:
                                    'long', year: 'numeric' }) }}
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-2 text-right">
                                        <button @click="openModal(item)"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-amber-600 hover:bg-amber-50 flex items-center justify-center transition-all"
                                            title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button @click="deleteGaleri(item.id)"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!galeris?.data?.length">
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                        <i class="fas fa-images text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm">Belum ada foto galeri.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="galeris?.links?.length > 3"
                    class="px-8 py-6 border-t border-slate-50 flex justify-center bg-slate-50/30">
                    <div class="flex gap-1">
                        <template v-for="(link, k) in (galeris?.links || [])" :key="k">
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

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
            <div class="relative bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-fade-in-up">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-black text-slate-900 text-lg">{{ isEditing ? 'Edit Foto' : 'Tambah Foto Baru' }}
                    </h3>
                    <button @click="closeModal" class="text-slate-400 hover:text-slate-600"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="p-8">
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <!-- Judul -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul
                                Foto</label>
                            <input v-model="form.judul" type="text"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 font-bold text-sm text-slate-700"
                                placeholder="Contoh: Kegiatan Kerja Bakti..." required>
                            <div v-if="form.errors.judul" class="text-red-500 text-xs mt-1">{{ form.errors.judul }}
                            </div>
                        </div>

                        <!-- Kategori & Tanggal -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                                <select v-model="form.kategori"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 font-bold text-sm text-slate-700">
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                                <input v-model="form.tanggal" type="date"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 font-bold text-sm text-slate-700"
                                    required>
                            </div>
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload
                                Foto</label>
                            <input type="file" @input="form.image = $event.target.files[0]" accept="image/*"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 font-bold text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}
                            </div>
                            <p v-if="isEditing" class="text-[10px] text-slate-400 mt-2 font-medium italic">* Biarkan
                                kosong jika
                                tidak ingin mengubah foto</p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi
                                (Opsional)</label>
                            <textarea v-model="form.deskripsi" rows="3"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 font-bold text-sm text-slate-700"
                                placeholder="Tambahkan keterangan singkat..."></textarea>
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-3">
                            <button type="button" @click="closeModal"
                                class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-colors">Batal</button>
                            <button type="submit" :disabled="form.processing"
                                class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs uppercase tracking-widest hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-2">
                                <i v-if="form.processing" class="fas fa-spinner fa-spin"></i>
                                {{ isEditing ? 'Simpan Perubahan' : 'Upload Foto' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.3s ease-out forwards;
}

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
