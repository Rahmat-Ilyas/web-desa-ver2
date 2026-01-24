<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    layanans: Array
});

const isModalOpen = ref(false);
const editingLayanan = ref(null);

const icons = [
    'fa-id-card', 'fa-file-signature', 'fa-users', 'fa-shield-alt',
    'fa-building', 'fa-book-reader', 'fa-store', 'fa-hand-holding-heart',
    'fa-heart', 'fa-home', 'fa-briefcase', 'fa-landmark', 'fa-map-marked-alt',
    'fa-file-alt', 'fa-balance-scale', 'fa-user-check'
];

const colors = [
    { name: 'Orange', class: 'bg-orange-50 text-orange-600' },
    { name: 'Blue', class: 'bg-blue-50 text-blue-600' },
    { name: 'Emerald', class: 'bg-emerald-50 text-emerald-600' },
    { name: 'Red', class: 'bg-red-50 text-red-600' },
    { name: 'Amber', class: 'bg-amber-50 text-amber-600' },
    { name: 'Gray', class: 'bg-gray-50 text-gray-600' },
    { name: 'Indigo', class: 'bg-indigo-50 text-indigo-600' },
    { name: 'Rose', class: 'bg-rose-50 text-rose-600' },
    { name: 'Violet', class: 'bg-violet-50 text-violet-600' },
    { name: 'Teal', class: 'bg-teal-50 text-teal-600' },
];

const form = useForm({
    title: '',
    description: '',
    icon: 'fa-file-alt',
    color: 'bg-blue-50 text-blue-600',
    requirements: ['']
});

const openCreateModal = () => {
    editingLayanan.value = null;
    form.reset();
    form.requirements = [''];
    isModalOpen.value = true;
};

const openEditModal = (layanan) => {
    editingLayanan.value = layanan;
    form.title = layanan.title;
    form.description = layanan.description;
    form.icon = layanan.icon;
    form.color = layanan.color;
    form.requirements = [...layanan.requirements];
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const addRequirement = () => {
    form.requirements.push('');
};

const removeRequirement = (index) => {
    form.requirements.splice(index, 1);
};

const submit = () => {
    if (editingLayanan.value) {
        form.put(route('admin.layanan.update', editingLayanan.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.layanan.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteLayanan = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
        useForm({}).delete(route('admin.layanan.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>

        <Head title="Manajemen Layanan" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-5">
                <div class="mb-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-concierge-bell"></i> Layanan Warga
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Layanan Administrasi</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola jenis layanan dan persyaratan surat secara transparan.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full md:w-auto"></div> <!-- Spacer for future search -->
                    <button @click="openCreateModal" 
                        class="w-full md:w-auto px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-xl shadow-blue-600/20 whitespace-nowrap">
                        <i class="fas fa-plus"></i> TAMBAH LAYANAN
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="layanan in layanans" :key="layanan.id"
                    class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 group flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <div
                            :class="[layanan.color, 'w-16 h-16 rounded-[1.5rem] flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform duration-500']">
                            <i :class="['fas', layanan.icon]"></i>
                        </div>
                        <div
                            class="flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
                            <button @click="openEditModal(layanan)"
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="deleteLayanan(layanan.id)"
                                class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <h3 class="text-xl font-black text-slate-900 mb-3 leading-tight">{{ layanan.title }}</h3>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8 flex-grow line-clamp-3">
                        {{ layanan.description }}</p>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">
                            {{ layanan.requirements.length }} PERSYARATAN
                        </span>
                        <button @click="openEditModal(layanan)"
                            class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline decoration-2 underline-offset-4">DETAIL
                            & EDIT</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal"></div>
                <div class="flex min-h-full items-center justify-center p-4">
                    <div
                        class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl p-8 md:p-12 overflow-hidden">
                        <div class="flex justify-between items-center mb-10">
                            <h2 class="text-2xl font-black text-slate-900">{{ editingLayanan ? 'Edit Layanan' :
                                'Tambah Layanan Baru' }}</h2>
                            <button @click="closeModal"
                                class="p-3 hover:bg-slate-100 rounded-2xl transition-colors text-slate-400">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submit" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Nama
                                            Layanan</label>
                                        <input v-model="form.title" type="text"
                                            class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                            placeholder="Contoh: Pembuatan KTP">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-4">Deskripsi
                                            Singkat</label>
                                        <textarea v-model="form.description" rows="3"
                                            class="w-full bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-6 py-4 rounded-2xl font-bold text-slate-700 transition-all outline-none"
                                            placeholder="Jelaskan secara ringkas layanan ini..."></textarea>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-4">Pilih
                                            Warna & Icon</label>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <button v-for="color in colors" :key="color.name" type="button"
                                                @click="form.color = color.class"
                                                :class="[color.class, 'w-8 h-8 rounded-full border-2 transition-all', form.color === color.class ? 'border-slate-900 scale-110' : 'border-transparent']"
                                                :title="color.name"></button>
                                        </div>
                                        <div
                                            class="grid grid-cols-5 gap-2 p-4 bg-slate-50 rounded-2xl max-h-40 overflow-y-auto">
                                            <button v-for="icon in icons" :key="icon" type="button"
                                                @click="form.icon = icon"
                                                :class="['w-10 h-10 rounded-xl flex items-center justify-center transition-all', form.icon === icon ? 'bg-slate-900 text-white' : 'bg-white text-slate-400 hover:bg-slate-200']">
                                                <i :class="['fas', icon]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div class="flex justify-between items-center ml-4">
                                        <label
                                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Syarat
                                            & Berkas</label>
                                        <button type="button" @click="addRequirement"
                                            class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">+
                                            Tambah</button>
                                    </div>
                                    <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                        <div v-for="(req, index) in form.requirements" :key="index" class="flex gap-2">
                                            <input v-model="form.requirements[index]" type="text"
                                                class="flex-grow bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white px-4 py-3 rounded-xl font-semibold text-sm text-slate-600 transition-all outline-none"
                                                :placeholder="`Syarat ke-${index + 1}`">
                                            <button v-if="form.requirements.length > 1" type="button"
                                                @click="removeRequirement(index)"
                                                class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 flex gap-4">
                                <button type="button" @click="closeModal"
                                    class="flex-grow py-4 bg-slate-100 text-slate-600 font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                                <button type="submit" :disabled="form.processing"
                                    class="flex-[2] py-4 bg-blue-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50">
                                    {{ editingLayanan ? 'SIMPAN PERUBAHAN' : 'TAMBAHKAN LAYANAN' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </AdminLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
