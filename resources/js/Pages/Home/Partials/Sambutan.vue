<script setup>
defineProps({
    lurah: Object,
    sambutan: Object
});
</script>

<template>
    <section id="sambutan" class="py-32 bg-white relative overflow-hidden">
        <!-- Dynamic Background Elements -->
        <div
            class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/40 skew-x-12 transform translate-x-32 hidden lg:block">
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-indigo-50/50 rounded-full blur-2xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:flex lg:items-center lg:justify-between gap-16">
                <!-- Photo Column with Premium Effects -->
                <div class="hidden lg:block lg:w-2/5 relative group perspective-1000">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[2.5rem] transform rotate-3 opacity-20 group-hover:rotate-1 group-hover:opacity-40 transition-all duration-700 blur-xl">
                    </div>
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>

                    <div
                        class="relative overflow-hidden rounded-[2.5rem] bg-slate-200 border-8 border-white shadow-2xl transform transition-all duration-700 group-hover:scale-[1.02] group-hover:-translate-y-2">
                        <img class="w-full h-[600px] object-cover object-top transition-transform duration-1000 group-hover:scale-110"
                            :src="lurah?.photo ? '/storage/' + lurah.photo : 'https://placehold.co/600x800?text=Foto+Lurah'"
                            :alt="lurah?.name || 'Foto Lurah'">

                        <!-- Shine Overlay Effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                        </div>

                        <!-- Premium Name Badge -->
                        <div
                            class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent backdrop-blur-subtle">
                            <h4 class="text-2xl font-black text-white leading-tight mb-1">{{ lurah?.name ||
                                "Nama Lurah Belum Diatur" }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                                <p class="text-blue-300 font-bold uppercase text-[10px] tracking-[0.2em]">{{
                                    lurah?.position || "Lurah Ujung Sabbang" }}</p>
                            </div>
                            <p v-if="lurah?.nip"
                                class="text-white/40 font-mono text-[9px] mt-3 tracking-widest border-t border-white/10 pt-3">
                                NIP. {{ lurah.nip }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Column with Interactive Text -->
                <div class="lg:w-3/5 mt-20 lg:mt-0 space-y-8 animate-fade-in-up">
                    <div
                        class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 hover:bg-blue-100 transition-colors duration-300">
                        <i class="fas fa-comment-dots text-sm"></i>
                        <span class="text-xs font-black uppercase tracking-[0.2em]">Pesan Pimpinan</span>
                    </div>

                    <div v-if="sambutan?.quote"
                        class="relative py-8 px-6 md:px-10 bg-slate-50 rounded-[2rem] border-l-8 border-blue-600">
                        <i class="fas fa-quote-right absolute top-4 right-8 text-6xl text-blue-200/30"></i>
                        <p class="text-xl md:text-2xl font-bold text-slate-700 italic leading-relaxed relative z-10">
                            "{{ sambutan.quote }}"
                        </p>
                    </div>

                    <div v-if="sambutan?.message"
                        class="prose text-slate-600 max-w-none sambutan-rich-text selection:bg-blue-100"
                        v-html="sambutan.message"></div>
                    <div v-else class="prose text-slate-400 max-w-none italic flex items-center gap-3">
                        <i class="fas fa-info-circle"></i> Pesan sambutan sedang disiapkan oleh admin.
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.sambutan-rich-text :deep(p) {
    margin-bottom: 1.25rem;
    line-height: 1.8;
    color: #475569;
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
    padding-left: 2rem;
    margin-bottom: 0.75rem;
    line-height: 1.6;
}

.sambutan-rich-text :deep(ul li::before) {
    content: "\f058";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 0.25rem;
    color: #2563eb;
    font-size: 1.1rem;
}

.sambutan-rich-text :deep(ol) {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
    color: #475569;
}

.sambutan-rich-text :deep(ol li) {
    margin-bottom: 0.5rem;
    padding-left: 0.5rem;
}

.sambutan-rich-text :deep(p:first-of-type)::first-letter {
    font-size: 3.5rem;
    font-weight: 900;
    color: #2563eb;
    margin-right: 0.75rem;
    float: left;
    line-height: 1;
    text-transform: uppercase;
}

.animate-fade-in-up {
    animation: fadeInUp 1s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
