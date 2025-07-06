# Aplikasi Manajemen Inventaris Sederhana

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-8892BF.svg)

Aplikasi Manajemen Inventaris Sederhana adalah sebuah sistem berbasis web yang dirancang untuk membantu pengelolaan barang inventaris secara digital. Aplikasi ini menyediakan fungsionalitas dasar untuk pencatatan, pemantauan, dan manajemen data inventaris, serta dilengkapi dengan sistem autentikasi pengguna.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Proyek](#struktur-proyek)
- [Diagram Perancangan Sistem](#diagram-perancangan-sistem)
  - [Entity Relationship Diagram (ERD)](#entity-relationship-diagram-erd)
  - [Use Case Diagram](#use-case-diagram)
  - [Activity Diagram](#activity-diagram)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Panduan Instalasi](#panduan-instalasi)
- [Penggunaan Aplikasi](#penggunaan-aplikasi)
- [Kontributor](#kontributor)
- [Lisensi](#lisensi)

## Fitur Utama

Aplikasi ini dilengkapi dengan fitur-fitur inti untuk manajemen inventaris:

-   **Manajemen Produk (CRUD):** Memungkinkan penambahan, melihat daftar dan detail, pengubahan, serta penghapusan data barang inventaris.
-   **Sistem Otentikasi Pengguna:** Fungsi login dan logout yang aman untuk mengelola akses ke sistem.
-   **Pembatasan Akses Berbasis Peran:** Fitur administratif (CRUD produk, pendaftaran pengguna baru) hanya dapat diakses oleh pengguna dengan peran 'admin'.
-   **Pesan Feedback Pengguna:** Memberikan notifikasi visual kepada pengguna mengenai status setiap operasi (sukses atau error).
-   **Efek Dinamis Title Bar:** Implementasi JavaScript sederhana untuk efek teks berjalan pada title bar browser.

## Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan kombinasi teknologi web *open-source*:

-   **Backend:** PHP (Native)
-   **Database:** MySQL
-   **Web Server:** Apache (melalui Laragon)
-   **Frontend:** HTML, CSS, JavaScript (Vanilla JS)
-   **Lingkungan Pengembangan:** Laragon

## Struktur Proyek

Struktur direktori proyek diorganisir untuk memisahkan logika aplikasi dari file yang dapat diakses publik:

inventaris_app/
├── app/                  # Logika inti aplikasi, actions, dll.

├── config/               # File konfigurasi, terutama database.

├── public/               # File yang dapat diakses publik (index.php, login.php, css/, js/)

│   ├── css/              # File CSS untuk styling

│   │   └── style.css

│   ├── index.php         # Halaman utama (daftar inventaris)

│   ├── login.php         # Halaman login

│   ├── create.php        # Halaman tambah produk

│   └── edit.php          # Halaman edit produk

├── indeks.php

## Diagram Perancangan Sistem

### Entity Relationship Diagram (ERD)

Menggambarkan struktur database aplikasi.

![ERD Aplikasi Inventaris](https://github.com/Gustri38/aplikasi-manajemen-inventaris-sederhana/blob/main/docs/ERD.png)

### Use Case Diagram

Memodelkan fungsionalitas sistem dari sudut pandang pengguna.

![Use Case Diagram Aplikasi Inventaris](https://github.com/Gustri38/aplikasi-manajemen-inventaris-sederhana/blob/main/docs/Use%20Case.png)

### Activity Diagram

Menggambarkan alur kerja langkah demi langkah untuk fungsi kunci.

#### Alur Aktivitas Login

![Activity Diagram Login](https://github.com/Gustri38/aplikasi-manajemen-inventaris-sederhana/blob/main/docs/Activity%201.png)

#### Alur Aktivitas Tambah Produk (Oleh Admin)

![Activity Diagram Tambah Produk](https://github.com/Gustri38/aplikasi-manajemen-inventaris-sederhana/blob/main/docs/Activity%202.png)

## Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut untuk menjalankan aplikasi:

-   Web Server (Apache direkomendasikan)
-   PHP versi 7.4 atau lebih tinggi
-   MySQL versi 8.0 atau lebih tinggi
-   Browser web modern (Chrome, Firefox, Edge, Safari)

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi secara lokal:

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/Gustri38/aplikasi-manajemen-inventaris-sederhana.git
    cd aplikasi-manajemen-inventaris-sederhana
    ```

2.  **Konfigurasi Web Server (Laragon/XAMPP/MAMP):**
    -   Jika menggunakan **Laragon**:
        -   Pindahkan folder `inventaris_app` ke dalam direktori `www` Laragon.
        -   Klik kanan pada Laragon, pilih `Apache > Sites > Add Apache Virtual Host`.
        -   Masukkan `inventaris_app.test` sebagai nama host dan arahkan `Document Root` ke `[Laragon_Path]\www\inventaris_app\public`.
        -   Restart Apache dan MySQL melalui Laragon.
    -   Jika menggunakan **XAMPP/MAMP**:
        -   Pindahkan folder `inventaris_app` ke dalam direktori `htdocs` (XAMPP) atau `htdocs`/`Applications/MAMP/htdocs` (MAMP).
        -   Akses melalui `http://localhost/inventaris_app/public` atau konfigurasikan Virtual Host secara manual untuk `http://inventaris_app.test`.

3.  **Konfigurasi Database:**
    -   Buka phpMyAdmin atau MySQL client lainnya.
    -   Buat database baru, contoh: `inventaris_db`.
    -   Impor skema database dari file SQL yang Anda miliki (misalnya, `database.sql` di folder `config/` atau `sql/`). Jika belum ada, Anda perlu membuat tabel `user` dan `product` secara manual sesuai ERD.

    **Contoh Struktur Tabel (SQL):**

    ```sql
    -- Tabel User
    CREATE TABLE user (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'user', -- 'admin' atau 'user'
        create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabel Product
    CREATE TABLE product (
        kode_aset VARCHAR(50) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        location VARCHAR(255),
        responsible_person_name VARCHAR(255),
        create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES user(ID) ON DELETE SET NULL
    );

    -- Contoh data awal (Admin)
    INSERT INTO user (username, password, role) VALUES ('admin', '$2y$10$YourHashedPasswordHere', 'admin');
    -- Ganti '$2y$10$YourHashedPasswordHere' dengan hash password 'admin' yang sesungguhnya
    ```

4.  **Konfigurasi Koneksi Database di Aplikasi:**
    -   Buka file koneksi database Anda (misalnya `config/database.php` atau `app/config.php`).
    -   Sesuaikan kredensial database (hostname, username, password, nama database) agar sesuai dengan konfigurasi MySQL lokal Anda.

    ```php
    // Contoh konfigurasi database (sesuaikan dengan file Anda)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root'); // Ganti dengan username MySQL Anda
    define('DB_PASS', '');     // Ganti dengan password MySQL Anda
    define('DB_NAME', 'inventaris_db'); // Ganti dengan nama database Anda

    // Contoh koneksi (sesuaikan dengan implementasi Anda)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    ```

5.  **Akses Aplikasi:**
    -   Buka browser web Anda dan akses URL aplikasi: `http://inventaris_app.test` (jika menggunakan Virtual Host Laragon) atau `http://localhost/inventaris_app/public`.

## Penggunaan Aplikasi

1.  **Login:** Akses halaman login (`login.php`) untuk masuk ke sistem.
    -   **Admin Default:**
        -   Username: `admin`
        -   Password: `admin` (atau sesuai yang Anda atur/hash di database)
2.  **Manajemen Inventaris:** Setelah login sebagai Admin, Anda dapat:
    -   Melihat daftar produk.
    -   Menambah produk baru.
    -   Mengedit detail produk.
    -   Menghapus produk.
3.  **Manajemen Pengguna:** Admin juga dapat mendaftarkan pengguna baru.

## Kontributor

-   Gustri Dede Putra (https://github.com/Gustri38)
-   My linkedin (https://www.linkedin.com/in/gustri-dede-putra-611178141)

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.
