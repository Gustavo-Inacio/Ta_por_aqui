-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Ago-2021 às 15:25
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.6

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

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_servico`, `nota`, `comentario`, `data`, `id_usuario`) VALUES
(1, 1, 4.0, 'servico muito bom esse aí', '2021-06-25 10:41:24', 3),
(2, 1, 5.0, 'v', '2021-06-25 10:41:58', 3),
(3, 1, 1.0, 'd', '2021-06-25 10:42:16', 3),
(4, 2, 4.0, 'teste', '2021-06-25 10:44:32', 3),
(5, 5, 3.0, 'sdsdsd', '2021-06-25 15:04:16', 1),
(6, 4, 2.0, 'ssdsdssd', '2021-06-25 18:42:05', 1),
(7, 4, 2.0, 's', '2021-06-25 18:43:55', 1),
(8, 4, 3.0, 's', '2021-06-25 18:44:56', 1),
(9, 4, 5.0, 's', '2021-06-25 18:45:46', 1),
(10, 9, 2.0, 'e', '2021-07-27 14:00:21', 3),
(11, 9, 3.0, 'asasas', '2021-07-27 14:00:25', 3),
(12, 9, 5.0, 'sd', '2021-07-27 14:01:49', 3),
(13, 9, 4.0, 'comentário do serviço ', '2021-08-04 07:58:22', 3),
(14, 10, 3.0, 'Teste nota 3', '2021-08-04 08:09:34', 3),
(15, 9, 3.0, 'Teste de comentário\n', '2021-08-04 08:34:49', 3),
(16, 11, 3.0, 'serico otimo\n', '2021-08-04 08:37:38', 3),
(17, 10, 3.0, 'bla\n', '2021-08-09 15:34:36', 3),
(18, 10, 4.0, 'ola', '2021-08-09 15:35:07', 3),
(19, 10, 4.0, 'kkkk', '2021-08-09 15:36:21', 3),
(20, 10, 1.0, 'oi', '2021-08-09 15:36:27', 3),
(21, 10, 5.0, 'ioiiiiioioioio', '2021-08-09 15:44:12', 3),
(22, 10, 3.0, 'j', '2021-08-09 15:44:27', 3);

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

--
-- Extraindo dados da tabela `contratos`
--

INSERT INTO `contratos` (`id_contrato`, `id_servico`, `id_cliente`, `id_prestador`, `data_contrato`, `status_contrato`) VALUES
(14, 13, 3, 3, '2021-08-05 11:43:48', 0),
(13, 12, 3, 3, '2021-08-05 11:40:05', 1),
(12, 11, 3, 3, '2021-08-04 08:37:05', 1),
(11, 10, 3, 3, '2021-08-04 08:08:48', 1),
(10, 9, 3, 3, '2021-07-27 13:41:03', 1);

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

--
-- Extraindo dados da tabela `fale_conosco`
--

INSERT INTO `fale_conosco` (`id_contato`, `nome`, `email`, `empresa`, `telefone`, `mensagem`) VALUES
(1, 'Gustavo', 'gutiinacio@gmail.com', 'minha empresa', '5151616551161', 'Serviço sensacional!'),
(2, 'Gustavo', 'gutiinacio@gmail.com', 'minha empresa', '5151616551161', 'Serviço sensacional!'),
(3, 'João', 'teste@gmail.com', 'teste', '15646448', 'MensagemMensagemMensagemMensagemMensagemMensagemMensagemMensagemMensagemMensagemMensagem');

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

--
-- Extraindo dados da tabela `servico_categoria`
--

INSERT INTO `servico_categoria` (`id_servico_categoria`, `id_servico`, `id_categoria`, `id_subcategoria`) VALUES
(38, 14, 1, 4),
(37, 14, 1, 3),
(36, 14, 1, 2),
(35, 13, 1, 4),
(34, 13, 1, 3),
(33, 13, 1, 2),
(32, 12, 1, 2),
(31, 11, 1, 3),
(30, 11, 1, 2),
(29, 11, 1, 1),
(28, 10, 1, 4),
(27, 9, 1, 3),
(26, 9, 1, 2),
(25, 9, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_imagens`
--

