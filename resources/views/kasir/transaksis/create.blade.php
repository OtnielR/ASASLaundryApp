<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi Laundry') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <form action="{{ route('kasir.transaksis.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">
                            Nama Pelanggan
                        </label>
                        <input type="text"
                               name="nama_pelanggan"
                               id="nama_pelanggan"
                               value="{{ old('nama_pelanggan') }}"
                               maxlength="100"
                               placeholder="Contoh: Budi Santoso"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('nama_pelanggan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="paket_id" class="block text-sm font-medium text-gray-700">
                            Paket Layanan
                        </label>
                        <select name="paket_id"
                                id="paket_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="" data-harga="0" data-satuan="">-- Pilih Paket --</option>
                            @foreach ($pakets as $paket)
                                <option value="{{ $paket->id }}"
                                        data-harga="{{ $paket->harga }}"
                                        data-satuan="{{ $paket->satuan }}"
                                        @selected(old('paket_id') == $paket->id)>
                                    {{ $paket->nama_paket }} — Rp {{ number_format($paket->harga, 0, ',', '.') }} / {{ $paket->satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('paket_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_atau_jumlah" class="block text-sm font-medium text-gray-700">
                            Berat / Jumlah <span id="satuan-label" class="text-gray-400"></span>
                        </label>
                        <input type="number"
                               name="berat_atau_jumlah"
                               id="berat_atau_jumlah"
                               value="{{ old('berat_atau_jumlah') }}"
                               step="0.01"
                               min="0.1"
                               placeholder="Contoh: 3.5"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('berat_atau_jumlah')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status_bayar" class="block text-sm font-medium text-gray-700">
                                Status Pembayaran
                            </label>
                            <select name="status_bayar"
                                    id="status_bayar"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="belum lunas" @selected(old('status_bayar', 'belum lunas') === 'belum lunas')>
                                    Belum Lunas
                                </option>
                                <option value="lunas" @selected(old('status_bayar') === 'lunas')>
                                    Lunas
                                </option>
                            </select>
                            @error('status_bayar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status_cucian" class="block text-sm font-medium text-gray-700">
                                Status Cucian
                            </label>
                            <select name="status_cucian"
                                    id="status_cucian"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="proses" @selected(old('status_cucian', 'proses') === 'proses')>
                                    Proses
                                </option>
                                <option value="selesai" @selected(old('status_cucian') === 'selesai')>
                                    Selesai
                                </option>
                                <option value="diambil" @selected(old('status_cucian') === 'diambil')>
                                    Diambil
                                </option>
                            </select>
                            @error('status_cucian')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">
                            Tanggal Masuk
                        </label>
                        <input type="date"
                               name="tanggal_masuk"
                               id="tanggal_masuk"
                               value="{{ old('tanggal_masuk', now()->toDateString()) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('tanggal_masuk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Estimasi Total Harga</span>
                        <span id="estimasi-total" class="text-lg font-bold text-gray-900">Rp 0</span>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('kasir.transaksis.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-700">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const paketSelect = document.getElementById('paket_id');
            const beratInput = document.getElementById('berat_atau_jumlah');
            const totalDisplay = document.getElementById('estimasi-total');
            const satuanLabel = document.getElementById('satuan-label');

            function updateEstimasi() {
                const selectedOption = paketSelect.options[paketSelect.selectedIndex];
                const harga = parseFloat(selectedOption?.dataset?.harga || 0);
                const satuan = selectedOption?.dataset?.satuan || '';
                const berat = parseFloat(beratInput.value || 0);

                satuanLabel.textContent = satuan ? `(${satuan})` : '';

                const total = harga > 0 && berat > 0 ? Math.round(harga * berat) : 0;
                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            paketSelect.addEventListener('change', updateEstimasi);
            beratInput.addEventListener('input', updateEstimasi);
            updateEstimasi();
        })();
    </script>
</x-app-layout>