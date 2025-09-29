<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kantin Online')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-light: #0080ff;
            --primary-dark: #001f43;
            --secondary: #b40000;
            --background-light: #F8F9FA;
            --background-medium: #E0E7E9;
            --text-dark: #000000;
            --text-medium: #000000;
            --border-color: #DDE4E7;
            --success-color: #79B38B;
            --danger-color: #ff0000;
            --warning-color: #15ff00;
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
        }
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            background-color: var(--background-medium);
            color: var(--text-dark);
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 30px;
            background-color: var(--background-light);
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--shadow-medium);
        }
        nav {
            background-color: var(--primary-dark);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }
        nav h1 { margin: 0; font-size: 1.8rem; font-weight: 600; }
        nav form button {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.2s ease;
            box-shadow: 0 2px 5px var(--shadow-light);
        }
        nav form button:hover { background: #632211; }
        h2 {
            font-size: 2rem;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            margin-top: 0;
            color: var(--text-dark);
            margin-bottom: 15px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 25px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px var(--shadow-light);
        }
        .table-responsive-wrapper { overflow-x: auto; }
        .table-actions { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        th, td {
            border-bottom: 1px solid var(--border-color);
            padding: 15px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: var(--background-medium);
            color: var(--text-dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        th a { color: inherit; text-decoration: none; }
        th a:hover { color: var(--primary-dark); }
        tr:nth-child(even) { background-color: #FBFDFF; }
        td { color: var(--text-medium); }
        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 5px var(--shadow-light);
            text-align: center;
        }
        .btn-primary { background-color: var(--primary-dark); }
        .btn-primary:hover { background-color: #66b0ff; }
        .btn-danger { background-color: var(--danger-color); }
        .btn-danger:hover { background-color: #742f1e; }
        .btn-warning { background-color: var(--warning-color); color: var(--text-dark); }
        .btn-warning:hover { background-color: #125b16; }

        /* === FINAL: DESAIN PAGINATION MONOKROM BERSIH (SESUAI REFERENSI) === */
       .pagination a {
            padding: 4px 8px;
            text-decoration: none;
            color: inherit;
        }
        .pagination .active {
            font-weight: bold;
            text-decoration: underline;
        }
        .pagination .disabled {
            color: #aaa;
        }

        /* === AKHIR DARI BLOK PAGINATION BARU === */
        /* === FORM STYLE UNTUK TAMBAH/EDIT MENU === */
        form .form-group {
            margin-bottom: 1.2rem;
        }

        form label {
            display: block;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        form input,
        form textarea,
        form select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: white;
            color: var(--text-dark);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box;
        }

        form input:focus,
        form textarea:focus,
        form select:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 3px rgba(108, 155, 207, 0.2);
            outline: none;
        }

        form textarea {
            resize: none;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 1.5rem;
        }

        /* Tombol lebih konsisten */
        .btn-cancel {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-medium);
        }
        .btn-cancel:hover {
            background-color: var(--background-medium);
            color: var(--text-dark);
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .prefix {
            position: absolute;
            left: 12px;
            color: var(--text-medium);
            font-weight: 600;
            pointer-events: none;
        }

        .input-wrapper input {
            padding-left: 40px; /* kasih space biar gak nabrak "Rp" */
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px var(--shadow-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card .menu-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-dark);
        }

        .card .order-form {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .card input[type="number"] {
            width: 60px;
            padding: 6px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
        }

        .out-of-stock {
            color: var(--danger-color);
            font-weight: bold;
        }


        /* Utility classes */
        .mt-4 { margin-top: 1.5rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .d-flex { display: flex !important; }
        .justify-content-center { justify-content: center !important; }
        .justify-content-start { 
            justify-content: flex-start !important; 
            /* Memastikan area ini 100% transparan */
            background: none !important;
            border: none !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    @auth
    <nav>
        <h1>Kantin Online - {{ Auth::user()->role == 'admin_kantin' ? 'Admin Panel' : 'Selamat Datang!' }}</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </nav>
    @endauth

    <main class="container">
        @yield('content')
    </main>
</body>
</html>