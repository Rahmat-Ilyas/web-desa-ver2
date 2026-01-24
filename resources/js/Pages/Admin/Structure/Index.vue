<script setup>
import { useForm, Head, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    structures: Array,
    parents: Array
});

const page = usePage();
const errors = computed(() => page.props.errors || {});

const isModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const editingItem = ref(null);
const deleteId = ref(null);
const deleteName = ref('');
const isDeleting = ref(false);
const showSuccessDelete = ref(false);
const showSuccessAdd = ref(false);
const showSuccessEdit = ref(false);
const photoError = ref('');

const form = useForm({
    name: '',
    position: '',
    nip: '',
    level: 1,
    parent_id: null,
    order: 0,
    photo: null
});

const openCreateModal = () => {
    photoError.value = '';
    editingItem.value = null;
    form.reset();

    // Clear errors by reloading only errors from server
    router.reload({ only: ['errors'] });

    isModalOpen.value = true;
};

const openEditModal = (item) => {
    photoError.value = '';
    editingItem.value = item;
    form.name = item.name;
    form.position = item.position;
    form.nip = item.nip || '';
    form.level = item.level;
    form.parent_id = item.parent_id;
    form.order = item.order;
    form.photo = null;

    // Clear errors by reloading only errors from server
    router.reload({ only: ['errors'] });

    isModalOpen.value = true;
};

const submit = () => {
    // Create FormData manually
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('position', form.position);
    formData.append('nip', form.nip || '');
    formData.append('level', form.level);
    formData.append('parent_id', form.parent_id || '');
    formData.append('order', form.order);

    if (form.photo) {
        formData.append('photo', form.photo);
    }

    const url = editingItem.value
        ? route('admin.struktur.update', editingItem.value.id)
        : route('admin.struktur.store');

    router.post(url, formData, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // Clear form and close modal on success
            form.reset();
            closeModal();

            // Show success toast
            if (editingItem.value) {
                showSuccessEdit.value = true;
                setTimeout(() => showSuccessEdit.value = false, 3000);
            } else {
                showSuccessAdd.value = true;
                setTimeout(() => showSuccessAdd.value = false, 3000);
            }
        },
        onError: (errors) => {
            console.log('Validation errors received:', errors);
            console.log('Page props errors:', page.props.errors);
            console.log('Computed errors:', errors.value);
            // PENTING: Modal TETAP terbuka saat ada error
            // Errors akan otomatis muncul dari page.props.errors
        }
    });
};

const openDeleteModal = (item) => {
    deleteId.value = item.id;
    deleteName.value = item.name;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    deleteId.value = null;
    deleteName.value = '';
};

const confirmDelete = () => {
    if (!deleteId.value) {
        alert("Error: ID Data tidak valid.");
        return;
    }

    if (isDeleting.value) return;
    isDeleting.value = true;

    router.post(route('admin.struktur.destroy', deleteId.value), {
        _method: 'DELETE'
    }, {
        preserveScroll: true,
        onSuccess: () => {
            isDeleting.value = false;
            closeDeleteModal();
            showSuccessDelete.value = true;
            setTimeout(() => showSuccessDelete.value = false, 3000);
        },
        onError: (errors) => {
            isDeleting.value = false;
            console.error('Delete error:', errors);
            alert('Gagal menghapus data. Silakan coba lagi.');
        },
        onFinish: () => {
            isDeleting.value = false;
        }
    });
};

const closeModal = () => {
    isModalOpen.value = false;
    editingItem.value = null;
    form.reset();
};

const getLevelName = (level) => {
    switch (level) {
        case 1: return 'Lurah';
        case 2: return 'Sekretaris';
        case 3: return 'Kasi/Kasubag';
        case 4: return 'Staf';
        default: return 'Lainnya';
    }
};

