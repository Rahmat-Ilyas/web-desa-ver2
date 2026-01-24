<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    members: Array,
    rws: Array
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
    rukun_warga_id: '',
    no_rt: '',
    nama_ketua: '',
    no_hp: '',
    foto_ketua: null
});

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    if (props.rws.length > 0) {
        form.rukun_warga_id = props.rws[0].id; // Default to first RW
    }
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.rukun_warga_id = item.rukun_warga_id;
    form.no_rt = item.no_rt;
    form.nama_ketua = item.nama_ketua;
    form.no_hp = item.no_hp;
    form.foto_ketua = null; // Reset photo input
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const handleFileChange = (e) => {
    if (e.target.files[0]) {
        form.foto_ketua = e.target.files[0];
    }
};

const submit = () => {
    if (editingItem.value) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(route('admin.rukun-tetangga.update', editingItem.value.id), {
            onSuccess: () => {
                closeModal();
                showNotification('Data RT berhasil diperbarui');
            },
            forceFormData: true,
        });
    } else {
        form.post(route('admin.rukun-tetangga.store'), {
            onSuccess: () => {
                closeModal();
                showNotification('Data RT berhasil ditambahkan');
            },
            forceFormData: true,
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
        router.delete(route('admin.rukun-tetangga.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
                showNotification('Data RT berhasil dihapus');
            }
        });
    }
};

const formatWa = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, '');
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};
</script>

