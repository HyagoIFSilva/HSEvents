-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/07/2025 às 07:13
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
-- Banco de dados: `dbevento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcadevento`
--

CREATE TABLE `tbcadevento` (
  `idCadEvento` int(11) NOT NULL,
  `nomeCadEvento` varchar(255) NOT NULL,
  `dataCadEvento` date NOT NULL,
  `descCadEvento` text NOT NULL,
  `fotoCadEvento` varchar(255) NOT NULL,
  `precoCadEvento` decimal(10,2) NOT NULL DEFAULT 49.90,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcadevento`
--

INSERT INTO `tbcadevento` (`idCadEvento`, `nomeCadEvento`, `dataCadEvento`, `descCadEvento`, `fotoCadEvento`, `precoCadEvento`, `idUsuario`) VALUES
(1, 'Mundial De League Of Legends', '2025-12-12', 'MUNDIAL DE LOL', '6bd06ad4c8c900087a24c8e1f4656f6d.png', 49.90, 1),
(4, 'Major Csgo 2', '2025-08-07', 'Mundial de Counter Strike 2', '6ce629455d3ab6f9c17882d5481ec91a.png', 49.90, 1),
(5, 'Champions Valorant', '2026-12-11', 'Mundial De Valorantt', 'evento_6866ea982cbae.png', 49.90, 1),
(6, 'BGS evento', '2026-01-12', 'Maior evento de games do Brasil', 'efafbadf2f30b3e2a4f04cebf941f64b.png', 49.90, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbhoteis`
--

CREATE TABLE `tbhoteis` (
  `idHotel` int(11) NOT NULL,
  `nomeHotel` varchar(100) NOT NULL,
  `localHotel` varchar(100) NOT NULL,
  `detalhesHotel` varchar(255) NOT NULL,
  `descricaoHotel` text NOT NULL,
  `imagemHotel` varchar(255) NOT NULL,
  `linkReserva` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbhoteis`
--

INSERT INTO `tbhoteis` (`idHotel`, `nomeHotel`, `localHotel`, `detalhesHotel`, `descricaoHotel`, `imagemHotel`, `linkReserva`) VALUES
(1, 'CHARLIE', 'Jardim Paulista', '🚶 9.3 KM • 📶 Wi-Fi • ❄️ Ar-condicionado', 'Descubra uma nova forma de se hospedar com conforto, praticidade e zero burocracia.', 'img/charlie.jpg', '#'),
(2, 'VILA GALÉ PAULISTA', 'Consolação', '🚶 9 KM • 📶 Wi-Fi • ❄️ Ar-condicionado • 🅿 Estacionamento • ☕ Café da manhã', 'Localizado próximo à Paulista, ideal para quem procura animação noturna e localização privilegiada.', 'img/289305619.jpg', '#');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbparceiros`
--

CREATE TABLE `tbparceiros` (
  `idParceiro` int(11) NOT NULL,
  `nomeParceiro` varchar(100) NOT NULL,
  `logoParceiro` varchar(255) NOT NULL,
  `linkParceiro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbparceiros`
--

INSERT INTO `tbparceiros` (`idParceiro`, `nomeParceiro`, `logoParceiro`, `linkParceiro`) VALUES
(1, 'CCXP', 'img/ccxp.png', 'https://www.ccxp.com.br'),
(2, 'Gamescom', 'img/gamescom.png', 'https://www.gamescom.global'),
(3, 'BGS', 'img/BGS.png', 'https://www.brasilgameshow.com.br'),
(4, 'Riot Games', 'img/logoRiot.png', 'https://www.riotgames.com'),
(5, 'Valve', 'img/logoValve.png', 'https://www.valvesoftware.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidos`
--

CREATE TABLE `tbpedidos` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `valorTotal` decimal(10,2) NOT NULL,
  `formaPagamento` varchar(50) NOT NULL,
  `dataPedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidos`
--

INSERT INTO `tbpedidos` (`idPedido`, `idUsuario`, `valorTotal`, `formaPagamento`, `dataPedido`) VALUES
(2, 1, 44.91, 'pix', '2025-07-04 17:59:08'),
(3, 1, 942.03, 'pix', '2025-07-04 18:29:10'),
(4, 1, 359.28, 'pix', '2025-07-04 19:33:18'),
(5, 1, 314.01, 'pix', '2025-07-04 19:51:22'),
(6, 1, 358.20, 'pix', '2025-07-11 03:05:04'),
(7, 1, 211.50, 'pix', '2025-07-11 04:41:03'),
(8, 1, 5184.00, 'pix', '2025-07-11 04:49:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidos_itens`
--

CREATE TABLE `tbpedidos_itens` (
  `idItemPedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idCadEvento` int(11) DEFAULT NULL,
  `idProduto` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `precoUnitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidos_itens`
--

INSERT INTO `tbpedidos_itens` (`idItemPedido`, `idPedido`, `idCadEvento`, `idProduto`, `quantidade`, `precoUnitario`) VALUES
(2, 2, 4, NULL, 1, 49.90),
(3, 3, NULL, 1, 1, 99.00),
(4, 3, NULL, 2, 2, 50.00),
(5, 3, NULL, 3, 1, 199.00),
(6, 3, 5, NULL, 7, 49.90),
(7, 3, 6, NULL, 2, 49.90),
(8, 3, 4, NULL, 1, 49.90),
(11, 3, 1, NULL, 1, 49.90),
(12, 4, 5, NULL, 2, 49.90),
(13, 4, 6, NULL, 2, 49.90),
(14, 4, 4, NULL, 2, 49.90),
(15, 4, 1, NULL, 1, 49.90),
(17, 5, NULL, 2, 2, 50.00),
(18, 5, 6, NULL, 1, 49.90),
(19, 5, NULL, 3, 1, 199.00),
(20, 6, NULL, 3, 1, 199.00),
(21, 6, NULL, 2, 2, 50.00),
(22, 6, NULL, 1, 1, 99.00),
(23, 7, NULL, 5, 1, 75.00),
(24, 7, NULL, 6, 1, 60.00),
(25, 7, NULL, 4, 1, 50.00),
(26, 7, NULL, 2, 1, 50.00),
(27, 8, NULL, 3, 2, 100.00),
(28, 8, NULL, 1, 1, 75.00),
(29, 8, NULL, 2, 1, 50.00),
(30, 8, NULL, 8, 10, 230.00),
(31, 8, NULL, 7, 12, 250.00),
(32, 8, NULL, 6, 1, 60.00),
(33, 8, NULL, 5, 1, 75.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbprodutos`
--

CREATE TABLE `tbprodutos` (
  `idProduto` int(11) NOT NULL,
  `nomeProduto` varchar(100) NOT NULL,
  `precoProduto` decimal(10,2) NOT NULL,
  `imagemProduto` varchar(255) NOT NULL,
  `categoriaProduto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbprodutos`
--

INSERT INTO `tbprodutos` (`idProduto`, `nomeProduto`, `precoProduto`, `imagemProduto`, `categoriaProduto`) VALUES
(1, 'Camisa Manga Comprida', 75.00, 'img/comprida.png', 'camisas'),
(2, 'Camisa Manga Curta', 50.00, 'img/curta.png', 'camisas'),
(3, 'Blusa de Frio', 100.00, 'img/frio.png', 'camisas'),
(4, 'Xícara Gamer', 50.00, 'img/xicara.png', 'copos'),
(5, 'Garrafa Térmica', 75.00, 'img/termica.png', 'copos'),
(6, 'Garrafa Simples', 60.00, 'img/garrafa.png', 'copos'),
(7, 'Controle Custom PS5', 250.00, 'img/ps5.png', 'controles'),
(8, 'Controle Custom Xbox', 230.00, 'img/xbox.png', 'controles');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuario`
--

CREATE TABLE `tbusuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `emailUsuario` varchar(255) NOT NULL,
  `senhaUsuario` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `idadeUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario`
--

INSERT INTO `tbusuario` (`idUsuario`, `nomeUsuario`, `emailUsuario`, `senhaUsuario`, `foto`, `idadeUsuario`) VALUES
(1, 'hyago', 'hyagodw@hyago', '$2y$10$nMem43Vce81AqhP0cfluhOXaCKvIoDyFAZVlfHwFfZtYujcHVWazi', 'foto2.png', 18),
(2, 'hyago', 'hyagodwdq@hyago', '$2y$10$E3Vyqixe.lZcISJV2YlO/e6dGgFgdvLZRc4K369naX9SPN4V2xUSe', 'foto3.png', 12),
(3, 'a', 'as@as', '$2y$10$1tHTt3mPuIDVypzVQsJ1Su8XWNjdSibApW/BP74KFHh5WdjmAJlFC', 'foto4.png', 12),
(4, 'abc', 'abc@abc', '$2y$10$xH5adT0XBPIPVtslL7VbROsB.3EHwDeLPM3fSk1rrXt5jOHM27DJC', 'foto5.png', 123),
(5, 'bca', 'bca@bca', '$2y$10$Jm74Oa3ppnUUeDTjhZ4eJ.UzPHNsOi0gA/dvdvP7udEKXpqhC5xlC', 'foto6.png', 123),
(6, 'hyago212', 'hyago212@h', '$2y$10$ozOsjBtCbi2JZhC/q1/3FuMhnWvdlQJg9sCDILAI3rzytQ5k2f0pO', 'foto3.jpg', 12),
(7, 'hyago silva', 'hyago@gmail.com', '$2y$10$AOlXOK9.VrhUp5tSYQFqJe.r1IRpZVah/MexzETajukgc7KkU0eua', 'user_686b3d38563fa.jpg', 31),
(8, 'hyago', 'hyago2@gmail.com', '$2y$10$M4CVv.9mtKENerJCHabCNuwSamcU6JUFDpcctatzHufzSLoAx/3g6', 'user_686b3d5256975.jpg', 123),
(9, 'adm', 'adm@gmail.com', '$2y$10$RcVhNPgfwUsMrQZsKJJmUeDIsHbC12DEFxl8R1NhU4cPg12qSdGca', 'user_686b41e3d7daa.jpg', 32);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbcadevento`
--
ALTER TABLE `tbcadevento`
  ADD PRIMARY KEY (`idCadEvento`),
  ADD KEY `fk_evento_usuario_idx` (`idUsuario`);

--
-- Índices de tabela `tbhoteis`
--
ALTER TABLE `tbhoteis`
  ADD PRIMARY KEY (`idHotel`);

--
-- Índices de tabela `tbparceiros`
--
ALTER TABLE `tbparceiros`
  ADD PRIMARY KEY (`idParceiro`);

--
-- Índices de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_pedido_usuario_idx` (`idUsuario`);

--
-- Índices de tabela `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  ADD PRIMARY KEY (`idItemPedido`),
  ADD KEY `fk_item_pedido_idx` (`idPedido`),
  ADD KEY `fk_item_evento_idx` (`idCadEvento`),
  ADD KEY `idProduto` (`idProduto`);

--
-- Índices de tabela `tbprodutos`
--
ALTER TABLE `tbprodutos`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `emailUsuario_UNIQUE` (`emailUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbcadevento`
--
ALTER TABLE `tbcadevento`
  MODIFY `idCadEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `tbhoteis`
--
ALTER TABLE `tbhoteis`
  MODIFY `idHotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbparceiros`
--
ALTER TABLE `tbparceiros`
  MODIFY `idParceiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  MODIFY `idItemPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `tbprodutos`
--
ALTER TABLE `tbprodutos`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbcadevento`
--
ALTER TABLE `tbcadevento`
  ADD CONSTRAINT `fk_evento_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tbpedidos`
--
ALTER TABLE `tbpedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  ADD CONSTRAINT `fk_item_evento` FOREIGN KEY (`idCadEvento`) REFERENCES `tbcadevento` (`idCadEvento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_item_pedido` FOREIGN KEY (`idPedido`) REFERENCES `tbpedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbpedidos_itens_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `tbprodutos` (`idProduto`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
