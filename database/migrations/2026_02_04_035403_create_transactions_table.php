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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('books')->onDelete('cascade');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo'); // Batas waktu maksimal pengembalian
            $table->date('tanggal_kembali')->nullable(); // Diisi hanya saat buku dikembalikan

            // Status peminjaman
            $table->enum('status', ['pinjam', 'terlambat', 'kembali', 'hilang'])->default('pinjam');

            // Denda dibuat default 0 dan tidak bisa minus
            $table->unsignedInteger('denda')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
