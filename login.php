<?php

session_start();
include "koneksi.php";

if (isset($_SESSION['login'])) {

    if ($_SESSION['role'] == "Admin") {
        header("Location: admin/admin_index.php");
    } else {
        header("Location: kasir/kasir_index.php");
    }

    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];

    // Password dari form diubah menjadi MD5
    $password = md5($_POST['password']);

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM user
        WHERE Username='$username'
        AND Password='$password'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {

        $_SESSION['login'] = true;
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['username'] = $data['Username'];
        $_SESSION['role'] = $data['Role'];

        if ($data['Role'] == "Admin") {

            header("Location: admin/admin_index.php");

        } else {

            header("Location: kasir/kasir_index.php");

        }

        exit;

    } else {

        $error = "Username atau password salah!";

    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login FirSkincare</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                radial-gradient(circle at 10% 20%, rgba(255,255,255,.8), transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(255,255,255,.7), transparent 25%),
                linear-gradient(135deg, #eadcff, #d8c0f0, #f3e8ff);
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "✦";
            position: absolute;
            top: 12%;
            left: 15%;
            font-size: 45px;
            color: rgba(126, 77, 160, .25);
        }

        body::after {
            content: "♡";
            position: absolute;
            bottom: 12%;
            right: 15%;
            font-size: 65px;
            color: rgba(126, 77, 160, .20);
        }

        .circle-one {
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255,255,255,.22);
            top: -70px;
            right: -60px;
        }

        .circle-two {
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.20);
            bottom: -60px;
            left: -50px;
        }

        .login-box {
            width: 420px;
            padding: 42px 40px;
            background: rgba(255,255,255,.92);
            border-radius: 30px;
            box-shadow:
                0 25px 60px rgba(91, 54, 120, .20),
                0 5px 15px rgba(91, 54, 120, .10);
            text-align: center;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .logo {
            width: 82px;
            height: 82px;
            margin: 0 auto 18px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #8e5bb7, #b784d4);
            box-shadow: 0 12px 25px rgba(126, 77, 160, .30);
        }

        .login-box h1 {
            color: #5c3475;
            font-size: 30px;
            margin-bottom: 7px;
            letter-spacing: .5px;
        }

        .login-box > p {
            color: #987ba8;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .welcome {
            color: #76518b;
            font-size: 13px;
            margin-bottom: 22px;
            background: #f7f0fc;
            padding: 10px;
            border-radius: 12px;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            color: #654174;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border: 1.5px solid #dfcceb;
            border-radius: 14px;
            background: #fcf9ff;
            color: #513460;
            font-size: 14px;
            outline: none;
            transition: .25s;
        }

        input:focus {
            border-color: #9865b9;
            background: white;
            box-shadow: 0 0 0 4px rgba(152,101,185,.10);
        }

        input::placeholder {
            color: #b9a4c4;
        }

        button {
            width: 100%;
            border: none;
            padding: 15px;
            margin-top: 5px;
            border-radius: 15px;
            background: linear-gradient(135deg, #8150a6, #a875c6);
            color: white;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: .8px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(126,77,160,.25);
            transition: .25s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 25px rgba(126,77,160,.30);
        }

        button:active {
            transform: scale(.98);
        }

        .error {
            background: #fff0f3;
            color: #c44c6c;
            border: 1px solid #f4c6d1;
            padding: 11px 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
        }

        .footer-text {
            margin-top: 25px;
            color: #ad96b8;
            font-size: 12px;
        }

        .beauty {
            margin-top: 15px;
            font-size: 18px;
            letter-spacing: 8px;
            color: #b084c9;
        }

        @media (max-width: 500px) {

            .login-box {
                width: calc(100% - 30px);
                padding: 35px 25px;
            }

            .login-box h1 {
                font-size: 26px;
            }

        }

    </style>
</head>

<body class="login-body">

<div class="circle-one"></div>
<div class="circle-two"></div>

<div class="login-box">

    <div class="logo">F</div>

    <h1>FirSkincare</h1>

    <p>Sistem Kasir Skincare</p>

    <div class="welcome">
        ✨ Selamat datang, silakan masuk ke akun Anda
    </div>

    <?php if ($error != "") { ?>

        <div class="error">
            ⚠️ <?= $error ?>
        </div>

    <?php } ?>

    <form method="POST">

        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Masukkan username"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Masukkan password"
            required
        >

        <button type="submit" name="login">
            MASUK KE SISTEM 💜
        </button>

    </form>

    <div class="beauty">
        ♡ ✦ ♡
    </div>

    <div class="footer-text">
        FirSkincare • Beauty & Skincare Store
    </div>

</div>

</body>
</html>