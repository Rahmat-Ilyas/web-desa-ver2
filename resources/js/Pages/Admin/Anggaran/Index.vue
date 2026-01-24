<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    anggaran: Array,
    tahun: [String, Number],
    years: Array,
});

const isModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isEditing = ref(false);
const itemToDelete = ref(null);

const form = useForm({
    id: null,
    tahun: new Date().getFullYear(),
    kategori: 'pendapatan',
    nama: '',
    jumlah: '',
});

const notification = ref({ show: false, message: '', type: 'success' });
const page = usePage();

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

// Check for flash messages on load or change
watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
}, { immediate: true });

const displayJumlah = ref('');

const openModal = (item = null) => {
    isEditing.value = !!item;
    if (item) {
        form.id = item.id;
        form.tahun = item.tahun;
        form.kategori = item.kategori;
        form.nama = item.nama;
        form.jumlah = item.jumlah;
        displayJumlah.value = formatRupiahInput(item.jumlah);
    } else {
        form.reset();
        form.tahun = props.tahun || new Date().getFullYear();
        form.kategori = 'pendapatan';
        displayJumlah.value = '';
    }
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
    displayJumlah.value = '';
};

const formatRupiahInput = (number) => {
    if (!number) return '';
    return new Intl.NumberFormat('id-ID').format(number);
};

const updateJumlah = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    form.jumlah = value;
    displayJumlah.value = formatRupiahInput(value);
};

const openDeleteModal = (item) => {
    itemToDelete.value = item;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    itemToDelete.value = null;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.anggaran.update', form.id), {
            onSuccess: () => {
                closeModal();
                showNotification('Data anggaran berhasil diperbarui.', 'success');
            },
        });
    } else {
        form.post(route('admin.anggaran.store'), {
            onSuccess: () => {
                closeModal();
                showNotification('Data anggaran berhasil ditambahkan.', 'success');
            },
        });
    }
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.anggaran.destroy', itemToDelete.value.id), {
            onSuccess: () => {
                closeDeleteModal();
                showNotification('Data anggaran berhasil dihapus.', 'success');
            },
        });
    }
};

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

const totalPendapatan = computed(() => {
    return props.anggaran.filter(a => a.kategori === 'pendapatan').reduce((sum, item) => sum + Number(item.jumlah), 0);
});

const totalBelanja = computed(() => {
    return props.anggaran.filter(a => a.kategori === 'belanja').reduce((sum, item) => sum + Number(item.jumlah), 0);
});

const changeYear = (event) => {
    router.get(route('admin.anggaran.index'), { tahun: event.target.value }, { preserveState: true });
};
</script>

