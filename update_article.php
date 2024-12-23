<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ./login.html");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_pribadi";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Query untuk memperbarui artikel
    $sql = "UPDATE articles SET title='$title', content='$content' WHERE id=$id";

    // Mengeksekusi query
    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, arahkan kembali ke dashboard
        header("Location: ./admin_dashboard.php"); 
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Artikel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #880808; /* Warna merah tua */
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: inline-block;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            padding: 12px 20px;
            background-color: #880808; /* Warna merah tua */
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff4d4d; /* Warna merah lebih terang saat hover */
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #880808; /* Warna merah tua */
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Update Artikel</h1>
    </header>
    <main>
        <!-- Form untuk memperbarui artikel -->
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"> <!-- ID artikel untuk mengupdate -->
            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="<?php echo $article['title']; ?>" required>

            <label for="content">Konten:</label>
            <textarea id="content" name="content" rows="10" required><?php echo $article['content']; ?></textarea>

            <button type="submit">Perbarui Artikel</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>