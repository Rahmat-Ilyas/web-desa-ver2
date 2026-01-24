<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
    <AdminLayout>

        <Head title="Konfigurasi Website" />

        <div class="max-w-[1000px] mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                    <i class="fas fa-cogs"></i> Pengaturan Sistem
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Konfigurasi Website</h1>
                <p class="text-slate-500 font-bold text-sm mt-2">Kelola identitas dasar, logo, dan optimasi SEO website
                    kelurahan.</p>
            </div>

            <!-- Placeholder Card -->
            <div class="bg-white rounded-[2.5rem] p-20 border border-slate-100 shadow-sm text-center">
                <div
                    class="w-24 h-24 bg-blue-50 text-blue-500 rounded-3xl flex items-center justify-center mx-auto mb-8 text-4xl shadow-lg shadow-blue-500/10">
                    <i class="fas fa-tools"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">Fitur Dalam Pengembangan</h2>
                <p class="text-slate-500 font-medium max-w-md mx-auto leading-relaxed">
                    Halaman ini nantinya akan digunakan untuk mengatur identitas website seperti:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10 max-w-2xl mx-auto">
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-left flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-500 shadow-sm shrink-0">
                            <i class="fas fa-heading"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">Identitas Web</p>
                            <p class="text-xs text-slate-500 mt-1">Nama Kelurahan & Judul Website.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-left flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0">
                            <i class="fas fa-image"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">Logo & Favicon</p>
                            <p class="text-xs text-slate-500 mt-1">Upload logo resmi kelurahan.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-left flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm shrink-0">
                            <i class="fas fa-search"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">Optimasi SEO</p>
                            <p class="text-xs text-slate-500 mt-1">Deskripsi & Keyword Google.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-left flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-500 shadow-sm shrink-0">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">Konten Beranda</p>
                            <p class="text-xs text-slate-500 mt-1">Teks sambutan di halaman utama.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
