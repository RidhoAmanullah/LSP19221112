# LAPORAN PEMETAAN TEKNIS & PANDUAN UJI KOMPETENSI LSP
**Skema Sertifikasi: Analis Program (SKM-2019-62010-02)**
**Studi Kasus Proyek: Sistem Informasi Bimbel Online (Siswa, Guru, Admin)**
**ID Registrasi Asesi: 19221112**

---

## 📌 Pengantar
Laporan ini disusun untuk membantu Anda (**Asesi**) mempresentasikan proyek **Bimbel Online** Anda di hadapan **Asesor** untuk memenuhi 10 Unit Kompetensi dalam skema **Analis Program**. 

Aplikasi Bimbel Online ini dirancang dengan struktur yang bersih, keamanan yang kokoh, dan pembagian hak akses (*Role-based Access Control*) yang jelas antara **Admin**, **Guru**, dan **Siswa**.

---

## 🗄️ 1. Skema Database Lengkap (`db_bimbel`)
Berikut adalah struktur tabel relasional yang digunakan oleh aplikasi Bimbel Online:

```sql
CREATE DATABASE IF NOT EXISTS `db_bimbel`;
USE `db_bimbel`;

-- 1. Tabel Users (untuk Login Admin)
CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Tabel Guru
CREATE TABLE `guru` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nip` VARCHAR(20) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Tabel Siswa
CREATE TABLE `siswa` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nis` VARCHAR(20) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `kelas` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. Tabel Mata Pelajaran
CREATE TABLE `matapelajaran` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_mapel` VARCHAR(100) NOT NULL,
  `guru_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`guru_id`) REFERENCES `guru`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. Tabel Nilai
CREATE TABLE `nilai` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` INT(11) UNSIGNED NOT NULL,
  `mapel_id` INT(11) UNSIGNED NOT NULL,
  `nilai` INT(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mapel_id`) REFERENCES `matapelajaran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

---

## 📈 2. Demonstrasi 10 Unit Kompetensi Pada Proyek Anda

Berikut adalah cara memaparkan masing-masing Unit Kompetensi kepada Asesor menggunakan proyek Bimbel Online Anda:

### 📑 Unit 1: Menganalisis Skalabilitas Perangkat Lunak (J.620100.002.01)
* **Konsep Pemaparan**: Tunjukkan bahwa aplikasi menggunakan framework **CodeIgniter 4** dengan arsitektur **MVC (Model-View-Controller)**. Pemisahan data, logika, dan presentasi ini memungkinkan sistem dikalakan secara modular.
* **Bukti Kode/Struktur**:
  * Tunjukkan file rute [app/Config/Routes.php](file:///D:/LSP/19221112/19221112/app/Config/Routes.php) sebagai pengatur alur sistem terpusat.
  * Jelaskan bahwa untuk skalabilitas tingkat tinggi, database dapat dipisah ke server tersendiri (horizontal scaling), dan kita bisa menerapkan caching (seperti Redis) untuk data yang jarang berubah (seperti daftar mata pelajaran).
* **Jawaban ke Asesor**: *"Sistem ini menggunakan arsitektur MVC. Untuk mendukung skalabilitas, kami memisahkan logika relasional. Jika beban transaksi meningkat, kita dapat menerapkan caching di sisi server untuk data pelajaran dan melakukan pemisahan server database (database replication)."*

---

### 📑 Unit 2: Menggunakan SQL (J.620100.020.02)
* **Konsep Pemaparan**: Tunjukkan pemahaman Anda tentang skema relasional SQL, tipe data, dan integritas referensial (Foreign Key).
* **Bukti Kode/Struktur**:
  * Tunjukkan skema database relasional `db_bimbel` di atas, di mana tabel `nilai` memiliki Relasi Foreign Key ke `siswa` (`siswa_id`) dan `matapelajaran` (`mapel_id`) dengan efek cascade `ON DELETE CASCADE`.
  * Hal ini menjaga integritas data: jika data siswa dihapus, nilainya akan otomatis terhapus secara aman.

---

### 📑 Unit 3: Menerapkan Akses Basis Data (J.620100.021.02)
* **Konsep Pemaparan**: Jelaskan bagaimana aplikasi menghubungkan dan mengambil data dari database secara aman menggunakan konfigurasi `.env` dan Query Builder CodeIgniter 4.
* **Bukti Kode/Struktur**:
  * Tunjukkan file konfigurasi [.env](file:///D:/LSP/19221112/19221112/.env) pada bagian database (baris 33-39) yang menyimpan kredensial database.
  * Tunjukkan penggunaan Query Builder di [app/Controllers/Siswa.php](file:///D:/LSP/19221112/19221112/app/Controllers/Siswa.php):
    ```php
    $db = \Config\Database::connect();
    $grades = $db->table('nilai')->where('siswa_id', $id)->get()->getResultArray();
    ```
  * **Poin Keamanan**: Penggunaan Query Builder di CodeIgniter 4 secara otomatis menggunakan *Prepared Statements* (parameterized queries) yang melindungi aplikasi dari serangan **SQL Injection**.

---

### 📑 Unit 4: Mengimplementasikan Algoritma Pemrograman (J.620100.022.02)
* **Konsep Pemaparan**: Tunjukkan kemampuan Anda mengimplementasikan logika kontrol alur (percabangan dan perulangan) untuk memproses data mentah menjadi informasi terstruktur.
* **Bukti Kode/Struktur**:
  * Tunjukkan fungsi `index()` di [app/Controllers/Siswa.php](file:///D:/LSP/19221112/19221112/app/Controllers/Siswa.php):
    ```php
    $nilaiMap = [];
    foreach ($grades as $g) {
        $nilaiMap[$g['mapel_id']] = $g['nilai'];
    }

    $myGrades = [];
    foreach ($subjects as $sub) {
        $myGrades[] = [
            'nama_mapel' => $sub['nama_mapel'],
            'nama_guru'  => $sub['nama_guru'] ?? 'Belum ada guru',
            'nilai'      => $nilaiMap[$sub['id']] ?? 0
        ];
    }
    ```
  * **Penjelasan Algoritma**: Algoritma ini memetakan nilai dari struktur satu dimensi di database menjadi matriks yang menghubungkan Siswa dengan Mata Pelajaran secara instan tanpa melakukan query berulang (N+1 query problem).

---

### 📑 Unit 5: Membuat Dokumen Kode Program (J.620100.023.02)
* **Konsep Pemaparan**: Tunjukkan bahwa kode Anda telah didokumentasikan dengan baik menggunakan standar komentar (seperti PHPDoc) yang menjelaskan input, proses, output, dan otorisasi program.
* **Bukti Kode/Struktur**:
  * Tunjukkan dokumentasi blok komentar pada kode, misalnya di [app/Controllers/Admin.php](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php).
  * Tunjukkan file penjelasan operasional sistem [PENJELASAN_CRUD.md](file:///D:/LSP/19221112/19221112/PENJELASAN_CRUD.md) sebagai bukti dokumen penjelasan teknis.

---

### 📑 Unit 6: Melakukan Debugging (J.620100.025.02)
* **Konsep Pemaparan**: Tunjukkan bagaimana Anda mengonfigurasi aplikasi untuk mempermudah deteksi kesalahan saat tahap pengembangan dan cara menangani validasi input.
* **Bukti Kode/Struktur**:
  * Tunjukkan baris konfigurasi environment di file [.env](file:///D:/LSP/19221112/19221112/.env#L17):
    ```ini
    CI_ENVIRONMENT = development
    ```
    Konfigurasi ini mengaktifkan mode *whoops* error page dari CodeIgniter 4 yang menampilkan stack trace kesalahan secara detail.
  * Tunjukkan sistem penanganan error logic dengan flashdata untuk memberikan feedback ke pengguna pada [app/Controllers/Auth.php](file:///D:/LSP/19221112/19221112/app/Controllers/Auth.php#L43-L48).

---

### 📑 Unit 7: Melakukan Profiling Program (J.620100.031.01)
* **Konsep Pemaparan**: Jelaskan bahwa ketika `CI_ENVIRONMENT` diset ke `development`, CodeIgniter secara otomatis memuat **Debug Toolbar** di pojok kanan bawah halaman web.
* **Detail Presentasi**:
  * Jelaskan kepada asesor bahwa Debug Toolbar digunakan untuk menganalisis:
    1. **Execution Time**: Waktu muat halaman (milidetik).
    2. **Memory Usage**: Penggunaan memori RAM oleh skrip PHP.
    3. **Database Queries**: Detail kueri SQL yang dieksekusi beserta durasinya.
    4. **History**: Riwayat request sebelumnya untuk mendeteksi anomali performa.

---

### 📑 Unit 8: Menerapkan Code Review (J.620100.032.01)
* **Konsep Pemaparan**: Tunjukkan kepatuhan kode terhadap aspek keamanan dan standar penulisan (PSR-12).
* **Bukti Kode/Struktur**:
  * **Keamanan Form**: Penggunaan Token CSRF (`<?= csrf_field(); ?>`) di form [app/Views/auth/login.php](file:///D:/LSP/19221112/19221112/app/Views/auth/login.php) untuk mencegah eksploitasi Cross-Site Request Forgery.
  * **Kriptografi Password**: Penggunaan hashing satu arah menggunakan standard industri `password_hash($password, PASSWORD_DEFAULT)` (Bcrypt) untuk menyimpan password dengan aman di database.
  * **Clean Code**: Pemisahan otorisasi berdasarkan role (Admin, Guru, Siswa) di `app/Controllers/Admin.php`, `app/Controllers/Guru.php`, dan `app/Controllers/Siswa.php`.

---

### 📑 Unit 9: Melaksanakan Pengujian Unit Program (J.620100.033.02)
* **Konsep Pemaparan**: Tunjukkan kesiapan program untuk diuji secara unit (unit testing) menggunakan PHPUnit.
* **Bukti Kode/Struktur**:
  * Tunjukkan struktur folder [tests/unit/HealthTest.php](file:///D:/LSP/19221112/19221112/tests/unit/HealthTest.php).
  * File ini berisi kode pengujian unit menggunakan PHPUnit untuk memastikan parameter konfigurasi dasar (seperti `baseURL`) tervalidasi dengan benar sebelum aplikasi dijalankan ke server.

---

### 📑 Unit 10: Melaksanakan Pengujian Integrasi Program (J.620100.034.02)
* **Konsep Pemaparan**: Jelaskan bagaimana pengujian integrasi dilakukan untuk memastikan semua komponen (Model, View, Controller, Router, dan Session) bekerja sama dengan baik.
* **Bukti Kode/Struktur**:
  * Tunjukkan file [tests/database/ExampleDatabaseTest.php](file:///D:/LSP/19221112/19221112/tests/database/ExampleDatabaseTest.php) yang menguji integrasi database dalam mode pengujian (`testing` environment).
  * Jelaskan bahwa pengujian integrasi ini berjalan di memori (`:memory:` SQLite) sehingga tidak merusak data produksi saat dijalankan di server CI/CD.

> [!TIP]
> **Penyelesaian Masalah SQLite3 pada XAMPP saat Pengujian:**
> Jika saat menjalankan perintah `vendor/bin/phpunit` Anda menemui error *SQLite3 driver not loaded*, aktifkan ekstensi SQLite3 di XAMPP dengan cara:
> 1. Buka **XAMPP Control Panel** -> klik **Config** di sebelah Apache -> pilih **PHP (php.ini)**.
> 2. Cari baris `;extension=sqlite3` (atau `;extension=php_sqlite3.dll`).
> 3. Hapus tanda titik koma (`;`) di depannya menjadi `extension=sqlite3` (atau `extension=php_sqlite3.dll`).
> 4. Simpan file `php.ini` dan restart Apache di XAMPP.

