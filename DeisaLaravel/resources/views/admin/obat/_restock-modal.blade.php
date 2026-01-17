<div id="restockModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-100">
        <div class="bg-deisa-blue px-6 py-4 flex justify-between items-center text-white">
            <h4 class="font-bold text-lg">Restock Obat</h4>
            <button onclick="closeRestockModal()"
                class="text-white hover:text-blue-100 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6">
            <form id="restockForm" method="POST" class="space-y-4" data-ajax="true" data-reload="true">
                @csrf
                <!-- Dynamic Action URL via JS -->

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Masuk</label>
                    <input type="number"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                        name="jumlah" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan / Supplier</label>
                    <input type="text"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                        name="keterangan" placeholder="Contoh: Pembelian dari Kimia Farma">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" class="px-4 py-2 border rounded-lg"
                        onclick="closeRestockModal()">Batal</button>
                    <button type="submit" class="bg-deisa-blue text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRestockModal(id) {
        document.getElementById('restockModal').classList.remove('hidden');
        // Set dynamic route
        const form = document.getElementById('restockForm');
        form.action = `/admin/obat/${id}/restock`;
    }
    function closeRestockModal() {
        document.getElementById('restockModal').classList.add('hidden');
    }
</script>