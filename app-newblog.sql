-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/05/2026 às 15:33
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app-newblog`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `level_users`
--

CREATE TABLE `level_users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `level_users`
--

INSERT INTO `level_users` (`id`, `name`, `level`) VALUES
(1, 'admin\r\n', 20),
(2, 'super-admin', 50),
(3, 'editor', 15),
(4, 'User', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `slug` varchar(225) NOT NULL,
  `image` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `id_level_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `slug`, `image`, `status`, `id_level_users`) VALUES
(4, 'Elias Oliveira', 'elias@gmail.com', '123456', 'elias-oliveira', '', 0, 1),
(5, 'Manager', 'manager2@gmail.com', '321321', 'localhost-admin', '', 0, 2),
(6, 'b', 'elias1@gmail.com', '123456', '', '', 1, 2),
(7, 'asdfas', 'operation@rewe.com', '202cb962ac59075b964b07152d234b70', '', '', 0, 2),
(8, 'Saulo Elias', 'adminoperator33@gnail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 3),
(9, 'Nícolas Custódio', 'ncustodio@gnaail.com', '5a751d6a0b6ef05cfe51b86e5d1458e6', '', '', 1, 4),
(10, 'Thales Vieira', 'thales3c@etec.gov.br', '254ed7d2de3b23ab10936522dd547b78', '', '', 1, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `level_users`
--
ALTER TABLE `level_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_level` (`id_level_users`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `level_users`
--
ALTER TABLE `level_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_level` FOREIGN KEY (`id_level_users`) REFERENCES `level_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
