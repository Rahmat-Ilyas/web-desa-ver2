<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    settings: Object
});

const form = useForm({
    visi: props.settings.visi || '',
    misi: Array.isArray(props.settings.misi) ? props.settings.misi : []
});

const showSuccess = ref(false);

const addMisi = () => {
    form.misi.push('');
};

const removeMisi = (index) => {
    form.misi.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.visimisi.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccess.value = true;
            setTimeout(() => showSuccess.value = false, 3000);
        }
    });
};
</script>

<template>
    <AdminLayout>

        <Head title="Kelola Visi Misi" />

        <div class="max-w-[1200px] mx-auto px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest mb-3">
                        <i class="fas fa-edit"></i> Editor Konten
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Visi & Misi</h1>
                    <p class="text-slate-500 font-bold text-sm mt-2">Kelola visi, misi, dan arah kebijakan kelurahan.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a :href="route('profil.visimisi')" target="_blank"
                        class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 font-black text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                        <i class="fas fa-external-link-alt"></i> LIHAT WEB
                    </a>
                </div>
            </div>

            <!-- Success Notification -->
            <transition enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="showSuccess"
                    class="fixed bottom-10 right-10 z-50 p-5 bg-white border border-emerald-100 rounded-3xl flex items-center gap-4 shadow-2xl">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-black text-sm">Berhasil Disimpan!</p>
                        <p class="text-slate-500 text-xs font-bold">Konten visi misi telah diperbarui.</p>
                    </div>
                </div>
            </transition>

            <div class="space-y-8">
                <!-- Visi Section (Full Width) -->
                <div
                    class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10 overflow-hidden relative group">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
                    <div class="mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Visi Kelurahan</h3>
                    </div>
                    <textarea v-model="form.visi" rows="3"
                        class="w-full bg-slate-50 border-none rounded-3xl px-8 py-6 focus:ring-2 focus:ring-blue-500/10 font-bold text-slate-700 italic text-2xl placeholder:text-slate-300 transition-all leading-relaxed text-center"
                        placeholder="Masukkan visi kelurahan..."></textarea>
                    <p v-if="form.errors.visi" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                        form.errors.visi }}</p>
                </div>

                <!-- Misi Section (Full Width) -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Misi Kelurahan
                            </h3>
                        </div>
                        <button @click="addMisi" type="button"
                            class="px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl font-bold text-xs transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Poin Misi
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div v-for="(item, index) in form.misi" :key="index" class="flex gap-4 items-start group">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs mt-2 shrink-0">
                                {{ index + 1 }}
                            </div>
                            <div class="flex-grow">
                                <textarea v-model="form.misi[index]" rows="2"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-indigo-500/10 font-medium text-slate-700 placeholder:text-slate-300 transition-all"
                                    placeholder="Tuliskan poin misi..."></textarea>
                            </div>
                            <button @click="removeMisi(index)" type="button"
                                class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all mt-1">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <div v-if="form.misi.length === 0"
                            class="text-center py-10 border-2 border-dashed border-slate-100 rounded-3xl">
                            <p class="text-slate-400 text-sm font-medium">Belum ada daftar misi. Klik tombol "Tambah
                                Poin Misi" di atas.</p>
                        </div>
                    </div>

                    <p v-if="form.errors.misi" class="mt-3 text-rose-500 text-xs font-bold pl-2">{{
                        form.errors.misi }}</p>

                </div>

                <!-- Sticky Save Action Footer -->
                <div
                    class="mt-12 mb-20 p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-blue-900/5 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-50 group-hover:bg-blue-100/50 transition-colors rounded-full -mr-20 -mt-20 blur-3xl">
                    </div>

                    <div class="relative z-10">
                        <h4 class="font-black text-slate-900 text-lg">Siap mempublikasikan?</h4>
                        <p class="text-slate-500 font-bold text-sm">Pastikan visi dan misi sudah sesuai dengan dokumen
                            resmi.</p>
                    </div>

                    <div class="flex items-center gap-4 relative z-10 w-full md:w-auto">
                        <button @click="submit" :disabled="form.processing"
                            class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/30 disabled:opacity-50 flex items-center justify-center gap-3 active:scale-95 group/btn">
                            <i v-if="form.processing" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            SIMPAN SEMUA PERUBAHAN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
