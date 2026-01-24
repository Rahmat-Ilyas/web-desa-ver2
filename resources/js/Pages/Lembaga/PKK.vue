<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    members: Array,
    profile: String,
    programs: Array
});

const activePokja = ref('Semua');

const pokjas = ['Semua', 'Inti', 'Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4'];

const filteredMembers = computed(() => {
    if (activePokja.value === 'Semua') return props.members;
    return props.members.filter(m => m.pokja === activePokja.value);
});

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : `https://placehold.co/100x120?text=Ibu+PKK`;
};

const formatPhone = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, '');
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};

const currentPrograms = computed(() => {
    if (!props.programs || props.programs.length === 0) {
        return [
            "Penghayatan dan Pengamalan Pancasila",
            "Gotong Royong",
            "Pangan",
            "Sandang",
            "Perumahan dan Tata Laksana Rumah Tangga",
            "Pendidikan dan Keterampilan",
            "Kesehatan",
            "Pengembangan Kehidupan Berkoperasi",
            "Kelestarian Lingkungan Hidup",
            "Perencanaan Sehat"
        ];
    }
    return props.programs;
});

</script>

<template>

    <Head title="Lembaga PKK" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-blue-900 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-6 text-white shadow-lg shadow-indigo-900/20">
                    <i class="fas fa-handshake text-4xl"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">PKK</h1>
                <p class="text-indigo-100 text-lg max-w-2xl mx-auto">Pemberdayaan Kesejahteraan Keluarga Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-24 bg-slate-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                    <!-- Left: Profile and Programs -->
                    <div class="lg:col-span-12 space-y-16">
                        <section
                            class="bg-white rounded-[4rem] p-12 md:p-20 shadow-2xl shadow-slate-900/5 border border-white relative overflow-hidden group">
                            <div
                                class="absolute -top-10 -right-10 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                                <div>
                                    <h2 class="text-4xl font-black text-slate-900 mb-10 tracking-tight">Profil PKK</h2>
                                    <div
                                        class="prose prose-blue prose-lg max-w-none text-slate-600 leading-relaxed font-medium">
                                        <p v-if="profile"
                                            class="whitespace-pre-line text-lg first-letter:text-6xl first-letter:font-black first-letter:text-blue-600 first-letter:mr-3 first-letter:float-left">
                                            {{ profile }}
                                        </p>
                                        <p v-else
                                            class="first-letter:text-6xl first-letter:font-black first-letter:text-blue-600 first-letter:mr-3 first-letter:float-left">
                                            PKK merupakan gerakan pembangunan masyarakat yang tumbuh dari bawah dengan
                                            wanita sebagai penggerak utamanya untuk membina keluarga dalam upaya
                                            mewujudkan kesejahteraan keluarga.
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="bg-blue-50/50 rounded-[4rem] p-10 md:p-14 border border-blue-100 relative overflow-hidden shadow-inner">
                                    <div
                                        class="absolute -bottom-20 -left-20 w-40 h-40 bg-blue-100/50 rounded-full blur-3xl">
                                    </div>
                                    <h3
                                        class="text-blue-900 font-black mb-10 uppercase tracking-[0.3em] text-[10px] flex items-center gap-4 relative z-10">
                                        10 Program Pokok PKK
                                    </h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 relative z-10">
                                        <div v-for="(prog, i) in currentPrograms" :key="i" 
                                            class="flex items-center gap-4 p-4 bg-white rounded-[2rem] border border-blue-50 group/item hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                                            
                                            <!-- Color Accent -->
                                            <div class="absolute inset-y-0 left-0 w-1 transition-all duration-500 group-hover/item:w-2"
                                                :class="[
                                                    i === 0 ? 'bg-rose-500' :
                                                    i === 1 ? 'bg-blue-500' :
                                                    i === 2 ? 'bg-emerald-500' :
                                                    i === 3 ? 'bg-amber-500' :
                                                    i === 4 ? 'bg-purple-500' :
                                                    i === 5 ? 'bg-teal-500' :
                                                    i === 6 ? 'bg-red-500' :
                                                    i === 7 ? 'bg-indigo-500' :
                                                    i === 8 ? 'bg-green-500' :
                                                    'bg-cyan-500'
                                                ]"></div>

                                            <div class="w-10 h-10 rounded-2xl flex-shrink-0 flex items-center justify-center text-lg font-black transition-all duration-500 group-hover/item:rotate-12 shadow-sm"
                                                :class="[
                                                    i === 0 ? 'bg-rose-50 text-rose-500' :
                                                    i === 1 ? 'bg-blue-50 text-blue-500' :
                                                    i === 2 ? 'bg-emerald-50 text-emerald-500' :
                                                    i === 3 ? 'bg-amber-50 text-amber-500' :
                                                    i === 4 ? 'bg-purple-50 text-purple-500' :
                                                    i === 5 ? 'bg-teal-50 text-teal-500' :
                                                    i === 6 ? 'bg-red-50 text-red-500' :
                                                    i === 7 ? 'bg-indigo-50 text-indigo-500' :
                                                    i === 8 ? 'bg-green-50 text-green-500' :
                                                    'bg-cyan-50 text-cyan-500'
                                                ]">
                                                {{ i + 1 }}
                                            </div>
                                            <div class="flex flex-col overflow-hidden">
                                                <span class="text-slate-800 font-bold text-xs leading-tight group-hover/item:text-blue-700 transition-colors">{{ prog }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Middle: Structure with Pokja Tabs -->
                        <section class="space-y-12">
                            <div class="text-center">
                                <h2 class="text-4xl font-black text-slate-900 mb-4 tracking-tight">Struktur Pengurus
                                </h2>
                                <p class="text-slate-500 font-bold">Data jajaran kepengurusan PKK berdasarkan Kelompok
                                    Kerja (Pokja)</p>
                            </div>

                            <!-- Tabs -->
                            <div class="flex flex-wrap justify-center gap-3 mb-16">
                                <button v-for="pokja in pokjas" :key="pokja" @click="activePokja = pokja"
                                    class="px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-sm border"
                                    :class="activePokja === pokja
                                        ? 'bg-blue-600 border-blue-600 text-white shadow-xl shadow-blue-600/30 -translate-y-1'
                                        : 'bg-white border-slate-100 text-slate-400 hover:border-blue-200 hover:text-blue-600'">
                                    {{ pokja }}
                                </button>
                            </div>

                            <!-- Members Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                                <transition-group enter-active-class="transition duration-500 ease-out"
                                    enter-from-class="opacity-0 scale-90 translate-y-4"
                                    enter-to-class="opacity-100 scale-100 translate-y-0"
                                    leave-active-class="transition duration-300 ease-in absolute"
                                    leave-from-class="opacity-100" leave-to-class="opacity-0 scale-95">
                                    <div v-for="member in filteredMembers" :key="member.id"
                                        class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-900/5 border border-white hover:border-blue-100 transition-all duration-500 hover:-translate-y-2">
                                        <div class="relative mb-8 flex justify-center">
                                            <div
                                                class="w-32 h-40 rounded-[2.5rem] bg-slate-100 overflow-hidden shadow-2xl group-hover:scale-110 transition-transform duration-700 rotate-2 group-hover:rotate-0">
                                                <img :src="getPhotoUrl(member.foto)" :alt="member.nama"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div
                                                class="absolute -bottom-3 px-4 py-1.5 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-xl">
                                                {{ member.pokja }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div
                                                class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2">
                                                {{ member.jabatan }}</div>
                                            <h4 class="text-xl font-black text-slate-900 leading-tight mb-4">{{
                                                member.nama }}</h4>

                                            <a v-if="member.no_hp" :href="'https://wa.me/' + formatPhone(member.no_hp)"
                                                target="_blank"
                                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">
                                                <i class="fab fa-whatsapp"></i> Hubungi
                                            </a>
                                        </div>
                                    </div>
                                </transition-group>

                                <div v-if="filteredMembers.length === 0" class="col-span-full py-20 text-center">
                                    <div
                                        class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-user-friends text-3xl text-slate-200"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">Data belum
                                        tersedia</h3>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
/* Optional: Masonry-like or specific card height normalization if needed */
</style>
