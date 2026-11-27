<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Kasir') }}
            </h2>
            <div class="flex items-center space-x-2">
            <a href="{{ route('kasir.transaksis.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                + Tambah Transaksi
            </a>
                    </div>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ringkasan Operasional Kasir --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ number_format($totalPelanggan) }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Transaksi Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ number_format($transaksiHariIni) }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Cucian Diproses</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">
                        {{ number_format($cucianProses) }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Cucian Selesai</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600">
                        {{ number_format($cucianSelesai) }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm font-medium text-gray-500">Belum Lunas</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">
                        {{ number_format($belumLunas) }}
                    </p>
                </div>
            </div>

            {{-- Tabel Transaksi Terbaru --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    <span class="text-xs text-gray-500">10 transaksi terakhir</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Invoice</th>
                                <th class="px-6 py-3 text-left font-medium">Pelanggan</th>
                                <th class="px-6 py-3 text-left font-medium">Paket</th>
                                <th class="px-6 py-3 text-right font-medium">Berat / Jumlah</th>
                                <th class="px-6 py-3 text-right font-medium">Total Harga</th>
                                <th class="px-6 py-3 text-center font-medium">Pembayaran</th>
                                <th class="px-6 py-3 text-center font-medium">Status Cucian</th>
                                <th class="px-6 py-3 text-left font-medium">Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($transaksiTerbaru as $transaksi)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $transaksi->kode_invoice }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                        {{ $transaksi->nama_pelanggan ?? '-' }}
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
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @if ($transaksi->status_bayar === 'lunas')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                Belum Lunas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @switch($transaksi->status_cucian)
                                            @case('selesai')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    Selesai
                                                </span>
                                                @break
                                            @case('diambil')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                                    Diambil
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Proses
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>