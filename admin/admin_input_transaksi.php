<?php

include "../koneksi.php";
include "admin_header.php";

$data = mysqli_query(
    $koneksi,
    "SELECT
        penjualan.*,
        pelanggan.NamaPelanggan
     FROM penjualan
     LEFT JOIN pelanggan
     ON penjualan.PelangganID = pelanggan.PelangganID
     ORDER BY PenjualanID DESC"
);

?>

<h1>Data Transaksi</h1>

<p class="subtitle">
    Melihat seluruh transaksi penjualan.
</p>

<div class="box">

<table>

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Pelanggan</th>
<th>Total</th>
<th>Aksi</th>

</tr>

<?php

$no = 1;

while ($row = mysqli_fetch_assoc($data)) {

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['TanggalPenjualan']; ?></td>

<td><?= $row['NamaPelanggan']; ?></td>

<td>
Rp <?= number_format(
$row['TotalHarga'],0,',','.'
); ?>
</td>

<td>

<a class="btn btn-purple"
href="cetak_struk.php?id=<?= $row['PenjualanID']; ?>"
target="_blank">
Cetak
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>