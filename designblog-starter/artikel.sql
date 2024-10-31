-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 05:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas5a`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(250) NOT NULL,
  `isi` text NOT NULL,
  `kategori` enum('Technology','LifeStyle') NOT NULL,
  `author` varchar(250) NOT NULL,
  `tanggal_publikasi` date NOT NULL,
  `images` varchar(250) NOT NULL,
  `views` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `isi`, `kategori`, `author`, `tanggal_publikasi`, `images`, `views`) VALUES
(6, 'Pemasaran Dalam Era Digital', 'Saat ini makin banyak perusahaan khususnya Lembaga keuangan dalam melakukan kegiatan promosi pemasaran memanfaatkan tren marketing saat ini melalui dunia digital. Sudah banyak kita ketahui bahwa konsumen saat ini menginginkan pelayanan yang serba cepat dan sesuai dengan kebutuhannya menggunakan aplikasi atau bahkan beberapa perusahaan besar menyebutnya Super Apps.\r\n\r\nSeiring dengan itu promosi pemasaran melalui kanal digital menghasilkan jangkauan yang lebih luas dan membantu mencapai tujuan bisnis perusahaan. Beberapa kanal digital untuk promosi pemasaran baik yang gratis maupun berbayar telah banyak kita kenal.  Beberapa contoh strategi promosi pemasaran digital diantaranya adalah :\r\n\r\nMenggunakan Media Sosial\r\nHampir semua orang yang menggunakan Smarphone saat ini menggunakan social media dalam berinteraksi dengan orang lain bahkan mencari informasi tentang hal baru di social media. Beberapa contoh Sosmed yang dapat digunakan sebagai sarana promosi antara lain Instagram, Youtube, Facebook, Twitter\r\n\r\nMelalui Website\r\nSebelum era medsos penggunaan website sudah terlebih dulu dipakai oleh banyak perusahaan sebagai sarana promosi perusahaan. Dan sampai saat ini  website masih dipergunakan oleh banyak perusahaan sebagai representasi wajah perusahaan.\r\n\r\nMembuat Konten Menarik\r\nIstilah konten sering kita dengar. Perbanyak konten menjadi salah satu cara kita mempresentasikan tentang diri kita agar lebih dikenal. Demikian juga dengan branding terhadap produk maupun perusahaan kita dengan tujuan produk semakin dikenal.\r\n\r\nMenggunakan Influencer\r\nPada saat ini influencer sangatlah berpengaruh untuk meningkatkan penjualan. Influencer memiliki banyak pengikut di akun media sosialnya, hal inilah yang menjadi alasan mengapa promosi menggunakan jasa influencer sangatlah efektif.\r\n\r\nGiveaway\r\nGiveaway menjadi senjata ampuh untuk menarik konsumen untuk membeli produk yang ditawarkan.  Giveaway biasanya berupa hadiah maupun uang tunai melalui media sosial seperti Instagram.  Dengan makin banyak giveaway yang diberikan menjadikan produk makin dikenal oleh masyarakat umum.\r\n\r\nProgram Membership\r\nMenjaga keberlangsungan pelanggan agar terus menggunakan produk kita, strategi marketing selanjutnya dapat menerapkan program membership. Dalam program membership tersebut.\r\n\r\nSemakin aktif kita dalam mempromosikan perusahaan kita ataupun produk kita kepada konsumen atau maupun masyarakat luas menjadikan produk kita menjadi salah satu top of mind ketika mereka membutuhkan produk yang diperlukan.', 'Technology', 'Rachmat Roly Suyono', '2024-10-12', 'uploads/1730388499_technology1.png', 1),
(11, 'What is metaverse', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Technology', 'Johnson smith', '2024-10-04', 'uploads/1730389436_technology2.png', 0),
(12, 'Journal Joi-Tech', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Technology', 'Johnson smith', '2024-10-07', 'uploads/1730389494_technology3.jpeg', 0),
(13, 'Smart Techno', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Technology', 'Johnson smith', '2024-10-09', 'uploads/1730389552_technology4.jpg', 0),
(14, 'F-Ture Tech', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Technology', 'Johnson smith', '2024-10-13', 'uploads/1730389599_technology5.png', 0),
(15, 'Widya Analtic', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'Technology', 'Johnson smith', '2024-10-16', 'uploads/1730389642_technology6.jpeg', 3),
(16, 'Here are a few tips that will help you to get started about lifestyle', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-10-18', 'uploads/1730389964_lifestyle1.png', 0),
(17, 'Before you start writing first blog post, you should make a content plan.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-10-23', 'uploads/1730389976_lifestyle2.jpeg', 0),
(18, 'Guidelines to help you decide what your blog post should be about.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-11-05', 'uploads/1730389946_lifestyle3.png', 1),
(19, 'Now, Make money from blogging in easy steps', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-11-07', 'uploads/1730390022_lifestyle4.jpeg', 0),
(20, 'Here are a few tips that will help you to get started about lifestyle', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-11-10', 'uploads/1730390083_lifestyle5.png', 1),
(21, 'Many ways by which your blog can earn passive income for you.', 'Lorem ipsum dolor sit amet consectetur ipsum adipisicing elit. Qui eligendi vitae sit.', 'LifeStyle', 'Johnson smith', '2024-11-16', 'uploads/1730390136_lifestyle6.jpeg', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
