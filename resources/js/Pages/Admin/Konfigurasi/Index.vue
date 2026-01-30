<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    settings: Object
});

const page = usePage();
const activeTab = ref('tampilan');
const notification = ref({ show: false, message: '', type: 'success' });
const confirmModal = ref({ show: false, title: '', message: '', action: null });
const sliderPreviews = ref([]);
const logoPreview = ref(null);

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
}, { immediate: true });

watch(() => page.props.flash?.error, (msg) => {
    if (msg) showNotification(msg, 'error');
}, { immediate: true });

// Form Identitas Umum
const generalForm = useForm({
    web_name: props.settings.web_name || '',
    web_description: props.settings.web_description || '',
    web_keywords: props.settings.web_keywords || '',
    sebutan_wilayah: props.settings.sebutan_wilayah || 'Kelurahan',
    nama_wilayah: props.settings.nama_wilayah || '',
    sebutan_kepala: props.settings.sebutan_kepala || 'Lurah',
    nama_kabupaten: props.settings.nama_kabupaten || '',
    logo: null,
    reset_logo: false,
});

// Form Modul / Fitur
const modulesForm = useForm({
    // Modul Utama
    modul_galeri: props.settings.module_status?.modul_galeri ?? true,
    modul_download: props.settings.module_status?.modul_download ?? true,
    modul_layanan: props.settings.module_status?.modul_layanan ?? true,
    modul_pengaduan: props.settings.module_status?.modul_pengaduan ?? true,

    // Profil
    modul_profil_sambutan: props.settings.module_status?.modul_profil_sambutan ?? true,
    modul_profil_visimisi: props.settings.module_status?.modul_profil_visimisi ?? true,
    modul_profil_sejarah: props.settings.module_status?.modul_profil_sejarah ?? true,
    modul_profil_kondisi: props.settings.module_status?.modul_profil_kondisi ?? true,
    modul_profil_lokasi: props.settings.module_status?.modul_profil_lokasi ?? true,
    modul_profil_peta: props.settings.module_status?.modul_profil_peta ?? true,

    // Lembaga
    modul_lembaga_rt_rw: props.settings.module_status?.modul_lembaga_rt_rw ?? true,
    modul_lembaga_pkk: props.settings.module_status?.modul_lembaga_pkk ?? true,
    modul_lembaga_karang_taruna: props.settings.module_status?.modul_lembaga_karang_taruna ?? true,
    modul_lembaga_lpmk: props.settings.module_status?.modul_lembaga_lpmk ?? true,
    modul_lembaga_majelis_taklim: props.settings.module_status?.modul_lembaga_majelis_taklim ?? true,

    // Data (Statistik)
    modul_data_penduduk: props.settings.module_status?.modul_data_penduduk ?? (props.settings.module_status?.modul_statistik ?? true),
    modul_data_umur: props.settings.module_status?.modul_data_umur ?? (props.settings.module_status?.modul_statistik ?? true),
    modul_data_agama: props.settings.module_status?.modul_data_agama ?? (props.settings.module_status?.modul_statistik ?? true),
    modul_data_pendidikan: props.settings.module_status?.modul_data_pendidikan ?? (props.settings.module_status?.modul_statistik ?? true),
    modul_data_pemilih: props.settings.module_status?.modul_data_pemilih ?? (props.settings.module_status?.modul_statistik ?? true),

    // Pemerintahan
    modul_pemerintahan_aparatur: props.settings.module_status?.modul_pemerintahan_aparatur ?? true,
    modul_pemerintahan_anggaran: props.settings.module_status?.modul_pemerintahan_anggaran ?? true,

    // Informasi
    modul_berita: props.settings.module_status?.modul_berita ?? true,
    modul_potensi: props.settings.module_status?.modul_potensi ?? true,
    modul_program: props.settings.module_status?.modul_program ?? true,
});

// Form Tampilan & Konten
const appearanceForm = useForm({
    hero_title: props.settings.hero_title || 'Pelayanan Profesional & Inovatif',
    hero_subtitle: props.settings.hero_subtitle || 'Mewujudkan Masyarakat Peduli',
    hero_description: props.settings.hero_description || 'Pusat informasi terkini dan layanan administrasi terpadu untuk warga masyarakat.',
    hero_bg_type: props.settings.hero_bg_type || 'video',
    hero_video: null,
    hero_slider: [],
    cover_pkk: null,
    cover_karang_taruna: null,
    cover_majelis_taklim: null,
    reset_bg: false,
    reset_covers: false,
});

