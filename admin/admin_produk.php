<?php

include "../koneksi.php";


/* =========================
   SIMPAN PRODUK
========================= */

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query(
        $koneksi,
        "INSERT INTO produk
        (NamaProduk, Harga, Stok)
        VALUES
        ('$nama', '$harga', '$stok')"
    );

    header("Location: admin_produk.php");
    exit;
}


/* =========================
   UPDATE PRODUK
========================= */

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query(
        $koneksi,
        "UPDATE produk SET
        NamaProduk='$nama',
        Harga='$harga',
        Stok='$stok'
        WHERE ProdukID='$id'"
    );

    header("Location: admin_produk.php");
    exit;
}


/* =========================
   HAPUS PRODUK
========================= */

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query(
        $koneksi,
        "DELETE FROM produk
        WHERE ProdukID='$id'"
    );

    header("Location: admin_produk.php");
    exit;
}


/* =========================
   AMBIL DATA PRODUK
========================= */

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM produk
    ORDER BY ProdukID DESC"
);


/* =========================
   HEADER
========================= */

include "admin_header.php";

?>

<style>

/* =========================
   JUDUL
========================= */

.page-title {
    margin-bottom: 25px;
}

.page-title h1 {
    margin: 0 0 7px;
    color: #5c3475;
    font-size: 28px;
}

.page-title p {
    margin: 0;
    color: #9478a1;
    font-size: 14px;
}


/* =========================
   BOX
========================= */

.box {
    background: white;
    padding: 28px;
    margin-bottom: 25px;
    border-radius: 23px;
    border: 1px solid #eee2f3;
    box-shadow: 0 10px 28px rgba(91,54,120,.07);
}

.box-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.box-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #f0e3f7;
    font-size: 20px;
}

.box h2 {
    margin: 0;
    color: #603b75;
    font-size: 20px;
}


/* =========================
   FORM
========================= */

.form-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 18px;
}

.form-group {
    margin-bottom: 17px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #674477;
    font-size: 13px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 13px 15px;
    border: 1px solid #dfcde8;
    border-radius: 13px;
    background: #fcfaff;
    color: #594063;
    font-size: 14px;
    outline: none;
    transition: .2s;
}

.form-group input:focus {
    border-color: #9b69b9;
    background: white;
    box-shadow: 0 0 0 4px rgba(155,105,185,.10);
}


/* =========================
   BUTTON
========================= */

.btn {
    display: inline-block;
    border: none;
    padding: 10px 15px;
    border-radius: 11px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    transition: .2s;
}

.btn:hover {
    opacity: .85;
    transform: translateY(-1px);
}

