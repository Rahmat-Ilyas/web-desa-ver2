<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps({
    intro: String,
    timelines: Array
});

// CKEditor for Intro
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
    placeholder: 'Tuliskan narasi sejarah singkat di sini...'
};

// Intro Form
const introForm = useForm({
    intro: props.intro || ''
});

const saveIntro = () => {
    introForm.post(route('admin.sejarah.intro'), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification('Sejarah singkat berhasil diperbarui');
        }
    });
};

// Timeline CRUD
const timelineModalOpen = ref(false);
const editingTimeline = ref(null);

const timelineForm = useForm({
    year: '',
    title: '',
    content: '',
    order: 0,
});

const openTimelineModal = (timeline = null) => {
    editingTimeline.value = timeline;
    if (timeline) {
        timelineForm.year = timeline.year;
        timelineForm.title = timeline.title;
        timelineForm.content = timeline.content;
        timelineForm.order = timeline.order;
    } else {
        timelineForm.reset();
        timelineForm.order = props.timelines.length + 1;
    }
    timelineModalOpen.value = true;
};

const closeTimelineModal = () => {
    timelineModalOpen.value = false;
    editingTimeline.value = null;
    timelineForm.reset();
};

const submitTimeline = () => {
    const url = editingTimeline.value
        ? route('admin.sejarah.timeline.update', editingTimeline.value.id)
        : route('admin.sejarah.timeline.store');

    timelineForm.post(url, {
        onSuccess: () => {
            closeTimelineModal();
            showNotification(editingTimeline.value ? 'Timeline berhasil diperbarui' : 'Timeline berhasil ditambahkan');
        },
        preserveScroll: true
    });
};

// Delete Confirmation
const deleteModalOpen = ref(false);
const timelineToDelete = ref(null);
const deleteForm = useForm({});

const confirmDelete = (id) => {
    timelineToDelete.value = id;
    deleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    deleteModalOpen.value = false;
    timelineToDelete.value = null;
};

const executeDelete = () => {
    if (!timelineToDelete.value) return;

    deleteForm.delete(route('admin.sejarah.timeline.destroy', timelineToDelete.value), {
        onSuccess: () => {
            closeDeleteModal();
            showNotification('Timeline berhasil dihapus');
        },
        preserveScroll: true
    });
};

// Notifications
const notification = ref({ show: false, message: '' });
const showNotification = (msg) => {
    notification.value.message = msg;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};
</script>

