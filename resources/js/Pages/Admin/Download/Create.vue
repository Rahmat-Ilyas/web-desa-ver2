<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const form = useForm({
    judul: '',
    kategori: 'Layanan Umum',
    file: null,
    deskripsi: '',
});

const categories = [
    'Layanan Umum', 'Hukum', 'Transparansi', 'Kependudukan', 'Lainnya'
];

const filePreview = ref(null);

const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.file = file;
        filePreview.value = {
            name: file.name,
            size: (file.size / 1024).toFixed(2) + ' KB',
            type: file.name.split('.').pop().toUpperCase()
        };
    }
};

const submit = () => {
    form.post(route('admin.download.store'));
};
</script>

<template>
    <AdminLayout>

        <Head title="Upload Dokumen Baru" />

        <div class="max-w-[1000px] mx-auto px-4">
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-plus"></i> File Manager
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Upload Dokumen</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Unggah dokumen resmi untuk publik.</p>
                </div>

                <div class="flex items-center gap-3">
                    <Link :href="route('admin.download.index')"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-xs hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm uppercase tracking-widest">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8 pb-20">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form Area -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Judul Card -->
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                            <div class="mb-6 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                                    <i class="fas fa-heading"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Nama Dokumen</h3>
                            </div>
                            <input v-model="form.judul" type="text"
                                class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/5 font-bold text-slate-700 text-lg placeholder:text-slate-300 transition-all"
                                placeholder="Contoh: Formulir SKTM 2024">
                            <p v-if="form.errors.judul" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                                form.errors.judul }}</p>
                        </div>

                        <!-- Deskripsi Card -->
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                            <div class="mb-6 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Keterangan
                                    Singkat</h3>
                            </div>
                            <textarea v-model="form.deskripsi" rows="4"
                                class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/5 font-bold text-slate-600 text-sm placeholder:text-slate-300 transition-all resize-none"
                                placeholder="Jelaskan isi dokumen secara singkat..."></textarea>
                            <p v-if="form.errors.deskripsi" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                                form.errors.deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="space-y-8">
                        <!-- Category & File Card -->
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                            <!-- Category -->
                            <div class="mb-8">
                                <div class="mb-4 flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                                        <i class="fas fa-tags text-xs"></i>
                                    </div>
                                    <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest">Kategori
                                    </h3>
                                </div>
                                <select v-model="form.kategori"
                                    class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 font-bold text-slate-600 text-sm focus:ring-2 focus:ring-amber-500/10 cursor-pointer">
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                                <p v-if="form.errors.kategori" class="mt-2 text-rose-500 text-[10px] font-bold">{{
                                    form.errors.kategori }}</p>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-4 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-file-upload text-xs"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest">File Dokumen
                                </h3>
                            </div>

                            <div v-if="filePreview"
                                class="bg-slate-50 rounded-2xl p-4 mb-4 relative group border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-500 shadow-sm">
                                        <i class="fas fa-file text-lg"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-xs font-bold text-slate-700 truncate w-full">{{ filePreview.name
                                            }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">{{ filePreview.type }}
                                            • {{ filePreview.size }}</p>
                                    </div>
                                </div>
                                <button @click="form.file = null; filePreview = null" type="button"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-rose-600 transition-all opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-times text-[10px]"></i>
                                </button>
                            </div>

                            <label v-else
                                class="aspect-[4/3] rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 hover:border-emerald-200 transition-all group/upload mb-4">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3 group-hover/upload:scale-110 transition-transform">
                                    <i
                                        class="fas fa-cloud-upload-alt text-2xl text-slate-300 group-hover/upload:text-emerald-500 transition-colors"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-400 group-hover/upload:text-slate-600">Klik
                                    untuk upload</span>
                                <span class="text-[10px] text-slate-300 mt-1 uppercase font-bold tracking-wider">PDF,
                                    DOCX, XLSX (Max 10MB)</span>
                                <input type="file" @change="handleFileUpload" class="hidden"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                            </label>

                            <p v-if="form.errors.file" class="mt-2 text-rose-500 text-[10px] font-bold">{{
                                form.errors.file }}</p>
                        </div>

                        <!-- Publish Card -->
                        <div
                            class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all duration-700">
                            </div>
                            <h3 class="text-lg font-black mb-2 relative z-10 uppercase tracking-tight">Upload Sekarang?
                            </h3>
                            <p class="text-slate-400 font-bold text-xs mb-6 leading-relaxed relative z-10">Pastikan file
                                yang diupload valid dan aman untuk publik.</p>
                            <button type="submit" :disabled="form.processing"
                                class="w-full bg-blue-600 hover:bg-blue-500 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-900/40 flex items-center justify-center gap-3 disabled:opacity-50 relative z-10 active:scale-95 group/btn">
                                <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                                <span v-else class="flex items-center gap-2">
                                    UPLOAD FILE <i
                                        class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
