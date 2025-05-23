<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Tracer Study</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
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
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
        }

        .login-image {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1623461487986-9400110de28e?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            min-height: 500px;
        }

        .login-container {
            flex: 1;
            padding: 40px;
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
            font-size: 24px;
            margin-bottom: 10px;
            color: #2c3e50;
            text-align: center;
        }

        p {
            font-size: 14px;
            color: #7f8c8d;
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
            border-color: #3498db;
            outline: none;
        }

        .otp-button {
            background-color: #3498db;
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
            background-color: #2980b9;
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
            <h1>Login Tracer Study</h1>
            <p>Masukkan email Anda untuk menerima kode OTP</p>

            <form method="POST" action="{{ route('otp.send') }}" id="otp.send">
                @csrf
                <label>Email:</label>
                <input type="email" name="email" required>
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