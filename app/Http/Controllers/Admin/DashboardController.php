<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPelanggan = Transaksi::distinct()->count('nama_pelanggan');
        $totalPaket = Paket::count();
        $totalTransaksi = Transaksi::count();
        $totalKasir = User::where('role', 'kasir')->count();

        $pendapatanLunas = Transaksi::where('status_bayar', 'lunas')->sum('total_harga');
        $piutangBelumLunas = Transaksi::where('status_bayar', 'belum lunas')->sum('total_harga');

        $cucianProses = Transaksi::where('status_cucian', 'proses')->count();
        $cucianSelesai = Transaksi::where('status_cucian', 'selesai')->count();

        $transaksiTerbaru = Transaksi::with(['paket'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'totalPaket',
            'totalTransaksi',
            'totalKasir',
            'pendapatanLunas',
            'piutangBelumLunas',
            'cucianProses',
            'cucianSelesai',
            'transaksiTerbaru'
        ));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}