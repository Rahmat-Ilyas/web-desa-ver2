<script setup>
import { Head, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, computed } from 'vue';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement
} from 'chart.js';
import { Doughnut } from 'vue-chartjs';

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, BarElement);

const props = defineProps({
    anggaran: Array,
    tahun: [String, Number],
    years: Array
});

const changeYear = (event) => {
    router.get(route('pemerintahan.anggaran'), { tahun: event.target.value }, { preserveState: true, preserveScroll: true });
};

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

const formatCompactRupiah = (number) => {
    if (number === 0) return 'Rp 0';

    const absNumber = Math.abs(number);
    let result = '';
    let suffix = '';

    if (absNumber >= 1e12) {
        result = (number / 1e12).toFixed(1);
        suffix = ' T';
    } else if (absNumber >= 1e9) {
        result = (number / 1e9).toFixed(1);
        suffix = ' M';
    } else if (absNumber >= 1e6) {
        result = (number / 1e6).toFixed(1);
        suffix = ' Jt';
    } else if (absNumber >= 1e3) {
        result = (number / 1e3).toFixed(1);
        suffix = ' K';
    } else {
        result = number.toString();
    }

    // Remove .0 if it exists
    result = result.replace(/\.0$/, '');

    return 'Rp ' + result + suffix;
};

const totalPendapatan = computed(() => {
    return props.anggaran.filter(a => a.kategori === 'pendapatan').reduce((sum, item) => sum + Number(item.jumlah), 0);
});

const totalBelanja = computed(() => {
    return props.anggaran.filter(a => a.kategori === 'belanja').reduce((sum, item) => sum + Number(item.jumlah), 0);
});

const silpa = computed(() => totalPendapatan.value - totalBelanja.value);

const pendapatanItems = computed(() => props.anggaran.filter(a => a.kategori === 'pendapatan'));
const belanjaItems = computed(() => props.anggaran.filter(a => a.kategori === 'belanja'));

const pendapatanColors = ['#059669', '#10B981', '#34D399', '#6EE7B7', '#A7F3D0', '#D1FAE5'];
const belanjaColors = ['#EF4444', '#F59E0B', '#3B82F6', '#8B5CF6', '#EC4899', '#6366F1'];

const pendapatanData = computed(() => ({
    labels: pendapatanItems.value.map(item => item.nama),
    datasets: [
        {
            label: 'Rupiah',
            backgroundColor: pendapatanColors.slice(0, pendapatanItems.value.length).concat(Array(Math.max(0, pendapatanItems.value.length - pendapatanColors.length)).fill('#cbd5e1')),
            hoverOffset: 15,
            borderWidth: 0,
            data: pendapatanItems.value.map(item => Number(item.jumlah))
        }
    ]
}));

const belanjaData = computed(() => ({
    labels: belanjaItems.value.map(item => item.nama),
    datasets: [
        {
            label: 'Rupiah', // Changed from Persentase to Rupiah for consistency
            backgroundColor: belanjaColors.slice(0, belanjaItems.value.length).concat(Array(Math.max(0, belanjaItems.value.length - belanjaColors.length)).fill('#cbd5e1')),
            hoverOffset: 15,
            borderWidth: 0,
            data: belanjaItems.value.map(item => Number(item.jumlah))
        }
    ]
}));

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '80%',
    plugins: {
        legend: {
            display: false,
        },
        tooltip: {
            backgroundColor: '#1f2937',
            padding: 12,
            titleFont: { size: 14, weight: 'bold' },
            bodyFont: { size: 13 },
            callbacks: {
                label: function (context) {
                    let label = context.label || '';
                    if (label) label += ': ';
                    // Always format as Rupiah now
                    label += formatRupiah(context.raw) + ' (' + formatCompactRupiah(context.raw) + ')';
                    return label;
                }
            }
        }
    }
};

const activeCategory = ref('pendapatan');
</script>

