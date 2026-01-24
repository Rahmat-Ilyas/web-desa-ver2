<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link, Head, usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(window.innerWidth > 768);
const isUserMenuOpen = ref(false);
const activeDropdown = ref(null);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const toggleUserMenu = () => {
    isUserMenuOpen.value = !isUserMenuOpen.value;
};

const closeUserMenu = (e) => {
    if (isUserMenuOpen.value && !e.target.closest('#user-menu-container')) {
        isUserMenuOpen.value = false;
    }
};

const toggleDropdown = (name) => {
    activeDropdown.value = activeDropdown.value === name ? null : name;
};

onMounted(() => {
    window.addEventListener('click', closeUserMenu);

    // Auto-open dropdown if child route is active
    menus.forEach(menu => {
        if (menu.sub) {
            const hasActiveChild = menu.sub.some(s =>
                s.route !== '#' && (
                    route().current(s.route, s.params) ||
                    (s.route.endsWith('.index') && route().current(s.route.replace('.index', '.*'), s.params))
                )
            );
            if (hasActiveChild) {
                activeDropdown.value = menu.name;
            }
        }
    });

    const handleResize = () => {
        if (window.innerWidth <= 768) {
            isSidebarOpen.value = false;
        } else {
            isSidebarOpen.value = true;
        }
    };
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('click', closeUserMenu);
});

