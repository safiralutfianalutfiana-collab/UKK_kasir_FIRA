<?php 
 
session_start(); 
 
if (!isset($_SESSION['login']) || $_SESSION['role'] != "Admin") { 
    header("Location: ../login.php"); 
    exit; 
} 
 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
 
<head> 
 
    <meta charset="UTF-8"> 
 
    <meta name="viewport" 
          content="width=device-width, initial-scale=1.0"> 
 
    <title>Admin - FirSkincare</title> 
 
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

        .logo-area {
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

        .logo-area h2 {
            color: white;
            font-size: 21px;
            margin-bottom: 6px;
        }

        .logo-area p {
            color: rgba(255,255,255,.75);
            font-size: 12px;
        }

        /* MENU */

        .sidebar > a {
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

        .sidebar > a:hover {
            background: rgba(255,255,255,.17);
            color: white;
            transform: translateX(3px);
        }

        .sidebar > a[href="admin_index.php"] {
            background: rgba(255,255,255,.22);
            color: white;
            box-shadow: 0 5px 15px rgba(60,30,80,.10);
        }

        .sidebar br + a {
            margin-top: 12px;
            background: rgba(70,35,90,.16);
        }

        /* CONTENT */

        .content {
            margin-left: 245px;
            min-height: 100vh;
            padding: 25px 30px;
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

        .topbar b {
            color: #5d3d70;
            font-size: 18px;
        }

        .user {
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

        /* DECORASI */

        .content::before {
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

            .content {
                margin-left: 210px;
                padding: 20px;
            }

            .sidebar > a {
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

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar > a {
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
 
    <div class="logo-area"> 
 
        <div class="logo-circle"> 
            F 
        </div> 
 
        <h2>FirSkincare</h2> 
 
        <p>Panel Administrator</p> 
 
    </div> 
 
    <a href="admin_index.php"> 
        🏠 Dashboard 
    </a> 
 
    <a href="admin_pelanggan.php"> 
        👥 Pelanggan 
    </a> 
 
    <a href="admin_produk.php"> 
        🧴 Produk 
    </a> 
 
    <a href="admin_transaksi.php"> 
        🛒 Transaksi 
    </a> 
 
    <a href="admin_laporan.php"> 
        📊 Laporan 
    </a> 
 
    <a href="admin_statistik.php"> 
        📈 Statistik 
    </a> 
 
    <br> 
 
    <a href="../logout.php"> 
        🚪 Logout 
    </a> 
 
</div> 
 
<div class="content"> 
 
<div class="topbar"> 
 
    <b>Panel Admin ✨</b> 
 
    <span class="user"> 
        👤 <?= $_SESSION['username']; ?> 
    </span> 
 
</div>