<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: Array,
    recentActivities: Array,
    pendingPengaduanCount: Number,
    serverStatus: Array
});
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
        <div class="flex flex-wrap gap-6 mb-10">
            <template v-for="stat in stats" :key="stat.name">
                <div v-if="
                    (stat.name === 'Total Berita' && $page.props.settings?.module_status?.modul_berita !== false) ||
                    (stat.name === 'Galeri Foto' && $page.props.settings?.module_status?.modul_galeri !== false) ||
                    (stat.name === 'Pengaduan Warga' && $page.props.settings?.module_status?.modul_pengaduan !== false) ||
                    (stat.name === 'Dokumen Download' && $page.props.settings?.module_status?.modul_download !== false)
                "
                    class="flex-1 min-w-[200px] bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-xl hover:shadow-gray-200/50 transition-all group">
                    <div
                        :class="[`bg-${stat.color}-100 text-${stat.color}-600`, 'w-16 h-16 rounded-3xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform']">
                        <i :class="['fas', stat.icon]"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ stat.name }}</p>
                        <h3 class="text-2xl font-black text-slate-900 leading-tight">{{ stat.value }}</h3>
                    </div>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Activities -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-900">Aktivitas Terakhir</h2>
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
                    <div class="flex flex-wrap justify-center gap-3 relative z-10">
                        <Link v-if="$page.props.settings?.module_status?.modul_berita !== false"
                            :href="route('admin.berita.create')"
                            class="bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-[2rem] transition-all flex flex-col items-center gap-3 active:scale-95 group/btn flex-1 min-w-[90px]">
                            <div
                                class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-plus-circle text-lg text-blue-400"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-center">Tambah
                                Berita</span>
                        </Link>

                        <Link v-if="$page.props.settings?.module_status?.modul_galeri !== false"
                            :href="route('admin.galeri.index')"
                            class="bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-[2rem] transition-all flex flex-col items-center gap-3 active:scale-95 group/btn flex-1 min-w-[90px]">
                            <div
                                class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-image text-lg text-emerald-400"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-center">Upload
                                Foto</span>
                        </Link>

                        <Link v-if="$page.props.settings?.module_status?.modul_pengaduan !== false"
                            :href="route('admin.pengaduan.index')"
                            class="bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-[2rem] transition-all flex flex-col items-center gap-3 active:scale-95 group/btn relative flex-1 min-w-[90px]">
                            <!-- Notification Bubble -->
                            <div v-if="pendingPengaduanCount > 0"
                                class="absolute top-4 right-4 w-6 h-6 bg-rose-500 rounded-full flex items-center justify-center text-[10px] font-black shadow-lg shadow-rose-500/40 animate-bounce">
                                {{ pendingPengaduanCount }}
                            </div>
                            <div
                                class="w-10 h-10 bg-rose-500/20 rounded-xl flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                <i class="fas fa-exclamation-circle text-lg text-rose-400"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-center">Pengaduan
                                Warga</span>
                        </Link>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-black text-slate-900 mb-6">Status Server</h3>
                    <div class="space-y-6">
                        <div v-for="item in serverStatus" :key="item.label">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{
                                    item.label }}</span>
                                <span :class="[`text-${item.color}-600`, 'text-xs font-black']">{{ item.value }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-50 rounded-full overflow-hidden mb-2">
                                <div :class="[`bg-${item.color}-500`, 'h-full rounded-full transition-all duration-1000']"
                                    :style="{ width: item.raw + '%' }"></div>
                            </div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">{{ item.detail }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
