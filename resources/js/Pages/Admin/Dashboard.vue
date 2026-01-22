<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const stats = [
    { name: 'Total Berita', value: '42', icon: 'fa-newspaper', color: 'blue' },
    { name: 'Aduan Masuk', value: '12', icon: 'fa-exclamation-circle', color: 'rose' },
    { name: 'Data Penduduk', value: '1,240', icon: 'fa-users', color: 'emerald' },
    { name: 'Dokumen Download', value: '15', icon: 'fa-file-download', color: 'amber' },
];

const recentActivities = [
    { title: 'Update Berita: Kerja Bakti', time: '5 Menit yang lalu', type: 'Berita' },
    { title: 'Aduan Baru: Lampu Jalan Mati', time: '1 Jam yang lalu', type: 'Pengaduan' },
    { title: 'Upload Galeri: Musrenbang', time: '4 Jam yang lalu', type: 'Galeri' },
    { title: 'Perubahan Struktur Organisasi', time: 'Kemarin', type: 'Profil' },
];
</script>

<template>

    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 font-bold text-sm uppercase tracking-widest mt-1">Selamat datang kembali, Admin!
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div v-for="stat in stats" :key="stat.name"
                class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-xl hover:shadow-gray-200/50 transition-all group">
                <div
                    :class="[`bg-${stat.color}-100 text-${stat.color}-600`, 'w-16 h-16 rounded-3xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform']">
                    <i :class="['fas', stat.icon]"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ stat.name }}</p>
                    <h3 class="text-2xl font-black text-slate-900 leading-tight">{{ stat.value }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Activities -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-900">Aktivitas Terakhir</h2>
                        <button class="text-blue-600 font-bold text-sm hover:underline">Lihat Semua</button>
                    </div>
                    <div class="p-4">
                        <div v-for="act in recentActivities" :key="act.title"
                            class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-2xl transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ act.title }}</h4>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{
                                        act.type }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-slate-400">{{ act.time }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="space-y-6">
                <div
                    class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                    <i class="fas fa-rocket absolute -right-6 -bottom-6 text-[120px] opacity-10"></i>
                    <h3 class="text-xl font-black mb-2 relative z-10">Pintasan Cepat</h3>
                    <p class="text-indigo-200 text-xs font-bold mb-6 relative z-10">Kelola konten yang paling sering
                        diupdate.</p>
                    <div class="grid grid-cols-2 gap-3 relative z-10">
                        <button
                            class="bg-white/10 hover:bg-white/20 backdrop-blur-md p-4 rounded-2xl transition-all flex flex-col items-center gap-3 active:scale-95">
                            <i class="fas fa-plus-circle text-xl text-blue-400"></i>
                            <span class="text-[10px] font-bold uppercase">Tambah Berita</span>
                        </button>
                        <button
                            class="bg-white/10 hover:bg-white/20 backdrop-blur-md p-4 rounded-2xl transition-all flex flex-col items-center gap-3 active:scale-95">
                            <i class="fas fa-image text-xl text-emerald-400"></i>
                            <span class="text-[10px] font-bold uppercase">Upload Foto</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-black text-slate-900 mb-6">Status Server</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Storage</span>
                            <span class="text-xs font-bold text-slate-900">45%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
