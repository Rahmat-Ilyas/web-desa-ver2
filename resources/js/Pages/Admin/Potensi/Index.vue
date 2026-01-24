<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    potensis: Array
});

// Notification State
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
});

// Delete Modal State
const isDeleteModalOpen = ref(false);
const itemToDelete = ref(null);

const isModalOpen = ref(false);
const editingItem = ref(null);
const previewImage = ref(null);

const categories = ['Wisata Alam', 'UMKM & Produk', 'Pertanian', 'Seni Budaya', 'Kuliner'];

const form = useForm({
    judul: '',
    kategori: 'Wisata Alam',
    deskripsi: '',
    lokasi: '',
    image: null
});

const openCreateModal = () => {
    editingItem.value = null;
    previewImage.value = null;
    form.reset();
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.judul = item.judul;
    form.kategori = item.kategori;
    form.deskripsi = item.deskripsi;
    form.lokasi = item.lokasi;

    // Handle image preview
    previewImage.value = item.image ? `/storage/${item.image}` : null;
    form.image = null; // Reset file input

    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    previewImage.value = null;
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (editingItem.value) {
        form.transform((data) => ({
            ...data,
            _method: 'put'
        })).post(route('admin.potensi.update', editingItem.value.id), {
            onSuccess: () => {
                closeModal();
                showNotification('Potensi desa berhasil diperbarui');
            },
        });
    } else {
        form.post(route('admin.potensi.store'), {
            onSuccess: () => {
                closeModal();
                showNotification('Potensi desa berhasil ditambahkan');
            },
        });
    }
};

const deleteItem = (item) => {
    itemToDelete.value = item;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.potensi.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
                // Notification handled by flash watcher
            }
        });
    }
};
</script>

<template>
    <AdminLayout>

        <Head title="Potensi Desa" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-star"></i> Informasi Publik
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Potensi Desa</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola informasi mengenai potensi unggulan desa.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full md:w-auto"></div>
                    <button @click="openCreateModal"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH POTENSI
                    </button>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="item in potensis" :key="item.id"
                    class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden hover:shadow-xl transition-all group flex flex-col">

                    <!-- Image Area -->
                    <div class="h-48 bg-slate-100 relative overflow-hidden">
                        <img v-if="item.image"
                            :src="item.image.startsWith('http') ? item.image : `/storage/${item.image}`"
                            @error="e => e.target.src = 'https://placehold.co/800x600/e2e8f0/94a3b8?text=No+Image'"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400">
                            <i class="fas fa-image text-3xl"></i>
                        </div>
                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm">
                            {{ item.kategori }}
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-xl font-black text-slate-900 mb-2 leading-tight">{{ item.judul }}</h3>
                        <div v-if="item.lokasi" class="flex items-center gap-2 text-slate-400 text-xs font-bold mb-4">
                            <i class="fas fa-map-marker-alt text-rose-500"></i> {{ item.lokasi }}
                        </div>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed mb-6 flex-grow line-clamp-3">
                            {{ item.deskripsi }}
                        </p>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                                {{ new Date(item.created_at).toLocaleDateString() }}
                            </span>
                            <div class="flex gap-2">
                                <button @click="openEditModal(item)"
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button @click="deleteItem(item)"
                                    class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal"></div>
                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl p-8 md:p-12 overflow-hidden">
                        <div class="flex justify-between items-center mb-10">
                            <h2 class="text-2xl font-black text-slate-900">{{ editingItem ? 'Edit Potensi' :
                                'Tambah Potensi Baru' }}</h2>
                            <button @click="closeModal"
                                class="p-3 hover:bg-slate-100 rounded-2xl transition-colors text-slate-400">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Image Upload -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Foto
                                    Utama</label>
                                <div class="relative group cursor-pointer">
                                    <div
                                        class="h-48 w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center hover:border-blue-400 hover:bg-blue-50 transition-all overflow-hidden relative">
                                        <img v-if="previewImage" :src="previewImage"
                                            class="absolute inset-0 w-full h-full object-cover">
                                        <div v-if="!previewImage" class="text-center p-6">
                                            <i
                                                class="fas fa-cloud-upload-alt text-3xl text-slate-300 mb-3 group-hover:text-blue-500 transition-colors"></i>
                                            <p class="text-xs font-bold text-slate-400">Klik untuk upload foto</p>
                                        </div>
                                        <div v-else
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold text-xs uppercase tracking-widest">
                                            Ganti Foto
                                        </div>
                                    </div>
                                    <input type="file" @change="handleImageUpload" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>
                                <p v-if="form.errors.image" class="text-rose-500 text-xs font-bold mt-2 ml-4">{{
                                    form.errors.image }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Judul
                                        Potensi</label>
                                    <input v-model="form.judul" type="text"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                        placeholder="Nama Potensi...">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Kategori</label>
                                    <select v-model="form.kategori"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none appearance-none cursor-pointer">
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Lokasi
                                    (Opsional)</label>
                                <input v-model="form.lokasi" type="text"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    placeholder="Dusun / Lingkungan...">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Deskripsi
                                    Lengkap</label>
                                <textarea v-model="form.deskripsi" rows="4"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    placeholder="Ceritakan keunggulan potensi ini..."></textarea>
                            </div>

                            <div class="pt-6 flex gap-4">
                                <button type="button" @click="closeModal"
                                    class="flex-grow py-4 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-[2] py-4 bg-blue-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50">
                                    {{ editingItem ? 'SIMPAN PERUBAHAN' : 'PUBLIKASIKAN' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <!-- Success Notification -->
        <transition enter-active-class="transform transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-10 z-[120] p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
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

        <!-- Delete Confirmation Modal -->
        <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isDeleteModalOpen" class="fixed inset-0 z-[110] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    @click="closeDeleteModal"></div>

                <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative z-10 text-center">
                    <div
                        class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                        <i class="fas fa-trash-alt text-3xl"></i>
                    </div>

                    <h3 class="text-xl font-black text-slate-900 mb-2">Hapus Potensi?</h3>
                    <p class="text-slate-500 font-medium text-sm mb-8 leading-relaxed">
                        Anda yakin ingin menghapus <strong class="text-slate-800">{{ itemToDelete?.judul }}</strong>?
                        <br>Data yang dihapus tidak dapat dikembalikan.
                    </p>

                    <div class="flex gap-4">
                        <button type="button" @click="closeDeleteModal"
                            class="flex-1 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-slate-200 transition-colors">
                            Batalkan
                        </button>
                        <button type="button" @click="confirmDelete"
                            class="flex-1 bg-rose-600 text-white font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-rose-500 transition-all shadow-xl shadow-rose-500/30 active:scale-95">
                            Ya, Hapus!
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </AdminLayout>
</template>
