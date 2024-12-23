<?php
// Mulai sesi
session_start();

// Class untuk koneksi database
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "blog_pribadi";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

// Class untuk artikel
class Article {
    private $db;
    private $id;

    public function __construct($db, $id) {
        $this->db = $db;
        $this->id = $id;
    }

    public function fetchArticle() {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

// Pastikan ada parameter id dalam URL
if (!isset($_GET['id'])) {
    echo "ID artikel tidak ditemukan!";
    exit;
}

$article_id = $_GET['id'];

// Inisialisasi koneksi dan objek
$db = new Database();
$articleObj = new Article($db, $article_id);
$article = $articleObj->fetchArticle();

if (!$article) {
    echo "Artikel tidak ditemukan!";
    exit;
}

// Set zona waktu sesuai kebutuhan
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>

    <!-- Menambahkan styling di dalam HTML untuk halaman detail artikel -->
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
            background-color: #f4f4f4;
            color: #333;
            padding-top: 50px;
        }

        /* Header styling */
        header {
            background-color: #880808;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
        }

        /* Navigasi styling */
        nav {
            margin-top: 10px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            font-size: 1.2rem;
            margin: 0 15px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ff6347;
        }

        /* Main content styling */
        main {
            background-color: #fff;
            padding: 40px 20px;
            max-width: 900px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk artikel */
        article {
            margin-bottom: 30px;
        }

        article h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        article p em {
            font-size: 1rem;
            color: #888;
        }

        article p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #880808;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #ff6347;
        }

        footer {
            background-color: #880808;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Blog Pribadi</h1>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="login.html">Login</a>
        </nav>
    </header>

    <main>
        <article>
            <h2><?php echo htmlspecialchars($article['title']); ?></h2>
            <p><em>Dipublikasikan pada: <?php echo date("d F Y, H:i", strtotime($article['created_at'])); ?></em></p>
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
        </article>
        <a href="index.php" class="btn">Kembali ke Beranda</a>
    </main>

    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>