const getPhotoPreview = (file) => {
    if (!file) return null;
    return window.URL.createObjectURL(file);
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    photoError.value = ''; // Clear previous error

    if (!file) {
        form.photo = null;
        return;
    }

    // Validasi Tipe File (Harus Image)
    if (!file.type.startsWith('image/')) {
        photoError.value = 'File harus berupa gambar (JPG, PNG, GIF, atau WebP)';
        event.target.value = '';
        form.photo = null;
        return;
    }

    // Validasi Ukuran File (Max 2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB
    if (file.size > maxSize) {
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
        photoError.value = `Ukuran foto terlalu besar (${fileSizeMB}MB). Maksimal 2MB.`;
        event.target.value = '';
        form.photo = null;
        return;
    }

    // File valid
    form.photo = file;
};
</script>

<template>
    <AdminLayout>

        <Head title="Struktur Organisasi" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-sitemap"></i> Konten Profil
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Struktur Organisasi</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola jajaran pimpinan dan staf Kelurahan Ujung
                        Sabbang.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full md:w-auto"></div> <!-- Spacer -->
                    <button @click="openCreateModal"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH ANGGOTA
                    </button>
                </div>
            </div>

            <!-- Success Notification Toasts -->
            <!-- Delete Success -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showSuccessDelete"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil Dihapus!</p>
                        <p class="text-slate-500 text-xs font-bold">Data anggota struktur telah dihapus.</p>
                    </div>
                </div>
            </transition>

            <!-- Add Success -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showSuccessAdd"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-blue-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil Ditambahkan!</p>
                        <p class="text-slate-500 text-xs font-bold">Anggota baru telah ditambahkan ke struktur.</p>
                    </div>
                </div>
            </transition>

            <!-- Edit Success -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showSuccessEdit"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-amber-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/20">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil Diperbarui!</p>
                        <p class="text-slate-500 text-xs font-bold">Data anggota struktur telah diperbarui.</p>
                    </div>
                </div>
            </transition>

            <!-- Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest">
                                Pejabat/Staf
                            </th>
                            <th class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest">Jabatan
                            </th>
                            <th
                                class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest text-center">
                                Tingkat</th>
                            <th class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest">Atasan
                                Langsung</th>
                            <th
                                class="px-6 py-5 text-xs font-black text-slate-500 uppercase tracking-widest text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr v-for="item in structures" :key="item.id" class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                        <img v-if="item.photo" :src="'/storage/' + item.photo"
                                            class="w-full h-full object-cover">
                                        <div v-else
                                            class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fas fa-user text-xl"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[14px] whitespace-nowrap font-black text-slate-900 leading-tight">{{ item.name }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-wider">
                                            NIP.
                                            {{ item.nip || '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-600 text-sm">{{ item.position }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span :class="['px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider',
                                    {
                                        'bg-blue-100 text-blue-700': item.level === 1,
                                        'bg-orange-100 text-orange-700': item.level === 2,
                                        'bg-emerald-100 text-emerald-700': item.level === 3,
                                        'bg-slate-100 text-slate-600': item.level === 4
                                    }]">
                                    {{ getLevelName(item.level) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div v-if="item.parent" class="flex items-center gap-2">
                                    <i class="fas fa-arrow-up text-slate-400 text-xs"></i>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm">{{ item.parent.position }}</p>
                                    </div>
                                </div>
                                <div v-else-if="item.level === 1" class="flex items-center gap-2">
                                    <i class="fas fa-crown text-amber-500 text-sm"></i>
                                    <span
                                        class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-wider">Jabatan
                                        Tertinggi</span>
                                </div>
                                <span v-else class="text-slate-400 text-sm font-medium italic">-</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                    <button @click="openEditModal(item)"
                                        class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-blue-200">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(item)"
                                        class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-md hover:shadow-rose-200">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="structures.length === 0" class="p-20 text-center">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                        <i class="fas fa-users text-4xl"></i>
                    </div>
                    <p class="text-slate-400 font-bold">Belum ada data struktur organisasi.</p>
                </div>
            </div>

            <!-- Modal -->
            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="isModalOpen"
                    class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div
                        class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden border border-white/20">
                        <div
                            class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <h3 class="text-lg font-black text-slate-900">{{ editingItem ? 'Edit Anggota' : 
                            'Tambah Anggota'
                                }}</h3>
                            <button @click="closeModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit"
                            class="p-8 space-y-8 max-h-[85vh] overflow-y-auto custom-scrollbar">
                            <!-- Layout Split: Left (Photo + Personal) & Right (Position + Hierarchy) -->
                            <div class="flex flex-col lg:flex-row gap-10">

                                <!-- Left Column: Photo & Personal Info -->
                                <div class="lg:w-5/12 space-y-6">

                                    <!-- Photo Upload Card -->
                                    <div class="relative group">
                                        <label
                                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Foto
                                            Profil</label>
                                        <div
                                            class="w-full aspect-[4/5] rounded-[2rem] bg-slate-50 border-2 border-dashed border-slate-200 overflow-hidden relative transition-all hover:border-blue-400 hover:bg-blue-50/30 group-hover:shadow-xl group-hover:shadow-blue-100">

                                            <!-- Image Preview -->
                                            <img v-if="form.photo" :src="getPhotoPreview(form.photo)"
                                                class="w-full h-full object-cover">
                                            <img v-else-if="editingItem?.photo" :src="'/storage/' + editingItem.photo"
                                                class="w-full h-full object-cover transition-opacity group-hover:opacity-40">

                                            <!-- Placeholder State -->
                                            <div v-if="!form.photo && !editingItem?.photo"
                                                class="absolute inset-0 flex flex-col items-center justify-center text-slate-300">
                                                <div
                                                    class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                    <i class="fas fa-camera text-3xl"></i>
                                                </div>
                                                <span class="text-xs font-bold">Upload Foto</span>
                                            </div>

                                            <!-- Overlay Instruction (On Hover or if Empty) -->
                                            <div
                                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/10 backdrop-blur-[2px]">
                                                <span
                                                    class="bg-white/90 px-4 py-2 rounded-full text-xs font-black text-slate-700 shadow-lg">
                                                    <i class="fas fa-pen mr-1"></i> Pilih Foto
                                                </span>
                                            </div>

                                            <!-- Hidden Input -->
                                            <input type="file" @change="handleFileChange" accept="image/*"
                                                class="absolute inset-0 opacity-0 cursor-pointer z-50">
                                        </div>

                                        <!-- Photo Error Display -->
                                        <p v-if="errors.photo || photoError"
                                            class="mt-1 text-rose-500 text-[10px] font-bold">{{
                                                errors.photo?.[0] || photoError }}</p>

                                        <p class="text-[10px] text-center text-slate-400 font-medium mt-2">Format:
                                            JPG/PNG,
                                            Max 2MB. Rasio 4:5 disarankan.</p>
                                    </div>

                                    <!-- Personal Inputs -->
                                    <div class="space-y-4">
                                        <div
                                            class="bg-slate-50 p-4 rounded-2xl border border-slate-100 focus-within:ring-2 focus-within:ring-blue-500/10 transition-all">
                                            <label
                                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama
                                                Lengkap</label>
                                            <input v-model="form.name" type="text"
                                                placeholder="Contoh: Budi Santoso, S.Sos"
                                                class="w-full bg-transparent border-none p-0 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-0">
                                            <p v-if="errors.name" class="mt-1 text-rose-500 text-[10px] font-bold">{{
                                                errors.name?.[0] }}</p>
                                        </div>

                                        <div
                                            class="bg-slate-50 p-4 rounded-2xl border border-slate-100 focus-within:ring-2 focus-within:ring-blue-500/10 transition-all">
                                            <label
                                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">NIP
                                                (Opsional)</label>
                                            <input v-model="form.nip" type="text" placeholder="198305..."
                                                class="w-full bg-transparent border-none p-0 text-sm font-bold text-slate-700 placeholder:text-slate-300 focus:ring-0">
                                            <p v-if="errors.nip" class="mt-1 text-rose-500 text-[10px] font-bold">{{
                                                errors.nip?.[0] }}</p>
                                        </div>
                                    </div>

                                </div>

                                <!-- Right Column: Position & Hierarchy -->
                                <div class="lg:w-7/12 space-y-6">

                                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-100">
                                        <label
                                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Informasi
                                            Jabatan</label>

                                        <div class="space-y-4">
                                            <!-- Position Name -->
                                            <div>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                                        <i class="fas fa-briefcase"></i>
                                                    </div>
                                                    <input v-model="form.position" type="text"
                                                        placeholder="Nama Jabatan (Misal: Sekretaris Lurah)"
                                                        class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                                                </div>
                                                <p v-if="errors.position"
                                                    class="mt-1 text-rose-500 text-[10px] font-bold pl-2">
                                                    {{ errors.position?.[0] }}
                                                </p>
                                            </div>

                                            <!-- Hierarchy Level Selection -->
                                            <div>
                                                <span
                                                    class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Tingkat
                                                    Hirarki</span>

                                                <!-- Error Alert (More Prominent) -->
                                                <div v-if="errors.level"
                                                    class="mb-3 p-4 bg-rose-50 border-2 border-rose-200 rounded-xl flex items-start gap-3">
                                                    <div
                                                        class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="text-rose-900 font-black text-xs mb-1">PERINGATAN!</p>
                                                        <p class="text-rose-700 text-xs font-bold leading-relaxed">
                                                            {{ errors.level?.[0] }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-3">
                                                    <button type="button" @click="form.level = 1"
                                                        :class="['p-3 rounded-xl border text-left transition-all relative overflow-hidden',
                                                            form.level === 1 ? 'border-blue-500 bg-blue-50/50 ring-1 ring-blue-500' : 'border-slate-200 bg-white hover:border-blue-300']">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <div
                                                                :class="['w-3 h-3 rounded-full', form.level === 1 ? 'bg-blue-500' : 'bg-slate-300']">
                                                            </div>
                                                            <span
                                                                :class="['text-xs font-black uppercase', form.level === 1 ? 'text-blue-700' : 'text-slate-500']">Lurah</span>
                                                        </div>
                                                        <p class="text-[10px] text-slate-400 leading-tight">Pimpinan
                                                            Tertinggi</p>
                                                    </button>

                                                    <button type="button" @click="form.level = 2"
                                                        :class="['p-3 rounded-xl border text-left transition-all relative overflow-hidden',
                                                            form.level === 2 ? 'border-orange-500 bg-orange-50/50 ring-1 ring-orange-500' : 'border-slate-200 bg-white hover:border-orange-300']">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <div
                                                                :class="['w-3 h-3 rounded-full', form.level === 2 ? 'bg-orange-500' : 'bg-slate-300']">
                                                            </div>
                                                            <span
                                                                :class="['text-xs font-black uppercase', form.level === 2 ? 'text-orange-700' : 'text-slate-500']">Sekretaris</span>
                                                        </div>
                                                        <p class="text-[10px] text-slate-400 leading-tight">Wakil
                                                            Pimpinan
                                                        </p>
                                                    </button>

                                                    <button type="button" @click="form.level = 3"
                                                        :class="['p-3 rounded-xl border text-left transition-all relative overflow-hidden',
                                                            form.level === 3 ? 'border-emerald-500 bg-emerald-50/50 ring-1 ring-emerald-500' : 'border-slate-200 bg-white hover:border-emerald-300']">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <div
                                                                :class="['w-3 h-3 rounded-full', form.level === 3 ? 'bg-emerald-500' : 'bg-slate-300']">
                                                            </div>
                                                            <span
                                                                :class="['text-xs font-black uppercase', form.level === 3 ? 'text-emerald-700' : 'text-slate-500']">Kasi/Kasubag</span>
                                                        </div>
                                                        <p class="text-[10px] text-slate-400 leading-tight">Kepala Seksi
                                                        </p>
                                                    </button>

                                                    <button type="button" @click="form.level = 4"
                                                        :class="['p-3 rounded-xl border text-left transition-all relative overflow-hidden',
                                                            form.level === 4 ? 'border-slate-500 bg-slate-50 ring-1 ring-slate-500' : 'border-slate-200 bg-white hover:border-slate-300']">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <div
                                                                :class="['w-3 h-3 rounded-full', form.level === 4 ? 'bg-slate-500' : 'bg-slate-300']">
                                                            </div>
                                                            <span
                                                                :class="['text-xs font-black uppercase', form.level === 4 ? 'text-slate-700' : 'text-slate-500']">Staf</span>
                                                        </div>
                                                        <p class="text-[10px] text-slate-400 leading-tight">Anggota Umum
                                                        </p>
                                                    </button>
                                                </div>
                                                <!-- Validasi Error Message -->
                                                <p v-if="errors.level"
                                                    class="mt-2 text-rose-500 text-center text-xs font-bold bg-rose-50 py-2 px-3 rounded-lg border border-rose-100 flex items-center justify-center gap-2">
                                                    <i class="fas fa-exclamation-circle"></i> {{ errors.level?.[0] }}
                                                </p>
                                            </div>

                                            <!-- Parent Selector -->
                                            <div>
                                                <span
                                                    class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Atasan
                                                    Langsung (Untuk Garis Koordinasi)</span>
                                                <p v-if="errors.parent_id"
                                                    class="text-rose-500 text-[10px] font-bold mb-2 ml-1">
                                                    {{ errors.parent_id?.[0] }}
                                                </p>
                                                <div class="relative">
                                                    <select v-model="form.parent_id"
                                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all appearance-none">
                                                        <option :value="null">-- Tidak Ada / Langsung ke Lurah --
                                                        </option>
                                                        <option v-for="parent in parents" :key="parent.id"
                                                            :value="parent.id">
                                                            {{ parent.position }} - {{ parent.name }}
                                                        </option>
                                                    </select>
                                                    <div
                                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                                        <i class="fas fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Order Input -->
                                            <div>
                                                <label
                                                    class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Urutan
                                                    Tampilan</label>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="form.order--"
                                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold transition-colors">-</button>
                                                    <input v-model="form.order" type="number"
                                                        class="w-16 text-center bg-white border border-slate-200 rounded-lg py-1.5 text-sm font-bold text-slate-700 focus:ring-0">
                                                    <button type="button" @click="form.order++"
                                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold transition-colors">+</button>
                                                    <span class="text-[10px] text-slate-400 ml-2">Semakin kecil, semakin
                                                        di
                                                        kiri/atas.</span>
                                                    <p v-if="errors.order"
                                                        class="text-rose-500 text-[10px] font-bold mt-1">
                                                        {{ errors.order?.[0] }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4 pt-4">
                                <button type="button" @click="closeModal"
                                    class="flex-1 px-6 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all italic">BATAL</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-[2] px-6 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/30 disabled:opacity-50">
                                    {{ editingItem ? 'UPDATE DATA' : 'SIMPAN DATA' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>

            <!-- Delete Confirmation Modal -->
            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="isDeleteModalOpen"
                    class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                    <div
                        class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden border border-white/20 p-6 text-center">
                        <div
                            class="w-16 h-16 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2">Hapus Data?</h3>
                        <p class="text-sm text-slate-500 font-medium mb-6">Apakah Anda yakin ingin menghapus
                            <strong class="text-slate-800">{{ deleteName }}</strong>? Tindakan ini tidak dapat
                            dibatalkan.
                        </p>

                        <div class="flex gap-3">
                            <button type="button" @click="closeDeleteModal" :disabled="isDeleting"
                                class="flex-1 px-4 py-3 bg-slate-100 text-slate-600 rounded-xl font-black text-xs hover:bg-slate-200 transition-all disabled:opacity-50">
                                BATAL
                            </button>
                            <button type="button" @click="confirmDelete" :disabled="isDeleting"
                                class="flex-1 px-4 py-3 bg-rose-500 text-white rounded-xl font-black text-xs hover:bg-rose-600 transition-all shadow-lg shadow-rose-500/30 disabled:opacity-50 flex items-center justify-center gap-2">
                                <i v-if="isDeleting" class="fas fa-spinner fa-spin"></i>
                                {{ isDeleting ? 'MENGHAPUS...' : 'YA, HAPUS' }}
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </AdminLayout>
</template>
