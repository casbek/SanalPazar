-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Haz 2022, 17:56:10
-- Sunucu sürümü: 10.4.22-MariaDB
-- PHP Sürümü: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ureticiden`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sehir` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `ikategori` varchar(20) NOT NULL,
  `ubilgisi` varchar(40) NOT NULL,
  `uetiketi` varchar(30) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `imageUrl` varchar(100) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `title`, `sehir`, `price`, `ikategori`, `ubilgisi`, `uetiketi`, `owner_id`, `imageUrl`, `isActive`, `dateAdded`) VALUES
(8, 'satilik tarla domatesi', 'Antalya', 5000, 'meyvesebze', 'domates', 'seradan', 1, '1bd901ba66b65dab27ffe32fe09a5094.jpg', 1, '2022-06-02 21:32:12'),
(9, 'hepsi satilik patates', 'İzmir', 30000, 'meyvesebze', 'patates', 'tarladan', 3, '546db292208b7b9762d76f3408ba77be.jpg', 1, '2022-06-02 21:33:53'),
(10, 'kesime hazır 3000 marul', 'Adana', 12000, 'meyvesebze', 'marul', 'seradan', 1, 'd4b9d1dafae06b7e216a054b93b436a2.jpg', 1, '2022-06-02 21:37:39'),
(12, 'tarla karpuzu 5 donum', 'Adana', 80000, 'meyvesebze', 'karpuz', 'tarladan', 3, '9c1073590be26320a4a7570889600031.jpg', 1, '2022-06-04 20:55:55'),
(16, 'bahceden papaz erik', 'Aydın', 42, 'meyvesebze', 'erik', 'tarladan', 3, 'b389903518e981beb6d41731c01cff6d.jpg', 1, '2022-06-06 22:06:28'),
(17, 'satilik erik tohumu', 'Ardahan', 50, 'tohum', 'erik', 'bahceden', 10, '4b61847dd88769c864aeb85321d78e14.jpg', 0, '2022-06-08 15:35:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `kullanici_id` int(11) NOT NULL,
  `isim` varchar(24) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(24) NOT NULL,
  `onceki_sifre` varchar(24) DEFAULT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user',
  `tel` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`kullanici_id`, `isim`, `email`, `password`, `onceki_sifre`, `user_type`, `tel`) VALUES
(1, 'kadir', 'gulerkadir61@gmail.com', '1234567', '123456', 'admin', '5360606586'),
(3, 'hasan', 'hasan@gmail.com', '1234566', NULL, 'user', '5423984542'),
(4, 'ayse', 'ayse@gmail.com', '123456', '444444', 'user', '5336548574'),
(5, 'veli', 'veli@hotmail.com', '123456', NULL, 'user', NULL),
(6, 'semiha', 'semiha@hotmail.com', '123456', NULL, 'user', NULL),
(8, 'cagri', 'cagir1@gmail.com', '123456', NULL, 'user', NULL),
(10, 'deneme deneme ', 'deneme@gmail.com', 'deneme123', NULL, 'user', '5360606577');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
