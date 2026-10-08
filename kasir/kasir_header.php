<?php 
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
} 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>FirSkincare - Kasir</title> 
 
    <style> 

        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
            font-family: Arial, Helvetica, sans-serif; 
        } 
 
        body { 
            min-height: 100vh; 
            background: #f8f3fb; 
            color: #5d4569; 
        } 
 
        /* SIDEBAR */ 
 
        .sidebar { 
            position: fixed; 
            left: 0; 
            top: 0; 
            width: 245px; 
            height: 100vh; 
            padding: 25px 16px; 
 
            background: linear-gradient( 
                180deg, 
                #765092, 
                #8e65aa, 
                #a77fc0 
            ); 
 
            box-shadow: 5px 0 25px rgba(80, 45, 100, .12); 
            z-index: 10; 
        } 
 
        .logo { 
            text-align: center; 
            padding-bottom: 28px; 
        } 
 
        .logo-circle { 
            width: 68px; 
            height: 68px; 
            margin: 0 auto 13px; 
 
            display: flex; 
            align-items: center; 
            justify-content: center; 
 
            border-radius: 22px; 
 
            background: rgba(255,255,255,.20); 
            border: 2px solid rgba(255,255,255,.45); 
 
            color: white; 
            font-size: 34px; 
            font-weight: bold; 
 
            box-shadow: 0 8px 20px rgba(50,30,70,.15); 
        } 
 
        .logo h2 { 
            color: white; 
            font-size: 21px; 
            margin-bottom: 6px; 
        } 
 
        .logo p { 
            color: rgba(255,255,255,.75); 
            font-size: 12px; 
        } 
 
        /* MENU */ 
 
        .menu { 
            margin-top: 0; 
        } 
 
        .menu a { 
            display: flex; 
            align-items: center; 
            gap: 11px; 
 
            text-decoration: none; 
 
            color: rgba(255,255,255,.88); 
 
            padding: 13px 15px; 
            margin: 6px 0; 
 
            border-radius: 14px; 
 
            font-size: 14px; 
 
            transition: .25s; 
        } 
 
        .menu a:hover { 
            background: rgba(255,255,255,.17); 
            color: white; 
            transform: translateX(3px); 
        } 
 
        .menu a.active { 
            background: rgba(255,255,255,.22); 
            color: white; 
            box-shadow: 0 5px 15px rgba(60,30,80,.10); 
        } 
 
        .menu a.logout { 
            margin-top: 12px; 
            background: rgba(70,35,90,.16); 
        } 
 
        /* DEKORASI */ 
 
        .decoration { 
            position: absolute; 
            bottom: 25px; 
            left: 25px; 
            color: #eadcf5; 
        } 
 
        .decoration .bintang { 
            font-size: 30px; 
        } 
 
        .decoration p { 
            font-size: 13px; 
            font-style: italic; 
            line-height: 1.5; 
        } 
 
        /* MAIN */ 
 
        .main { 
            margin-left: 245px; 
            min-height: 100vh; 
            padding: 25px 30px; 
 
            background: #f8f3fb; 
        } 
 
        /* TOPBAR */ 
 
        .topbar { 
            height: 70px; 
 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
 
            padding: 0 22px; 
            margin-bottom: 25px; 
 
            background: rgba(255,255,255,.90); 
 
            border: 1px solid #eee2f3; 
            border-radius: 20px; 
 
            box-shadow: 0 8px 25px rgba(80,45,100,.07); 
        } 
 
        .welcome { 
            color: #987ba8; 
            font-size: 13px; 
            margin-bottom: 4px; 
        } 
 
        .topbar strong { 
            color: #5d3d70; 
            font-size: 18px; 
        } 
 
        /* PROFILE */ 
 
        .profile { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
 
            background: #f4ebf8; 
            color: #70498a; 
 
            padding: 10px 15px; 
            border-radius: 13px; 
 
            font-size: 13px; 
            font-weight: bold; 
        } 
 
        /* ISI */ 
 
        .content { 
            padding: 0; 
        } 
 
        .content-header { 
            position: relative; 
            min-height: 145px; 
            display: flex; 
            align-items: center; 
            margin-bottom: 10px; 
        } 
 
        .icon-title { 
            width: 68px; 
            height: 68px; 
            border-radius: 20px; 
 
            background: linear-gradient( 
                135deg, 
                #eee0fa, 
                #d9c1ed 
            ); 
 
            color: #8051a6; 
 
            display: flex; 
            justify-content: center; 
            align-items: center; 
 
            font-size: 31px; 
            margin-right: 18px; 
 
            box-shadow: 0 8px 20px rgba(120,80,150,.10); 
        } 
 
        .judul h1 { 
            color: #50366a; 
            font-size: 30px; 
            margin-bottom: 6px; 
        } 
 
        .judul p { 
            color: #897590; 
            font-size: 14px; 
        } 
 
        /* ORNAMEN SKINCARE */ 
 
        .skincare { 
            position: absolute; 
            right: 25px; 
            top: 5px; 
            text-align: center; 
            color: #a27bbb; 
        } 
 
        .skincare .bintang { 
            font-size: 25px; 
        } 
 
        .skincare h3 { 
            font-family: Georgia, serif; 
            font-size: 20px; 
            font-weight: normal; 
        } 
 
        .skincare p { 
            font-size: 12px; 
            line-height: 1.5; 
        } 
 
        .produk { 
            font-size: 32px; 
            margin-top: 5px; 
        } 
 
        /* CARD */ 
 
        .card { 
            background: white; 
            padding: 25px; 
            border-radius: 20px; 
 
            border: 1px solid #eee2f3; 
 
            box-shadow: 0 8px 25px rgba(80,45,100,.07); 
        } 
 
        .card-title { 
            padding: 16px 20px; 
            border-radius: 15px; 
 
            background: linear-gradient( 
                90deg, 
                #f0e4fa, 
                #f8f1fc 
            ); 
 
            color: #63427f; 
            font-size: 18px; 
            font-weight: bold; 
            margin-bottom: 18px; 
        } 
 
        /* TABEL */ 
 
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            overflow: hidden; 
        } 
 
        thead { 
            background: linear-gradient( 
                90deg, 
                #eee0fa, 
                #f5eafb 
            ); 
        } 
 
        th { 
            padding: 16px; 
            text-align: left; 
            color: #604078; 
            font-size: 13px; 
        } 
 
        td { 
            padding: 16px; 
            border-bottom: 1px solid #eee8f2; 
            color: #57475f; 
            font-size: 14px; 
        } 
 
        tbody tr:hover { 
            background: #fbf7fd; 
        } 
 
        /* BUTTON */ 
 
        .btn { 
            display: inline-block; 
 
            padding: 9px 17px; 
 
            border-radius: 10px; 
 
            text-decoration: none; 
 
            border: none; 
 
            cursor: pointer; 
 
            color: white; 
 
            background: linear-gradient( 
                135deg, 
                #9b69c5, 
                #744399 
            ); 
 
            box-shadow: 0 5px 12px rgba(117,67,155,.2); 
        } 
 
        .btn:hover { 
            transform: translateY(-2px); 
        } 
 
        /* DECORASI MAIN */ 
 
        .main::before { 
            content: "✦"; 
 
            position: fixed; 
 
            right: 35px; 
            bottom: 20px; 
 
            color: rgba(126,77,160,.08); 
 
            font-size: 100px; 
 
            pointer-events: none; 
        } 
 
        /* RESPONSIVE */ 
 
        @media (max-width: 850px) { 
 
            .sidebar { 
                width: 210px; 
            } 
 
            .main { 
                margin-left: 210px; 
                padding: 20px; 
            } 
 
            .skincare { 
                display: none; 
            } 
 
            .menu a { 
                font-size: 13px; 
            } 
        } 
 
        @media (max-width: 650px) { 
 
            .sidebar { 
                position: relative; 
                width: 100%; 
                height: auto; 
                min-height: auto; 
            } 
 
            .main { 
                margin-left: 0; 
                padding: 15px; 
            } 
 
            .menu a { 
                display: inline-flex; 
                width: 48%; 
            } 
 
            .topbar { 
                height: auto; 
                min-height: 65px; 
            } 
        } 
 
    </style> 
