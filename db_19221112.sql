CREATE DATABASE IF NOT EXISTS `db_pmb_stkip`;
USE `db_pmb_stkip`;

-- 1. Table structure for table `users` (Admin Panitia PMB)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Admin Default (Password: admin123)
INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$vK6n751u58B7eXhS4Gfeee94Vb4B8r5.UvKkM1B99tB0u1D9W2K8.');

-- 2. Table structure for table `penguji` (Dosen Penguji / Pewawancara STKIP)
DROP TABLE IF EXISTS `penguji`;
CREATE TABLE `penguji` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nip` VARCHAR(20) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Penguji Default (Password: penguji123)
INSERT INTO `penguji` (`id`, `nip`, `nama`, `email`, `password`) VALUES
(1, '19900101', 'Dr. H. Andi Wijaya, M.Pd', 'andi@stkipsingkawang.ac.id', '$2y$10$6R6VpC6Q5Q9J0Z8y9r.T6O7Vb4B8r5.UvKkM1B99tB0u1D9W2K8.');

-- 3. Table structure for table `program_studi` (Program Studi di STKIP Singkawang)
DROP TABLE IF EXISTS `program_studi`;
CREATE TABLE `program_studi` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_prodi` VARCHAR(100) NOT NULL,
  `jenjang` VARCHAR(10) NOT NULL DEFAULT 'S1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Program Studi STKIP Singkawang
INSERT INTO `program_studi` (`id`, `nama_prodi`, `jenjang`) VALUES
(1, 'Pendidikan Guru Sekolah Dasar (PGSD)', 'S1'),
(2, 'Pendidikan Bahasa Indonesia', 'S1'),
(3, 'Pendidikan Matematika', 'S1'),
(4, 'Pendidikan Fisika', 'S1'),
(5, 'Pendidikan Bimbingan Konseling (BK)', 'S1');

-- 4. Table structure for table `calon_mahasiswa` (Pendaftar PMB)
DROP TABLE IF EXISTS `calon_mahasiswa`;
CREATE TABLE `calon_mahasiswa` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_pendaftaran` VARCHAR(20) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `asal_sekolah` VARCHAR(100) NOT NULL,
  `prodi_id` INT(11) UNSIGNED NOT NULL,
  `status_seleksi` ENUM('pending', 'lulus', 'tidak lulus') NOT NULL DEFAULT 'pending',
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`prodi_id`) REFERENCES `program_studi`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Calon Mahasiswa Default (Password: 2005-05-15)
INSERT INTO `calon_mahasiswa` (`id`, `nomor_pendaftaran`, `nama`, `email`, `tanggal_lahir`, `asal_sekolah`, `prodi_id`, `status_seleksi`, `password`) VALUES
(1, 'PMB20260001', 'Rian Hidayat', 'rian@gmail.com', '2005-05-15', 'SMA Negeri 1 Singkawang', 1, 'pending', '$2y$10$t2m.sK7G.7p8iW2kQY6xreO9vKkM1B99tB0u1D9W2K8.HefF.5r0ee');

-- 5. Table structure for table `mata_uji` (Mata Uji Seleksi Masuk STKIP)
DROP TABLE IF EXISTS `mata_uji`;
CREATE TABLE `mata_uji` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_ujian` VARCHAR(100) NOT NULL,
  `penguji_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`penguji_id`) REFERENCES `penguji`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Mata Uji Default
INSERT INTO `mata_uji` (`id`, `nama_ujian`, `penguji_id`) VALUES
(1, 'Tes Potensi Akademik (TPA)', 1),
(2, 'Tes Wawancara & Minat Bakat', 1);

-- 6. Table structure for table `nilai_seleksi`
DROP TABLE IF EXISTS `nilai_seleksi`;
CREATE TABLE `nilai_seleksi` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `calon_id` INT(11) UNSIGNED NOT NULL,
  `mata_uji_id` INT(11) UNSIGNED NOT NULL,
  `nilai` INT(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`calon_id`) REFERENCES `calon_mahasiswa`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mata_uji_id`) REFERENCES `mata_uji`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Nilai Default untuk Rian
INSERT INTO `nilai_seleksi` (`calon_id`, `mata_uji_id`, `nilai`) VALUES
(1, 1, 80),
(1, 2, 85);
