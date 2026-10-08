<?php

include "../koneksi.php";
include "admin_header.php";

$tanggal_awal = isset($_GET['awal'])
    ? $_GET['awal']
    : date('Y-m-01');

$tanggal_akhir = isset($_GET['akhir'])
    ? $_GET['akhir']
    : date('Y-m-d');

$data = mysqli_query(
    $koneksi,
    "SELECT
        penjualan.*,
        pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID = pelanggan.PelangganID
     WHERE TanggalPenjualan
     BETWEEN '$tanggal_awal'
     AND '$tanggal_akhir'
     ORDER BY PenjualanID DESC"
);

?>

<style>

.laporan-header {
    background: linear-gradient(135deg, #8f68a8, #b58bc8);
    padding: 28px 30px;
    border-radius: 22px;
    color: white;
    margin-bottom: 22px;
    box-shadow: 0 10px 25px rgba(100, 60, 120, 0.12);
    position: relative;
    overflow: hidden;
}

.laporan-header::after {
    content: "✦";
    position: absolute;
    right: 28px;
    top: 10px;
    font-size: 75px;
    color: rgba(255,255,255,0.12);
}

.laporan-header h1 {
    margin: 0 0 7px;
    font-size: 28px;
}

.laporan-header p {
    margin: 0;
    color: rgba(255,255,255,0.85);
    font-size: 14px;
}

.filter-box {
    background: white;
    padding: 25px;
    border-radius: 20px;
    border: 1px solid #eee3f3;
    box-shadow: 0 8px 25px rgba(90, 55, 110, 0.07);
    margin-bottom: 22px;
}

.filter-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.filter-icon {
    width: 42px;
    height: 42px;
    border-radius: 13px;
    background: #f0e4f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.filter-title h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}

.filter-title span {
    color: #a085ad;
    font-size: 12px;
}

.filter-form {
    display: grid;
    grid-template-columns: 1fr 1fr auto auto;
    gap: 15px;
    align-items: end;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    color: #684878;
    font-size: 13px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #dfd1e5;
    border-radius: 12px;
    outline: none;
    background: #fcfaff;
    color: #5d4569;
    transition: 0.2s;
}

.form-group input:focus {
    border-color: #9b72b4;
    box-shadow: 0 0 0 3px rgba(155,114,180,0.10);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border: none;
    cursor: pointer;
    padding: 12px 18px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: bold;
    transition: 0.25s;
    white-space: nowrap;
}

.btn-purple {
    background: linear-gradient(135deg, #80609a, #9c74b5);
    color: white;
    box-shadow: 0 6px 15px rgba(100,65,120,0.15);
}

.btn-purple:hover {
    transform: translateY(-2px);
    box-shadow: 0 9px 18px rgba(100,65,120,0.22);
}

.btn-success {
    background: #eee3f3;
    color: #714a85;
}

.btn-success:hover {
    background: #e4d5eb;
    transform: translateY(-2px);
}

.report-box {
    background: white;
    border: 1px solid #eee3f3;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(90,55,110,0.07);
    overflow: hidden;
}

.report-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.report-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.report-title-icon {
    width: 42px;
    height: 42px;
    background: #f0e4f5;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.report-title h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}

.report-title p {
    margin: 4px 0 0;
    color: #a28eaa;
    font-size: 12px;
}

.table-wrapper {
    overflow-x: auto;
}

.report-box table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

.report-box th {
    background: #f3eaf6;
    color: #674575;
    padding: 14px 13px;
    font-size: 12px;
    text-align: left;
    border-bottom: 1px solid #e8ddec;
}

.report-box td {
    padding: 14px 13px;
    color: #705d78;
    font-size: 13px;
    border-bottom: 1px solid #f0e8f3;
}

.report-box tbody tr:hover {
    background: #fbf8fc;
}

.report-box td:first-child,
.report-box th:first-child {
    text-align: center;
    width: 60px;
}

.report-box td:last-child,
.report-box th:last-child {
    text-align: right;
}

.price {
    color: #76518b;
    font-weight: bold;
}

.total-row th {
    background: #eee1f3 !important;
    color: #603c70 !important;
    font-size: 14px !important;
    padding: 16px 13px !important;
}

.total-row th:last-child {
    color: #744895 !important;
    font-size: 16px !important;
}

.empty-data {
    text-align: center;
    padding: 35px !important;
    color: #a894af !important;
}

@media (max-width: 950px) {
    .filter-form {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 600px) {
    .laporan-header {
        padding: 22px;
    }

    .laporan-header h1 {
        font-size: 23px;
    }

    .filter-box,
    .report-box {
        padding: 18px;
    }

    .filter-form {
        grid-template-columns: 1fr;
    }

    .btn {
        width: 100%;
    }
}

</style>

<div class="laporan-header">

    <h1>📊 Laporan Penjualan</h1>

    <p>
        Lihat dan cetak laporan transaksi berdasarkan periode tanggal.
    </p>

</div>

<div class="filter-box">

    <div class="filter-title">

        <div class="filter-icon">
            📅
        </div>

        <div>
            <h2>Filter Laporan</h2>
            <span>Pilih periode transaksi yang ingin ditampilkan</span>
        </div>

    </div>

    <form method="GET">

        <div class="filter-form">

            <div class="form-group">

                <label>Tanggal Awal</label>

                <input type="date"
                       name="awal"
                       value="<?= $tanggal_awal; ?>">

            </div>

            <div class="form-group">

                <label>Tanggal Akhir</label>

                <input type="date"
                       name="akhir"
                       value="<?= $tanggal_akhir; ?>">

            </div>

            <button class="btn btn-purple">

                🔍 Tampilkan

            </button>

            <a class="btn btn-success"
               href="admin_cetak_laporan.php?awal=<?= $tanggal_awal; ?>&akhir=<?= $tanggal_akhir; ?>"
               target="_blank">

                🖨️ Cetak Laporan

            </a>

        </div>

    </form>

</div>

<div class="report-box">

    <div class="report-top">

        <div class="report-title">

            <div class="report-title-icon">
                📋
            </div>

            <div>

                <h2>Detail Penjualan</h2>

                <p>
                    Periode <?= $tanggal_awal; ?> sampai <?= $tanggal_akhir; ?>
                </p>

            </div>

        </div>

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

            if (mysqli_num_rows($data) > 0) {

                while ($row = mysqli_fetch_assoc($data)) {

                    $total += $row['TotalHarga'];

            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td>
                    <?= $row['TanggalPenjualan']; ?>
                </td>

                <td>
                    👤 <?= $row['NamaPelanggan']; ?>
                </td>

                <td class="price">
                    Rp <?= number_format(
                        $row['TotalHarga'],0,',','.'
                    ); ?>
                </td>

            </tr>

            <?php

                }

            } else {

            ?>

            <tr>

                <td colspan="4" class="empty-data">

                    📭 Tidak ada transaksi pada periode ini.

                </td>

            </tr>

            <?php } ?>

            <tr class="total-row">

                <th colspan="3">
                    💜 Total Penjualan
                </th>

                <th>
                    Rp <?= number_format($total,0,',','.'); ?>
                </th>

            </tr>

        </table>

    </div>

</div>

</div>

</body>
</html>