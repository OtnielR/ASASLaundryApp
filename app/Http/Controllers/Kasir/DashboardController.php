<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPelanggan = Transaksi::distinct()->count('nama_pelanggan');        $transaksiHariIni = Transaksi::whereDate('tanggal_masuk', today())->count();
        $cucianProses = Transaksi::where('status_cucian', 'proses')->count();
        $cucianSelesai = Transaksi::where('status_cucian', 'selesai')->count();
        $belumLunas = Transaksi::where('status_bayar', 'belum lunas')->count();

        $transaksiTerbaru = Transaksi::with('paket')
            ->latest()
            ->take(10)
            ->get();

        return view('kasir.dashboard', compact(
            'totalPelanggan',
            'transaksiHariIni',
            'cucianProses',
            'cucianSelesai',
            'belumLunas',
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