<template>
    <AdminLayout>

        <Head :title="`Kelola Sejarah ${$page.props.settings?.sebutan_wilayah || 'Kelurahan'}`" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 text-slate-700">
            <!-- Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-history"></i> Profil Wilayah
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Sejarah {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }}</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola narasi sejarah dan timeline perkembangan
                        {{ $page.props.settings?.sebutan_wilayah?.toLowerCase() || 'kelurahan' }}.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a :href="route('profil.sejarah')" target="_blank"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                        <i class="fas fa-external-link-alt"></i> LIHAT WEB
                    </a>
                </div>
            </div>

            <!-- Intro Section (CKEditor) -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 mb-12">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Sejarah Singkat (Intro)
                        </h3>
                    </div>
                    <button @click="saveIntro" :disabled="introForm.processing"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-black text-xs hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                        <i v-if="introForm.processing" class="fas fa-circle-notch fa-spin"></i>
                        <i v-else class="fas fa-save"></i>
                        SIMPAN INTRO
                    </button>
                </div>

                <div class="ck-content editor-intro">
                    <ckeditor :editor="editor" v-model="introForm.intro" :config="editorConfig"></ckeditor>
                </div>
                <p v-if="introForm.errors.intro" class="mt-3 text-rose-500 text-xs font-bold">{{ introForm.errors.intro
                }}</p>
            </div>

            <!-- Timeline Section -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 overflow-hidden">
                <div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 font-bold">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-stream"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Timeline Sejarah</h3>
                    </div>
                    <button @click="openTimelineModal()"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black text-xs hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                        <i class="fas fa-plus"></i> TAMBAH PERISTIWA
                    </button>
                </div>

                <div class="space-y-4">
                    <div v-for="t in timelines" :key="t.id"
                        class="p-6 rounded-3xl border border-slate-50 bg-slate-50/50 hover:bg-white hover:border-blue-100 hover:shadow-xl hover:shadow-blue-900/5 transition-all group">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 min-w-0">
                            <div class="flex gap-5 min-w-0 flex-1">
                                <div
                                    class="w-20 h-20 bg-white rounded-2xl flex flex-col items-center justify-center border border-slate-100 shadow-sm shrink-0 overflow-hidden transition-transform group-hover:scale-105 duration-300">
                                    <span
                                        class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1 text-center px-1">Periode</span>
                                    <span class="text-xs font-black text-blue-600 text-center px-1">{{ t.year }}</span>
                                </div>
                                <div class="overflow-hidden min-w-0">
                                    <h4 class="font-black text-slate-900 text-lg mb-1 truncate">{{ t.title }}</h4>
                                    <!-- Use whitespace-pre-wrap to handle both HTML and Plain Text line breaks -->
                                    <div class="text-sm text-slate-500 line-clamp-2 whitespace-pre-wrap"
                                        v-html="t.content"></div>
                                    <div class="mt-2 flex items-center gap-2">
                                        <div
                                            class="px-3 py-1 bg-white border border-slate-100 rounded-full flex items-center gap-2 shadow-sm">
                                            <i class="fas fa-layer-group text-[10px] text-blue-500"></i>
                                            <span
                                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Urutan:
                                                {{ t.order }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-2 self-end md:self-start opacity-0 group-hover:opacity-100 transition-all duration-300 shrink-0">
                                <button @click="openTimelineModal(t)"
                                    class="w-11 h-11 rounded-xl bg-white border border-slate-100 text-amber-500 hover:bg-amber-50 hover:border-amber-200 transition-all shadow-sm flex items-center justify-center">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="confirmDelete(t.id)"
                                    class="w-11 h-11 rounded-xl bg-white border border-slate-100 text-rose-500 hover:bg-rose-50 hover:border-rose-200 transition-all shadow-sm flex items-center justify-center">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="timelines.length === 0"
                        class="text-center py-20 bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                        <i class="fas fa-history text-4xl text-slate-200 mb-4"></i>
                        <p class="text-slate-400 font-bold">Belum ada jejak peristiwa sejarah yang diabadikan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Timeline Entry -->
        <transition enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div v-if="timelineModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    @click="closeTimelineModal"></div>

                <!-- Modal Content -->
                <div
                    class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-100 z-10 hide-scrollbar">
                    <div class="p-8 sm:p-12">
                        <div class="mb-10 flex items-center justify-between">
                            <div>
                                <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                                    {{ editingTimeline ? 'Edit Peristiwa' : 'Tambah Peristiwa' }}
                                </h3>
                                <p class="text-slate-400 font-bold text-sm mt-1 uppercase tracking-widest text-[10px]">
                                    Detail Jejak Sejarah
                                </p>
                            </div>
                            <button @click="closeTimelineModal"
                                class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submitTimeline" class="space-y-8 font-bold">
                            <!-- Image Upload Removed per USER REQUEST -->

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-1"></i>
                                        Tahun / Periode
                                    </label>
                                    <input v-model="timelineForm.year" type="text"
                                        class="w-full bg-white border-2 border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-bold text-slate-800 placeholder:text-slate-400 transition-all"
                                        placeholder="Contoh: 1960 atau Era 1945-1950">
                                    <p v-if="timelineForm.errors.year" class="mt-1 text-rose-500 text-[10px] font-bold">
                                        {{ timelineForm.errors.year }}
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                        <i class="fas fa-sort-numeric-down text-blue-500 mr-1"></i>
                                        Urutan Tampil
                                    </label>
                                    <input v-model="timelineForm.order" type="number"
                                        class="w-full bg-white border-2 border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-bold text-slate-800 transition-all">
                                    <p v-if="timelineForm.errors.order"
                                        class="mt-1 text-rose-500 text-[10px] font-bold">{{
                                            timelineForm.errors.order }}</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <i class="fas fa-heading text-blue-500 mr-1"></i>
                                    Judul Peristiwa
                                </label>
                                <input v-model="timelineForm.title" type="text"
                                    class="w-full bg-white border-2 border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-bold text-slate-800 text-lg placeholder:text-slate-400 transition-all"
                                    placeholder="Contoh: Pembentukan Kantor Kelurahan Pertama">
                                <p v-if="timelineForm.errors.title" class="mt-1 text-rose-500 text-[10px] font-bold">{{
                                    timelineForm.errors.title }}</p>
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <i class="fas fa-align-left text-blue-500 mr-1"></i>
                                    Penjelasan Detail
                                </label>
                                <textarea v-model="timelineForm.content" rows="6"
                                    class="w-full bg-white border-2 border-slate-200 rounded-[2rem] px-8 py-6 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 font-bold text-slate-800 placeholder:text-slate-400 transition-all leading-relaxed resize-none"
                                    placeholder="Ceritakan dengan detail peristiwa sejarah ini..."></textarea>
                                <p v-if="timelineForm.errors.content" class="mt-1 text-rose-500 text-[10px] font-bold">
                                    {{ timelineForm.errors.content }}
                                </p>
                            </div>

                            <div class="pt-8 flex flex-col-reverse sm:flex-row gap-4">
                                <button type="button" @click="closeTimelineModal"
                                    class="flex-1 px-8 py-5 rounded-2xl bg-slate-100 text-slate-500 font-black text-xs hover:bg-slate-200 transition-all uppercase tracking-[0.2em]">
                                    Batal
                                </button>
                                <button type="submit" :disabled="timelineForm.processing"
                                    class="flex-[2] px-8 py-5 rounded-2xl bg-blue-600 text-white font-black text-xs hover:bg-blue-700 transition-all shadow-2xl shadow-blue-600/30 uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                                    <i v-if="timelineForm.processing" class="fas fa-circle-notch fa-spin"></i>
                                    <i v-else
                                        :class="editingTimeline ? 'fas fa-save' : 'fas fa-plus-circle text-lg'"></i>
                                    {{ editingTimeline ? 'Simpan Perubahan' : 'Terbitkan Peristiwa' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Modal Konfirmasi Hapus -->
        <transition enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div v-if="deleteModalOpen" class="fixed inset-0 z-[120] flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                    @click="closeDeleteModal"></div>

                <div
                    class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden border border-slate-100 z-10">
                    <div class="p-10 text-center">
                        <div
                            class="w-20 h-20 bg-rose-50 rounded-3xl flex items-center justify-center text-rose-500 mx-auto mb-6 shadow-lg shadow-rose-500/10 scale-110">
                            <i class="fas fa-trash-alt text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Hapus Timeline?</h3>
                        <p class="text-slate-500 font-bold text-sm leading-relaxed px-4">Tindakan ini permanen.
                            Peristiwa sejarah yang dihapus tidak dapat dipulihkan kembali.</p>

                        <div class="mt-10 flex flex-col gap-3">
                            <button @click="executeDelete" :disabled="deleteForm.processing"
                                class="w-full py-4 bg-rose-500 text-white rounded-2xl font-black text-xs hover:bg-rose-600 transition-all shadow-xl shadow-rose-500/20 uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                                <i v-if="deleteForm.processing" class="fas fa-circle-notch fa-spin"></i>
                                <span v-else>YA, HAPUS SEKARANG</span>
                            </button>
                            <button @click="closeDeleteModal"
                                class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs hover:bg-slate-200 transition-all uppercase tracking-[0.2em]">
                                BATALKAN
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
                class="fixed bottom-10 right-10 z-[130] p-6 bg-white border border-emerald-100 rounded-[2rem] flex items-center gap-5 shadow-2xl shadow-emerald-500/5">
                <div
                    class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-slate-900 font-black text-sm">Aksi Berhasil!</h5>
                    <p class="text-slate-500 text-xs font-bold mt-0.5">{{ notification.message }}</p>
                </div>
            </div>
        </transition>
    </AdminLayout>
</template>

<style>
/* CKEditor Fixed Styling for Intro */
.ck-body-wrapper {
    z-index: 10001 !important;
}

.ck.ck-balloon-panel {
    z-index: 10002 !important;
}

.editor-intro .ck-editor__editable_inline {
    min-height: 250px;
    background-color: #f8fafc !important;
    border: none !important;
    padding: 1.5rem 2.5rem !important;
    font-size: 0.95rem;
    font-weight: 600;
    color: #334155;
    line-height: 1.8;
}

.editor-intro .ck-toolbar {
    background-color: #ffffff !important;
    border: 1px solid #f1f5f9 !important;
    border-top-left-radius: 2rem !important;
    border-top-right-radius: 2rem !important;
    padding: 0.75rem 1.5rem !important;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
}

.editor-intro .ck.ck-editor__main>.ck-editor__editable {
    border-bottom-left-radius: 2rem !important;
    border-bottom-right-radius: 2rem !important;
}

.ck-focused {
    outline: none !important;
    border: none !important;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hide-scrollbar {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}

/* Textarea scrollbar styling */
textarea::-webkit-scrollbar {
    width: 6px;
}

textarea::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}

textarea::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
