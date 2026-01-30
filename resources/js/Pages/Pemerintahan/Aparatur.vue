<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    structures: Array
});

const getPhotoUrl = (path) => {
    return path ? `/storage/${path}` : 'https://placehold.co/400x500?text=No+Photo';
};
</script>

<template>

    <Head :title="`Aparatur ${$page.props.settings?.sebutan_wilayah || 'Kelurahan'}`" />

    <MainLayout>
        <!-- Hero Section with Modern Mesh Gradient -->
        <div class="relative bg-slate-900 py-16 overflow-hidden">
            <!-- Animated Background Elements -->
            <div
                class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:24px_24px]">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-16 h-16 mx-auto bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-2xl border border-white/10">
                    <i class="fas fa-user-tie text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6 drop-shadow-2xl">
                    Aparatur {{ $page.props.settings?.sebutan_wilayah || 'Kelurahan' }}
                </h1>
                <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto font-medium leading-relaxed opacity-80">
                    Mengenal lebih dekat jajaran profesional yang berdedikasi melayani masyarakat {{
                        $page.props.settings?.sebutan_wilayah || 'Kelurahan' }} {{ $page.props.settings?.nama_wilayah ||
                        '[Nama Wilayah]' }}.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-24 bg-slate-50 relative">
            <!-- Background Decoration -->
            <div
                class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-slate-900 to-transparent opacity-[0.03]">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="structures && structures.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div v-for="(person, index) in structures" :key="person.id"
                        class="group relative bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-700 border border-slate-100 overflow-hidden hover:-translate-y-2">

                        <!-- Image Container -->
                        <div class="relative aspect-[4/5] rounded-[2rem] overflow-hidden mb-5 bg-slate-50">
                            <img :src="getPhotoUrl(person.photo)" :alt="person.name"
                                class="w-full h-full object-cover object-top transition-all duration-700 group-hover:scale-110">

                            <!-- Modern Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                        </div>

                        <!-- Info Section -->
                        <div class="px-2 pb-2">
                            <div class="mb-4">
                                <h3
                                    class="text-base font-black text-slate-900 mb-1 group-hover:text-blue-600 transition-colors duration-300 line-clamp-1 uppercase tracking-tight">
                                    {{ person.name }}
                                </h3>
                                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em] mb-2">
                                    {{ person.position }}
                                </p>

                                <!-- Permanent NIP Display -->
                                <div v-if="person.nip"
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-slate-50 border border-slate-100/50">
                                    <i class="fas fa-id-card text-[8px] text-slate-400"></i>
                                    <span class="text-[9px] font-bold text-slate-500 font-mono tracking-tighter">
                                        {{ person.nip }}
                                    </span>
                                </div>
                            </div>

                            <!-- Compact Direct Superior Info -->
                            <div class="pt-4 border-t border-slate-50">
                                <div v-if="person.parent" class="flex items-center gap-2 group/superior">
                                    <div
                                        class="w-6 h-6 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 group-hover/superior:bg-blue-50 group-hover/superior:text-blue-500 transition-colors">
                                        <i class="fas fa-sitemap text-[9px]"></i>
                                    </div>
                                    <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider truncate">
                                        {{ person.parent.position }}
                                    </span>
                                </div>
                                <div v-else-if="person.level === 1" class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500">
                                        <i class="fas fa-crown text-[9px]"></i>
                                    </div>
                                    <span class="text-[9px] text-blue-600 font-black uppercase tracking-widest">Kepala
                                        Instansi</span>
                                </div>
                                <div v-else class="flex items-center gap-2 text-slate-300">
                                    <i class="fas fa-link-slash text-[9px]"></i>
                                    <span class="text-[9px] font-bold uppercase tracking-wider">Independent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Subtle Animated Shine -->
                        <div
                            class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
                            <div
                                class="absolute top-[-150%] left-[-50%] w-[200%] h-[200%] bg-gradient-to-tr from-white/10 to-transparent rotate-12 animate-shine">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else
                    class="text-center py-32 bg-white rounded-[3rem] border border-dashed border-slate-200 group relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-blue-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-blue-500/5 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-users-cog text-3xl text-blue-200"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Data Belum Tersedia</h3>
                        <p class="text-slate-500 text-sm font-medium">Informasi jajaran aparatur sedang dalam proses
                            pemutakhiran.</p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fadeInDown 1s ease-out forwards;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shine {
    from {
        transform: translate(-50%, -50%) rotate(45deg);
    }

    to {
        transform: translate(150%, 150%) rotate(45deg);
    }
}

.animate-shine {
    animation: shine 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}
</style>
