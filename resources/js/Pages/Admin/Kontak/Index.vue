<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
    alamat: 'Jl. Ahmad Yani No. 1, Kel. Ujung Sabbang, Kec. Ujung, Kota Parepare',
    email: 'kontak@ujungsabbang.go.id',
    telepon: '(0421) 123456',
    whatsapp: '081234567890',
    instagram: 'https://instagram.com/ujungsabbang',
    facebook: 'https://facebook.com/kel.ujungsabbang',
    twitter: 'https://twitter.com/ujungsabbang',
    youtube: 'https://youtube.com/@ujungsabbang',
});

const submit = () => {
    alert('Konfigurasi kontak berhasil diperbarui! (Demo)');
};
</script>

<template>

    <Head title="Kelola Kontak" />

    <AdminLayout>
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Kontak & Media Sosial</h1>
            <p class="text-slate-500 font-bold text-sm uppercase tracking-widest mt-1">Atur informasi kontak resmi
                kelurahan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Basic Contact -->
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-gray-100">
                        <h2 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-500"></i> Informasi Dasar
                        </h2>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat
                                    Kantor</label>
                                <textarea v-model="form.alamat" rows="3"
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email
                                        Resmi</label>
                                    <input v-model="form.email" type="email"
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No.
                                        Telepon Kantor</label>
                                    <input v-model="form.telepon" type="text"
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">WhatsApp
                                    Pengaduan</label>
                                <input v-model="form.whatsapp" type="text"
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-gray-100">
                        <h2 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-share-alt text-indigo-500"></i> Media Sosial
                        </h2>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Instagram
                                        URL</label>
                                    <div class="relative">
                                        <i
                                            class="fab fa-instagram absolute left-5 top-1/2 -translate-y-1/2 text-rose-500"></i>
                                        <input v-model="form.instagram" type="text"
                                            class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Facebook
                                        URL</label>
                                    <div class="relative">
                                        <i
                                            class="fab fa-facebook absolute left-5 top-1/2 -translate-y-1/2 text-blue-600"></i>
                                        <input v-model="form.facebook" type="text"
                                            class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Twitter
                                        / X URL</label>
                                    <div class="relative">
                                        <i
                                            class="fab fa-twitter absolute left-5 top-1/2 -translate-y-1/2 text-sky-500"></i>
                                        <input v-model="form.twitter" type="text"
                                            class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">YouTube
                                        Channel URL</label>
                                    <div class="relative">
                                        <i
                                            class="fab fa-youtube absolute left-5 top-1/2 -translate-y-1/2 text-red-600"></i>
                                        <input v-model="form.youtube" type="text"
                                            class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all active:scale-[0.98]">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <i class="fas fa-lightbulb absolute -right-6 -top-6 text-[120px] opacity-10"></i>
                    <h3 class="text-xl font-black mb-4 relative z-10">Tips Pengaturan</h3>
                    <ul class="space-y-4 text-sm font-medium text-blue-100 relative z-10">
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle mt-1"></i>
                            Pastikan format email sudah benar menggunakan @
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle mt-1"></i>
                            Gunakan format internasional untuk WhatsApp (contoh: 62812...)
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-check-circle mt-1"></i>
                            Salin (copy) link profile sosmed secara utuh dari browser
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