.btn-purple {
    background: linear-gradient(135deg,#8050a4,#a875c5);
    color: white;
    padding: 13px 24px;
    box-shadow: 0 7px 17px rgba(128,80,164,.20);
}

.btn-warning {
    background: #fff1cf;
    color: #a47719;
}

.btn-danger {
    background: #ffe2e8;
    color: #c34e6c;
}

.btn-success {
    width: 100%;
    background: linear-gradient(135deg,#8050a4,#a875c5);
    color: white;
    padding: 14px 25px;
    box-shadow: 0 7px 17px rgba(128,80,164,.20);
}


/* =========================
   TABLE
========================= */

.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

th {
    background: #f4ebf8;
    color: #654174;
    font-size: 13px;
    text-align: left;
    padding: 14px;
}

th:first-child {
    border-radius: 12px 0 0 12px;
}

th:last-child {
    border-radius: 0 12px 12px 0;
}

td {
    padding: 14px;
    border-bottom: 1px solid #f0e8f4;
    color: #765b83;
    font-size: 13px;
}

tr:hover td {
    background: #fcf9fd;
}

.number {
    width: 45px;
    font-weight: bold;
    color: #9066a9;
}

.product-name {
    font-weight: bold;
    color: #624071;
}

.price {
    font-weight: bold;
    color: #76509a;
}

.stock {
    display: inline-block;
    padding: 6px 11px;
    border-radius: 9px;
    background: #f1e7f6;
    color: #755087;
    font-weight: bold;
}

.action {
    white-space: nowrap;
}


/* =========================
   INFO
========================= */

.product-note {
    margin-top: 18px;
    padding: 14px 16px;
    background: #faf5fc;
    border-radius: 13px;
    color: #92779e;
    font-size: 12px;
}


/* =========================
   MODAL EDIT
========================= */

.modal-edit {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(55,35,65,.50);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
    z-index: 99999;
    padding: 20px;
}

.modal-box {
    width: 100%;
    max-width: 500px;
    background: white;
    border-radius: 25px;
    padding: 30px;
    position: relative;
    box-shadow: 0 25px 70px rgba(60,35,75,.30);
    animation: muncul .25s ease;
}

@keyframes muncul {

    from {
        opacity: 0;
        transform: translateY(-20px) scale(.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}

.modal-close {
    position: absolute;
    right: 18px;
    top: 17px;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: #f3e7f7;
    color: #765087;
    font-size: 23px;
    cursor: pointer;
}

.modal-close:hover {
    background: #ead8f0;
    transform: rotate(90deg);
}

.modal-title {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
    padding-right: 35px;
}

.modal-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg,#eee0f7,#dfc8ec);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
}

.modal-title h2 {
    margin: 0;
    color: #603b75;
    font-size: 21px;
}

.modal-title p {
    margin: 5px 0 0;
    color: #9a84a4;
    font-size: 12px;
}

.edit-info {
    margin-bottom: 20px;
    padding: 13px 15px;
    border-radius: 12px;
    background: #faf5fc;
    border: 1px solid #eee2f3;
    color: #8c7597;
    font-size: 12px;
    line-height: 1.5;
}

.modal-box .form-group {
    margin-bottom: 18px;
}

.modal-box .form-group input {
    background: #fcfaff;
}

.modal-box .form-group input:focus {
    border-color: #9b69b9;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 800px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

    .box {
        padding: 20px;
    }

    .modal-box {
        padding: 23px;
    }

}

</style>


<!-- =========================
     JUDUL HALAMAN
========================= -->

<div class="page-title">

    <h1>Data Produk 🧴</h1>

    <p>
        Kelola produk skincare, harga, dan stok FirSkincare.
    </p>

</div>


<!-- =========================
     TAMBAH PRODUK
========================= -->

<div class="box">

    <div class="box-title">

        <div class="box-icon">
            🧴
        </div>

        <h2>Tambah Produk</h2>

    </div>


    <form method="POST">

        <div class="form-grid">

            <div class="form-group">

                <label>Nama Produk</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Contoh: Glow Serum"
                    required
                >

            </div>


            <div class="form-group">

                <label>Harga</label>

                <input
                    type="number"
                    name="harga"
                    placeholder="Masukkan harga"
                    min="0"
                    required
                >

            </div>


            <div class="form-group">

                <label>Stok</label>

                <input
                    type="number"
                    name="stok"
                    placeholder="Jumlah stok"
                    min="0"
                    required
                >

            </div>

        </div>


        <button
            type="submit"
            class="btn btn-purple"
            name="simpan"
        >
            ✨ Simpan Produk
        </button>

    </form>


    <div class="product-note">

        💜 Pastikan nama produk, harga, dan stok sudah benar sebelum disimpan.

    </div>

</div>


<!-- =========================
     DAFTAR PRODUK
========================= -->

<div class="box">

    <div class="box-title">

        <div class="box-icon">
            📦
        </div>

        <h2>Daftar Produk</h2>

    </div>


    <div class="table-wrap">

        <table>

            <tr>

                <th>No</th>

                <th>Produk</th>

                <th>Harga</th>

                <th>Stok</th>

                <th>Aksi</th>

            </tr>


            <?php

            $no = 1;

            while ($row = mysqli_fetch_assoc($data)) {

            ?>

            <tr>

                <td class="number">
                    <?= $no++; ?>
                </td>


                <td class="product-name">

                    <?= htmlspecialchars($row['NamaProduk']); ?>

                </td>


                <td class="price">

                    Rp <?= number_format(
                        $row['Harga'],
                        0,
                        ',',
                        '.'
                    ); ?>

                </td>


                <td>

                    <span class="stock">

                        <?= $row['Stok']; ?> pcs

                    </span>

                </td>


                <td class="action">


                    <!-- EDIT -->

                    <button
                        type="button"
                        class="btn btn-warning"
                        onclick="bukaEdit(
                            '<?= $row['ProdukID']; ?>',
                            '<?= htmlspecialchars($row['NamaProduk'], ENT_QUOTES); ?>',
                            '<?= $row['Harga']; ?>',
                            '<?= $row['Stok']; ?>'
                        )"
                    >

                        ✏️ Edit

                    </button>


                    <!-- HAPUS -->

                    <a
                        class="btn btn-danger"
                        href="?hapus=<?= $row['ProdukID']; ?>"
                        onclick="return confirm('Yakin ingin menghapus produk ini?')"
                    >

                        🗑️ Hapus

                    </a>


                </td>

            </tr>

            <?php

            }

            ?>

        </table>

    </div>

</div>


<!-- =========================
     MODAL EDIT
========================= -->

<div
    id="modalEdit"
    class="modal-edit"
>

    <div class="modal-box">


        <!-- CLOSE -->

        <button
            type="button"
            class="modal-close"
            onclick="tutupEdit()"
        >

            ×

        </button>


        <!-- TITLE -->

        <div class="modal-title">

            <div class="modal-icon">

                ✏️

            </div>


            <div>

                <h2>Edit Produk</h2>

                <p>
                    Ubah data produk FirSkincare
                </p>

            </div>

        </div>


        <!-- INFO -->

        <div class="edit-info">

            💜 Silakan ubah nama, harga, atau stok.
            Setelah selesai tekan <b>Update Produk</b>.

        </div>


        <!-- FORM UPDATE -->

        <form method="POST">


            <input
                type="hidden"
                name="id"
                id="edit_id"
            >


            <div class="form-group">

                <label>
                    Nama Produk
                </label>

                <input
                    type="text"
                    name="nama"
                    id="edit_nama"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Harga
                </label>

                <input
                    type="number"
                    name="harga"
                    id="edit_harga"
                    min="0"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    id="edit_stok"
                    min="0"
                    required
                >

            </div>


            <button
                type="submit"
                name="update"
                class="btn btn-success"
            >

                💾 Update Produk

            </button>


        </form>

    </div>

</div>


<script>

/* =========================
   BUKA MODAL EDIT
========================= */

function bukaEdit(
    id,
    nama,
    harga,
    stok
) {

    document.getElementById("edit_id").value = id;

    document.getElementById("edit_nama").value = nama;

    document.getElementById("edit_harga").value = harga;

    document.getElementById("edit_stok").value = stok;

    document.getElementById("modalEdit").style.display = "flex";

}


/* =========================
   TUTUP MODAL
========================= */

function tutupEdit() {

    document.getElementById("modalEdit").style.display = "none";

}


/* =========================
   KLIK DI LUAR MODAL
========================= */

window.onclick = function(event) {

    const modal =
        document.getElementById("modalEdit");

    if (event.target === modal) {

        tutupEdit();

    }

};


/* =========================
   TOMBOL ESC
========================= */

document.addEventListener(
    "keydown",
    function(event) {

        if (event.key === "Escape") {

            tutupEdit();

        }

    }
);

</script>


</div>

</body>

</html>