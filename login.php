<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "blog_pribadi"; 

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error_message = ''; // Variabel untuk menyimpan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];
    
    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login berhasil
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $inputUsername;

        // Menyimpan informasi IP dan browser pengguna ke dalam session
        $_SESSION["user_ip"] = $_SERVER['REMOTE_ADDR'];  // IP pengguna
        $_SESSION["user_agent"] = $_SERVER['HTTP_USER_AGENT'];  // Browser pengguna

        // Redirect ke halaman admin dashboard
        header("Location: ./admin_dashboard.php"); 
        exit;
    } else {
        // Login gagal: set pesan error
        $error_message = "Username atau Password salah!"; 
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    
    <!-- Styling untuk halaman login -->
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
            padding-top: 50px; /* Memberikan ruang pada header */
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
            padding: 40px 20px;
            max-width: 500px;
            margin: 20px auto; /* Memberikan margin di kanan kiri agar konten terpusat */
            border-radius: 8px; /* Sudut membulat untuk konten */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        }

        /* Styling untuk form login */
        .login-form {
            margin-top: 20px;
        }

        .login-form h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Label untuk input field */
        .login-form label {
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
        }

        /* Input fields styling */
        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc; /* Border halus */
            border-radius: 5px; /* Sudut membulat pada input */
            font-size: 1rem;
        }

        /* Tombol login */
        .login-form button {
            background-color: #880808; /* Warna merah untuk tombol */
            color: #fff; /* Warna teks putih */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Efek saat hover pada tombol */
        .login-form button:hover {
            background-color: #ff6347; /* Warna saat hover */
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

        /* Styling pesan error */
        .error-message {
            color: #f44336;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center; /* Menempatkan pesan error di tengah */
        }
    </style>
</head>
<body>
    <header>
        <h1>Login Admin</h1>
        <nav>
            <a href="index.php" style="color: white; text-decoration: none;">Beranda</a>
        </nav>
    </header>

    <main>
        <section class="login-form">
            <h2>Login Admin</h2>
            
            <!-- Menampilkan pesan error jika login gagal -->
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Form login -->
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Login</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Blog Pribadi</p>
    </footer>
</body>
</html>