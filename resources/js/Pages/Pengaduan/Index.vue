<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, watch } from 'vue';

const form = useForm({
    nama: '',
    phone: '',
    kategori: 'Layanan Publik',
    pesan: '',
    photos: [],
});

const previews = ref([]);

const formatPhoneNumber = (number) => {
    if (!number) return '';
    // Remove all non-numeric characters
    let cleaned = number.replace(/\D/g, '');
    
    // Convert 08... to 628...
    if (cleaned.startsWith('0')) {
        cleaned = '62' + cleaned.substring(1);
    }
    
    // If it starts with 8... (no 0 or 62), add 62
    if (cleaned.startsWith('8')) {
        cleaned = '62' + cleaned;
    }
    
    return cleaned;
};

// Tracking State
const trackPhone = ref('');
const trackResults = ref(null);
const isTracking = ref(false);

const handleTrack = async () => {
    const formattedPhone = formatPhoneNumber(trackPhone.value);
    if (!formattedPhone) return;

    isTracking.value = true;
    try {
        const response = await axios.post(route('pengaduan.track'), {
            phone: formattedPhone
        });
        trackResults.value = response.data;
    } catch (error) {
        console.error(error);
        alert('Gagal memuat aduan. Pastikan nomor WhatsApp benar.');
    } finally {
        isTracking.value = false;
    }
};

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

const notification = ref({ show: false, message: '', type: 'success' });
const page = usePage();

const showNotification = (msg, type = 'success') => {
    notification.value.message = msg;
    notification.value.type = type;
    notification.value.show = true;
    setTimeout(() => notification.value.show = false, 5000);
};

// Auto-show notification from flash message
watch(() => page.props.flash?.success, (msg) => {
    if (msg) showNotification(msg, 'success');
});

const getStatusLabel = (status) => {
    const labels = {
        'pending': 'Menunggu Verifikasi',
        'proses': 'Sedang Diproses',
        'selesai': 'Selesai ditangani',
        'ditolak': 'Aduan Ditolak'
    };
    return labels[status] || status;
};

const getStatusColor = (status) => {
    switch (status) {
        case 'pending': return 'bg-amber-100 text-amber-700 border-amber-200';
        case 'proses': return 'bg-blue-100 text-blue-700 border-blue-200';
        case 'selesai': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'ditolak': return 'bg-rose-100 text-rose-700 border-rose-200';
        default: return 'bg-gray-100 text-gray-700 border-gray-200';
    }
};

const getWhatsAppLink = (aduan) => {
    const adminPhone = '628123456789'; // Placeholder, ideally from settings
    const message = `Halo Admin Kelurahan Ujung Sabbang, saya ingin menanyakan progres aduan saya:
    
Kode Aduan: ${aduan.kode}
Kategori: ${aduan.kategori}
Waktu: ${aduan.created_at}
Status: ${getStatusLabel(aduan.status)}

Pesan: ${aduan.pesan}

Mohon informasinya. Terima kasih.`;
    return `https://wa.me/${adminPhone}?text=${encodeURIComponent(message)}`;
};

const submit = () => {
    // Format phone before submit
    form.phone = formatPhoneNumber(form.phone);
    
    form.post(route('pengaduan.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            previews.value = [];
        },
    });
};
</script>

