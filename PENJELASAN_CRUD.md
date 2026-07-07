# PENJELASAN IMPLEMENTASI CRUD - BIMBEL ONLINE
**Proyek: Sistem Informasi Bimbel Online (Siswa, Guru, Admin)**
**Panduan Uji Kompetensi LSP - Skema Analis Program**

Dokumen ini menjelaskan bagaimana konsep **CRUD (Create, Read, Update, Delete)** dirancang dan diimplementasikan pada aplikasi Bimbel Online ini menggunakan Framework **CodeIgniter 4**. Penjelasan ini dirancang sederhana agar Anda dapat memaparkannya dengan mudah di hadapan Asesor.

---

## 📌 1. Pembagian Hak Akses (Otorisasi CRUD)
Untuk menjaga keamanan data, hak operasi CRUD dibagi berdasarkan peran (*role*) pengguna:
* **Admin**: Memiliki hak akses penuh **CRUD** untuk data **Siswa**, **Guru**, dan **Mata Pelajaran**.
* **Guru**: Memiliki hak **Read** data siswa & mapel yang diajarnya, serta **Create & Update** untuk **Nilai Siswa**.
* **Siswa**: Hanya memiliki hak **Read** untuk melihat data profil dan transkrip nilai miliknya sendiri, serta **Update** khusus data profil mandiri.

---

## 📂 2. Penjelasan Alur CRUD & Contoh Kode

### 🟢 A. CREATE (Membuat / Menambah Data)
*Create* digunakan untuk menyimpan data baru ke dalam database.
* **Contoh Kasus**: Admin menambah data siswa baru.
* **Kode Program (Controller)**: Terletak di [Admin::siswaStore()](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php#L39-L72)
* **Cara Menjelaskan ke Asesor**:
  1. Pengguna mengisi form input di view [siswa_create.php](file:///D:/LSP/19221112/19221112/app/Views/admin/siswa_create.php).
  2. Saat tombol Submit ditekan, data dikirim melalui metode **POST** ke route `/admin/siswa/store`.
  3. Controller menerima input data (`getVar()`) dan mengenkripsi password default menggunakan `password_hash()`.
  4. Controller memanggil `siswaModel->save()` untuk menyimpan data ke tabel `siswa`.
  5. Sebagai bagian dari integrasi, sistem secara otomatis menginisialisasi baris data nilai baru untuk siswa tersebut di tabel `nilai` dengan nilai default `0`.

---

### 🔵 B. READ (Membaca / Menampilkan Data)
*Read* digunakan untuk mengambil data dari database dan menampilkannya di halaman web.
* **Contoh Kasus**: Menampilkan daftar Mata Pelajaran beserta nama guru pengajarnya.
* **Kode Program (Controller)**: Terletak di [Admin::index()](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php#L24-L34)
* **Cara Menjelaskan ke Asesor**:
  1. Controller menggunakan Query Builder untuk mengambil seluruh data dari tabel `matapelajaran`.
  2. Dilakukan teknik SQL **JOIN** dengan tabel `guru` (`guru.id = matapelajaran.guru_id`) agar nama guru pengajar dapat ditampilkan bersama data mata pelajaran.
  3. Data dikirim ke view [index.php](file:///D:/LSP/19221112/19221112/app/Views/admin/index.php) menggunakan parameter `$data`.
  4. View memproses data tersebut menggunakan perulangan `foreach` untuk memformatnya menjadi tabel HTML Bootstrap yang rapi.

---

### 🟡 C. UPDATE (Mengubah / Memperbarui Data)
*Update* digunakan untuk mengubah data yang sudah ada di database berdasarkan ID unik data tersebut.
* **Contoh Kasus**: Guru mengedit/menginput nilai belajar siswa.
* **Kode Program (Controller)**: Terletak di [Guru::updateNilai()](file:///D:/LSP/19221112/19221112/app/Controllers/Guru.php#L101-L129)
* **Cara Menjelaskan ke Asesor**:
  1. Guru mengeklik tombol "Edit Nilai" pada siswa tertentu di halaman utama portal guru.
  2. Sistem memuat view [edit_nilai.php](file:///D:/LSP/19221112/19221112/app/Views/guru/edit_nilai.php) berisi data siswa dan nilai saat ini berdasarkan ID Siswa & ID Mapel.
  3. Guru mengubah input nilai dan menekan tombol Simpan.
  4. Controller melakukan pengecekan apakah baris nilai sudah ada di tabel `nilai`.
     * Jika **Sudah Ada**, program menjalankan query **UPDATE** pada baris nilai tersebut.
     * Jika **Belum Ada**, program menjalankan query **INSERT** baru.
  5. Setelah sukses, program dialihkan kembali ke halaman utama guru (`redirect()->to('/guru')`) dengan menyertakan pesan sukses (*Flash Data*).

---

### 🔴 D. DELETE (Menghapus Data)
*Delete* digunakan untuk menghapus data dari database.
* **Contoh Kasus**: Admin menghapus data siswa yang sudah keluar.
* **Kode Program (Controller)**: Terletak di [Admin::siswaDelete()](file:///D:/LSP/19221112/19221112/app/Controllers/Admin.php#L98-L103)
* **Cara Menjelaskan ke Asesor**:
  1. Admin mengeklik tombol ikon sampah (Delete) pada baris data siswa di halaman dashboard admin.
  2. Program mengirimkan request penghapusan ke route `/admin/siswa/delete/(:num)`.
  3. Controller memanggil `siswaModel->delete($id)` untuk menghapus data siswa dengan ID yang sesuai di tabel `siswa`.
  4. **Penting (Integritas Data)**: Karena database dikonfigurasi dengan relasi **Foreign Key** dan opsi **ON DELETE CASCADE**, maka saat data siswa dihapus, seluruh data nilai miliknya di tabel `nilai` akan otomatis ikut terhapus di tingkat database secara aman.

---

## 🔒 3. Fitur Keamanan Terintegrasi pada CRUD
1. **CSRF Protection**: Setiap form CRUD dilengkapi dengan token keamanan `<?= csrf_field(); ?>` untuk melindungi aplikasi dari manipulasi request dari pihak ketiga (*Cross-Site Request Forgery*).
2. **Prepared Statements**: Framework CodeIgniter 4 secara otomatis mengamankan query database yang dieksekusi melalui Model/Query Builder untuk menangkal celah keamanan **SQL Injection**.
