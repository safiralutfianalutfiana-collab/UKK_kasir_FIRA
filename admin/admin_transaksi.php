<?php
include "../koneksi.php";
include "admin_header.php";

if (isset($_POST['simpan'])) {

    $tanggal = $_POST['tanggal'];
    $pelanggan = $_POST['pelanggan'];
    $produk_list = $_POST['produk'];
    $jumlah_list = $_POST['jumlah'];

    if (empty($produk_list) || empty($jumlah_list)) {
        echo "<script>
                alert('Produk belum dipilih!');
                window.location='admin_transaksi.php';
              </script>";
        exit;
    }

    $total_harga = 0;
    $detail_produk = [];

    for ($i = 0; $i < count($produk_list); $i++) {

        $produk_id = $produk_list[$i];
        $jumlah = (int)$jumlah_list[$i];

        if (empty($produk_id) || $jumlah < 1) {
            continue;
        }

        $cek = mysqli_query(
            $koneksi,
            "SELECT * FROM produk WHERE ProdukID='$produk_id'"
        );

        $data_produk = mysqli_fetch_assoc($cek);

        if (!$data_produk) {
            echo "<script>
                    alert('Produk tidak ditemukan!');
                    window.location='admin_transaksi.php';
                  </script>";
            exit;
        }

        if ($jumlah > $data_produk['Stok']) {
            echo "<script>
                    alert('Stok {$data_produk['NamaProduk']} tidak mencukupi!');
                    window.location='admin_transaksi.php';
                  </script>";
            exit;
        }

        $harga = $data_produk['Harga'];
        $subtotal = $harga * $jumlah;

        $total_harga += $subtotal;

        $detail_produk[] = [
            'produk' => $produk_id,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }

    if (count($detail_produk) == 0) {
        echo "<script>
                alert('Minimal pilih satu produk!');
                window.location='admin_transaksi.php';
              </script>";
        exit;
    }

    mysqli_query(
        $koneksi,
        "INSERT INTO penjualan
        (TanggalPenjualan, TotalHarga, PelangganID)
        VALUES
        ('$tanggal', '$total_harga', '$pelanggan')"
    );

    $penjualan_id = mysqli_insert_id($koneksi);

    foreach ($detail_produk as $detail) {

        mysqli_query(
            $koneksi,
            "INSERT INTO detailpenjualan
            (PenjualanID, ProdukID, JumlahProduk, Subtotal)
            VALUES
            (
                '$penjualan_id',
                '{$detail['produk']}',
                '{$detail['jumlah']}',
                '{$detail['subtotal']}'
            )"
        );

        mysqli_query(
            $koneksi,
            "UPDATE produk
             SET Stok = Stok - {$detail['jumlah']}
             WHERE ProdukID = '{$detail['produk']}'"
        );
    }

    echo "<script>
            alert('Transaksi berhasil ditambahkan!');
            window.location='admin_transaksi.php';
          </script>";
    exit;
}

$produk = mysqli_query(
    $koneksi,
    "SELECT * FROM produk ORDER BY NamaProduk ASC"
);

$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY NamaPelanggan ASC"
);

$data = mysqli_query(
    $koneksi,
    "SELECT penjualan.*, pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID = pelanggan.PelangganID
     ORDER BY penjualan.PenjualanID DESC"
);
?>

<style>

.transaksi-container {
    max-width: 1200px;
    margin: auto;
}

.judul-halaman {
    margin-bottom: 20px;
}

.judul-halaman h2 {
    color: #5d3d70;
    font-size: 25px;
    margin-bottom: 5px;
}

.judul-halaman p {
    color: #927aa0;
    font-size: 14px;
}

.card {
    background: white;
    border: 1px solid #eee2f3;
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(80,45,100,.07);
}

.card-title {
    color: #654477;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    color: #654477;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 7px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e2d5e8;
    border-radius: 12px;
    outline: none;
    color: #5d4569;
    background: #fcf9fd;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #9670b0;
    box-shadow: 0 0 0 3px rgba(150,112,176,.10);
}

.produk-section {
    margin-top: 20px;
}

.produk-row {
    display: grid;
    grid-template-columns: 1fr 150px 45px;
    gap: 10px;
    margin-bottom: 10px;
    align-items: center;
}

.produk-row select,
.produk-row input {
    padding: 12px;
    border: 1px solid #e2d5e8;
    border-radius: 12px;
    outline: none;
    background: #fcf9fd;
    color: #5d4569;
}

