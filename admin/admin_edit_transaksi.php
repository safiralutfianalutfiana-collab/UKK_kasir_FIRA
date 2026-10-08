<?php
include "../koneksi.php";
include "admin_header.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo "<script>
        alert('ID transaksi tidak ditemukan!');
        window.location='admin_transaksi.php';
    </script>";
    exit;
}

$data = mysqli_query(
    $koneksi,
    "SELECT penjualan.*, pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID = pelanggan.PelangganID
     WHERE penjualan.PenjualanID='$id'"
);

$transaksi = mysqli_fetch_assoc($data);

if (!$transaksi) {
    echo "<script>
        alert('Transaksi tidak ditemukan!');
        window.location='admin_transaksi.php';
    </script>";
    exit;
}

$detail = mysqli_query(
    $koneksi,
    "SELECT detailpenjualan.*, produk.NamaProduk, produk.Harga
     FROM detailpenjualan
     LEFT JOIN produk
     ON detailpenjualan.ProdukID = produk.ProdukID
     WHERE detailpenjualan.PenjualanID='$id'
     ORDER BY detailpenjualan.DetailID ASC"
);

$detail_lama = [];

while ($d = mysqli_fetch_assoc($detail)) {
    $detail_lama[] = $d;
}

$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan
     ORDER BY NamaPelanggan ASC"
);

$produk = mysqli_query(
    $koneksi,
    "SELECT * FROM produk
     ORDER BY NamaProduk ASC"
);

if (isset($_POST['update'])) {

    $tanggal = $_POST['tanggal'];
    $pelanggan_id = $_POST['pelanggan'];
    $produk_list = $_POST['produk'];
    $jumlah_list = $_POST['jumlah'];

    mysqli_begin_transaction($koneksi);

    try {

        foreach ($detail_lama as $lama) {

            $produk_lama = $lama['ProdukID'];
            $jumlah_lama = $lama['JumlahProduk'];

            mysqli_query(
                $koneksi,
                "UPDATE produk
                 SET Stok = Stok + $jumlah_lama
                 WHERE ProdukID='$produk_lama'"
            );
        }

        mysqli_query(
            $koneksi,
            "DELETE FROM detailpenjualan
             WHERE PenjualanID='$id'"
        );

        $total = 0;
        $detail_baru = [];

        for ($i = 0; $i < count($produk_list); $i++) {

            $produk_id = $produk_list[$i];
            $jumlah = (int)$jumlah_list[$i];

            if (empty($produk_id) || $jumlah < 1) {
                continue;
            }

            $cek = mysqli_query(
                $koneksi,
                "SELECT * FROM produk
                 WHERE ProdukID='$produk_id'"
            );

            $p = mysqli_fetch_assoc($cek);

            if (!$p) {
                throw new Exception("Produk tidak ditemukan.");
            }

            if ($jumlah > $p['Stok']) {
                throw new Exception(
                    "Stok {$p['NamaProduk']} tidak mencukupi."
                );
            }

            $subtotal = $p['Harga'] * $jumlah;

            $total += $subtotal;

            $detail_baru[] = [
                'produk' => $produk_id,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal
            ];
        }

        if (count($detail_baru) == 0) {
            throw new Exception("Minimal pilih satu produk.");
        }

        mysqli_query(
            $koneksi,
            "UPDATE penjualan SET
             TanggalPenjualan='$tanggal',
             TotalHarga='$total',
             PelangganID='$pelanggan_id'
             WHERE PenjualanID='$id'"
        );

        foreach ($detail_baru as $d) {

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
                    '$id',
                    '{$d['produk']}',
                    '{$d['jumlah']}',
                    '{$d['subtotal']}'
                )"
            );

            mysqli_query(
                $koneksi,
                "UPDATE produk
                 SET Stok = Stok - {$d['jumlah']}
                 WHERE ProdukID='{$d['produk']}'"
            );
        }

        mysqli_commit($koneksi);

        echo "<script>
            alert('Struk transaksi berhasil diperbarui!');
            window.location='admin_transaksi.php';
        </script>";
        exit;

    } catch (Exception $e) {

        mysqli_rollback($koneksi);

        echo "<script>
            alert('" . addslashes($e->getMessage()) . "');
            window.location='admin_edit_struk_transaksi.php?id=$id';
        </script>";
        exit;
    }
}
?>

<style>
.edit-box {
    max-width: 1100px;
    margin: auto;
}

.edit-title {
    margin-bottom: 20px;
}

