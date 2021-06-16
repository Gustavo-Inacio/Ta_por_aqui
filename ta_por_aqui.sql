-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql205.epizy.com
-- Tempo de geração: 14/06/2021 às 14:53
-- Versão do servidor: 5.6.48-88.0
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `epiz_28781284_ta_por_aqui`
--

-- --------------------------------------------------------

create database ta_por_aqui;
use ta_por_aqui;

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `nota` float(3,1) NOT NULL,
  `comentario` text,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `data_contrato` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_contrato` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `denuncia_comentario`
--

CREATE TABLE `denuncia_comentario` (
  `id_denuncia_comentario` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `motivo_denuncia` varchar(20) NOT NULL,
  `comentario_denuncia` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `denuncia_motivo`
--

CREATE TABLE `denuncia_motivo` (
  `id_denuncia_motivo` int(11) NOT NULL,
  `motivo_denuncia` varchar(20) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `denuncia_servico`
--

CREATE TABLE `denuncia_servico` (
  `id_denuncia_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `motivo_denuncia` int(11) NOT NULL,
  `comentario_denuncia` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fale_conosco`
--

CREATE TABLE `fale_conosco` (
  `id_contato` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `empresa` varchar(30) DEFAULT NULL,
  `telefone` varchar(20) NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens`
--

CREATE TABLE `imagens` (
  `id_imagem` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `dir_imagem` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `redes_sociais`
--

CREATE TABLE `redes_sociais` (
  `id_rede_social` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `instragram` varchar(30) DEFAULT NULL,
  `twitter` varchar(30) DEFAULT NULL,
  `facebook` varchar(30) DEFAULT NULL,
  `linkedin` varchar(30) DEFAULT NULL,
  `tiktok` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `prestador` int(11) NOT NULL,
  `nome_servico` varchar(30) NOT NULL,
  `tipo` int(11) NOT NULL,
  `categoria` text NOT NULL,
  `descricao` text NOT NULL,
  `preco` float(5,2) DEFAULT NULL,
  `data_publicacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nota_media` float(3,1) DEFAULT NULL,
  `status_servico` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos_salvos`
--

CREATE TABLE `servicos_salvos` (
  `id_servico_salvo` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
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
  `data_entrada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descricao` text,
  `site` varchar(40) DEFAULT NULL,
  `status_usuario` int(11) NOT NULL DEFAULT '0',
  `imagem_perfil` varchar(20) DEFAULT 'no_picture.jpg'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `sobrenome`, `telefone`, `email`, `senha`, `data_nascimento`, `sexo`, `classificacao`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`, `complemento`, `data_entrada`, `descricao`, `site`, `status_usuario`, `imagem_perfil`) VALUES
(1, 'Teste_Nome', 'Teste_do_guru', '(25) 25252-5252', 'gutiinacio@gmail.com', '123', '5252-02-05', 'M', 2, '13508970', 'SP', 'Rio Claro', 'Ferraz', 'Rua 5 Ferraz 472', '52', NULL, '2021-06-03 08:50:22', NULL, NULL, 0, 'no_picture.jpg');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_ComentarioServico` (`id_servico`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_contrato`),
  ADD KEY `fk_ContratoServico` (`id_servico`),
  ADD KEY `fk_ContratoCliente` (`id_cliente`),
  ADD KEY `fk_ContratoPrestador` (`id_prestador`);

--
-- Índices de tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  ADD PRIMARY KEY (`id_denuncia_comentario`),
  ADD KEY `fk_DenunciaComentario` (`id_comentario`);

--
-- Índices de tabela `denuncia_motivo`
--
ALTER TABLE `denuncia_motivo`
  ADD PRIMARY KEY (`id_denuncia_motivo`);

--
-- Índices de tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  ADD PRIMARY KEY (`id_denuncia_servico`),
  ADD KEY `fk_DenunciaServico` (`id_servico`),
  ADD KEY `fk_DenunciaMotivo` (`motivo_denuncia`);

--
-- Índices de tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  ADD PRIMARY KEY (`id_contato`);

--
-- Índices de tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `fk_ServicoImagem` (`id_servico`);

--
-- Índices de tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  ADD PRIMARY KEY (`id_rede_social`),
  ADD KEY `fk_RedesocialUsuario` (`id_usuario`);

--
-- Índices de tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_PrestadorServico` (`prestador`);

--
-- Índices de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  ADD PRIMARY KEY (`id_servico_salvo`),
  ADD KEY `fk_SalvoServico` (`id_servico`),
  ADD KEY `fk_SalvoUsuario` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  MODIFY `id_denuncia_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `denuncia_motivo`
--
ALTER TABLE `denuncia_motivo`
  MODIFY `id_denuncia_motivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  MODIFY `id_denuncia_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
