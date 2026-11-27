<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Layanan Laundry') }}
            </h2>
            <a href="{{ route('admin.pakets.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                + Tambah Layanan
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

            @if (session('error'))
                <div class="p-4 rounded-md bg-red-50 border border-red-200 text-red-800 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">#</th>
                                <th class="px-6 py-3 text-left font-medium">Nama Layanan</th>
                                <th class="px-6 py-3 text-center font-medium">Satuan</th>
                                <th class="px-6 py-3 text-right font-medium">Harga</th>
                                <th class="px-6 py-3 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($pakets as $index => $paket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $paket->nama_paket }}</td>
                                    <td class="px-6 py-4 text-center text-gray-700 uppercase">{{ $paket->satuan }}</td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.pakets.edit', $paket) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600">
                                            Ubah
                                        </a>

                                        <form action="{{ route('admin.pakets.destroy', $paket) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan {{ $paket->nama_paket }}?')">
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
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data layanan (contoh: Reguler, Ekspress, Superkilat).
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