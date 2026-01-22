<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const imagePreview = ref(null);

const form = useForm({
    judul: '',
    kategori: 'Umum',
    konten: '',
    image: null,
});

const categories = [
    'Umum', 'Prestasi', 'Ekonomi', 'Sosial', 'Pembangunan', 'Pemerintahan', 'Kesehatan', 'Pendidikan'
];

const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('admin.berita.store'));
};

const editor = ClassicEditor;
const editorConfig = {
    toolbar: {
        items: [
            'heading', '|',
            'bold', 'italic', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'outdent', 'indent', '|',
            'blockQuote', 'insertTable', 'undo', 'redo'
        ],
        shouldNotGroupWhenFull: true
    },
    placeholder: 'Tuliskan isi berita di sini...',
};
</script>

<template>
    <AdminLayout>

        <Head title="Buat Berita Baru" />

        <div class="max-w-[1200px] mx-auto px-4">
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-plus"></i> Content Creator
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Tulis Berita Baru</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Publikasikan informasi terbaru untuk warga
                        Kelurahan Ujung Sabbang.</p>
                </div>

                <div class="flex items-center gap-3">
                    <Link :href="route('admin.berita.index')"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-xs hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm uppercase tracking-widest">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8 pb-20">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Main Editor Area -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Judul Card -->
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                            <div class="mb-6 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-sm">
                                    <i class="fas fa-font"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Judul Berita</h3>
                            </div>
                            <input v-model="form.judul" type="text"
                                class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/5 font-bold text-slate-700 text-xl placeholder:text-slate-300 transition-all uppercase tracking-tight"
                                placeholder="MASUKKAN JUDUL BERITA YANG MENARIK...">
                            <p v-if="form.errors.judul" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                                form.errors.judul }}</p>
                        </div>

                        <!-- Konten Card -->
                        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 editor-container">
                            <div class="mb-6 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Isi Konten Berita
                                </h3>
                            </div>
                            <div class="modern-editor">
                                <ckeditor :editor="editor" v-model="form.konten" :config="editorConfig"></ckeditor>
                            </div>
                            <p v-if="form.errors.konten" class="mt-4 text-rose-500 text-xs font-bold pl-2">{{
                                form.errors.konten }}</p>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="space-y-8">
                        <!-- Category & Image Card -->
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
                                    class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 font-bold text-slate-600 text-sm focus:ring-2 focus:ring-amber-500/10">
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                            </div>

                            <!-- Featured Image -->
                            <div class="mb-4 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-image text-xs"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest">Gambar Utama
                                </h3>
                            </div>
                            <div class="relative group">
                                <div v-if="imagePreview"
                                    class="aspect-video rounded-2xl overflow-hidden mb-4 border border-slate-100 shadow-sm relative">
                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                    <button @click="imagePreview = null; form.image = null" type="button"
                                        class="absolute top-2 right-2 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center shadow-lg hover:bg-rose-600 transition-all opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <label v-else
                                    class="aspect-video rounded-2xl border-2 border-dashed border-slate-100 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-all group/upload mb-4">
                                    <i
                                        class="fas fa-cloud-upload-alt text-3xl text-slate-200 group-hover/upload:text-emerald-400 transition-colors"></i>
                                    <span
                                        class="text-[10px] font-black text-slate-400 mt-3 group-hover/upload:text-slate-600 uppercase tracking-widest">Klik
                                        Untuk Upload</span>
                                    <input type="file" @change="handleImageUpload" class="hidden" accept="image/*">
                                </label>
                            </div>
                            <p v-if="form.errors.image" class="mt-2 text-rose-500 text-[10px] font-bold">{{
                                form.errors.image }}</p>
                        </div>

                        <!-- Publish Card -->
                        <div
                            class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all duration-700">
                            </div>
                            <h3 class="text-xl font-black mb-4 relative z-10 uppercase tracking-tight">Siap Terbit?</h3>
                            <p class="text-slate-400 font-bold text-xs mb-8 leading-relaxed relative z-10">
                                Pastikan judul menarik dan isi berita telah diperiksa tata bahasanya sebelum
                                dipublikasikan ke warga.
                            </p>
                            <button type="submit" :disabled="form.processing"
                                class="w-full bg-blue-600 hover:bg-blue-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-900/40 flex items-center justify-center gap-3 disabled:opacity-50 relative z-10 active:scale-95 group/btn">
                                <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                                <i v-else
                                    class="fas fa-paper-plane group-hover/btn:translate-x-1 group-hover/btn:-translate-y-1 transition-transform"></i>
                                PUBLIKASIKAN SEKARANG
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style>
.modern-editor .ck-primary {
    border: none !important;
}

.modern-editor .ck-editor__editable_inline {
    min-height: 400px;
    background-color: #f8fafc !important;
    border: none !important;
    padding: 1.5rem 2.5rem !important;
    font-size: 1rem;
    font-weight: 600;
    color: #334155;
    line-height: 1.8;
}

.modern-editor .ck-toolbar {
    background-color: #ffffff !important;
    border: none !important;
    border-top-left-radius: 2rem !important;
    border-top-right-radius: 2rem !important;
    padding: 0.75rem 1.5rem !important;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
}

.modern-editor .ck.ck-editor__main>.ck-editor__editable {
    border-bottom-left-radius: 2rem !important;
    border-bottom-right-radius: 2rem !important;
}

.ck-focused {
    outline: none !important;
    border: none !important;
}

.ck.ck-content pre {
    background: #0f172a !important;
    color: #f8fafc !important;
    padding: 1.5rem !important;
    border-radius: 1rem !important;
}
</style>
