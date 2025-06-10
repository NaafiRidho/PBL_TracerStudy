<!DOCTYPE html> 
<html>
<head>
    <title>OTP Verification</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            line-height: 1.6;
            color: #000;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-container p {
            color: #000 !important;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .institution-name {
            font-size: 18px;
            font-weight: bold;
            color: #0066cc;
            margin: 10px 0;
            padding: 15px 20px;
            background: rgba(128, 128, 128, 0.15);
            border-radius: 8px;
            display: inline-block;
        }
        .otp-code {
            font-size: 28px;
            letter-spacing: 5px;
            color: #d32f2f;
            text-align: center;
            margin: 25px 0;
            padding: 15px;
            background: #f9f9f9;
            border: 1px dashed #d32f2f;
            border-radius: 5px;
        }
        .warning {
            color: red !important;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #fff3f3;
            border-left: 4px solid red;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #000;
            font-size: 14px;
        }
        .footer p {
            color: #000 !important;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="institution-name">POLITEKNIK NEGERI MALANG</div>
        </div>

        <p>Selamat datang,</p>
        
        <p>
            Anda sedang melakukan verifikasi keamanan akun. Silakan masukkan kode verifikasi berikut:
        </p>

        <div class="otp-code">{{ $otp ?? 'Tidak ada OTP' }}</div>

        <div class="warning">
            ⚠️ Peringatan: Jangan berikan kode ini kepada siapapun termasuk petugas kami. Kode ini hanya untuk Anda gunakan sendiri.
        </div>

        <p>
            Jika Anda tidak melakukan permintaan ini, harap abaikan email ini dan segera hubungi tim support kami.
        </p>

        <div class="footer">
            <p>
                Dengan hormat,<br>
                <strong>Politeknik Negeri Malang</strong>
            </p>
        </div>
    </div>
</body>
</html>