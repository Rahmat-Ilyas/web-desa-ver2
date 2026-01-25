<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch, computed } from 'vue';

const title = 'Pengurus Majelis Taklim';

const props = defineProps({
    members: Array,
    profile: String,
    activities: Array,
});

const page = usePage();
const notification = ref({ show: false, message: '', type: 'success' });

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
});

const AVAILABLE_ICONS = [
    'fa-quran', 'fa-mosque', 'fa-hand-holding-heart', 'fa-pray', 'fa-book-open',
    'fa-users', 'fa-star-and-crescent', 'fa-kaaba', 'fa-heart', 'fa-moon',
    'fa-book-reader', 'fa-prayer-beads', 'fa-star', 'fa-sun', 'fa-water',
    'fa-hands-helping', 'fa-graduation-cap', 'fa-compass', 'fa-landmark'
];

// Profile & Activities Section
const profileForm = useForm({
    profil_majelis_taklim: props.profile || '',
    kegiatan_majelis_taklim: props.activities && props.activities.length > 0 ? props.activities : [
        { name: "Pengajian rutin mingguan.", icon: "fa-quran" },
        { name: "Peringatan Hari Besar Islam (PHBI).", icon: "fa-mosque" },
        { name: "Santunan anak yatim dan dhuafa.", icon: "fa-hand-holding-heart" },
        { name: "Pelatihan pemulasaraan jenazah.", icon: "fa-pray" }
    ],
});

const addActivity = () => {
    profileForm.kegiatan_majelis_taklim.push({ name: "", icon: "fa-star" });
};

const showIconModal = ref(false);
const activeActivityIndex = ref(null);

const openIconModal = (index) => {
    activeActivityIndex.value = index;
    showIconModal.value = true;
};

const selectIcon = (icon) => {
    if (activeActivityIndex.value !== null) {
        profileForm.kegiatan_majelis_taklim[activeActivityIndex.value].icon = icon;
    }
    showIconModal.value = false;
    activeActivityIndex.value = null;
};

const removeActivity = (index) => {
    if (profileForm.kegiatan_majelis_taklim.length > 1) {
        profileForm.kegiatan_majelis_taklim.splice(index, 1);
    }
};

const submitProfile = () => {
    profileForm.put(route('admin.majelis-taklim.profile.update'), {
        preserveScroll: true,
        onSuccess: () => showNotification('Profil & Kegiatan Majelis Taklim berhasil diperbarui'),
    });
};

const showModal = ref(false);
const editingItem = ref(null);

const form = useForm({
    nama: '',
    jabatan: '',
    kategori: 'Induk',
    no_hp: '',
    foto: null,
    urutan: 0,
});

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.nama = item.nama;
    form.jabatan = item.jabatan;
    form.kategori = item.kategori || 'Induk';
    form.no_hp = item.no_hp || '';
    form.urutan = item.urutan || 0;
    form.foto = null;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
};

const submit = () => {
    if (editingItem.value) {
        router.post(route('admin.majelis-taklim.update', editingItem.value.id), {
            _method: 'PUT',
            ...form.data(),
        }, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.majelis-taklim.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const showDeleteModal = ref(false);
const itemToDelete = ref(null);

const deleteMember = (item) => {
    itemToDelete.value = item;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.majelis-taklim.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                showNotification('Data pengurus berhasil dihapus');
                showDeleteModal.value = false;
                itemToDelete.value = null;
            },
        });
    }
};

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : 'https://placehold.co/100x120?text=No+Photo';
};

const kategoriOptions = [
    'Induk',
    'Remaja',
    'Ibu-ibu',
    'Bapak-bapak'
];

</script>

