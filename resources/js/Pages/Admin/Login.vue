<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const login = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login Admin" />

    <div class="min-h-screen bg-slate-900 flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Abstract Background -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-600 rounded-full blur-[120px]"></div>
        </div>

        <div class="w-full max-w-md relative z-10">
            <!-- Logo & Title -->
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-blue-600 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-blue-600/40 rotate-12 hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Admin<span class="text-blue-500">Panel</span></h1>
                <p class="text-slate-400 font-bold text-sm uppercase tracking-[0.2em] mt-2">Kelurahan Ujung Sabbang</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] p-10 shadow-3xl">
                <!-- Error Message -->
                <div v-if="form.errors.email" class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center gap-3 animate-shake">
                    <i class="fas fa-exclamation-circle text-rose-500 text-lg"></i>
                    <p class="text-xs font-bold text-rose-200 leading-relaxed">{{ form.errors.email }}</p>
                </div>

                <form @submit.prevent="login" class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                            <input v-model="form.email" type="email" placeholder="Masukkan email admin" 
                                class="w-full pl-12 pr-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-white outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Password</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                            <input v-model="form.password" :type="showPassword ? 'text' : 'password'" placeholder="Masukkan password" 
                                class="w-full pl-12 pr-12 py-4 bg-white/5 border border-white/10 rounded-2xl text-white outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                required>
                            <button @click.prevent="showPassword = !showPassword" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors">
                                <i :class="['fas', showPassword ? 'fa-eye-slash' : 'fa-eye']"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center cursor-pointer group">
                             <input type="checkbox" v-model="form.remember" class="hidden">
                             <div :class="['w-5 h-5 rounded-md border-2 mr-3 flex items-center justify-center transition-all', form.remember ? 'bg-blue-600 border-blue-600 shadow-lg shadow-blue-600/30' : 'border-white/10 bg-white/5']">
                                 <i v-if="form.remember" class="fas fa-check text-[10px] text-white"></i>
                             </div>
                             <span class="text-xs font-bold text-slate-400 group-hover:text-slate-300 transition-colors">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" 
                        :disabled="form.processing"
                        class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all active:scale-[0.98] mt-4 disabled:opacity-50">
                        {{ form.processing ? 'MEMPROSES...' : 'MASUK SEKARANG' }}
                    </button>
                </form>
            </div>

            <!-- Back to Website -->
            <div class="text-center mt-10">
                <Link href="/" class="text-slate-500 hover:text-white font-bold text-sm transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali ke Website Utama
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.shadow-3xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
}
</style>