</head> 
 
<body> 
 
<div class="sidebar"> 
 
    <div class="logo"> 
 
        <div class="logo-circle">F</div> 
 
        <h2>FirSkincare</h2> 
 
        <p> 
            Beauty & Skincare Store 
        </p> 
 
    </div> 
 
    <div class="menu"> 
 
        <a href="kasir_index.php"> 
           🏠 &nbsp; Dashboard 
        </a> 
 
        <a href="kasir_pelanggan.php"> 
            👥 &nbsp; Pelanggan 
        </a> 
 
        <a href="kasir_transaksi.php"> 
            🛒 &nbsp; Transaksi 
        </a> 
 
        <a href="kasir_riwayat.php" class="active"> 
            ▣ &nbsp; Riwayat 
        </a> 
 
        <a href="../logout.php" class="logout"> 
            🚪&nbsp; Logout 
        </a> 
 
    </div> 
 
    <div class="decoration"> 
 
        <div class="bintang">✦</div> 
 
        <p> 
            Rawat kulitmu,<br> 
            mulai dari sekarang ♡ 
        </p> 
 
    </div> 
 
</div> 
 
<div class="main"> 
 
    <div class="topbar"> 
 
        <div> 
 
            <div class="welcome"> 
                Selamat datang kembali 👋 
            </div> 
 
            <strong> 
                Panel Kasir FirSkincare 
            </strong> 
 
        </div> 
 
        <div class="profile"> 
            👤 <?= $_SESSION['username'] ?? 'Kasir'; ?> 
        </div> 
 
    </div>