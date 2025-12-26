-- Tabel backup untuk menyimpan data harga_tbs yang sudah dihapus
-- Struktur tabel backup sama dengan harga_tbs, ditambah kolom untuk tracking
-- Jalankan script ini di database untuk membuat tabel backup

CREATE TABLE IF NOT EXISTS `harga_tbs_backup` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID backup (AUTO_INCREMENT)',
  `id_harga_original` int(11) DEFAULT NULL COMMENT 'ID dari tabel harga_tbs sebelum dihapus',
  `id_kabupaten` int(11) NOT NULL COMMENT 'ID Kabupaten (sama dengan harga_tbs)',
  `id_perusahaan` int(11) NOT NULL COMMENT 'ID Perusahaan (sama dengan harga_tbs)',
  `tanggal` date NOT NULL COMMENT 'Tanggal harga (sama dengan harga_tbs)',
  `harga_per_kg` decimal(10,2) NOT NULL COMMENT 'Harga per KG (sama dengan harga_tbs)',
  `deleted_at` datetime NOT NULL COMMENT 'Waktu data dihapus',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'ID user yang menghapus data',
  PRIMARY KEY (`id_backup`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_kabupaten_perusahaan` (`id_kabupaten`, `id_perusahaan`),
  KEY `idx_deleted_at` (`deleted_at`),
  KEY `idx_id_harga_original` (`id_harga_original`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel backup untuk data harga_tbs yang sudah dihapus';

