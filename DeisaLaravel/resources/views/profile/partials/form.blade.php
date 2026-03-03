@php
    $rawSettings = $user->profile?->settings;
    if (is_string($rawSettings)) {
        $decoded = json_decode($rawSettings, true);
        $rawSettings = is_array($decoded) ? $decoded : [];
    }

    $savedTheme = $rawSettings['theme_color'] ?? 'deisa-blue';
    $requestedTab = request('tab', 'user');
    $allowedTabs = ['user', 'personalization', 'settings'];
    $activeTab = in_array($requestedTab, $allowedTabs, true) ? $requestedTab : 'user';

    $themePresets = [
        'deisa-blue' => ['bg' => 'bg-blue-500', 'name' => 'DEISA Blue', 'hex' => '#0B63D6'],
        'indigo-600' => ['bg' => 'bg-indigo-600', 'name' => 'Royal Indigo', 'hex' => '#4F46E5'],
        'emerald-600' => ['bg' => 'bg-emerald-600', 'name' => 'Emerald Care', 'hex' => '#059669'],
        'rose-600' => ['bg' => 'bg-rose-600', 'name' => 'Rose Focus', 'hex' => '#E11D48'],
    ];
@endphp

<div x-data="{
        tab: '{{ $activeTab }}',
        selectedTheme: '{{ $savedTheme }}',
        updateTheme(theme) {
            const map = {
                'deisa-blue': '#0B63D6',
                'indigo-600': '#4f46e5',
                'emerald-600': '#059669',
                'rose-600': '#e11d48'
            };
            document.documentElement.style.setProperty('--color-deisa-blue', map[theme] || '#0B63D6');
        },
        submitLabel() {
            if (this.tab === 'personalization') return 'Simpan Personalisasi';
            if (this.tab === 'settings') return 'Simpan Pengaturan';
            return 'Simpan Data User';
        },
        init() {
            this.updateTheme(this.selectedTheme);
            this.$watch('selectedTheme', (value) => this.updateTheme(value));
        }
    }" class="settings-shell space-y-6">

    <x-card class="border-0 shadow-sm settings-overview">
        <div class="flex flex-col md:flex-row md:items-center gap-5">
            <div class="flex items-center gap-4">
                <div class="settings-avatar rounded-3xl overflow-hidden border-4 border-white shadow-lg">
                    @if($user->profile?->avatar)
                        <img src="{{ Storage::url($user->profile->avatar) }}" class="w-full h-full object-cover" alt="Avatar {{ $user->name }}">
                    @else
                        <div class="w-full h-full bg-blue-50 text-deisa-blue flex items-center justify-center text-3xl font-black">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-deisa-blue text-[10px] font-black uppercase tracking-widest border border-blue-100">
                        {{ ucfirst($user->role) }}
                    </div>
                </div>
            </div>

            <div class="ml-auto settings-overview-info">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Halaman Personalisasi</div>
                <p class="text-sm text-slate-600 mt-1">Kelola data user, personalisasi tampilan aplikasi, dan pengaturan akun pada satu tempat.</p>
            </div>
        </div>
    </x-card>

    <div class="settings-tab-nav grid grid-cols-1 md:grid-cols-3 gap-3">
        <button type="button" @click="tab = 'user'"
            :class="tab === 'user' ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/20 border-deisa-blue' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-200'"
            class="w-full px-4 py-3 rounded-2xl border text-left transition-all">
            <div class="text-xs font-black uppercase tracking-wider">Data User</div>
            <div class="text-[11px] opacity-80 mt-1">Profil, kontak, dan bio</div>
        </button>

        <button type="button" @click="tab = 'personalization'"
            :class="tab === 'personalization' ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/20 border-deisa-blue' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-200'"
            class="w-full px-4 py-3 rounded-2xl border text-left transition-all">
            <div class="text-xs font-black uppercase tracking-wider">Personalisasi Aplikasi</div>
            <div class="text-[11px] opacity-80 mt-1">Tema warna dan tampilan</div>
        </button>

        <button type="button" @click="tab = 'settings'"
            :class="tab === 'settings' ? 'bg-deisa-blue text-white shadow-lg shadow-blue-500/20 border-deisa-blue' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-200'"
            class="w-full px-4 py-3 rounded-2xl border text-left transition-all">
            <div class="text-xs font-black uppercase tracking-wider">Pengaturan</div>
            <div class="text-[11px] opacity-80 mt-1">Keamanan & kata sandi</div>
        </button>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" data-ajax="true" data-reload="true" class="space-y-6">
        @csrf
        @method('PUT')

        <div x-show="tab === 'user'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            <x-card class="border-0 shadow-sm space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Informasi User</h4>
                        <p class="text-xs text-slate-500">Data dasar pengguna yang ditampilkan pada aplikasi.</p>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-6">
                    <div x-data="{
                            photoPreview: null,
                            processFile(file) {
                                if (!file || !file.type.startsWith('image/')) return;
                                const reader = new FileReader();
                                reader.onload = (e) => this.photoPreview = e.target.result;
                                reader.readAsDataURL(file);
                            },
                            onDrop(event) {
                                const file = event.dataTransfer.files[0];
                                if (!file) return;
                                const dt = new DataTransfer();
                                dt.items.add(file);
                                this.$refs.photo.files = dt.files;
                                this.processFile(file);
                            }
                        }" class="shrink-0">
                        <input type="file" class="hidden" x-ref="photo" name="avatar" data-no-auto-image @change="processFile($event.target.files[0])">

                        <button type="button" @click="$refs.photo.click()" @dragover.prevent @drop.prevent="onDrop($event)"
                            class="settings-avatar-picker group">
                            <template x-if="!photoPreview">
                                @if($user->profile?->avatar)
                                    <img src="{{ Storage::url($user->profile->avatar) }}" class="w-full h-full object-cover rounded-3xl" alt="Avatar {{ $user->name }}">
                                @else
                                    <div class="w-full h-full rounded-3xl bg-blue-50 flex items-center justify-center text-4xl font-black text-deisa-blue">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover rounded-3xl" alt="Avatar preview">
                            </template>
                            <span class="settings-avatar-badge">Ubah Foto</span>
                        </button>
                    </div>

                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->profile?->phone) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email (readonly)</label>
                            <input type="text" value="{{ $user->email }}" readonly
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Bio Singkat</label>
                            <textarea name="bio" rows="2"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ old('bio', $user->profile?->bio) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ old('address', $user->profile?->address) }}</textarea>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <div x-show="tab === 'personalization'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            <x-card class="border-0 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-1">Personalisasi Aplikasi</h4>
                <p class="text-xs text-slate-500 mb-6">Atur warna antarmuka sesuai preferensi Anda.</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($themePresets as $value => $theme)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="theme_color" value="{{ $value }}" class="sr-only" x-model="selectedTheme">

                            <div class="p-4 rounded-3xl border-2 transition-all duration-300"
                                :class="selectedTheme === '{{ $value }}' ? 'border-deisa-blue bg-blue-50/30 ring-4 ring-blue-500/10' : 'border-slate-100 hover:border-slate-200 bg-white'">
                                <div class="w-full h-16 rounded-2xl {{ $theme['bg'] }} mb-3 shadow-inner relative overflow-hidden">
                                    <div class="absolute right-2 top-2 px-2 py-0.5 rounded-full text-[9px] font-bold bg-white/20 text-white">{{ $theme['hex'] }}</div>

                                    <div x-show="selectedTheme === '{{ $value }}'" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="scale-0 opacity-0" x-transition:enter-end="scale-100 opacity-100"
                                        class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-8 h-8 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg border border-white/30">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-[10px] font-black text-center uppercase tracking-widest"
                                    :class="selectedTheme === '{{ $value }}' ? 'text-deisa-blue' : 'text-slate-400'">
                                    {{ $theme['name'] }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </x-card>
        </div>

        <div x-show="tab === 'settings'" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            <x-card class="border-0 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-800 mb-1">Pengaturan Keamanan</h4>
                <p class="text-xs text-slate-500 mb-2">Kosongkan kata sandi jika tidak ingin mengubahnya.</p>

                <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex gap-3 text-amber-800">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xs">Untuk keamanan, masukkan kata sandi saat ini sebelum menyimpan kata sandi baru.</p>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kata Sandi Baru</label>
                        <input type="password" name="new_password"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                    </div>
                </div>
            </x-card>
        </div>

        <div class="flex justify-end">
            <x-button class="px-6 py-2.5 rounded-xl shadow-lg shadow-blue-500/20">
                <span x-text="submitLabel()"></span>
            </x-button>
        </div>
    </form>
</div>
