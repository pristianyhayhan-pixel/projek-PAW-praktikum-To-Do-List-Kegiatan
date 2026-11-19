<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'To-Do List Kegiatan')</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: #fdf6f8;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigasi */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #f6d8df;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(226, 130, 148, 0.08);
        }

        .navbar-brand {
            font-size: 18px;
            font-weight: 600;
            color: #b54a62;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: #98384e;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-user {
            font-size: 14px;
            color: #635558;
        }

        .btn-logout {
            background-color: transparent;
            border: 1px solid #e5a4b1;
            color: #b54a62;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background-color: #fdf0f3;
            border-color: #d66b80;
        }

        /* Container Autentikasi */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 32px 28px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(226, 130, 148, 0.12);
            border: 1px solid #f6d8df;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h1 {
            font-size: 22px;
            font-weight: 600;
            color: #b54a62;
            margin-bottom: 6px;
        }

        .auth-header p {
            font-size: 13px;
            color: #7d7275;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #7d7275;
        }

        .auth-footer a {
            color: #b54a62;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Container Aplikasi & Dashboard */
        .dashboard-container {
            max-width: 950px;
            margin: 0 auto;
            width: 100%;
            padding: 28px 16px;
            flex: 1;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-title h1 {
            font-size: 22px;
            font-weight: 600;
            color: #b54a62;
            margin-bottom: 4px;
        }

        .page-title p {
            font-size: 13px;
            color: #7d7275;
        }

        /* Kartu Statistik */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #f6d8df;
            padding: 18px 20px;
            box-shadow: 0 2px 6px rgba(226, 130, 148, 0.05);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .stat-card.stat-total {
            border-left: 4px solid #d66b80;
        }

        .stat-card.stat-pending {
            border-left: 4px solid #e0966a;
        }

        .stat-card.stat-completed {
            border-left: 4px solid #5aa77e;
        }

        .stat-label {
            font-size: 13px;
            color: #756a6d;
            font-weight: 500;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            color: #403236;
        }

        /* Card Konten */
        .card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #f6d8df;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(226, 130, 148, 0.06);
            margin-bottom: 20px;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #fce7ea;
        }

        .card-title {
            font-size: 17px;
            font-weight: 600;
            color: #b54a62;
        }

        /* Formulir */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #554a4d;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #f0ccd5;
            border-radius: 8px;
            background-color: #ffffff;
            color: #333333;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #d66b80;
            box-shadow: 0 0 0 3px rgba(214, 107, 128, 0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .error-message {
            color: #c93b55;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Tombol */
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d66b80;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #c4576e;
        }

        .btn-secondary {
            display: inline-block;
            padding: 10px 18px;
            background-color: #ffffff;
            border: 1px solid #e5a4b1;
            border-radius: 8px;
            color: #b54a62;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #fdf0f3;
            border-color: #d66b80;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }

        /* Tabel Kegiatan */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table-kegiatan {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
        }

        .table-kegiatan th {
            background-color: #fff2f5;
            color: #8c3a4f;
            font-weight: 600;
            padding: 12px 14px;
            border-bottom: 2px solid #f6d8df;
            white-space: nowrap;
        }

        .table-kegiatan td {
            padding: 14px;
            border-bottom: 1px solid #fbeff2;
            color: #403236;
            vertical-align: top;
        }

        .table-kegiatan tr:hover td {
            background-color: #fffcfd;
        }

        .text-muted {
            color: #8c8285;
            font-size: 12px;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-pending {
            background-color: #fef4e8;
            color: #b56b2e;
            border: 1px solid #fbe0c3;
        }

        .badge-completed {
            background-color: #edf7f1;
            color: #2e7d56;
            border: 1px solid #c6ebd4;
        }

        /* Alert Notifikasi */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #edf7f1;
            color: #246845;
            border: 1px solid #cce9d6;
        }

        /* Filter Tanggal */
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
            padding: 12px 16px;
            background-color: #fff9fa;
            border: 1px solid #f9e2e7;
            border-radius: 8px;
        }

        .filter-form {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-label {
            font-size: 13px;
            font-weight: 500;
            color: #635558;
            margin: 0;
            white-space: nowrap;
        }

        .filter-input {
            width: auto;
            min-width: 150px;
            padding: 7px 12px;
            font-size: 13px;
        }

        .filter-status-info {
            font-size: 13px;
            color: #8c3a4f;
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 13px;
            border-radius: 6px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 42px 20px;
            color: #8c8084;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 14px;
        }

        /* Kontrol Status Kegiatan */
        .btn-status-toggle {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            outline: none;
            line-height: 1.2;
        }

        .btn-status-pending {
            background-color: #fef4e8;
            color: #b56b2e;
            border: 1px solid #fbe0c3;
        }

        .btn-status-pending:hover {
            background-color: #fde8d0;
            border-color: #f5cda1;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(181, 107, 46, 0.15);
        }

        .btn-status-completed {
            background-color: #edf7f1;
            color: #2e7d56;
            border: 1px solid #c6ebd4;
        }

        .btn-status-completed:hover {
            background-color: #dcf1e4;
            border-color: #aee0c2;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(46, 125, 86, 0.15);
        }

        /* Tombol Aksi Tabel */
        .action-buttons {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-action {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-action-edit {
            background-color: #fdf0f3;
            color: #b54a62;
            border-color: #f0ccd5;
        }

        .btn-action-edit:hover {
            background-color: #fce3e8;
            border-color: #d66b80;
        }

        .btn-action-delete {
            background-color: #fff5f6;
            color: #c93b55;
            border-color: #fcd5dc;
        }

        .btn-action-delete:hover {
            background-color: #fde8eb;
            border-color: #c93b55;
        }

        @media (max-width: 640px) {
            .navbar {
                padding: 12px 16px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .card {
                padding: 18px 14px;
            }
            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .form-actions button,
            .form-actions a {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @auth
        <nav class="navbar">
            <a href="{{ route('dashboard') }}" class="navbar-brand">To-Do List Kegiatan</a>
            <div class="navbar-menu">
                <span class="navbar-user">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </nav>
    @endauth

    @yield('content')
</body>
</html>
