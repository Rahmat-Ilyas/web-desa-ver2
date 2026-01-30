<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { ref } from 'vue';

const props = defineProps({
    settings: Object
});

// CKEditor Setup
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
    placeholder: 'Tuliskan gambaran umum wilayah di sini...'
};

const form = useForm({
    deskripsi: props.settings.deskripsi || '',
    umum: {
        luas_wilayah: props.settings.umum?.luas_wilayah || '',
        kecamatan: props.settings.umum?.kecamatan || '',
        kota: props.settings.umum?.kota || '',
        jumlah_lingkungan: props.settings.umum?.jumlah_lingkungan || '',
        rt: props.settings.umum?.rt || '',
        rw: props.settings.umum?.rw || '',
    },
    batas: {
        utara: props.settings.batas?.utara || '',
        timur: props.settings.batas?.timur || '',
        selatan: props.settings.batas?.selatan || '',
        barat: props.settings.batas?.barat || '',
    },
    lahan: props.settings.lahan?.length > 0 ? props.settings.lahan : [
        { label: 'PEMUKIMAN', percentage: 0, color: 'blue' },
        { label: 'FASILITAS UMUM & RTH', percentage: 0, color: 'emerald' },
        { label: 'PERDAGANGAN & JASA', percentage: 0, color: 'violet' },
    ],
    iklim: {
        suhu_min: props.settings.iklim?.suhu_min || '',
        suhu_max: props.settings.iklim?.suhu_max || '',
        iklim: props.settings.iklim?.iklim || '',
        curah_hujan: props.settings.iklim?.curah_hujan || '',
    }
});

// Notifications
const notification = ref({ show: false, message: '' });
const showNotification = (msg) => {
    notification.value.message = msg;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

const addLahan = () => {
    form.lahan.push({ label: '', percentage: 0, color: 'blue' });
};

const removeLahan = (index) => {
    form.lahan.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.kondisi.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification(`Kondisi ${props.settings?.sebutan_wilayah || 'Wilayah'} berhasil diperbarui`);
        }
    });
};
</script>

