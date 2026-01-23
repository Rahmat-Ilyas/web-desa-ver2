<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, watch } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const scrolled = ref(false);

const handleScroll = () => {
    scrolled.value = window.scrollY > 20;
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
                    <span class="hidden sm:inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C7.82 21 2 15.18 2 5V5z">
                            </path>
                        </svg>
                        +6285-3333-41194
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="flex items-center gap-1.5 hover:text-blue-200 transition-colors group"
                        title="Facebook">
                        <svg class="w-4 h-4 fill-current group-hover:text-blue-400 transition-colors"
                            viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="hidden md:inline">Facebook</span>
                    </a>
                    <a href="#" class="flex items-center gap-1.5 hover:text-pink-200 transition-colors group"
                        title="Instagram">
                        <svg class="w-4 h-4 fill-current group-hover:text-pink-400 transition-colors"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                        <span class="hidden md:inline">Instagram</span>
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
                                <div class="hidden md:block">
                                    <h1
                                        class="text-sm font-bold text-gray-800 leading-tight uppercase tracking-wide group-hover:text-blue-600 transition-colors">
                                        KEL. UJUNG SABBANG</h1>
                                    <p class="text-[10px] text-gray-500 font-medium tracking-wider">KOTA PAREPARE</p>
                                </div>
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-6 sm:-my-px sm:ml-10 xl:flex items-center">
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
                                            <DropdownLink :href="route('lembaga.rt')">
                                                <i
                                                    class="fas fa-users w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Rukun Tetangga (RT)
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.rw')">
                                                <i
                                                    class="fas fa-users-cog w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Rukun Warga (RW)
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.pkk')">
                                                <i
                                                    class="fas fa-female w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                PKK
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.karang-taruna')">
                                                <i
                                                    class="fas fa-child w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                Karang Taruna
                                            </DropdownLink>
                                            <DropdownLink :href="route('lembaga.lpmk')">
                                                <i
                                                    class="fas fa-hands-helping w-5 text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                                LPMK
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
                    <div class="-mr-2 flex items-center xl:hidden">
                        <button @click="showingNavigationDropdown = true"
                            class="inline-flex items-center justify-center p-2.5 rounded-xl bg-white border border-gray-100 text-slate-500 hover:text-blue-600 hover:bg-slate-50 shadow-sm transition-all active:scale-90 focus:outline-none">
                            <i class="fa-solid fa-bars-staggered text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

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
                    class="fixed inset-y-0 left-0 z-[60] w-full max-w-xs bg-white shadow-2xl flex flex-col lg:hidden overflow-hidden">
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
                        <nav class="space-y-6">
                            <!-- Section: Utama -->
                            <div>
                                <h3 class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                                    Navigasi
                                    Utama</h3>
                                <div class="space-y-1">
                                    <Link :href="route('landing')"
                                        :class="[route().current('landing') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                                        <i class="fa-solid fa-house fa-fw mr-3 text-lg opacity-70"></i>
                                        Beranda
                                    </Link>
                                    <Link :href="route('pemerintahan.aparatur')"
                                        :class="[route().current('pemerintahan.aparatur') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                                        <i class="fa-solid fa-users-gear fa-fw mr-3 text-lg opacity-70"></i>
                                        Aparatur
                                    </Link>
                                    <Link :href="route('pemerintahan.anggaran')"
                                        :class="[route().current('pemerintahan.anggaran') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50', 'group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all']">
                                        <i class="fa-solid fa-chart-line fa-fw mr-3 text-lg opacity-70"></i>
                                        Transparansi Anggaran
                                    </Link>
                                </div>
                            </div>

                            <!-- Section: Informasi Publik -->
                            <div>
                                <h3 class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">
                                    Informasi &
                                    Data</h3>
                                <div class="space-y-1">
                                    <Link :href="route('informasi.berita')"
                                        class="group flex items-center px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 rounded-2xl transition-all">
                                        <i class="fa-solid fa-newspaper fa-fw mr-3 text-lg opacity-70"></i>
                                        Berita Terbaru
                                    </Link>
                                    <Link :href="route('data.statistik')"
                                        class="group flex items-center px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 rounded-2xl transition-all">
                                        <i class="fa-solid fa-chart-pie fa-fw mr-3 text-lg opacity-70"></i>
                                        Statistik Penduduk
                                    </Link>
                                    <Link :href="route('galeri')"
                                        class="group flex items-center px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 rounded-2xl transition-all">
                                        <i class="fa-solid fa-camera-retro fa-fw mr-3 text-lg opacity-70"></i>
                                        Galeri Kegiatan
                                    </Link>
                                </div>
                            </div>

                            <!-- Section: Layanan -->
                            <div class="px-2">
                                <Link :href="route('layanan')"
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl shadow-lg shadow-blue-200 group transition-all active:scale-[0.98]">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center text-white">
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
                        </nav>
                    </div>

                    <!-- Sidebar Footer -->
                    <div class="p-6 bg-slate-50 border-t border-gray-100">
                        <div class="flex items-center justify-center gap-4 mb-6">
                            <a href="#"
                                class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-blue-600 shadow-sm transition-all"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"
                                class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-pink-500 shadow-sm transition-all"><i
                                    class="fa-brands fa-instagram"></i></a>
                            <a href="#"
                                class="w-10 h-10 rounded-2xl bg-white border border-gray-200 flex items-center justify-center text-slate-400 hover:text-green-500 shadow-sm transition-all"><i
                                    class="fa-brands fa-whatsapp"></i></a>
                        </div>
                        <p class="text-[10px] text-center font-bold text-slate-400 uppercase tracking-widest">&copy;
                            2026 Admin
                            Portal</p>
                    </div>
                </div>
            </transition>
        </nav>

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
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Kecamatan Ujung, Kota Parepare, Sulawesi Selatan, Pos 92983</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C7.82 21 2 15.18 2 5V5z">
                                    </path>
                                </svg>
                                <span>+6285-3333-41194</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>kontak@ujung-sabbang.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Gallery Preview (Mockup) -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2 inline-block">Galeri Terbaru
                        </h3>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="h-16 bg-gray-700 rounded bg-cover bg-center"
                                style="background-image: url('https://placehold.co/100x100?text=IMG1')"></div>
                            <div class="h-16 bg-gray-700 rounded bg-cover bg-center"
                                style="background-image: url('https://placehold.co/100x100?text=IMG2')"></div>
                            <div class="h-16 bg-gray-700 rounded bg-cover bg-center"
                                style="background-image: url('https://placehold.co/100x100?text=IMG3')"></div>
                        </div>
                    </div>

                    <!-- Socials -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2 inline-block">Ikuti Kami
                        </h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-4 h-4 fill-current group-hover:text-blue-400 transition-colors"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-4 h-4 fill-current group-hover:text-pink-400 transition-colors"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
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
