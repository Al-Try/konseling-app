<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="max-width:420px;margin:40px auto;font-family:system-ui;">
  <h2>Login</h2>

  @if ($errors->any())
    <p style="color:#b91c1c">{{ $errors->first() }}</p>
  @endif

  <form method="POST" action="{{ url('/login') }}">
    @csrf
    <div style="margin:8px 0">
      <label>Email</label><br>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus style="width:100%">
    </div>

    <div style="margin:8px 0">
      <label>Password</label><br>
      <input type="password" name="password" required style="width:100%">
    </div>

    <label><input type="checkbox" name="remember"> Remember me</label>

    <div style="margin-top:12px">
      <button type="submit">Masuk</button>
    </div>
  </form>
</body>
</html>
