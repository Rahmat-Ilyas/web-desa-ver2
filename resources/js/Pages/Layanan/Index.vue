<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    services: Array
});

import { ref } from 'vue';
const selectedService = ref(null);
const isModalOpen = ref(false);

const openModal = (service) => {
    selectedService.value = service;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = 'auto';
};

const page = usePage();
const whatsappNumber = page.props.settings?.info_umum?.whatsapp || '';
const whatsappLink = whatsappNumber ? `https://wa.me/${whatsappNumber}` : '#';
</script>

<template>

    <Head title="Layanan Administrasi" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-orange-600 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30 rotate-3">
                    <i class="fas fa-concierge-bell text-3xl text-orange-100"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Pusat Layanan Warga</h1>
                <p class="text-orange-100 text-lg max-w-2xl mx-auto font-medium">Informasi persyaratan dan prosedur pengurusan
                    administrasi di Kelurahan Ujung Sabbang secara transparan dan cepat.</p>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="props.services.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="service in props.services" :key="service.id"
                        class="bg-white rounded-3xl p-8 shadow-xl shadow-orange-900/5 hover:shadow-2xl transition-all duration-500 group border border-gray-100 flex flex-col items-start translate-y-0 hover:-translate-y-2">
                        <div
                            :class="[service.color, 'w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:rotate-12 transition-all duration-500 shadow-sm']">
                            <i :class="['fas', service.icon]"></i>
                        </div>
                        <h3
                            class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors leading-tight">
                            {{ service.title }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow">
                            {{ service.description }}
                        </p>
                        <button @click="openModal(service)"
                            class="w-full py-3 bg-gray-50 text-gray-700 font-bold rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 flex items-center justify-center">
                            Lihat Syarat <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </button>
                    </div>
                </div>
                <div v-else class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <i class="fas fa-file-invoice text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400">Belum ada data layanan tersedia.</h3>
                </div>

                <!-- Assistance Section -->
                <div
                    class="mt-24 p-12 bg-white rounded-[3rem] border border-gray-100 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-10">
                    <div class="flex items-center gap-8">
                        <div
                            class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center text-4xl text-orange-600 shadow-inner">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-gray-900 mb-2 font-poppins">Butuh bantuan pengurusan?
                            </h4>
                            <p class="text-gray-500">Petugas kami siap membantu Anda memberikan informasi lebih detail
                                setiap hari kerja.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a :href="whatsappLink" target="_blank"
                            class="px-8 py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 transition-colors shadow-lg shadow-green-600/20">
                            <i class="fab fa-whatsapp mr-2 text-xl"></i>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requirements Modal -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="closeModal">
                </div>

                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <transition enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div
                            class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                            <div class="bg-white p-8 sm:p-10">
                                <div class="flex justify-between items-start mb-8">
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="[selectedService.color, 'w-14 h-14 rounded-2xl flex items-center justify-center text-xl shadow-sm']">
                                            <i :class="['fas', selectedService.icon]"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-black text-slate-900 leading-tight">Syarat & Berkas
                                            </h3>
                                            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-1">
                                                {{ selectedService.title }}</p>
                                        </div>
                                    </div>
                                    <button @click="closeModal"
                                        class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-400">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div v-for="(req, index) in selectedService.requirements" :key="index"
                                        class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-orange-200 hover:bg-orange-50/30 transition-all">
                                        <div
                                            class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] font-black text-slate-400 shrink-0 group-hover:border-orange-500 group-hover:text-orange-600 transition-colors">
                                            {{ index + 1 }}
                                        </div>
                                        <p class="text-slate-600 font-semibold text-sm leading-relaxed">{{ req }}</p>
                                    </div>
                                </div>

                                <div class="mt-10">
                                    <button @click="closeModal"
                                        class="w-full py-4 bg-orange-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-orange-700 transition-all shadow-xl shadow-orange-600/20">
                                        SAYA MENGERTI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </transition>
    </MainLayout>
</template>
