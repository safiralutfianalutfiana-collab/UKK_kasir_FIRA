<?php

include "../koneksi.php";
include "admin_header.php";

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    mysqli_query(
        $koneksi,
        "INSERT INTO pelanggan
        (NamaPelanggan, Alamat, NomorTelepon)
        VALUES
        ('$nama', '$alamat', '$telepon')"
    );

    echo "<script>
        alert('Data pelanggan berhasil ditambahkan!');
        window.location='admin_pelanggan.php';
    </script>";
    exit;
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    mysqli_query(
        $koneksi,
        "UPDATE pelanggan SET
        NamaPelanggan='$nama',
        Alamat='$alamat',
        NomorTelepon='$telepon'
        WHERE PelangganID='$id'"
    );

    echo "<script>
        alert('Data pelanggan berhasil diperbarui!');
        window.location='admin_pelanggan.php';
    </script>";
    exit;
}

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query(
        $koneksi,
        "DELETE FROM pelanggan WHERE PelangganID='$id'"
    );

    echo "<script>
        alert('Data pelanggan berhasil dihapus!');
        window.location='admin_pelanggan.php';
    </script>";
    exit;
}

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY PelangganID DESC"
);

?>

<style>

.page-title {
    margin-bottom: 22px;
}

.page-title h1 {
    color: #603b75;
    font-size: 25px;
    margin-bottom: 6px;
}

.page-title p {
    color: #92789e;
    font-size: 13px;
}

.card {
    background: white;
    border-radius: 20px;
    padding: 25px;
    border: 1px solid #eee2f3;
    box-shadow: 0 8px 25px rgba(80,45,100,.07);
    margin-bottom: 25px;
}

.card-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-title h2 {
    color: #603b75;
    font-size: 19px;
}

