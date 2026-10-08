<?php 
 
include "../koneksi.php"; 
include "admin_header.php"; 
 
$pelanggan = mysqli_fetch_assoc( 
    mysqli_query( 
        $koneksi, 
        "SELECT COUNT(*) AS jumlah FROM pelanggan" 
    ) 
); 
 
$produk = mysqli_fetch_assoc( 
    mysqli_query( 
        $koneksi, 
        "SELECT COUNT(*) AS jumlah FROM produk" 
    ) 
); 
 
$transaksi = mysqli_fetch_assoc( 
    mysqli_query( 
        $koneksi, 
        "SELECT COUNT(*) AS jumlah FROM penjualan" 
    ) 
); 
 
?> 

<style>

    .admin-content {
        padding: 30px;
    }

    .hero-admin {
        background: linear-gradient(135deg, #ead9f5, #f7edfc);
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        border: 1px solid #ead8f1;
    }

    .hero-admin::after {
        content: "✦";
        position: absolute;
        right: 45px;
        top: 20px;
        font-size: 75px;
        color: rgba(126, 77, 160, .12);
    }

    .hero-admin h1 {
        margin: 0 0 8px;
        color: #59366f;
        font-size: 30px;
    }

    .hero-admin p {
        margin: 0;
        color: #8b6c9b;
        font-size: 14px;
    }

    .hero-small {
        margin-top: 18px;
        display: inline-block;
        background: rgba(255,255,255,.65);
        color: #75488c;
        padding: 9px 15px;
        border-radius: 12px;
        font-size: 13px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        margin-bottom: 28px;
    }

    .card {
        background: white;
        border-radius: 22px;
        padding: 24px;
        border: 1px solid #eee1f4;
        box-shadow: 0 10px 28px rgba(91, 54, 120, .08);
        position: relative;
        overflow: hidden;
        transition: .25s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px rgba(91, 54, 120, .14);
    }

    .card::after {
        content: "";
        width: 80px;
        height: 80px;
        position: absolute;
        right: -25px;
        bottom: -25px;
        border-radius: 50%;
        background: #f3e8f8;
    }

    .card-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #eee0f7, #dcc2ed);
        font-size: 25px;
        margin-bottom: 17px;
    }

    .card h3 {
        margin: 0 0 8px;
        font-size: 14px;
        font-weight: normal;
        color: #9275a1;
    }

    .card h2 {
        margin: 0;
        color: #5c3475;
        font-size: 30px;
    }

    .box {
        background: white;
        border-radius: 24px;
        padding: 28px;
        border: 1px solid #eee1f4;
        box-shadow: 0 10px 28px rgba(91, 54, 120, .07);
    }

    .box-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .box-title-icon {
        width: 42px;
        height: 42px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1e4f7;
        font-size: 20px;
    }

    .box h2 {
        margin: 0;
        color: #5c3475;
        font-size: 21px;
    }

    .box p {
        margin: 0;
        color: #897397;
        line-height: 1.8;
        font-size: 14px;
    }

    .quick-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 22px;
    }

    .info-item {
        background: #faf6fc;
        border-radius: 16px;
        padding: 17px;
        color: #765584;
        font-size: 13px;
    }

    .info-item strong {
        display: block;
        color: #5c3475;
        margin-bottom: 5px;
    }

    @media (max-width: 850px) {
        .cards {
            grid-template-columns: 1fr;
        }

        .quick-info {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .admin-content {
            padding: 20px;
        }

        .hero-admin h1 {
            font-size: 24px;
        }
    }

</style>

<div class="admin-content">

    <div class="hero-admin">

        <h1>Dashboard Admin ✨</h1>

        <p>
            Selamat datang di sistem manajemen FirSkincare 👋
        </p>

        <div class="hero-small">
            💜 Kelola toko skincare dengan mudah dan nyaman
        </div>

    </div>


    <div class="cards">

        <div class="card">

            <div class="card-icon">👥</div>

            <h3>Total Pelanggan</h3>

            <h2>
                <?= $pelanggan['jumlah']; ?>
            </h2>

        </div>


        <div class="card">

            <div class="card-icon">🧴</div>

            <h3>Total Produk</h3>

            <h2>
                <?= $produk['jumlah']; ?>
            </h2>

        </div>


        <div class="card">

            <div class="card-icon">🛍️</div>

            <h3>Total Transaksi</h3>

            <h2>
                <?= $transaksi['jumlah']; ?>
            </h2>

        </div>

    </div>


    <div class="box">

        <div class="box-title">

            <div class="box-title-icon">
                ✨
            </div>

            <h2>FirSkincare</h2>

        </div>

        <p>
            Admin dapat mengelola data pelanggan, produk,
            transaksi, laporan, dan statistik penjualan
            melalui dashboard FirSkincare.
        </p>


        <div class="quick-info">

            <div class="info-item">
                <strong>👥 Pelanggan</strong>
                Kelola data pelanggan
            </div>

            <div class="info-item">
                <strong>🧴 Produk</strong>
                Kelola produk skincare
            </div>

            <div class="info-item">
                <strong>🛒 Penjualan</strong>
                Pantau transaksi
            </div>

        </div>

    </div>

</div>

</div>

</body>
</html>