const submitGeneral = () => {
    generalForm.post(route('admin.konfigurasi.update'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            showNotification('Konfigurasi umum berhasil diperbarui');
            generalForm.logo = null;
            generalForm.reset_logo = false;
            if (logoPreview.value) {
                URL.revokeObjectURL(logoPreview.value);
                logoPreview.value = null;
            }
        },
    });
};

const submitModules = () => {
    modulesForm.post(route('admin.konfigurasi.modules.update'), {
        preserveScroll: true,
        onSuccess: () => showNotification('Konfigurasi modul berhasil diperbarui'),
    });
};

const submitAppearance = () => {
    appearanceForm.post(route('admin.konfigurasi.appearance.update'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            showNotification('Pengaturan tampilan berhasil diperbarui');
            appearanceForm.hero_video = null;
            appearanceForm.hero_slider = [];
            appearanceForm.cover_pkk = null;
            appearanceForm.cover_karang_taruna = null;
            appearanceForm.cover_majelis_taklim = null;
            appearanceForm.reset_bg = false;
            appearanceForm.reset_covers = false;
            sliderPreviews.value.forEach(url => URL.revokeObjectURL(url));
            sliderPreviews.value = [];
            closeConfirm();
        },
        onError: (errors) => {
            console.error(errors);
            showNotification('Gagal memperbarui pengaturan. Periksa kembali inputan Anda.', 'error');
        }
    });
};

const openConfirm = (title, message, action) => {
    confirmModal.value = { show: true, title, message, action };
};

const closeConfirm = () => {
    confirmModal.value.show = false;
};

const resetHeroBg = () => {
    openConfirm(
        'Reset Latar Belakang?',
        'Tindakan ini akan menghapus semua kustomisasi latar belakang dan mengembalikannya ke video default. Lanjutkan?',
        () => {
            appearanceForm.reset_bg = true;
            submitAppearance();
        }
    );
};

const resetLogo = () => {
    openConfirm(
        'Reset Logo?',
        'Tindakan ini akan menghapus semua kustomisasi logo dan mengembalikannya ke logo default sistem. Lanjutkan?',
        () => {
            generalForm.reset_logo = true;
            submitGeneral();
        }
    );
};

const resetCovers = () => {
    openConfirm(
        'Reset Gambar Sampul?',
        'Tindakan ini akan mengembalikan semua gambar sampul lembaga ke desain default sistem. Lanjutkan?',
        () => {
            appearanceForm.reset_covers = true;
            submitAppearance();
        }
    );
};

const tabs = [
    { id: 'tampilan', name: 'Konten & Tampilan', icon: 'fas fa-paint-brush' },
    { id: 'umum', name: 'Identitas Web', icon: 'fas fa-id-card' },
    { id: 'modul', name: 'Modul / Fitur', icon: 'fas fa-cubes' },
];

const handleLogoUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        generalForm.logo = file;
        if (logoPreview.value) URL.revokeObjectURL(logoPreview.value);
        logoPreview.value = URL.createObjectURL(file);
    }
};

const handleFiles = (e, field) => {
    if (field === 'hero_slider') {
        const files = Array.from(e.target.files);
        appearanceForm.hero_slider = [...appearanceForm.hero_slider, ...files];
        files.forEach(file => {
            sliderPreviews.value.push(URL.createObjectURL(file));
        });
    } else {
        appearanceForm[field] = e.target.files[0];
    }
};

const removeSliderFile = (index) => {
    appearanceForm.hero_slider.splice(index, 1);
    URL.revokeObjectURL(sliderPreviews.value[index]);
    sliderPreviews.value.splice(index, 1);
};

</script>

