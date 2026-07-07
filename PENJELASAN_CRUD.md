# PENJELASAN IMPLEMENTASI CRUD - PMB STKIP SINGKAWANG
**Proyek: Sistem Informasi Penerimaan Mahasiswa Baru (Calon, Penguji, Admin)**
**Panduan Uji Kompetensi LSP - Skema Analis Program**

Dokumen ini menjelaskan bagaimana konsep **CRUD (Create, Read, Update, Delete)** dirancang dan diimplementasikan pada aplikasi PMB STKIP Singkawang menggunakan Framework **CodeIgniter 4**. Panduan ini dirancang agar Anda dapat memaparkannya dengan mudah di hadapan Asesor.

---

## 📌 1. Pembagian Hak Akses (Otorisasi CRUD)
Untuk menjaga keamanan data seleksi pendaftaran, operasi CRUD dibatasi sebagai berikut:
* **Admin (Panitia PMB)**: Memiliki hak akses penuh **CRUD** untuk data **Calon Mahasiswa**, **Dosen Penguji**, dan **Program Studi** (termasuk mengubah status kelulusan calon mahasiswa).
* **Penguji (Dosen Penguji)**: Memiliki hak **Read** data calon mahasiswa & mata uji yang diujinya, serta **Create & Update** untuk **Nilai Hasil Ujian Seleksi**.
* **Calon Mahasiswa**: Hanya memiliki hak **Read** untuk melihat data profil pendaftaran, status kelulusan, dan nilai ujian masuk miliknya sendiri, serta **Update** khusus data profil mandirinya.

---

## 📂 2. Penjelasan Alur CRUD & Contoh Kode

### 🟢 A. CREATE (Membuat / Menambah Data)
*Create* digunakan untuk menyimpan data pendaftaran baru ke database.
* **Contoh Kasus**: Calon Mahasiswa mendaftar PMB secara online.
* **Kode Program (Controller)**: Terletak di [Auth::registerProcess()](file:///D:/LSP/19221112/19221112/app/Controllers/Auth.php#L130-L167)
* **Cara Menjelaskan ke Asesor**:
  1. Calon mahasiswa mengisi form di view [register.php](file:///D:/LSP/19221112/19221112/app/Views/auth/register.php).
  2. Saat tombol diklik, data dikirim menggunakan metode **POST** ke route `/register/process`.
  3. Controller secara otomatis membuat **Nomor Pendaftaran** unik dengan format `PMB2026xxxx` (ditentukan dari ID pendaftar terakhir).
  4. Password pendaftar dienkripsi menggunakan `password_hash()` (default-nya adalah tanggal lahir).
  5. Controller memanggil `calonModel->save()` untuk menyimpan data ke tabel `calon_mahasiswa`.
  6. Sistem otomatis menyisipkan data nilai default `0` untuk mata seleksi pendaftar tersebut di tabel `nilai_seleksi`.

---

### 🔵 B. READ (Membaca / Menampilkan Data)
*Read* digunakan untuk menampilkan data dari database secara terstruktur.
* **Contoh Kasus**: Menampilkan daftar pendaftar beserta pilihan Program Studi mereka.
* **Kode Program (Controller)**: Terletak di [Admin::index()](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php#L26-L37)
* **Cara Menjelaskan ke Asesor**:
  1. Controller menggunakan Query Builder untuk memuat seluruh pendaftar.
  2. Diterapkan kueri **JOIN** antara tabel `calon_mahasiswa` dan `program_studi` (`program_studi.id = calon_mahasiswa.prodi_id`) agar nama program studi pilihan pendaftar dapat dibaca secara relasional.
  3. Data tersebut dikirim ke view [index.php](file:///D:/LSP/19221112/19221112/app/Views/admin/index.php) menggunakan parameter `$data`.
  4. View merender baris data ke dalam tabel HTML Bootstrap menggunakan perulangan `foreach`.

---

### 🟡 C. UPDATE (Mengubah / Memperbarui Data)
*Update* digunakan untuk memodifikasi data yang sudah tersimpan di database berdasarkan ID uniknya.
* **Contoh Kasus**: Dosen Penguji menginput atau mengubah nilai hasil tes masuk calon mahasiswa.
* **Kode Program (Controller)**: Terletak di [Penguji::updateNilai()](file:///D:/LSP/19221112/19221112/app/Controllers/Penguji.php#L106-L134)
* **Cara Menjelaskan ke Asesor**:
  1. Dosen Penguji mengeklik tombol "Input/Edit Nilai" pada tabel pendaftar di portal dosen.
  2. View [edit_nilai.php](file:///D:/LSP/19221112/19221112/app/Views/penguji/edit_nilai.php) memuat data nilai yang ada.
  3. Penguji memasukkan nilai baru (0-100) dan mengirimkan form.
  4. Controller mengecek keberadaan data nilai pendaftar di tabel `nilai_seleksi`:
     * Jika **Sudah Ada**, program melakukan query **UPDATE**.
     * Jika **Belum Ada**, program melakukan query **INSERT** baru.
  5. Pengguna dialihkan kembali ke dashboard penguji (`redirect()->to('/penguji')`) dengan pesan sukses.

---

### 🔴 D. DELETE (Menghapus Data)
*Delete* digunakan untuk menghapus data dari database.
* **Contoh Kasus**: Admin menghapus data calon mahasiswa yang membatalkan pendaftaran.
* **Kode Program (Controller)**: Terletak di [Admin::calonDelete()](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php#L104-L109)
* **Cara Menjelaskan ke Asesor**:
  1. Admin mengeklik tombol ikon hapus pada siswa tertentu di panel admin.
  2. Data dikirim ke route `/admin/calon/delete/(:num)`.
  3. Controller memanggil `calonModel->delete($id)` untuk menghapus baris bersangkutan dari tabel `calon_mahasiswa`.
  4. **Penting (Relasi Integrity)**: Karena tabel `nilai_seleksi` dikonfigurasi dengan relasi **Foreign Key** menggunakan opsi **ON DELETE CASCADE**, seluruh baris nilai ujian milik calon mahasiswa tersebut otomatis ikut terhapus di tingkat database demi integritas data.

---

## 🔒 3. Fitur Keamanan Terintegrasi pada CRUD
1. **CSRF Protection**: Setiap form dilengkapi dengan token keamanan `<?= csrf_field(); ?>` untuk memvalidasi bahwa request berasal dari form resmi aplikasi STKIP Singkawang.
2. **Prepared Statements**: Framework CodeIgniter 4 mengamankan query database yang dieksekusi melalui Model/Query Builder untuk menangkal celah keamanan **SQL Injection**.
