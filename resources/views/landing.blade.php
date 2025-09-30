<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Online UIN Suka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d7a3d 0%, #0a5c2e 100%);
            color: white;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,112C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        .btn-landing {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 10px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-landing-primary {
            background-color: #d4af37;
            border: none;
            color: white;
        }

        .btn-landing-primary:hover {
            background-color: #b8941f;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        .btn-landing-outline {
            background-color: transparent;
            border: 2px solid white;
            color: white;
        }

        .btn-landing-outline:hover {
            background-color: white;
            color: #0d7a3d;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        .features {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .feature-card {
            text-align: center;
            padding: 40px 30px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0d7a3d, #0a5c2e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #0d7a3d;
        }

        .hero-image {
            max-width: 500px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Selamat Datang di<br>Kantin Online UIN Suka</h1>
                    <p class="hero-subtitle">
                        Pesan makanan dan minuman favoritmu dengan mudah dan cepat. 
                        Nikmati kemudahan berbelanja di kantin kampus!
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-landing btn-landing-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-landing btn-landing-outline">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <i class="fas fa-hamburger hero-image" style="font-size: 300px; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #0d7a3d;">Mengapa Memilih Kami?</h2>
                <p class="text-muted">Kemudahan dan kenyamanan dalam satu platform</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Cepat & Mudah</h3>
                        <p class="text-muted">Pesan makanan hanya dalam beberapa klik. Hemat waktu dan tenaga!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="feature-title">Menu Variatif</h3>
                        <p class="text-muted">Berbagai pilihan makanan dan minuman sesuai selera Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Aman & Terpercaya</h3>
                        <p class="text-muted">Sistem pembayaran yang aman dan data terlindungi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>