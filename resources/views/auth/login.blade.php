<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #d8f3dc;
            color: #333;
        }

        .login-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2f855a;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #2f855a;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #f97316;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #ea580c;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>เข้าสู่ระบบ</h1>

        @if ($errors->any())
        <p class="error-message">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <label for="a_e_id">รหัสพนักงาน/ผู้ดูแลระบบ</label>
            <input id="a_e_id" type="email" name="email" required autofocus>

            <label for="password">รหัสผ่าน</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>

</html>
