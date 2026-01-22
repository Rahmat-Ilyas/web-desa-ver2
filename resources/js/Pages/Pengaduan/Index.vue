<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref } from 'vue';

const form = useForm({
    nama: '',
    phone: '',
    kategori: 'Layanan Publik',
    pesan: '',
    photos: [],
});

const previews = ref([]);

const handleFileUpload = (event) => {
    const files = Array.from(event.target.files);
    if (form.photos.length + files.length > 3) {
        alert('Maksimal 3 foto dokumentasi.');
        return;
    }

    files.forEach(file => {
        form.photos.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            previews.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removePhoto = (index) => {
    form.photos.splice(index, 1);
    previews.value.splice(index, 1);
};

const submit = () => {
    // Logic for submitting the complaint
    console.log(form.data());
    alert('Terima kasih! Aduan Anda telah terkirim (Demo).');
    form.reset();
    previews.value = [];
};
</script>

<template>
    <Head title="Pengaduan Warga" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-red-600 to-rose-700 py-20 relative overflow-hidden">
             <div class="absolute inset-x-0 bottom-0 top-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30">
                    <i class="fas fa-exclamation-triangle text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Pusat Pengaduan Warga</h1>
                <p class="text-rose-50 text-xl max-w-2xl mx-auto">Kami mendengar dan siap membantu. Sampaikan keluhan, aspirasi, atau masukan Anda demi kemajuan Kelurahan Ujung Sabbang.</p>
            </div>
        </div>

        <div class="py-20 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                    
                    <!-- Form Section -->
                    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-2xl border border-gray-100">
                        <h2 class="text-2xl font-black text-gray-900 mb-8 flex items-center">
                            <i class="fas fa-paper-plane mr-3 text-rose-500"></i> Kirim Aduan
                        </h2>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input v-model="form.nama" type="text" placeholder="Masukkan nama Anda" 
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                                    <input v-model="form.phone" type="tel" placeholder="08xx xxxx xxxx" 
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all duration-300">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Aduan</label>
                                <select v-model="form.kategori" 
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all duration-300 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23cbd5e1%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E')] bg-[length:20px] bg-[right_1.25rem_center] bg-no-repeat">
                                    <option>Layanan Publik</option>
                                    <option>Infrastruktur & Jalan</option>
                                    <option>Kebersihan & Lingkungan</option>
                                    <option>Keamanan & Ketertiban</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pesan Aduan</label>
                                <textarea v-model="form.pesan" rows="5" placeholder="Ceritakan detail aduan Anda secara lengkap" 
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-3xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all duration-300 resize-none"></textarea>
                            </div>

                            <!-- Photo Upload Section -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3 flex justify-between items-center">
                                    <span>Foto Dokumentasi (Opsional)</span>
                                    <span class="text-xs font-medium text-gray-400">{{ form.photos.length }}/3 Foto</span>
                                </label>
                                
                                <div class="grid grid-cols-3 gap-4">
                                    <div v-for="(preview, index) in previews" :key="index" class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                                        <img :src="preview" class="w-full h-full object-cover">
                                        <button @click.prevent="removePhoto(index)" class="absolute top-2 right-2 w-8 h-8 bg-black/50 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <label v-if="form.photos.length < 3" class="aspect-square rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-rose-500 hover:bg-rose-50 transition-all text-gray-400 hover:text-rose-500">
                                        <input type="file" class="hidden" accept="image/*" @change="handleFileUpload" multiple>
                                        <i class="fas fa-camera text-2xl mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Tambah</span>
                                    </label>
                                </div>
                                <p class="mt-3 text-[11px] text-gray-400 leading-relaxed italic">Format: JPG, PNG. Ukuran maks 2MB per foto.</p>
                            </div>

                            <button type="submit" 
                                class="w-full py-5 bg-rose-600 text-white font-black text-lg rounded-[2rem] hover:bg-rose-700 hover:shadow-2xl hover:shadow-rose-600/30 transition-all duration-300 active:scale-[0.98]">
                                Kirim Laporan Sekarang
                            </button>
                        </form>
                    </div>

                    <!-- Info Section -->
                    <div class="space-y-12 lg:pt-12">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 mb-6 font-poppins">Alur Penanganan Aduan</h3>
                            <div class="space-y-6">
                                <div class="flex gap-6 group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">1</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Verifikasi Laporan</h4>
                                        <p class="text-gray-500 text-sm">Petugas admin akan memvalidasi data dan kategori aduan Anda paling lambat 1x24 jam.</p>
                                    </div>
                                </div>
                                <div class="flex gap-6 group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">2</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Disposisi Unit</h4>
                                        <p class="text-gray-500 text-sm">Aduan diteruskan ke unit terkait (Kasi Pemerintahan, Kebersihan, atau Polsek setempat).</p>
                                    </div>
                                </div>
                                <div class="flex gap-6 group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">3</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Tindak Lanjut & Selesai</h4>
                                        <p class="text-gray-500 text-sm">Petugas lapangan melakukan aksi nyata dan status aduan akan diinfokan kembali kepada Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-10 bg-gradient-to-br from-gray-900 to-slate-800 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
                             <i class="fas fa-headset absolute -right-6 -top-6 text-[150px] opacity-10"></i>
                             <h4 class="text-2xl font-black mb-4 relative z-10 font-poppins">Layanan Darurat?</h4>
                             <p class="text-gray-400 mb-8 relative z-10 leading-relaxed">Untuk kejadian darurat (Kebakaran, Kriminalitas, Bencana), silakan hubungi pusat panggilan darurat atau langsung datangi Kantor Lurah.</p>
                             <div class="flex gap-4 relative z-10">
                                 <a href="tel:112" class="p-4 bg-white/20 backdrop-blur-md rounded-2xl hover:bg-white/30 transition-colors">
                                     <i class="fas fa-phone-alt mr-2"></i> <strong>112</strong>
                                 </a>
                                 <a href="#" class="p-4 bg-rose-600 rounded-2xl hover:bg-rose-700 transition-all">
                                      <i class="fab fa-whatsapp mr-2"></i> Chat Admin
                                 </a>
                             </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
