<?php
session_start();

// Memeriksa apakah sesi login valid
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.html"); // Arahkan ke halaman login jika belum login
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "blog_pribadi"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Jika gagal, tampilkan pesan error
}

// Ambil artikel dari database
$sql = "SELECT id, title, created_at FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Styling untuk halaman dashboard -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9; /* Warna latar belakang yang lembut */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #880808; /* Warna header merah tua */
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .dashboard {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard a {
            display: inline-block;
            background-color: #880808;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .dashboard a:hover {
            background-color: #cc0000;
        }

        .dashboard h3 {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #880808;
            color: white;
        }

        .btn-edit-delete {
            display: inline-block;
            background-color: #880808;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #880808;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>

    <script>
        // Ambil data dari Local Storage
        const username = localStorage.getItem("username");
        const isLoggedIn = sessionStorage.getItem("isLoggedIn");

        // Tampilkan pesan jika pengguna login
        if (isLoggedIn) {
            alert(`Selamat datang kembali, ${username}!`);
        }
    </script>
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
        <nav>
            <!-- Menambahkan navigasi untuk ke halaman Beranda dan Logout -->
            <a href="index.php">Beranda</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <!-- Menyapa admin yang login -->
            <h2>Selamat datang, <?php echo $_SESSION["username"]; ?>!</h2>

            <!-- Link untuk menambah artikel -->
            <a href="add_article.html" class="btn">Tambah Artikel</a>

            <!-- Menampilkan daftar artikel yang sudah dipublikasikan -->
            <h3>Artikel yang sudah dipublikasikan:</h3>
            
            <!-- Tabel Artikel -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Tanggal Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memeriksa apakah ada artikel yang dipublikasikan
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Menampilkan artikel dengan link ke halaman detail dan opsi edit atau hapus
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td><a href='article.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></td>
                                    <td>" . $row["created_at"] . "</td>
                                    <td>
                                        <a href='edit_article.php?id=" . $row["id"] . "' class='btn-edit-delete'>Edit</a> | 
                                        <a href='delete_article.php?id=" . $row["id"] . "' class='btn-edit-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus artikel ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        // Jika belum ada artikel, tampilkan pesan
                        echo "<tr><td colspan='4'>Belum ada artikel yang dipublikasikan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi ke database setelah selesai
?>