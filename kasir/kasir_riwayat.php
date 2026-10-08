<?php

include "../koneksi.php";


if (isset($_POST['simpan'])) {

    $pelanggan = $_POST['pelanggan'];
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];

    $produkGabungan = [];


    for ($i = 0; $i < count($produk); $i++) {

        $produkID = $produk[$i];
        $jumlahProduk = (int)$jumlah[$i];

        if ($produkID == "" || $jumlahProduk < 1) {
            continue;
        }


        if (isset($produkGabungan[$produkID])) {

            $produkGabungan[$produkID] += $jumlahProduk;

        } else {

            $produkGabungan[$produkID] = $jumlahProduk;

        }

    }


    if (count($produkGabungan) == 0) {

        echo "<script>
                alert('Silakan pilih minimal satu produk!');
                window.location='kasir_transaksi.php';
              </script>";

        exit;
    }


    $totalHarga = 0;


    foreach ($produkGabungan as $produkID => $jumlahProduk) {

        $cek = mysqli_fetch_assoc(
            mysqli_query(
                $koneksi,
                "SELECT * FROM produk
                 WHERE ProdukID='$produkID'"
            )
        );


        if (!$cek) {

            echo "<script>
                    alert('Produk tidak ditemukan!');
                    window.location='kasir_transaksi.php';
                  </script>";

            exit;
        }


        if ($jumlahProduk > $cek['Stok']) {

            echo "<script>
                    alert('Stok produk \"{$cek['NamaProduk']}\" tidak mencukupi! Stok tersedia: {$cek['Stok']}, jumlah dibeli: $jumlahProduk');
                    window.location='kasir_transaksi.php';
                  </script>";

            exit;
        }


        $subtotal = $cek['Harga'] * $jumlahProduk;

        $totalHarga += $subtotal;

    }


    /*
     * Jika memilih Pelanggan Umum,
     * PelangganID harus NULL karena tidak ada ID 0
     * di tabel pelanggan.
     */

    if ($pelanggan == "0" || empty($pelanggan)) {

        $pelangganSQL = "NULL";

    } else {

        $pelangganSQL = "'" . mysqli_real_escape_string(
            $koneksi,
            $pelanggan
        ) . "'";

    }


    mysqli_query(
        $koneksi,
        "INSERT INTO penjualan
        (
            TanggalPenjualan,
            TotalHarga,
            PelangganID
        )
        VALUES
        (
            CURDATE(),
            '$totalHarga',
            $pelangganSQL
        )"
    );


    $penjualanID = mysqli_insert_id($koneksi);


    foreach ($produkGabungan as $produkID => $jumlahProduk) {

        $cek = mysqli_fetch_assoc(
            mysqli_query(
                $koneksi,
                "SELECT * FROM produk
                 WHERE ProdukID='$produkID'"
            )
        );


        $harga = $cek['Harga'];

        $subtotal = $harga * $jumlahProduk;


        mysqli_query(
            $koneksi,
            "INSERT INTO detailpenjualan
            (
                PenjualanID,
                ProdukID,
                JumlahProduk,
                Subtotal
            )
            VALUES
            (
                '$penjualanID',
                '$produkID',
                '$jumlahProduk',
                '$subtotal'
            )"
        );


        mysqli_query(
            $koneksi,
            "UPDATE produk
             SET Stok = Stok - $jumlahProduk
             WHERE ProdukID='$produkID'"
        );

    }


    echo "<script>
            alert('Transaksi berhasil disimpan!');
            window.location='kasir_riwayat.php';
          </script>";

    exit;

}


include "kasir_header.php";


$data = mysqli_query(
    $koneksi,
    "SELECT
        penjualan.*,
        pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID = pelanggan.PelangganID
     ORDER BY penjualan.PenjualanID DESC"
);

?>


<style>

.riwayat-banner {
    background: linear-gradient(135deg, #8f68ad, #b58ac8);
    padding: 28px 30px;
    border-radius: 23px;
    color: white;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(90,55,110,.12);
}

.riwayat-banner::after {
    content: "🛍️";
    position: absolute;
    right: 35px;
    top: 12px;
    font-size: 70px;
    opacity: .15;
}

.riwayat-banner h1 {
    margin: 0 0 7px;
    font-size: 27px;
}

.riwayat-banner p {
    margin: 0;
    color: rgba(255,255,255,.85);
    font-size: 13px;
}


.riwayat-card {
    background: white;
    border: 1px solid #eee3f5;
    border-radius: 21px;
    padding: 25px;
    box-shadow: 0 9px 25px rgba(94,56,120,.07);
}


.riwayat-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
}


