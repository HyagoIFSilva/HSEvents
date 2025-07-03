-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/06/2025 às 20:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
(1, 'HyagoDW', '2003-10-20', 'aaaaaaaaaaaaaaa', 'evento16.png', 1),
(2, 'PIX', '1212-12-12', '121212', 'evento17.png', 1);

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
  MODIFY `idCadEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
