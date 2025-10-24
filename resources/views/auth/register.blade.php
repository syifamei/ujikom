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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            position: relative;
        }

        .register-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .register-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 2;
        }

        .register-icon i {
            font-size: 2rem;
        }

        .register-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .register-subtitle {
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .register-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 1;
        }

        .input-group .form-input {
            padding-left: 3rem;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak .strength-fill {
            background: #ef4444;
            width: 25%;
        }

        .strength-fair .strength-fill {
            background: #f59e0b;
            width: 50%;
        }

        .strength-good .strength-fill {
            background: #3b82f6;
            width: 75%;
        }

        .strength-strong .strength-fill {
            background: #10b981;
            width: 100%;
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .register-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #6b7280;
        }

        .register-footer a {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: #059669;
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
            top: 1rem;
            left: 1rem;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.3s ease;
            z-index: 3;
        }

        .back-link:hover {
            color: #e5e7eb;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .terms-checkbox input[type="checkbox"] {
            margin-top: 0.25rem;
            transform: scale(1.2);
        }

        .terms-checkbox label {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .terms-checkbox a {
            color: #10b981;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            
            .register-header {
                padding: 1.5rem;
            }
            
            .register-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
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
                        <i class="fas fa-user"></i>
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
                        <i class="fas fa-envelope"></i>
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
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               required 
                               autocomplete="new-password"
                               placeholder="Buat password yang kuat"
                               minlength="8">
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-fill"></div>
                        </div>
                        <small class="strength-text">Kekuatan password</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-input" 
                               required 
                               autocomplete="new-password"
                               placeholder="Ulangi password Anda">
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
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrength');
        const strengthFill = strengthBar.querySelector('.strength-fill');
        const strengthText = strengthBar.querySelector('.strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthBar.className = 'password-strength ' + strength.class;
            strengthText.textContent = strength.text;
        });

        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];

            if (password.length >= 8) score++;
            else feedback.push('minimal 8 karakter');

            if (/[a-z]/.test(password)) score++;
            else feedback.push('huruf kecil');

            if (/[A-Z]/.test(password)) score++;
            else feedback.push('huruf besar');

            if (/[0-9]/.test(password)) score++;
            else feedback.push('angka');

            if (/[^A-Za-z0-9]/.test(password)) score++;
            else feedback.push('karakter khusus');

            if (score <= 1) {
                return { class: 'strength-weak', text: 'Lemah - tambahkan: ' + feedback.join(', ') };
            } else if (score <= 2) {
                return { class: 'strength-fair', text: 'Cukup - tambahkan: ' + feedback.slice(0, 2).join(', ') };
            } else if (score <= 3) {
                return { class: 'strength-good', text: 'Baik - tambahkan: ' + feedback.slice(0, 1).join(', ') };
            } else {
                return { class: 'strength-strong', text: 'Sangat kuat!' };
            }
        }

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

