<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    settings: Object,
});

// Notification state
const notification = ref({ show: false, message: '', type: 'success' });
const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

// Flash messages
const page = usePage();
watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
});

const statsForm = useForm({
    statistik_umum: props.settings?.statistik_umum || [
        { label: 'Total Penduduk', value: '4250', unit: 'Jiwa', icon: 'fa-users', color: 'blue' },
        { label: 'Laki-laki', value: '2100', unit: 'Jiwa', icon: 'fa-male', color: 'indigo' },
        { label: 'Perempuan', value: '2150', unit: 'Jiwa', icon: 'fa-female', color: 'pink' },
    ],
    statistik_agama: props.settings?.statistik_agama || [
        { label: 'Islam', value: '4150', color: 'bg-emerald-600', icon: 'fa-mosque' },
        { label: 'Kristen Protestan', value: '65', color: 'bg-blue-600', icon: 'fa-church' },
        { label: 'Katolik', value: '25', color: 'bg-indigo-600', icon: 'fa-cross' },
        { label: 'Hindu / Budha / Lainnya', value: '10', color: 'bg-orange-500', icon: 'fa-om' },
    ],
    statistik_pendidikan: props.settings?.statistik_pendidikan || [
        { label: 'Tidak/Belum Sekolah', value: '850', color: 'bg-emerald-500' },
        { label: 'SD / Sederajat', value: '1200', color: 'bg-blue-500' },
        { label: 'SMP / Sederajat', value: '750', color: 'bg-indigo-500' },
        { label: 'SMA / Sederajat', value: '980', color: 'bg-violet-500' },
        { label: 'Diploma / Sarjana (S1)', value: '420', color: 'bg-purple-500' },
        { label: 'Pascasarjana (S2/S3)', value: '50', color: 'bg-pink-500' },
    ],
    statistik_umur: props.settings?.statistik_umur || [
        { label: '0 - 5 Tahun (Balita)', value: '350', color: 'bg-rose-500' },
        { label: '6 - 12 Tahun (Anak)', value: '480', color: 'bg-orange-500' },
        { label: '13 - 17 Tahun (Remaja)', value: '420', color: 'bg-yellow-500' },
        { label: '18 - 40 Tahun (Pemuda)', value: '1450', color: 'bg-green-500' },
        { label: '41 - 60 Tahun (Dewasa)', value: '1150', color: 'bg-blue-500' },
        { label: '60+ Tahun (Lansia)', value: '400', color: 'bg-purple-500' },
    ],
    statistik_pemilih: props.settings?.statistik_pemilih || {
        total: '2990',
        laki: '1450',
        perempuan: '1540'
    }
});

// Helpers for numeric only input
const onlyNumber = (event) => {
    const charCode = event.which ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
};

const parseNum = (val) => {
    if (val === null || val === undefined) return 0;
    const clean = val.toString().replace(/\D/g, '');
    return parseInt(clean) || 0;
};

const findVal = (label) => {
    const item = statsForm.statistik_umum.find(s => s.label.trim().toLowerCase() === label.trim().toLowerCase());
    return item ? item.value : '0';
};

// Validation Computed Properties
const lakiJiwa = computed(() => parseNum(findVal('Laki-laki')));
const prJiwa = computed(() => parseNum(findVal('Perempuan')));
const sumGender = computed(() => lakiJiwa.value + prJiwa.value);

const sumAgama = computed(() => statsForm.statistik_agama.reduce((sum, item) => sum + parseNum(item.value), 0));
const sumPendidikan = computed(() => statsForm.statistik_pendidikan.reduce((sum, item) => sum + parseNum(item.value), 0));
const sumUmur = computed(() => statsForm.statistik_umur.reduce((sum, item) => sum + parseNum(item.value), 0));

const dptTotal = computed(() => parseNum(statsForm.statistik_pemilih.total));
const dptLaki = computed(() => parseNum(statsForm.statistik_pemilih.laki));
const dptPr = computed(() => parseNum(statsForm.statistik_pemilih.perempuan));
const sumDptGender = computed(() => dptLaki.value + dptPr.value);

// Compute Live Percentage for visual feedback
const totalPenduduk = computed(() => {
    const val = findVal('Total Penduduk');
    return parseNum(val) || 1;
});

const calculatePercent = (val) => {
    const num = parseNum(val);
    return ((num / totalPenduduk.value) * 100).toFixed(1);
};

