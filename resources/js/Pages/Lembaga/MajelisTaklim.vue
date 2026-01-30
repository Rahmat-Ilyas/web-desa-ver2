<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    members: Array,
    profile: String,
    activities: Array
});

const activeKategori = ref('Semua');
const kategoris = ['Semua', 'Induk', 'Remaja', 'Ibu-ibu', 'Bapak-bapak'];

const filteredMembers = computed(() => {
    if (activeKategori.value === 'Semua') return props.members;
    return props.members.filter(m => m.kategori === activeKategori.value);
});

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : `https://placehold.co/100x120?text=No+Photo`;
};

const formatPhone = (number) => {
    if (!number) return '';
    let n = number.toString().replace(/\D/g, '');
    if (n.startsWith('0')) return '62' + n.slice(1);
    if (n.startsWith('62')) return n;
    return '62' + n;
};

const FALLBACK_ICONS = [
    'fa-quran', 'fa-mosque', 'fa-hand-holding-heart', 'fa-pray', 'fa-book-open',
    'fa-users', 'fa-star-and-crescent', 'fa-kaaba', 'fa-heart', 'fa-moon'
];

const currentActivities = computed(() => {
    if (!props.activities || props.activities.length === 0) {
        return [
            { name: "Pengajian rutin mingguan.", icon: "fa-quran" },
            { name: "Peringatan Hari Besar Islam (PHBI).", icon: "fa-mosque" },
            { name: "Santunan anak yatim dan dhuafa.", icon: "fa-hand-holding-heart" },
            { name: "Pelatihan pemulasaraan jenazah.", icon: "fa-pray" }
        ];
    }

    return props.activities.map((p, i) => {
        if (typeof p === 'string') {
            return { name: p, icon: FALLBACK_ICONS[i] || 'fa-star' };
        }
        return p;
    });
});
</script>

