<?php

include "../koneksi.php";

$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan
     ORDER BY NamaPelanggan ASC"
);

$produk = mysqli_query(
    $koneksi,
    "SELECT * FROM produk
     WHERE Stok > 0
     ORDER BY NamaProduk ASC"
);

$data_produk = [];

while ($pr = mysqli_fetch_assoc($produk)) {
    $data_produk[] = $pr;
}

include "kasir_header.php";

?>

<style>

.transaksi-banner {
    background: linear-gradient(135deg, #8f68ad, #b58ac8);
    padding: 28px 30px;
    border-radius: 23px;
    color: white;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(90,55,110,.12);
}

.transaksi-banner::after {
    content: "🧴";
    position: absolute;
    right: 35px;
    top: 15px;
    font-size: 65px;
    opacity: .16;
}

.transaksi-banner h1 {
    margin: 0 0 7px;
    font-size: 27px;
}

.transaksi-banner p {
    margin: 0;
    color: rgba(255,255,255,.85);
    font-size: 13px;
}

.transaksi-card {
    background: white;
    border: 1px solid #eee3f5;
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 9px 25px rgba(94,56,120,.07);
}

.transaksi-title {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 25px;
}

.transaksi-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
}

.transaksi-title h2 {
    margin: 0;
    color: #654376;
    font-size: 19px;
}