.produk-row select:focus,
.produk-row input:focus {
    border-color: #9670b0;
}

.btn-tambah-produk {
    border: none;
    padding: 11px 17px;
    border-radius: 12px;
    background: #f0e6f5;
    color: #70498a;
    font-weight: bold;
    cursor: pointer;
    margin-top: 5px;
}

.btn-tambah-produk:hover {
    background: #e5d6ec;
}

.btn-hapus-row {
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 11px;
    background: #f8e3e7;
    color: #b45569;
    cursor: pointer;
    font-size: 16px;
}

.btn-hapus-row:hover {
    background: #f2d2d9;
}

.total-box {
    margin-top: 20px;
    padding: 17px 20px;
    background: #f7f0fa;
    border-radius: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-box span {
    color: #735583;
    font-weight: bold;
}

.total-box strong {
    color: #6a3e7d;
    font-size: 21px;
}

.btn-simpan {
    margin-top: 18px;
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 13px;
    background: linear-gradient(135deg,#765092,#9a73b6);
    color: white;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 7px 18px rgba(118,80,146,.18);
}

.btn-simpan:hover {
    transform: translateY(-1px);
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    background: #f4ebf8;
    color: #684679;
    padding: 14px 12px;
    text-align: left;
    font-size: 13px;
    white-space: nowrap;
}

table td {
    padding: 14px 12px;
    border-bottom: 1px solid #eee5f1;
    color: #685471;
    font-size: 13px;
    vertical-align: top;
}

table tr:hover td {
    background: #fcf9fd;
}

.produk-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.produk-item {
    display: inline-block;
    background: #f5edf8;
    color: #70498a;
    padding: 7px 10px;
    border-radius: 9px;
    width: fit-content;
    font-size: 12px;
    font-weight: bold;
}

.total-table {
    color: #6a3e7d;
    font-weight: bold;
    white-space: nowrap;
}

.action {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    min-width: 210px;
}

.action a {
    display: inline-block;
    text-decoration: none;
    padding: 8px 10px;
    border-radius: 9px;
    font-size: 11px;
    font-weight: bold;
    transition: .2s;
}

.action a:hover {
    transform: translateY(-2px);
}

.btn-edit {
    color: white;
    background: linear-gradient(135deg,#8b6bb1,#a98aca);
    box-shadow: 0 5px 12px rgba(128,80,164,.12);
}

.btn-struk {
    color: white;
    background: linear-gradient(135deg,#765092,#9470ad);
    box-shadow: 0 5px 12px rgba(118,80,146,.12);
}

.btn-hapus {
    color: white;
    background: linear-gradient(135deg,#c56b7d,#df8c9d);
    box-shadow: 0 5px 12px rgba(197,107,125,.12);
}

.empty {
    text-align: center;
    padding: 30px;
    color: #9a879f;
}

@media(max-width:700px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

    .produk-row {
        grid-template-columns: 1fr;
    }

    .btn-hapus-row {
        width: 100%;
    }

    .total-box {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }
}

</style>

<div class="transaksi-container">

    <div class="judul-halaman">
        <h2>🛒 Transaksi Penjualan</h2>
        <p>Kelola transaksi penjualan produk FirSkincare.</p>
    </div>

    <div class="card">

        <div class="card-title">
            ✨ Tambah Transaksi
        </div>

        <form method="POST">

            <div class="form-grid">

                <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <input
                        type="date"
                        name="tanggal"
                        value="<?= date('Y-m-d'); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Pelanggan</label>

                    <select name="pelanggan" required>

                        <option value="">
                            -- Pilih Pelanggan --
                        </option>

                        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

                            <option value="<?= $p['PelangganID']; ?>">
                                <?= htmlspecialchars($p['NamaPelanggan']); ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <div class="produk-section">

                <div class="card-title">
                    🧴 Produk yang Dibeli
                </div>

                <div id="produk-container">

                    <div class="produk-row">

                        <select
                            name="produk[]"
                            class="produk-select"
                            onchange="hitungTotal()"
                            required
                        >

                            <option value="">
                                -- Pilih Produk --
                            </option>

                            <?php

                            mysqli_data_seek($produk, 0);

                            while ($p = mysqli_fetch_assoc($produk)) {

                            ?>

                                <option
                                    value="<?= $p['ProdukID']; ?>"
                                    data-harga="<?= $p['Harga']; ?>"
                                >
                                    <?= htmlspecialchars($p['NamaProduk']); ?>
                                    - Rp <?= number_format($p['Harga'],0,',','.'); ?>
                                    (Stok: <?= $p['Stok']; ?>)
                                </option>

                            <?php } ?>

                        </select>

                        <input
                            type="number"
                            name="jumlah[]"
                            class="jumlah-input"
                            value="1"
                            min="1"
                            oninput="hitungTotal()"
                            required
                        >

                        <button
                            type="button"
                            class="btn-hapus-row"
                            onclick="hapusProduk(this)"
                        >
                            ✕
                        </button>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-tambah-produk"
                    onclick="tambahProduk()"
                >
                    + Tambah Produk
                </button>

            </div>

            <div class="total-box">

                <span>
                    Total Harga
                </span>

                <strong id="totalHarga">
                    Rp 0
                </strong>

            </div>

            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                💾 Simpan Transaksi
            </button>

        </form>

    </div>


    <div class="card">

        <div class="card-title">
            📋 Riwayat Transaksi
        </div>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Produk yang Dibeli</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($data) > 0) {

                    while ($row = mysqli_fetch_assoc($data)) {

                        $id_transaksi = $row['PenjualanID'];

                        $detail = mysqli_query(
                            $koneksi,
                            "SELECT detailpenjualan.*, produk.NamaProduk
                             FROM detailpenjualan
                             LEFT JOIN produk
                             ON detailpenjualan.ProdukID = produk.ProdukID
                             WHERE detailpenjualan.PenjualanID='$id_transaksi'
                             ORDER BY detailpenjualan.DetailID ASC"
                        );

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= date('d-m-Y', strtotime($row['TanggalPenjualan'])); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['NamaPelanggan'] ?? '-'); ?>
                        </td>

                        <td>

                            <div class="produk-list">

                                <?php

                                while ($d = mysqli_fetch_assoc($detail)) {

                                ?>

                                    <span class="produk-item">

                                        🧴
                                        <?= htmlspecialchars($d['NamaProduk']); ?>

                                        ×

                                        <?= $d['JumlahProduk']; ?>

                                    </span>

                                <?php } ?>

                            </div>

                        </td>

                        <td class="total-table">

                            Rp
                            <?= number_format(
                                $row['TotalHarga'],
                                0,
                                ',',
                                '.'
                            ); ?>

                        </td>

                        <td>

                            <div class="action">

                                <a
                                    class="btn-edit"
                                    href="admin_edit_transaksi.php?id=<?= $row['PenjualanID']; ?>"
                                >
                                    ✏️ Edit
                                </a>

                                <a
                                    class="btn-struk"
                                    href="admin_cetak_struk.php?id=<?= $row['PenjualanID']; ?>"
                                    target="_blank"
                                >
                                    🧾 Struk
                                </a>

                                <a
                                    class="btn-hapus"
                                    href="admin_hapus_transaksi.php?id=<?= $row['PenjualanID']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini? Stok produk akan dikembalikan.')"
                                >
                                    🗑 Hapus
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td
                            colspan="6"
                            class="empty"
                        >
                            Belum ada transaksi.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>

function tambahProduk() {

    let container =
        document.getElementById("produk-container");

    let baris =
        document.querySelector(".produk-row");

    let baru =
        baris.cloneNode(true);

    baru.querySelector("select").value = "";

    baru.querySelector("input").value = 1;

    container.appendChild(baru);

    hitungTotal();
}


function hapusProduk(button) {

    let container =
        document.getElementById("produk-container");

    let semuaBaris =
        container.querySelectorAll(".produk-row");

    if (semuaBaris.length > 1) {

        button.parentElement.remove();

        hitungTotal();

    } else {

        alert("Minimal harus ada satu produk!");

    }

}


function hitungTotal() {

    let semuaBaris =
        document.querySelectorAll(".produk-row");

    let total = 0;

    semuaBaris.forEach(function(baris) {

        let select =
            baris.querySelector(".produk-select");

        let jumlah =
            baris.querySelector(".jumlah-input");

        if (select.value !== "") {

            let pilihan =
                select.options[select.selectedIndex];

            let harga =
                parseFloat(
                    pilihan.getAttribute("data-harga")
                );

            let qty =
                parseInt(jumlah.value) || 0;

            total += harga * qty;

        }

    });

    document.getElementById("totalHarga").innerHTML =
        "Rp " + total.toLocaleString("id-ID");

}

</script>