CREATE TABLE `servico_imagens` (
  `id_imagem` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `dir_imagem` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servico_imagens`
--

INSERT INTO `servico_imagens` (`id_imagem`, `id_servico`, `dir_imagem`) VALUES
(1, 1, '162462839860d5dcae00c11.jpg'),
(2, 1, '162462839860d5dcae03371.jpg'),
(3, 1, '162462839860d5dcae0352a.png'),
(4, 1, '162462839860d5dcae036ce.png'),
(5, 2, '162462862360d5dd8fca3bb.jpg'),
(6, 2, '162462862360d5dd8fcad9f.jpg'),
(7, 2, '162462862360d5dd8fcaf55.jpg'),
(8, 2, '162462862360d5dd8fcb0fa.jpg'),
(9, 3, '162462903360d5df29cb0ae.jpg'),
(10, 3, '162462903360d5df29cb30c.jpg'),
(11, 3, '162462903360d5df29cb4f0.png'),
(12, 3, '162462903360d5df29cbd5d.png'),
(13, 4, '162462910060d5df6cf2b52.jpg'),
(14, 4, '162462910060d5df6cf2de0.jpg'),
(15, 4, '162462910060d5df6cf3079.jpg'),
(16, 4, '162462910060d5df6cf334c.png'),
(17, 5, '162462934360d5e05f91477.jpg'),
(18, 5, '162462934360d5e05f9163d.jpg'),
(19, 5, '162462934360d5e05f9181c.jpg'),
(20, 5, '162462934360d5e05f91cfb.png'),
(21, 6, '162464418860d61a5c54d9e.jpg'),
(22, 6, '162464418860d61a5c54ff3.jpg'),
(23, 6, '162464418860d61a5c56265.png'),
(24, 6, '162464418860d61a5c5642b.png'),
(25, 7, '162466709860d673dacbd7b.jpeg'),
(26, 7, '162466709860d673dacc065.jpeg'),
(27, 7, '162466709860d673dacc291.jpeg'),
(28, 7, '162466709860d673dacc400.jpeg'),
(29, 8, '162473314360d775d7c0051.jpeg'),
(30, 8, '162473314360d775d7c1289.jpeg'),
(31, 8, '162473314360d775d7c143d.jpeg'),
(32, 8, '162473314360d775d7c15c7.jpeg'),
(33, 9, '162473331760d7768536753.jpeg'),
(34, 9, '162473331760d776853693f.jpeg'),
(35, 9, '162473331760d7768537989.jpeg'),
(36, 9, '162473331760d7768537b59.jpeg'),
(37, 10, '1628075249610a74f155a51.jpg'),
(38, 10, '1628075249610a74f159297.jpg'),
(39, 10, '1628075249610a74f15949c.jpg'),
(40, 11, '1628076974610a7baed2354.jpg'),
(41, 11, '1628076974610a7baed2917.jpg'),
(42, 11, '1628076974610a7baed2af4.jpg'),
(43, 12, '1628174391610bf837303bd.png'),
(44, 13, '1628174549610bf8d50261a.png'),
(45, 14, '1628250373610d2105c5df5.png');

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
  `imagem_perfil` varchar(40) DEFAULT 'no_picture.jpg',
  `nota_media` float(2,1) DEFAULT NULL,
  `posicao` point DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `sobrenome`, `telefone`, `email`, `senha`, `data_nascimento`, `sexo`, `classificacao`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`, `complemento`, `data_entrada`, `descricao`, `site`, `status_usuario`, `imagem_perfil`, `nota_media`, `posicao`) VALUES
(13, '', '', '', '', '', '0000-00-00', '', 0, '', '', '', '', '', '', NULL, '2021-08-11 09:49:46', NULL, NULL, 0, 'no_picture.jpg', NULL, 0x000000000101000000f1ba7ec16ee037c01f85eb51b86247c0);

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
-- Extraindo dados da tabela `usuario_redes_sociais`
--

INSERT INTO `usuario_redes_sociais` (`id_rede_social`, `id_usuario`, `rede_social`, `nome_usuario`, `link_perfil`) VALUES
(1, 1, 'instagram', NULL, NULL),
(2, 1, 'facebook', NULL, NULL),
(3, 1, 'twitter', NULL, NULL),
(4, 1, 'linkedin', NULL, NULL),
(5, 2, 'instagram', NULL, NULL),
(6, 2, 'facebook', NULL, NULL),
(7, 2, 'twitter', NULL, NULL),
(8, 2, 'linkedin', NULL, NULL),
(9, 3, 'instagram', NULL, NULL),
(10, 3, 'facebook', NULL, NULL),
(11, 3, 'twitter', NULL, NULL),
(12, 3, 'linkedin', NULL, NULL),
(13, 12, 'instagram', NULL, NULL),
(14, 12, 'facebook', NULL, NULL),
(15, 12, 'twitter', NULL, NULL),
(16, 12, 'linkedin', NULL, NULL);

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
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `servico_categoria`
--
ALTER TABLE `servico_categoria`
  MODIFY `id_servico_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