const menus = [
    { name: 'Dashboard', icon: 'fa-th-large', route: 'admin.dashboard' },
    {
        name: 'Konten Profil',
        icon: 'fa-user-tie',
        sub: [
            { name: 'Sambutan Lurah', route: 'admin.sambutan.index' },
            { name: 'Visi & Misi', route: 'admin.visimisi.index' },
            { name: 'Sejarah Kelurahan', route: 'admin.sejarah.index' },
            { name: 'Kondisi Kelurahan', route: 'admin.kondisi.index' },
            { name: 'Struktur Organisasi', route: 'admin.struktur.index' },
        ]
    },
    {
        name: 'Informasi Publik',
        icon: 'fa-newspaper',
        sub: [
            { name: 'Berita & Informasi', route: 'admin.berita.index' },
            { name: 'APBDes / Anggaran', route: 'admin.anggaran.index' },
            { name: 'Pusat Download', route: 'admin.download.index' },
            { name: 'Program Kerja', route: 'admin.program.index' },
            { name: 'Potensi Wilayah', route: 'admin.potensi.index' },
        ]
    },
    {
        name: 'Lembaga',
        icon: 'fa-users-cog',
        sub: [
            { name: 'Rukun Warga (RW)', route: 'admin.rukun-warga.index' },
            { name: 'Rukun Tetangga (RT)', route: 'admin.rukun-tetangga.index' },
            { name: 'LPMK', route: 'admin.lpmk.index' },
            { name: 'Karang Taruna', route: 'admin.karang-taruna.index' },
            { name: 'PKK', route: 'admin.pkk.index' },
            { name: 'Majelis Taklim', route: 'admin.majelis-taklim.index' },
        ]
    },
    { name: 'Statistik Penduduk', icon: 'fa-users', route: 'admin.kependudukan.index' },
    { name: 'Galeri Foto', icon: 'fa-images', route: 'admin.galeri.index' },
    { name: 'Layanan & Surat', icon: 'fa-concierge-bell', route: 'admin.layanan.index' },
    { name: 'Pengaduan Warga', icon: 'fa-exclamation-circle', route: 'admin.pengaduan.index' },
    { name: 'Kontak & Sosmed', icon: 'fa-address-book', route: 'admin.kontak' },
    { name: 'Konfigurasi Web', icon: 'fa-cogs', route: 'admin.konfigurasi' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar Backdrop (Mobile only) -->
        <div v-if="isSidebarOpen" @click="isSidebarOpen = false"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 md:hidden transition-opacity"></div>

        <!-- Sidebar -->
        <aside :class="[
            'bg-slate-900 text-white transition-all duration-300 flex-shrink-0 z-50 fixed md:relative h-screen',
            isSidebarOpen ? 'w-72 translate-x-0' : 'w-20 translate-x-[-100%] md:translate-x-0'
        ]">
            <div class="p-6 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <span v-if="isSidebarOpen" class="font-black tracking-tight text-xl">Admin<span
                        class="text-blue-500">Panel</span></span>
            </div>

            <nav class="mt-6 px-3 space-y-1 overflow-y-auto max-h-[calc(100vh-180px)] custom-scrollbar">
                <div v-for="menu in menus" :key="menu.name">
                    <!-- Simple Menu -->
                    <Link v-if="!menu.sub" :href="menu.route ? (menu.route === '#' ? '#' : route(menu.route)) : '#'"
                        @click="activeDropdown = null"
                        :class="['flex items-center gap-4 px-4 py-3 rounded-xl transition-all group hover:bg-slate-800/50',
                            (menu.route && (route().current(menu.route) || (menu.route.endsWith('.index') && route().current(menu.route.replace('.index', '.*'))))) ? 'text-blue-400' : 'text-slate-400 hover:text-blue-400']">
                        <i
                            :class="['fas w-6 text-center text-lg', menu.icon, (menu.route && (route().current(menu.route) || (menu.route.endsWith('.index') && route().current(menu.route.replace('.index', '.*'))))) ? 'text-blue-400' : 'text-slate-500 group-hover:text-blue-400']"></i>
                        <span v-if="isSidebarOpen" class="font-bold text-sm flex-grow">{{ menu.name }}</span>

                        <!-- Notification Badge for Pengaduan -->
                        <div v-if="menu.name === 'Pengaduan Warga' && usePage().props.pendingPengaduanCount > 0"
                            class="ml-auto w-5 h-5 bg-rose-500 text-white text-[10px] font-black rounded-full flex items-center justify-center shadow-lg shadow-rose-500/40 animate-pulse">
                            {{ usePage().props.pendingPengaduanCount }}
                        </div>
                    </Link>

                    <!-- Dropdown Menu -->
                    <div v-else>
                        <button @click="toggleDropdown(menu.name)"
                            :class="['w-full flex items-center justify-between gap-4 px-4 py-3 rounded-xl transition-all group font-bold text-sm hover:bg-slate-800/50',
                                (activeDropdown === menu.name || (menu.sub && menu.sub.some(s => s.route !== '#' && route().current(s.route, s.params)))) ? 'text-blue-400 bg-slate-800/30' : 'text-slate-400 hover:text-blue-400']">
                            <div class="flex items-center gap-4">
                                <i
                                    :class="['fas w-6 text-center text-lg', menu.icon, (activeDropdown === menu.name || (menu.sub && menu.sub.some(s => s.route !== '#' && route().current(s.route, s.params)))) ? 'text-blue-400' : 'text-slate-500 group-hover:text-blue-400']"></i>
                                <span v-if="isSidebarOpen">{{ menu.name }}</span>
                            </div>
                            <i v-if="isSidebarOpen"
                                :class="['fas fa-chevron-right text-[10px] transition-transform', (activeDropdown === menu.name) ? 'rotate-90' : '']"></i>
                        </button>
                        <transition enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-y-0 opacity-0"
                            enter-to-class="transform scale-y-100 opacity-100"
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="transform scale-y-100 opacity-100"
                            leave-to-class="transform scale-y-0 opacity-0">
                            <div v-if="isSidebarOpen && activeDropdown === menu.name"
                                class="mt-1 ml-10 space-y-1 border-l border-slate-700 pl-4 py-2 origin-top">
                                <Link v-for="sub in menu.sub" :key="sub.name"
                                    :href="sub.route === '#' ? '#' : route(sub.route, sub.params || {})"
                                    :class="['block py-2 text-xs font-bold transition-colors',
                                        (sub.route !== '#' && route().current(sub.route, sub.params)) ? 'text-blue-400' : 'text-slate-500 hover:text-blue-400']">
                                    {{ sub.name }}
                                </Link>
                            </div>
                        </transition>
                    </div>
                </div>
            </nav>

            <!-- Logout removed from sidebar -->
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0 h-screen overflow-hidden">
            <!-- Header -->
            <header
                class="bg-white h-20 min-h-[5rem] shadow-sm flex items-center justify-between px-4 md:px-8 relative z-20 shrink-0">
                <button @click="toggleSidebar"
                    class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center hover:bg-gray-100 text-gray-400 transition-colors">
                    <i :class="['fas', isSidebarOpen ? 'fa-indent' : 'fa-outdent']"></i>
                </button>

                <!-- User Profile & Dropdown -->
                <div id="user-menu-container" class="relative">
                    <button @click="toggleUserMenu" class="flex items-center gap-4 group">
                        <div class="hidden md:flex flex-col items-end text-right">
                            <span
                                class="font-black text-gray-900 text-sm group-hover:text-blue-600 transition-colors">{{
                                    $page.props.auth.user.name }}</span>
                            <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-0.5">Ujung
                                Sabbang</span>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 border-2 border-white shadow-lg overflow-hidden flex items-center justify-center transition-transform hover:scale-105 active:scale-95 text-white shrink-0">
                            <i class="fas fa-user-shield text-lg"></i>
                        </div>
                    </button>

                    <!-- Dropdown menu -->
                    <transition enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                        <div v-if="isUserMenuOpen"
                            class="absolute right-0 mt-4 w-64 origin-top-right bg-white rounded-3xl shadow-2xl border border-slate-100 p-2 overflow-hidden focus:outline-none">
                            <div class="px-5 py-4 border-b border-slate-50 mb-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{
                                    $page.props.auth.user.name }}</p>
                                <p class="text-xs font-bold text-slate-500 truncate mt-1">{{ $page.props.auth.user.email
                                    }}</p>
                            </div>

                            <Link :href="route('admin.profile.index')"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-2xl transition-all">
                                <i class="fas fa-user-circle text-lg opacity-50"></i> Lihat Profil
                            </Link>

                            <Link :href="route('admin.konfigurasi')"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-2xl transition-all">
                                <i class="fas fa-cogs text-lg opacity-50"></i> Konfigurasi Web
                            </Link>

                            <hr class="my-1 border-slate-50">

                            <Link :href="route('logout')" method="post" as="button"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-2xl transition-all text-left">
                                <i class="fas fa-sign-out-alt text-lg opacity-50"></i> Logout
                            </Link>
                        </div>
                    </transition>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-grow p-4 md:p-8 overflow-y-auto bg-gray-50/50">
                <slot />
            </div>
        </main>
    </div>
</template>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
