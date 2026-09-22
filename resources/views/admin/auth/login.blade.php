<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>অ্যাডমিন লগইন</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .3);
            max-width: 400px;
        }

        .login-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #c00, #7a0000);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card login-card mx-auto p-4 p-md-5">
            <div class="login-icon"><i class="bi bi-shield-lock"></i></div>
            <h4 class="text-center mb-1">অ্যাডমিন প্যানেল</h4>
            <p class="text-center text-muted small mb-4">শুধুমাত্র অনুমোদিত অ্যাডমিনদের জন্য</p>

            @if ($errors->any())
                <div class="alert alert-danger small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning small">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ইমেইল</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required
                        autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small" for="remember">লগইন মনে রাখুন</label>
                </div>
                <button type="submit" class="btn btn-danger w-100">লগইন করুন</button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-muted small"><i class="bi bi-arrow-left"></i> সাইটে ফিরে
                    যান</a>
            </div>
        </div>
    </div>
</body>

</html>
