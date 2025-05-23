<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <label>Masukkan OTP:</label>
    <input type="text" name="otp_code" required>
    <button type="submit">Verifikasi</button>
</form>
