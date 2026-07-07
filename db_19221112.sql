CREATE DATABASE IF NOT EXISTS `db_bimbel`;
USE `db_bimbel`;

-- 1. Table structure for table `users` (Admin)
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

-- 2. Table structure for table `guru`
DROP TABLE IF EXISTS `guru`;
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

-- Insert Guru Default (Password: guru123)
INSERT INTO `guru` (`id`, `nip`, `nama`, `email`, `password`) VALUES
(1, '19800101', 'Budi Santoso, S.Pd', 'budi@bimbel.com', '$2y$10$j8D0yY1sZp.i3960w0kYfO5Z1gD2YwG4r5E67v.47wU.6ZJb2z7Ie');

-- 3. Table structure for table `siswa`
DROP TABLE IF EXISTS `siswa`;
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

-- Insert Siswa Default (Password: 2010-10-10)
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `email`, `tanggal_lahir`, `password`) VALUES
(1, '20260001', 'Ahmad Dani', '10-SMA', 'dani@siswa.com', '2010-10-10', '$2y$10$TfRfe31z9XkZJp.u23y4eO9vKkM1B99tB0u1D9W2K8.HefF.5r0ee');

-- 4. Table structure for table `matapelajaran`
DROP TABLE IF EXISTS `matapelajaran`;
CREATE TABLE `matapelajaran` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_mapel` VARCHAR(100) NOT NULL,
  `guru_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`guru_id`) REFERENCES `guru`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Mata Pelajaran Default
INSERT INTO `matapelajaran` (`id`, `nama_mapel`, `guru_id`) VALUES
(1, 'Matematika', 1),
(2, 'Fisika', 1);

-- 5. Table structure for table `nilai`
DROP TABLE IF EXISTS `nilai`;
CREATE TABLE `nilai` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` INT(11) UNSIGNED NOT NULL,
  `mapel_id` INT(11) UNSIGNED NOT NULL,
  `nilai` INT(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`mapel_id`) REFERENCES `matapelajaran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Nilai Default
INSERT INTO `nilai` (`siswa_id`, `mapel_id`, `nilai`) VALUES
(1, 1, 85),
(1, 2, 90);
