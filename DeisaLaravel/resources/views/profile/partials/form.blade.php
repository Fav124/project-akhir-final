<x-card>
    <form action="{{ route('profile.update') }}" method="POST" data-ajax="true" data-reload="true" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
            <div
                class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-deisa-blue text-2xl font-bold border-4 border-white shadow-sm">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-lg">{{ $user->name }}</h3>
                <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                <span
                    class="inline-flex mt-1 px-2 py-0.5 rounded-full bg-blue-50 text-deisa-blue text-[10px] font-bold uppercase tracking-wider">
                    {{ $user->role }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ $user->profile?->phone }}"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Bio Singkat</label>
            <textarea name="bio" rows="2"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ $user->profile?->bio }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
            <textarea name="address" rows="2"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">{{ $user->profile?->address }}</textarea>
        </div>

        <div class="pt-4">
            <x-button type="submit" class="w-full py-3">Simpan Perubahan</x-button>
        </div>
    </form>
</x-card>