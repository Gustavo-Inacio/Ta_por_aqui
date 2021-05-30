-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Maio-2021 às 19:22
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ta_por_aqui`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(15) NOT NULL,
  `sobrenome` varchar(15) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `classificacao` int(11) NOT NULL,
  `cep` char(8) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(40) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `data_entrada` date DEFAULT curdate(),
  `descricao` text DEFAULT NULL,
  `site` varchar(40) DEFAULT NULL,
  `status_usuario` int(11) NOT NULL DEFAULT 0,
  `imagem_perfil` varchar(20) DEFAULT 'no_picture.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `sobrenome`, `telefone`, `email`, `senha`, `data_nascimento`, `sexo`, `classificacao`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`, `complemento`, `data_entrada`, `descricao`, `site`, `status_usuario`, `imagem_perfil`) VALUES
(1, 'Natan', 'Barbosa', '(11) 54788-5223', 'natanbarbosa525@gmail.com', '123', '2003-07-28', 'M', 1, '64017808', 'PI', 'Teresina', 'Redenção', 'Rua Jorge Mazuad', '54', NULL, '2021-05-27', NULL, NULL, 0, 'no_picture.jpg'),
(4, 'Andressa', 'Silva', '(65) 46541-3216', 'lauringamesbr@gmail.com', 'senha', '1998-05-14', 'F', 0, '05570140', 'SP', 'São Paulo', 'Jardim Amaralina', 'Rua Fausto Feijó', '78', NULL, '2021-05-30', NULL, NULL, 0, 'no_picture.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
