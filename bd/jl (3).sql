-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/11/2023 às 13:58
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jl`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carros`
--

CREATE TABLE `carros` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `renavam` varchar(20) NOT NULL,
  `ano` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `cor` varchar(20) NOT NULL,
  `quilometragem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carros`
--

INSERT INTO `carros` (`id`, `marca`, `modelo`, `placa`, `renavam`, `ano`, `valor`, `cor`, `quilometragem`) VALUES
(9, 'Ford', 'Focus', 'PSJ88SD', 'dadadadadad', 2022, 80000.00, '#000000', 15000),
(10, 'Renault', 'Kwid', '58458455', '12888455588', 2020, 36000.00, '#000000', 50000),
(11, 'Renault', 'Kwid', '58458455', '12888455588', 2020, 36000.00, '#000000', 45000),
(12, 'Renault', 'Kwid', '58458455', '12888455588', 2020, 36000.00, '#000000', 45000);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `cnh` varchar(20) NOT NULL,
  `tipo_cnh` varchar(10) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `rg`, `cnh`, `tipo_cnh`, `telefone`, `email`, `endereco`) VALUES
(2, 'João Darruiz ', '4875552651', '365459541335', 'A,B', '14991877240', 'darruizhomeoffice@gmail.com', 'av cruer adad ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrada`
--

CREATE TABLE `entrada` (
  `id` int(11) NOT NULL,
  `carro_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `valor_entrada` decimal(10,2) NOT NULL,
  `data_entrada` date NOT NULL,
  `motivo_entrada` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `metodo_pagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `entrada`
--

INSERT INTO `entrada` (`id`, `carro_id`, `cliente_id`, `valor_entrada`, `data_entrada`, `motivo_entrada`, `descricao`, `metodo_pagamento`) VALUES
(1, 9, 2, 500.00, '2023-11-09', 'Pagou aluguel', 'AAAAAAAAAAA', 'PIX'),
(2, 9, 2, 500.35, '2023-11-09', 'Pagou aluguel', 'AAAAAAAAAAA', 'PIX'),
(3, 9, 2, 500.00, '2023-11-09', 'Pagou aluguel', 'sssssssssss', 'Cartão');

-- --------------------------------------------------------

--
-- Estrutura para tabela `locacoes`
--

CREATE TABLE `locacoes` (
  `id` int(11) NOT NULL,
  `carro_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `valor_mensal` decimal(10,2) NOT NULL,
  `data_inicial` date NOT NULL,
  `valor_caucao` decimal(10,2) NOT NULL,
  `data_locacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `locacoes`
--

INSERT INTO `locacoes` (`id`, `carro_id`, `cliente_id`, `valor_mensal`, `data_inicial`, `valor_caucao`, `data_locacao`) VALUES
(1, 9, 2, 2000.00, '2023-08-31', 2000.00, '2023-09-28 11:41:43'),
(2, 9, 2, 2000.00, '2023-08-31', 2000.00, '2023-09-28 11:43:51'),
(3, 9, 2, 2050.00, '2023-08-31', 2000.00, '2023-09-28 11:44:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `saida`
--

CREATE TABLE `saida` (
  `id` int(11) NOT NULL,
  `carro_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `valor_saida` decimal(10,2) NOT NULL,
  `data_saida` date NOT NULL,
  `motivo_saida` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `metodo_pagamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `saida`
--

INSERT INTO `saida` (`id`, `carro_id`, `cliente_id`, `valor_saida`, `data_saida`, `motivo_saida`, `descricao`, `metodo_pagamento`) VALUES
(2, 9, 2, -250.00, '2023-11-09', 'Mecânica', 'aa', 'PIX');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `data_aniversario` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `data_aniversario`, `email`) VALUES
(1, 'Master', '2acfc192f7f74e84214ff5ddcbce2bdaaa73c3a0', '2005-12-05', 'darruizhomeoffice@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carros`
--
ALTER TABLE `carros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carro_id` (`carro_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `locacoes`
--
ALTER TABLE `locacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carro_id` (`carro_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carros`
--
ALTER TABLE `carros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `locacoes`
--
ALTER TABLE `locacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `saida`
--
ALTER TABLE `saida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`carro_id`) REFERENCES `carros` (`id`),
  ADD CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Restrições para tabelas `locacoes`
--
ALTER TABLE `locacoes`
  ADD CONSTRAINT `locacoes_ibfk_1` FOREIGN KEY (`carro_id`) REFERENCES `carros` (`id`),
  ADD CONSTRAINT `locacoes_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