<template>

    <Head title="Lembaga Majelis Taklim" />

    <MainLayout>
        <!-- Hero Section (Standardized with PKK) -->
        <div class="bg-emerald-800 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-white/20 backdrop-blur-md border border-white/30 mb-8 text-white shadow-2xl rotate-3 group-hover:rotate-0 transition-transform">
                    <i class="fas fa-quran text-4xl"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-4">Majelis Taklim</h1>
                <p class="text-emerald-100 text-xl max-w-2xl mx-auto font-medium">Pusat pembinaan keagamaan dan
                    penguatan ukhuwah islamiyah {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-emerald-400/20 rounded-full blur-2xl"></div>
        </div>

        <!-- Section 1: Unique Profile Layout (Full Width Story) -->
        <section id="profil" class="py-32 bg-slate-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    <div class="w-full lg:w-1/2">
                        <div class="relative">
                            <!-- Artistic Frame -->
                            <div
                                class="absolute -inset-4 border-2 border-dashed border-emerald-200 rounded-[4rem] group-hover:rotate-1 transition-transform">
                            </div>
                            <div class="relative aspect-[4/3] rounded-[3.5rem] overflow-hidden shadow-2xl">
                                <img :src="$page.props.settings?.cover_majelis_taklim || '/assets/images/lembaga/majelis_taklim_profile.png'"
                                    class="w-full h-full object-cover" alt="Kajian">
                                <div class="absolute inset-0 bg-emerald-900/40 mix-blend-multiply"></div>
                                <div class="absolute inset-0 p-12 flex flex-col justify-end text-white">
                                    <h4 class="text-3xl font-black uppercase tracking-tighter mb-2 italic">Ukhuwah
                                        Islamiyah</h4>
                                    <p class="text-emerald-50 text-sm font-bold opacity-80">Mempererat tali silaturahmi
                                        antar umat di {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 space-y-8">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-sm">
                                    <i class="fas fa-book-reader"></i>
                                </div>
                                <span
                                    class="text-emerald-600 font-black text-[10px] uppercase tracking-[0.5em]">Tholabul
                                    Ilmi</span>
                            </div>
                            <h2
                                class="text-4xl md:text-5xl font-black text-slate-900 leading-none tracking-tighter uppercase mb-6">
                                Membina <span class="text-emerald-700">Masyarakat</span> Berbasis Nilai-Nilai Mulia.
                            </h2>
                            <div class="relative">
                                <div class="absolute -left-6 top-0 text-emerald-100 text-6xl font-serif">“</div>
                                <p
                                    class="text-slate-600 text-lg md:text-xl leading-relaxed font-medium italic relative z-10 pl-2">
                                    {{ profile || `Majelis Taklim ${$page.props.settings?.nama_wilayah || '[Nama Wilayah]'} hadir sebagai cahaya bagi masyarakat,
                                    menjadi tempat di mana ilmu agama disampaikan secara murni, hati dilembutkan dengan
                                    dzikir, dan kepedulian sosial dipraktikkan secara nyata.` }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                            <div
                                class="flex items-center gap-4 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div
                                    class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shrink-0">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <span class="text-sm font-black text-slate-700 uppercase leading-tight">Penguatan
                                    Aqidah</span>
                            </div>
                            <div
                                class="flex items-center gap-4 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div
                                    class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shrink-0">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <span class="text-sm font-black text-slate-700 uppercase leading-tight">Kepedulian
                                    Sosial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Mosaic Kegiatan (Timeline-Like Vertical flow) -->
        <section class="py-32 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 uppercase tracking-tighter mb-6">Agenda
                        <span class="text-emerald-700">Dakwah</span> & Amal
                    </h2>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Membangun peradaban melalui
                        kegiatan nyata</p>
                </div>

                <div class="relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-1/2 top-0 bottom-0 w-px bg-emerald-100 hidden lg:block"></div>

                    <div class="space-y-12">
                        <div v-for="(act, i) in currentActivities" :key="i"
                            class="relative flex flex-col lg:flex-row items-center group">
                            <!-- Left Content (Odd) -->
                            <div
                                :class="['w-full lg:w-1/2 text-center lg:text-right px-8 lg:px-16 order-2', i % 2 === 0 ? 'lg:order-1' : 'lg:order-2 lg:text-left']">
                                <h3
                                    class="text-2xl font-black text-slate-900 uppercase tracking-tighter mb-3 group-hover:text-emerald-700 transition-colors">
                                    {{ act.name }}</h3>
                                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Program Rutin {{ i
                                    + 1 }}</p>
                            </div>

                            <!-- Center Icon -->
                            <div class="relative z-10 w-16 h-16 bg-white border-4 border-slate-50 rounded-full flex items-center justify-center text-xl shadow-xl group-hover:scale-110 transition-transform order-1 lg:order-2 my-6 lg:my-0"
                                :class="i % 2 === 0 ? 'text-emerald-600' : 'text-amber-500'">
                                <i :class="['fas', act.icon || 'fa-star']"></i>
                            </div>

                            <!-- Right Content (Even) -->
                            <div
                                :class="['w-full lg:w-1/2 px-8 lg:px-16 order-3', i % 2 === 0 ? 'lg:order-3' : 'lg:order-1']">
                                <div class="hidden lg:block"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Member Gallery (Arch Style Tabs + Floating Cards) -->
        <section id="members" class="py-32 bg-emerald-950 relative overflow-hidden">
            <!-- Background Decoration -->
            <div
                class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/pinstriped-suit.png')]">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-20 space-y-6">
                    <span class="text-amber-400 font-black text-[10px] uppercase tracking-[0.6em] block">Keluarga
                        Besar</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter">Pilar <span
                            class="text-amber-400">Kepengurusan</span></h2>

                    <div class="flex flex-wrap justify-center gap-2 mt-8">
                        <button v-for="kat in kategoris" :key="kat" @click="activeKategori = kat"
                            class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95"
                            :class="activeKategori === kat
                                ? 'bg-amber-500 text-emerald-950 shadow-lg'
                                : 'bg-white/5 text-emerald-100 hover:bg-white/10 border border-white/10'">
                            {{ kat }}
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    <transition-group enter-active-class="transition duration-500 ease-out"
                        enter-from-class="opacity-0 translate-y-10" enter-to-class="opacity-100 translate-y-0"
                        leave-active-class="transition duration-300 ease-in absolute" leave-from-class="opacity-100"
                        leave-to-class="opacity-0 scale-95">
                        <div v-for="member in filteredMembers" :key="member.id"
                            class="group relative bg-emerald-900/50 backdrop-blur-sm border border-emerald-400/20 rounded-[4rem] rounded-t-full p-8 text-center hover:bg-emerald-900 transition-all duration-500">

                            <!-- Arch Shape Image Frame -->
                            <div
                                class="relative w-40 h-52 mx-auto mb-6 rounded-t-full rounded-b-3xl overflow-hidden border-4 border-emerald-800 shadow-2xl">
                                <img :src="getPhotoUrl(member.foto)" :alt="member.nama"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                <div
                                    class="absolute inset-0 bg-emerald-950/20 group-hover:opacity-0 transition-opacity">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-1">{{
                                    member.jabatan }}</div>
                                <h4 class="text-xl font-black text-white uppercase tracking-tighter mb-4">{{ member.nama
                                    }}</h4>

                                <a v-if="member.no_hp" :href="'https://wa.me/' + formatPhone(member.no_hp)"
                                    target="_blank"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-700 text-emerald-100 hover:bg-emerald-500 hover:text-white transition-all shadow-lg border border-emerald-400/20">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </transition-group>
                </div>

                <div v-if="filteredMembers.length === 0" class="py-20 text-center text-emerald-200/50">
                    <i class="fas fa-users text-4xl mb-4 opacity-20"></i>
                    <p class="font-black text-xs uppercase tracking-widest">Belum ada data tersedia</p>
                </div>
            </div>
        </section>

        <!-- Final Call to Wisdom -->
        <section class="py-32 bg-white text-center relative overflow-hidden">
            <div
                class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/islamic-exercise.png')]">
            </div>

            <div class="max-w-4xl mx-auto px-4 relative z-10">
                <i class="fas fa-kaaba text-5xl text-emerald-800 mb-8"></i>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 uppercase tracking-tighter mb-8 italic">
                    "Sebaik-baik manusia adalah yang paling bermanfaat bagi sesama."</h2>
                <p class="text-slate-500 text-xl font-medium leading-relaxed mb-12">Mari bergabung dan menjadi bagian
                    dari syiar islam yang rahmatan lil 'alamin di {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah || '[Nama Wilayah]' }}.</p>

                <div class="flex flex-wrap justify-center gap-12 pt-10 border-t border-slate-100">
                    <div class="text-center">
                        <div class="text-4xl font-black text-emerald-800 mb-2">Pilar</div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kebajikan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-emerald-800 mb-2">Cahaya</div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Hidayah</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-black text-emerald-800 mb-2">Simpul</div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ukhuwah</div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
