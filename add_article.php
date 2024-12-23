<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.html");
    exit;
}

// Pengaturan koneksi database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan pengaturan database Anda
$password = ""; // Sesuaikan dengan pengaturan database Anda
$dbname = "blog_pribadi"; // Sesuaikan dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses penambahan artikel jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $created_at = date('Y-m-d H:i:s');

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO articles (title, content, created_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $created_at); // Mengikat parameter (title, content, created_at)

    // Eksekusi query
    if ($stmt->execute()) {
        // Artikel berhasil ditambahkan
        header("Location: ./admin_dashboard.php"); // Kembali ke dashboard admin
        exit;
    } else {
        // Jika gagal menambahkan artikel
        echo "Error: " . $stmt->error;
    }

    // Menutup prepared statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>