<?php

include "../koneksi.php";
include "kasir_header.php";

$transaksi = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS jumlah FROM penjualan"
    )
);

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

?>

<style>

.dashboard-welcome {
    background: linear-gradient(135deg, #8f68ad, #b58ac8);
    border-radius: 23px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(90, 55, 110, .13);
}

.dashboard-welcome::after {
    content: "✦";
    position: absolute;
    right: 30px;
    top: 0;
    font-size: 95px;
    color: rgba(255,255,255,.12);
}

.dashboard-welcome h1 {
    margin: 0 0 8px;
    font-size: 28px;
}

.dashboard-welcome p {
    margin: 0;
    color: rgba(255,255,255,.86);
    font-size: 14px;
}

.dashboard-welcome .mini-text {
    margin-top: 18px;
    display: inline-block;
    padding: 8px 13px;
    border-radius: 20px;
    background: rgba(255,255,255,.16);
    font-size: 12px;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.dashboard-card {
    background: white;
    padding: 24px;
    border-radius: 21px;
    border: 1px solid #eee3f5;
    box-shadow: 0 9px 25px rgba(94,56,120,.08);
    position: relative;
    overflow: hidden;
    transition: .25s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(94,56,120,.13);
}

.dashboard-card::after {
    content: "";
    position: absolute;
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: #f4eafa;
    right: -30px;
    bottom: -30px;
}

.dashboard-icon {
    width: 55px;
    height: 55px;
    border-radius: 17px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    margin-bottom: 17px;
    position: relative;
    z-index: 2;
}

.dashboard-card h3 {
    margin: 0 0 8px;
    color: #765580;
    font-size: 14px;
}

.dashboard-card h2 {
    margin: 0;
    color: #573666;
    font-size: 28px;
    position: relative;
    z-index: 2;
}

.dashboard-info {
    background: white;
    padding: 25px;
    border-radius: 21px;
    border: 1px solid #eee3f5;
    box-shadow: 0 9px 25px rgba(94,56,120,.07);
}

.dashboard-info-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 14px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}

.dashboard-info h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}

.dashboard-info-title span {
    display: block;
    margin-top: 4px;
    color: #a18ca8;
    font-size: 12px;
}

.info-text {
    background: #faf7fc;
    border: 1px solid #eee5f2;
    border-radius: 15px;
    padding: 17px;
    color: #77647e;
    font-size: 13px;
    line-height: 1.7;
}

.menu-hint {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 15px;
}

.hint {
    padding: 14px;
    background: #f8f2fb;
    border-radius: 13px;
    text-align: center;
    color: #765582;
    font-size: 12px;
}

@media (max-width: 850px) {

    .dashboard-cards {
        grid-template-columns: 1fr;
    }

    .menu-hint {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .dashboard-welcome {
        padding: 23px;
    }

    .dashboard-welcome h1 {
        font-size: 23px;
    }

    .dashboard-card,
    .dashboard-info {
        padding: 20px;
    }

}

</style>


<div class="dashboard-welcome">

    <h1>
        Dashboard Kasir ✨
    </h1>

    <p>
        Selamat datang kembali,
        <?= $_SESSION['username']; ?> 👋
    </p>

    <span class="mini-text">
        💜 Kelola transaksi FirSkincare dengan mudah
    </span>

</div>


<div class="dashboard-cards">

    <div class="dashboard-card">

        <div class="dashboard-icon">
            🛒
        </div>

        <h3>
            Total Transaksi
        </h3>

        <h2>
            <?= $transaksi['jumlah']; ?>
        </h2>

    </div>


    <div class="dashboard-card">

        <div class="dashboard-icon">
            👥
        </div>

        <h3>
            Total Pelanggan
        </h3>

        <h2>
            <?= $pelanggan['jumlah']; ?>
        </h2>

    </div>


    <div class="dashboard-card">

        <div class="dashboard-icon">
            🧴
        </div>

        <h3>
            Total Produk
        </h3>

        <h2>
            <?= $produk['jumlah']; ?>
        </h2>

    </div>

</div>


<div class="dashboard-info">

    <div class="dashboard-info-title">

        <div class="info-icon">
            💜
        </div>

        <div>

            <h2>
                Selamat Datang di FirSkincare
            </h2>

            <span>
                Sistem Kasir Beauty & Skincare Store
            </span>

        </div>

    </div>


    <div class="info-text">

        Gunakan menu di sebelah kiri untuk mengelola
        pelanggan, melakukan transaksi penjualan,
        dan melihat riwayat transaksi FirSkincare.

    </div>


    <div class="menu-hint">

        <div class="hint">
            👥<br>
            Kelola Pelanggan
        </div>

        <div class="hint">
            🛒<br>
            Buat Transaksi
        </div>

        <div class="hint">
            📋<br>
            Lihat Riwayat
        </div>

    </div>

</div>


</div>

</body>
</html>