.edit-title h2 {
    color: #5d3d70;
    margin-bottom: 5px;
}

.edit-title p {
    color: #927aa0;
    font-size: 14px;
}

.edit-card {
    background: white;
    padding: 25px;
    border-radius: 20px;
    border: 1px solid #eee2f3;
    box-shadow: 0 8px 25px rgba(80,45,100,.07);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.form-group label {
    display: block;
    color: #654477;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 7px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #e2d5e8;
    border-radius: 12px;
    outline: none;
    color: #5d4569;
    background: #fcf9fd;
}

.produk-title {
    color: #654477;
    font-weight: bold;
    margin: 25px 0 15px;
}

.produk-row {
    display: grid;
    grid-template-columns: 1fr 150px 45px;
    gap: 10px;
    margin-bottom: 10px;
}

.produk-row select,
.produk-row input {
    padding: 12px;
    border: 1px solid #e2d5e8;
    border-radius: 12px;
    outline: none;
}

.btn-tambah {
    padding: 10px 15px;
    border: none;
    border-radius: 11px;
    background: #f0e6f5;
    color: #70498a;
    font-weight: bold;
    cursor: pointer;
}

.btn-hapus-row {
    border: none;
    border-radius: 10px;
    background: #f8e3e7;
    color: #b45569;
    cursor: pointer;
}

.total {
    margin-top: 20px;
    padding: 17px;
    border-radius: 13px;
    background: #f7f0fa;
    display: flex;
    justify-content: space-between;
    color: #70498a;
    font-weight: bold;
}

.tombol {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-simpan {
    flex: 1;
    border: none;
    border-radius: 12px;
    padding: 13px;
    background: linear-gradient(135deg,#765092,#9a73b6);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-kembali {
    padding: 13px 20px;
    border-radius: 12px;
    background: #f0e6f5;
    color: #70498a;
    text-decoration: none;
    font-weight: bold;
}

@media(max-width:700px) {
    .form-grid,
    .produk-row {
        grid-template-columns: 1fr;
    }

    .tombol {
        flex-direction: column;
    }
}
</style>

<div class="edit-box">

    <div class="edit-title">
        <h2>✏️ Edit Struk Transaksi</h2>
        <p>Edit tanggal, pelanggan, dan produk yang dibeli.</p>
    </div>

    <div class="edit-card">

        <form method="POST">

            <div class="form-grid">

                <div class="form-group">
                    <label>Tanggal Transaksi</label>

                    <input
                        type="date"
                        name="tanggal"
                        value="<?= $transaksi['TanggalPenjualan']; ?>"
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

                            <option
                                value="<?= $p['PelangganID']; ?>"
                                <?= $p['PelangganID'] == $transaksi['PelangganID'] ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($p['NamaPelanggan']); ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>

            </div>

            <div class="produk-title">
                🧴 Produk yang Dibeli
            </div>

            <div id="produk-container">

                <?php foreach ($detail_lama as $lama) { ?>

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
                                    <?= $p['ProdukID'] == $lama['ProdukID'] ? 'selected' : ''; ?>
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
                            value="<?= $lama['JumlahProduk']; ?>"
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

                <?php } ?>

            </div>

            <button
                type="button"
                class="btn-tambah"
                onclick="tambahProduk()"
            >
                + Tambah Produk
            </button>

            <div class="total">
                <span>Total Harga</span>
                <span id="totalHarga">Rp 0</span>
            </div>

            <div class="tombol">

                <a
                    href="admin_transaksi.php"
                    class="btn-kembali"
                >
                    ← Kembali
                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn-simpan"
                >
                    💾 Simpan Perubahan
                </button>

            </div>

        </form>

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

    let semua =
        document.querySelectorAll(".produk-row");

    if (semua.length > 1) {
        button.parentElement.remove();
        hitungTotal();
    } else {
        alert("Minimal satu produk harus ada!");
    }
}

function hitungTotal() {

    let semua =
        document.querySelectorAll(".produk-row");

    let total = 0;

    semua.forEach(function(baris) {

        let select =
            baris.querySelector(".produk-select");

        let jumlah =
            baris.querySelector(".jumlah-input");

        if (select.value !== "") {

            let option =
                select.options[select.selectedIndex];

            let harga =
                parseFloat(option.getAttribute("data-harga"));

            let qty =
                parseInt(jumlah.value) || 0;

            total += harga * qty;
        }
    });

    document.getElementById("totalHarga").innerHTML =
        "Rp " + total.toLocaleString("id-ID");
}

hitungTotal();

</script>