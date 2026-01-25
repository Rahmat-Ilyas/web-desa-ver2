<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, watch } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
    latestGaleris: {
        type: Array,
        default: () => []
    }
});

const showingNavigationDropdown = ref(false);
const scrolled = ref(false);

const handleScroll = () => {
    scrolled.value = window.scrollY > 20;
};

// Mobile Accordion State
const activeMobileSection = ref(null);

const toggleMobileSection = (section) => {
    if (activeMobileSection.value === section) {
        activeMobileSection.value = null;
    } else {
        activeMobileSection.value = section;
    }
};

// Lock body scroll when mobile menu is open
watch(showingNavigationDropdown, (value) => {
    if (value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.body.style.overflow = '';
});
</script>

<template>
    <div class="font-sans antialiased text-gray-900 bg-gray-50 min-h-screen flex flex-col">

        <!-- Top Utility Bar -->
        <div class="bg-blue-900 text-white py-2 text-xs font-medium">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ new Date().toLocaleDateString('id-ID', {
                            weekday: 'long', year: 'numeric', month: 'long',
                            day: 'numeric'
                        }) }}
                    </span>
                    <span v-if="$page.props.settings?.info_umum?.whatsapp"
                        class="hidden sm:inline-flex items-center gap-2">
                        <i class="fas fa-phone-alt text-[10px]"></i>
                        {{ $page.props.settings.info_umum.telepon }}
                    </span>
                    <span v-if="$page.props.settings?.info_umum?.email"
                        class="hidden lg:inline-flex items-center gap-2 ml-4 border-l border-white/20 pl-4">
                        <i class="fas fa-envelope text-[10px]"></i>
                        {{ $page.props.settings.info_umum.email }}
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <a v-if="$page.props.settings?.sosial_media?.facebook"
                        :href="$page.props.settings.sosial_media.facebook" target="_blank"
                        class="flex items-center gap-1.5 hover:text-blue-200 transition-colors group" title="Facebook">
                        <i class="fab fa-facebook text-sm group-hover:text-blue-400"></i>
                        <span class="hidden md:inline">Facebook</span>
                    </a>
                    <a v-if="$page.props.settings?.sosial_media?.instagram"
                        :href="$page.props.settings.sosial_media.instagram" target="_blank"
                        class="flex items-center gap-1.5 hover:text-pink-200 transition-colors group" title="Instagram">
                        <i class="fab fa-instagram text-sm group-hover:text-pink-400"></i>
                        <span class="hidden md:inline">Instagram</span>
                    </a>
                    <a v-if="$page.props.settings?.sosial_media?.twitter"
                        :href="$page.props.settings.sosial_media.twitter" target="_blank"
                        class="flex items-center gap-1.5 hover:text-slate-200 transition-colors group" title="Twitter / X">
                        <i class="fab fa-x-twitter text-sm group-hover:text-slate-400"></i>
                        <span class="hidden md:inline">Twitter</span>
                    </a>
                    <a v-if="$page.props.settings?.sosial_media?.youtube"
                        :href="$page.props.settings.sosial_media.youtube" target="_blank"
                        class="flex items-center gap-1.5 hover:text-red-200 transition-colors group" title="YouTube">
                        <i class="fab fa-youtube text-sm group-hover:text-red-500"></i>
                        <span class="hidden md:inline">YouTube</span>
                    </a>
                    <a v-if="$page.props.settings?.info_umum?.whatsapp" 
                        :href="'https://wa.me/' + $page.props.settings.info_umum.whatsapp" target="_blank"
                        class="flex items-center gap-1.5 hover:text-green-200 transition-colors group" title="WhatsApp">
                        <i class="fab fa-whatsapp text-sm group-hover:text-green-500"></i>
                        <span class="hidden md:inline">WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sticky Navbar -->
        <nav class="sticky top-0 z-50 transition-all duration-300 ease-in-out border-b border-gray-100"
            :class="[scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-2' : 'bg-white py-4 shadow-sm']">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center transition-all duration-300"
                    :class="[scrolled ? 'h-16' : 'h-20']">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center gap-3">
                            <Link :href="route('landing')" class="group flex items-center gap-3">
                                <img class="h-12 w-auto transition-transform duration-300 group-hover:scale-105"
                                    src="/assets/images/icons/logo.png" alt="Logo Kelurahan"
                                    onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'" />
                                <div class="flex flex-col">
                                    <h1
                                        class="text-[11px] sm:text-sm font-bold text-gray-800 leading-tight uppercase tracking-wide group-hover:text-blue-600 transition-colors">
                                        KEL. UJUNG SABBANG</h1>
                                    <p class="text-[9px] sm:text-[10px] text-gray-500 font-medium tracking-wider">KOTA
                                        PAREPARE</p>
                                </div>
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-2 sm:space-x-4 xl:space-x-6 sm:-my-px sm:ml-10 lg:flex items-center">
                            <NavLink :href="route('landing')" :active="route().current('landing')">
                                HOME
                            </NavLink>

                            <!-- Profil Dropdown -->
                            <div class="hidden sm:flex sm:items-center">
                                <div class="relative">
                                    <Dropdown align="left" width="64" trigger="hover">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" :class="[
                                                    'group inline-flex items-center px-3 py-2 text-sm leading-4 font-bold tracking-wide rounded-md transition ease-in-out duration-150 focus:outline-none bg-transparent',
                                                    route().current('profil.*') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600'
                                                ]">
                                                    PROFIL
                                                    <svg :class="['ml-1 -mr-0.5 h-4 w-4 transition-colors', route().current('profil.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500']"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div
                                                class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                                                Tentang Kami</div>
                                            <DropdownLink :href="route('profil.sambutan')">
                                                <i
                                                    class="fas fa-bullhorn w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Sambutan Lurah
                                            </DropdownLink>
                                            <DropdownLink :href="route('profil.visimisi')">
                                                <i
                                                    class="fas fa-bullseye w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Visi & Misi
                                            </DropdownLink>
                                            <DropdownLink :href="route('profil.sejarah')">
                                                <i
                                                    class="fas fa-history w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Sejarah Kelurahan
                                            </DropdownLink>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <div
                                                class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                                                Geografis</div>
                                            <DropdownLink :href="route('profil.kondisi')">
                                                <i
                                                    class="fas fa-map-marked-alt w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Kondisi Kelurahan
                                            </DropdownLink>
                                            <DropdownLink :href="route('profil.lokasi-kantor')">
                                                <i
                                                    class="fas fa-building w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Lokasi Kantor
                                            </DropdownLink>
                                            <DropdownLink :href="route('profil.peta-lokasi')">
                                                <i
                                                    class="fas fa-map w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Peta Lokasi
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Lembaga Dropdown -->
                            <div class="hidden sm:flex sm:items-center">
                                <div class="relative">
                                    <Dropdown align="left" width="56" trigger="hover">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" :class="[
                                                    'group inline-flex items-center px-3 py-2 text-sm leading-4 font-bold tracking-wide rounded-md transition ease-in-out duration-150 focus:outline-none bg-transparent',
                                                    route().current('lembaga.*') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600'
                                                ]">
                                                    LEMBAGA
                                                    <svg :class="['ml-1 -mr-0.5 h-4 w-4 transition-colors', route().current('lembaga.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500']"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('lembaga.rw')">
                                                <i
                                                    class="fas fa-users-cog w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Rukun Warga (RW)
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.rt')">
                                                <i
                                                    class="fas fa-users w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Rukun Tetangga (RT)
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.lpmk')">
                                                <i
                                                    class="fas fa-hands-helping w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                LPMK
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.pkk')">
                                                <i
                                                    class="fas fa-hand-holding-heart w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                PKK
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.karang-taruna')">
                                                <i
                                                    class="fas fa-fist-raised w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Karang Taruna
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.majelis-taklim')">
                                                <i
                                                    class="fas fa-quran w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Majelis Taklim
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <NavLink :href="route('pemerintahan.aparatur')"
                                :active="route().current('pemerintahan.aparatur')">
                                APARATUR
                            </NavLink>

                            <NavLink :href="route('pemerintahan.anggaran')"
                                :active="route().current('pemerintahan.anggaran')">
                                ANGGARAN
                            </NavLink>


                            <!-- Data Penduduk Dropdown -->
                            <div class="hidden sm:flex sm:items-center">
                                <div class="relative">
                                    <Dropdown align="left" width="64" trigger="hover">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" :class="[
                                                    'group inline-flex items-center px-3 py-2 text-sm leading-4 font-bold tracking-wide rounded-md transition ease-in-out duration-150 focus:outline-none bg-transparent',
                                                    route().current('data.*') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600'
                                                ]">
                                                    DATA
                                                    <svg :class="['ml-1 -mr-0.5 h-4 w-4 transition-colors', route().current('data.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500']"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('data.statistik')">
                                                <i
                                                    class="fas fa-chart-pie w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Statistik Penduduk
                                            </DropdownLink>
                                            <DropdownLink :href="route('data.umur')">
                                                <i
                                                    class="fas fa-user-clock w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Berdasarkan Umur
                                            </DropdownLink>
                                            <DropdownLink :href="route('data.pemilih')">
                                                <i
                                                    class="fas fa-vote-yea w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Pemilih Tetap
                                            </DropdownLink>
                                            <DropdownLink :href="route('data.agama')">
                                                <i
                                                    class="fas fa-praying-hands w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Statistik Agama
                                            </DropdownLink>
                                            <DropdownLink :href="route('data.pendidikan')">
                                                <i
                                                    class="fas fa-graduation-cap w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Statistik Pendidikan
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <NavLink :href="route('galeri')" :active="route().current('galeri')">
                                GALERI
                            </NavLink>

                            <NavLink :href="route('download')" :active="route().current('download')">
                                DOWNLOAD
                            </NavLink>

                            <!-- Informasi Dropdown -->
                            <div class="hidden sm:flex sm:items-center">
                                <div class="relative">
                                    <Dropdown align="right" width="48" trigger="hover">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button type="button" :class="[
                                                    'group inline-flex items-center px-3 py-2 text-sm leading-4 font-bold tracking-wide rounded-md transition ease-in-out duration-150 focus:outline-none bg-transparent',
                                                    route().current('informasi.*') ? 'text-blue-600' : 'text-gray-600 hover:text-blue-600'
                                                ]">
                                                    INFORMASI
                                                    <svg :class="['ml-1 -mr-0.5 h-4 w-4 transition-colors', route().current('informasi.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500']"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('informasi.berita')">
                                                <i
                                                    class="fas fa-newspaper w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Berita
                                            </DropdownLink>
                                            <DropdownLink :href="route('informasi.potensi')">
                                                <i
                                                    class="fas fa-tree w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Potensi
                                            </DropdownLink>
                                            <DropdownLink :href="route('informasi.program')">
                                                <i
                                                    class="fas fa-tasks w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Program
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Modern Hamburger -->
                    <div class="-mr-2 flex items-center lg:hidden">
                        <button @click="showingNavigationDropdown = true"
                            class="inline-flex items-center justify-center p-2.5 rounded-xl bg-white border border-gray-100 text-slate-500 hover:text-blue-600 hover:bg-slate-50 shadow-sm transition-all active:scale-90 focus:outline-none">
                            <i class="fa-solid fa-bars-staggered text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

        </nav>

        <!-- Modern Mobile Sidebar/Drawer -->
        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="showingNavigationDropdown"
                class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm lg:hidden"
                @click="showingNavigationDropdown = false">
            </div>
        </transition>

        <transition enter-active-class="transition ease-in-out duration-500 transform"
            enter-from-class="-translate-x-full" enter-to-class="translate-x-0"
            leave-active-class="transition ease-in-out duration-500 transform" leave-from-class="translate-x-0"
            leave-to-class="-translate-x-full">
            <div v-show="showingNavigationDropdown"
                class="fixed inset-y-0 left-0 z-[60] w-full max-w-xs h-[100dvh] bg-white shadow-2xl flex flex-col lg:hidden overflow-hidden">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-slate-50">
                    <div class="flex items-center gap-3">
                        <img class="h-10 w-auto" src="/assets/images/icons/logo.png" alt="Logo" />
                        <div>
                            <h2 class="text-sm font-black text-slate-800 leading-tight">UJUNG SABBANG</h2>
                            <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Official
                                Portal</p>
                        </div>
                    </div>
                    <button @click="showingNavigationDropdown = false"
                        class="p-2 rounded-xl bg-white border border-gray-100 text-slate-400 hover:text-slate-600 shadow-sm transition-all active:scale-95">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto px-4 py-6">
                    <nav class="space-y-4">
                        <!-- Beranda -->
                        <Link :href="route('landing')"
                            :class="[route().current('landing') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                            <i class="fa-solid fa-house fa-fw mr-3 text-lg opacity-70"></i>
                            Beranda
                        </Link>

                        <!-- Profil Accordion -->
                        <div class="space-y-1">
                            <button @click="toggleMobileSection('profil')"
                                :class="[route().current('profil.*') ? 'text-blue-600' : 'text-slate-600', 'w-full group flex items-center justify-between px-4 py-3 text-sm font-bold rounded-2xl hover:bg-slate-50 transition-all']">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-building-user fa-fw mr-3 text-lg opacity-70"></i>
                                    Profil
                                </div>
                                <i
                                    :class="['fa-solid fa-chevron-down text-xs transition-transform duration-300', activeMobileSection === 'profil' ? 'rotate-180' : '']"></i>
                            </button>
                            <div v-show="activeMobileSection === 'profil'"
                                class="pl-12 pr-4 space-y-1 overflow-hidden transition-all">
                                <Link :href="route('profil.sambutan')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Sambutan
                                    Lurah
                                </Link>
                                <Link :href="route('profil.visimisi')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Visi &
                                    Misi</Link>
                                <Link :href="route('profil.sejarah')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Sejarah
                                    Kelurahan
                                </Link>
                                <Link :href="route('profil.kondisi')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Kondisi
                                    Kelurahan
                                </Link>
                                <Link :href="route('profil.lokasi-kantor')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Lokasi
                                    Kantor
                                </Link>
                                <Link :href="route('profil.peta-lokasi')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Peta
                                    Lokasi</Link>
                            </div>
                        </div>

                        <!-- Lembaga Accordion -->
                        <div class="space-y-1">
                            <button @click="toggleMobileSection('lembaga')"
                                :class="[route().current('lembaga.*') ? 'text-blue-600' : 'text-slate-600', 'w-full group flex items-center justify-between px-4 py-3 text-sm font-bold rounded-2xl hover:bg-slate-50 transition-all']">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-sitemap fa-fw mr-3 text-lg opacity-70"></i>
                                    Lembaga
                                </div>
                                <i
                                    :class="['fa-solid fa-chevron-down text-xs transition-transform duration-300', activeMobileSection === 'lembaga' ? 'rotate-180' : '']"></i>
                            </button>
                            <div v-show="activeMobileSection === 'lembaga'" class="pl-12 pr-4 space-y-1 transition-all">
                                <Link :href="route('lembaga.rw')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Rukun
                                    Warga (RW)
                                </Link>
                                <Link :href="route('lembaga.rt')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Rukun
                                    Tetangga (RT)</Link>
                                <Link :href="route('lembaga.pkk')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">
                                    PKK
                                </Link>
                                <Link :href="route('lembaga.karang-taruna')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">
                                    Karang Taruna
                                </Link>
                                <Link :href="route('lembaga.lpmk')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">LPMK
                                </Link>
                                <Link :href="route('lembaga.majelis-taklim')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Majelis
                                    Taklim
                                </Link>
                            </div>
                        </div>

                        <!-- Aparatur -->
                        <Link :href="route('pemerintahan.aparatur')"
                            :class="[route().current('pemerintahan.aparatur') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                            <i class="fa-solid fa-users-gear fa-fw mr-3 text-lg opacity-70"></i>
                            Aparatur
                        </Link>

                        <!-- Anggaran -->
                        <Link :href="route('pemerintahan.anggaran')"
                            :class="[route().current('pemerintahan.anggaran') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                            <i class="fa-solid fa-chart-line fa-fw mr-3 text-lg opacity-70"></i>
                            Anggaran
                        </Link>

                        <!-- Data Accordion -->
                        <div class="space-y-1">
                            <button @click="toggleMobileSection('data')"
                                :class="[route().current('data.*') ? 'text-blue-600' : 'text-slate-600', 'w-full group flex items-center justify-between px-4 py-3 text-sm font-bold rounded-2xl hover:bg-slate-50 transition-all']">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-chart-pie fa-fw mr-3 text-lg opacity-70"></i>
                                    Data
                                </div>
                                <i
                                    :class="['fa-solid fa-chevron-down text-xs transition-transform duration-300', activeMobileSection === 'data' ? 'rotate-180' : '']"></i>
                            </button>
                            <div v-show="activeMobileSection === 'data'" class="pl-12 pr-4 space-y-1 transition-all">
                                <Link :href="route('data.statistik')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Statistik
                                    Penduduk
                                </Link>
                                <Link :href="route('data.umur')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">
                                    Berdasarkan Umur
                                </Link>
                                <Link :href="route('data.pemilih')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Pemilih
                                    Tetap
                                </Link>
                                <Link :href="route('data.agama')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Statistik
                                    Agama
                                </Link>
                                <Link :href="route('data.pendidikan')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Statistik
                                    Pendidikan</Link>
                            </div>
                        </div>

                        <!-- Galeri -->
                        <Link :href="route('galeri')"
                            :class="[route().current('galeri') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                            <i class="fa-solid fa-camera-retro fa-fw mr-3 text-lg opacity-70"></i>
                            Galeri
                        </Link>

                        <!-- Download -->
                        <Link :href="route('download')"
                            :class="[route().current('download') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                            <i class="fa-solid fa-download fa-fw mr-3 text-lg opacity-70"></i>
                            Download
                        </Link>

                        <!-- Informasi Accordion -->
                        <div class="space-y-1">
                            <button @click="toggleMobileSection('informasi')"
                                :class="[route().current('informasi.*') ? 'text-blue-600' : 'text-slate-600', 'w-full group flex items-center justify-between px-4 py-3 text-sm font-bold rounded-2xl hover:bg-slate-50 transition-all']">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-circle-info fa-fw mr-3 text-lg opacity-70"></i>
                                    Informasi
                                </div>
                                <i
                                    :class="['fa-solid fa-chevron-down text-xs transition-transform duration-300', activeMobileSection === 'informasi' ? 'rotate-180' : '']"></i>
                            </button>
                            <div v-show="activeMobileSection === 'informasi'"
                                class="pl-12 pr-4 space-y-1 transition-all">
                                <Link :href="route('informasi.berita')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Berita
                                </Link>
                                <Link :href="route('informasi.potensi')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Potensi
                                </Link>
                                <Link :href="route('informasi.program')"
                                    class="block py-2 text-sm font-medium text-slate-500 hover:text-blue-600">Program
                                </Link>
                            </div>
                        </div>

                    </nav>
                </div>

                <!-- Fixed Action: Layanan (Always Visible) -->
                <div class="px-6 py-4 border-t border-slate-50">
                    <Link :href="route('layanan')"
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 group transition-all active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center text-white">
                                <i class="fa-solid fa-hand-holding-heart"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] font-bold text-white/70 uppercase tracking-widest">
                                    Akses</p>
                                <p class="text-sm font-black text-white">Layanan Mandiri</p>
                            </div>
                        </div>
                        <i
                            class="fa-solid fa-chevron-right text-white/50 group-hover:translate-x-1 transition-transform"></i>
                    </Link>
                </div>

                <!-- Sidebar Footer -->
                <div class="p-6 bg-slate-50 border-t border-gray-100">
                    <div class="flex items-center justify-center gap-3 mb-6">
                        <a v-if="$page.props.settings?.sosial_media?.facebook" :href="$page.props.settings.sosial_media.facebook" target="_blank"
                            class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-[#1877F2] shadow-sm transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a v-if="$page.props.settings?.sosial_media?.instagram" :href="$page.props.settings.sosial_media.instagram" target="_blank"
                            class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-[#E4405F] shadow-sm transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a v-if="$page.props.settings?.sosial_media?.twitter" :href="$page.props.settings.sosial_media.twitter" target="_blank"
                            class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-black shadow-sm transition-all">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a v-if="$page.props.settings?.sosial_media?.youtube" :href="$page.props.settings.sosial_media.youtube" target="_blank"
                            class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-[#FF0000] shadow-sm transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a v-if="$page.props.settings?.info_umum?.whatsapp" :href="'https://wa.me/' + $page.props.settings.info_umum.whatsapp" target="_blank"
                            class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-[#25D366] shadow-sm transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                    <p class="text-[10px] text-center font-bold text-slate-400 uppercase tracking-widest">&copy;
                        2026 Admin
                        Portal</p>
                </div>
            </div>
        </transition>

        <!-- Page Content -->
        <main class="flex-grow">
            <slot />
        </main>


        <!-- Footer -->
        <footer class="bg-gray-800 text-white pt-10 pb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Identity -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <img class="h-12 w-auto" src="/assets/images/icons/logo.png" alt="Logo"
                                onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'" />
                            <div>
                                <h3 class="text-md font-bold text-white leading-tight">KEL. UJUNG SABBANG</h3>
                                <p class="text-xs text-gray-400">Kota Parepare</p>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Kel. Ujung Sabbang adalah kelurahan yang terletak di Kecamatan Ujung, Kota Parepare,
                            Sulawesi
                            Selatan, Indonesia.
                        </p>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2 inline-block">Hubungi Kami
                        </h3>
                        <ul class="space-y-3 text-gray-400 text-sm">
                            <li v-if="$page.props.settings?.info_umum?.alamat" class="flex items-start gap-3">
                                <i class="fas fa-map-marker-alt w-5 h-5 mt-1 text-blue-500"></i>
                                <span>{{ $page.props.settings.info_umum.alamat }}</span>
                            </li>
                            <li v-if="$page.props.settings?.info_umum?.telepon" class="flex items-center gap-3">
                                <i class="fas fa-phone-alt w-5 h-5 text-blue-500"></i>
                                <span>{{ $page.props.settings.info_umum.telepon }}</span>
                            </li>
                            <li v-if="$page.props.settings?.info_umum?.whatsapp" class="flex items-center gap-3">
                                <i class="fab fa-whatsapp w-5 h-5 text-blue-500 text-lg"></i>
                                <span>{{ $page.props.settings.info_umum.whatsapp }} (WA)</span>
                            </li>
                            <li v-if="$page.props.settings?.info_umum?.email" class="flex items-center gap-3">
                                <i class="fas fa-envelope w-5 h-5 text-blue-500"></i>
                                <span>{{ $page.props.settings.info_umum.email }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Gallery Preview -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2 inline-block">Galeri Terbaru
                        </h3>
                        <div class="grid grid-cols-3 gap-2">
                            <template v-if="$page.props.footerGaleris && $page.props.footerGaleris.length > 0">
                                <Link :href="route('galeri')" v-for="item in $page.props.footerGaleris" :key="item.id"
                                    class="h-16 bg-gray-700 rounded-lg bg-cover bg-center hover:opacity-80 transition-opacity border border-gray-600 block"
                                    :style="{ backgroundImage: `url(${item.image})` }" :title="item.judul">
                                </Link>
                            </template>
                            <template v-else>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                                <div
                                    class="h-16 bg-gray-700/50 rounded flex items-center justify-center text-xs text-gray-500 border border-gray-700">
                                    Empty</div>
                            </template>
                        </div>
                    </div>

                    <!-- Socials -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2 inline-block">Ikuti Kami
                        </h3>
                        <div class="flex space-x-4">
                            <a v-if="$page.props.settings?.sosial_media?.facebook" :href="$page.props.settings.sosial_media.facebook" target="_blank" class="text-gray-400 hover:text-[#1877F2] transition-colors" title="Facebook">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a v-if="$page.props.settings?.sosial_media?.instagram" :href="$page.props.settings.sosial_media.instagram" target="_blank" class="text-gray-400 hover:text-[#E4405F] transition-colors" title="Instagram">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a v-if="$page.props.settings?.sosial_media?.twitter" :href="$page.props.settings.sosial_media.twitter" target="_blank" class="text-gray-400 hover:text-white transition-colors" title="Twitter / X">
                                <i class="fab fa-x-twitter text-xl"></i>
                            </a>
                            <a v-if="$page.props.settings?.sosial_media?.youtube" :href="$page.props.settings.sosial_media.youtube" target="_blank" class="text-gray-400 hover:text-[#FF0000] transition-colors" title="YouTube">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                            <a v-if="$page.props.settings?.info_umum?.whatsapp" :href="'https://wa.me/' + $page.props.settings.info_umum.whatsapp" target="_blank" class="text-gray-400 hover:text-[#25D366] transition-colors" title="WhatsApp">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
                    &copy; {{ new Date().getFullYear() }} Kel. Ujung Sabbang, Parepare. Develop by <a
                        href="https://mainsite.web.id" target="_blank" class="text-white font-semibold">Mainsite
                        Studio</a>
                </div>
            </div>
        </footer>
    </div>
</template>
