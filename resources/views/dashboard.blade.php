@extends('layouts.app')

@section('title', 'Dashboard - To-Do List Kegiatan')

@section('content')
<div class="dashboard-container">
    <div class="card">
        <h2 style="font-size: 20px; color: #b54a62; margin-bottom: 8px;">Selamat Datang di Dashboard!</h2>
        <p style="font-size: 14px; color: #635558; margin-bottom: 16px;">
            Anda telah berhasil masuk sebagai <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }}).
        </p>
        <div style="padding: 16px; background-color: #fdf6f8; border-radius: 8px; border: 1px dashed #f0ccd5; font-size: 13px; color: #7d7275;">
            Autentikasi (Login & Register) telah berhasil diimplementasikan. Fitur pengelolaan kegiatan To-Do List akan dibangun pada tahap berikutnya.
        </div>
    </div>
</div>
@endsection
