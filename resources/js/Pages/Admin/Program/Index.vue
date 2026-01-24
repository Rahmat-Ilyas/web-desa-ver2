<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    programs: Array
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

// Modal State
const isModalOpen = ref(false);
const editingItem = ref(null);
const isDeleteModalOpen = ref(false);
const itemToDelete = ref(null);

const form = useForm({
    judul: '',
    kategori: '',
    deskripsi: '',
    status: 'Rencana',
    progress: 0,
    waktu_pelaksanaan: '',
    icon: 'fa-hard-hat',
    color: 'bg-blue-50 text-blue-600'
});

const categories = [
    'Pembangunan Infrastruktur',
    'Pemberdayaan Masyarakat',
    'Pembinaan Kemasyarakatan',
    'Penyelenggaraan Pemerintahan',
    'Penanggulangan Bencana',
    'Keagamaan & Budaya',
    'Kesehatan & Posyandu',
    'Pariwisata & Ekonomi Kreatif',
    'Pertanian & Ketahanan Pangan',
    'Kebersihan & Lingkungan',
    'Kepemudaan & Olahraga'
];

const icons = [
    { class: 'fa-hard-hat', name: 'Konstruksi' },
    { class: 'fa-tree', name: 'Lingkungan' },
    { class: 'fa-users', name: 'Sosial' },
    { class: 'fa-heartbeat', name: 'Kesehatan' },
    { class: 'fa-chalkboard-teacher', name: 'Pendidikan' },
    { class: 'fa-road', name: 'Jalan' },
    { class: 'fa-lightbulb', name: 'Listrik' },
    { class: 'fa-tint', name: 'Air' },
    { class: 'fa-mosque', name: 'Keagamaan' }, // Added
    { class: 'fa-store', name: 'Ekonomi/Pasar' }, // Added
    { class: 'fa-trash', name: 'Kebersihan' }, // Added
    { class: 'fa-shield-alt', name: 'Keamanan' }, // Added
    { class: 'fa-wifi', name: 'Teknologi' }, // Added
    { class: 'fa-futbol', name: 'Olahraga' }, // Added
    { class: 'fa-hands-helping', name: 'Bantuan' }, // Added
    { class: 'fa-child', name: 'Anak & Balita' }, // Added
];

const colors = [
    { class: 'bg-blue-50 text-blue-600', name: 'Blue Sky' },
    { class: 'bg-emerald-50 text-emerald-600', name: 'Emerald Green' },
    { class: 'bg-orange-50 text-orange-600', name: 'Sunset Orange' },
    { class: 'bg-rose-50 text-rose-600', name: 'Rose Red' },
    { class: 'bg-purple-50 text-purple-600', name: 'Royal Purple' },
    { class: 'bg-cyan-50 text-cyan-600', name: 'Cyan Ocean' },
    { class: 'bg-indigo-50 text-indigo-600', name: 'Indigo Soft' }, // Added
    { class: 'bg-teal-50 text-teal-600', name: 'Teal Fresh' }, // Added
    { class: 'bg-pink-50 text-pink-600', name: 'Pink Vivid' }, // Added
    { class: 'bg-amber-50 text-amber-600', name: 'Amber Gold' }, // Added
    { class: 'bg-lime-50 text-lime-600', name: 'Lime Zest' }, // Added
    { class: 'bg-fuchsia-50 text-fuchsia-600', name: 'Fuchsia Pop' }, // Added
    { class: 'bg-slate-100 text-slate-600', name: 'Classic Slate' }, // Added
    { class: 'bg-sky-100 text-sky-700', name: 'Deep Sky' }, // Added
];

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.judul = item.judul;
    form.kategori = item.kategori;
    form.deskripsi = item.deskripsi;
    form.status = item.status;
    form.progress = item.progress;
    form.waktu_pelaksanaan = item.waktu_pelaksanaan;
    form.icon = item.icon;
    form.color = item.color;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const submit = () => {
    if (editingItem.value) {
        form.put(route('admin.program.update', editingItem.value.id), {
            onSuccess: () => {
                closeModal();
                showNotification('Program kerja berhasil diperbarui');
            },
        });
    } else {
        form.post(route('admin.program.store'), {
            onSuccess: () => {
                closeModal();
                showNotification('Program kerja berhasil ditambahkan');
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
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.program.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
                showNotification('Program kerja berhasil dihapus');
            }
        });
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Selesai': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'Berjalan': return 'bg-blue-100 text-blue-700 border-blue-200';
        default: return 'bg-slate-100 text-slate-600 border-slate-200';
    }
};
</script>

