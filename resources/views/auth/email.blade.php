<form method="POST" action="{{ route('otp.send') }}">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Kirim OTP</button>
</form>
@if(session('status'))
    <div>{{ session('status') }}</div>
@endif

@if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

