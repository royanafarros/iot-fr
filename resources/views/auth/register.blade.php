<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register IoT</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: linear-gradient(135deg, #43e97b, #38f9d7);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 320px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #43e97b;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

.error {
    color: red;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="card">
    <h2>📝 Register</h2>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="name" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

        <button type="submit">Register</button>
    </form>

    <p style="text-align:center;">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
</div>

</body>
</html>