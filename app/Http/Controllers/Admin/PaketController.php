<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaketController extends Controller
{
    public function index(): View
    {
        $pakets = Paket::latest()->get();

        return view('admin.pakets.index', compact('pakets'));
    }

    public function create(): View
    {
        return view('admin.pakets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_paket' => ['required', 'string', 'max:100'],
            'satuan' => ['required', 'in:kg,pcs'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        Paket::create($validated);

        return redirect()
            ->route('admin.pakets.index')
            ->with('success', 'Layanan laundry berhasil ditambahkan.');
    }

    public function show(Paket $paket): View
    {
        return view('admin.pakets.show', compact('paket'));
    }

    public function edit(Paket $paket): View
    {
        return view('admin.pakets.edit', compact('paket'));
    }

    public function update(Request $request, Paket $paket): RedirectResponse
    {
        $validated = $request->validate([
            'nama_paket' => ['required', 'string', 'max:100'],
            'satuan' => ['required', 'in:kg,pcs'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        $paket->update($validated);

        return redirect()
            ->route('admin.pakets.index')
            ->with('success', 'Layanan laundry berhasil diperbarui.');
    }

    public function destroy(Paket $paket): RedirectResponse
    {
        if ($paket->transaksis()->exists()) {
            return redirect()
                ->route('admin.pakets.index')
                ->with('error', 'Layanan tidak bisa dihapus karena sudah digunakan pada transaksi.');
        }

        $paket->delete();

        return redirect()
            ->route('admin.pakets.index')
            ->with('success', 'Layanan laundry berhasil dihapus.');
    }
}