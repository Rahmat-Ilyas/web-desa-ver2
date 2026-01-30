<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps({
    page_settings: Object,
    lurah: Object
});

const editor = ClassicEditor;
const editorConfig = {
    toolbar: {
        items: [
            'heading', '|',
            'bold', 'italic', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'blockQuote', 'undo', 'redo'
        ],
        shouldNotGroupWhenFull: true
    },
    placeholder: 'Tuliskan isi sambutan di sini...'
};

const form = useForm({
    sambutan_quote: props.page_settings.sambutan_quote || '',
    sambutan_message: props.page_settings.sambutan_message || ''
});

const showSuccess = ref(false);

const submit = () => {
    form.post(route('admin.sambutan.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccess.value = true;
            setTimeout(() => showSuccess.value = false, 3000);
        }
    });
};
</script>

<template>
    <AdminLayout>

        <Head :title="`Kelola Sambutan ${$page.props.settings?.sebutan_kepala || 'Lurah'}`" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-edit"></i> Editor Konten
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Sambutan {{
                        $page.props.settings?.sebutan_kepala || 'Lurah' }}</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola pesan resmi dan komitmen pelayanan
                        {{ ($page.props.settings?.sebutan_wilayah || 'Kelurahan').toLowerCase() }}.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a :href="route('profil.sambutan')" target="_blank"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                        <i class="fas fa-external-link-alt"></i> LIHAT WEB
                    </a>
                </div>
            </div>

            <!-- Success Notification -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showSuccess"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil Disimpan!</p>
                        <p class="text-slate-500 text-xs font-bold">Konten sambutan telah diperbarui.</p>
                    </div>
                </div>
            </transition>

            <!-- Lurah Profile Banner (Full Width) -->
            <div
                class="mb-10 bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>

                <div class="flex items-center gap-6 relative z-10">
                    <div class="relative">
                        <img :src="props.lurah?.photo ? '/storage/' + props.lurah.photo : 'https://placehold.co/100x100?text=👤'"
                            class="w-20 h-20 rounded-2xl object-cover ring-4 ring-blue-500/20 shadow-2xl"
                            :alt="'Foto ' + ($page.props.settings?.sebutan_kepala || 'Lurah')">
                        <div
                            class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center border-4 border-slate-900 shadow-lg">
                            <i class="fas fa-check text-[10px]"></i>
                        </div>
                    </div>
                    <div>
                        <h4
                            class="text-xs font-black text-blue-400 uppercase tracking-widest mb-1 flex items-center gap-2">
                            <i class="fas fa-user-circle"></i> Profil {{ $page.props.settings?.sebutan_kepala || 'Lurah' }}
                            Aktif
                        </h4>
                        <p class="font-black text-2xl leading-tight">{{ props.lurah?.name || 'Belum Diatur' }}</p>
                        <p class="text-slate-400 text-sm font-bold mt-1 tracking-wider">{{ props.lurah?.position ||
                            ($page.props.settings?.sebutan_kepala || 'Lurah') + ' ' + ($page.props.settings?.nama_wilayah || '[Nama Wilayah]') }}</p>
                    </div>
                </div>

                <Link :href="route('admin.struktur.index')"
                    class="relative z-10 px-6 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-white font-black text-xs transition-all border border-white/10 flex items-center gap-3">
                    <i class="fas fa-users-cog"></i> EDIT PROFIL STRUKTUR
                </Link>
            </div>

            <div class="space-y-8">
                <!-- Quote Section (Full Width) -->
                <div
                    class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 overflow-hidden relative group">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                    <div class="mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Kutipan Utama</h3>
                    </div>
                    <textarea v-model="form.sambutan_quote" rows="3"
                        class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 focus:ring-2 focus:ring-blue-500/10 font-bold text-slate-700 italic text-2xl placeholder:text-slate-300 transition-all leading-relaxed text-center"
                        placeholder="Masukkan kutipan..."></textarea>
                    <p v-if="form.errors.sambutan_quote" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                        form.errors.sambutan_quote }}</p>
                </div>

                <!-- Main Message Section (Full Width) -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-paragraph"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Narasi Sambutan Lengkap
                        </h3>
                    </div>

                    <div class="ck-editor-custom ck-content">
                        <ckeditor :editor="editor" v-model="form.sambutan_message" :config="editorConfig"></ckeditor>
                    </div>

                    <p v-if="form.errors.sambutan_message" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                        form.errors.sambutan_message }}</p>
                </div>

                <!-- Sticky Save Action Footer -->
                <div
                    class="mt-12 mb-20 p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-blue-900/5 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-50 group-hover:bg-blue-100/50 transition-colors rounded-full -mr-20 -mt-20 blur-3xl">
                    </div>

                    <div class="relative z-10">
                        <h4 class="font-black text-slate-900 text-lg">Siap mempublikasikan?</h4>
                        <p class="text-slate-500 font-bold text-sm">Pastikan semua narasi dan kutipan sudah sesuai
                            sebelum disimpan.</p>
                    </div>

                    <div class="flex items-center gap-4 relative z-10 w-full md:w-auto">
                        <button @click="submit" :disabled="form.processing"
                            class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/30 disabled:opacity-50 flex items-center justify-center gap-3 active:scale-95 group/btn">
                            <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            SIMPAN SEMUA PERUBAHAN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style>
