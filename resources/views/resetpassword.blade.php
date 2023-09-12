{{-- resources/views/emails/reset_password.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vampire Kingdom - Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .message {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="https://i.ibb.co/zFfk63Z/removal-ai-9e1a1dae-adfd-4af4-9942-cd3a2db80dd6-354430263-1365058510889489-2214758273738567925-n.png" alt="Vampire Kingdom Logo">
            <h2>Vampire Kingdom</h2>
        </div>
        <div class="message">
            <p>Halo, {{ $data['name'] }}</p>
            <p>Kami menerima permintaan untuk mereset password akun Anda di Vampire Kingdom. Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.</p>
            <p>Untuk mereset password akun Anda, silakan klik tombol di bawah ini:</p>
            <p>
                <a href="{{ $data['link'] }}" target="_blank" style="display: inline-block; padding: 12px 24px; background-color: #333; color: #fff; text-decoration: none; border-radius: 4px;">Reset Password</a>
            </p>
            <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke dalam browser Anda:</p>
            <p><a href="{{ $data['link'] }}" target="_blank">reset</a></p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis, jangan membalas pesan ini.</p>
            <p>&copy; {{ date('Y') }} Vampire Kingdom. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
