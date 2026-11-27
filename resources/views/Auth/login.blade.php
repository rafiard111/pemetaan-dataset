
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Satu Data OPD</title>

    <style>
        :root {
            --navy: #102b50;
            --blue: #1769aa;
            --gold: #d6ad55;
            --ink: #172b45;
            --muted: #718096;
            --line: #dce5ef;
            --surface: #ffffff;
            --page: #f2f6fb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 15%, rgba(42,117,183,.13), transparent 28%),
                radial-gradient(circle at 90% 85%, rgba(214,173,85,.12), transparent 25%),
                var(--page);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .login-shell {
            width: min(100%, 1200px);
            min-height: 650px;
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            background: var(--surface);
            border: 1px solid rgba(210,222,235,.9);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(16,43,80,.13);
        }

        .brand-panel {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 54px 48px;
            color: white;
            background:
                linear-gradient(
                    90deg,
                    rgba(10,30,56,.82) 0%,
                    rgba(10,30,56,.62) 52%,
                    rgba(10,30,56,.30) 100%
                ),
                url('{{ asset('images/ilustrasi-login.jpeg') }}') center center / cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-content,
        .brand-footer {
            position: relative;
            z-index: 1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .eyebrow,
        .brand-panel h1,
        .gold-line,
        .brand-panel p,
        .brand-footer {
            opacity: 0;
            animation: fadeInUp .8s ease-out forwards;
        }

        .eyebrow { animation-delay: .15s; }
        .brand-panel h1 { animation-delay: .35s; }
        .gold-line { animation-delay: .55s; }
        .brand-panel p { animation-delay: .75s; }
        .brand-footer { animation-delay: .95s; }

        .form-panel {
            padding: 58px clamp(28px,5vw,62px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeInUp .8s ease-out .25s both;
        }

        .eyebrow {
            display: inline-block;
            color: #f3d27e;
            background: rgba(10,30,56,.55);
            padding: 7px 11px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .brand-panel h1 {
            max-width: 440px;
            margin: 0 0 18px;
            color: #fff;
            font-size: clamp(30px,4vw,43px);
            line-height: 1.13;
            letter-spacing: -.8px;
            text-shadow: 0 2px 12px rgba(0,0,0,.35);
        }

        .brand-panel p {
            max-width: 410px;
            color: rgba(255,255,255,.94);
            background: rgba(10,30,56,.48);
            border-left: 4px solid var(--gold);
            border-radius: 0 10px 10px 0;
            padding: 13px 16px;
            font-size: 14px;
            line-height: 1.8;
            margin: 0;
            text-shadow: 0 1px 5px rgba(0,0,0,.3);
        }

        .gold-line {
            width: 58px;
            height: 4px;
            border-radius: 99px;
            background: var(--gold);
            margin: 28px 0;
        }

        .brand-footer {
            display: inline-block;
            width: fit-content;
            color: rgba(255,255,255,.92);
            background: rgba(10,30,56,.58);
            border-radius: 9px;
            padding: 9px 12px;
            font-size: 11px;
            line-height: 1.7;
            backdrop-filter: blur(5px);
        }

        .form-heading { margin-bottom: 34px; }

        .form-heading .mini-label {
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .form-heading h2 {
            margin: 0 0 9px;
            color: var(--navy);
            font-size: 29px;
            letter-spacing: -.5px;
        }

        .form-heading p {
            color: var(--muted);
            margin: 0;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 13px;
            font-size: 12px;
            line-height: 1.6;
        }

        .alert-error {
            color: #9b2632;
            background: #fff0f1;
            border: 1px solid #ffd4d8;
        }

        .alert-success {
            color: #17633c;
            background: #edfbf3;
            border: 1px solid #c8efd8;
        }

        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #30445e;
            font-size: 12px;
            font-weight: 700;
        }

        .input-wrap { position: relative; }

        .field input {
            width: 100%;
            height: 51px;
            padding: 0 16px;
            border: 1px solid var(--line);
            border-radius: 14px;
            outline: none;
            background: #fbfdff;
            color: var(--ink);
            font-size: 13px;
            transition: .2s ease;
        }

        .field input:focus {
            border-color: #5b9bd0;
            background: white;
            box-shadow: 0 0 0 4px rgba(23,105,170,.10);
        }

        .field input::placeholder { color: #a5b1c0; }

        .password-input {
            padding-right: 55px !important;
        }

        /* IKON MATA PASSWORD */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 50%;
            background: transparent;
            color: #8293a8;
            cursor: pointer;
            transition: .2s ease;
        }

        .toggle-password:hover {
            color: var(--blue);
            background: #edf5fd;
        }

        .toggle-password:focus-visible {
            outline: 2px solid var(--blue);
            outline-offset: 2px;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 2px 0 25px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 12px;
            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: var(--blue);
        }

        .submit-btn {
            width: 100%;
            min-height: 51px;
            border: 0;
            border-radius: 999px;
            color: white;
            background: linear-gradient(100deg,#1769aa,#104d86);
            box-shadow: 0 9px 20px rgba(23,105,170,.20);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .2px;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 13px 25px rgba(23,105,170,.27);
            filter: brightness(1.06);
        }

        .submit-btn:active { transform: translateY(0); }

        .security-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 25px;
            color: #8290a2;
            font-size: 10px;
            line-height: 1.65;
        }

        .security-note span {
            color: #25815a;
            font-size: 14px;
        }

        @media (max-width: 760px) {
            body { padding: 14px; }

            .login-shell {
                max-width: 520px;
                min-height: auto;
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .brand-panel {
                padding: 27px 28px;
                min-height: 300px;
                background-position: center 42%;
            }

            .brand-panel h1 {
                font-size: 25px;
                margin-bottom: 8px;
            }

            .brand-panel p { font-size: 12px; }
            .brand-panel .gold-line { margin: 16px 0; }
            .brand-footer { display: none; }

            .form-panel { padding: 34px 28px 38px; }
            .form-heading { margin-bottom: 25px; }
            .form-heading h2 { font-size: 25px; }
        }

        @media (max-width: 380px) {
            body { padding: 8px; }
            .brand-panel { padding: 22px; min-height: 270px; }
            .form-panel { padding: 28px 20px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="brand-panel">
            <div class="brand-content">
                <div class="eyebrow">Platform Data Pemerintahan</div>

                <h1>Satu Data<br>Organisasi Perangkat Daerah</h1>

                <div class="gold-line"></div>

                <p>
                    Sistem pengelolaan, klasifikasi, pemetaan, dan analisis
                    dataset untuk mendukung tata kelola data antar-OPD.
                </p>
            </div>

            <div class="brand-footer">
                Sistem Informasi Pemetaan Dataset OPD<br>
                Akses terbatas untuk pengguna yang berwenang.
            </div>
        </section>

        <section class="form-panel">
            <div class="form-heading">
                <div class="mini-label">Selamat datang kembali</div>
                <h2>Masuk ke Sistem</h2>
                <p>Gunakan akun yang telah didaftarkan oleh administrator.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@instansi.go.id"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input
                            class="password-input"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            class="toggle-password"
                            type="button"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                            aria-pressed="false"
                            title="Tampilkan password"
                        >
                            <!-- Ikon mata -->
                            <svg id="eyeIcon"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>
                </div>

                <button class="submit-btn" type="submit">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="security-note">
                <span>●</span>
                <div>
                    Akses sistem dilindungi. Jangan membagikan akun dan
                    password kepada pihak lain.
                </div>
            </div>
        </section>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        const eyeOpen = `
            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
            <circle cx="12" cy="12" r="3"/>
        `;

        const eyeClosed = `
            <path d="M3 3l18 18"/>
            <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
            <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a16.5 16.5 0 0 1-3.1 3.8"/>
            <path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7c1.1 0 2.1-.2 3-.5"/>
        `;

        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';

                passwordInput.type = isPassword ? 'text' : 'password';

                eyeIcon.innerHTML = isPassword ? eyeClosed : eyeOpen;

                this.setAttribute(
                    'aria-label',
                    isPassword ? 'Sembunyikan password' : 'Tampilkan password'
                );

                this.setAttribute('title',
                    isPassword ? 'Sembunyikan password' : 'Tampilkan password'
                );

                this.setAttribute('aria-pressed', String(isPassword));
            });
        }
    </script>
</body>
</html>
