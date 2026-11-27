<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function index(): View
    {
        $transaksis = Transaksi::with(['paket', 'user'])
            ->latest()
            ->paginate(15);

        return view('kasir.transaksis.index', compact('transaksis'));
    }

    public function create(): View
    {
        $pakets = Paket::orderBy('nama_paket')->get();

        return view('kasir.transaksis.create', compact('pakets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:100'],
            'paket_id' => ['required', 'exists:pakets,id'],
            'berat_atau_jumlah' => ['required', 'numeric', 'min:0.1'],
            'status_bayar' => ['required', 'in:lunas,belum lunas'],
            'status_cucian' => ['nullable', 'in:proses,selesai,diambil'],
            'tanggal_masuk' => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($validated) {
            $paket = Paket::findOrFail($validated['paket_id']);
            $beratAtauJumlah = (float) $validated['berat_atau_jumlah'];
            $totalHarga = (int) round($paket->harga * $beratAtauJumlah);

            $kodeInvoice = 'INV-' . now()->format('Ymd') . '-' . strtoupper(str()->random(4));

            Transaksi::create([
                'kode_invoice' => $kodeInvoice,
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'paket_id' => $paket->id,
                'berat_atau_jumlah' => $beratAtauJumlah,
                'total_harga' => $totalHarga,
                'status_bayar' => $validated['status_bayar'],
                'status_cucian' => $validated['status_cucian'] ?? 'proses',
                'tanggal_masuk' => $validated['tanggal_masuk'] ?? now()->toDateString(),
                'tanggal_selesai' => in_array($validated['status_cucian'] ?? 'proses', ['selesai', 'diambil'], true)
                    ? now()->toDateString()
                    : null,
            ]);
        }); 

        return redirect()
            ->route('kasir.dashboard.index')
            ->with('success', 'Transaksi laundry berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi): View
    {
        $pakets = Paket::orderBy('nama_paket')->get();

        return view('kasir.transaksis.edit', compact('transaksi', 'pakets'));
    }

    public function update(Request $request, Transaksi $transaksi): RedirectResponse
    {
        // Mendukung update khusus status dari tabel/form cepat maupun update lengkap
        if ($request->hasAny(['status_bayar', 'status_cucian']) && !$request->has('paket_id')) {
            $validated = $request->validate([
                'status_bayar' => ['required', 'in:lunas,belum lunas'],
                'status_cucian' => ['required', 'in:proses,selesai,diambil'],
            ]);

            $tanggalSelesai = match ($validated['status_cucian']) {
                'selesai', 'diambil' => $transaksi->tanggal_selesai ?? now()->toDateString(),
                default => null,
            };

            $transaksi->update([
                'status_bayar' => $validated['status_bayar'],
                'status_cucian' => $validated['status_cucian'],
                'tanggal_selesai' => $tanggalSelesai,
            ]);

            return back()->with('success', 'Status transaksi berhasil diperbarui.');
        }

        $validated = $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:100'],
            'paket_id' => ['required', 'exists:pakets,id'],
            'berat_atau_jumlah' => ['required', 'numeric', 'min:0.1'],
            'status_bayar' => ['required', 'in:lunas,belum lunas'],
            'status_cucian' => ['required', 'in:proses,selesai,diambil'],
            'tanggal_masuk' => ['nullable', 'date'],
        ]);

        $paket = Paket::findOrFail($validated['paket_id']);
        $beratAtauJumlah = (float) $validated['berat_atau_jumlah'];
        $totalHarga = (int) round($paket->harga * $beratAtauJumlah);

        $tanggalSelesai = match ($validated['status_cucian']) {
            'selesai', 'diambil' => $transaksi->tanggal_selesai ?? now()->toDateString(),
            default => null,
        };

        $transaksi->update([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'paket_id' => $paket->id,
            'berat_atau_jumlah' => $beratAtauJumlah,
            'total_harga' => $totalHarga,
            'status_bayar' => $validated['status_bayar'],
            'status_cucian' => $validated['status_cucian'],
            'tanggal_masuk' => $validated['tanggal_masuk'] ?? $transaksi->tanggal_masuk,
            'tanggal_selesai' => $tanggalSelesai,
        ]);

        return redirect()
            ->route('kasir.transaksis.index')
            ->with('success', 'Data dan status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi): RedirectResponse
    {
        $transaksi->delete();

        return redirect()
            ->route('kasir.transaksis.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}