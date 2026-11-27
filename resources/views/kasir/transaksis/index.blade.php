<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Transaksi Laundry') }}
            </h2>
            <a href="{{ route('kasir.transaksis.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                + Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-md bg-red-50 border border-red-200 text-red-800 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Invoice</th>
                                <th class="px-6 py-3 text-left font-medium">Pelanggan</th>
                                <th class="px-6 py-3 text-left font-medium">Paket</th>
                                <th class="px-6 py-3 text-right font-medium">Berat / Jumlah</th>
                                <th class="px-6 py-3 text-right font-medium">Total Harga</th>
                                <th class="px-6 py-3 text-left font-medium">Ubah Status Cepat</th>
                                <th class="px-6 py-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($transaksis as $transaksi)
                                <tr class="hover:bg-gray-50 align-top">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $transaksi->kode_invoice }}</div>
                                        <div class="text-xs text-gray-500">
                                            Masuk: {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                        {{ $transaksi->pelanggan->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                        {{ $transaksi->paket->nama_paket ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-700 whitespace-nowrap">
                                        {{ rtrim(rtrim(number_format($transaksi->berat_atau_jumlah, 2, '.', ''), '0'), '.') }}
                                        {{ $transaksi->paket->satuan ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('kasir.transaksis.update', $transaksi) }}"
                                              method="POST"
                                              class="flex flex-wrap items-center gap-2">
                                            @csrf
                                            @method('PUT')

                                            <select name="status_bayar"
                                                    aria-label="Status Pembayaran"
                                                    class="rounded-md border-gray-300 text-xs py-1.5 pr-7 focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="belum lunas" @selected($transaksi->status_bayar === 'belum lunas')>
                                                    Belum Lunas
                                                </option>
                                                <option value="lunas" @selected($transaksi->status_bayar === 'lunas')>
                                                    Lunas
                                                </option>
                                            </select>

                                            <select name="status_cucian"
                                                    aria-label="Status Cucian"
                                                    class="rounded-md border-gray-300 text-xs py-1.5 pr-7 focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="proses" @selected($transaksi->status_cucian === 'proses')>
                                                    Proses
                                                </option>
                                                <option value="selesai" @selected($transaksi->status_cucian === 'selesai')>
                                                    Selesai
                                                </option>
                                                <option value="diambil" @selected($transaksi->status_cucian === 'diambil')>
                                                    Diambil
                                                </option>
                                            </select>

                                            <button type="submit"
                                                    class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700">
                                                Simpan Status
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('kasir.transaksis.edit', $transaksi) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('kasir.transaksis.destroy', $transaksi) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $transaksi->kode_invoice }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transaksis->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $transaksis->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>