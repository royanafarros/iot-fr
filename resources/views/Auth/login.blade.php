<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login IoT Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            /* Background gradasi modern yang menyatu dengan tema IoT */
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Ornamen Dekorasi di Belakang (Agar lebih "Modern") */
        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: #38bdf8;
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.2;
            animation: move 10s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-10%, -10%); }
            to { transform: translate(20%, 20%); }
        }

        .card {
            /* Efek Glassmorphism */
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 40px;
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .card h2 {
            color: white;
            font-size: 28px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .card p {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .icon-box {
            background: #38bdf8;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 32px;
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(14, 165, 233, 0.5);
            filter: brightness(1.1);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        /* Footer teks kecil */
        .footer-text {
            margin-top: 25px;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="blob"></div>

    <div class="card">
        <div class="icon-box">🔐</div>
        <h2>Welcome Back</h2>
        <p>Akses panel monitoring IoT Anda sekarang</p>

        <form method="POST" action="{{ route('auto.login') }}">
            @csrf
            <button type="submit" class="btn-login">
                Masuk ke Dashboard 🚀
            </button>
        </form>

        <div class="footer-text">
            © 2026 IoT Tester System • Secured Access
        </div>
    </div>

</body>
</html>