.btn-tambah {
    border: none;
    padding: 11px 17px;
    border-radius: 12px;
    background: linear-gradient(135deg,#8050a4,#a875c5);
    color: white;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
}

.btn-tambah:hover {
    opacity: .9;
}

.form-tambah {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    color: #674477;
    font-size: 13px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #dfcde8;
    border-radius: 12px;
    background: #fcfaff;
    color: #594063;
    outline: none;
    font-family: Arial, sans-serif;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #9b70b6;
    box-shadow: 0 0 0 3px rgba(155,112,182,.10);
}

.form-group textarea {
    resize: vertical;
    min-height: 44px;
}

.btn-simpan {
    align-self: end;
    height: 44px;
    border: none;
    border-radius: 12px;
    background: #765092;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-simpan:hover {
    background: #65417e;
}

.table-card {
    background: white;
    border-radius: 20px;
    padding: 25px;
    border: 1px solid #eee2f3;
    box-shadow: 0 8px 25px rgba(80,45,100,.07);
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    background: #f5edf8;
    color: #674477;
    font-size: 13px;
    padding: 14px 12px;
    text-align: left;
}

thead th:first-child {
    border-radius: 12px 0 0 12px;
}

thead th:last-child {
    border-radius: 0 12px 12px 0;
}

tbody td {
    padding: 15px 12px;
    border-bottom: 1px solid #f0e7f3;
    color: #685273;
    font-size: 13px;
}

tbody tr:hover {
    background: #fcf9fd;
}

.nomor {
    color: #9a7ba8;
    font-weight: bold;
}

.nama-pelanggan {
    color: #5f3b70;
    font-weight: bold;
}

.aksi {
    display: flex;
    gap: 7px;
    white-space: nowrap;
}

.btn {
    border: none;
    padding: 8px 11px;
    border-radius: 9px;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
}

.btn-warning {
    background: #f4e8a8;
    color: #76621a;
}

.btn-warning:hover {
    background: #ecdf91;
}

.btn-danger {
    background: #f6dddd;
    color: #a33b3b;
}

.btn-danger:hover {
    background: #efcaca;
}

/* MODAL */

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(65,40,75,.35);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-box {
    width: 100%;
    max-width: 600px;
    background: white;
    border-radius: 23px;
    padding: 28px;
    box-shadow: 0 20px 50px rgba(70,40,90,.20);
    animation: muncul .2s ease;
}

@keyframes muncul {

    from {
        opacity: 0;
        transform: translateY(-15px) scale(.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.modal-header h2 {
    margin: 0;
    color: #603b75;
    font-size: 20px;
}

.tutup-modal {
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 10px;
    background: #f5eaf8;
    color: #76508b;
    font-size: 18px;
    cursor: pointer;
}

.tutup-modal:hover {
    background: #ead9f2;
}

.modal .form-group {
    margin-bottom: 17px;
}

.modal .form-group label {
    display: block;
    margin-bottom: 8px;
    color: #674477;
    font-size: 13px;
    font-weight: bold;
}

.modal .form-group input,
.modal .form-group textarea {
    width: 100%;
    padding: 13px 15px;
    border: 1px solid #dfcde8;
    border-radius: 13px;
    background: #fcfaff;
    color: #594063;
    outline: none;
    font-family: Arial, sans-serif;
}

.modal .form-group input:focus,
.modal .form-group textarea:focus {
    border-color: #9b70b6;
    box-shadow: 0 0 0 3px rgba(155,112,182,.10);
}

.modal .form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.modal-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-batal {
    flex: 1;
    border: none;
    padding: 13px;
    border-radius: 12px;
    background: #f1e8f5;
    color: #70498a;
    font-weight: bold;
    cursor: pointer;
}

.btn-batal:hover {
    background: #e8dcef;
}

.btn-update-modal {
    flex: 1;
    border: none;
    padding: 13px;
    border-radius: 12px;
    background: linear-gradient(135deg,#8050a4,#a875c5);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-update-modal:hover {
    opacity: .9;
}

@media(max-width:850px) {

    .form-tambah {
        grid-template-columns: 1fr;
    }

    .btn-simpan {
        width: 100%;
    }

}

@media(max-width:600px) {

    .modal-box {
        padding: 20px;
    }

    .modal-buttons {
        flex-direction: column;
    }

}

</style>


<div class="page-title">
    <h1>👥 Data Pelanggan</h1>
    <p>Kelola data pelanggan FirSkincare dengan mudah.</p>
</div>


<div class="card">

    <div class="card-title">
        <h2>➕ Tambah Pelanggan</h2>
    </div>

    <form method="POST">

        <div class="form-tambah">

            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama pelanggan"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input
                    type="text"
                    name="telepon"
                    placeholder="Masukkan nomor telepon"
                >
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input
                    type="text"
                    name="alamat"
                    placeholder="Masukkan alamat"
                >
            </div>

            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                💾 Simpan Pelanggan
            </button>

        </div>

    </form>

</div>


<div class="table-card">

    <div class="card-title">

        <h2>📋 Daftar Pelanggan</h2>

        <span style="
            background:#f5eaf8;
            color:#76508b;
            padding:9px 13px;
            border-radius:10px;
            font-size:12px;
            font-weight:bold;
        ">
            Total Pelanggan
        </span>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th width="180">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php

                $no = 1;

                while ($row = mysqli_fetch_assoc($data)) {

                ?>

                <tr>

                    <td class="nomor">
                        <?= $no++; ?>
                    </td>

                    <td class="nama-pelanggan">
                        <?= htmlspecialchars($row['NamaPelanggan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['NomorTelepon'] ?? '-'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['Alamat'] ?? '-'); ?>
                    </td>

                    <td>

                        <div class="aksi">

                            <button
                                type="button"
                                class="btn btn-warning"
                                onclick='bukaEdit(
                                    <?= json_encode($row['PelangganID']); ?>,
                                    <?= json_encode($row['NamaPelanggan']); ?>,
                                    <?= json_encode($row['NomorTelepon'] ?? ""); ?>,
                                    <?= json_encode($row['Alamat'] ?? ""); ?>
                                )'
                            >
                                ✏️ Edit
                            </button>

                            <a
                                href="?hapus=<?= $row['PelangganID']; ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
                            >
                                🗑 Hapus
                            </a>

                        </div>

                    </td>

                </tr>

                <?php

                }

                ?>

            </tbody>

        </table>

    </div>

</div>


<!-- MODAL EDIT -->

<div class="modal" id="modalEdit">

    <div class="modal-box">

        <div class="modal-header">

            <h2>✏️ Edit Pelanggan</h2>

            <button
                type="button"
                class="tutup-modal"
                onclick="tutupEdit()"
            >
                ✕
            </button>

        </div>


        <form method="POST">

            <input
                type="hidden"
                name="id"
                id="edit_id"
            >


            <div class="form-group">

                <label>Nama Pelanggan</label>

                <input
                    type="text"
                    name="nama"
                    id="edit_nama"
                    required
                >

            </div>


            <div class="form-group">

                <label>Nomor Telepon</label>

                <input
                    type="text"
                    name="telepon"
                    id="edit_telepon"
                >

            </div>


            <div class="form-group">

                <label>Alamat</label>

                <textarea
                    name="alamat"
                    id="edit_alamat"
                ></textarea>

            </div>


            <div class="modal-buttons">

                <button
                    type="button"
                    class="btn-batal"
                    onclick="tutupEdit()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    name="update"
                    class="btn-update-modal"
                >
                    💾 Update Data
                </button>

            </div>

        </form>

    </div>

</div>


<script>

function bukaEdit(id, nama, telepon, alamat) {

    document.getElementById("edit_id").value = id;

    document.getElementById("edit_nama").value = nama;

    document.getElementById("edit_telepon").value = telepon;

    document.getElementById("edit_alamat").value = alamat;

    document.getElementById("modalEdit").style.display = "flex";

}


function tutupEdit() {

    document.getElementById("modalEdit").style.display = "none";

}


window.onclick = function(event) {

    let modal = document.getElementById("modalEdit");

    if (event.target === modal) {

        tutupEdit();

    }

}

</script>

</div>
</body>
</html>