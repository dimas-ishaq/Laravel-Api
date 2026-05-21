<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua daftar Transaction peminjaman.
     */
    public function index()
    {
        // Mengambil semua Transaction beserta data user dan buku (Eager Loading)
        $transactions = Transaction::with(['user', 'buku'])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ], 200);
    }

    /**
     * Memproses pembuatan Transaction peminjaman baru (User Pinjam Buku).
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:books,id',
        ]);

        // 2. Set tanggal otomatis menggunakan Carbon
        $tanggalPinjam = Carbon::now()->toDateString(); // Hari ini
        $tanggalJatuhTempo = Carbon::now()->addDays(7)->toDateString(); // Otomatis +7 hari ke depan

        // 3. Simpan ke database
        $transaction = Transaction::create([
            'user_id'             => $request->user_id,
            'buku_id'             => $request->buku_id,
            'tanggal_pinjam'      => $tanggalPinjam,
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'tanggal_kembali'     => null, // Baru pinjam, jadi masih kosong
            'status'              => 'pinjam',
            'denda'               => 0, // Default awal 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dipinjam. Batas pengembalian: ' . $tanggalJatuhTempo,
            'data'    => $transaction
        ], 21);
    }

    /**
     * Menampilkan detail satu Transaction tertentu.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['user', 'buku'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $transaction], 200);
    }

    /**
     * Memproses pengembalian buku dan hitung denda otomatis.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction tidak ditemukan'], 404);
        }

        // Cek apakah buku sudah pernah dikembalikan sebelumnya
        if ($transaction->status === 'kembali') {
            return response()->json(['message' => 'Buku ini sudah dikembalikan sebelumnya'], 400);
        }

        $tanggalKembali = Carbon::now(); // Tanggal hari ini saat dia mengembalikan
        $tanggalJatuhTempo = Carbon::parse($transaction->tanggal_jatuh_tempo);

        $denda = 0;
        $status = 'kembali';
        $selisihHari = 0;

        // Hitung denda jika tanggal kembali melewati jatuh tempo
        if ($tanggalKembali->gt($tanggalJatuhTempo)) {
            $selisihHari = $tanggalKembali->diffInDays($tanggalJatuhTempo);

            $tarifDendaPerHari = 2000; // Contoh: Denda Rp 2.000 per hari
            $denda = $selisihHari * $tarifDendaPerHari;
            $status = 'terlambat'; // opsional, atau tetap diset 'kembali' tapi dendanya tercatat
        }

        // Update data Transaction
        $transaction->update([
            'tanggal_kembali' => $tanggalKembali->toDateString(),
            'status'          => 'kembali', // Kita kunci statusnya jadi kembali karena bukunya sudah pulang
            'denda'           => $denda
        ]);

        return response()->json([
            'success' => true,
            'message' => $denda > 0
                ? "Buku dikembalikan, Anda terlambat {$selisihHari} hari. Denda: Rp " . number_format($denda, 0, ',', '.')
                : "Buku dikembalikan tepat waktu. Terima kasih!",
            'data'    => $transaction
        ], 200);
    }

    /**
     * Menghapus data Transaction (Opsional/Pembatalan).
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction tidak ditemukan'], 404);
        }

        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Data Transaction berhasil dihapus'], 200);
    }
}