<template>
    <AdminLayout>

        <Head title="Program Kerja" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-tasks"></i> Pembangunan & Kegiatan
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Program Kerja</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Pantau progres pembangunan dan kegiatan desa.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full md:w-auto"></div>
                    <button @click="openCreateModal"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH PROGRAM
                    </button>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 gap-6">
                <div v-for="item in programs" :key="item.id"
                    class="bg-white rounded-[2rem] border border-slate-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-lg transition-all items-center md:items-start group">

                    <!-- Icon Box -->
                    <div
                        :class="[item.color, 'w-16 h-16 rounded-2xl flex flex-col items-center justify-center text-2xl shadow-sm shrink-0']">
                        <i :class="['fas', item.icon]"></i>
                    </div>

                    <div class="flex-grow w-full text-center md:text-left">
                        <div class="mb-2">
                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1 block">{{ item.kategori }}</span>
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="text-lg font-black text-slate-900 leading-tight text-left">{{ item.judul }}</h3>
                                <span :class="['px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border shrink-0', getStatusColor(item.status)]">
                                    {{ item.status }}
                                </span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-sm font-medium mb-4 line-clamp-2">{{ item.deskripsi }}</p>

                        <!-- Metadata -->
                        <div
                            class="flex flex-wrap items-center gap-4 text-xs font-bold text-slate-400 justify-center md:justify-start">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i>
                                {{ item.waktu_pelaksanaan || '-' }}
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4 w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-1000"
                                :style="{ width: item.progress + '%' }"></div>
                        </div>
                        <div class="flex justify-between mt-1 text-[10px] font-black uppercase text-slate-400">
                            <span>Progres</span>
                            <span>{{ item.progress }}%</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex gap-2 self-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="openEditModal(item)"
                            class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteItem(item)"
                            class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div v-if="programs.length === 0"
                    class="text-center py-20 bg-white rounded-[2rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold">Belum ada program kerja.</p>
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
                            <h2 class="text-2xl font-black text-slate-900">{{ editingItem ? 'Edit Program' :
                                'Tambah Program' }}</h2>
                            <button @click="closeModal"
                                class="p-3 hover:bg-slate-100 rounded-2xl transition-colors text-slate-400">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Nama
                                    Program</label>
                                <input v-model="form.judul" type="text"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    required placeholder="Contoh: Pembangunan Posyandu...">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Kategori
                                    Program</label>
                                <select v-model="form.kategori"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Waktu
                                        Pelaksanaan</label>
                                    <input v-model="form.waktu_pelaksanaan" type="text"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                        placeholder="Contoh: Januari - Maret 2024">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Status</label>
                                    <select v-model="form.status"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none appearance-none cursor-pointer">
                                        <option value="Rencana">Rencana</option>
                                        <option value="Berjalan">Sedang Berjalan</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Progress
                                    ({{ form.progress }}%)</label>
                                <input v-model="form.progress" type="range" min="0" max="100"
                                    class="w-full h-3 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Deskripsi
                                    Singkat</label>
                                <textarea v-model="form.deskripsi" rows="3"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    placeholder="Jelaskan tujuan dan detail program..." required></textarea>
                            </div>

                            <!-- Icon Selection -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Pilih
                                    Ikon</label>
                                <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
                                    <div v-for="icon in icons" :key="icon.class" @click="form.icon = icon.class"
                                        :class="['h-12 rounded-xl flex items-center justify-center cursor-pointer transition-all border-2', form.icon === icon.class ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-transparent bg-slate-50 text-slate-400 hover:bg-slate-100']"
                                        :title="icon.name">
                                        <i :class="['fas', icon.class]"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Color Selection -->
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-4">Pilih
                                    Warna Kartu</label>
                                <div class="flex flex-wrap gap-3">
                                    <div v-for="color in colors" :key="color.class" @click="form.color = color.class"
                                        :class="['h-12 w-12 rounded-xl flex items-center justify-center cursor-pointer transition-all border-2', form.color === color.class ? 'border-blue-600 shadow-md transform scale-110' : 'border-transparent opacity-70 hover:opacity-100']">
                                        <div :class="['w-8 h-8 rounded-lg', color.class.split(' ')[0]]"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 flex gap-4">
                                <button type="button" @click="closeModal"
                                    class="flex-grow py-4 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-[2] py-4 bg-blue-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50">
                                    {{ editingItem ? 'SIMPAN PERUBAHAN' : 'TAMBAHKAN PROGRAM' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Notification & Delete Modal (Reusable) -->
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

                    <h3 class="text-xl font-black text-slate-900 mb-2">Hapus Program?</h3>
                    <p class="text-slate-500 font-medium text-sm mb-8 leading-relaxed">
                        Anda yakin ingin menghapus <strong class="text-slate-800">{{ itemToDelete?.judul }}</strong>?
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
