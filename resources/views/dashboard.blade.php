@extends('layouts.app')

@section('title', 'Dashboard - To-Do List Kegiatan')

@section('content')
<div class="dashboard-container">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Dashboard & Sapaan Pengguna --}}
    <div class="page-header">
        <div class="page-title">
            <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p>Kelola dan pantau seluruh kegiatan harian Anda dengan mudah.</p>
        </div>
        <div>
            <a href="{{ route('kegiatan.create') }}" class="btn-primary">+ Tambah Kegiatan</a>
        </div>
    </div>

    {{-- Statistik Jumlah Kegiatan --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <span class="stat-label">Total Kegiatan</span>
            <span class="stat-value">{{ $totalKegiatan }}</span>
        </div>
        <div class="stat-card stat-pending">
            <span class="stat-label">Belum Selesai</span>
            <span class="stat-value">{{ $belumSelesai }}</span>
        </div>
        <div class="stat-card stat-completed">
            <span class="stat-label">Selesai</span>
            <span class="stat-value">{{ $sudahSelesai }}</span>
        </div>
    </div>

    {{-- Tabel & Filter Daftar Kegiatan --}}
    <div class="card">
        <div class="card-header-flex">
            <div>
                <h2 class="card-title">Daftar Kegiatan</h2>
                <span class="text-muted">Urut berdasarkan tanggal pelaksanaan</span>
            </div>
        </div>

        {{-- Form Filter Tanggal --}}
        <div class="filter-container">
            <form action="{{ route('dashboard') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label for="tanggal" class="filter-label">Filter Tanggal:</label>
                    <input 
                        type="date" 
                        id="tanggal" 
                        name="tanggal" 
                        class="form-control filter-input" 
                        value="{{ request('tanggal', $tanggal) }}"
                    >
                    <button type="submit" class="btn-primary btn-sm">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary btn-sm">Reset</a>
                </div>
            </form>
            @if(!empty($tanggal))
                <div class="filter-status-info">
                    Menampilkan kegiatan tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong>
                </div>
            @endif
        </div>

        {{-- Isi Daftar Kegiatan / Empty State --}}
        @if($kegiatan->isEmpty())
            <div class="empty-state">
                @if(!empty($tanggal))
                    <p>Tidak ada kegiatan pada tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong>.</p>
                    <div style="display: flex; justify-content: center; gap: 8px; margin-top: 8px;">
                        <a href="{{ route('dashboard') }}" class="btn-secondary btn-sm">Tampilkan Semua Kegiatan</a>
                        <a href="{{ route('kegiatan.create') }}" class="btn-primary btn-sm">+ Tambah Kegiatan</a>
                    </div>
                @else
                    <p>Belum ada kegiatan yang ditambahkan.</p>
                    <a href="{{ route('kegiatan.create') }}" class="btn-primary">+ Tambah Kegiatan Sekarang</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table-kegiatan">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Kegiatan</th>
                            <th>Deskripsi</th>
                            <th style="width: 170px;">Tanggal Pelaksanaan</th>
                            <th style="width: 150px;">Status</th>
                            <th style="width: 140px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->nama_kegiatan }}</strong>
                                </td>
                                <td>
                                    @if($item->deskripsi)
                                        {{ $item->deskripsi }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}
                                </td>
                                <td>
                                    <form action="{{ route('kegiatan.status', $item->id) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        @if(strtolower($item->status) === 'selesai' || strtolower($item->status) === 'sudah selesai')
                                            <button type="submit" class="btn-status-toggle btn-status-completed" title="Klik untuk mengubah menjadi Belum Selesai">
                                                ✓ Selesai
                                            </button>
                                        @else
                                            <button type="submit" class="btn-status-toggle btn-status-pending" title="Klik untuk mengubah menjadi Selesai">
                                                ○ Belum Selesai
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <div class="action-buttons">
                                        <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn-action btn-action-edit">Edit</a>
                                        <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
