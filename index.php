<?php
// Mulai sesi
session_start();

// Pengaturan koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_pribadi";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil artikel
$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Pribadi</title>

    <!-- Menambahkan styling di dalam HTML untuk memperbaiki tampilan halaman -->
    <style>
        /* Reset CSS untuk elemen dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styling untuk body */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4; /* Warna latar belakang halaman */
            color: #333; /* Warna teks */
            padding-top: 50px; /* Memberi ruang pada header */
        }

        /* Header styling */
        header {
            background-color: #880808; /* Warna merah untuk header */
            color: #fff; /* Warna teks putih */
            padding: 20px 0;
            text-align: center;
        }

        /* Judul utama */
        header h1 {
            font-size: 2.5rem;
        }

        /* Navigasi styling */
        nav {
            margin-top: 10px;
        }

        nav a {
            text-decoration: none;
            color: #fff; /* Warna link */
            font-size: 1.2rem;
            margin: 0 15px; /* Menambah jarak antar link */
            transition: color 0.3s ease;
        }

        /* Efek saat hover pada link */
        nav a:hover {
            color: #ff6347; /* Warna saat hover */
        }

        /* Main content styling */
        main {
            background-color: #fff; /* Warna latar belakang utama */
            padding: 40px 0;
        }

        /* Styling untuk section artikel */
        .articles h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Grid untuk artikel */
        .articles {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px; /* Jarak antar artikel */
        }

        /* Styling untuk setiap artikel */
        article {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        }

        /* Judul artikel */
        article h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        /* Styling untuk link artikel */
        article a {
            text-decoration: none;
            color: #880808; /* Warna merah untuk link artikel */
            font-weight: bold;
        }

        /* Efek saat hover pada link artikel */
        article a:hover {
            color: #ff6347; /* Warna saat hover */
        }

        /* Footer styling */
        footer {
            background-color: #880808; /* Warna merah untuk footer */
            color: #fff; /* Warna teks putih */
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Styling untuk footer teks */
        footer p {
            font-size: 1rem;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }

            /* Menata navigasi untuk perangkat lebih kecil */
            nav {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* Menata grid artikel agar menjadi satu kolom pada perangkat kecil */
            .articles {
                grid-template-columns: 1fr;
            }

            /* Menyesuaikan lebar kontainer untuk perangkat kecil */
            .container {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <!-- Bagian header dengan judul dan navigasi -->
    <header>
        <h1>Blog Pribadi</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="login.html">Login</a>
        </nav>
    </header>

    <!-- Bagian utama yang berisi artikel-artikel terbaru -->
    <main>
        <section class="articles">
            <h2>Artikel Terbaru</h2>
            <!-- Artikel akan ditampilkan di sini -->
            <?php
            if ($result->num_rows > 0) {
                // Loop untuk menampilkan setiap artikel
                while ($row = $result->fetch_assoc()) {
                    echo "<article>";
                    echo "<h3><a href='article.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h3>";
                    echo "<p>" . substr(htmlspecialchars($row['content']), 0, 150) . "...</p>"; // Menampilkan ringkasan artikel
                    echo "</article>";
                }
            } else {
                echo "<p>Tidak ada artikel yang tersedia.</p>";
            }
            ?>
        </section>
    </main>

    <!-- Footer halaman -->
    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>