<template>

    <Head title="Manajemen Anggaran" />

    <AdminLayout>
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-wallet"></i> Informasi Publik
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Manajemen Anggaran</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola data APBDes dan transparansi anggaran desa.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative w-full sm:w-64">
                            <i
                                class="far fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                            <select :value="tahun" @change="changeYear"
                                class="w-full pl-12 pr-10 py-4 bg-white border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all font-bold text-sm text-slate-900 shadow-sm appearance-none cursor-pointer">
                                <option v-for="y in years" :key="y" :value="y">Tahun Anggaran {{ y }}</option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <button @click="openModal()"
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH DATA
                    </button>
                </div>
            </div>

            <!-- Success Notification Popover -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="notification.show"
                    class="fixed bottom-10 right-10 z-[60] p-6 bg-white border border-emerald-100 rounded-2xl flex items-center gap-4 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] min-w-[300px]">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
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

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div
                    class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Pendapatan</p>
                        <h3 class="text-3xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">{{
                            formatRupiah(totalPendapatan) }}</h3>
                    </div>
                    <div
                        class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div
                    class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex items-center justify-between group hover:shadow-lg transition-all">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Belanja</p>
                        <h3 class="text-3xl font-black text-slate-900 group-hover:text-rose-600 transition-colors">{{
                            formatRupiah(totalBelanja) }}</h3>
                    </div>
                    <div
                        class="w-16 h-16 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 text-2xl group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-8 py-6">Kategori</th>
                                <th class="px-8 py-6">Uraian Anggaran</th>
                                <th class="px-8 py-6 text-right">Jumlah (Rp)</th>
                                <th class="px-8 py-6 text-center">Tahun</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="item in anggaran" :key="item.id"
                                class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5">
                                    <span :class="[
                                        'px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border',
                                        item.kategori === 'pendapatan' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100'
                                    ]">
                                        {{ item.kategori }}
                                    </span>
                                </td>
                                <td
                                    class="px-8 py-5 font-bold text-slate-700 group-hover:text-blue-600 transition-colors">
                                    {{ item.nama }}</td>
                                <td class="px-8 py-5 text-right font-black text-slate-800 text-lg">{{
                                    formatRupiah(item.jumlah) }}</td>
                                <td
                                    class="px-8 py-5 text-center font-bold text-slate-500 bg-slate-50/50 rounded-xl mx-2">
                                    {{
                                        item.tahun }}</td>
                                <td class="px-8 py-5">
                                    <div
                                        class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-2 group-hover:translate-x-0">
                                        <button @click="openModal(item)"
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
                            <tr v-if="anggaran.length === 0">
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div
                                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                        <i class="fas fa-folder-open text-3xl"></i>
                                    </div>
                                    <p class="text-slate-900 font-bold text-lg mb-1">Tidak ada data</p>
                                    <p class="text-slate-500 text-sm">Belum ada data anggaran untuk tahun {{ tahun }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add/Edit Modal -->
            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        @click="closeModal">
                    </div>

                    <div class="bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <span
                                    class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1 block">{{
                                        isEditing ? 'UPDATE DATA' : 'DATA BARU' }}</span>
                                <h3 class="text-2xl font-black text-slate-900">{{ isEditing ? 'Edit Anggaran' :
                                    'Tambah Anggaran' }}</h3>
                            </div>
                            <button @click="closeModal"
                                class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600 flex items-center justify-center transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-1">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tahun</label>
                                    <input v-model="form.tahun" type="number"
                                        class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-300"
                                        required>
                                    <p v-if="form.errors.tahun"
                                        class="text-rose-500 text-[10px] uppercase font-bold mt-2">
                                        {{ form.errors.tahun }}</p>
                                </div>

                                <div class="col-span-1">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kategori</label>
                                    <select v-model="form.kategori"
                                        class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 appearance-none cursor-pointer">
                                        <option value="pendapatan">Pendapatan</option>
                                        <option value="belanja">Belanja</option>
                                    </select>
                                    <p v-if="form.errors.kategori"
                                        class="text-rose-500 text-[10px] uppercase font-bold mt-2">{{
                                            form.errors.kategori
                                        }}</p>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Uraian
                                    / Nama Akun</label>
                                <input v-model="form.nama" type="text"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-300"
                                    placeholder="Contoh: Dana Desa (DD)" required>
                                <p v-if="form.errors.nama" class="text-rose-500 text-[10px] uppercase font-bold mt-2">{{
                                    form.errors.nama }}</p>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Jumlah
                                    Anggaran (Rp)</label>
                                <input v-model="displayJumlah" @input="updateJumlah" type="text"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-300"
                                    placeholder="0" required>
                                <p v-if="form.errors.jumlah" class="text-rose-500 text-[10px] uppercase font-bold mt-2">
                                    {{
                                        form.errors.jumlah }}</p>
                            </div>

                            <div class="pt-6 flex gap-4">
                                <button type="button" @click="closeModal"
                                    class="flex-1 bg-white border border-slate-200 text-slate-600 font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-slate-50 transition-colors">Batal</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-1 bg-blue-600 text-white font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-blue-500 transition-all shadow-xl shadow-blue-500/30 active:scale-95 disabled:opacity-50 disabled:scale-100">
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
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
                <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        @click="closeDeleteModal"></div>

                    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative z-10 text-center">
                        <div
                            class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                            <i class="fas fa-trash-alt text-3xl"></i>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 mb-2">Hapus Data Anggaran?</h3>
                        <p class="text-slate-500 font-medium text-sm mb-8 leading-relaxed">
                            Anda yakin ingin menghapus data <strong class="text-slate-800">{{ itemToDelete?.nama
                                }}</strong>?
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

        </div>
    </AdminLayout>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
