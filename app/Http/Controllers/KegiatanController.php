<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    /**
     * Menampilkan dashboard utama dan daftar seluruh kegiatan milik pengguna (mendukung filter tanggal).
     */
    public function index(Request $request): View
    {
        $userId = Auth::id();

        // Statistik Dashboard tetap menghitung seluruh kegiatan milik pengguna
        $totalKegiatan = Kegiatan::where('user_id', $userId)->count();
        $belumSelesai = Kegiatan::where('user_id', $userId)->where('status', 'belum selesai')->count();
        $sudahSelesai = Kegiatan::where('user_id', $userId)
            ->whereIn('status', ['selesai', 'sudah selesai'])
            ->count();

        // Validasi query parameter tanggal jika disertakan
        $request->validate([
            'tanggal' => ['nullable', 'date'],
        ]);

        $tanggal = $request->query('tanggal');

        // Mengambil daftar kegiatan pengguna aktif dengan opsi filter tanggal
        $query = Kegiatan::where('user_id', $userId);

        if (!empty($tanggal)) {
            $query->whereDate('tanggal_pelaksanaan', $tanggal);
        }

        $kegiatan = $query->orderBy('tanggal_pelaksanaan', 'asc')->get();

        return view('dashboard', compact('kegiatan', 'totalKegiatan', 'belumSelesai', 'sudahSelesai', 'tanggal'));
    }

    /**
     * Menampilkan halaman formulir tambah kegiatan baru.
     */
    public function create(): View
    {
        return view('kegiatan.create');
    }

    /**
     * Menyimpan kegiatan baru ke dalam database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_pelaksanaan' => ['required', 'date'],
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'tanggal_pelaksanaan.date' => 'Format tanggal pelaksanaan tidak valid.',
        ]);

        // Menyimpan data kegiatan dengan user_id dari sesi login dan status default 'belum selesai'
        Kegiatan::create([
            'user_id' => Auth::id(),
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],
            'status' => 'belum selesai',
        ]);

        return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit kegiatan milik pengguna.
     */
    public function edit(string $id): View
    {
        // Mengambil kegiatan melalui relasi user untuk memastikan kepemilikan data
        $kegiatan = Auth::user()->kegiatan()->findOrFail($id);

        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Memperbarui data kegiatan milik pengguna di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Mengambil kegiatan melalui relasi user untuk memastikan kepemilikan data
        $kegiatan = Auth::user()->kegiatan()->findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'status' => ['nullable', 'string', 'in:belum selesai,selesai'],
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter.',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'tanggal_pelaksanaan.date' => 'Format tanggal pelaksanaan tidak valid.',
            'status.in' => 'Status hanya boleh berisi belum selesai atau selesai.',
        ]);

        $updateData = [
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],
        ];

        if (isset($validated['status'])) {
            $updateData['status'] = $validated['status'];
        }

        $kegiatan->update($updateData);

        return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Mengubah status kegiatan milik pengguna (toggle antara 'belum selesai' dan 'selesai').
     */
    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        // Mengambil data kegiatan melalui relasi user yang sedang login untuk memastikan kepemilikan
        $kegiatan = Auth::user()->kegiatan()->findOrFail($id);

        // Jika request mengirim status spesifik, validasi nilainya
        if ($request->has('status')) {
            $validated = $request->validate([
                'status' => ['required', 'string', 'in:belum selesai,selesai'],
            ], [
                'status.in' => 'Status hanya boleh berisi belum selesai atau selesai.',
            ]);

            $newStatus = $validated['status'];
        } else {
            // Lakukan toggle otomatis berdasarkan status saat ini
            $currentStatus = strtolower($kegiatan->status);
            $newStatus = in_array($currentStatus, ['selesai', 'sudah selesai']) ? 'belum selesai' : 'selesai';
        }

        $kegiatan->update([
            'status' => $newStatus,
        ]);

        return redirect()->route('dashboard')->with('success', 'Status kegiatan berhasil diperbarui.');
    }

    /**
     * Menghapus kegiatan milik pengguna dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Mengambil kegiatan melalui relasi user untuk memastikan kepemilikan data
        $kegiatan = Auth::user()->kegiatan()->findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('dashboard')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
