<?php

include "../koneksi.php";


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

    header("Location: kasir_pelanggan.php");
    exit;
}


$data = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan
     ORDER BY PelangganID DESC"
);


include "kasir_header.php";

?>

<style>

.page-banner {
    background: linear-gradient(135deg, #8f68ad, #b58ac8);
    padding: 28px 30px;
    border-radius: 23px;
    color: white;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(90,55,110,.12);
}

.page-banner::after {
    content: "♡";
    position: absolute;
    right: 35px;
    top: -8px;
    font-size: 90px;
    color: rgba(255,255,255,.12);
}

.page-banner h1 {
    margin: 0 0 7px;
    font-size: 27px;
}

.page-banner p {
    margin: 0;
    color: rgba(255,255,255,.85);
    font-size: 13px;
}


.data-card {
    background: white;
    border: 1px solid #eee3f5;
    border-radius: 21px;
    padding: 25px;
    box-shadow: 0 9px 25px rgba(94,56,120,.07);
}


.data-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
}

.data-icon {
    width: 45px;
    height: 45px;
    border-radius: 14px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}

.data-title h2 {
    margin: 0;
    color: #654376;
    font-size: 18px;
}

.data-title span {
    display: block;
    margin-top: 4px;
    color: #a18ca8;
    font-size: 12px;
}


.btn-tambah {
    margin-left: auto;
    border: none;
    padding: 11px 18px;
    border-radius: 12px;
    background: linear-gradient(135deg,#9b69c5,#744399);
    color: white;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(117,67,155,.20);
}

.btn-tambah:hover {
    transform: translateY(-2px);
}


.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-card table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

.data-card th {
    padding: 15px;
    text-align: left;
    background: linear-gradient(90deg,#eee0fa,#f5eafb);
    color: #604078;
    font-size: 13px;
}

.data-card td {
    padding: 15px;
    border-bottom: 1px solid #eee8f2;
    color: #57475f;
    font-size: 13px;
}

.data-card tbody tr:hover {
    background: #fbf7fd;
}

.data-card th:first-child,
.data-card td:first-child {
    text-align: center;
    width: 60px;
}

.phone {
    display: inline-block;
    padding: 7px 11px;
    border-radius: 10px;
    background: #f5edf8;
    color: #70498a;
    font-size: 12px;
    font-weight: bold;
}

.name {
    color: #654376;
    font-weight: bold;
}

.empty-data {
    text-align: center;
    padding: 35px !important;
    color: #a18ca8 !important;
}


/* MODAL */

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(52,35,60,.45);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.modal-box {
    width: 100%;
    max-width: 500px;
    background: white;
    border-radius: 23px;
    padding: 28px;
    box-shadow: 0 20px 60px rgba(50,30,70,.25);
    position: relative;
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

.modal-close {
    position: absolute;
    right: 18px;
    top: 16px;
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    background: #f5edf8;
    color: #70498a;
    font-size: 22px;
    cursor: pointer;
}

.modal-title {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 23px;
}

.modal-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: #f0e3f7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.modal-title h2 {
    margin: 0;
    color: #654376;
    font-size: 19px;
}

.modal-title p {
    margin: 4px 0 0;
    color: #a18ca8;
    font-size: 12px;
}


.form-group {
    margin-bottom: 17px;
}

.form-group label {
    display: block;
    margin-bottom: 7px;
    color: #684477;
    font-size: 13px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 13px 14px;
    border: 1px solid #dfd0e7;
    border-radius: 12px;
    background: #fcfaff;
    color: #5d4a65;
    font-family: Arial, sans-serif;
    font-size: 13px;
    outline: none;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #9b69c5;
    background: white;
    box-shadow: 0 0 0 3px rgba(155,105,197,.10);
}

.form-group textarea {
    min-height: 85px;
    resize: vertical;
}


.btn-simpan {
    width: 100%;
    margin-top: 5px;
    padding: 13px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg,#9b69c5,#744399);
    color: white;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
}

.btn-simpan:hover {
    background: linear-gradient(135deg,#8d59b8,#68398e);
}


@media (max-width: 600px) {

    .page-banner {
        padding: 22px;
    }

    .page-banner h1 {
        font-size: 23px;
    }

    .data-card {
        padding: 18px;
    }

    .data-title {
        flex-wrap: wrap;
    }

    .btn-tambah {
        width: 100%;
        margin-left: 0;
    }

    .modal-box {
        padding: 22px;
    }

}

</style>


<div class="page-banner">

    <h1>
        👥 Data Pelanggan
    </h1>

    <p>
        Kelola data pelanggan FirSkincare dengan mudah.
    </p>

</div>


<div class="data-card">

    <div class="data-title">

        <div class="data-icon">
            👥
        </div>

        <div>
            <h2>
                Daftar Pelanggan
            </h2>

            <span>
                Informasi pelanggan FirSkincare
            </span>
        </div>

        <button
            type="button"
            class="btn-tambah"
            onclick="bukaModal()"
        >
            ➕ Tambah Pelanggan
        </button>

    </div>


    <div class="table-wrapper">

        <table>

            <tr>

                <th>
                    No
                </th>

                <th>
                    Nama
                </th>

                <th>
                    Alamat
                </th>

                <th>
                    Nomor Telepon
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

                <td class="name">
                    <?= htmlspecialchars($row['NamaPelanggan']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['Alamat']); ?>
                </td>

                <td>

                    <span class="phone">
                        📞 <?= htmlspecialchars($row['NomorTelepon']); ?>
                    </span>

                </td>

            </tr>

            <?php

                }

            } else {

            ?>

            <tr>

                <td
                    colspan="4"
                    class="empty-data"
                >
                    📭 Belum ada data pelanggan.
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>


<!-- MODAL TAMBAH PELANGGAN -->

<div
    class="modal"
    id="modalPelanggan"
>

    <div class="modal-box">

        <button
            type="button"
            class="modal-close"
            onclick="tutupModal()"
        >
            ×
        </button>


        <div class="modal-title">

            <div class="modal-icon">
                👤
            </div>

            <div>

                <h2>
                    Tambah Pelanggan
                </h2>

                <p>
                    Masukkan data pelanggan baru.
                </p>

            </div>

        </div>


        <form method="POST">

            <div class="form-group">

                <label>
                    👤 Nama Pelanggan
                </label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama pelanggan"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    🏠 Alamat
                </label>

                <textarea
                    name="alamat"
                    placeholder="Masukkan alamat pelanggan"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    📞 Nomor Telepon
                </label>

                <input
                    type="text"
                    name="telepon"
                    placeholder="Contoh: 081234567890"
                    required
                >

            </div>


            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                💜 Simpan Pelanggan
            </button>

        </form>

    </div>

</div>


<script>

function bukaModal() {

    document.getElementById("modalPelanggan").style.display = "flex";

}


function tutupModal() {

    document.getElementById("modalPelanggan").style.display = "none";

}


window.onclick = function(event) {

    const modal = document.getElementById("modalPelanggan");

    if (event.target === modal) {
        tutupModal();
    }

};


document.addEventListener("keydown", function(event) {

    if (event.key === "Escape") {
        tutupModal();
    }

});

</script>


</div>

</body>
</html>