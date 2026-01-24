<script setup>
import { ref, onMounted } from 'vue';
import { Link, Head, usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(true);
const activeDropdown = ref(null);

// Auto-open dropdown if child route is active
onMounted(() => {
    menus.forEach(menu => {
        if (menu.sub) {
            const hasActiveChild = menu.sub.some(s => 
                s.route !== '#' && (route().current(s.route) || (s.route.endsWith('.index') && route().current(s.route.replace('.index', '.*'))))
            );
            if (hasActiveChild) {
                activeDropdown.value = menu.name;
            }
        }
    });
});

const toggleSidebar = () => isSidebarOpen.value = !isSidebarOpen.value;
const toggleDropdown = (name) => {
    // If clicking the active dropdown, close it (set to null)
    // Otherwise, set the new name as the ONLY active dropdown (automatically closing others)
    activeDropdown.value = activeDropdown.value === name ? null : name;
};

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
            { name: 'Program Kerja', route: '#' },
            { name: 'Potensi Wilayah', route: '#' },
        ]
    },
    { name: 'Kependudukan', icon: 'fa-users', route: '#' },
    { name: 'Galeri Foto', icon: 'fa-images', route: 'admin.galeri.index' },
    { name: 'Layanan & Surat', icon: 'fa-concierge-bell', route: '#' },
    { name: 'Pengaduan Warga', icon: 'fa-exclamation-circle', route: '#' },
    { name: 'Kontak & Sosmed', icon: 'fa-address-book', route: 'admin.kontak' },
    { name: 'Konfigurasi Web', icon: 'fa-cogs', route: 'admin.struktur.index' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside
            :class="['bg-slate-900 text-white transition-all duration-300 flex-shrink-0 z-50', isSidebarOpen ? 'w-72' : 'w-20']">
            <div class="p-6 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <span v-if="isSidebarOpen" class="font-black tracking-tight text-xl">Admin<span
                        class="text-blue-500">Panel</span></span>
            </div>

            <nav class="mt-6 px-3 space-y-1">
                <div v-for="menu in menus" :key="menu.name">
                    <!-- Simple Menu -->
                    <Link v-if="!menu.sub" :href="menu.route ? (menu.route === '#' ? '#' : route(menu.route)) : '#'"
                        @click="activeDropdown = null"
                        :class="['flex items-center gap-4 px-4 py-3 rounded-xl transition-all group hover:bg-slate-800/50',
                            (menu.route && (route().current(menu.route) || (menu.route.endsWith('.index') && route().current(menu.route.replace('.index', '.*'))))) ? 'text-blue-400' : 'text-slate-400 hover:text-blue-400']">
                        <i
                            :class="['fas w-6 text-center text-lg', menu.icon, (menu.route && (route().current(menu.route) || (menu.route.endsWith('.index') && route().current(menu.route.replace('.index', '.*'))))) ? 'text-blue-400' : 'text-slate-500 group-hover:text-blue-400']"></i>
                        <span v-if="isSidebarOpen" class="font-bold text-sm">{{ menu.name }}</span>
                    </Link>

                    <!-- Dropdown Menu -->
                    <div v-else>
                        <button @click="toggleDropdown(menu.name)"
                            :class="['w-full flex items-center justify-between gap-4 px-4 py-3 rounded-xl transition-all group font-bold text-sm hover:bg-slate-800/50',
                                (activeDropdown === menu.name || menu.sub.some(s => s.route !== '#' && (route().current(s.route) || (s.route.endsWith('.index') && route().current(s.route.replace('.index', '.*')))))) ? 'text-blue-400 bg-slate-800/30' : 'text-slate-400 hover:text-blue-400']">
                            <div class="flex items-center gap-4">
                                <i
                                    :class="['fas w-6 text-center text-lg', menu.icon, (activeDropdown === menu.name || menu.sub.some(s => s.route !== '#' && (route().current(s.route) || (s.route.endsWith('.index') && route().current(s.route.replace('.index', '.*')))))) ? 'text-blue-400' : 'text-slate-500 group-hover:text-blue-400']"></i>
                                <span v-if="isSidebarOpen">{{ menu.name }}</span>
                            </div>
                            <i v-if="isSidebarOpen"
                                :class="['fas fa-chevron-right text-[10px] transition-transform', (activeDropdown === menu.name) ? 'rotate-90' : '']"></i>
                        </button>
                        <transition enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-y-0 opacity-0" enter-to-class="transform scale-y-100 opacity-100"
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="transform scale-y-100 opacity-100" leave-to-class="transform scale-y-0 opacity-0">
                            <div v-if="isSidebarOpen && activeDropdown === menu.name"
                                class="mt-1 ml-10 space-y-1 border-l border-slate-700 pl-4 py-2 origin-top">
                                <Link v-for="sub in menu.sub" :key="sub.name"
                                    :href="sub.route === '#' ? '#' : route(sub.route)"
                                    :class="['block py-2 text-xs font-bold transition-colors',
                                        (sub.route !== '#' && (route().current(sub.route) || (sub.route.endsWith('.index') && route().current(sub.route.replace('.index', '.*'))))) ? 'text-blue-400' : 'text-slate-500 hover:text-blue-400']">
                                    {{ sub.name }}
                                </Link>
                            </div>
                        </transition>
                    </div>
                </div>
            </nav>

            <!-- Logout Bottom -->
            <div class="absolute bottom-6 w-full px-6">
                <Link :href="route('logout')" method="post" as="button"
                    class="w-full flex items-center gap-4 text-rose-500 font-bold hover:translate-x-1 transition-transform outline-none">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span v-if="isSidebarOpen">Logout</span>
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0 h-screen overflow-hidden">
            <!-- Header -->
            <header class="bg-white h-20 shadow-sm flex items-center justify-between px-8 relative z-20">
                <button @click="toggleSidebar"
                    class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center hover:bg-gray-100 text-gray-400">
                    <i :class="['fas', isSidebarOpen ? 'fa-indent' : 'fa-outdent']"></i>
                </button>

                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col items-end leading-none">
                        <span class="font-black text-gray-900 text-sm">Super Admin</span>
                        <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Ujung
                            Sabbang</span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 border-2 border-white shadow-md">
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-grow p-8 overflow-y-auto bg-gray-50/50">
                <slot />
            </div>
        </main>
    </div>
</template>
