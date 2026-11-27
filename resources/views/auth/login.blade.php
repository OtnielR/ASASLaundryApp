<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Staf - {{ config('app.name', 'Sistem Manajemen Laundry') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-100 text-slate-800 font-sans">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12">

        {{-- Panel Samping Kiri (Identitas & Info Peran Staf) --}}
        <div class="lg:col-span-5 bg-slate-900 text-white p-8 sm:p-12 flex flex-col justify-between">
            <div class="space-y-8">
                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                        <span class="w-10 h-10 rounded-xl bg-teal-500 text-slate-950 font-bold text-lg flex items-center justify-center">
                            L
                        </span>
                        <div>
                            <span class="font-bold text-base tracking-tight block leading-none">
                                {{ config('app.name', 'LaundrySys') }}
                            </span>
                            <span class="text-xs text-slate-400">Console Operasional</span>
                        </div>
                    </a>

                    <a href="{{ url('/') }}"
                       class="text-xs text-slate-300 hover:text-white underline underline-offset-4 transition">
                        Beranda
                    </a>
                </div>

                <div class="space-y-4 pt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-500/15 text-teal-300 border border-teal-400/20">
                        Autentikasi Internal Staf
                    </span>
                    <h1 class="text-3xl font-bold leading-snug tracking-tight">
                        Masuk ke ruang kerja operasional laundry.
                    </h1>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Sistem akan mengarahkan akun Anda secara otomatis ke panel yang sesuai setelah kredensial terverifikasi.
                    </p>
                </div>

                <div class="space-y-3 pt-2">
                    <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/70">
                        <p class="text-xs font-semibold uppercase tracking-wider text-teal-300">Role Admin</p>
                        <p class="text-xs text-slate-300 mt-1">
                            Kelola layanan (Reguler, Ekspress, Superkilat), data kasir, dan rekap operasional.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/70">
                        <p class="text-xs font-semibold uppercase tracking-wider text-sky-300">Role Kasir</p>
                        <p class="text-xs text-slate-300 mt-1">
                            Input transaksi masuk, kelola pelanggan, serta perbarui status cucian dan pembayaran.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-10 text-xs text-slate-400 flex items-center justify-between border-t border-slate-800 mt-10">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'LaundrySys') }}</span>
                <span>Akses Terbatas</span>
            </div>
        </div>

        {{-- Panel Form Login Kanan --}}
        <div class="lg:col-span-7 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-7 sm:p-9 space-y-6">
                <div class="space-y-1.5">
                    <h2 class="text-2xl font-bold text-slate-900">Sign In</h2>
                    <p class="text-sm text-slate-500">
                        Masukkan email dan password akun staf Anda.
                    </p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-2" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email Address --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Alamat Email
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="nama@laundry.local"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-slate-700">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-medium text-teal-700 hover:text-teal-800 hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500">
                            <span class="text-sm text-slate-600">Ingat sesi saya</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition cursor-pointer">
                        Masuk ke Sistem
                    </button>
                </form>

                <div class="pt-4 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Registrasi akun mandiri dinonaktifkan. Hubungi Admin jika perlu akun baru.
                    </p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>