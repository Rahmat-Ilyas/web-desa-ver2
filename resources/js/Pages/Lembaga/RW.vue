<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    members: Array
});

const formatPhone = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, ''); // Remove non-digits
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};
</script>

<template>

    <Head title="Lembaga Rukun Warga (RW)" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-indigo-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 text-white shadow-lg shadow-indigo-900/20">
                    <i class="fas fa-users-cog text-3xl"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Rukun Warga (RW)</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Daftar Ketua RW dan Cakupan Wilayah di Kelurahan
                    Ujung Sabbang.</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-16 bg-white min-h-[50vh]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div v-if="members.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="item in members" :key="item.id"
                        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-visible hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">

                        <!-- Header / Cover Pattern -->
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-indigo-700 relative rounded-t-2xl">
                            <div
                                class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] invert rounded-t-2xl">
                            </div>
                            <div class="absolute -bottom-10 left-6">
                                <div
                                    class="w-20 h-20 rounded-full border-4 border-white bg-gray-100 overflow-hidden shadow-md z-10 relative">
                                    <img v-if="item.foto_ketua" :src="'/storage/' + item.foto_ketua"
                                        class="w-full h-full object-cover">
                                    <div v-else
                                        class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                        <i class="fas fa-user text-3xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full border border-white/30 text-white font-black text-xs">
                                RW {{ item.no_rw }}
                            </div>
                        </div>

                        <div class="pt-12 px-6 pb-6 bg-white rounded-b-2xl">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                                {{ item.nama_ketua }}</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ketua RW {{
                                item.no_rw }}</p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="text-xs text-gray-400 font-medium">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Ujung Sabbang
                                </div>
                                <a v-if="item.no_hp" :href="'https://wa.me/' + formatPhone(item.no_hp)" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors">
                                    <i class="fab fa-whatsapp text-sm"></i> Hubungi
                                </a>
                                <span v-else class="text-xs text-slate-300 italic">No Kontak</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <div
                        class="w-20 h-20 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-4">
                        <i class="fas fa-users-slash text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">Belum ada data RW</h3>
                    <p class="text-slate-500 text-sm">Data pengurus RW belum ditambahkan.</p>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