.riwayat-icon {
    width: 45px;
    height: 45px;
    border-radius: 14px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}


.riwayat-title h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}


.riwayat-title span {
    display: block;
    margin-top: 4px;
    color: #a18ca8;
    font-size: 12px;
}


.table-wrapper {
    width: 100%;
    overflow-x: auto;
}


.riwayat-card table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}


.riwayat-card th {
    padding: 15px;
    text-align: left;
    background: linear-gradient(
        90deg,
        #eee0fa,
        #f5eafb
    );
    color: #604078;
    font-size: 13px;
}


.riwayat-card td {
    padding: 15px;
    border-bottom: 1px solid #eee8f2;
    color: #57475f;
    font-size: 13px;
}


.riwayat-card tbody tr:hover {
    background: #fbf7fd;
}


.riwayat-card th:first-child,
.riwayat-card td:first-child {
    text-align: center;
    width: 60px;
}


.nama-pelanggan {
    color: #654376;
    font-weight: bold;
}


.total {
    color: #744399;
    font-weight: bold;
}


.btn-cetak {
    display: inline-block;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 9px;
    background: #f0e3f7;
    color: #70498a;
    font-size: 12px;
    font-weight: bold;
}


.btn-cetak:hover {
    background: #e4d1ee;
}


.empty-data {
    text-align: center;
    padding: 35px !important;
    color: #a18ca8 !important;
}


.btn-transaksi {
    margin-left: auto;
    text-decoration: none;
    padding: 11px 17px;
    border-radius: 11px;
    background: linear-gradient(
        135deg,
        #9b69c5,
        #744399
    );
    color: white;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 5px 14px rgba(117,67,155,.18);
}


.btn-transaksi:hover {
    transform: translateY(-2px);
}


@media (max-width: 600px) {

    .riwayat-banner {
        padding: 22px;
    }

    .riwayat-banner h1 {
        font-size: 23px;
    }

    .riwayat-card {
        padding: 18px;
    }

    .riwayat-title {
        flex-wrap: wrap;
    }

    .btn-transaksi {
        width: 100%;
        text-align: center;
        margin-left: 0;
    }

}

</style>


<div class="riwayat-banner">

    <h1>
        🧾 Riwayat Transaksi
    </h1>

    <p>
        Daftar seluruh transaksi penjualan FirSkincare.
    </p>

</div>


<div class="riwayat-card">


    <div class="riwayat-title">

        <div class="riwayat-icon">
            🛒
        </div>

        <div>

            <h2>
                Daftar Transaksi
            </h2>

            <span>
                Riwayat transaksi penjualan skincare
            </span>

        </div>


        <a
            href="kasir_transaksi.php"
            class="btn-transaksi"
        >
            ➕ Transaksi Baru
        </a>

    </div>


    <div class="table-wrapper">

        <table>

            <tr>

                <th>
                    No
                </th>

                <th>
                    Tanggal
                </th>

                <th>
                    Pelanggan
                </th>

                <th>
                    Total Harga
                </th>

                <th>
                    Aksi
                </th>

            </tr>


            <?php

            $no = 1;

            if (mysqli_num_rows($data) > 0) {

                while ($row = mysqli_fetch_assoc($data)) {

            ?>

            <tr>

                <td>
                    <?= $no++; ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $row['TanggalPenjualan']
                    ); ?>
                </td>


                <td class="nama-pelanggan">

                    <?php

                    if (
                        empty($row['NamaPelanggan']) ||
                        $row['PelangganID'] === null
                    ) {

                        echo "👤 Pelanggan Umum";

                    } else {

                        echo htmlspecialchars(
                            $row['NamaPelanggan']
                        );

                    }

                    ?>

                </td>


                <td class="total">

                    Rp <?= number_format(
                        $row['TotalHarga'],
                        0,
                        ',',
                        '.'
                    ); ?>

                </td>


                <td>

                    <a
                        href="../admin/admin_cetak_struk.php?id=<?= $row['PenjualanID']; ?>"
                        class="btn-cetak"
                        target="_blank"
                    >

                        🧾 Cetak Struk

                    </a>

                </td>

            </tr>

            <?php

                }

            } else {

            ?>

            <tr>

                <td
                    colspan="5"
                    class="empty-data"
                >

                    📭 Belum ada transaksi.

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>


</div>

</body>
</html>