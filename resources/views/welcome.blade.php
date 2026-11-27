<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Manajemen Laundry') }} - Portal Staf</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-800 font-sans">
    <div class="min-h-screen flex flex-col justify-between">

        {{-- Header Internal --}}
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-900 text-white font-bold text-base">
                        L
                    </span>
                    <div>
                        <span class="font-bold text-base text-gray-900 block leading-none">
                            {{ config('app.name', 'LaundrySys') }}
                        </span>
                        <span class="text-xs text-gray-500">Sistem Operasional Internal</span>
                    </div>
                </div>

                @if (Route::has('login'))
                    <div>
                        @auth
                            @php
                                $dashboardUrl = auth()->user()->role === 'admin'
                                    ? route('admin.dashboard.index')
                                    : (auth()->user()->role === 'kasir' ? route('kasir.dashboard') : route('dashboard'));
                            @endphp
                            <a href="{{ $dashboardUrl }}"
                               class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                                Login Staf
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </header>

        {{-- Konten Utama (Portal Admin & Kasir) --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="max-w-3xl w-full bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-10 space-y-8">
                <div class="text-center space-y-3">
                    <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full bg-gray-100 text-gray-700">
                        Akses Terbatas • Admin & Kasir
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                        Portal Manajemen Operasional Laundry
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 max-w-xl mx-auto">
                        Halaman ini khusus digunakan oleh petugas internal untuk mengelola data pelanggan, jenis layanan, transaksi harian, dan laporan pembayaran.
                    </p>
                </div>

                {{-- Ringkasan Hak Akses Peran --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-xl bg-gray-50 border border-gray-200 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-gray-900 text-base">Admin</h2>
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-indigo-100 text-indigo-800">
                                Pengelola
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Mengelola master layanan cuci (Reguler, Ekspress, Superkilat), akun kasir, serta memantau ringkasan pendapatan dan status operasional.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl bg-gray-50 border border-gray-200 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-gray-900 text-base">Kasir</h2>
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                Operasional
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Mencatat data pelanggan, membuat transaksi masuk, memperbarui status pembayaran (lunas/belum lunas), dan status pengerjaan cucian.
                        </p>
                    </div>
                </div>

                {{-- Tombol Aksi Login Tunggal --}}
                <div class="pt-2 flex flex-col items-center space-y-3">
                    @auth
                        <a href="{{ $dashboardUrl }}"
                           class="w-full sm:w-auto px-8 py-3 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition text-center">
                            Masuk ke Dashboard ({{ ucfirst(auth()->user()->role) }})
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full sm:w-auto px-8 py-3 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition text-center">
                            Login ke Sistem
                        </a>
                        <p class="text-xs text-gray-500">
                            Belum memiliki akun? Hubungi Admin untuk pembuatan akun staf.
                        </p>
                    @endauth
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-2">
                <p>© {{ date('Y') }} {{ config('app.name', 'LaundrySys') }}.</p>
                <p>Akses Internal Staf Laundry</p>
            </div>
        </footer>

    </div>
</body>
</html>