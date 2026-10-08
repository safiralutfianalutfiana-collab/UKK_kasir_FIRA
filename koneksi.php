<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "db_kasir_skincare";
$port = 3306;

$koneksi = mysqli_init();

mysqli_options($koneksi, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

if (!mysqli_real_connect($koneksi, $host, $user, $pass, $db, $port)) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");

?>