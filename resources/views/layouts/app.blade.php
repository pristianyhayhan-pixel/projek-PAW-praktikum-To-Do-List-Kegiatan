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

        .error-message {
            color: #c93b55;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn-primary {
            width: 100%;
            padding: 11px;
            background-color: #d66b80;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #c4576e;
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

        /* Container untuk Dashboard */
        .dashboard-container {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
            padding: 24px 16px;
        }

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

        .card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #f6d8df;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(226, 130, 148, 0.06);
            margin-bottom: 20px;
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
