<?php

include "../koneksi.php";
include "admin_header.php";

$total = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT
        SUM(TotalHarga) AS total
        FROM penjualan"
    )
);

$transaksi = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS jumlah
        FROM penjualan"
    )
);

$produk = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS jumlah
        FROM produk"
    )
);

?>

<style>

.stat-header {
    background: linear-gradient(135deg, #80609a, #b38bc6);
    padding: 30px;
    border-radius: 23px;
    color: white;
    margin-bottom: 25px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(90, 55, 110, 0.13);
}

.stat-header::after {
    content: "✦";
    position: absolute;
    right: 30px;
    top: 5px;
    font-size: 90px;
    color: rgba(255,255,255,0.12);
}

.stat-header h1 {
    margin: 0 0 8px;
    font-size: 28px;
}

.stat-header p {
    margin: 0;
    color: rgba(255,255,255,0.85);
    font-size: 14px;
}

.stat-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.stat-card {
    background: white;
    border-radius: 21px;
    padding: 25px;
    border: 1px solid #eee3f3;
    box-shadow: 0 8px 25px rgba(90,55,110,0.07);
    position: relative;
    overflow: hidden;
    transition: 0.25s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(90,55,110,0.12);
}

.stat-card::after {
    content: "";
    position: absolute;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #f5edf8;
    right: -30px;
    bottom: -30px;
}

.stat-icon {
    width: 55px;
    height: 55px;
    border-radius: 17px;
    background: #f1e6f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    margin-bottom: 18px;
    position: relative;
    z-index: 2;
}

.stat-card h3 {
    margin: 0 0 9px;
    color: #765580;
    font-size: 14px;
    font-weight: 600;
}

.stat-card h2 {
    margin: 0;
    color: #573666;
    font-size: 25px;
    font-weight: bold;
    position: relative;
    z-index: 2;
}

.stat-card small {
    display: block;
    margin-top: 8px;
    color: #a18eaa;
    font-size: 11px;
    position: relative;
    z-index: 2;
}

.stat-info {
    background: white;
    border: 1px solid #eee3f3;
    border-radius: 21px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(90,55,110,0.06);
}

.stat-info-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
}

.stat-info-icon {
    width: 43px;
    height: 43px;
    border-radius: 13px;
    background: #f1e6f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-info h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}

.stat-info p {
    margin: 4px 0 0;
    color: #a18daa;
    font-size: 12px;
}

.info-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.info-item {
    background: #faf7fc;
    border: 1px solid #eee5f2;
    border-radius: 15px;
    padding: 17px;
}

.info-item span {
    display: block;
    color: #9a83a5;
    font-size: 11px;
    margin-bottom: 6px;
}

.info-item strong {
    color: #684477;
    font-size: 14px;
}

@media (max-width: 900px) {

    .stat-cards {
        grid-template-columns: 1fr;
    }

    .info-list {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .stat-header {
        padding: 23px;
    }

    .stat-header h1 {
        font-size: 23px;
    }

    .stat-card,
    .stat-info {
        padding: 20px;
    }

}

</style>

<div class="stat-header">

    <h1>📈 Statistik Penjualan</h1>

    <p>
        Ringkasan data penjualan dan performa FirSkincare.
    </p>

</div>


<div class="stat-cards">

    <div class="stat-card">

        <div class="stat-icon">
            💰
        </div>

        <h3>Total Pendapatan</h3>

        <h2>
            Rp <?= number_format(
                $total['total'] ?? 0,
                0,
                ',',
                '.'
            ); ?>
        </h2>

        <small>
            Pendapatan dari seluruh transaksi
        </small>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            🛒
        </div>

        <h3>Total Transaksi</h3>

        <h2>
            <?= $transaksi['jumlah']; ?>
        </h2>

        <small>
            Jumlah transaksi penjualan
        </small>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            🧴
        </div>

        <h3>Total Produk</h3>

        <h2>
            <?= $produk['jumlah']; ?>
        </h2>

        <small>
            Produk yang tersedia di sistem
        </small>

    </div>

</div>


<div class="stat-info">

    <div class="stat-info-title">

        <div class="stat-info-icon">
            ✨
        </div>

        <div>

            <h2>Ringkasan FirSkincare</h2>

            <p>
                Informasi singkat mengenai data toko
            </p>

        </div>

    </div>


    <div class="info-list">

        <div class="info-item">

            <span>💰 Pendapatan</span>

            <strong>
                Rp <?= number_format(
                    $total['total'] ?? 0,
                    0,
                    ',',
                    '.'
                ); ?>
            </strong>

        </div>


        <div class="info-item">

            <span>🛒 Transaksi</span>

            <strong>
                <?= $transaksi['jumlah']; ?> Transaksi
            </strong>

        </div>


        <div class="info-item">

            <span>🧴 Produk</span>

            <strong>
                <?= $produk['jumlah']; ?> Produk
            </strong>

        </div>

    </div>

</div>


</div>

</body>
</html>