<?php
// Mulai sesi untuk memastikan pengguna login
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.html"); // Jika belum login, arahkan ke halaman login
    exit;
}

// Pengaturan koneksi ke database
$servername = "localhost";
$username = "root"; // Nama pengguna database
$password = ""; // Password database
$dbname = "blog_pribadi"; // Nama database

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek apakah ada ID artikel yang diberikan dalam URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id']; // Ambil ID artikel yang ingin dihapus
    
    // Query untuk menghapus artikel dari database
    $delete_sql = "DELETE FROM articles WHERE id = $article_id";
    
    // Mengeksekusi query
    if ($conn->query($delete_sql) === TRUE) {
        // Jika berhasil, arahkan kembali ke dashboard admin
        header("Location: ./admin_dashboard.php");
        exit;
    } else {
        // Jika terjadi error, tampilkan pesan error
        echo "Error: " . $conn->error;
    }
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Artikel - Blog Pribadi</title>
    <style>
        /* Styling untuk halaman konfirmasi penghapusan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #880808;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .message-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .message-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .message-container p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #666;
        }

        .message-container button {
            background-color: #880808;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .message-container button:hover {
            background-color: #a03a3a;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #880808;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Blog Pribadi</h1>
    </header>
    <main>
        <div class="message-container">
            <h2>Artikel Berhasil Dihapus</h2>
            <p>Artikel yang Anda pilih telah berhasil dihapus. Anda akan diarahkan kembali ke dashboard admin.</p>
            <button onclick="window.location.href = './admin_dashboard.php';">Kembali ke Dashboard</button>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>