<template>
    <AdminLayout>

        <Head title="Konfigurasi Website" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 mb-20">
            <!-- Header Section -->
            <div class="mb-10 group">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100 shadow-sm">
                    <i class="fas fa-cogs"></i> Pengaturan Sistem
                </span>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none mb-3">Konfigurasi Website</h1>
                <p class="text-slate-500 font-bold text-sm max-w-2xl">
                    Kelola identitas dasar, tampilan beranda, dan aktifkan atau nonaktifkan fitur website sesuai
                    kebutuhan operasional {{ $page.props.settings?.sebutan_wilayah?.toLowerCase() || 'kelurahan' }}.
                </p>
            </div>

            <!-- Tabs Navigation -->
            <div
                class="flex flex-wrap gap-2 p-2 bg-slate-100/50 backdrop-blur-sm rounded-[2rem] border border-slate-200/60 mb-8 w-fit">
                <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id" :class="[
                    'px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 flex items-center gap-3',
                    activeTab === tab.id
                        ? 'bg-white text-blue-600 shadow-xl shadow-blue-500/10 border border-blue-100'
                        : 'text-slate-400 hover:text-slate-600 hover:bg-white/50'
                ]">
                    <i :class="tab.icon"></i>
                    {{ tab.name }}
                </button>
            </div>

            <!-- Tab Content: Identitas Umum -->
            <div v-if="activeTab === 'umum'" class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <form @submit.prevent="submitGeneral" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-blue-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 relative z-10">
                            <span
                                class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            Identitas Dasar
                        </h2>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Judul
                                    Website (Web Name)</label>
                                <input v-model="generalForm.web_name" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="Nama yang muncul di tab browser">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Nama
                                    Kabupaten / Kota</label>
                                <input v-model="generalForm.nama_kabupaten" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="E.g. Parepare">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Nama
                                    Wilayah</label>
                                <input v-model="generalForm.nama_wilayah" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="Nama Wilayah">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Sebutan
                                        Wilayah</label>
                                    <input v-model="generalForm.sebutan_wilayah" type="text"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="E.g. Kelurahan / Desa">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Sebutan
                                        Kepala</label>
                                    <input v-model="generalForm.sebutan_kepala" type="text"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="E.g. Lurah / Kepala Desa">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-emerald-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 relative z-10">
                            <span
                                class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-search"></i>
                            </span>
                            Optimasi SEO
                        </h2>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Deskripsi
                                    Website</label>
                                <textarea v-model="generalForm.web_description" rows="3"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="Bagaimana Google melihat website Anda..."></textarea>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Keywords
                                    (Pisahkan dengan koma)</label>
                                <input v-model="generalForm.web_keywords" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="E.g. pelayanan, kelurahan, digital">
                            </div>

                            <div
                                class="bg-slate-50/50 rounded-3xl p-8 border-2 border-dashed border-slate-200 group/upload relative transition-all duration-300 hover:border-emerald-200 hover:bg-emerald-50/30">
                                <div class="flex flex-col md:flex-row items-center gap-8">
                                    <!-- Preview Area -->
                                    <div class="relative flex-shrink-0">
                                        <div
                                            class="w-32 h-32 bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border-4 border-white flex items-center justify-center p-4 overflow-hidden relative group/avatar">
                                            <img v-if="logoPreview || props.settings.logo"
                                                :src="logoPreview || props.settings.logo"
                                                class="max-w-full max-h-full object-contain transform transition-transform duration-500 group-hover/avatar:scale-110">
                                            <div v-else class="flex flex-col items-center gap-2 text-slate-300">
                                                <i class="fas fa-image text-3xl"></i>
                                                <span class="text-[8px] font-black uppercase tracking-tighter">No
                                                    Preview</span>
                                            </div>

                                            <!-- Animated Overlay on Hover -->
                                            <div
                                                class="absolute inset-0 bg-emerald-600/60 opacity-0 group-hover/avatar:opacity-100 transition-all duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                                <div
                                                    class="flex flex-col items-center text-white scale-75 group-hover/avatar:scale-100 transition-transform duration-300">
                                                    <i class="fas fa-cloud-upload-alt text-2xl mb-1"></i>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">Ubah
                                                        Logo</span>
                                                </div>
                                            </div>

                                            <input type="file" @change="handleLogoUpload" accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        </div>

                                        <!-- Reset Pulse Button -->
                                        <button v-if="props.settings.logo" @click="resetLogo" type="button"
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-rose-500/30 border-2 border-white hover:bg-rose-600 hover:scale-110 active:scale-95 transition-all z-20 group/reset">
                                            <i
                                                class="fas fa-undo text-xs transition-transform group-hover/reset:-rotate-180 duration-500"></i>
                                        </button>
                                    </div>

                                    <!-- Info & Instructions -->
                                    <div class="flex-grow text-center md:text-left space-y-4">
                                        <div>
                                            <h4
                                                class="text-sm font-black text-slate-800 uppercase tracking-widest mb-1">
                                                Logo & Favicon Website</h4>
                                            <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-sm">
                                                Gunakan gambar transparan (PNG) untuk hasil terbaik. File ini akan
                                                digunakan sebagai logo utama dan ikon pada tab browser.
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                            <div
                                                class="px-4 py-2 bg-white rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">
                                                <i class="fas fa-expand text-emerald-500 text-xs"></i>
                                                <span
                                                    class="text-[10px] font-black text-slate-600 uppercase tracking-tight">Format
                                                    PNG/JPG</span>
                                            </div>
                                            <div
                                                class="px-4 py-2 bg-white rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">
                                                <i class="fas fa-hdd text-emerald-500 text-xs"></i>
                                                <span
                                                    class="text-[10px] font-black text-slate-600 uppercase tracking-tight">Maks
                                                    2MB</span>
                                            </div>
                                        </div>

                                        <div v-if="generalForm.errors.logo"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 rounded-xl border border-rose-100 text-rose-500 animate-bounce">
                                            <i class="fas fa-exclamation-triangle text-xs"></i>
                                            <span class="text-[10px] font-black uppercase tracking-tight">{{
                                                generalForm.errors.logo }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 flex justify-end">
                        <button type="submit" :disabled="generalForm.processing"
                            class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50 flex items-center gap-3 active:scale-95">
                            <i v-if="generalForm.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Simpan Perubahan Identitas
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Tampilan & Konten -->
            <div v-if="activeTab === 'tampilan'"
                class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <form @submit.prevent="submitAppearance" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Hero Content -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-amber-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 relative z-10">
                            <span
                                class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                                <i class="fas fa-heading"></i>
                            </span>
                            Konten Header (Hero)
                        </h2>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Judul
                                    Utama (Max 100 Karakter)</label>
                                <input v-model="appearanceForm.hero_title" maxlength="100" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-amber-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="E.g. Pelayanan Profesional & Inovatif">
                                <p class="text-[10px] text-slate-400 mt-1 ml-3 font-bold">{{
                                    appearanceForm.hero_title.length }}/100 Karakter</p>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Sub
                                    Judul (Max 150 Karakter)</label>
                                <input v-model="appearanceForm.hero_subtitle" maxlength="150" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-amber-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="E.g. Mewujudkan Masyarakat Peduli">
                                <p class="text-[10px] text-slate-400 mt-1 ml-3 font-bold">{{
                                    appearanceForm.hero_subtitle.length }}/150 Karakter</p>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Deskripsi
                                    Singkat (Max 255 Karakter)</label>
                                <textarea v-model="appearanceForm.hero_description" maxlength="255" rows="3"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-amber-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="Selamat datang di platform digital..."></textarea>
                                <p class="text-[10px] text-slate-400 mt-1 ml-3 font-bold">{{
                                    appearanceForm.hero_description.length }}/255 Karakter</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Background -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <div class="flex items-center justify-between mb-8 relative z-10">
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-4">
                                <span
                                    class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                    <i class="fas fa-image"></i>
                                </span>
                                Latar Belakang Header
                            </h2>
                            <button @click="resetHeroBg" type="button"
                                class="text-[10px] font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest flex items-center gap-2 transition-colors">
                                <i class="fas fa-undo"></i> Reset Default
                            </button>
                        </div>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Tipe
                                    Background</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" @click="appearanceForm.hero_bg_type = 'video'"
                                        :class="[appearanceForm.hero_bg_type === 'video' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100', 'py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300']">
                                        <i class="fas fa-video mr-2"></i> Video
                                    </button>
                                    <button type="button" @click="appearanceForm.hero_bg_type = 'slider'"
                                        :class="[appearanceForm.hero_bg_type === 'slider' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100', 'py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300']">
                                        <i class="fas fa-images mr-2"></i> Slider Foto
                                    </button>
                                </div>
                                <p v-if="appearanceForm.errors.hero_bg_type"
                                    class="text-xs text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.hero_bg_type }}</p>
                            </div>

                            <div v-if="appearanceForm.hero_bg_type === 'video'">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Upload
                                    Video (MP4/WebM, Max 20MB)</label>
                                <input type="file" @change="handleFiles($event, 'hero_video')" accept="video/*"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-indigo-500 rounded-2xl font-bold text-slate-700 outline-none transition-all cursor-pointer">
                                <p v-if="appearanceForm.errors.hero_video"
                                    class="text-xs text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.hero_video }}</p>
                                <p v-if="settings.hero_video"
                                    class="text-[10px] text-indigo-500 mt-2 ml-3 font-bold flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Video saat ini aktif: {{
                                        settings.hero_video.split('/').pop() }}
                                </p>
                            </div>

                            <div v-if="appearanceForm.hero_bg_type === 'slider'">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Kelola
                                    Foto Slider (Format Foto, Max 2MB/Foto)</label>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                                    <!-- Selected Previews -->
                                    <div v-for="(file, idx) in appearanceForm.hero_slider" :key="idx"
                                        class="relative aspect-[4/3] rounded-2xl overflow-hidden border-2 border-indigo-200 shadow-sm group">
                                        <img :src="sliderPreviews[idx]" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button @click="removeSliderFile(idx)" type="button"
                                                class="w-10 h-10 bg-rose-500 text-white rounded-xl shadow-lg hover:scale-110 active:scale-95 transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <div class="absolute bottom-2 left-2 right-2 flex justify-center">
                                            <span
                                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm rounded-md text-[8px] font-black text-indigo-600 truncate">{{
                                                    file.name }}</span>
                                        </div>
                                    </div>

                                    <!-- Add Button -->
                                    <label
                                        class="aspect-[4/3] rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-500 hover:bg-indigo-50 flex flex-col items-center justify-center cursor-pointer transition-all group">
                                        <input type="file" @change="handleFiles($event, 'hero_slider')" multiple
                                            accept="image/*" class="hidden">
                                        <i
                                            class="fas fa-plus text-slate-300 group-hover:text-indigo-500 text-xl mb-2"></i>
                                        <span
                                            class="text-[9px] font-black text-slate-400 group-hover:text-indigo-600 uppercase">Tambah
                                            Foto</span>
                                    </label>
                                </div>
                                <p v-if="appearanceForm.errors.hero_slider"
                                    class="text-xs text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.hero_slider }}</p>
                                <p v-if="appearanceForm.errors['hero_slider.0']"
                                    class="text-xs text-rose-500 mt-2 ml-3 font-bold">Beberapa foto melebihi batas
                                    ukuran atau format tidak valid.</p>

                                <div v-if="settings.hero_slider?.length"
                                    class="mt-8 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                    <p
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <i class="fas fa-images text-indigo-500"></i> Slider Saat Ini yang Aktif
                                    </p>
                                    <div class="flex flex-wrap gap-3">
                                        <div v-for="(img, idx) in settings.hero_slider" :key="idx"
                                            class="w-24 h-16 rounded-xl bg-cover bg-center border-2 border-white shadow-sm ring-1 ring-slate-100"
                                            :style="{ backgroundImage: `url(${img})` }"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lembaga Covers -->
                    <div
                        class="lg:col-span-2 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-rose-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <div class="flex items-center justify-between mb-8 relative z-10">
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-4">
                                <span
                                    class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/20">
                                    <i class="fas fa-images"></i>
                                </span>
                                Foto Ilustrasi Profil Lembaga
                            </h2>
                            <button @click="resetCovers" type="button"
                                class="text-[10px] font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest flex items-center gap-2 transition-colors">
                                <i class="fas fa-undo"></i> Reset Default
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto
                                    Profil PKK</label>
                                <div v-if="settings.cover_pkk"
                                    class="w-full h-32 rounded-2xl bg-cover bg-center mb-3 shadow-sm"
                                    :style="{ backgroundImage: `url(${settings.cover_pkk})` }"></div>
                                <input type="file" @change="handleFiles($event, 'cover_pkk')" accept="image/*"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-rose-500 rounded-xl text-xs font-bold text-slate-500 cursor-pointer transition-all">
                                <p v-if="appearanceForm.errors.cover_pkk"
                                    class="text-[9px] text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.cover_pkk }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto
                                    Profil Karang Taruna</label>
                                <div v-if="settings.cover_karang_taruna"
                                    class="w-full h-32 rounded-2xl bg-cover bg-center mb-3 shadow-sm"
                                    :style="{ backgroundImage: `url(${settings.cover_karang_taruna})` }"></div>
                                <input type="file" @change="handleFiles($event, 'cover_karang_taruna')" accept="image/*"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-rose-500 rounded-xl text-xs font-bold text-slate-500 cursor-pointer transition-all">
                                <p v-if="appearanceForm.errors.cover_karang_taruna"
                                    class="text-[9px] text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.cover_karang_taruna }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Foto
                                    Profil Majelis Taklim</label>
                                <div v-if="settings.cover_majelis_taklim"
                                    class="w-full h-32 rounded-2xl bg-cover bg-center mb-3 shadow-sm"
                                    :style="{ backgroundImage: `url(${settings.cover_majelis_taklim})` }"></div>
                                <input type="file" @change="handleFiles($event, 'cover_majelis_taklim')"
                                    accept="image/*"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-rose-500 rounded-xl text-xs font-bold text-slate-500 cursor-pointer transition-all">
                                <p v-if="appearanceForm.errors.cover_majelis_taklim"
                                    class="text-[9px] text-rose-500 mt-2 ml-3 font-bold">{{
                                        appearanceForm.errors.cover_majelis_taklim }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 flex justify-end">
                        <button type="submit" :disabled="appearanceForm.processing"
                            class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50 flex items-center gap-3 active:scale-95">
                            <i v-if="appearanceForm.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Terapkan Pengaturan Visual
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Modul / Fitur -->
            <div v-if="activeTab === 'modul'" class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <form @submit.prevent="submitModules">
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-rose-50 rounded-bl-[5rem] -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-4 relative z-10">
                            <span
                                class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/20">
                                <i class="fas fa-toggle-on"></i>
                            </span>
                            Visibilitas Modul & Fitur
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <!-- Galeri -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-amber-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-images"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Modul Galeri</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Foto & Video Kegiatan</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_galeri" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-amber-500 focus:ring-amber-500 transition-all">
                            </label>

                            <!-- Layanan -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-emerald-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-concierge-bell"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Modul Layanan</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Pelayanan Publik</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_layanan" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500 transition-all">
                            </label>

                            <!-- Pengaduan -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-rose-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Pengaduan</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Laporan Warga Online</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_pengaduan" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-rose-600 focus:ring-rose-500 transition-all">
                            </label>

                            <!-- Download -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-slate-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Modul Download</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Dokumen & Regulasi</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_download" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-slate-600 focus:ring-slate-500 transition-all">
                            </label>
                        </div>

                        <!-- Profil Section -->
                        <div class="mt-12 mb-6 h-px bg-slate-100 w-full relative z-10"></div>
                        <h3
                            class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-3">
                            <i class="fas fa-landmark text-xs"></i> Pemerintahan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <!-- Aparatur -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-users-gear"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Aparatur</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Struktur Organisasi</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_pemerintahan_aparatur" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>

                            <!-- Anggaran -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Anggaran</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Transparansi Anggaran</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_pemerintahan_anggaran" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                        </div>

                        <div class="mt-12 mb-6 h-px bg-slate-100 w-full relative z-10"></div>
                        <h3
                            class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-3">
                            <i class="fas fa-id-card text-xs"></i> Profil Wilayah
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Sambutan</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_sambutan" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Visi & Misi</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_visimisi" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Sejarah</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_sejarah" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Kondisi Wilayah</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_kondisi" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Lokasi Kantor</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_lokasi" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-map"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Peta Lokasi</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_profil_peta" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                        </div>

                        <!-- Data Section -->
                        <div class="mt-12 mb-6 h-px bg-slate-100 w-full relative z-10"></div>
                        <h3
                            class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-3">
                            <i class="fas fa-chart-pie text-xs"></i> Data & Statistik
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Statistik Penduduk</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_data_penduduk" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-user-clock"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Berdasarkan Umur</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_data_umur" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-praying-hands"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Statistik Agama</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_data_agama" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Statistik Pendidikan</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_data_pendidikan" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-vote-yea"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Pemilih Tetap</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_data_pemilih" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>
                        </div>

                        <!-- Informasi Section -->
                        <div class="mt-12 mb-6 h-px bg-slate-100 w-full relative z-10"></div>
                        <h3
                            class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-3">
                            <i class="fas fa-bullhorn text-xs"></i> Informasi Publik
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <!-- Berita -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Modul Berita</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Informasi & Artikel</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_berita" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>

                            <!-- Potensi -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-tree"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Potensi</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Potensi Wilayah</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_potensi" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>

                            <!-- Program -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Program</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Program Kerja</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_program" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>
                        </div>


                        <div class="mt-12 mb-6 h-px bg-slate-100 w-full relative z-10"></div>
                        <h3
                            class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-3">
                            <i class="fas fa-sitemap text-xs"></i> Lembaga {{ $page.props.settings?.sebutan_wilayah ||
                                'Kelurahan' }}
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                            <!-- RT RW -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-blue-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">RT & RW</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Rukun Tetangga/Warga</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_lembaga_rt_rw" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            </label>

                            <!-- PKK -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-rose-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-female"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">P.K.K</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Pemberdayaan Wanita</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_lembaga_pkk" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-rose-600 focus:ring-rose-500 transition-all">
                            </label>

                            <!-- Karang Taruna -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Karang Taruna</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Organisasi Kepemudaan</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_lembaga_karang_taruna" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                            </label>

                            <!-- LPMK -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-amber-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-building-user"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">L.P.M.K</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Pemberdayaan Masyarakat</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_lembaga_lpmk" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-amber-600 focus:ring-amber-500 transition-all">
                            </label>

                            <!-- Majelis Taklim -->
                            <label
                                class="relative flex items-center justify-between p-6 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-emerald-500/30 cursor-pointer transition-all group/item">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover/item:scale-110 transition-transform">
                                        <i class="fas fa-mosque"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-sm">Majelis Taklim</p>
                                        <p class="text-[10px] text-slate-400 font-bold">Organisasi Keagamaan</p>
                                    </div>
                                </div>
                                <input v-model="modulesForm.modul_lembaga_majelis_taklim" type="checkbox"
                                    class="w-6 h-6 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500 transition-all">
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" :disabled="modulesForm.processing"
                            class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 disabled:opacity-50 flex items-center gap-3 active:scale-95">
                            <i v-if="modulesForm.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Terapkan Konfigurasi Modul
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Custom Confirmation Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="confirmModal.show" class="fixed inset-0 z-[200] flex items-center justify-center px-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeConfirm"></div>

                <div
                    class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-md p-10 overflow-hidden animate-in zoom-in duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -mr-10 -mt-10"></div>

                    <div class="relative z-10 text-center">
                        <div
                            class="w-20 h-20 bg-rose-100 text-rose-500 rounded-[2rem] flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>

                        <h3 class="text-2xl font-black text-slate-900 mb-4 uppercase tracking-tight">{{
                            confirmModal.title }}</h3>
                        <p class="text-slate-500 font-bold text-sm mb-10 leading-relaxed">{{ confirmModal.message }}</p>

                        <div class="flex gap-4">
                            <button @click="closeConfirm"
                                class="flex-1 px-6 py-4 rounded-2xl bg-slate-100 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Batal
                            </button>
                            <button @click="confirmModal.action"
                                class="flex-1 px-6 py-4 rounded-2xl bg-rose-500 text-white font-black text-xs uppercase tracking-widest hover:bg-rose-600 shadow-xl shadow-rose-500/20 transition-all active:scale-95">
                                Ya, Lanjutkan
                            </button>
                        </div>
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
                class="fixed bottom-10 right-10 z-[120] p-4 bg-white border border-slate-100 rounded-3xl flex items-center gap-4 shadow-2xl min-w-[300px]">
                <div :class="[
                    'w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg transition-colors',
                    notification.type === 'error' ? 'bg-rose-500 shadow-rose-500/20' : 'bg-emerald-500 shadow-emerald-500/20'
                ]">
                    <i :class="['fas', notification.type === 'error' ? 'fa-exclamation-circle' : 'fa-check']"></i>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-sm uppercase tracking-tight">
                        {{ notification.type === 'error' ? 'Gagal!' : 'Berhasil!' }}
                    </p>
                    <p class="text-slate-500 text-xs font-bold">{{ notification.message }}</p>
                </div>
            </div>
        </transition>
    </AdminLayout>
</template>

<style scoped>
.animate-in {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slide-in-from-bottom-4 {
    from {
        transform: translateY(1rem);
    }

    to {
        transform: translateY(0);
    }
}

.fade-in {
    animation-name: fade-in;
}

.slide-in-from-bottom-4 {
    animation-name: slide-in-from-bottom-4;
}

@keyframes bounce-slow {

    0%,
    100% {
        transform: translateY(-5%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }

    50% {
        transform: none;
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 2s infinite;
}
</style>
