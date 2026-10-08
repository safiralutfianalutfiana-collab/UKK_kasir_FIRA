<?php

include "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo "<script>
        alert('ID transaksi tidak ditemukan!');
        window.location='admin_transaksi.php';
    </script>";
    exit;
}

mysqli_begin_transaction($koneksi);

try {

    $cek = mysqli_query(
        $koneksi,
        "SELECT * FROM detailpenjualan
         WHERE PenjualanID='$id'"
    );

    if (mysqli_num_rows($cek) == 0) {
        throw new Exception("Detail transaksi tidak ditemukan.");
    }

    while ($detail = mysqli_fetch_assoc($cek)) {

        $produk_id = $detail['ProdukID'];
        $jumlah = $detail['JumlahProduk'];

        mysqli_query(
            $koneksi,
            "UPDATE produk
             SET Stok = Stok + $jumlah
             WHERE ProdukID='$produk_id'"
        );
    }

    mysqli_query(
        $koneksi,
        "DELETE FROM detailpenjualan
         WHERE PenjualanID='$id'"
    );

    mysqli_query(
        $koneksi,
        "DELETE FROM penjualan
         WHERE PenjualanID='$id'"
    );

    mysqli_commit($koneksi);

    echo "<script>
        alert('Transaksi berhasil dihapus dan stok dikembalikan!');
        window.location='admin_transaksi.php';
    </script>";

    exit;

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    echo "<script>
        alert('Gagal menghapus transaksi!');
        window.location='admin_transaksi.php';
    </script>";

    exit;
}
?>