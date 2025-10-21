<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Galeri Sekolah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --cyan-100: #e6fffe;
            --cyan-200: #c8fbfb;
            --cyan-300: #a4f1f1;
            --cyan-400: #7de3e1;
            --cyan-500: #5de0e6;
            --cyan-600: #2cc7d7;
            --slate-700: #2b3a42;
            --slate-500: #6b7a86;
            --white-70: rgba(255,255,255,0.7);
            --white-30: rgba(255,255,255,0.3);
            --white-15: rgba(255,255,255,0.15);
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
        }
        .bg-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(40px);
            opacity: .6;
            pointer-events: none;
        }
        .orb-1 { width: 260px; height: 260px; background: var(--cyan-400); top: 8%; left: 12%; }
        .orb-2 { width: 320px; height: 320px; background: var(--cyan-500); bottom: 6%; right: 10%; }
        .orb-3 { width: 180px; height: 180px; background: #ffffff; bottom: 18%; left: 8%; opacity: .35; }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 123, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 123, 255, 0.1), 0 5px 15px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            color: #2c3e50;
            padding: 30px 25px 20px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        }
        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            background: white;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            border: 3px solid rgba(0, 123, 255, 0.1);
        }
        .login-body { 
            padding: 25px; 
            background: white;
        }

        .input-wrap { }
        .input-field { position: relative; }
        .glass-input {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 44px 12px 44px;
            height: 50px;
            color: #2c3e50;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .glass-input::placeholder { color: #6d7b88; }
        .glass-input:focus {
            outline: none;
            border-color: #007bff;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1), 0 4px 12px rgba(0, 123, 255, 0.15);
            transform: translateY(-1px);
        }
        /* Tidy invalid state to avoid harsh red outline */
        .glass-input.is-invalid,
        .was-validated .glass-input:invalid {
            border-color: rgba(220, 38, 38, .45);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, .18), inset 0 1px 0 rgba(255,255,255,.8);
            background-image: none;
        }
        .glass-input.is-invalid:focus,
        .was-validated .glass-input:invalid:focus {
            border-color: rgba(220, 38, 38, .55);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, .22), inset 0 1px 0 rgba(255,255,255,.85);
        }
        /* Remove autofill yellow and keep glass look */
        input.glass-input:-webkit-autofill,
        input.glass-input:-webkit-autofill:hover,
        input.glass-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255,255,255,0.28) inset !important;
            -webkit-text-fill-color: #0e2430 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .form-label { 
            margin-bottom: 8px; 
            color: #2c3e50; 
            font-weight: 500;
        }
        .input-field .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
            font-size: 16px;
        }
        .input-field .input-action {
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
        .input-field .input-action:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 14px;
            padding: 12px 14px;
            font-weight: 600;
            color: white;
            letter-spacing: .2px;
            box-shadow: 0 12px 30px rgba(0, 123, 255, .35);
            transition: transform .15s ease, box-shadow .2s ease, filter .2s ease;
        }
        .btn-login:hover { 
            transform: translateY(-2px); 
            filter: brightness(1.1);
            background: linear-gradient(135deg, #0056b3, #004085);
        }
        .btn-login:active { 
            transform: translateY(0); 
            box-shadow: 0 6px 16px rgba(0, 123, 255, .35); 
        }

        .muted-link { color: #3a4a55; }
    </style>
</head>
<body>
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>
    <div class="bg-orb orb-3"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="avatar">
                <img src="{{ asset('images/logo smkn 4.png') }}" alt="SMKN 4 Logo" style="width: 70px; height: 70px; object-fit: contain;">
            </div>
            <h4 class="mb-1 fw-semibold">Admin Login</h4>
            <span class="text-muted" style="font-size: 0.95rem;">SMKN 4 Kota Bogor</span>
        </div>
        
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.authenticate') }}" autocomplete="off">
                @csrf
                <div class="mb-3 input-wrap">
                    <label for="username" class="form-label fw-medium">Username</label>
                    <div class="input-field">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input type="text"
                               class="form-control glass-input @error('username') is-invalid @enderror"
                               id="username"
                               name="username"
                               placeholder="username"
                               value=""
                               autocomplete="off"
                               autocapitalize="off" autocorrect="off" spellcheck="false"
                               required
                               autofocus>
                    </div>
                </div>
                
                <div class="mb-4 input-wrap">
                    <label for="password" class="form-label fw-medium">Password</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <i class="fa-regular fa-eye-slash input-action" id="togglePassword" title="Show/Hide"></i>
                        <input type="password"
                               class="form-control glass-input @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="password"
                               value=""
                               autocomplete="new-password"
                               required>
                    </div>
                    
                </div>
                
                <button type="submit" class="btn btn-login w-100">
                    <span class="me-2">Log in</span> <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none muted-link">
                    <i class="fas fa-arrow-left me-2"></i>cancel
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            const toggle = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const username = document.getElementById('username');

            // Ensure fields are always cleared on initial load
            if (username) username.value = '';
            if (password) password.value = '';
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
    </script>
</body>
</html>

