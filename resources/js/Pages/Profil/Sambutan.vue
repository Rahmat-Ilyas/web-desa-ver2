<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    lurah: Object,
    sambutan: Object
});

const copied = ref(false);
const copyLink = () => {
    navigator.clipboard.writeText(window.location.href);
    copied.value = true;
    setTimeout(() => copied.value = false, 3000);
};
</script>

<template>

    <Head title="Sambutan Lurah" />

    <MainLayout>
        <!-- Hero Title -->
        <div class="bg-blue-900 py-24 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Sambutan Lurah</h1>
                <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto font-medium leading-relaxed">
                    Pesan, harapan, dan komitmen untuk kemajuan Kel. Ujung Sabbang.
                </p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:gap-20">

                    <!-- Sidebar / Photo -->
                    <div class="lg:col-span-4 mb-16 lg:mb-0">
                        <div class="sticky top-32">
                            <div class="relative group">
                                <div
                                    class="absolute -inset-2 md:-inset-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[2.5rem] transform rotate-3 opacity-20 group-hover:rotate-1 transition-all duration-700 blur-xl">
                                </div>

                                <div
                                    class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-white bg-slate-100">
                                    <img :src="props.lurah?.photo ? '/storage/' + props.lurah.photo : 'https://placehold.co/600x800?text=Foto+Lurah'"
                                        :alt="props.lurah?.name || 'Lurah Ujung Sabbang'"
                                        class="w-full h-[500px] object-cover object-top transform group-hover:scale-105 transition-all duration-1000">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10 text-center lg:text-left relative">
                                <div class="absolute -left-4 top-0 w-1 h-20 bg-blue-600 hidden lg:block"></div>
                                <h3 class="text-3xl font-black text-slate-900 leading-tight mb-2">{{ props.lurah?.name
                                    || 'Nama Belum Diatur' }}</h3>
                                <p class="text-blue-600 font-black uppercase text-xs tracking-[0.2em]">{{
                                    props.lurah?.position || 'Lurah Ujung Sabbang' }}</p>
                                <p v-if="props.lurah?.nip"
                                    class="text-slate-400 font-mono text-[10px] mt-4 tracking-widest uppercase">NIP. {{
                                        props.lurah.nip }}</p>

                                <div class="mt-8 pt-8 border-t border-slate-100">
                                    <p
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 text-center lg:text-left">
                                        Bagikan Halaman:</p>
                                    <div class="flex justify-center lg:justify-start gap-3">
                                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(typeof window !== 'undefined' ? window.location.href : '')"
                                            target="_blank"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all transform hover:-translate-y-1 shadow-sm group/share"
                                            title="Bagikan ke Facebook">
                                            <i class="fab fa-facebook-f text-sm"></i>
                                        </a>
                                        <a :href="'https://api.whatsapp.com/send?text=Baca Sambutan Lurah Ujung Sabbang: ' + encodeURIComponent(typeof window !== 'undefined' ? window.location.href : '')"
                                            target="_blank"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all transform hover:-translate-y-1 shadow-sm group/share"
                                            title="Bagikan ke WhatsApp">
                                            <i class="fab fa-whatsapp text-sm"></i>
                                        </a>
                                        <button @click="copyLink"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all transform hover:-translate-y-1 shadow-sm group/share"
                                            title="Salin Tautan">
                                            <i class="fas fa-link text-sm"></i>
                                        </button>
                                    </div>
                                    <transition enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0 translate-y-1"
                                        enter-to-class="opacity-100 translate-y-0"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100 translate-y-0"
                                        leave-to-class="opacity-0 translate-y-1">
                                        <p v-if="copied"
                                            class="mt-3 text-[10px] font-bold text-emerald-600 flex items-center gap-2 justify-center lg:justify-start">
                                            <i class="fas fa-check-circle"></i> Tautan berhasil disalin!
                                        </p>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="lg:col-span-8 animate-fade-in-up">
                        <div v-if="props.sambutan?.quote"
                            class="relative py-10 px-6 md:px-12 bg-slate-50 rounded-[2.5rem] border-l-8 border-blue-600 mb-12 group overflow-hidden">
                            <i
                                class="fas fa-quote-right absolute top-6 right-10 text-7xl text-blue-200/20 group-hover:scale-110 transition-transform duration-700"></i>
                            <p
                                class="text-2xl md:text-3xl font-bold text-slate-800 italic leading-relaxed relative z-10 transition-colors">
                                "{{ props.sambutan.quote }}"
                            </p>
                        </div>

                        <div v-if="props.sambutan?.message"
                            class="prose text-slate-600 max-w-none sambutan-rich-text selection:bg-blue-100"
                            v-html="props.sambutan.message"></div>

                        <div v-else
                            class="py-20 text-center bg-slate-50 rounded-[2.5rem] border-4 border-dashed border-slate-100">
                            <div
                                class="w-20 h-20 bg-white rounded-3xl shadow-md flex items-center justify-center text-slate-300 text-3xl mx-auto mb-6">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <p class="text-slate-400 font-bold italic">Belum ada rincian sambutan yang diunggah.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.sambutan-rich-text :deep(p) {
    margin-bottom: 1rem;
    line-height: 1.625;
    text-align: justify;
}

.sambutan-rich-text :deep(p:first-of-type)::first-letter {
    font-size: 4.5rem;
    font-weight: 900;
    color: #2563eb;
    margin-right: 1rem;
    float: left;
    line-height: 1;
}

.sambutan-rich-text :deep(h2) {
    font-size: 2.25rem;
    font-weight: 900;
    color: #0f172a;
    margin-top: 3rem;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.sambutan-rich-text :deep(h3) {
    font-size: 1.875rem;
    font-weight: 800;
    color: #1e293b;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    line-height: 1.3;
}

.sambutan-rich-text :deep(h4) {
    font-size: 1.5rem;
    font-weight: 700;
    color: #334155;
    margin-top: 2rem;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.sambutan-rich-text :deep(ul) {
    list-style-type: none;
    padding-left: 0.5rem;
    margin-bottom: 1.5rem;
}

.sambutan-rich-text :deep(ul li) {
    position: relative;
    padding-left: 2.5rem;
    margin-bottom: 0.75rem;
    line-height: 1.625;
    color: #475569;
}

.sambutan-rich-text :deep(ul li::before) {
    content: "";
    position: absolute;
    left: 0;
    top: 0.6rem;
    width: 0.75rem;
    height: 0.75rem;
    background-color: #2563eb;
    border-radius: 50%;
    box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
}

.sambutan-rich-text :deep(ol) {
    list-style-type: none;
    counter-reset: item;
    padding-left: 0.5rem;
    margin-bottom: 1.5rem;
}

.sambutan-rich-text :deep(ol li) {
    position: relative;
    padding-left: 3rem;
    margin-bottom: 0.75rem;
    line-height: 1.625;
    color: #475569;
}

.sambutan-rich-text :deep(ol li::before) {
    content: counter(item);
    counter-increment: item;
    position: absolute;
    left: 0;
    top: 0.15rem;
    width: 2rem;
    height: 2rem;
    background-color: #eff6ff;
    color: #2563eb;
    font-weight: 900;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.75rem;
    border: 1px solid #dbeafe;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 1s ease-out forwards;
}
</style>