<template>
    <AdminLayout>

        <Head title="Manajemen RT" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100 shadow-sm">
                        <i class="fas fa-sitemap"></i> Lembaga Kelurahan
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-2">Rukun Tetangga (RT)
                    </h1>
                    <p class="text-slate-500 font-bold text-sm">Kelola data ketua dan pengurus RT.</p>
                </div>
                <button @click="openCreateModal"
                    class="px-6 py-3 rounded-xl bg-blue-600 text-white font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all flex items-center gap-2 shadow-lg shadow-blue-600/20">
                    <i class="fas fa-plus"></i> Tambah RT
                </button>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="item in members" :key="item.id"
                    class="bg-white rounded-[2rem] border border-slate-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">

                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[4rem] -mr-8 -mt-8 z-0"></div>

                    <div class="relative z-10 flex flex-col items-center text-center">
                        <!-- Foto Profile -->
                        <div
                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg mb-4 bg-white overflow-hidden relative group-hover:scale-105 transition-transform">
                            <img v-if="item.foto_ketua" :src="'/storage/' + item.foto_ketua"
                                class="w-full h-full object-cover">
                            <div v-else
                                class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-2">
                            <span
                                class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest">
                                RT {{ item.no_rt }}
                            </span>
                            <span
                                class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                                RW {{ item.rukun_warga?.no_rw || '??' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-black text-slate-900 mb-1 leading-tight">{{ item.nama_ketua }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Ketua RT</p>

                        <div class="w-full pt-4 border-t border-slate-50 flex items-center justify-between text-sm">
                            <a :href="'https://wa.me/' + formatWa(item.no_hp)" target="_blank" v-if="item.no_hp"
                                class="text-slate-500 font-bold hover:text-green-500 transition-colors flex items-center gap-2">
                                <i class="fab fa-whatsapp text-lg text-green-500"></i> {{ item.no_hp }}
                            </a>
                            <span v-else class="text-slate-300 italic text-xs">No HP Kosong</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                        <button @click="openEditModal(item)"
                            class="w-8 h-8 rounded-lg bg-white text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm flex items-center justify-center transition-all">
                            <i class="fas fa-pen text-xs"></i>
                        </button>
                        <button @click="deleteItem(item)"
                            class="w-8 h-8 rounded-lg bg-white text-rose-500 hover:bg-rose-500 hover:text-white shadow-sm flex items-center justify-center transition-all">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="members.length === 0"
                    class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 rounded-[3rem] bg-slate-50/50">
                    <div
                        class="w-20 h-20 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-4">
                        <i class="fas fa-users-slash text-3xl"></i>
                    </div>
                    <p class="text-slate-500 font-bold">Belum ada data RT.</p>
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
                    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8 overflow-hidden">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-xl font-black text-slate-900">{{ editingItem ? 'Edit Data RT' : 'Tambah RT
                                Baru' }}</h2>
                            <button @click="closeModal"
                                class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-400">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Pilih
                                        RW</label>
                                    <select v-model="form.rukun_warga_id"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-5 py-3 rounded-2xl font-bold text-slate-700 transition-all outline-none appearance-none"
                                        required>
                                        <option value="" disabled>Pilih RW</option>
                                        <option v-for="rw in rws" :key="rw.id" :value="rw.id">RW {{ rw.no_rw }} - {{
                                            rw.nama_ketua }}</option>
                                    </select>
                                    <p v-if="form.errors.rukun_warga_id"
                                        class="text-xs text-rose-500 mt-1 ml-3 font-bold">{{ form.errors.rukun_warga_id
                                        }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Nomor
                                        RT</label>
                                    <input v-model="form.no_rt" type="text"
                                        class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-5 py-3 rounded-2xl font-bold text-slate-700 transition-all outline-none text-center"
                                        placeholder="01" required>
                                    <p v-if="form.errors.no_rt" class="text-xs text-rose-500 mt-1 ml-3 font-bold">{{
                                        form.errors.no_rt }}</p>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Nama
                                    Ketua RT</label>
                                <input v-model="form.nama_ketua" type="text"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-5 py-3 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    placeholder="Nama Lengkap" required>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">No.
                                    HP / WA</label>
                                <input v-model="form.no_hp" type="text"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-5 py-3 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                    placeholder="08...">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto
                                    Ketua (Opsional)</label>
                                <div class="relative group cursor-pointer">
                                    <input type="file" @change="handleFileChange"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        accept="image/*">
                                    <div
                                        class="w-full bg-slate-50 border-2 border-dashed border-slate-200 group-hover:border-blue-400 rounded-2xl p-4 flex items-center justify-center gap-3 transition-colors">
                                        <i class="fas fa-camera text-slate-400 group-hover:text-blue-500"></i>
                                        <span
                                            class="text-xs font-bold text-slate-500 group-hover:text-blue-600 line-clamp-1">{{
                                                form.foto_ketua ? (form.foto_ketua.name || 'Ganti foto terpilih') : 'Upload
                                            Foto JPG/PNG' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex gap-3">
                                <button type="button" @click="closeModal"
                                    class="flex-1 py-3 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-slate-200 transition-all">Batal</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-[2] py-3 bg-blue-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 disabled:opacity-50">
                                    {{ editingItem ? 'Simpan' : 'Tambah' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Delete Warning -->
        <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isDeleteModalOpen" class="fixed inset-0 z-[110] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeDeleteModal"></div>
                <div class="bg-white rounded-[2.5rem] w-full max-sm p-8 shadow-2xl relative z-10 text-center">
                    <div
                        class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-500">
                        <i class="fas fa-trash-alt text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 mb-2">Hapus Data RT?</h3>
                    <p class="text-slate-500 font-medium text-xs mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex gap-3">
                        <button @click="closeDeleteModal"
                            class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-xs text-slate-600 uppercase tracking-widest hover:bg-slate-200">Batal</button>
                        <button @click="confirmDelete"
                            class="flex-1 py-3 bg-rose-600 rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-rose-700 shadow-lg shadow-rose-500/30">Hapus</button>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Notification Toast -->
        <transition enter-active-class="transform transition duration-500 ease-out"
            enter-from-class="translate-y-10 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-300 ease-in" leave-from-class="opacity-100"
            leave-to-class="translate-y-10 opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-10 z-[120] p-4 bg-white border border-emerald-100 rounded-2xl flex items-center gap-3 shadow-2xl">
                <div
                    class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-xs">Berhasil!</p>
                    <p class="text-slate-500 text-[10px] font-bold">{{ notification.message }}</p>
                </div>
            </div>
        </transition>

    </AdminLayout>
</template>
