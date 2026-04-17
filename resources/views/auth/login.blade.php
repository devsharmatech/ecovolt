<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoVolt | Enterprise Login</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f0f4f8; /* Same background color as Dashboard */
            position: relative;
            overflow: hidden;
        }

        /* Subtle aesthetic curves in background */
        body::before {
            content: ''; position: absolute; top: -10vw; left: -10vw;
            width: 40vw; height: 40vw; border-radius: 50%;
            background: radial-gradient(circle, rgba(22,163,74,0.06) 0%, transparent 70%);
            z-index: 0;
        }
        body::after {
            content: ''; position: absolute; bottom: -15vw; right: -5vw;
            width: 50vw; height: 50vw; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,0.05) 0%, transparent 70%);
            z-index: 0;
        }

        /* ── Main Centered Card ── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }

        /* ── Brand / Header ── */
        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .brand {
            display: inline-flex; align-items: center; justify-content: center; gap: 12px;
            margin-bottom: 24px;
        }
        .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #14532d, #16a34a);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff;
            box-shadow: 0 4px 12px rgba(22,163,74,0.3);
        }
        .brand-name {
            font-size: 1.2rem; font-weight: 900;
            color: #0f172a; letter-spacing: 2px;
        }

        .form-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1.2; margin-bottom: 6px; }
        .form-subtitle { font-size: 0.85rem; color: #64748b; font-weight: 500; }

        /* Error toast */
        .error-toast {
            background: #fff1f2; border: 1.5px solid #fecdd3; border-radius: 12px;
            padding: 12px 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
            animation: shake 0.4s both;
        }
        .error-toast i { color: #e11d48; font-size: 1.2rem; }
        .error-toast span { color: #9f1239; font-size: 0.8rem; font-weight: 700; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }

        /* ── Role Selector ── */
        .role-label-txt {
            font-size: 9px; font-weight: 800; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px; display: block;
        }
        .role-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 28px; }
        .role-opt { cursor: pointer; }
        .role-opt input { display: none; }
        .role-tile {
            padding: 14px 10px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s ease;
            display: flex; flex-direction: column; align-items: center; gap: 6px;
        }
        .role-tile:hover { border-color: #cbd5e1; background: #fff; }

        .role-tile .ico {
            width: 40px; height: 40px;
            background: #fff; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #94a3b8; box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            transition: 0.3s;
        }
        
        .role-tile .nm { display: block; font-size: 0.85rem; font-weight: 700; color: #334155; }
        .role-tile .sub { display: block; font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

        /* Actives */
        .role-opt input:checked + .role-tile { border-color: #16a34a; background: #f0fdf4; box-shadow: 0 4px 12px rgba(22,163,74,0.1); }
        .role-opt input:checked + .role-tile .ico { background: #16a34a; color: #fff; }
        .role-opt input:checked + .role-tile .nm { color: #166534; }
        .role-opt input:checked + .role-tile .sub { color: #22c55e; }

        /* ── Inputs ── */
        .input-group { margin-bottom: 20px; position: relative; }
        .custom-input {
            width: 100%;
            background: #fff; border: 1.5px solid #e2e8f0; border-radius: 14px;
            padding: 14px 16px 14px 44px; font-size: 0.95rem; font-weight: 500;
            color: #0f172a; transition: 0.3s; font-family: inherit;
        }
        .input-icon {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1.1rem; pointer-events: none; transition: 0.3s;
        }
        .custom-input:focus { outline: none; border-color: #22c55e; box-shadow: 0 0 0 4px rgba(34,197,94,0.1); }
        .custom-input:focus + .input-icon, .custom-input:not(:placeholder-shown) + .input-icon { color: #16a34a; }

        .eye-btn {
            position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94a3b8; font-size: 1.1rem;
            cursor: pointer; transition: 0.2s; padding: 4px;
        }
        .eye-btn:hover { color: #64748b; }

        /* Link */
        .forgot-link { display: block; text-align: right; font-size: 0.8rem; font-weight: 700; color: #16a34a; text-decoration: none; margin-bottom: 24px; transition: 0.2s; }
        .forgot-link:hover { color: #15803d; text-decoration: underline; }

        /* Button */
        .submit-btn {
            width: 100%; background: linear-gradient(135deg, #16a34a, #15803d);
            border: none; border-radius: 14px; padding: 16px; color: #fff;
            font-size: 1rem; font-weight: 800; cursor: pointer; transition: 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 8px 16px rgba(22,163,74,0.25); font-family: inherit;
        }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(22,163,74,0.3); }

        .secure-badge {
            margin-top: 24px; display: flex; align-items: center; justify-content: center; gap: 8px;
            font-size: 0.75rem; font-weight: 600; color: #94a3b8;
        }
        .secure-badge i { color: #10b981; }

    </style>
</head>
<body>

    <div class="login-card">
        <form method="POST" action="{{ route('loginSubmit') }}" id="login-form">
            @csrf

            <!-- Header -->
            <div class="brand-header">
                <div class="brand">
                    <div class="brand-icon">
                        <i class="mdi mdi-lightning-bolt"></i>
                    </div>
                    <div class="brand-name">ECOVOLT</div>
                </div>
                <h1 class="form-title">Welcome Back 👋</h1>
                <p class="form-subtitle">Access your enterprise dashboard</p>
            </div>

            <!-- Error Notification -->
            @error('email')
                <div class="error-toast">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
            
            @error('role')
                <div class="error-toast">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            @if(session('error'))
                <div class="error-toast">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Role Selector -->
            <span class="role-label-txt">Access Identity</span>
            <div class="role-grid">
                <label class="role-opt">
                    <input type="radio" name="role" value="Admin" checked>
                    <div class="role-tile">
                        <div class="ico"><i class="mdi mdi-shield-crown-outline"></i></div>
                        <div>
                            <span class="nm">Master</span>
                            <span class="sub">Admin</span>
                        </div>
                    </div>
                </label>

                <label class="role-opt">
                    <input type="radio" name="role" value="Dealer">
                    <div class="role-tile">
                        <div class="ico"><i class="mdi mdi-handshake-outline"></i></div>
                        <div>
                            <span class="nm">Partner</span>
                            <span class="sub">Dealer</span>
                        </div>
                    </div>
                </label>

                <label class="role-opt">
                    <input type="radio" name="role" value="Accounts">
                    <div class="role-tile">
                        <div class="ico"><i class="mdi mdi-calculator-variant-outline"></i></div>
                        <div>
                            <span class="nm">Finance</span>
                            <span class="sub">Accounts</span>
                        </div>
                    </div>
                </label>
            </div>

            <!-- Inputs -->
            <span class="role-label-txt">Enterprise Email</span>
            <div class="input-group">
                <input type="email" name="email" class="custom-input" placeholder="someone@ecovolt.com" value="{{ old('email') }}" required autofocus>
                <i class="mdi mdi-email-outline input-icon"></i>
            </div>

            <span class="role-label-txt">Access Passkey</span>
            <div class="input-group" style="margin-bottom: 8px;">
                <input type="password" name="password" id="password_input" class="custom-input" placeholder="•••••••••" required>
                <i class="mdi mdi-lock-outline input-icon"></i>
                <button type="button" class="eye-btn" id="toggle_pwd" tabindex="-1">
                    <i class="mdi mdi-eye-outline" id="eye_icon"></i>
                </button>
            </div>

            <a href="javascript:void(0)" class="forgot-link">Forgot Settings?</a>

            <!-- Submit -->
            <button type="submit" class="submit-btn" id="submit_btn">
                <i class="mdi mdi-shield-check-outline"></i> Authorize Access
            </button>

            <!-- Footer Badge -->
            <div class="secure-badge">
                <i class="mdi mdi-lock"></i>
                <span>256-bit SSL secured&nbsp;&nbsp;•&nbsp;&nbsp;EcoVolt Cloud</span>
            </div>
        </form>
    </div>

    <!-- Password visibility script -->
    <script>
        const passInput = document.getElementById('password_input');
        const eyeBtn = document.getElementById('toggle_pwd');
        const eyeIcon = document.getElementById('eye_icon');

        eyeBtn.addEventListener('click', () => {
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.classList.replace('mdi-eye-outline', 'mdi-eye-off-outline');
            } else {
                passInput.type = 'password';
                eyeIcon.classList.replace('mdi-eye-off-outline', 'mdi-eye-outline');
            }
        });

        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit_btn');
            btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Authenticating...';
            btn.style.opacity = '0.8';
        });
    </script>
</body>
</html>
