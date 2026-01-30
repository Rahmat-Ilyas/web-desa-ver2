<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl tracking-tight">Pusat Informasi & Layanan
                </h2>
                <p class="mt-4 text-lg text-gray-500 font-medium">Akses mudah ke berbagai layanan publik serta informasi
                    terkini seputar {{ $page.props.settings?.sebutan_wilayah || 'kelurahan' }}.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <div v-if="$page.props.settings?.module_status?.modul_berita !== false"
                    class="w-full md:w-[calc(50%-2rem)] lg:w-[calc(25%-2rem)] bg-white rounded-3xl p-8 shadow-sm border border-slate-100 group hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110 transition-transform">
                        <i class="fas fa-newspaper text-2xl"></i></div>
                    <h3 class="text-xl font-black text-slate-900 mb-3">Berita Terkini</h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">Dapatkan informasi terbaru mengenai kegiatan
                        {{ $page.props.settings?.sebutan_wilayah || 'kelurahan' }}.</p>
                    <Link :href="route('informasi.berita')"
                        class="text-blue-600 font-black text-sm uppercase tracking-wider hover:text-blue-700">Baca
                        Selengkapnya <i class="fas fa-arrow-right ml-2 text-[10px]"></i></Link>
                </div>

                <div v-if="$page.props.settings?.module_status?.modul_layanan !== false"
                    class="w-full md:w-[calc(50%-2rem)] lg:w-[calc(25%-2rem)] bg-white rounded-3xl p-8 shadow-sm border border-slate-100 group hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-6 text-green-600 group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-contract text-2xl"></i></div>
                    <h3 class="text-xl font-black text-slate-900 mb-3">Layanan Surat</h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">Panduan lengkap persyaratan administrasi
                        kependudukan.</p>
                    <Link :href="route('layanan')"
                        class="text-green-600 font-black text-sm uppercase tracking-wider hover:text-green-700">Lihat
                        Persyaratan <i class="fas fa-arrow-right ml-2 text-[10px]"></i></Link>
                </div>

                <div v-if="$page.props.settings?.module_status?.modul_statistik !== false"
                    class="w-full md:w-[calc(50%-2rem)] lg:w-[calc(25%-2rem)] bg-white rounded-3xl p-8 shadow-sm border border-slate-100 group hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-6 text-purple-600 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-2xl"></i></div>
                    <h3 class="text-xl font-black text-slate-900 mb-3">Data Penduduk</h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">Transparansi data demografi dan statistik
                        warga.</p>
                    <Link :href="route('data.statistik')"
                        class="text-purple-600 font-black text-sm uppercase tracking-wider hover:text-purple-700">Cek
                        Statistik <i class="fas fa-arrow-right ml-2 text-[10px]"></i></Link>
                </div>

                <div v-if="$page.props.settings?.module_status?.modul_pemerintahan_anggaran !== false"
                    class="w-full md:w-[calc(50%-2rem)] lg:w-[calc(25%-2rem)] bg-white rounded-3xl p-8 shadow-sm border border-slate-100 group hover:shadow-2xl transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 text-orange-600 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-pie text-2xl"></i></div>
                    <h3 class="text-xl font-black text-slate-900 mb-3">Transparansi Dana</h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">Laporan terbuka penggunaan anggaran
                        pembangunan.</p>
                    <Link :href="route('pemerintahan.anggaran')"
                        class="text-orange-600 font-black text-sm uppercase tracking-wider hover:text-orange-700">Lihat
                        Laporan <i class="fas fa-arrow-right ml-2 text-[10px]"></i></Link>
                </div>
            </div>
        </div>
    </section>
</template>
