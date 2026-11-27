<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Layanan Laundry') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <form action="{{ route('admin.pakets.update', $paket) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_paket" class="block text-sm font-medium text-gray-700">
                            Nama Layanan
                        </label>
                        <input type="text"
                               name="nama_paket"
                               id="nama_paket"
                               value="{{ old('nama_paket', $paket->nama_paket) }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('nama_paket')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700">
                            Satuan
                        </label>
                        <select name="satuan"
                                id="satuan"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="kg" @selected(old('satuan', $paket->satuan) === 'kg')>Kilogram (kg)</option>
                            <option value="pcs" @selected(old('satuan', $paket->satuan) === 'pcs')>Pieces (pcs)</option>
                        </select>
                        @error('satuan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">
                            Harga (Rp)
                        </label>
                        <input type="number"
                               name="harga"
                               id="harga"
                               value="{{ old('harga', $paket->harga) }}"
                               min="0"
                               step="1"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @error('harga')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('admin.pakets.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-700">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>