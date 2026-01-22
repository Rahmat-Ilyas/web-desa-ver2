<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const pokjas = [
    { name: 'POKJA I', desc: 'Penghayatan dan Pengamalan Pancasila & Gotong Royong', icon: 'fa-dove' },
    { name: 'POKJA II', desc: 'Pendidikan dan Keterampilan & Pengembangan Kehidupan Berkoperasi', icon: 'fa-book-reader' },
    { name: 'POKJA III', desc: 'Pangan, Sandang, Perumahan dan Tata Laksana Rumah Tangga', icon: 'fa-utensils' },
    { name: 'POKJA IV', desc: 'Kesehatan & Perencanaan Sehat', icon: 'fa-heartbeat' },
];
</script>

<template>

    <Head title="Lembaga PKK" />

    <MainLayout>
        <div class="bg-pink-600 py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-female text-3xl text-pink-600"></i>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">PKK Kelurahan</h1>
                <p class="text-pink-100 text-lg max-w-2xl mx-auto">Pemberdayaan Kesejahteraan Keluarga Kelurahan Ujung
                    Sabbang.</p>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Ketua Info -->
                <div
                    class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden mb-16 border border-gray-100 flex flex-col md:flex-row">
                    <div class="md:w-1/3 bg-gray-100 relative">
                        <!-- Placeholder Image -->
                        <img src="https://placehold.co/400x500?text=Ibu+Ketua+PKK" alt="Ketua PKK"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-2/3 p-8 flex flex-col justify-center">
                        <div class="uppercase tracking-wide text-sm text-pink-500 font-bold mb-1">Ketua Tim Penggerak
                            PKK</div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Ibu Hj. Mariani</h2>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            "Mewujudkan keluarga yang beriman dan bertaqwa kepada Tuhan Yang Maha Esa, berakhlak mulia
                            dan berbudi luhur, sehat sejahtera, maju dan mandiri, kesetaraan dan keadilan gender serta
                            kesadaran hukum dan lingkungan."
                        </p>
                    </div>
                </div>

                <!-- 10 Program Pokok & Pokja -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Kelompok Kerja (POKJA)</h2>
                    <p class="text-gray-500 mt-3">Pelaksana 10 Program Pokok PKK</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="pokja in pokjas" :key="pokja.name"
                        class="bg-pink-50 rounded-xl p-6 text-center hover:bg-pink-100 transition-colors duration-300 border border-pink-100">
                        <div
                            class="w-14 h-14 mx-auto bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <i :class="['fas', pokja.icon, 'text-2xl text-pink-500']"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">{{ pokja.name }}</h3>
                        <p class="text-sm text-gray-600">{{ pokja.desc }}</p>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
