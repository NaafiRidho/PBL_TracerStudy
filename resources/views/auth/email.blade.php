<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Tracer Study</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .login-wrapper {
            display: flex;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 920px;
            width: 95%;
        }

        .login-image {
            flex: 1.5;
            background-image: url('https://alumni.polinema.ac.id/front/upload/IMG_92751.JPG');
            background-size: cover;
            background-position: center;
            min-height: 150px;
            /* Tambahkan ini untuk rounded kanan */
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .login-container {
            flex: 1.5;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
            align-self: center;
            position: center;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #1d4582;
            text-align: center;
        }

        p {
            font-size: 15px;
            color: #555
            margin-bottom: 25px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        input[type="email"]:focus {
            border-color: #1d4582;
            outline: none;
        }

        .otp-button {
            background-color: #1d4582;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .otp-button:hover {
            background-color: #002244;
        }

        .otp-button:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #95a5a6;
            text-align: center;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-image {
                min-height: 200px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-image"></div>

        <div class="login-container">
            <img src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/Logo-Polinema.png') }}" alt="Logo"
                width="50" class="logo">
            <h1>Tracer Study Alumni</h1>
            <p>Masukkan email Anda untuk menerima kode OTP</p>

            <form method="POST" action="{{ route('otp.send') }}" id="otp.send">
                @csrf
                <label>Email:</label>
                <input type="email" name="email" required placeholder="contoh: alumni@polinema.ac.id">
                <button type="submit" class="otp-button">Kirim OTP</button>
            </form>
            
            @if(session('status'))
                <div>{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <ul style="color: red; margin-top: 15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="footer">
                Sistem Tracer Study Alumni © 2025
            </div>
        </div>
    </div>
    <script>
        document.getElementById('otp.send').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            alert(`Kode OTP telah dikirim ke ${email}. Silakan cek email Anda.`);
            // Di sini biasanya akan ada kode untuk mengirim OTP ke email
        });
    </script>
</body>
</html>