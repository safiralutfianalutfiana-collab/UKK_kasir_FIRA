<?php

include "../koneksi.php";

$awal = $_GET['awal'];
$akhir = $_GET['akhir'];

$data = mysqli_query(
    $koneksi,
    "SELECT
        penjualan.*,
        pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID =
        pelanggan.PelangganID
     WHERE TanggalPenjualan
     BETWEEN '$awal' AND '$akhir'
     ORDER BY PenjualanID ASC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Laporan FirSkincare</title>

<style>

* {
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 35px;
    background: #f7f3f9;
    color: #51445a;
}

.laporan {
    max-width: 1000px;
    margin: auto;
    background: white;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(80, 50, 100, 0.10);
}

.header {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 2px solid #eadff0;
}

.logo {
    width: 58px;
    height: 58px;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 17px;
    background: linear-gradient(135deg, #80609a, #b58ac8);
    color: white;
    font-size: 28px;
    font-weight: bold;
}

.header h1 {
    margin: 0;
    color: #684477;
    font-size: 25px;
}

.header p {
    margin: 7px 0 0;
    color: #9a87a2;
    font-size: 13px;
}

.periode {
    margin-top: 22px;
    padding: 13px 17px;
    background: #f5edf8;
    border-radius: 12px;
    color: #704b82;
    font-size: 13px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

th {
    background: #eee3f3;
    color: #654174;
    padding: 13px;
    font-size: 13px;
    border-bottom: 2px solid #dfd0e6;
}

td {
    padding: 13px;
    border-bottom: 1px solid #eee8f1;
    font-size: 13px;
    color: #64566b;
}

tr:hover td {
    background: #fcfaff;
}

th:first-child,
td:first-child {
    text-align: center;
    width: 60px;
}

td:last-child,
th:last-child {
    text-align: right;
}

.harga {
    color: #71458a;
    font-weight: bold;
}

.total-row th {
    background: #e9d9ef;
    color: #5f3b70;
    font-size: 14px;
    padding: 16px 13px;
}

.total-row th:last-child {
    font-size: 16px;
}

.tombol {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 25px;
}

button {
    border: none;
    padding: 12px 22px;
    border-radius: 12px;
    background: linear-gradient(135deg, #80609a, #a879bd);
    color: white;
    font-weight: bold;
    cursor: pointer;
    font-size: 13px;
    box-shadow: 0 6px 15px rgba(100, 60, 120, 0.15);
}

button:hover {
    transform: translateY(-2px);
}

.footer {
    text-align: center;
    margin-top: 25px;
    color: #a594ac;
    font-size: 11px;
}

@media print {

    body {
        background: white;
        padding: 0;
    }

    .laporan {
        max-width: none;
        padding: 0;
        box-shadow: none;
        border-radius: 0;
    }

    .tombol {
        display: none;
    }

    .footer {
        margin-top: 20px;
    }

    table {
        margin-top: 20px;
    }

    tr:hover td {
        background: white;
    }

}

@media (max-width: 600px) {

    body {
        padding: 15px;
    }

    .laporan {
        padding: 20px;
    }

    .header h1 {
        font-size: 21px;
    }

    table {
        min-width: 600px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

}

</style>

</head>

<body>

<div class="laporan">

    <div class="header">

        <div class="logo">
            F
        </div>

        <h1>
            LAPORAN PENJUALAN FIRSKINCARE
        </h1>

        <p>
            Laporan transaksi penjualan skincare
        </p>

    </div>


    <div class="periode">

        📅 <strong>Periode:</strong>
        <?= $awal; ?>
        sampai
        <?= $akhir; ?>

    </div>


    <div class="table-wrapper">

        <table>

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Pelanggan</th>

                <th>Total</th>

            </tr>


            <?php

            $no = 1;
            $total = 0;

            while ($row = mysqli_fetch_assoc($data)) {

                $total += $row['TotalHarga'];

            ?>

            <tr>

                <td>
                    <?= $no++; ?>
                </td>

                <td>
                    <?= $row['TanggalPenjualan']; ?>
                </td>

                <td>
                    <?= $row['NamaPelanggan']; ?>
                </td>

                <td class="harga">
                    Rp <?= number_format(
                        $row['TotalHarga'],
                        0,
                        ',',
                        '.'
                    ); ?>
                </td>

            </tr>

            <?php } ?>


            <tr class="total-row">

                <th colspan="3">
                    TOTAL PENJUALAN
                </th>

                <th>
                    Rp <?= number_format(
                        $total,
                        0,
                        ',',
                        '.'
                    ); ?>
                </th>

            </tr>

        </table>

    </div>


    <div class="tombol">

        <button onclick="window.print()">
            🖨️ Cetak Laporan
        </button>

    </div>


    <div class="footer">

        FirSkincare • Sistem Kasir Skincare

    </div>

</div>

</body>

</html>