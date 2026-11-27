<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice', 30)->unique();
            $table->string('nama_pelanggan', 100);
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('restrict');
            $table->decimal('berat_atau_jumlah', 8, 2);
            $table->integer('total_harga');
            $table->enum('status_bayar', ['lunas', 'belum lunas'])->default('belum lunas');
            $table->enum('status_cucian', ['proses', 'selesai', 'diambil'])->default('proses');
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
