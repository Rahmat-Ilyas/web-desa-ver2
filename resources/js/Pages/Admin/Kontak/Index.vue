<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    settings: Object
});

const page = usePage();
const notification = ref({ show: false, message: '', type: 'success' });

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 3000);
};

watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg);
});

const form = useForm({
    alamat: props.settings.info_umum?.alamat || '',
    email: props.settings.info_umum?.email || '',
    telepon: props.settings.info_umum?.telepon || '',
    whatsapp: props.settings.info_umum?.whatsapp || '',
    instagram: props.settings.sosial_media?.instagram || '',
    facebook: props.settings.sosial_media?.facebook || '',
    twitter: props.settings.sosial_media?.twitter || '',
    youtube: props.settings.sosial_media?.youtube || '',
});

const submit = () => {
    form.post(route('admin.kontak.update'), {
        onSuccess: () => {
            showNotification('Informasi kontak berhasil diperbarui');
        },
    });
};
</script>

<template>
    <AdminLayout>

        <Head title="Kelola Kontak & Sosmed" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100 shadow-sm">
                        <i class="fas fa-address-book"></i> Kontak & Sosial Media
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-2">Kontak & Media
                        Sosial</h1>
                    <p class="text-slate-500 font-bold text-sm">Kelola informasi kontak resmi dan akun media sosial
                        kelurahan.</p>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Contact -->
                    <div
                        class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden group h-fit">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[4rem] -mr-12 -mt-12 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-lg font-black text-slate-900 mb-8 flex items-center gap-3 relative z-10">
                            <span
                                class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                                <i class="fas fa-info-circle text-sm"></i>
                            </span>
                            Informasi Dasar
                        </h2>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Alamat
                                    Kantor</label>
                                <textarea v-model="form.alamat" rows="4"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    :placeholder="`Masukkan alamat lengkap kantor ${$page.props.settings?.sebutan_wilayah?.toLowerCase() || 'kelurahan'}...`"></textarea>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Email
                                    Resmi</label>
                                <input v-model="form.email" type="email"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="contoh@pareparekota.go.id">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">No.
                                    Telepon Kantor</label>
                                <input v-model="form.telepon" type="text"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                    placeholder="(0421) ...">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">WhatsApp
                                    Pengaduan</label>
                                <div class="relative">
                                    <i
                                        class="fab fa-whatsapp absolute left-6 top-1/2 -translate-y-1/2 text-emerald-500 text-lg"></i>
                                    <input v-model="form.whatsapp" type="text"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="62812...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div
                        class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden group h-fit">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[4rem] -mr-12 -mt-12 transition-transform group-hover:scale-110 duration-500">
                        </div>

                        <h2 class="text-lg font-black text-slate-900 mb-8 flex items-center gap-3 relative z-10">
                            <span
                                class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                <i class="fas fa-share-alt text-sm"></i>
                            </span>
                            Media Sosial
                        </h2>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Instagram
                                    URL</label>
                                <div class="relative">
                                    <i
                                        class="fab fa-instagram absolute left-6 top-1/2 -translate-y-1/2 text-rose-500 text-lg"></i>
                                    <input v-model="form.instagram" type="text"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="https://instagram.com/...">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Facebook
                                    URL</label>
                                <div class="relative">
                                    <i
                                        class="fab fa-facebook absolute left-6 top-1/2 -translate-y-1/2 text-blue-600 text-lg"></i>
                                    <input v-model="form.facebook" type="text"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="https://facebook.com/...">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">Twitter
                                    / X URL</label>
                                <div class="relative">
                                    <i
                                        class="fab fa-x-twitter absolute left-6 top-1/2 -translate-y-1/2 text-slate-900 text-lg"></i>
                                    <input v-model="form.twitter" type="text"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="https://twitter.com/...">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-3">YouTube
                                    URL</label>
                                <div class="relative">
                                    <i
                                        class="fab fa-youtube absolute left-6 top-1/2 -translate-y-1/2 text-red-600 text-lg"></i>
                                    <input v-model="form.youtube" type="text"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:border-blue-500 focus:bg-white rounded-2xl font-bold text-slate-700 outline-none transition-all"
                                        placeholder="https://youtube.com/@...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Save Action Footer -->
                <div
                    class="mt-12 mb-20 p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-blue-900/5 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-50 group-hover:bg-blue-100/50 transition-colors rounded-full -mr-20 -mt-20 blur-3xl">
                    </div>

                    <div class="relative z-10">
                        <h4 class="font-black text-slate-900 text-lg">Simpan informasi kontak?</h4>
                        <p class="text-slate-500 font-bold text-sm">Pastikan semua data kontak dan link sosial media
                            sudah benar.</p>
                    </div>

                    <div class="flex items-center gap-4 relative z-10 w-full md:w-auto">
                        <button type="submit" :disabled="form.processing"
                            class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/30 disabled:opacity-50 flex items-center justify-center gap-3 active:scale-95 group/btn">
                            <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Notification Toast -->
        <transition enter-active-class="transform transition duration-500 ease-out"
            enter-from-class="translate-y-10 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-300 ease-in" leave-from-class="opacity-100"
            leave-to-class="translate-y-10 opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-10 z-[120] p-4 bg-white border border-emerald-100 rounded-2xl flex items-center gap-3 shadow-2xl">
                <div
                    class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-md shadow-emerald-500/20">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <p class="text-slate-900 font-black text-xs">Berhasil!</p>
                    <p class="text-slate-500 text-[10px] font-bold">{{ notification.message }}</p>
                </div>
            </div>
        </transition>

    </AdminLayout>
</template>
