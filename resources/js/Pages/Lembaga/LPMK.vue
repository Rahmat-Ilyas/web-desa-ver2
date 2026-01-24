<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    members: Array,
    profile: String,
    tasks: [Array, String]
});

const parsedTasks = computed(() => {
    // If no tasks provided, show default list
    if (!props.tasks || (Array.isArray(props.tasks) && props.tasks.length === 0)) {
        return [
            'Menyusun rencana pembangunan yang partisipatif (Musrenbang).',
            'Menggerakkan swadaya gotong royong masyarakat.',
            'Melaksanakan dan mengendalikan pembangunan.',
            'Menampung dan menyalurkan aspirasi masyarakat.'
        ];
    }

    // If it's already an array (from the fixed web.php decode)
    if (Array.isArray(props.tasks)) {
        return props.tasks.filter(t => t && t.trim() !== '');
    }

    // Fallback if it comes as a string (legacy or raw input)
    return props.tasks.split('\n').map(t => t.trim()).filter(t => t !== '');
});

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : `https://placehold.co/100x120?text=Pengurus`;
};

const formatPhone = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, '');
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};
</script>

<template>

    <Head title="Lembaga LPMK" />

    <MainLayout>
        <div class="bg-teal-700 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 text-white shadow-lg shadow-indigo-900/20">
                    <i class="fas fa-handshake text-4xl"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">LPMK</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Lembaga Pemberdayaan Masyarakat Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-24 bg-slate-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                    <!-- Main Content -->
                    <div class="lg:col-span-7 space-y-12">
                        <section
                            class="bg-white rounded-[3rem] p-10 md:p-14 shadow-2xl shadow-slate-900/5 border border-white">
                            <h2 class="text-3xl font-black text-slate-900 mb-8">
                                Profil & Fungsi
                            </h2>
                            <div
                                class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed font-medium space-y-6">
                                <p v-if="profile"
                                    class="whitespace-pre-line first-letter:text-5xl first-letter:font-black first-letter:text-teal-600 first-letter:mr-3 first-letter:float-left">
                                    {{ profile }}
                                </p>
                                <div v-else class="space-y-4">
                                    <p
                                        class="first-letter:text-5xl first-letter:font-black first-letter:text-teal-600 first-letter:mr-3 first-letter:float-left">
                                        <strong class="text-slate-900">LPMK (Lembaga Pemberdayaan Masyarakat
                                            Kelurahan)</strong> adalah lembaga
                                        kemasyarakatan yang tumbuh dari, oleh, dan untuk masyarakat, merupakan mitra
                                        kerja Lurah
                                        dalam menampung dan menyalurkan aspirasi masyarakat dibidang pembangunan.
                                    </p>
                                    <p>
                                        LPMK berperan sebagai motor penggerak partisipasi masyarakat dalam merencanakan,
                                        melaksanakan, dan mengontrol hasil-hasil pembangunan yang berada di tingkat
                                        kelurahan.
                                    </p>
                                </div>
                                <div class="bg-teal-50 rounded-3xl p-8 border border-teal-100 mt-10">
                                    <h4 class="text-teal-900 font-black mb-6 uppercase tracking-widest text-xs">Tugas
                                        Utama LPMK:</h4>
                                    <ul class="space-y-4">
                                        <li v-for="(task, i) in parsedTasks" :key="i" class="flex items-start gap-4">
                                            <div
                                                class="w-6 h-6 rounded-full bg-teal-500 flex items-center justify-center text-white text-[10px] shrink-0 mt-1">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="text-slate-700 font-bold text-sm leading-relaxed">{{ task
                                                }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar: Structure -->
                    <div class="lg:col-span-5">
                        <div
                            class="bg-white rounded-[3rem] p-10 shadow-2xl shadow-slate-900/5 border border-white sticky top-32">
                            <h3 class="text-2xl font-black text-slate-900 mb-10 flex items-center gap-4">
                                <i class="fas fa-sitemap text-teal-600"></i>
                                Struktur Pengurus
                            </h3>

                            <div v-if="members && members.length > 0" class="space-y-6">
                                <div v-for="member in members" :key="member.id"
                                    class="group flex items-center gap-6 p-4 rounded-3xl hover:bg-teal-50 border border-transparent hover:border-teal-100 transition-all duration-300">
                                    <div
                                        class="w-16 h-20 rounded-2xl bg-slate-100 flex-shrink-0 overflow-hidden shadow-md group-hover:scale-110 transition-transform duration-500">
                                        <img :src="getPhotoUrl(member.foto)" :alt="member.nama"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-grow">
                                        <div
                                            class="text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1">
                                            {{ member.jabatan }}</div>
                                        <div
                                            class="text-lg font-black text-slate-900 group-hover:text-teal-700 transition-colors">
                                            {{ member.nama }}</div>

                                        <a v-if="member.no_hp" :href="'https://wa.me/' + formatPhone(member.no_hp)"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 mt-2 text-xs font-bold text-slate-400 hover:text-emerald-600 transition-colors">
                                            <i class="fab fa-whatsapp"></i> Hubungi WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty State Sidebar -->
                            <div v-else
                                class="text-center py-10 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                                <i class="fas fa-user-friends text-3xl text-slate-200 mb-4"></i>
                                <p class="text-slate-400 font-bold text-sm">Data pengurus belum tersedia.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
