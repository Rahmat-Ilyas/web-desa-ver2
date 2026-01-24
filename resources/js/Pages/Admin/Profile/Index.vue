<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    password: '',
    password_confirmation: '',
});

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

const submit = () => {
    form.post(route('admin.profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <AdminLayout>

        <Head title="Pengaturan Profil" />

        <div class="max-w-[1000px] mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                    <i class="fas fa-user-cog"></i> Keamanan Akun
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Pengaturan Profil</h1>
                <p class="text-slate-500 font-bold text-sm mt-2">Perbarui informasi personal dan kata sandi akses Anda.
                </p>
            </div>

            <!-- Success Notification -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="notification.show"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil!</p>
                        <p class="text-slate-500 text-xs font-bold">{{ notification.message }}</p>
                    </div>
                </div>
            </transition>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm text-center">
                        <div class="relative w-24 h-24 mx-auto mb-4">
                            <div
                                class="w-full h-full rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-3xl shadow-xl">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center text-white text-[10px]">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <h3 class="font-black text-slate-900 text-lg">{{ user.name }}</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Administrator</p>

                        <div class="mt-8 pt-8 border-t border-slate-50 space-y-4 text-left">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                    <i class="fas fa-envelope text-xs"></i>
                                </div>
                                <div class="truncate">
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-tight">Email</p>
                                    <p class="text-xs font-bold text-slate-600 truncate">{{ user.email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                    <i class="fas fa-history text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-tight">Terakhir
                                        Update</p>
                                    <p class="text-xs font-bold text-slate-600">{{ new
                                        Date(user.updated_at).toLocaleDateString('id-ID') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Profile -->
                <div class="lg:col-span-2">
                    <form @submit.prevent="submit"
                        class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm space-y-8">
                        <!-- Personal Info Section -->
                        <div>
                            <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-6">Informasi
                                Dasar</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-wider ml-1">Nama
                                        Lengkap</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-user-edit text-sm"></i>
                                        </div>
                                        <input v-model="form.name" type="text"
                                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="Masukkan nama lengkap...">
                                    </div>
                                    <p v-if="form.errors.name" class="text-rose-500 text-[10px] font-bold ml-1">{{
                                        form.errors.name }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-wider ml-1">Alamat
                                        Email</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-at text-sm"></i>
                                        </div>
                                        <input v-model="form.email" type="email"
                                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="nama@email.com">
                                    </div>
                                    <p v-if="form.errors.email" class="text-rose-500 text-[10px] font-bold ml-1">{{
                                        form.errors.email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="pt-8 border-t border-slate-50">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em]">Ganti Kata
                                    Sandi</h4>
                                <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[9px] font-black rounded-lg">*
                                    Kosongkan jika tidak diubah</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-wider ml-1">Password
                                        Baru</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-lock text-sm"></i>
                                        </div>
                                        <input v-model="form.password" type="password"
                                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="********">
                                    </div>
                                    <p v-if="form.errors.password" class="text-rose-500 text-[10px] font-bold ml-1">{{
                                        form.errors.password }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-wider ml-1">Konfirmasi
                                        Password</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                            <i class="fas fa-shield-alt text-sm"></i>
                                        </div>
                                        <input v-model="form.password_confirmation" type="password"
                                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:bg-white transition-all placeholder:text-slate-300"
                                            placeholder="********">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="pt-10 flex items-center justify-end gap-4">
                            <button type="submit" :disabled="form.processing"
                                class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/30 disabled:opacity-50 flex items-center gap-3">
                                <i v-if="form.processing" class="fas fa-spinner fa-spin"></i>
                                <i v-else class="fas fa-save shadow-sm"></i>
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
