<?php
// Memulai sesi
session_start();

// Menghapus semua variabel sesi yang disimpan
session_unset();

// Menghancurkan sesi untuk menghapus data sesi yang ada
session_destroy();

// Mengarahkan pengguna kembali ke halaman login setelah logout
header("Location: ./login.html");
exit;
?>