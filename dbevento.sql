-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2025 às 21:03
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
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcadevento`
--

INSERT INTO `tbcadevento` (`idCadEvento`, `nomeCadEvento`, `dataCadEvento`, `descCadEvento`, `fotoCadEvento`, `idUsuario`) VALUES
(1, 'Mundial De League Of Legends', '2025-12-12', 'MUNDIAL DE LOL', '6bd06ad4c8c900087a24c8e1f4656f6d.png', 1),
(4, 'Major Csgo 2', '2025-08-07', 'Mundial de Counter Strike 2', '6ce629455d3ab6f9c17882d5481ec91a.png', 1),
(5, 'Champions Valorant', '2026-12-11', 'Mundial De Valorantt', '', 1),
(6, 'BGS evento', '2026-01-12', 'Maior evento de games do Brasil', 'efafbadf2f30b3e2a4f04cebf941f64b.png', 1),
(7, 'Mundial De League Of Legendsaaa', '1231-03-12', 'asd', 'evento_6866ceca6eadf.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidos`
--

CREATE TABLE `tbpedidos` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `dataPedido` datetime NOT NULL DEFAULT current_timestamp(),
  `valorTotal` decimal(10,2) NOT NULL,
  `formaPagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidos`
--

INSERT INTO `tbpedidos` (`idPedido`, `idUsuario`, `dataPedido`, `valorTotal`, `formaPagamento`) VALUES
(1, 1, '2025-07-03 13:27:29', 149.70, ''),
(2, 1, '2025-07-03 13:27:43', 49.90, ''),
(3, 1, '2025-07-03 13:27:43', 49.90, ''),
(4, 1, '2025-07-03 13:33:24', 149.00, ''),
(5, 1, '2025-07-03 13:33:49', 99.90, ''),
(6, 1, '2025-07-03 13:37:09', 50.00, ''),
(7, 1, '2025-07-03 13:41:45', 89.82, 'pix'),
(8, 1, '2025-07-03 13:46:16', 44.91, 'pix'),
(9, 1, '2025-07-03 13:48:50', 44.91, 'pix'),
(10, 1, '2025-07-03 13:52:31', 44.91, 'pix');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidos_itens`
--

CREATE TABLE `tbpedidos_itens` (
  `idItemPedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idCadEvento` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `precoUnitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidos_itens`
--

INSERT INTO `tbpedidos_itens` (`idItemPedido`, `idPedido`, `idCadEvento`, `quantidade`, `precoUnitario`) VALUES
(1, 1, -5, 2, 49.90),
(2, 1, -4, 1, 49.90),
(3, 2, -5, 1, 49.90),
(4, 3, -5, 1, 49.90),
(5, 4, -2, 1, 50.00),
(6, 4, -1, 1, 99.00),
(7, 5, -2, 1, 50.00),
(8, 5, -5, 1, 49.90),
(9, 6, -2, 1, 50.00),
(10, 7, -6, 1, 49.90),
(11, 7, -5, 1, 49.90),
(12, 8, -6, 1, 49.90),
(13, 9, -1, 1, 49.90),
(14, 10, -6, 1, 49.90);

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
(5, 'bca', 'bca@bca', '$2y$10$Jm74Oa3ppnUUeDTjhZ4eJ.UzPHNsOi0gA/dvdvP7udEKXpqhC5xlC', 'foto6.png', 123);

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
-- Índices de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  ADD PRIMARY KEY (`idItemPedido`),
  ADD KEY `idPedido` (`idPedido`);

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
  MODIFY `idCadEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbpedidos`
--
ALTER TABLE `tbpedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  MODIFY `idItemPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `tbpedidos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`);

--
-- Restrições para tabelas `tbpedidos_itens`
--
ALTER TABLE `tbpedidos_itens`
  ADD CONSTRAINT `tbpedidos_itens_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `tbpedidos` (`idPedido`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
