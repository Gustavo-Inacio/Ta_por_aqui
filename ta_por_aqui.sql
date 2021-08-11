-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Ago-2021 às 13:35
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.9

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
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Serviços domésticos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `nota` float(3,1) NOT NULL,
  `comentario` text DEFAULT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `data_contrato` datetime NOT NULL DEFAULT current_timestamp(),
  `status_contrato` int(11) NOT NULL COMMENT '0 = não aceito, 1 = pendente, 2 = rejeitado '
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_comentario`
--

CREATE TABLE `denuncia_comentario` (
  `id_denuncia_comentario` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `motivo_denuncia` varchar(20) NOT NULL,
  `comentario_denuncia` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_motivo`
--

CREATE TABLE `denuncia_motivo` (
  `id_denuncia_motivo` int(11) NOT NULL,
  `motivo_denuncia` varchar(20) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_servico`
--

CREATE TABLE `denuncia_servico` (
  `id_denuncia_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `motivo_denuncia` int(11) NOT NULL,
  `comentario_denuncia` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fale_conosco`
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
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `prestador` int(11) NOT NULL,
  `nome_servico` varchar(30) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '0 = remoto, 1 = presencial',
  `descricao` text NOT NULL,
  `orcamento` varchar(50) NOT NULL,
  `data_publicacao` datetime NOT NULL DEFAULT current_timestamp(),
  `nota_media` float(2,1) DEFAULT NULL,
  `status_servico` int(11) DEFAULT 1 COMMENT '0 = negado, 1 = permitido'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos_salvos`
--

CREATE TABLE `servicos_salvos` (
  `id_servico_salvo` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servicos_salvos`
--

INSERT INTO `servicos_salvos` (`id_servico_salvo`, `id_servico`, `id_usuario`) VALUES
(71, 10, 3),
(52, 5, 0),
(57, 9, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_categoria`
--

CREATE TABLE `servico_categoria` (
  `id_servico_categoria` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_imagens`
--

CREATE TABLE `servico_imagens` (
  `id_imagem` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `dir_imagem` varchar(70) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id_subcategoria` int(11) NOT NULL,
  `nome_subcategoria` varchar(30) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `subcategorias`
--

INSERT INTO `subcategorias` (`id_subcategoria`, `nome_subcategoria`, `id_categoria`) VALUES
(1, 'Diarista', 1),
(2, 'Serviços para pets', 1),
(3, 'Limpesa de piscina', 1),
(4, 'lavadeira', 1);

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
  `classificacao` int(11) NOT NULL COMMENT '0 = cliente, 1 = prestador, 2 = pequeno negócio',
  `cep` char(8) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(40) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `data_entrada` datetime NOT NULL DEFAULT current_timestamp(),
  `descricao` text DEFAULT NULL,
  `site` varchar(40) DEFAULT NULL,
  `status_usuario` int(11) NOT NULL DEFAULT 0 COMMENT '0 = ativa, 1 = banida, 2 = suspensa',
  `imagem_perfil` varchar(60) DEFAULT 'no_picture.jpg',
  `nota_media` float(2,1) DEFAULT NULL,
  `posicao` point DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_redes_sociais`
--

CREATE TABLE `usuario_redes_sociais` (
  `id_rede_social` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `rede_social` varchar(10) NOT NULL,
  `nome_usuario` varchar(30) DEFAULT NULL,
  `link_perfil` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_ComentarioServico` (`id_servico`),
  ADD KEY `fk_comentario_usuario` (`id_usuario`);

--
-- Índices para tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_contrato`),
  ADD KEY `fk_ContratoServico` (`id_servico`),
  ADD KEY `fk_ContratoCliente` (`id_cliente`),
  ADD KEY `fk_ContratoPrestador` (`id_prestador`);

--
-- Índices para tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  ADD PRIMARY KEY (`id_denuncia_comentario`),
  ADD KEY `fk_DenunciaComentario` (`id_comentario`);

--
-- Índices para tabela `denuncia_motivo`
--
ALTER TABLE `denuncia_motivo`
  ADD PRIMARY KEY (`id_denuncia_motivo`);

--
-- Índices para tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  ADD PRIMARY KEY (`id_denuncia_servico`),
  ADD KEY `fk_DenunciaServico` (`id_servico`),
  ADD KEY `fk_DenunciaMotivo` (`motivo_denuncia`);

--
-- Índices para tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  ADD PRIMARY KEY (`id_contato`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `fk_PrestadorServico` (`prestador`);

--
-- Índices para tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  ADD PRIMARY KEY (`id_servico_salvo`),
  ADD KEY `fk_SalvoServico` (`id_servico`),
  ADD KEY `fk_SalvoUsuario` (`id_usuario`);

--
-- Índices para tabela `servico_categoria`
--
ALTER TABLE `servico_categoria`
  ADD PRIMARY KEY (`id_servico_categoria`),
  ADD KEY `fk_relacao_servico` (`id_servico`),
  ADD KEY `fk_relacao_categoria` (`id_categoria`),
  ADD KEY `fk_relacao_subcategoria` (`id_subcategoria`);

--
-- Índices para tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `fk_ServicoImagem` (`id_servico`);

--
-- Índices para tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `fk_subcategoria_categoria` (`id_categoria`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  ADD PRIMARY KEY (`id_rede_social`),
  ADD KEY `fk_redesSociais_usuarios` (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `servico_categoria`
--
ALTER TABLE `servico_categoria`
  MODIFY `id_servico_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
