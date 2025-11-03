<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi OTP - Galeri Sekolah</title>
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

        .otp-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            position: relative;
        }

        .otp-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .otp-header::before {
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

        .otp-icon {
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

        .otp-icon i {
            font-size: 2rem;
        }

        .otp-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .otp-subtitle {
            opacity: 0.9;
            position: relative;
            z-index: 2;
            font-size: 0.95rem;
        }

        .otp-form {
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
            text-align: center;
        }

        .otp-input-group {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .otp-digit {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        .otp-digit:focus {
            outline: none;
            border-color: #f59e0b;
            background: white;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .btn-verify {
            width: 100%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .btn-verify:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-resend {
            width: 100%;
            background: transparent;
            color: #6b7280;
            border: 2px solid #e5e7eb;
            padding: 0.875rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-resend:hover {
            background: #f9fafb;
            border-color: #f59e0b;
            color: #f59e0b;
        }

        .btn-resend:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .otp-footer {
            text-align: center;
            padding: 1rem 2rem 2rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .otp-footer a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .otp-footer a:hover {
            color: #d97706;
        }

        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #fecaca;
            font-size: 0.875rem;
            text-align: center;
        }

        .success-message {
            background: #f0fdf4;
            color: #16a34a;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #bbf7d0;
            font-size: 0.875rem;
            text-align: center;
        }

        .loading {
            display: none;
        }

        .btn-verify.loading .loading {
            display: inline-block;
        }

        .btn-verify.loading .btn-text {
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

        .timer {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .timer.expired {
            color: #dc2626;
        }

        @media (max-width: 480px) {
            .otp-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
            }
            
            .otp-header {
                padding: 1.5rem;
            }
            
            .otp-form {
                padding: 1.5rem;
            }

            .otp-digit {
                width: 45px;
                height: 55px;
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-header">
            <div class="otp-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="otp-title">Verifikasi OTP</h1>
            <p class="otp-subtitle">Masukkan kode 6 digit yang telah dikirim ke email Anda</p>
        </div>

        <div class="otp-form">
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

            <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm">
                @csrf
                
                <input type="hidden" name="otp" id="otpValue">
                
                <div class="form-group">
                    <label class="form-label">Kode OTP</label>
                    <div class="otp-input-group">
                        <input type="text" maxlength="1" class="otp-digit" data-index="0" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-digit" data-index="1" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-digit" data-index="2" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-digit" data-index="3" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-digit" data-index="4" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-digit" data-index="5" autocomplete="off">
                    </div>
                </div>

                <div class="timer" id="timer">
                    Kode berlaku selama: <strong id="countdown">10:00</strong>
                </div>

                <button type="submit" class="btn-verify" id="verifyBtn">
                    <span class="loading">
                        <span class="spinner"></span>
                        Memverifikasi...
                    </span>
                    <span class="btn-text">
                        <i class="fas fa-check-circle"></i>
                        Verifikasi
                    </span>
                </button>
            </form>

            <form method="POST" action="{{ route('otp.resend') }}" id="resendForm">
                @csrf
                <button type="submit" class="btn-resend" id="resendBtn">
                    <i class="fas fa-redo-alt"></i>
                    Kirim Ulang Kode OTP
                </button>
            </form>
        </div>

        <div class="otp-footer">
            <p>Tidak menerima kode? Periksa folder spam atau <a href="{{ route('register') }}">daftar ulang</a></p>
        </div>
    </div>

    <script>
        // OTP Input Handler
        const otpInputs = document.querySelectorAll('.otp-digit');
        const otpValue = document.getElementById('otpValue');
        const otpForm = document.getElementById('otpForm');
        const verifyBtn = document.getElementById('verifyBtn');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                
                // Only allow numbers
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Move to next input
                if (value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Check if all inputs are filled
                checkOtpComplete();
            });

            input.addEventListener('keydown', function(e) {
                // Move to previous input on backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').trim();
                
                if (/^\d{6}$/.test(pastedData)) {
                    pastedData.split('').forEach((char, i) => {
                        if (i < otpInputs.length) {
                            otpInputs[i].value = char;
                        }
                    });
                    checkOtpComplete();
                }
            });
        });

        function checkOtpComplete() {
            const otp = Array.from(otpInputs).map(input => input.value).join('');
            otpValue.value = otp;
            
            if (otp.length === 6) {
                verifyBtn.disabled = false;
            } else {
                verifyBtn.disabled = true;
            }
        }

        // Form submission
        otpForm.addEventListener('submit', function(e) {
            verifyBtn.classList.add('loading');
            verifyBtn.disabled = true;
        });

        // Countdown Timer
        let timeLeft = 600; // 10 minutes in seconds
        const countdownElement = document.getElementById('countdown');
        const timerElement = document.getElementById('timer');

        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                timerElement.classList.add('expired');
                countdownElement.textContent = 'Kadaluarsa';
                clearInterval(countdownInterval);
            }
            
            timeLeft--;
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();

        // Resend Form
        const resendForm = document.getElementById('resendForm');
        const resendBtn = document.getElementById('resendBtn');

        resendForm.addEventListener('submit', function(e) {
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            
            // Re-enable after 3 seconds
            setTimeout(() => {
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="fas fa-redo-alt"></i> Kirim Ulang Kode OTP';
            }, 3000);
        });

        // Auto-focus on first input
        otpInputs[0].focus();

        // Initialize button state
        checkOtpComplete();
    </script>
</body>
</html>
