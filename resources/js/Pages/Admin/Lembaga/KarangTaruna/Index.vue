<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const title = 'Karang Taruna';
</script>

<template>
    <AdminLayout>

        <Head :title="title" />
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <div class="mb-8">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100 shadow-sm">
                    <i class="fas fa-sitemap"></i> Lembaga Kelurahan
                </span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-2">{{ title }}</h1>
                <p class="text-slate-500 font-bold text-sm">Kelola data pengurus Karang Taruna.</p>
            </div>
            <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100">
                <i class="fas fa-hard-hat text-4xl text-slate-300 mb-4"></i>
                <h3 class="text-lg font-bold text-slate-500">Halaman dalam pengembangan backend</h3>
            </div>
        </div>
    </AdminLayout>
</template>
