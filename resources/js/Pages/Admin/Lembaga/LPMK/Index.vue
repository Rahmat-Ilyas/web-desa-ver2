<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const title = 'Pengurus LPMK';

const props = defineProps({
    members: Array,
    profile: String,
    tasks: Array,
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

// Profile & Tasks Section
const profileForm = useForm({
    profil_lpmk: props.profile || '',
    tugas_lpmk: props.tasks && props.tasks.length > 0 ? props.tasks : [
        "Menyusun rencana pembangunan yang partisipatif (Musrenbang).",
        "Menggerakkan swadaya gotong royong masyarakat.",
        "Melaksanakan dan mengendalikan pembangunan.",
        "Menampung dan menyalurkan aspirasi masyarakat."
    ],
});

const addTask = () => {
    profileForm.tugas_lpmk.push("");
};

const removeTask = (index) => {
    if (profileForm.tugas_lpmk.length > 1) {
        profileForm.tugas_lpmk.splice(index, 1);
    }
};

const submitProfile = () => {
    profileForm.put(route('admin.lpmk.profile.update'), {
        preserveScroll: true,
        onSuccess: () => showNotification('Profil & Tugas LPMK berhasil diperbarui'),
    });
};

const showModal = ref(false);
const editingItem = ref(null);

const form = useForm({
    nama: '',
    jabatan: '',
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
        // Inertia requirement for multipart/form-data on PUT: use POST with _method=PUT
        router.post(route('admin.lpmk.update', editingItem.value.id), {
            _method: 'PUT',
            ...form.data(),
        }, {
            forceFormData: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.lpmk.store'), {
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
        router.delete(route('admin.lpmk.destroy', itemToDelete.value.id), {
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
                    <p class="text-slate-500 font-bold text-sm">Kelola data jajaran pengurus LPMK Kelurahan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <!-- Left Column: Profile & Tasks (Wider) -->
                <div class="lg:col-span-6 space-y-10">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-5 md:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shadow-sm">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-slate-900 leading-none mb-1">Profil Lembaga</h2>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">
                                    Deskripsi & Fungsi</p>
                            </div>
                        </div>

                        <form @submit.prevent="submitProfile" class="space-y-10">
                            <div class="space-y-8">
                                <!-- Deskripsi Section -->
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-3 text-left">Deskripsi
                                        Profil</label>
                                    <textarea v-model="profileForm.profil_lpmk" rows="10"
                                        class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent focus:border-teal-500 focus:bg-white rounded-[2rem] font-bold transition-all outline-none resize-none text-slate-700 leading-relaxed text-sm shadow-inner"
                                        placeholder="Masukkan deskripsi profil LPMK..."></textarea>
                                </div>

                                <!-- Tugas Utama Section -->
                                <div class="pt-8 border-t border-slate-50">
                                    <div class="flex items-center justify-between mb-4 ml-3">
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Tugas
                                            Utama</label>
                                        <button type="button" @click="addTask"
                                            class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-700 transition-all flex items-center gap-1.5">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="space-y-3 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                                        <transition-group enter-active-class="transition duration-300 ease-out"
                                            enter-from-class="opacity-0 -translate-y-2"
                                            enter-to-class="opacity-100 translate-y-0"
                                            leave-active-class="transition duration-200 ease-in"
                                            leave-from-class="opacity-100 scale-100"
                                            leave-to-class="opacity-0 scale-95">
                                            <div v-for="(task, index) in profileForm.tugas_lpmk" :key="index"
                                                class="flex gap-2 items-start group">
                                                <div class="flex-grow relative">
                                                    <input v-model="profileForm.tugas_lpmk[index]" type="text"
                                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-[1.25rem] font-bold text-xs transition-all outline-none text-slate-700 shadow-sm"
                                                        placeholder="Tuliskan tugas...">
                                                    <div
                                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] font-black">
                                                        {{ index + 1 }}
                                                    </div>
                                                </div>
                                                <button type="button" @click="removeTask(index)"
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
                                SIMPAN PROFIL & TUGAS
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Members Table (Narrower) -->
                <div class="lg:col-span-6 space-y-10">
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-4 md:p-10 overflow-hidden">
                        <div class="border-b border-slate-50 flex items-center justify-between gap-4 pb-6">
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
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50">
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-12">
                                            #</th>
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            Pengurus</th>
                                        <th
                                            class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <tr v-for="member in members" :key="member.id"
                                        class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-4 py-5 text-center">
                                            <span
                                                class="font-black text-slate-300 group-hover:text-blue-600 transition-colors text-sm">#{{
                                                    member.urutan }}</span>
                                        </td>
                                        <td class="px-4 py-5">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm flex-shrink-0">
                                                    <img :src="getPhotoUrl(member.foto)"
                                                        class="w-full h-full object-cover">
                                                </div>
                                                <div class="overflow-hidden">
                                                    <p
                                                        class="font-black text-slate-900 text-sm truncate max-w-[120px] sm:max-w-none">
                                                        {{ member.nama
                                                        }}</p>
                                                    <p
                                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate mt-0.5">
                                                        {{ member.jabatan }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5 transition-all">
                                                <button @click="openEditModal(member)"
                                                    class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fas fa-edit text-[10px]"></i>
                                                </button>
                                                <button @click="deleteMember(member)"
                                                    class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fas fa-trash text-[10px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="members.length === 0">
                                        <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                            <p class="font-bold text-[10px] uppercase tracking-widest">Belum ada data
                                            </p>
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
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Urutan
                                            Tampil</label>
                                        <input v-model="form.urutan" type="number"
                                            class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                            placeholder="0" required>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Jabatan</label>
                                    <input v-model="form.jabatan" type="text"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                        placeholder="Contoh: Ketua LPMK" required>
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">No.
                                        WhatsApp (Opsional)</label>
                                    <input v-model="form.no_hp" type="text"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                        placeholder="08xxxxxxxxxx">
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto
                                        Pengurus (Opsional)</label>
                                    <div class="relative group">
                                        <input type="file" @input="form.foto = $event.target.files[0]"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div
                                            class="px-6 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex items-center justify-center gap-3 transition-all group-hover:border-blue-500 group-hover:bg-blue-50">
                                            <i class="fas fa-camera text-slate-400 group-hover:text-blue-500"></i>
                                            <span
                                                class="text-xs font-bold text-slate-500 group-hover:text-blue-600 line-clamp-1">
                                                {{ form.foto ? form.foto.name : 'Pilih Foto JPG/PNG (Maks 1MB)' }}
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
                        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-8 text-center">
                            <div
                                class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-900 mb-2">Hapus Pengurus?</h2>
                            <p class="text-slate-500 font-bold text-sm mb-8 leading-relaxed">
                                Apakah Anda yakin ingin menghapus <span class="text-slate-900 font-black">{{
                                    itemToDelete?.nama }}</span>? Tindakan ini tidak dapat dibatalkan.
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
                        <p class="text-slate-900 font-black text-sm leading-none mb-1">Berhasil!</p>
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