// Live Validation Errors
const errors = computed(() => {
    const errs = {};
    const total = totalPenduduk.value;

    // 1. Gender Validation
    if (sumGender.value > total) {
        errs.gender = `Total Laki-laki & Perempuan (${sumGender.value}) melebihi Total Penduduk (${total})`;
    }

    // 2. Agama Validation
    if (sumAgama.value > total) {
        errs.agama = `Total data Agama (${sumAgama.value}) melebihi Total Penduduk (${total})`;
    }

    // 3. Pendidikan Validation
    if (sumPendidikan.value > total) {
        errs.pendidikan = `Total data Pendidikan (${sumPendidikan.value}) melebihi Total Penduduk (${total})`;
    }

    // 4. Umur Validation
    if (sumUmur.value > total) {
        errs.umur = `Total data Kelompok Usia (${sumUmur.value}) melebihi Total Penduduk (${total})`;
    }

    // 5. DPT Validation
    if (dptTotal.value > total) {
        errs.dpt_total = `Total DPT (${dptTotal.value}) melebihi Total Penduduk (${total})`;
    }
    if (sumDptGender.value > dptTotal.value) {
        errs.dpt_gender = `Total DPT Laki-laki & Perempuan (${sumDptGender.value}) melebihi Total DPT yang diinput (${dptTotal.value})`;
    }

    return errs;
});

const attemptedSave = ref(false);

// --- Smart Auto-Correction Logic ---

const handleUmumInput = (item) => {
    if (item.label.toLowerCase().includes('total')) return;

    const total = totalPenduduk.value;
    const label = item.label.toLowerCase();

    if (label === 'laki-laki') {
        const prVal = parseNum(findVal('Perempuan'));
        const maxLaki = Math.max(0, total - prVal);
        if (parseNum(item.value) > maxLaki) {
            item.value = maxLaki.toString();
        }
    } else if (label === 'perempuan') {
        const lakiVal = parseNum(findVal('Laki-laki'));
        const maxPr = Math.max(0, total - lakiVal);
        if (parseNum(item.value) > maxPr) {
            item.value = maxPr.toString();
        }
    }
};

const handleArrayInput = (array, item) => {
    const total = totalPenduduk.value;
    const otherSum = array.reduce((sum, i) => {
        return i === item ? sum : sum + parseNum(i.value);
    }, 0);

    const maxVal = Math.max(0, total - otherSum);
    if (parseNum(item.value) > maxVal) {
        item.value = maxVal.toString();
    }
};

const handleDptTotal = () => {
    const total = totalPenduduk.value;
    const dptVal = parseNum(statsForm.statistik_pemilih.total);
    if (dptVal > total) {
        statsForm.statistik_pemilih.total = total.toString();
    }
    // Also trigger dpt gender validation if total was reduced
    handleDptLaki();
};

const handleDptLaki = () => {
    const dptMax = parseNum(statsForm.statistik_pemilih.total);
    const prVal = parseNum(statsForm.statistik_pemilih.perempuan);
    const maxLaki = Math.max(0, dptMax - prVal);

    if (parseNum(statsForm.statistik_pemilih.laki) > maxLaki) {
        statsForm.statistik_pemilih.laki = maxLaki.toString();
    }
};

const handleDptPr = () => {
    const dptMax = parseNum(statsForm.statistik_pemilih.total);
    const lakiVal = parseNum(statsForm.statistik_pemilih.laki);
    const maxPr = Math.max(0, dptMax - lakiVal);

    if (parseNum(statsForm.statistik_pemilih.perempuan) > maxPr) {
        statsForm.statistik_pemilih.perempuan = maxPr.toString();
    }
};

const saveStats = () => {
    attemptedSave.value = true;

    if (Object.keys(errors.value).length > 0) {
        showNotification('Terdapat kesalahan data yang harus diperbaiki.', 'error');
        return;
    }

    statsForm.post(route('admin.statistik.update'), {
        preserveScroll: true,
        onSuccess: () => {
            attemptedSave.value = false;
        }
    });
};

// Helpers for dynamic fields
const addItem = (key, template) => {
    statsForm[key].push({ ...template });
};

const removeItem = (key, index) => {
    statsForm[key].splice(index, 1);
};
</script>