<template>

    <Head title="Pengaduan Warga" />

    <MainLayout>
        <!-- Notification Popover -->
        <transition enter-active-class="transform transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div v-if="notification.show"
                class="fixed bottom-10 right-4 md:right-10 z-[100] p-6 bg-white border border-emerald-100 rounded-30 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.15)] flex items-center gap-4 min-w-[320px] max-w-md rounded-[2rem]">
                <div
                    class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 flex-shrink-0">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div class="flex-grow">
                    <p class="text-slate-900 font-black text-sm uppercase tracking-wide">Laporan Terkirim</p>
                    <p class="text-slate-500 text-xs font-bold mt-0.5 leading-relaxed">{{ notification.message }}</p>
                </div>
                <button @click="notification.show = false"
                    class="text-slate-300 hover:text-slate-500 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </transition>

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-red-600 to-rose-700 py-20 relative overflow-hidden">
             <div class="absolute inset-x-0 bottom-0 top-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-white/30 rotate-3 transition-transform hover:rotate-0">
                    <i class="fas fa-search-location text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-6">Lacak & Lapor</h1>
                <p class="text-rose-50 text-xl max-w-2xl mx-auto font-medium">Sampaikan keluhan Anda atau pantau status penanganan aduan yang telah dikirim.</p>
            </div>
        </div>

        <div class="py-20 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start mb-20">

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
                                <textarea v-model="form.pesan" rows="5"
                                    placeholder="Ceritakan detail aduan Anda secara lengkap"
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-3xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all duration-300 resize-none"></textarea>
                            </div>

                            <!-- Photo Upload Section -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-gray-700 mb-3 flex justify-between items-center">
                                    <span>Foto Dokumentasi (Opsional)</span>
                                    <span class="text-xs font-medium text-gray-400">{{ form.photos.length }}/3
                                        Foto</span>
                                </label>

                                <div class="grid grid-cols-3 gap-4">
                                    <div v-for="(preview, index) in previews" :key="index"
                                        class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                                        <img :src="preview" class="w-full h-full object-cover">
                                        <button @click.prevent="removePhoto(index)"
                                            class="absolute top-2 right-2 w-8 h-8 bg-black/50 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>

                                    <label v-if="form.photos.length < 3"
                                        class="aspect-square rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-rose-500 hover:bg-rose-50 transition-all text-gray-400 hover:text-rose-500">
                                        <input type="file" class="hidden" accept="image/*" @change="handleFileUpload"
                                            multiple>
                                        <i class="fas fa-camera text-2xl mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Tambah</span>
                                    </label>
                                </div>
                                <p class="mt-3 text-[11px] text-gray-400 leading-relaxed italic">Format: JPG, PNG.
                                    Ukuran maks 2MB per foto.</p>
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
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">
                                        1</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Verifikasi Laporan</h4>
                                        <p class="text-gray-500 text-sm">Petugas admin akan memvalidasi data dan
                                            kategori aduan Anda paling lambat 1x24 jam.</p>
                                    </div>
                                </div>
                                <div class="flex gap-6 group">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">
                                        2</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Disposisi Unit</h4>
                                        <p class="text-gray-500 text-sm">Aduan diteruskan ke unit terkait (Kasi
                                            Pemerintahan, Kebersihan, atau Polsek setempat).</p>
                                    </div>
                                </div>
                                <div class="flex gap-6 group">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center font-black group-hover:bg-rose-600 group-hover:text-white transition-colors">
                                        3</div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 leading-none">Tindak Lanjut & Selesai
                                        </h4>
                                        <p class="text-gray-500 text-sm">Petugas lapangan melakukan aksi nyata dan
                                            status aduan akan diinfokan kembali kepada Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking Section -->
                        <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-xl border border-gray-100 overflow-hidden relative">
                            <div class="absolute top-0 right-0 p-8 opacity-[0.03] scale-125 rotate-12 pointer-events-none text-rose-900">
                                <i class="fas fa-search-location text-7xl"></i>
                            </div>
                            
                            <div class="relative z-10">
                                <h2 class="text-xl font-black text-gray-900 mb-2 font-poppins text-left">Lacak Status Aduan</h2>
                                <p class="text-gray-500 font-bold text-[11px] mb-6">Masukkan nomor WhatsApp Anda saat melapor.</p>
                                
                                <div class="space-y-4">
                                    <div class="relative group">
                                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-rose-500 transition-colors">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                        <input v-model="trackPhone" type="tel" placeholder="Contoh: 081234567890" 
                                            @keyup.enter="handleTrack"
                                            class="w-full pl-14 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:bg-white font-bold text-gray-700 transition-all text-sm">
                                    </div>
                                    <button @click="handleTrack" :disabled="isTracking"
                                        class="w-full py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-rose-600 transition-all shadow-xl shadow-gray-900/10 disabled:opacity-50 flex items-center justify-center gap-3 text-sm">
                                        <i v-if="isTracking" class="fas fa-spinner fa-spin"></i>
                                        <i v-else class="fas fa-search"></i>
                                        LACAK STATUS
                                    </button>
                                </div>
                            </div>

                            <!-- Results inside column -->
                            <div v-if="trackResults" class="mt-8 space-y-3 animate-in fade-in slide-in-from-top-4 duration-500 relative z-10">
                                <div v-if="trackResults.length === 0" class="p-6 bg-gray-50 rounded-[2rem] text-center border border-dashed border-gray-200">
                                    <p class="text-gray-400 font-bold text-xs">Data tidak ditemukan.</p>
                                </div>
                                <div v-for="res in trackResults" :key="res.id" 
                                    class="p-4 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all flex flex-col gap-3 group">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-rose-50 group-hover:text-rose-500 transition-colors shrink-0">
                                            <i class="fas fa-file-alt text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <span class="text-[9px] font-black text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded-md">{{ res.kode }}</span>
                                                <span class="text-[9px] font-bold text-gray-400">{{ res.created_at }}</span>
                                            </div>
                                            <p class="font-bold text-gray-900 text-[11px] line-clamp-1 italic">"{{ res.pesan }}"</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                                        <div :class="['px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-tight border', getStatusColor(res.status)]">
                                            {{ getStatusLabel(res.status) }}
                                        </div>
                                        <a :href="getWhatsAppLink(res)" target="_blank" 
                                            class="flex items-center gap-2 text-[10px] font-black text-emerald-600 hover:text-emerald-700 transition-colors">
                                            <i class="fab fa-whatsapp"></i> Chat Admin
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Layanan Darurat (Moved to bottom) -->
                        <div
                            class="p-10 bg-gradient-to-br from-gray-900 to-slate-800 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
                            <i class="fas fa-headset absolute -right-6 -top-6 text-[150px] opacity-10"></i>
                            <h4 class="text-2xl font-black mb-4 relative z-10 font-poppins">Layanan Darurat?</h4>
                            <p class="text-gray-400 mb-8 relative z-10 leading-relaxed">Untuk kejadian darurat
                                (Kebakaran, Kriminalitas, Bencana), silakan hubungi pusat panggilan darurat atau
                                langsung datangi Kantor Lurah.</p>
                            <div class="flex gap-4 relative z-10">
                                <a href="tel:112"
                                    class="p-4 bg-white/20 backdrop-blur-md rounded-2xl hover:bg-white/30 transition-colors">
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
