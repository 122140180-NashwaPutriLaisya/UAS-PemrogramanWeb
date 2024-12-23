# UAS - Pemrograman Web

**Nama**: Nashwa Putri Laisya  
**NIM**: 122140180  
**Kelas**: RA [Pemrograman Web]  

---

## Penjelasan Bagian-Bagian Kriteria Penilaian

### **Bagian 1: Client-side Programming (Bobot: 30%)**

#### 1.1 Manipulasi DOM dengan JavaScript (15%)
- **a)** Buat form input dengan minimal 4 elemen input
  - Pada file *add_article.html*, saya membuat elemen-elemen input, antara lain:
    - Input Teks (`<input type="text">`) untuk judul artikel.
    - Textarea (`<textarea>`) untuk konten artikel.
    - Checkbox (`<input type="checkbox">`) untuk menandai artikel sebagai favorit.
    - Radio Buttons (`<input type="radio">`) untuk memilih kategori artikel (Technology, Lifestyle, Health).
    - Select Dropdown (`<select>`) untuk memilih status artikel (Draft atau Published).
  
- **b)** Menampilkan data dari server ke dalam sebuah tabel HTML  
  - Pada *admin_dashboard.php* setiap artikel yang diambil dari database akan ditampilkan dalam sebuah baris `<tr>`.

#### 1.2 Event Handling (15%)
- **a)** Tambahkan minimal 3 event yang berbeda untuk meng-handle form pada 1.1.
  - *login.html* ->  
    - Event 1: `validateForm(event)` = dilakukan ketika form disubmit.  
    - Event 2: `showFocusMessage(event)` = ketika input fokus (di-click), akan menampilkan pesan.  
    - Event 3: `hideFocusMessage(event)` = ketika input kehilangan fokus, maka pesan disembunyikan.
  
- **b)** Implementasikan JavaScript untuk validasi setiap input sebelum diproses oleh PHP.  
  - Di dalam file *login.html* terdapat `validateForm(event)` untuk memastikan pengguna tidak mengirimkan form kosong.

---

### **Bagian 2: Server-side Programming (Bobot: 30%)**

#### 2.1 Pengelolaan Data dengan PHP (20%)
- **a)** Gunakan metode POST atau GET pada formulir  
  - Pada *login.html* dan *add_article.html* terdapat metode POST untuk mengirimkan data.
  
- **b)** Parsing data dari variabel global dan lakukan validasi di sisi server  
  - Di *login.php* sudah terdapat penanganan input pengguna dan sudah menggunakan prepared statements untuk mencegah SQL Injection.
  
- **c)** Simpan ke basis data termasuk jenis browser dan alamat IP pengguna  
  - *login.php* -> Setelah login berhasil (`$_SESSION["loggedin"] = true`), saya menambahkan dua baris untuk menyimpan alamat IP pengguna (`$_SESSION["user_ip"]`) dan jenis browser pengguna (`$_SESSION["user_agent"]`).

#### 2.2 Objek PHP Berbasis OOP (10%)
- **a)** Buat sebuah objek PHP berbasis OOP yang memiliki minimal dua metode dan gunakan objek tersebut dalam skenario tertentu.
  - *article.php*:
    - Class `Database` memiliki dua metode: `__construct` (koneksi) dan `__destruct` (menutup koneksi).
    - Class `Article` memiliki satu metode: `fetchArticle` (mengambil data artikel).
    - Keduanya digunakan untuk mengelola koneksi database dan menampilkan artikel berdasarkan ID yang diterima dari URL, sesuai dengan skenario yang diinginkan.

---

### **Bagian 3: Database Management (Bobot: 20%)**

#### 3.1 Pembuatan Tabel Database (5%)
File *database.sql*:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### **3.2 Konfigurasi Koneksi Database (5%)**
Pengkoneksian database sudah diatur di *login.php, admin_dashboard.php*, dll.

### **3.3 Manipulasi Data pada Database (10%)**
Operasi CRUD sudah ada, seperti Menambah, Memperbarui, dan Menghapus artikel dalam database.

---

### **Bagian 4: State Management (Bobot: 20%)**

#### **4.1 State Management dengan Session (10%)**
- **a)** Gunakan `session_start()` untuk memulai session.  
  `session_start()` digunakan di *login.php, admin_dashboard.php, logout.php*, dll.

- **b)** Simpan informasi pengguna ke dalam session.  
  Info pengguna disimpan dalam sesi setelah login berhasil di *login.php*.

#### **4.2 Pengelolaan State dengan Cookie dan Browser Storage (10%)**
- **a)** Buat fungsi untuk menetapkan, mendapatkan, dan menghapus cookie.  
  Di file *cookieUtils.js* terdapat fungsi:
  - Menetapkan cookie menggunakan `setCookie`.
  - Mendapatkan cookie menggunakan `getCookie`.
  - Menghapus cookie menggunakan `deleteCookie`.

- **b)** Gunakan browser storage untuk menyimpan informasi secara lokal.  
  Pada file *login.html* fungsi `storeDataLocally()` dibuat untuk menyimpan username ke Local Storage dan status login ke Session Storage. Fungsi tersebut dipanggil bersamaan dengan validasi pada atribut `onsubmit` form.

---

### **Bagian Bonus: Hosting Aplikasi Web (Bobot: 20%)**

#### **5%** Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?
- Pilih penyedia hosting (AWS, DigitalOcean, Heroku).
- Siapkan server sesuai kebutuhan (CPU, RAM, OS).
- Deploy aplikasi via FTP atau CI/CD.
- Daftarkan dan arahkan domain ke server.
- Uji aplikasi dan gunakan tools untuk monitoring.
- Terapkan caching dan backup rutin.

#### **5%** Pilih penyedia hosting web yang menurut Anda paling cocok untuk aplikasi web Anda.
- **AWS**: Fleksibel dan skalabel.
- **Heroku**: Mudah digunakan untuk aplikasi kecil.
- **DigitalOcean**: Terjangkau dan dapat disesuaikan.
- **Netlify**: Cocok untuk aplikasi statis dengan CI/CD.

#### **5%** Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?
- Gunakan HTTPS untuk enkripsi data.
- Terapkan firewall dan VPN untuk akses aman.
- Pastikan update keamanan sistem secara rutin.
- Lakukan backup dan siapkan redundansi.
- Gunakan pemantauan keamanan dan autentikasi API.

#### **5%** Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.
- Gunakan web server (Apache/Nginx) untuk menangani trafik.
- Sesuaikan konfigurasi database (MySQL/PostgreSQL).
- Terapkan load balancing untuk trafik tinggi.
- Gunakan caching (Redis/Memcached).
- Manfaatkan environment variables untuk data sensitif.
- Terapkan sistem logging untuk monitoring.

---
