<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kantin Online')</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f4f4f9; color: #333; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        nav { background-color: #4a5568; padding: 1rem; color: white; display: flex; justify-content: space-between; align-items: center; }
        nav h1 { margin: 0; }
        nav form button { background: #e53e3e; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; }
        nav form button:hover { background: #c53030; }
        h2 { color: #2d3748; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; }
        .card .price { font-weight: bold; color: #2f855a; }
        .card .status { font-style: italic; color: #718096; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #edf2f7; }
        .btn { padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background-color: #3182ce; }
        .btn-primary:hover { background-color: #2b6cb0; }
        .btn-danger { background-color: #e53e3e; }
        .btn-danger:hover { background-color: #c53030; }
        .btn-warning { background-color: #d69e2e; color: white; }
        .btn-warning:hover { background-color: #b08022; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background-color: #c6f6d5; color: #2f855a; }
        .alert-danger { background-color: #fed7d7; color: #c53030; }
    </style>
</head>
<body>
    @auth
    <nav>
        <h1>Kantin Online - {{ Auth::user()->role == 'admin_kantin' ? 'Admin Panel' : 'Selamat Datang!' }}</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
    @endauth

    <main class="container">
        @yield('content')
    </main>
</body>
</html>