<template>

    <Head :title="`Kelola Kondisi ${$page.props.settings?.sebutan_wilayah || 'Kelurahan'}`" />

    <AdminLayout>
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 text-slate-700">
            <!-- Header (Matched with Sejarah Style) -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-map-marked-alt"></i> Profil Wilayah
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Kondisi {{
                        $page.props.settings?.sebutan_wilayah || 'Kelurahan' }}</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Atur profil geografis, demografis, dan tata guna
                        lahan {{ $page.props.settings?.sebutan_wilayah?.toLowerCase() || 'kelurahan' }}.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a :href="route('profil.kondisi')" target="_blank"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                        <i class="fas fa-external-link-alt"></i> LIHAT WEB
                    </a>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-10 pb-20">
                <!-- Deskripsi Narasi Section -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="mb-8 flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100">
                            <i class="fas fa-book-open text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-xl tracking-tight">Deskripsi & Narasi</h3>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-0.5">Gambaran
                                Umum Wilayah</p>
                        </div>
                    </div>

                    <div class="ck-content editor-kondisi">
                        <ckeditor :editor="editor" v-model="form.deskripsi" :config="editorConfig"></ckeditor>
                    </div>
                    <p v-if="form.errors.deskripsi" class="mt-4 text-rose-500 text-xs font-bold pl-1">{{
                        form.errors.deskripsi }}</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Statistik Wilayah -->
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                                <i class="fas fa-chart-pie text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-900 text-xl tracking-tight">Statistik Wilayah</h3>
                                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-0.5">Data
                                    Administratif</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 font-bold text-slate-700">
                            <div class="sm:col-span-2 space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Luas
                                    Wilayah</label>
                                <input v-model="form.umum.luas_wilayah" type="text"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold placeholder:text-slate-300"
                                    placeholder="± 0.45 Km²">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kecamatan</label>
                                <input v-model="form.umum.kecamatan" type="text"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kota</label>
                                <input v-model="form.umum.kota" type="text"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Lingkungan</label>
                                <input v-model="form.umum.jumlah_lingkungan" type="text"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-1 space-y-2">
                                    <label
                                        class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Total
                                        RT</label>
                                    <input v-model="form.umum.rt" type="text"
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                                </div>
                                <div class="flex-1 space-y-2">
                                    <label
                                        class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Total
                                        RW</label>
                                    <input v-model="form.umum.rw" type="text"
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Batas Wilayah -->
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 shadow-sm border border-orange-100">
                                <i class="fas fa-compass text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-900 text-xl tracking-tight">Batas Wilayah</h3>
                                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-0.5">
                                    Demarkasi Area</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div v-for="dir in ['utara', 'timur', 'selatan', 'barat']" :key="dir" class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Batas
                                    {{ dir }}</label>
                                <input v-model="form.batas[dir]" type="text"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold placeholder:text-slate-300"
                                    :placeholder="'Sisi ' + dir + ' berbatasan dengan...'">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Iklim Section -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="mb-8 flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 shadow-sm border border-sky-100">
                            <i class="fas fa-cloud-sun text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-xl tracking-tight">Iklim & Kondisi Alam</h3>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-0.5">
                                Karakteristik Lingkungan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 font-bold">
                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 text-center md:text-left">Suhu
                                Min (°C)</label>
                            <input v-model="form.iklim.suhu_min" type="number"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-center">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 text-center md:text-left">Suhu
                                Maks (°C)</label>
                            <input v-model="form.iklim.suhu_max" type="number"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-center">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Status
                                Iklim</label>
                            <input v-model="form.iklim.iklim" type="text"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold"
                                placeholder="Contoh: Tropis">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Keterangan
                                Curah Hujan</label>
                            <input v-model="form.iklim.curah_hujan" type="text"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold"
                                placeholder="Contoh: Musiman (Okt-Apr)">
                        </div>
                    </div>
                </div>

                <!-- Penggunaan Lahan -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                                <i class="fas fa-layer-group text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-slate-900 text-xl tracking-tight">Penggunaan Lahan</h3>
                                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-0.5">
                                    Distribusi Pemanfaatan</p>
                            </div>
                        </div>
                        <button @click="addLahan" type="button"
                            class="px-6 py-3 bg-emerald-600 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                            <i class="fas fa-plus"></i> TAMBAH KATEGORI
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div v-for="(item, index) in form.lahan" :key="index"
                            class="flex flex-wrap md:flex-nowrap items-end gap-6 p-8 rounded-[2rem] bg-slate-50/50 border border-slate-100 group transition-all hover:bg-white hover:shadow-xl hover:shadow-slate-900/5">
                            <div class="flex-1 min-w-[200px] space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kategori
                                    / Label Lahan</label>
                                <input v-model="item.label" type="text"
                                    class="w-full bg-white border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold"
                                    placeholder="PEMUKIMAN">
                            </div>
                            <div class="w-full md:w-32 space-y-2 text-center md:text-left">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Persen
                                    (%)</label>
                                <input v-model="item.percentage" type="number"
                                    class="w-full bg-white border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold text-center">
                            </div>
                            <div class="w-full md:w-48 space-y-2 text-center md:text-left">
                                <label
                                    class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Visual
                                    Warna</label>
                                <select v-model="item.color"
                                    class="w-full bg-white border-2 border-slate-100 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-bold">
                                    <option value="blue">Blue (Biru)</option>
                                    <option value="emerald">Emerald (Hijau)</option>
                                    <option value="rose">Rose (Merah)</option>
                                    <option value="violet">Violet (Ungu)</option>
                                    <option value="amber">Amber (Kuning)</option>
                                </select>
                            </div>
                            <button @click="removeLahan(index)" type="button"
                                class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm flex items-center justify-center shrink-0">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sticky Save Action Footer (Matched with Visi Misi Style) -->
                <div
                    class="mt-12 mb-20 p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-blue-900/5 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-50 group-hover:bg-blue-100/50 transition-colors rounded-full -mr-20 -mt-20 blur-3xl">
                    </div>

                    <div class="relative z-10">
                        <h4 class="font-black text-slate-900 text-lg">Siap mempublikasikan?</h4>
                        <p class="text-slate-500 font-bold text-sm">Pastikan seluruh data profil wilayah sudah sesuai
                            dan akurat.</p>
                    </div>

                    <div class="flex items-center gap-4 relative z-10 w-full md:w-auto">
                        <button type="submit" :disabled="form.processing"
                            class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/30 disabled:opacity-50 flex items-center justify-center gap-3 active:scale-95 group/btn">
                            <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            SIMPAN SEMUA PERUBAHAN
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Success Notification Popover -->
        <transition enter-active-class="transform transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-10 z-[130] p-6 bg-white border border-emerald-100 rounded-[2rem] flex items-center gap-5 shadow-2xl shadow-emerald-500/10">
                <div
                    class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-slate-900 font-black text-sm leading-none">Aksi Berhasil!</h5>
                    <p class="text-slate-500 text-xs font-bold mt-1.5 opacity-80">{{ notification.message }}</p>
                </div>
            </div>
        </transition>
    </AdminLayout>
</template>

<style>
.editor-kondisi .ck-editor__editable_inline {
    min-height: 300px;
    background-color: #f8fafc !important;
    border: none !important;
    padding: 2rem 3rem !important;
    font-size: 1rem;
    font-weight: 500;
    color: #334155;
    line-height: 1.8;
}

.editor-kondisi .ck-toolbar {
    background-color: #ffffff !important;
    border: 1px solid #f1f5f9 !important;
    border-top-left-radius: 2rem !important;
    border-top-right-radius: 2rem !important;
    padding: 0.75rem 1.5rem !important;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
}

.editor-kondisi .ck.ck-editor__main>.ck-editor__editable {
    border-bottom-left-radius: 2rem !important;
    border-bottom-right-radius: 2rem !important;
}

.ck-focused {
    outline: none !important;
    border: none !important;
}
</style>
