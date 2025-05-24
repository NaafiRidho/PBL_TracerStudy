<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3182ce;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:disabled {
            background-color: #a0aec0;
        }

        #otpMessage {
            margin-top: 1rem;
            padding: 0.75rem;
            text-align: center;
            border-radius: 6px;
            font-weight: bold;
        }

        .success {
            background-color: #e6fffa;
            color: #2c7a7b;
        }

        .error {
            background-color: #fff5f5;
            color: #c53030;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="text-align: center;">Verifikasi OTP</h2>
        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <label>Masukkan OTP:</label>
            <input type="text" name="otp_code" required>
            <button type="submit" id="verifyBtn">Verifikasi</button>
        </form>
        <div id="otpMessage"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#otpForm').submit(function (e) {
                e.preventDefault();

                const token = $('meta[name="csrf-token"]').attr('content');
                const otpCode = $('#otp_code').val();

                $('#verifyBtn').prop('disabled', true).text('Memverifikasi...');
                $('#otpMessage').removeClass('success error').html('');

                $.ajax({
                    url: "{{ route('otp.verify') }}",
                    type: "POST",
                    data: {
                        _token: token,
                        otp_code: otpCode
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#otpMessage').addClass('success').html(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirect_url || '/dashboard';
                            }, 1500);
                        } else {
                            $('#otpMessage').addClass('error').html(response.message || 'OTP tidak valid');
                        }
                    },
                    error: function () {
                        $('#otpMessage').addClass('error').html('Terjadi kesalahan. Silakan coba lagi.');
                    },
                    complete: function () {
                        $('#verifyBtn').prop('disabled', false).text('Verifikasi');
                    }
                });
            });
        });
    </script>
</body>

</html>