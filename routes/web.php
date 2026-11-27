<?php
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Kasir\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('dashboard', AdminDashboardController::class);
        Route::resource('pakets', PaketController::class);
    });

Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {
        Route::resource('dashboard', KasirDashboardController::class);
        Route::resource('transaksis', TransaksiController::class);
    });

require __DIR__.'/auth.php';