<template>

    <Head title="Transparansi Anggaran" />

    <MainLayout>
        <!-- Premium Hero Section -->
        <div class="relative bg-[#064e3b] py-16 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-green-900/50 via-transparent to-blue-900/30"></div>
                <!-- Animated Background Elements -->
                <div
                    class="absolute top-[-10%] right-[-10%] w-[40%] h-[60%] bg-green-500/20 rounded-full blur-[120px] animate-pulse">
                </div>
                <div
                    class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[60%] bg-blue-500/10 rounded-full blur-[120px]">
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 mx-auto bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-2xl border border-white/10">
                        <i class="fas fa-coins text-3xl text-white"></i>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight">
                        Anggaran Pendapatan <br /> & Belanja <span class="text-green-400">Desa {{ tahun }}</span>
                    </h1>
                    <p class="text-green-100/80 text-lg md:text-xl max-w-2xl font-light leading-relaxed mb-8">
                        Mewujudkan tata kelola pemerintahan yang bersih dan transparan melalui keterbukaan informasi
                        publik bagi seluruh warga.
                    </p>

                    <!-- Year Filter -->
                    <div class="relative inline-block">
                        <select :value="tahun" @change="changeYear"
                            class="appearance-none bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold py-3 pl-6 pr-9 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400/50 cursor-pointer hover:bg-white/20 transition-colors">
                            <option v-for="y in years" :key="y" :value="y" class="text-slate-900 bg-white">{{ y }}
                            </option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-green-300">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-slate-50 min-h-screen mt-20 relative z-20 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Summary Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <!-- Income Card -->
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl shadow-green-900/5 border border-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Total
                                    Pendapatan</p>
                                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{
                                    formatRupiah(totalPendapatan) }}</h3>
                            </div>
                            <div
                                class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-wallet fa-fw text-2xl"></i>
                            </div>
                        </div>
                        <div
                            class="mt-8 flex items-center text-green-600 font-bold bg-green-50 w-fit px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-check-circle mr-2"></i> 100% Terealisasi
                        </div>
                    </div>

                    <!-- Expense Card -->
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl shadow-red-900/5 border border-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">Total
                                    Belanja</p>
                                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ formatRupiah(totalBelanja)
                                    }}</h3>
                            </div>
                            <div
                                class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-receipt fa-fw text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="w-full bg-slate-100 rounded-full h-2.5 mb-2 overflow-hidden">
                                <div class="bg-red-500 h-full rounded-full transition-all duration-1000"
                                    style="width: 94.4%"></div>
                            </div>
                            <p class="text-sm font-medium text-slate-500">94.4% Terserap</p>
                        </div>
                    </div>

                    <!-- Sisa Card -->
                    <div
                        class="group bg-white rounded-3xl p-8 shadow-xl shadow-blue-900/5 border border-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider mb-1">SiLPA /
                                    Sisa</p>
                                <h3 class="text-2xl md:text-3xl font-black text-slate-900">{{ formatRupiah(silpa) }}
                                </h3>
                            </div>
                            <div
                                class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-piggy-bank fa-fw text-2xl"></i>
                            </div>
                        </div>
                        <p class="mt-8 text-sm text-slate-500 font-medium">Sisa Lebih Pembiayaan Anggaran</p>
                    </div>
                </div>

                <!-- Interactive Visualization Section -->
                <div
                    class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 p-8 md:p-12 border border-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">Visualisasi Anggaran</h2>
                            <p class="text-slate-500">Pilih kategori untuk melihat rincian data secara interaktif.</p>
                        </div>
                        <div class="inline-flex p-1.5 bg-slate-100 rounded-2xl border border-slate-200/50">
                            <button @click="activeCategory = 'pendapatan'" :class="[
                                'px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300',
                                activeCategory === 'pendapatan' ? 'bg-white text-green-600 shadow-md translate-y-0' : 'text-slate-500 hover:text-slate-700'
                            ]">
                                Pendapatan
                            </button>
                            <button @click="activeCategory = 'belanja'" :class="[
                                'px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300',
                                activeCategory === 'belanja' ? 'bg-white text-red-600 shadow-md translate-y-0' : 'text-slate-500 hover:text-slate-700'
                            ]">
                                Belanja
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <!-- Chart Column -->
                        <div class="lg:col-span-5 flex flex-col items-center">
                            <div class="relative w-full h-80 md:h-[400px]">
                                <Doughnut v-if="activeCategory === 'pendapatan'" :data="pendapatanData"
                                    :options="chartOptions" />
                                <Doughnut v-else :data="belanjaData" :options="chartOptions" />

                                <!-- Center Text Overlay -->
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span
                                        class="text-slate-400 text-[10px] md:text-sm font-bold uppercase tracking-widest mb-1">Total</span>
                                    <span class="text-xl md:text-3xl font-black text-slate-900 leading-none">
                                        {{ activeCategory === 'pendapatan' ? formatCompactRupiah(totalPendapatan) :
                                            '100%'
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Custom Legend (Neater) -->
                            <div class="mt-8 flex flex-wrap justify-center gap-x-6 gap-y-3 px-4">
                                <template v-if="activeCategory === 'pendapatan'">
                                    <div v-for="(label, index) in pendapatanData.labels" :key="index"
                                        class="flex items-center gap-2">
                                        <div :style="{ backgroundColor: pendapatanData.datasets[0].backgroundColor[index] }"
                                            class="w-3 h-3 rounded-full"></div>
                                        <span class="text-xs font-semibold text-slate-600">{{ label }}</span>
                                    </div>
                                </template>
                                <template v-else>
                                    <div v-for="(label, index) in belanjaData.labels" :key="index"
                                        class="flex items-center gap-2">
                                        <div :style="{ backgroundColor: belanjaData.datasets[0].backgroundColor[index] }"
                                            class="w-3 h-3 rounded-full"></div>
                                        <span class="text-xs font-semibold text-slate-600">{{ label }}</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Data List Column -->
                        <div class="lg:col-span-7">
                            <div class="space-y-4">
                                <template v-if="activeCategory === 'pendapatan'">
                                    <div v-for="(label, index) in pendapatanData.labels" :key="index"
                                        class="p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-green-200 hover:bg-green-50/30 transition-all duration-300 group">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div :style="{ backgroundColor: pendapatanData.datasets[0].backgroundColor[index] }"
                                                    class="w-3 h-3 rounded-full"></div>
                                                <span class="font-bold text-slate-700">{{ label }}</span>
                                            </div>
                                            <span
                                                class="font-black text-slate-900 group-hover:text-green-600 transition-colors">{{
                                                    formatRupiah(pendapatanData.datasets[0].data[index]) }}</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-1000" :style="{
                                                backgroundColor: pendapatanData.datasets[0].backgroundColor[index],
                                                width: (pendapatanData.datasets[0].data[index] / totalPendapatan * 100) + '%'
                                            }"></div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div v-for="(label, index) in belanjaData.labels" :key="index"
                                        class="p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-red-200 hover:bg-red-50/30 transition-all duration-300 group">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div :style="{ backgroundColor: belanjaData.datasets[0].backgroundColor[index] }"
                                                    class="w-3 h-3 rounded-full"></div>
                                                <span class="font-bold text-slate-700">{{ label }}</span>
                                            </div>
                                            <span
                                                class="font-black text-slate-900 group-hover:text-red-600 transition-colors">{{
                                                    formatRupiah(belanjaData.datasets[0].data[index]) }}</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-1000" :style="{
                                                backgroundColor: belanjaData.datasets[0].backgroundColor[index],
                                                width: (belanjaData.datasets[0].data[index] / totalBelanja * 100) + '%'
                                            }"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-10 p-6 rounded-2xl bg-slate-900 text-white flex items-center gap-6">
                                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-info-circle fa-fw text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold mb-1">Butuh rincian lengkap?</h4>
                                    <p class="text-slate-400 text-sm">Anda dapat mengunduh dokumen resmi APBDes melalui
                                        menu Download Dokumentasi.
                                    </p>
                                </div>
                                <a href="/download"
                                    class="ml-auto bg-green-500 hover:bg-green-400 text-white h-10 px-4 rounded-xl flex items-center justify-center font-bold transition-colors">
                                    Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

.font-inter {
    font-family: 'Inter', sans-serif;
}

/* Ensure icons always use FontAwesome font family */
:deep(i) {
    font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", sans-serif !important;
    font-weight: 900;
}
</style>
