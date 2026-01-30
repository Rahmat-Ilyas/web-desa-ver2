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

const FALLBACK_ICONS = [
    'fa-dove', 'fa-users', 'fa-utensils', 'fa-tshirt', 'fa-home',
    'fa-graduation-cap', 'fa-heartbeat', 'fa-handshake', 'fa-leaf',
    'fa-briefcase-medical'
];

const currentPrograms = computed(() => {
    if (!props.programs || props.programs.length === 0) {
        return [
            { name: "Penghayatan dan Pengamalan Pancasila", icon: "fa-dove" },
            { name: "Gotong Royong", icon: "fa-users" },
            { name: "Pangan", icon: "fa-utensils" },
            { name: "Sandang", icon: "fa-tshirt" },
            { name: "Perumahan dan Tata Laksana Rumah Tangga", icon: "fa-home" },
            { name: "Pendidikan dan Keterampilan", icon: "fa-graduation-cap" },
            { name: "Kesehatan", icon: "fa-heartbeat" },
            { name: "Pengembangan Kehidupan Berkoperasi", icon: "fa-handshake" },
            { name: "Kelestarian Lingkungan Hidup", icon: "fa-leaf" },
            { name: "Perencanaan Sehat", icon: "fa-briefcase-medical" }
        ];
    }

    return props.programs.map((p, i) => {
        if (typeof p === 'string') {
            return { name: p, icon: FALLBACK_ICONS[i] || 'fa-star' };
        }
        return p;
    });
});
</script>