<template>
    <AdminLayout>

        <Head title="Statistik Penduduk" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 pb-32">
            <!-- Header Section -->
            <div class="mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                    <i class="fas fa-users"></i> Data Kependudukan
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Statistik Penduduk</h1>
                <p class="text-slate-500 font-bold text-sm mt-2">Perbarui data agregat kependudukan desa secara berkala.
                    Persentase akan dihitung otomatis oleh sistem.</p>
            </div>

            <!-- Notification Toast -->
            <transition enter-active-class="transform transition duration-500 ease-out"
                enter-from-class="translate-y-10 opacity-0 scale-95"
                enter-to-class="translate-y-0 opacity-100 scale-100"
                leave-active-class="transition duration-300 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="notification.show"
                    class="fixed bottom-12 right-12 z-[100] p-1 rounded-[2rem] shadow-2xl transition-all"
                    :class="notification.type === 'error' ? 'bg-gradient-to-r from-rose-500 to-red-600 shadow-rose-500/20' : 'bg-gradient-to-r from-emerald-500 to-teal-500 shadow-emerald-500/20'">
                    <div class="bg-white px-8 py-5 rounded-[1.8rem] flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl animate-bounce"
                            :class="notification.type === 'error' ? 'bg-rose-50 text-rose-500' : 'bg-emerald-50 text-emerald-500'">
                            <i
                                :class="notification.type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle'"></i>
                        </div>
                        <div>
                            <p class="text-slate-900 font-black text-lg leading-none mb-1">
                                {{ notification.type === 'error' ? 'Gagal!' : 'Berhasil!' }}
                            </p>
                            <p class="text-slate-400 text-sm font-bold tracking-tight">{{ notification.message }}</p>
                        </div>
                    </div>
                </div>
            </transition>

            <form @submit.prevent="saveStats" class="space-y-12">

                <!-- Section 1: Ringkasan Utama -->
                <div class="group">
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-600/20 rotate-3 group-hover:rotate-0 transition-transform">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Ringkasan Utama Kependudukan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="(item, idx) in statsForm.statistik_umum" :key="idx"
                            class="relative p-8 bg-white rounded-[3rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full opacity-50"></div>

                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 relative z-10">{{
                                    item.label }}</label>
                            <div class="relative z-10">
                                <input v-model="item.value" type="text" @keypress="onlyNumber"
                                    @input="handleUmumInput(item)"
                                    class="w-full bg-slate-50 border-2 focus:bg-white px-6 py-4 rounded-2xl font-black text-3xl text-slate-800 transition-all text-left"
                                    :class="attemptedSave && errors.gender && (item.label === 'Laki-laki' || item.label === 'Perempuan') ? 'border-rose-500 shadow-lg shadow-rose-200' : 'border-transparent focus:border-blue-500'">
                                <div
                                    class="mt-4 flex items-center justify-center gap-2 text-xs font-black text-slate-300 uppercase tracking-widest">
                                    <i :class="['fas', item.icon]"></i> {{ item.unit }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Validation Error -->
                    <transition enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                        <div v-if="errors.gender"
                            class="mt-6 p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span class="text-xs font-black uppercase tracking-wider">{{ errors.gender }}</span>
                        </div>
                    </transition>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Section 2: Agama -->
                    <div
                        class="p-10 bg-white rounded-[3.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-emerald-50 rounded-full -mr-20 -mt-20 opacity-30">
                        </div>

                        <div class="flex items-center justify-between mb-10 relative z-10">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-lg shadow-inner">
                                    <i class="fas fa-mosque"></i>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Kategori Agama</h3>
                            </div>
                            <button type="button"
                                @click="addItem('statistik_agama', { label: '', value: '0', color: 'bg-emerald-500', icon: 'fa-star' })"
                                class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="space-y-6 relative z-10">
                            <transition-group name="list">
                                <div v-for="(item, idx) in statsForm.statistik_agama" :key="idx"
                                    class="flex gap-4 items-center bg-slate-50 p-6 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-lg transition-all">
                                    <div class="flex-grow grid grid-cols-2 gap-4">
                                        <input v-model="item.label" type="text" placeholder="Agama"
                                            class="bg-white border-none rounded-2xl py-3 px-5 font-bold text-slate-700 shadow-sm placeholder:text-slate-300">
                                        <div class="relative">
                                            <input v-model="item.value" type="text" @keypress="onlyNumber"
                                                @input="handleArrayInput(statsForm.statistik_agama, item)"
                                                class="w-full bg-white border-2 rounded-2xl py-3 px-5 font-black text-slate-900 shadow-sm text-left pr-12 transition-all outline-none"
                                                :class="attemptedSave && errors.agama ? 'border-rose-500 shadow-sm shadow-rose-100' : 'border-transparent focus:border-blue-500'">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300">JIWA</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <span class="text-[10px] font-black text-emerald-500 mb-1 animate-pulse">{{
                                            calculatePercent(item.value) }}%</span>
                                        <button type="button" @click="removeItem('statistik_agama', idx)"
                                            class="w-10 h-10 rounded-2xl text-rose-300 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </transition-group>

                            <!-- Validation Error -->
                            <transition enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                <div v-if="errors.agama"
                                    class="mt-4 p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider">{{ errors.agama
                                        }}</span>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- Section 3: Pendidikan -->
                    <div
                        class="p-10 bg-white rounded-[3.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-violet-50 rounded-full -mr-20 -mt-20 opacity-30">
                        </div>

                        <div class="flex items-center justify-between mb-10 relative z-10">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-violet-100 text-violet-600 rounded-2xl flex items-center justify-center text-lg shadow-inner">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Kategori Pendidikan</h3>
                            </div>
                            <button type="button"
                                @click="addItem('statistik_pendidikan', { label: '', value: '0', color: 'bg-violet-500' })"
                                class="w-12 h-12 rounded-full bg-violet-50 text-violet-600 hover:bg-violet-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="space-y-6 relative z-10">
                            <transition-group name="list">
                                <div v-for="(item, idx) in statsForm.statistik_pendidikan" :key="idx"
                                    class="flex gap-4 items-center bg-slate-50 p-6 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-lg transition-all">
                                    <div class="flex-grow grid grid-cols-2 gap-4">
                                        <input v-model="item.label" type="text" placeholder="Jenjang"
                                            class="bg-white border-none rounded-2xl py-3 px-5 font-bold text-slate-700 shadow-sm placeholder:text-slate-300">
                                        <div class="relative">
                                            <input v-model="item.value" type="text" @keypress="onlyNumber"
                                                @input="handleArrayInput(statsForm.statistik_pendidikan, item)"
                                                class="w-full bg-white border-2 rounded-2xl py-3 px-5 font-black text-slate-900 shadow-sm text-left pr-12 transition-all outline-none"
                                                :class="attemptedSave && errors.pendidikan ? 'border-rose-500 shadow-sm shadow-rose-100' : 'border-transparent focus:border-blue-500'">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300">JIWA</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <span class="text-[10px] font-black text-violet-500 mb-1 animate-pulse">{{
                                            calculatePercent(item.value) }}%</span>
                                        <button type="button" @click="removeItem('statistik_pendidikan', idx)"
                                            class="w-10 h-10 rounded-2xl text-rose-300 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </transition-group>

                            <!-- Validation Error -->
                            <transition enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                <div v-if="errors.pendidikan"
                                    class="mt-4 p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider">{{ errors.pendidikan
                                        }}</span>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Section 4: Kelompok Usia -->
                    <div
                        class="p-10 bg-white rounded-[3.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 rounded-full -mr-20 -mt-20 opacity-30">
                        </div>

                        <div class="flex items-center justify-between mb-10 relative z-10">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-lg shadow-inner">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Kelompok Usia</h3>
                            </div>
                            <button type="button"
                                @click="addItem('statistik_umur', { label: '', value: '0', color: 'bg-indigo-500' })"
                                class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="space-y-6 relative z-10">
                            <transition-group name="list">
                                <div v-for="(item, idx) in statsForm.statistik_umur" :key="idx"
                                    class="flex gap-4 items-center bg-slate-50 p-6 rounded-[2.5rem] border border-slate-100 group/item hover:bg-white hover:shadow-lg transition-all">
                                    <div class="flex-grow grid grid-cols-2 gap-4">
                                        <input v-model="item.label" type="text" placeholder="Rentang"
                                            class="bg-white border-none rounded-2xl py-3 px-5 font-bold text-slate-700 shadow-sm placeholder:text-slate-300">
                                        <div class="relative">
                                            <input v-model="item.value" type="text" @keypress="onlyNumber"
                                                @input="handleArrayInput(statsForm.statistik_umur, item)"
                                                class="w-full bg-white border-2 rounded-2xl py-3 px-5 font-black text-slate-900 shadow-sm text-left pr-12 transition-all outline-none"
                                                :class="attemptedSave && errors.umur ? 'border-rose-500 shadow-sm shadow-rose-100' : 'border-transparent focus:border-blue-500'">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300">JIWA</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <span class="text-[10px] font-black text-indigo-500 mb-1 animate-pulse">{{
                                            calculatePercent(item.value) }}%</span>
                                        <button type="button" @click="removeItem('statistik_umur', idx)"
                                            class="w-10 h-10 rounded-2xl text-rose-300 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </transition-group>

                            <!-- Validation Error -->
                            <transition enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                <div v-if="errors.umur"
                                    class="mt-4 p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider">{{ errors.umur
                                        }}</span>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- Section 5: DPT -->
                    <div
                        class="p-10 bg-white rounded-[3.5rem] border border-slate-100 shadow-sm relative overflow-hidden group h-fit">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-rose-50 rounded-full -mr-20 -mt-20 opacity-30">
                        </div>

                        <div class="flex items-center gap-4 mb-10 relative z-10">
                            <div
                                class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-lg shadow-inner">
                                <i class="fas fa-vote-yea"></i>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Data Pemilih Tetap</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-6 relative z-10">
                            <div class="p-8 bg-rose-50/30 rounded-[2.5rem] border transition-all"
                                :class="attemptedSave && errors.dpt_total ? 'border-rose-500' : 'border-rose-100/50'">
                                <label
                                    class="block text-[10px] font-black text-rose-600 uppercase tracking-widest mb-3">Total
                                    DPT</label>
                                <input v-model="statsForm.statistik_pemilih.total" type="text" @keypress="onlyNumber"
                                    @input="handleDptTotal"
                                    class="w-full bg-white border-2 border-rose-100 focus:border-rose-400 rounded-2xl px-6 py-4 font-black text-2xl text-rose-600 shadow-sm transition-all text-left">
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="p-6 bg-blue-50/50 rounded-[2rem] border transition-all"
                                    :class="attemptedSave && errors.dpt_gender ? 'border-rose-500' : 'border-blue-100'">
                                    <label
                                        class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">Laki-laki</label>
                                    <input v-model="statsForm.statistik_pemilih.laki" type="text" @keypress="onlyNumber"
                                        @input="handleDptLaki"
                                        class="w-full bg-white border-none rounded-xl px-4 py-3 font-bold text-slate-700 shadow-sm text-left">
                                </div>
                                <div class="p-6 bg-pink-50/50 rounded-[2rem] border transition-all shadow-sm"
                                    :class="attemptedSave && errors.dpt_gender ? 'border-rose-500' : 'border-pink-100'">
                                    <label
                                        class="block text-[10px] font-black text-pink-600 uppercase tracking-widest mb-3">Perempuan</label>
                                    <input v-model="statsForm.statistik_pemilih.perempuan" type="text"
                                        @keypress="onlyNumber" @input="handleDptPr"
                                        class="w-full bg-white border-none rounded-xl px-4 py-3 font-bold text-slate-700 shadow-sm text-left">
                                </div>
                            </div>
                            <!-- Validation Error -->
                            <transition-group enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                <div v-if="errors.dpt_total" :key="'total'"
                                    class="p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                                    <i class="fas fa-exclamation-triangle text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider leading-tight">{{
                                        errors.dpt_total }}</span>
                                </div>
                                <div v-if="errors.dpt_gender" :key="'gender'"
                                    class="p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center gap-3 text-rose-600">
                                    <i class="fas fa-exclamation-triangle text-[10px]"></i>
                                    <span class="text-[10px] font-black uppercase tracking-wider leading-tight">{{
                                        errors.dpt_gender }}</span>
                                </div>
                            </transition-group>
                        </div>
                    </div>
                </div>

                <!-- Properly Centered Fixed Action Bar -->
                <div
                    class="fixed bottom-10 left-0 right-0 md:left-72 flex justify-center z-50 pointer-events-none px-4 sm:px-6">
                    <div
                        class="w-full max-w-[1200px] p-8 md:p-10 bg-white/95 backdrop-blur-xl rounded-[3rem] border border-slate-100 shadow-[0_25px_100px_rgba(30,58,138,0.2)] flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden pointer-events-auto group transition-all duration-500">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-blue-50 group-hover:bg-blue-100/50 transition-colors rounded-full -mr-20 -mt-20 blur-3xl">
                        </div>

                        <div class="relative z-10">
                            <h4 class="font-black text-slate-900 text-lg">Siap mempublikasikan?</h4>
                            <p class="text-slate-500 font-bold text-sm">Pastikan seluruh data statistik kependudukan
                                sudah
                                sesuai sebelum disimpan.</p>
                        </div>

                        <div class="flex items-center gap-4 relative z-10 w-full md:w-auto">
                            <button type="submit" :disabled="statsForm.processing"
                                class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/30 disabled:opacity-50 flex items-center justify-center gap-3 active:scale-95 group/btn">
                                <i v-if="statsForm.processing" class="fas fa-circle-notch fa-spin"></i>
                                <i v-else class="fas fa-save group-hover:scale-110 transition-transform"></i>
                                SIMPAN SEMUA PERUBAHAN
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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

/* List Transitions */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
