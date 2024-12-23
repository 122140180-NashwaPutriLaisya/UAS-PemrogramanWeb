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

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    
    // Ambil data artikel berdasarkan ID
    $sql = "SELECT title, content FROM articles WHERE id = $article_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];
    
    // Update artikel
    $update_sql = "UPDATE articles SET title = '$new_title', content = '$new_content' WHERE id = $article_id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: ./admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <style>
        /* Styling untuk bagian utama halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
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

        /* Styling form */
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
            background-color: #880808;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff4d4d;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #880808;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Artikel</h1>
    </header>
    <main>
        <!-- Form untuk mengedit artikel -->
        <form method="POST">
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

<?php
$conn->close();
?>