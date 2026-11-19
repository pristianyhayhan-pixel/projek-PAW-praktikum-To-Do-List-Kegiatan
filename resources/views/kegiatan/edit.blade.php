@extends('layouts.app')

@section('title', 'Edit Kegiatan - To-Do List Kegiatan')

@section('content')
<div class="dashboard-container">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="card">
            <div class="card-header-flex">
                <h2 class="card-title">Edit Kegiatan</h2>
                <a href="{{ route('dashboard') }}" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">&larr; Kembali</a>
            </div>

            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan <span style="color: #c93b55;">*</span></label>
                    <input 
                        type="text" 
                        id="nama_kegiatan" 
                        name="nama_kegiatan" 
                        class="form-control" 
                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" 
                        placeholder="Contoh: Mengerjakan Tugas Besar PAW" 
                        required 
                        autofocus
                    >
                    @error('nama_kegiatan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi (Opsional)</label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        class="form-control" 
                        placeholder="Tuliskan catatan atau rincian kegiatan jika ada..."
                    >{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_pelaksanaan">Tanggal Pelaksanaan <span style="color: #c93b55;">*</span></label>
                    <input 
                        type="date" 
                        id="tanggal_pelaksanaan" 
                        name="tanggal_pelaksanaan" 
                        class="form-control" 
                        value="{{ old('tanggal_pelaksanaan', $kegiatan->tanggal_pelaksanaan) }}" 
                        required
                    >
                    @error('tanggal_pelaksanaan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status Kegiatan</label>
                    <select id="status" name="status" class="form-control">
                        <option value="belum selesai" {{ old('status', $kegiatan->status) == 'belum selesai' ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="selesai" {{ in_array(old('status', $kegiatan->status), ['selesai', 'sudah selesai']) ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Perbarui Kegiatan</button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
