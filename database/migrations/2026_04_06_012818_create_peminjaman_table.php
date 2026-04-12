<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();

            // STATUS PEMINJAMAN
            $table->enum('status', ['pengajuan', 'dipinjam', 'dikembalikan', 'ditolak'])
                  ->default('pengajuan');

            // DENDA
            $table->decimal('denda', 10, 2)->default(0);

            // JENIS DENDA
            $table->enum('jenis_denda', ['terlambat', 'rusak', 'hilang'])->nullable();

            // STATUS DENDA
            $table->enum('status_denda', ['belum_bayar', 'menunggu_verifikasi', 'lunas'])
                  ->default('belum_bayar');

            // PEMBAYARAN
            $table->string('metode_pembayaran')->nullable();
            $table->date('tanggal_bayar')->nullable();

            // KETERANGAN 
            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};