<?php

include "../koneksi.php";

$id = $_GET['id'];

$penjualan = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT
            penjualan.*,
            pelanggan.NamaPelanggan
         FROM penjualan
         LEFT JOIN pelanggan
         ON penjualan.PelangganID =
            pelanggan.PelangganID
         WHERE PenjualanID='$id'"
    )
);

$detail = mysqli_query(
    $koneksi,
    "SELECT
        detailpenjualan.*,
        produk.NamaProduk
     FROM detailpenjualan
     LEFT JOIN produk
     ON detailpenjualan.ProdukID =
        produk.ProdukID
     WHERE PenjualanID='$id'"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Struk FirSkincare</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 30px 15px;
    background: #f5f0f7;
    font-family: Arial, Helvetica, sans-serif;
    color: #55465d;
}

.struk {
    width: 380px;
    max-width: 100%;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(80, 50, 100, 0.12);
}

.logo {
    width: 55px;
    height: 55px;
    margin: 0 auto 10px;
    border-radius: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #80609a, #b58ac8);
    color: white;
    font-size: 27px;
    font-weight: bold;
}

.header {
    text-align: center;
}

.header h2 {
    margin: 0;
    color: #684477;
    font-size: 23px;
}

.header p {
    margin: 6px 0;
    color: #9a88a2;
    font-size: 12px;
}

.garis {
    border: none;
    border-top: 1px dashed #cdbdd4;
    margin: 18px 0;
}

.info {
    background: #f8f3fa;
    padding: 13px;
    border-radius: 12px;
    font-size: 12px;
    line-height: 1.8;
}

.info strong {
    color: #684477;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 18px;
}

td {
    padding: 9px 0;
    border-bottom: 1px dashed #ddd2e1;
    vertical-align: top;
    font-size: 12px;
}

td:last-child {
    text-align: right;
    white-space: nowrap;
    font-weight: bold;
    color: #70498a;
}

.nama-produk {
    color: #604c68;
    font-weight: bold;
    margin-bottom: 4px;
}

.detail-produk {
    color: #9a899f;
    font-size: 11px;
}

.total td {
    border-bottom: none;
    padding-top: 16px;
    font-size: 14px;
    font-weight: bold;
    color: #5d3d6d;
}

.total td:last-child {
    color: #70498e;
    font-size: 16px;
}

.thanks {
    text-align: center;
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px dashed #cdbdd4;
}

.thanks p {
    margin: 5px 0;
    color: #765582;
    font-weight: bold;
    font-size: 13px;
}

.thanks small {
    color: #a492aa;
    font-size: 10px;
}

.tombol {
    text-align: center;
    margin-top: 20px;
}

button {
    border: none;
    padding: 11px 20px;
    border-radius: 11px;
    background: linear-gradient(135deg, #80609a, #a879bd);
    color: white;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 5px 14px rgba(100, 60, 120, 0.15);
}

button:hover {
    transform: translateY(-2px);
}

@media print {

    body {
        background: white;
        padding: 0;
    }

    .struk {
        width: 380px;
        padding: 10px;
        box-shadow: none;
        border-radius: 0;
    }

    .tombol {
        display: none;
    }

}

</style>

</head>

<body>

<div class="struk">

    <div class="header">

        <div class="logo">
            F
        </div>

        <h2>FirSkincare</h2>

        <p>
            Beauty & Skincare Store
        </p>

    </div>


    <hr class="garis">


    <div class="info">

        <strong>No Transaksi :</strong>
        <?= $penjualan['PenjualanID']; ?>

        <br>

        <strong>Tanggal :</strong>
        <?= $penjualan['TanggalPenjualan']; ?>

        <br>

        <strong>Pelanggan :</strong>
        <?= $penjualan['NamaPelanggan']; ?>

    </div>


    <table>

        <?php while ($row = mysqli_fetch_assoc($detail)) { ?>

        <tr>

            <td>

                <div class="nama-produk">

                    <?= $row['NamaProduk']; ?>

                </div>

                <div class="detail-produk">

                    <?= $row['JumlahProduk']; ?> x

                    Rp <?= number_format(
                        $row['Subtotal'] / $row['JumlahProduk'],
                        0,
                        ',',
                        '.'
                    ); ?>

                </div>

            </td>

            <td>

                Rp <?= number_format(
                    $row['Subtotal'],
                    0,
                    ',',
                    '.'
                ); ?>

            </td>

        </tr>

        <?php } ?>


        <tr class="total">

            <td>
                TOTAL
            </td>

            <td>

                Rp <?= number_format(
                    $penjualan['TotalHarga'],
                    0,
                    ',',
                    '.'
                ); ?>

            </td>

        </tr>

    </table>


    <div class="thanks">

        <p>
            Terima kasih telah berbelanja 💜
        </p>

        <small>
            Semoga harimu semakin cantik ✨
        </small>

    </div>


    <div class="tombol">

        <button onclick="window.print()">
            🖨️ Cetak Struk
        </button>

    </div>

</div>

</body>

</html>