<template>
    <AdminLayout>

        <Head :title="title" />

        <div class="max-w-[1400px] mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100 shadow-sm">
                        <i class="fas fa-sitemap"></i> Lembaga Kelurahan
                    </span>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none mb-2">{{ title }}</h1>
                    <p class="text-slate-500 font-bold text-sm">Kelola data jajaran pengurus Majelis Taklim Kelurahan.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <!-- Left Column: Profile & Activities -->
                <div class="lg:col-span-6 space-y-10">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-5 md:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shadow-sm">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-slate-900 leading-none mb-1">Profil & Kegiatan
                                    Majelis Taklim
                                </h2>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">
                                    Deskripsi & Fokus Kegiatan</p>
                            </div>
                        </div>

                        <form @submit.prevent="submitProfile" class="space-y-10">
                            <div class="space-y-8">
                                <!-- Deskripsi Section -->
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-3 text-left">Deskripsi
                                        Profil</label>
                                    <textarea v-model="profileForm.profil_majelis_taklim" rows="12"
                                        class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent focus:border-teal-500 focus:bg-white rounded-[2rem] font-bold transition-all outline-none resize-none text-slate-700 leading-relaxed text-sm shadow-inner"
                                        placeholder="Masukkan profil Majelis Taklim..."></textarea>
                                </div>

                                <!-- Activities Section -->
                                <div class="pt-8 border-t border-slate-50">
                                    <div class="flex items-center justify-between mb-4 ml-3">
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar
                                            Kegiatan Utama</label>
                                        <button type="button" @click="addActivity"
                                            class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-700 transition-all flex items-center gap-1.5">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 pb-10 custom-scrollbar">
                                        <transition-group enter-active-class="transition duration-300 ease-out"
                                            enter-from-class="opacity-0 -translate-y-2"
                                            enter-to-class="opacity-100 translate-y-0"
                                            leave-active-class="transition duration-200 ease-in"
                                            leave-from-class="opacity-100 scale-100"
                                            leave-to-class="opacity-0 scale-95">
                                            <div v-for="(activity, index) in profileForm.kegiatan_majelis_taklim"
                                                :key="index" class="flex gap-2 items-center group">
                                                <div class="flex-grow relative">
                                                    <input v-model="profileForm.kegiatan_majelis_taklim[index].name"
                                                        type="text"
                                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-[1.25rem] font-bold text-xs transition-all outline-none text-slate-700 shadow-sm"
                                                        placeholder="Tuliskan kegiatan...">
                                                    <div
                                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] font-black">
                                                        {{ index + 1 }}
                                                    </div>
                                                </div>
                                                <button type="button" @click="openIconModal(index)"
                                                    class="w-10 h-10 flex-shrink-0 bg-white border border-slate-100 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-100 rounded-xl transition-all flex items-center justify-center relative overflow-hidden group/icon-btn">
                                                    <i
                                                        :class="['fas', profileForm.kegiatan_majelis_taklim[index].icon || 'fa-star', 'text-[12px]']"></i>
                                                    <div
                                                        class="absolute inset-0 bg-emerald-600 opacity-0 group-hover/icon-btn:opacity-10 transition-opacity">
                                                    </div>
                                                </button>
                                                <button type="button" @click="removeActivity(index)"
                                                    class="w-10 h-10 flex-shrink-0 bg-white border border-slate-100 text-slate-300 hover:bg-rose-50 hover:text-rose-500 hover:border-rose-100 rounded-xl transition-all flex items-center justify-center">
                                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                                </button>
                                            </div>
                                        </transition-group>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" :disabled="profileForm.processing"
                                class="w-full py-4 bg-teal-600 text-white rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-teal-700 hover:shadow-2xl hover:shadow-teal-600/40 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                SIMPAN PROFIL & KEGIATAN
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Members Table -->
                <div class="lg:col-span-6 flex flex-col h-[850px]">
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-4 md:p-10 flex flex-col h-full overflow-hidden">
                        <div class="border-b border-slate-50 flex items-center justify-between gap-4 pb-6 shrink-0">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-sm flex-shrink-0">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 tracking-tight leading-none mb-1">
                                        Daftar Pengurus</h3>
                                    <p
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">
                                        Susunan & Struktur</p>
                                </div>
                            </div>
                            <button @click="openCreateModal"
                                class="px-5 py-2.5 bg-blue-600 text-white text-[10px] font-black rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-95 flex items-center gap-2 uppercase tracking-widest">
                                <i class="fas fa-plus text-[10px]"></i> TAMBAH
                            </button>
                        </div>

                        <!-- Table Container with Internal Scroll -->
                        <div class="overflow-y-auto mt-4 pr-2 custom-scrollbar flex-grow min-h-0">
                            <table class="w-full text-left border-separate border-spacing-0">
                                <thead class="sticky top-0 z-10 bg-white">
                                    <tr class="bg-slate-50/50">
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Pengurus</th>
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                            Kategori</th>
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <tr v-for="member in members" :key="member.id"
                                        class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-4 py-5">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm flex-shrink-0">
                                                    <img :src="getPhotoUrl(member.foto)"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div class="overflow-hidden text-left">
                                                    <p
                                                        class="font-black text-slate-900 text-sm truncate max-w-[150px] sm:max-w-none">
                                                        {{ member.nama
                                                        }}</p>
                                                    <p
                                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate mt-0.5">
                                                        {{ member.jabatan }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-center">
                                            <span
                                                class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest whitespace-nowrap inline-block"
                                                :class="{
                                                    'bg-blue-50 text-blue-600': member.kategori === 'Induk',
                                                    'bg-emerald-50 text-emerald-600': member.kategori === 'Remaja',
                                                    'bg-amber-50 text-amber-600': member.kategori === 'Ibu-ibu',
                                                    'bg-rose-50 text-rose-600': member.kategori === 'Bapak-bapak',
                                                }">
                                                {{ member.kategori || 'Lainnya' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5 transition-all">
                                                <button @click="openEditModal(member)"
                                                    class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fas fa-edit text-[10px]"></i>
                                                </button>
                                                <button @click="deleteMember(member)"
                                                    class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="members.length === 0">
                                        <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                            <p class="font-bold text-[10px] uppercase tracking-widest">Belum ada data
                                                pengurus</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showModal" class="fixed inset-0 z-[100] overflow-y-auto" role="dialog">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal"></div>
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8 md:p-10">
                            <div class="flex justify-between items-center mb-8">
                                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                                    {{ editingItem ? 'Edit Pengurus' : 'Tambah Pengurus' }}
                                </h2>
                                <button @click="closeModal"
                                    class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-all flex items-center justify-center">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <form @submit.prevent="submit" class="space-y-6 text-left text-slate-700">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Nama
                                            Lengkap</label>
                                        <input v-model="form.nama" type="text"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                            placeholder="Nama lengkap..." required>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Urutan</label>
                                        <input v-model="form.urutan" type="number"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                            placeholder="0" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Jabatan</label>
                                        <input v-model="form.jabatan" type="text"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                            placeholder="Contoh: Ketua" required>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Kategori</label>
                                        <select v-model="form.kategori"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none appearance-none">
                                            <option v-for="opt in kategoriOptions" :key="opt" :value="opt">{{ opt }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">No.
                                        WhatsApp</label>
                                    <input v-model="form.no_hp" type="text"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                        placeholder="08xxxxxxxxxx">
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto</label>
                                    <div class="relative group">
                                        <input type="file" @input="form.foto = $event.target.files[0]"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div
                                            class="px-6 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center gap-3 transition-all group-hover:border-blue-500 group-hover:bg-blue-50">
                                            <i class="fas fa-camera text-slate-400 group-hover:text-blue-500"></i>
                                            <span
                                                class="text-xs font-bold text-slate-500 group-hover:text-blue-600 line-clamp-1">
                                                {{ form.foto ? form.foto.name : 'Pilih Foto (Maks 1MB)' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" :disabled="form.processing"
                                        class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 shadow-xl shadow-blue-600/20 transition-all disabled:opacity-50">
                                        {{ editingItem ? 'SIMPAN PERUBAHAN' : 'TAMBAH PENGURUS' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Delete Confirmation Modal -->
            <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showDeleteModal" class="fixed inset-0 z-[110] overflow-y-auto" role="dialog">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div
                            class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-8 text-center text-slate-700">
                            <div
                                class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-900 mb-2">Hapus Pengurus?</h2>
                            <p class="text-slate-500 font-bold text-sm mb-8 leading-relaxed">
                                Apakah Anda yakin ingin menghapus <span class="text-slate-900 font-black">{{
                                    itemToDelete?.nama }}</span>?
                            </p>
                            <div class="flex gap-4">
                                <button @click="showDeleteModal = false"
                                    class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                                    Batal
                                </button>
                                <button @click="confirmDelete"
                                    class="flex-1 py-4 bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 shadow-xl shadow-rose-600/20 transition-all">
                                    Ya, Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Icon Picker Modal -->
            <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showIconModal" class="fixed inset-0 z-[120] overflow-y-auto" role="dialog">
                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showIconModal = false"></div>
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-black text-slate-900 tracking-tight">Pilih Ikon Kegiatan</h2>
                                <button @click="showIconModal = false"
                                    class="text-slate-400 hover:text-rose-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-4">
                                <button v-for="icon in AVAILABLE_ICONS" :key="icon" @click="selectIcon(icon)"
                                    class="w-full aspect-square rounded-2xl flex items-center justify-center text-xl transition-all border-2"
                                    :class="profileForm.kegiatan_majelis_taklim[activeActivityIndex]?.icon === icon
                                        ? 'bg-emerald-50 border-emerald-500 text-emerald-600'
                                        : 'bg-slate-50 border-transparent text-slate-400 hover:bg-emerald-50 hover:text-emerald-500'">
                                    <i :class="['fas', icon]"></i>
                                </button>
                            </div>
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
                    class="fixed bottom-10 right-10 z-[110] p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm leading-none mb-1 text-left">Berhasil!</p>
                        <p class="text-slate-500 text-xs font-bold">{{ notification.message }}</p>
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
</style>
