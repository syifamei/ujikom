<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Galeri Sekolah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(93, 224, 230, 0.35), transparent 60%),
                        radial-gradient(900px 500px at 90% 20%, rgba(125, 227, 225, 0.45), transparent 55%),
                        linear-gradient(135deg, #f6ffff 0%, #eaf9ff 100%);
            position: relative;
            padding: 20px 10px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .bg-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(40px);
            opacity: .6;
            pointer-events: none;
        }
        .orb-1 { width: 260px; height: 260px; background: #7de3e1; top: 8%; left: 12%; }
        .orb-2 { width: 320px; height: 320px; background: #5de0e6; bottom: 6%; right: 10%; }
        .orb-3 { width: 180px; height: 180px; background: #ffffff; bottom: 18%; left: 8%; opacity: .35; }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 123, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 123, 255, 0.1), 0 5px 15px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            overflow: visible;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            margin: auto;
        }

        .register-header {
            color: #2c3e50;
            padding: 18px 20px 12px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
            position: relative;
        }

        .register-icon {
            width: 60px;
            height: 60px;
            background: white;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            border: 3px solid rgba(0, 123, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .register-icon i {
            font-size: 1.5rem;
            color: #007bff;
        }

        .register-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .register-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .register-form {
            padding: 18px;
            background: white;
        }

        .form-group {
            margin-bottom: 0.75rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.35rem;
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .form-input {
            width: 100%;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 9px 40px 9px 40px;
            height: 42px;
            color: #2c3e50;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #007bff;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1), 0 4px 12px rgba(0, 123, 255, 0.15);
            transform: translateY(-1px);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
            font-size: 16px;
        }

        .input-action {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 4px;
            border-radius: 4px;
            z-index: 10;
            font-size: 16px;
        }

        .input-action:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }


        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 14px;
            padding: 10px;
            font-weight: 600;
            color: white;
            letter-spacing: .2px;
            box-shadow: 0 12px 30px rgba(0, 123, 255, .35);
            transition: transform .15s ease, box-shadow .2s ease, filter .2s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            background: linear-gradient(135deg, #0056b3, #004085);
        }

        .btn-register:active {
            transform: translateY(0);
            box-shadow: 0 6px 16px rgba(0, 123, 255, .35);
        }

        .btn-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .register-footer {
            text-align: center;
            padding: 0.7rem 1.2rem 1rem;
            color: #6b7280;
            font-size: 0.85rem;
            background: white;
        }

        .register-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: #0056b3;
        }

        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #fecaca;
            font-size: 0.875rem;
        }

        .success-message {
            background: #f0fdf4;
            color: #16a34a;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #bbf7d0;
            font-size: 0.875rem;
        }

        .loading {
            display: none;
        }

        .btn-register.loading .loading {
            display: inline-block;
        }

        .btn-register.loading .btn-text {
            display: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .back-link {
            position: absolute;
            top: 0.8rem;
            left: 0.8rem;
            color: #2c3e50;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 3;
        }

        .back-link:hover {
            color: #007bff;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 0.85rem;
        }

        .terms-checkbox input[type="checkbox"] {
            margin-top: 0.2rem;
            transform: scale(1.1);
        }

        .terms-checkbox label {
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1.3;
        }

        .terms-checkbox a {
            color: #007bff;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        @media (max-height: 700px) {
            .register-header {
                padding: 12px 18px 10px;
            }
            .register-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 8px;
            }
            .register-icon i {
                font-size: 1.3rem;
            }
            .register-title {
                font-size: 1.2rem;
            }
            .register-subtitle {
                font-size: 0.8rem;
            }
            .register-form {
                padding: 15px;
            }
            .form-group {
                margin-bottom: 0.6rem;
            }
            .form-label {
                font-size: 0.8rem;
                margin-bottom: 0.3rem;
            }
            .form-input {
                height: 38px;
                font-size: 0.85rem;
                padding: 8px 38px;
            }
            .btn-register {
                padding: 9px;
                font-size: 0.85rem;
            }
            .register-footer {
                padding: 0.6rem 1rem 0.8rem;
                font-size: 0.8rem;
            }
            .terms-checkbox {
                margin-bottom: 0.7rem;
            }
            .terms-checkbox label {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px 8px;
            }
            .register-container {
                max-width: 100%;
                border-radius: 16px;
            }
            .register-form {
                padding: 15px;
            }
        }

        @media (max-width: 360px) {
            body {
                padding: 10px 5px;
            }
            .register-header {
                padding: 10px 15px 8px;
            }
            .register-form {
                padding: 12px;
            }
            .form-input {
                height: 38px;
                font-size: 0.85rem;
                padding: 8px 36px;
            }
            .input-icon {
                font-size: 14px;
                left: 12px;
            }
            .input-action {
                font-size: 14px;
                right: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-orb orb-3"></div>

    <div class="register-container">
        <a href="{{ route('galeri') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
        </a>
        
        <div class="register-header">
            <div class="register-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="register-title">Daftar Akun</h1>
            <p class="register-subtitle">Bergabung dengan komunitas galeri sekolah</p>
        </div>

        <div class="register-form">
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input" 
                               value="{{ old('name') }}" 
                               required 
                               autocomplete="name"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email"
                               placeholder="Masukkan email aktif Anda">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <i class="fa-regular fa-eye-slash input-action" id="togglePassword" title="Show/Hide"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               required 
                               autocomplete="new-password"
                               placeholder="Buat password yang kuat"
                               minlength="8">
                    </div>
                </div>

                <div class="form-group">
                    <label for="captcha" class="form-label">Verifikasi</label>
                    <div style="padding: 8px; background: #f8f9fa; border: 2px dashed #e9ecef; border-radius: 10px; text-align: center; margin-bottom: 6px;">
                        <h3 style="margin: 0; font-size: 1.2rem; color: #2c3e50; font-weight: 600;">
                            {{ App\Http\Controllers\CaptchaController::generateMathQuestion() }}
                        </h3>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-calculator input-icon"></i>
                        <input type="number" 
                               id="captcha" 
                               name="captcha" 
                               class="form-input" 
                               required 
                               autocomplete="off"
                               placeholder="Ketik jawaban Anda">
                    </div>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya menyetujui <a href="#" target="_blank">Syarat dan Ketentuan</a> 
                        serta <a href="#" target="_blank">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn-register" id="registerBtn">
                    <span class="loading">
                        <span class="spinner"></span>
                        Memproses...
                    </span>
                    <span class="btn-text">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </span>
                </button>
            </form>
        </div>

        <div class="register-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>

    <script>
        // Password toggle visibility
        (function() {
            const toggle = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            if (toggle && password) {
                toggle.addEventListener('click', function () {
                    const isHidden = password.getAttribute('type') === 'password';
                    password.setAttribute('type', isHidden ? 'text' : 'password');
                    if (isHidden) {
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                        this.title = 'Hide';
                    } else {
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                        this.title = 'Show';
                    }
                });
            }
        })();

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('registerBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Auto-focus on name field
        document.getElementById('name').focus();
    </script>
</body>
</html>

