<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    members: Array,
    profile: String,
    tasks: Array,
});

const activeBidang = ref('Semua');

const bidangList = computed(() => {
    const list = ['Semua'];
    if (props.members) {
        props.members.forEach(m => {
            if (m.bidang && !list.includes(m.bidang)) {
                list.push(m.bidang);
            }
        });
    }
    return list;
});

const filteredMembers = computed(() => {
    if (!props.members) return [];
    if (activeBidang.value === 'Semua') return props.members;
    return props.members.filter(m => m.bidang === activeBidang.value);
});

const formatPhone = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, '');
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};
</script>

<template>

    <Head title="Lembaga Karang Taruna" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-orange-600 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-50 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-white/20 backdrop-blur-md border border-white/30 mb-8 text-white shadow-2xl rotate-3 group-hover:rotate-0 transition-transform">
                    <i class="fas fa-fist-raised text-4xl"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-4">Karang Taruna</h1>
                <p class="text-orange-50 text-xl max-w-2xl mx-auto font-medium">Wadah pengembangan bakat dan kreativitas
                    generasi muda {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-orange-400/20 rounded-full blur-2xl"></div>
        </div>

        <!-- Main Content Section -->
        <section id="profil" class="py-24 bg-white relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-1/3 h-full bg-slate-50/50 -skew-x-12 transform translate-x-20 z-0">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">
                    <!-- Left Column: Visual & Quote -->
                    <div class="space-y-12">
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-orange-100/50 rounded-[3.5rem] -rotate-3 group-hover:rotate-0 transition-transform duration-700">
                            </div>
                            <div
                                class="relative rounded-[3rem] overflow-hidden shadow-2xl aspect-[4/5] sm:aspect-square lg:aspect-[4/5] max-w-lg mx-auto lg:mx-0">
                                <img :src="$page.props.settings?.cover_karang_taruna || '/assets/images/lembaga/karang_taruna_profile.png'"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                                    :alt="'Pemuda ' + ($page.props.settings?.nama_wilayah || '[Nama Wilayah]')">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-orange-950/80 via-transparent to-transparent">
                                </div>
                                <div class="absolute bottom-12 left-12 right-12 text-white">
                                    <span
                                        class="inline-block px-3 py-1 bg-orange-500 rounded-lg text-[8px] font-black uppercase tracking-[0.3em] mb-4">Motto
                                        Kami</span>
                                    <h3 class="text-3xl font-black leading-tight uppercase tracking-tighter">
                                        Bekerja<br>Bersama<br>Bakti Nyata</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Mini Stats or Info -->
                        <div class="grid grid-cols-3 gap-6 pt-6">
                            <div class="text-center p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                <div class="text-2xl font-black text-orange-600 mb-1">Energi</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Muda</div>
                            </div>
                            <div class="text-center p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                <div class="text-2xl font-black text-orange-600 mb-1">Gerakan</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Aktif</div>
                            </div>
                            <div class="text-center p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                <div class="text-2xl font-black text-orange-600 mb-1">Dampak</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Nyata</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Profile Content -->
                    <div class="flex flex-col h-full pt-4">
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <span
                                    class="text-orange-600 font-extrabold text-[10px] uppercase tracking-[0.4em]">Tentang
                                    Karang Taruna</span>
                            </div>
                            <h2
                                class="text-3xl md:text-5xl font-black text-slate-900 leading-[1.1] tracking-tighter mb-8 uppercase">
                                Pemuda Bergerak, Membangun Masa Depan <span class="text-orange-600">{{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }}.</span>
                            </h2>
                            <div class="relative">
                                <div class="absolute -left-6 top-0 text-orange-100 text-6xl font-serif">“</div>
                                <p
                                    class="text-slate-600 text-lg md:text-xl leading-relaxed font-medium italic relative z-10 pl-2">
                                    {{ profile || `Karang Taruna ${$page.props.settings?.nama_wilayah || '[Nama Wilayah]'} merupakan wadah pengembangan generasi muda yang tumbuh dari, oleh, dan untuk masyarakat, terutama dalam bidang kesejahteraan sosial dan kewirausahaan.` }}
                                </p>
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div v-if="tasks && tasks.length > 0" class="flex-grow pt-8 border-t border-slate-100">
                            <h3
                                class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                                Program Kerja & Prioritas
                            </h3>
                            <div class="grid grid-cols-1 gap-4">
                                <div v-for="(task, index) in tasks" :key="index"
                                    class="flex items-start gap-5 p-6 bg-white rounded-3xl border border-slate-100 hover:border-orange-200 hover:shadow-2xl hover:shadow-orange-900/5 transition-all group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center text-lg font-black group-hover:bg-orange-600 group-hover:text-white transition-all shrink-0">
                                        {{ String(index + 1).padStart(2, '0') }}
                                    </div>
                                    <div class="pt-1">
                                        <p class="text-slate-800 text-sm font-bold leading-relaxed">{{ task }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Structure Section -->
        <section id="members" class="py-24 bg-slate-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="mb-16 space-y-8">
                    <div class="text-center">
                        <span
                            class="text-orange-600 font-black text-[10px] uppercase tracking-[0.3em] mb-3 block">Semangat
                            Kepemudaan</span>
                        <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter">Struktur <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">Kepengurusan</span>
                        </h2>
                    </div>

                    <!-- Category Filter Row -->
                    <div class="flex justify-center">
                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar max-w-full pb-2 md:pb-0">
                            <button v-for="bidang in bidangList" :key="bidang" @click="activeBidang = bidang"
                                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 whitespace-nowrap shrink-0"
                                :class="activeBidang === bidang
                                    ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20'
                                    : 'bg-white text-slate-500 hover:bg-orange-50 hover:text-orange-600 border border-slate-100 shadow-sm'">
                                {{ bidang }}
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="filteredMembers.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="member in filteredMembers" :key="member.id"
                        class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group relative">
                        <!-- Bidang Badge Overlay -->
                        <div
                            class="absolute top-6 right-6 px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-[8px] font-black uppercase tracking-widest z-10">
                            {{ member.bidang || 'Anggota' }}
                        </div>

                        <div class="relative w-32 h-32 mx-auto mb-8">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-orange-100 to-orange-50 rounded-[2.5rem] rotate-6 group-hover:rotate-12 transition-transform duration-500">
                            </div>
                            <div
                                class="relative w-full h-full rounded-[2.5rem] overflow-hidden shadow-lg border-4 border-white">
                                <img :src="member.foto ? '/storage/' + member.foto : 'https://placehold.co/400x400?text=No+Photo'"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            </div>
                        </div>

                        <div class="text-center">
                            <h3
                                class="text-lg font-black text-slate-900 group-hover:text-orange-600 transition-colors uppercase tracking-tight mb-2 px-2 truncate">
                                {{ member.nama }}
                            </h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">
                                {{ member.jabatan }}
                            </p>

                            <a v-if="member.no_hp" :href="'https://wa.me/' + formatPhone(member.no_hp)" target="_blank"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all w-full justify-center group/btn shadow-lg shadow-slate-900/10">
                                <i class="fab fa-whatsapp text-sm group-hover/btn:rotate-12 transition-transform"></i>
                                Hubungi Pemuda
                            </a>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-32 bg-white rounded-[3rem] border border-slate-100">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                        <i class="fas fa-users-slash text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">Kategori ini belum memiliki
                        data.</h3>
                </div>
            </div>
        </section>

        <!-- Youth Value Section -->
        <section class="py-24 bg-orange-600 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white transform rotate-12 opacity-5 rounded-[10rem]">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="max-w-3xl mx-auto text-white">
                    <h2 class="text-5xl font-black uppercase tracking-tighter mb-6 leading-none italic">
                        "Muda Berkarya, Berdaya Untuk <span
                            class="text-orange-200 underline decoration-4 underline-offset-8">Indonesia</span>"
                    </h2>
                    <p class="text-orange-100 font-bold text-lg leading-relaxed mb-12">
                        Kami percaya bahwa kreativitas tanpa batas dan kolaborasi yang kuat adalah kunci utama
                        transformasi positif bagi lingkungan sekitar kita.
                    </p>
                    <div class="flex flex-wrap justify-center gap-12">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-bolt text-4xl mb-4 text-orange-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em]">Cepat Tanggap</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <i class="fas fa-lightbulb text-4xl mb-4 text-orange-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em]">Solutif</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <i class="fas fa-handshake text-4xl mb-4 text-orange-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em]">Kolaboratif</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
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
    background: #ea580c;
    /* orange-600 */
    border-radius: 10px;
}
</style>
