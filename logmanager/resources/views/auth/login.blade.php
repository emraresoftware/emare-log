<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giriş Yap - Hiper Log</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(52, 152, 219, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(52, 152, 219, 0.05) 0%, transparent 40%);
            animation: bgShift 20s ease-in-out infinite;
        }

        @keyframes bgShift {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-2%, -1%); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 35px 30px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 20px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px 20px 0 0;
        }

        .brand-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(52, 152, 219, 0.15);
            border: 2px solid rgba(52, 152, 219, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .brand-icon i {
            font-size: 30px;
            color: #3498db;
        }

        .brand-title {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .brand-tagline {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            letter-spacing: 1px;
        }

        .login-body {
            padding: 30px 35px 35px;
        }

        .form-floating {
            margin-bottom: 18px;
        }

        .form-floating .form-control {
            border: 2px solid #e8ecef;
            border-radius: 10px;
            padding: 16px 14px 6px 42px;
            height: 54px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-floating .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            background-color: #fff;
        }

        .form-floating .form-control.is-invalid {
            border-color: #e74c3c;
        }

        .form-floating .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
        }

        .form-floating label {
            padding-left: 42px;
            color: #888;
            font-size: 14px;
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            color: #3498db;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
            z-index: 5;
            transition: color 0.3s;
        }

        .form-floating:focus-within .input-icon {
            color: #3498db;
        }

        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }

        .form-check-label {
            font-size: 13px;
            color: #666;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #2980b9, #2471a3);
            transform: translateY(-1px);
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.4);
            color: #fff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            margin-right: 8px;
        }

        .invalid-feedback {
            font-size: 12px;
            margin-top: 4px;
        }

        .login-footer {
            text-align: center;
            padding: 0 35px 25px;
        }

        .login-footer p {
            margin: 0;
            font-size: 11px;
            color: #aaa;
        }

        .floating-shapes div {
            position: absolute;
            border: 1px solid rgba(52, 152, 219, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .floating-shapes .shape-1 {
            width: 80px; height: 80px; top: 10%; left: 10%;
            animation-delay: 0s;
        }
        .floating-shapes .shape-2 {
            width: 120px; height: 120px; top: 60%; right: 10%;
            animation-delay: 3s;
        }
        .floating-shapes .shape-3 {
            width: 60px; height: 60px; bottom: 20%; left: 20%;
            animation-delay: 6s;
        }
        .floating-shapes .shape-4 {
            width: 100px; height: 100px; top: 30%; right: 25%;
            animation-delay: 9s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.6; }
        }

        @media (max-width: 480px) {
            .login-body { padding: 25px 20px 30px; }
            .login-header { padding: 25px 20px; }
            .brand-title { font-size: 20px; }
        }
    </style>
</head>
<body>

    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape-1"></div>
        <div class="shape-2"></div>
        <div class="shape-3"></div>
        <div class="shape-4"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="brand-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
                <div class="brand-title">Hiper Log</div>
                <div class="brand-tagline">ISP Yönetiminde Tek Adres</div>
            </div>

            <!-- Body -->
            <div class="login-body">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <!-- Kullanıcı Adı -->
                    <div class="form-floating position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text"
                               class="form-control @error('kullanici_adi') is-invalid @enderror"
                               id="kullanici_adi"
                               name="kullanici_adi"
                               placeholder="Kullanıcı Adı"
                               value="{{ old('kullanici_adi') }}"
                               required
                               autofocus>
                        <label for="kullanici_adi">Kullanıcı Adı</label>
                        @error('kullanici_adi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Şifre -->
                    <div class="form-floating position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Şifre"
                               required>
                        <label for="password">Şifre</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Beni Hatırla -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Beni Hatırla</label>
                        </div>
                    </div>

                    <!-- Giriş Butonu -->
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Giriş Yap
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>&copy; {{ date('Y') }} Hiper Log &mdash; Tüm hakları saklıdır.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
