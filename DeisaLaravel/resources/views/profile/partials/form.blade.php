    <div x-data="{ 
        tab: 'info',
        selectedTheme: '{{ $user->profile?->settings['theme_color'] ?? 'deisa-blue' }}',
        updateTheme(theme) {
            console.log('Theme changed to:', theme);
            const map = {
                'deisa-blue': '#0B63D6',
                'indigo-600': '#4f46e5',
                'emerald-600': '#059669',
                'rose-600': '#e11d48'
            };
            document.documentElement.style.setProperty('--color-deisa-blue', map[theme] || theme);
        },
        init() {
            this.$watch('selectedTheme', (value) => this.updateTheme(value));
        }
    }" class="space-y-6">
    <!-- Tab Navigation -->
    <div class="flex gap-1 p-1 bg-slate-100 rounded-2xl w-fit">
        <button @click="tab = 'info'" :class="tab === 'info' ? 'bg-white text-deisa-blue shadow-sm' : 'text-slate-500 hover:text-slate-700'"
            class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Pribadi</button>
        <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'bg-white text-deisa-blue shadow-sm' : 'text-slate-500 hover:text-slate-700'"
            class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Tampilan</button>
        <button @click="tab = 'security'" :class="tab === 'security' ? 'bg-white text-deisa-blue shadow-sm' : 'text-slate-500 hover:text-slate-700'"
            class="px-6 py-2 rounded-xl text-sm font-bold transition-all">Keamanan</button>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" data-ajax="true" data-reload="true" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- TAB: INFO PRIBADI -->
        <div x-show="tab === 'info'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            <x-card class="border-0 shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <!-- Avatar Upload -->
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <input type="file" class="hidden" x-ref="photo" name="avatar"
                            @change="
                                photoName = $event.target.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($event.target.files[0]);
                            ">
                        
                        <div class="relative group cursor-pointer" @click="$refs.photo.click()">
                            <div class="w-32 h-32 rounded-3xl bg-blue-50 border-4 border-white shadow-lg overflow-hidden flex items-center justify-center">
                                <template x-if="!photoPreview">
                                    @if($user->profile?->avatar)
                                        <img src="{{ Storage::url($user->profile->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-4xl font-black text-deisa-blue">{{ substr($user->name, 0, 1) }}</div>
                                    @endif
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 rounded-3xl flex items-center justify-center transition-all">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4 w-full">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                    class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ $user->profile?->phone }}"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Bio Singkat</label>
                            <textarea name="bio" rows="2"
                                class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ $user->profile?->bio }}</textarea>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card class="border-0 shadow-sm">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3"
                        class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ $user->profile?->address }}</textarea>
                </div>
            </x-card>
        </div>

        <div x-show="tab === 'appearance'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <x-card class="border-0 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-1">Warna Tema Utama</h4>
                <p class="text-xs text-slate-500 mb-6">Pilih warna yang paling nyaman bagi Anda.</p>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @php
                        $colors = [
                            'deisa-blue' => ['bg' => 'bg-blue-500', 'name' => 'Original Blue', 'hex' => '#0B63D6'],
                            'indigo-600' => ['bg' => 'bg-indigo-600', 'name' => 'Royal Indigo', 'hex' => '#4f46e5'],
                            'emerald-600' => ['bg' => 'bg-emerald-600', 'name' => 'Nature Green', 'hex' => '#059669'],
                            'rose-600' => ['bg' => 'bg-rose-600', 'name' => 'Elegant rose', 'hex' => '#e11d48'],
                        ];
                    @endphp
                    @foreach($colors as $val => $info)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="theme_color" value="{{ $val }}" 
                                   class="sr-only" 
                                   x-model="selectedTheme">
                            
                            <div class="p-4 rounded-3xl border-2 transition-all duration-300"
                                 :class="selectedTheme === '{{ $val }}' ? 'border-deisa-blue bg-blue-50/30 ring-4 ring-blue-500/10' : 'border-slate-100 hover:border-slate-200 bg-white'">
                                
                                <div class="w-full h-16 rounded-2xl {{ $info['bg'] }} mb-3 shadow-inner relative overflow-hidden">
                                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <!-- Selection Indicator -->
                                    <div x-show="selectedTheme === '{{ $val }}'"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="scale-0 opacity-0"
                                         x-transition:enter-end="scale-100 opacity-100"
                                         class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-8 h-8 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg border border-white/30">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-[10px] font-black text-center uppercase tracking-widest transition-colors"
                                     :class="selectedTheme === '{{ $val }}' ? 'text-deisa-blue' : 'text-slate-400'">
                                    {{ $info['name'] }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </x-card>
        </div>

        <!-- TAB: KEAMANAN -->
        <div x-show="tab === 'security'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <x-card class="border-0 shadow-sm space-y-4">
                <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex gap-3 text-amber-800">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xs">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kata Sandi Baru</label>
                        <input type="password" name="new_password"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                </div>
            </x-card>
        </div>

        <div class="pt-4">
            <x-button type="submit" class="w-full py-4 rounded-2xl shadow-lg shadow-blue-500/20">Simpan Seluruh Perubahan</x-button>
        </div>
    </form>
</div>