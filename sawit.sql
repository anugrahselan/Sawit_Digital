-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 24, 2025 at 03:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sawit`
--

-- --------------------------------------------------------

--
-- Table structure for table `harga_tbs`
--

CREATE TABLE `harga_tbs` (
  `id_harga` int NOT NULL,
  `id_kabupaten` int NOT NULL,
  `tanggal` date NOT NULL,
  `harga_per_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasi_tambahan`
--

CREATE TABLE `informasi_tambahan` (
  `id_info` int NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `konten` text,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_penyakit`
--

CREATE TABLE `jenis_penyakit` (
  `id_penyakit` int NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `gejala` text,
  `solusi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pupuk`
--

CREATE TABLE `jenis_pupuk` (
  `id_pupuk` int NOT NULL,
  `nama_pupuk` varchar(50) NOT NULL,
  `dosis_per_pohon` decimal(10,2) DEFAULT NULL,
  `harga_per_kg` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id_kabupaten` int NOT NULL,
  `nama_kabupaten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kalkulator_panen`
--

CREATE TABLE `kalkulator_panen` (
  `id_kalkulator` int NOT NULL,
  `id_lahan` int DEFAULT NULL,
  `rata_produksi_per_pohon` decimal(10,2) DEFAULT NULL,
  `frekuensi_panen` int DEFAULT NULL,
  `harga_tbs` decimal(10,2) DEFAULT NULL,
  `total_produksi_kg` decimal(15,2) DEFAULT NULL,
  `pendapatan` decimal(15,2) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kalkulator_pupuk`
--

CREATE TABLE `kalkulator_pupuk` (
  `id_kalkulator` int NOT NULL,
  `id_lahan` int DEFAULT NULL,
  `id_pupuk` int DEFAULT NULL,
  `total_pupuk_kg` decimal(10,2) DEFAULT NULL,
  `total_biaya` decimal(15,2) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lahan`
--

CREATE TABLE `lahan` (
  `id_lahan` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `nama_lahan` varchar(100) DEFAULT NULL,
  `luas_ha` decimal(10,2) DEFAULT NULL,
  `jumlah_pohon` int DEFAULT NULL,
  `umur_tanaman` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `harga_tbs`
--
ALTER TABLE `harga_tbs`
  ADD PRIMARY KEY (`id_harga`),
  ADD KEY `id_kabupaten` (`id_kabupaten`);

--
-- Indexes for table `informasi_tambahan`
--
ALTER TABLE `informasi_tambahan`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `jenis_penyakit`
--
ALTER TABLE `jenis_penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `jenis_pupuk`
--
ALTER TABLE `jenis_pupuk`
  ADD PRIMARY KEY (`id_pupuk`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id_kabupaten`),
  ADD UNIQUE KEY `nama_kabupaten` (`nama_kabupaten`);

--
-- Indexes for table `kalkulator_panen`
--
ALTER TABLE `kalkulator_panen`
  ADD PRIMARY KEY (`id_kalkulator`),
  ADD KEY `id_lahan` (`id_lahan`);

--
-- Indexes for table `kalkulator_pupuk`
--
ALTER TABLE `kalkulator_pupuk`
  ADD PRIMARY KEY (`id_kalkulator`),
  ADD KEY `id_lahan` (`id_lahan`),
  ADD KEY `id_pupuk` (`id_pupuk`);

--
-- Indexes for table `lahan`
--
ALTER TABLE `lahan`
  ADD PRIMARY KEY (`id_lahan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `harga_tbs`
--
ALTER TABLE `harga_tbs`
  MODIFY `id_harga` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi_tambahan`
--
ALTER TABLE `informasi_tambahan`
  MODIFY `id_info` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_penyakit`
--
ALTER TABLE `jenis_penyakit`
  MODIFY `id_penyakit` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pupuk`
--
ALTER TABLE `jenis_pupuk`
  MODIFY `id_pupuk` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `id_kabupaten` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kalkulator_panen`
--
ALTER TABLE `kalkulator_panen`
  MODIFY `id_kalkulator` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kalkulator_pupuk`
--
ALTER TABLE `kalkulator_pupuk`
  MODIFY `id_kalkulator` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lahan`
--
ALTER TABLE `lahan`
  MODIFY `id_lahan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `harga_tbs`
--
ALTER TABLE `harga_tbs`
  ADD CONSTRAINT `harga_tbs_ibfk_1` FOREIGN KEY (`id_kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`);

--
-- Constraints for table `kalkulator_panen`
--
ALTER TABLE `kalkulator_panen`
  ADD CONSTRAINT `kalkulator_panen_ibfk_1` FOREIGN KEY (`id_lahan`) REFERENCES `lahan` (`id_lahan`);

--
-- Constraints for table `kalkulator_pupuk`
--
ALTER TABLE `kalkulator_pupuk`
  ADD CONSTRAINT `kalkulator_pupuk_ibfk_1` FOREIGN KEY (`id_lahan`) REFERENCES `lahan` (`id_lahan`),
  ADD CONSTRAINT `kalkulator_pupuk_ibfk_2` FOREIGN KEY (`id_pupuk`) REFERENCES `jenis_pupuk` (`id_pupuk`);

--
-- Constraints for table `lahan`
--
ALTER TABLE `lahan`
  ADD CONSTRAINT `lahan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
