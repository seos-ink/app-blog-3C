-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/10/2026 às 18:22
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
-- Estrutura para tabela `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` blob NOT NULL,
  `status` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `criador` int(11) NOT NULL,
  `id_categories_blog` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `nome`) VALUES
(1, 'Jogos'),
(2, 'Literatura'),
(3, 'Filmes'),
(4, 'Exclusivo'),
(5, 'Tópico de Discussão'),
(6, 'Mangás e Animes'),
(7, 'Programação'),
(8, 'Feedback');

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
(1, 'Administrador', 20),
(2, 'Super-administrador', 50),
(3, 'Editor', 15),
(4, 'Usuário', 1),
(5, 'Usuário Banido', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `description` varchar(500) NOT NULL,
  `id_status` int(11) NOT NULL,
  `image` blob NOT NULL,
  `slug` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `id_status`, `image`, `slug`) VALUES
(1, 'Colecionável Gundam', 'R$500,00', 2, 0x68747470733a2f2f6d2e6d656469612d616d617a6f6e2e636f6d2f696d616765732f492f37312b746266484137424c2e5f41435f55463839342c313030305f514c38305f2e6a7067, ''),
(2, 'Watch_Dogs II', 'wads', 3, 0x68747470733a2f2f692e7974696d672e636f6d2f76692f79693663746c6e464363342f6d617872657364656661756c742e6a7067, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_blogs`
--

CREATE TABLE `status_blogs` (
  `id` int(11) NOT NULL,
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `status_blogs`
--

INSERT INTO `status_blogs` (`id`, `status`) VALUES
(1, 'Ativo'),
(2, 'Inativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_products`
--

CREATE TABLE `status_products` (
  `id` int(11) NOT NULL,
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `status_products`
--

INSERT INTO `status_products` (`id`, `status`) VALUES
(1, 'Sem estoque'),
(2, 'Planejado'),
(3, 'À venda');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `slug` varchar(225) NOT NULL,
  `image` varchar(225) NOT NULL,
  `status` int(11) NOT NULL,
  `id_level_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `slug`, `image`, `status`, `id_level_users`) VALUES
(11, 'Saulo Elias', 'adminoperator33@gnail.com', '(12) 98765-3210', 'e10adc3949ba59abbe56e057f20f883e', 'thatrandomguy33_', 'https://avatars.githubusercontent.com/u/166402067?v=4', 1, 2),
(12, 'Lívia Reis', 'livia@mail.com', '(12) 98765-3211', 'ab233b682ec355648e7891e66c54191b', 'livia-reis', 'https://avatars.githubusercontent.com/u/167586660?s=130&v=4', 1, 4),
(13, 'Thales Vieira', 'imperador@mail.com', '(12) 98765-3210', 'e10adc3949ba59abbe56e057f20f883e', 'imperador-vieria', 'https://avatars.githubusercontent.com/u/166405797?s=130&v=4', 1, 4),
(14, 'Nícolas Custódio', 'ncustodio@mail.com', '(12) 98765-3210', '6c44e5cd17f0019c64b042e4a745412a', 'ncustodio_', 'https://avatars.githubusercontent.com/u/166570565?s=130&v=4', 1, 4),
(15, 'Tomás Ericksen', 'tomatinho@mail.com', '(12) 98765-3211', 'e10adc3949ba59abbe56e057f20f883e', 'tomate-falante123', 'https://picsum.photos/seed/124/300/300?grayscale', 1, 4),
(16, 'Gabriella Tes', 'gabi_1@mail.com', '(12) 98765-3211', 'e10adc3949ba59abbe56e057f20f883e', 'tres-skates99', 'https://picsum.photos/seed/9/300/300?blur=1', 1, 1),
(17, 'teste 1', 'teste@mail.ocm', '(12) 98765-3211', '15de21c670ae7c3f6f3f1f37029303c9', 'teste-1', 'https://picsum.photos/seed/2134/300/300', 1, 4);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_criador` (`criador`),
  ADD KEY `fk_status_blog` (`status`),
  ADD KEY `fk_categoria_blog` (`id_categories_blog`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `level_users`
--
ALTER TABLE `level_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status` (`id_status`);

--
-- Índices de tabela `status_blogs`
--
ALTER TABLE `status_blogs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `status_products`
--
ALTER TABLE `status_products`
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
-- AUTO_INCREMENT de tabela `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `level_users`
--
ALTER TABLE `level_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `status_blogs`
--
ALTER TABLE `status_blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `status_products`
--
ALTER TABLE `status_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_categoria_blog` FOREIGN KEY (`id_categories_blog`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_criador` FOREIGN KEY (`criador`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_blog` FOREIGN KEY (`status`) REFERENCES `status_blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`id_status`) REFERENCES `status_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_level` FOREIGN KEY (`id_level_users`) REFERENCES `level_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
