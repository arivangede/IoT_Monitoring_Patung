<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }
        .email-body {
            padding: 20px 0;
            color: #555555;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 20px;
        }
        .email-button {
            text-align: center;
        }
        .email-button a {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .email-button a:hover {
            background-color: #0056b3;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #aaaaaa;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Verifikasi Email Anda</h1>
        </div>
        <div class="email-body">
            <p>Halo,</p>
            <p>Email anda telah terdaftar sebagai penerima notifikasi {{ env('APP_NAME', 'Default Name') }}. Silakan klik tombol di bawah untuk memverifikasi email Anda dan mengaktifkan notifikasi Anda:</p>
            <div class="email-button">
                <a href="{{ $verificationLink }}" target="_blank">Verifikasi Email</a>
            </div>
            <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
            <p>Atau salin dan tempel tautan ini di browser Anda: <br>
                <a href="{{ $verificationLink }}" style="color: #007bff;">{{ $verificationLink }}</a>
            </p>
        </div>
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ env('APP_NAME','Default Name') }}. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
