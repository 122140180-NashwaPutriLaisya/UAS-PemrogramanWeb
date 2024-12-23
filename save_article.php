<?php
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.html"); // Arahkan ke halaman login jika belum login
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

// Pastikan data yang diterima dari form ada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title']; // Mengambil judul artikel dari form
    $content = $_POST['content']; // Mengambil konten artikel dari form

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content); // Mengikat parameter (title, content)

    // Eksekusi query
    if ($stmt->execute()) {
        // Artikel berhasil disimpan, arahkan ke dashboard admin
        header("Location: ./admin_dashboard.php");
        exit;
    } else {
        // Jika gagal menyimpan artikel
        echo "Error: " . $stmt->error;
    }

    // Menutup prepared statement
    $stmt->close();
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel - Blog Pribadi</title>
    <style>
        /* Styling untuk form */
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

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #880808;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
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
        <div class="form-container">
            <h2>Tambah Artikel</h2>
            <form action="save_article.php" method="POST">
                <!-- Form untuk menambah artikel -->
                <label for="title">Judul Artikel:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">Konten Artikel:</label>
                <textarea id="content" name="content" rows="6" required></textarea>

                <button type="submit">Simpan Artikel</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>