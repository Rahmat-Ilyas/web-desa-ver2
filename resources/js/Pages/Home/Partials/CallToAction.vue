<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="py-24 bg-blue-600 relative overflow-hidden">
        <!-- Premium Background Elements -->
        <div
            class="absolute inset-0 opacity-20 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]">
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-400/30 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold uppercase tracking-[0.2em] mb-8 backdrop-blur-sm">
                <i class="fas fa-headset"></i> Layanan Pengaduan 24/7
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tight leading-tight">Sampaikan Aspirasi
                Anda</h2>
            <p class="text-blue-50 text-lg md:text-xl max-w-2xl mx-auto mb-12 font-medium leading-relaxed opacity-90">
                Kami siap mendengarkan saran, kritik, dan laporan Anda demi mewujudkan tata kelola kelurahan yang lebih
                baik dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <Link :href="route('pengaduan')"
                    class="group inline-flex items-center justify-center px-10 py-5 bg-white text-blue-700 font-black rounded-full shadow-[0_20px_40px_-15px_rgba(255,255,255,0.3)] hover:shadow-[0_25px_50px_-12px_rgba(255,255,255,0.4)] hover:-translate-y-1.5 transition-all duration-300 uppercase tracking-widest text-sm">
                    Buat Pengaduan <i
                        class="fas fa-paper-plane ml-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                </Link>
                <a href="https://wa.me/6285333341194?text=Halo%20Admin%20Kelurahan%20Ujung%20Sabbang%2C%20saya%20ingin%20menyampaikan%20aspirasi%2Fpengaduan%20mengenai..."
                    target="_blank"
                    class="group inline-flex items-center justify-center px-10 py-5 bg-green-500 text-white font-black rounded-full shadow-[0_20px_40px_-15px_rgba(34,197,94,0.3)] hover:shadow-[0_25px_50px_-12px_rgba(34,197,94,0.4)] hover:-translate-y-1.5 transition-all duration-300 uppercase tracking-widest text-sm">
                    Hubungi via WhatsApp <i
                        class="fab fa-whatsapp ml-3 text-lg group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>
</template>