/* Custom CKEditor Theme to match the new UI */
.ck-editor__editable_inline {
    min-height: 400px;
    background-color: transparent !important;
    border: none !important;
    padding: 2rem 0 !important;
    font-size: 1rem;
    font-weight: 600;
    color: #334155;
    line-height: 1.625;
}

.ck-content p,
.ck-editor__editable_inline p {
    margin-bottom: 1rem !important;
    text-align: justify !important;
}

.ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
    border-color: transparent !important;
}

.ck-toolbar {
    background-color: #f8fafc !important;
    border: 1px solid #f1f5f9 !important;
    border-radius: 1.5rem !important;
    padding: 0.5rem 1rem !important;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
}

.ck.ck-toolbar__separator {
    background-color: #e2e8f0 !important;
}

.ck-focused {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
}

.ck.ck-button.ck-on,
a.ck.ck-button.ck-on {
    background: #eff6ff !important;
    color: #2563eb !important;
}

.ck.ck-button:not(.ck-disabled):hover,
a.ck.ck-button:not(.ck-disabled):hover {
    background: #f1f5f9 !important;
}

/* Restore list styling inside editor (Tailwind reset fix) */
.ck-content ul,
.ck-editor__editable_inline ul {
    list-style-type: disc !important;
    padding-left: 2rem !important;
    margin-bottom: 1rem !important;
}

.ck-content ol,
.ck-editor__editable_inline ol {
    list-style-type: decimal !important;
    padding-left: 2rem !important;
    margin-bottom: 1rem !important;
}

.ck-content li,
.ck-editor__editable_inline li {
    display: list-item !important;
}

/* Heading styles inside editor */
.ck-content h2,
.ck-editor__editable_inline h2 {
    font-size: 1.5rem !important;
    font-weight: 800 !important;
    margin-top: 1.5rem !important;
    margin-bottom: 1rem !important;
    color: #1e293b !important;
}

.ck-content h3,
.ck-editor__editable_inline h3 {
    font-size: 1.25rem !important;
    font-weight: 700 !important;
    margin-top: 1.25rem !important;
    margin-bottom: 0.75rem !important;
    color: #334155 !important;
}

.ck-content h4,
.ck-editor__editable_inline h4 {
    font-size: 1.125rem !important;
    font-weight: 700 !important;
    margin-top: 1rem !important;
    margin-bottom: 0.5rem !important;
    color: #475569 !important;
}
</style>