.transaksi-title p {
    margin: 5px 0 0;
    color: #a18ca8;
    font-size: 12px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-group label {
    margin-bottom: 8px;
    color: #684477;
    font-size: 13px;
    font-weight: bold;
}

.form-group select,
.form-group input {
    width: 100%;
    padding: 13px 15px;
    border: 1px solid #dfd0e7;
    border-radius: 12px;
    background: #fcfaff;
    color: #5d4a65;
    font-size: 13px;
    outline: none;
}

.form-group select:focus,
.form-group input:focus {
    border-color: #9b69c5;
    background: white;
    box-shadow: 0 0 0 3px rgba(155,105,197,.10);
}

.pelanggan-info {
    margin-top: -10px;
    margin-bottom: 20px;
    padding: 11px 14px;
    background: #f8f2fb;
    border: 1px solid #eee3f5;
    border-radius: 11px;
    color: #80698a;
    font-size: 12px;
}

.produk-row {
    display: grid;
    grid-template-columns: 1fr 180px 50px;
    gap: 12px;
    align-items: end;
    margin-bottom: 12px;
    padding: 15px;
    background: #faf7fc;
    border: 1px solid #eee3f5;
    border-radius: 15px;
}

.produk-row label {
    display: block;
    margin-bottom: 7px;
    color: #684477;
    font-size: 12px;
    font-weight: bold;
}

.produk-row select,
.produk-row input {
    width: 100%;
    padding: 12px;
    border: 1px solid #dfd0e7;
    border-radius: 10px;
    background: white;
    color: #5d4a65;
    outline: none;
}

.produk-row select:focus,
.produk-row input:focus {
    border-color: #9b69c5;
}

.btn-tambah {
    margin: 5px 0 20px;
    border: none;
    padding: 11px 18px;
    border-radius: 11px;
    background: #f0e3f7;
    color: #70498a;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
}

.btn-tambah:hover {
    background: #e5d2ef;
}

.btn-hapus-produk {
    width: 45px;
    height: 43px;
    border: none;
    border-radius: 10px;
    background: #f8dfe6;
    color: #b34d68;
    font-size: 18px;
    cursor: pointer;
}

.btn-hapus-produk:hover {
    background: #f2cbd7;
}

.btn-simpan {
    margin-top: 5px;
    border: none;
    padding: 13px 24px;
    border-radius: 12px;
    background: linear-gradient(135deg,#9b69c5,#744399);
    color: white;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(117,67,155,.20);
}

.btn-simpan:hover {
    opacity: .92;
    transform: translateY(-1px);
}

.info-box {
    margin-top: 20px;
    padding: 15px 17px;
    border-radius: 13px;
    background: #f8f2fb;
    border: 1px solid #eee3f5;
    color: #80698a;
    font-size: 12px;
    line-height: 1.6;
}

@media (max-width: 700px) {

    .produk-row {
        grid-template-columns: 1fr;
    }

    .btn-hapus-produk {
        width: 100%;
    }

    .transaksi-banner {
        padding: 22px;
    }

    .transaksi-banner h1 {
        font-size: 23px;
    }

    .transaksi-card {
        padding: 20px;
    }

}

</style>


<div class="transaksi-banner">

    <h1>🛒 Transaksi Penjualan</h1>

    <p>
        Buat transaksi penjualan skincare dengan beberapa produk sekaligus.
    </p>

</div>


<div class="transaksi-card">

    <div class="transaksi-title">

        <div class="transaksi-icon">
            🛍️
        </div>

        <div>

            <h2>
                Buat Transaksi Baru
            </h2>

            <p>
                Pilih pelanggan dan satu atau lebih produk.
            </p>

        </div>

    </div>


    <form method="POST" action="kasir_riwayat.php">


        <!-- PELANGGAN -->

        <div class="form-group">

            <label>
                👤 Pelanggan
            </label>

            <select name="pelanggan">

                <option value="0">
                    👤 Pelanggan Umum
                </option>

                <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

                    <option value="<?= $p['PelangganID']; ?>">

                        <?= htmlspecialchars($p['NamaPelanggan']); ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="pelanggan-info">

            💡 <strong>Pelanggan Umum</strong> digunakan untuk pembeli
            yang tidak ingin dicatat sebagai pelanggan terdaftar.

        </div>


        <!-- PRODUK -->

        <label style="
            display:block;
            margin-bottom:10px;
            color:#684477;
            font-size:13px;
            font-weight:bold;
        ">

            🧴 Produk yang Dibeli

        </label>


        <div id="produk-container">


            <div class="produk-row">


                <div>

                    <label>
                        Produk
                    </label>

                    <select name="produk[]" required>

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        <?php foreach ($data_produk as $pr) { ?>

                            <option value="<?= $pr['ProdukID']; ?>">

                                <?= htmlspecialchars($pr['NamaProduk']); ?>

                                -

                                Rp <?= number_format(
                                    $pr['Harga'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                                -

                                Stok <?= $pr['Stok']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div>

                    <label>
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="jumlah[]"
                        min="1"
                        value="1"
                        required
                    >

                </div>


                <button
                    type="button"
                    class="btn-hapus-produk"
                    onclick="hapusProduk(this)"
                >

                    ×

                </button>


            </div>


        </div>


        <button
            type="button"
            class="btn-tambah"
            onclick="tambahProduk()"
        >

            ➕ Tambah Produk

        </button>


        <br>


        <button
            class="btn-simpan"
            name="simpan"
            type="submit"
        >

            💜 Simpan Transaksi

        </button>


        <div class="info-box">

            💡 <strong>Info:</strong>

            Kamu bisa menambahkan beberapa produk dalam satu transaksi.
            Stok setiap produk akan otomatis berkurang sesuai jumlah pembelian.

        </div>


    </form>

</div>


<script>

function tambahProduk() {

    const container = document.getElementById("produk-container");

    const produk = document.querySelector(
        "#produk-container .produk-row"
    );

    const row = produk.cloneNode(true);

    row.querySelector("select").value = "";

    row.querySelector("input").value = "1";

    container.appendChild(row);

}


function hapusProduk(button) {

    const container = document.getElementById("produk-container");

    const rows = container.querySelectorAll(".produk-row");

    if (rows.length > 1) {

        button.parentElement.remove();

    } else {

        alert("Minimal harus ada 1 produk.");

    }

}

</script>


</div>

</body>
</html>