<template>

    <Head title="Lembaga PKK" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-rose-600 py-16 relative overflow-hidden">
            <div
                class="absolute inset-0 opacity-100 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-white/20 backdrop-blur-md border border-white/30 mb-8 text-white shadow-2xl rotate-3 relative group">
                    <div class="absolute inset-0 bg-white/20 rounded-3xl animate-ping opacity-20"></div>
                    <i class="fas fa-hand-holding-heart text-4xl"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-4 uppercase">PKK</h1>
                <p class="text-rose-50 text-xl max-w-2xl mx-auto font-medium">Pemberdayaan Kesejahteraan Keluarga
                    {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah ||
                    '[Nama Wilayah]' }}.</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-rose-400/20 rounded-full blur-2xl"></div>
        </div>

        <!-- Main Content Section -->
        <section id="profil" class="py-24 bg-white relative overflow-hidden">
            <!-- Organic Background Elements -->
            <div class="absolute top-0 right-0 w-1/4 h-full bg-rose-50/50 -skew-x-12 transform translate-x-20 z-0">
            </div>
            <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-blue-50/30 skew-x-12 transform -translate-x-20 z-0">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <!-- Left Column: Visual & Quote -->
                    <div class="space-y-12">
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-rose-100/50 rounded-[3.5rem] rotate-3 group-hover:rotate-0 transition-transform duration-700">
                            </div>
                            <div
                                class="relative rounded-[3rem] overflow-hidden shadow-2xl aspect-[4/5] max-w-lg mx-auto lg:mx-0">
                                <img :src="$page.props.settings?.cover_pkk || '/assets/images/lembaga/pkk_profile.png'"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                                    alt="Kegiatan PKK">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-rose-950/80 via-transparent to-transparent">
                                </div>
                                <div class="absolute bottom-12 left-12 right-12 text-white text-center">
                                    <h3 class="text-2xl font-black leading-tight uppercase tracking-tighter italic">
                                        "Membangun Keluarga,<br>Menyejahterakan Warga"
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="grid grid-cols-3 gap-6">
                            <div
                                class="text-center p-6 bg-white rounded-3xl border border-rose-100 shadow-sm shadow-rose-900/5">
                                <div class="text-2xl font-black text-rose-600 mb-1">10</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Program
                                    Utama</div>
                            </div>
                            <div
                                class="text-center p-6 bg-white rounded-3xl border border-rose-100 shadow-sm shadow-rose-900/5">
                                <div class="text-2xl font-black text-blue-600 mb-1">4</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kelompok
                                    Kerja</div>
                            </div>
                            <div
                                class="text-center p-6 bg-white rounded-3xl border border-rose-100 shadow-sm shadow-rose-900/5">
                                <div class="text-2xl font-black text-emerald-600 mb-1">Aktif</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pemberdayaan
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Profile Content -->
                    <div class="flex flex-col">
                        <div class="mb-12">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <span class="text-rose-600 font-black text-[10px] uppercase tracking-[0.4em]">Profil
                                    Lembaga</span>
                            </div>
                            <h2
                                class="text-4xl md:text-5xl font-black text-slate-900 leading-[1.1] tracking-tighter mb-8 uppercase">
                                Penggerak <span class="text-rose-600">Kesejahteraan</span> Dari Rumah Untuk Semua.
                            </h2>
                            <div class="relative">
                                <div class="absolute -left-6 top-0 text-rose-100 text-6xl font-serif">“</div>
                                <p
                                    class="text-slate-600 text-lg md:text-xl leading-relaxed font-medium italic relative z-10 pl-2">
                                    {{ profile || 'PKK merupakan gerakan pembangunan masyarakat yang tumbuh dari bawah dengan wanita sebagai penggerak utamanya untuk membina keluarga dalam upaya mewujudkan kesejahteraan keluarga.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Core Values List -->
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 p-5 bg-rose-50/50 rounded-3xl border border-rose-100">
                                <div
                                    class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs shrink-0 mt-1">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 font-black text-sm uppercase mb-1">Kemandirian Keluarga
                                    </h4>
                                    <p class="text-slate-500 text-xs font-medium">Mendorong keluarga agar mampu memenuhi
                                        kebutuhan secara mandiri.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-5 bg-blue-50/50 rounded-3xl border border-blue-100">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs shrink-0 mt-1">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 font-black text-sm uppercase mb-1">Ketahanan Sosial</h4>
                                    <p class="text-slate-500 text-xs font-medium">Memperkuat ikatan sosial antar
                                        tetangga dan lingkungan sekitar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 10 Programs Section -->
        <section class="py-24 bg-slate-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-rose-600 font-black text-[10px] uppercase tracking-[0.4em] mb-4 block">Rencana
                        Aksi</span>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter mb-6 uppercase">
                        10 Program <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-rose-600">Pokok
                            PKK</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div v-for="(prog, i) in currentPrograms" :key="i"
                        class="group relative bg-white rounded-[3rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40 hover:shadow-rose-900/10 transition-all duration-500 hover:-translate-y-1 flex items-center gap-8 overflow-hidden">

                        <!-- Large Background Number -->
                        <div
                            class="absolute -right-4 -bottom-8 text-[12rem] font-black text-slate-50 opacity-[0.03] italic group-hover:opacity-[0.06] transition-opacity pointer-events-none">
                            {{ i + 1 }}
                        </div>

                        <!-- Icon Container -->
                        <div class="relative z-10 w-20 h-20 shrink-0 rounded-[2rem] flex items-center justify-center text-3xl shadow-inner group-hover:scale-110 transition-transform duration-500"
                            :class="[
                                i % 5 === 0 ? 'bg-rose-50 text-rose-500 shadow-rose-100' :
                                    i % 5 === 1 ? 'bg-blue-50 text-blue-500 shadow-blue-100' :
                                        i % 5 === 2 ? 'bg-emerald-50 text-emerald-500 shadow-emerald-100' :
                                            i % 5 === 3 ? 'bg-orange-50 text-orange-500 shadow-orange-100' :
                                                'bg-purple-50 text-purple-500 shadow-purple-100'
                            ]">
                            <i :class="['fas', prog.icon || 'fa-star']"></i>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <span
                                class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2 block font-sans">Program
                                {{ String(i + 1).padStart(2, '0') }}</span>
                            <h3
                                class="text-xl font-black text-slate-900 leading-tight group-hover:text-rose-600 transition-colors uppercase tracking-tighter">
                                {{ prog.name }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Structure Section -->
        <section id="members" class="py-24 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-16 space-y-8 text-center">
                    <div>
                        <span
                            class="text-rose-600 font-black text-[10px] uppercase tracking-[0.3em] mb-3 block">Kelompok
                            Kerja</span>
                        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter">Struktur <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-rose-600">Kepengurusan</span>
                        </h2>
                    </div>

                    <!-- Modern Segmented Control Tabs -->
                    <div class="flex justify-center">
                        <div
                            class="inline-flex p-2 bg-slate-100 rounded-[2.5rem] overflow-x-auto no-scrollbar max-w-full">
                            <button v-for="pokja in pokjas" :key="pokja" @click="activePokja = pokja"
                                class="px-8 py-3.5 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 whitespace-nowrap shrink-0"
                                :class="activePokja === pokja
                                    ? 'bg-white text-rose-600 shadow-xl shadow-rose-900/10'
                                    : 'text-slate-500 hover:text-rose-600 hover:bg-white/50'">
                                {{ pokja }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Members Grid - Scrollable & Dynamic -->
                <div class="relative max-h-[800px] overflow-y-auto px-4 pb-12 custom-scrollbar transition-all">
                    <transition-group enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 scale-90 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition duration-300 ease-in absolute" leave-from-class="opacity-100"
                        leave-to-class="opacity-0 scale-95" tag="div"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div v-for="member in filteredMembers" :key="member.id"
                            class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:border-rose-100 transition-all duration-500 hover:-translate-y-2">
                            <div class="relative mb-8 flex justify-center">
                                <div
                                    class="w-32 h-40 rounded-[2.5rem] bg-slate-50 overflow-hidden shadow-2xl group-hover:scale-110 transition-transform duration-700 rotate-2 group-hover:rotate-0 border-4 border-white">
                                    <img :src="getPhotoUrl(member.foto)" :alt="member.nama"
                                        class="w-full h-full object-cover">
                                </div>
                                <div
                                    class="absolute -bottom-3 px-4 py-1.5 bg-rose-600 text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-xl">
                                    {{ member.pokja }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-[10px] font-black text-rose-600 uppercase tracking-[0.2em] mb-2">
                                    {{ member.jabatan }}
                                </div>
                                <h4
                                    class="text-xl font-black text-slate-900 leading-tight mb-6 uppercase tracking-tighter">
                                    {{ member.nama }}
                                </h4>

                                <a v-if="member.no_hp" :href="'https://wa.me/' + formatPhone(member.no_hp)"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all w-full justify-center group/wa">
                                    <i class="fab fa-whatsapp text-sm group-hover:rotate-12 transition-transform"></i>
                                    Hubungi
                                </a>
                            </div>
                        </div>
                    </transition-group>

                    <div v-if="filteredMembers.length === 0" class="py-20 text-center w-full">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-friends text-3xl text-slate-200"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">Data belum tersedia</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- PKK Visionary Section - Improved -->
        <section class="py-32 bg-rose-600 relative overflow-hidden">
            <!-- Dynamic Background -->
            <div
                class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0">
            </div>
            <div
                class="absolute -top-1/2 -left-1/4 w-[100%] h-[200%] bg-gradient-to-br from-rose-500/20 to-transparent rounded-full blur-[120px] rotate-12">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div
                    class="bg-white/10 backdrop-blur-2xl rounded-[4rem] border border-white/20 p-12 md:p-24 text-center">
                    <div class="max-w-4xl mx-auto text-white">
                        <div
                            class="inline-flex items-center justify-center w-28 h-28 rounded-[2.5rem] bg-white text-rose-600 mb-10 shadow-2xl rotate-3 relative overflow-hidden group/star">
                            <div
                                class="absolute inset-0 bg-rose-50 scale-0 group-hover/star:scale-100 transition-transform duration-700 rounded-full">
                            </div>
                            <i class="fas fa-heart text-6xl relative z-10 animate-bounce-slow"></i>
                        </div>
                        <h2
                            class="text-5xl md:text-6xl font-black uppercase tracking-tighter mb-8 leading-[0.85] italic drop-shadow-2xl">
                            "Keluarga Sejahtera,<br><span class="text-rose-200">Masyarakat Berdaya.</span>"
                        </h2>
                        <p
                            class="text-rose-50 font-bold text-xl md:text-2xl leading-relaxed mb-16 max-w-3xl mx-auto opacity-90">
                            Membangun peradaban mulia yang dimulai dari ketahanan keluarga yang mandiri dan
                            berintegritas.
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                            <div
                                class="p-8 bg-white/5 rounded-3xl border border-white/10 hover:bg-white/20 transition-all cursor-default group">
                                <i
                                    class="fas fa-child text-3xl text-rose-200 mb-4 group-hover:scale-110 transition-transform"></i>
                                <span class="block text-[10px] font-black uppercase tracking-[0.3em]">Anak Sehat</span>
                            </div>
                            <div
                                class="p-8 bg-white/5 rounded-3xl border border-white/10 hover:bg-white/20 transition-all cursor-default group">
                                <i
                                    class="fas fa-venus text-3xl text-rose-200 mb-4 group-hover:scale-110 transition-transform"></i>
                                <span class="block text-[10px] font-black uppercase tracking-[0.3em]">Perempuan
                                    Maju</span>
                            </div>
                            <div
                                class="p-8 bg-white/5 rounded-3xl border border-white/10 hover:bg-white/20 transition-all cursor-default group">
                                <i
                                    class="fas fa-home text-3xl text-rose-200 mb-4 group-hover:scale-110 transition-transform"></i>
                                <span class="block text-[10px] font-black uppercase tracking-[0.3em]">Rumah
                                    Nyaman</span>
                            </div>
                            <div
                                class="p-8 bg-white/5 rounded-3xl border border-white/10 hover:bg-white/20 transition-all cursor-default group">
                                <i
                                    class="fas fa-hand-holding-heart text-3xl text-rose-200 mb-4 group-hover:scale-110 transition-transform"></i>
                                <span class="block text-[10px] font-black uppercase tracking-[0.3em]">Saling
                                    Bantu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
@keyframes bounce-slow {

    0%,
    100% {
        transform: translateY(0) rotate(3deg);
    }

    50% {
        transform: translateY(-10px) rotate(-3deg);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 4s ease-in-out infinite;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #f43f5e;
    /* rose-500 */
    border-radius: 10px;
    border: 1px solid transparent;
}
</style>
