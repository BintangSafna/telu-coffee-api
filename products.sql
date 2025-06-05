-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2025 pada 16.46
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telu_coffee`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `imageUrl` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `imageUrl`, `category`) VALUES
('1', 'Kopi Susu Gula Aren', 18000, 'https://i.ibb.co/rKnwGBV9/kopi-susu-gula-aren.jpg', 'Espresso Based'),
('10', 'MatchaPresso', 20000, 'https://i.ibb.co/RpGZQVwY/matcha-espresso.jpg', 'Espresso Based'),
('11', 'RedPresso', 20000, 'https://i.ibb.co/DPTKWfhK/redvelvet-espresso.jpg', 'Espresso Based'),
('12', 'TaroPresso', 20000, 'https://i.ibb.co/DHvnLHfd/taro-espresso.jpg', 'Espresso Based'),
('13', 'Avocado Coffee', 20000, 'https://i.ibb.co/pvG7rSR6/avocado-coffe.jpg', 'Espresso Based'),
('14', 'Matcha', 15000, 'https://i.ibb.co/kV6J0xGJ/matcha.jpg', 'NonCoffee'),
('15', 'Red Velvet', 15000, 'https://i.ibb.co/6c28B7H8/redvelvet.jpg', 'NonCoffee'),
('16', 'Taro', 15000, 'https://i.ibb.co/cKfpbCD9/taro.jpg', 'NonCoffee'),
('17', 'Choco', 15000, 'https://i.ibb.co/5WG4JcHh/choco.jpg', 'NonCoffee'),
('18', 'Jasmine Tea Jumbo', 15000, 'https://i.ibb.co/sJMnnvTL/jasmine-tea.jpg', 'Tea'),
('19', 'Lychee Tea Jumbo', 22000, 'https://i.ibb.co/23sCqt1J/lychee-tea.jpg', 'Tea'),
('2', 'Americano', 15000, 'https://i.ibb.co/qL6PThDV/americano.jpg', 'Espresso Based'),
('20', 'Lemon Tea Jumbo', 20000, 'https://i.ibb.co/rKbCmCTv/lemon-tea.jpg', 'Tea'),
('21', 'Kopi Susu Gula Aren Botolan', 20000, 'https://i.ibb.co/B2Btj9cg/kopi-susu-gula-aren-botolan.jpg', 'Bottle'),
('22', 'Vanilla Latte Botolan', 20000, 'https://i.ibb.co/B2Btj9cg/kopi-susu-gula-aren-botolan.jpg', 'Bottle'),
('23', 'Caramel Latte Botolan', 20000, 'https://i.ibb.co/B2Btj9cg/kopi-susu-gula-aren-botolan.jpg', 'Bottle'),
('24', 'Roti Keju', 7000, 'https://i.ibb.co/dJLz8WHb/roti-keju.jpg', 'Roti'),
('25', 'Roti Coklat', 7000, 'https://i.ibb.co/8DkQWbzX/roti-coklat.jpg', 'Roti'),
('3', 'Caffe Latte', 18000, 'https://i.ibb.co/vvhjXymG/caffe-latte.jpg', 'Espresso Based'),
('4', 'Capuccino', 18000, 'https://i.ibb.co/F4mwRWyk/capuccino.jpg', 'Espresso Based'),
('5', 'Espresso', 13000, 'https://i.ibb.co/ZpQmF5wS/esprsso.jpg', 'Espresso Based'),
('6', 'Peppermint Latte', 20000, 'https://i.ibb.co/HDwHP2Qd/peppermint-latte.jpg', 'Espresso Based'),
('7', 'Caramel Latte', 23000, 'https://i.ibb.co/mrfD5MWc/caramel-latte.jpg', 'Espresso Based'),
('8', 'Hazelnut Latte', 23000, 'https://i.ibb.co/XfRNLXp7/hazelnut-latte.jpg', 'Espresso Based'),
('9', 'Vanilla Latte', 23000, 'https://i.ibb.co/PGhwWcDb/vanilla-latte.jpg', 'Espresso Based');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
