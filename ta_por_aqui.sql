-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Ago-2021 às 13:23
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
(1, 'Informática');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota_comentario` decimal(2,1) NOT NULL,
  `desc_comentario` text DEFAULT NULL,
  `data_comentario` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `data_contrato` datetime DEFAULT current_timestamp(),
  `status_contrato` int(11) NOT NULL COMMENT '0 = pendente, 1 = aceito, 2 = rejeitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `deletar_conta_motivos`
--

CREATE TABLE `deletar_conta_motivos` (
  `id_del_motivo` int(11) NOT NULL,
  `del_motivo` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `deletar_conta_motivos`
--

INSERT INTO `deletar_conta_motivos` (`id_del_motivo`, `del_motivo`) VALUES
(1, 'Outro'),
(2, 'A plataforma é travada'),
(3, 'A plataforma não é responsiva com o meu celular'),
(4, 'Experienciei muitos bugs'),
(5, 'Tive problemas de segurança'),
(6, 'Vou criar uma nova conta do zero'),
(7, 'Meu serviço foi banido injustamente'),
(8, 'Achei uma outra plataforma que atende melhor minhas necessidades'),
(9, 'Raramente um serviço que eu peço, como cliente, é aceito'),
(10, 'Raramente um serviço meu, como prestador, é solicitado'),
(11, 'A plataforma não localiza corretamente prestadores próximos de mim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_comentario`
--

CREATE TABLE `denuncia_comentario` (
  `id_denuncia_comentario` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `nome_denuncia_comen` varchar(20) NOT NULL,
  `desc_denuncia_comen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_motivo`
--

CREATE TABLE `denuncia_motivo` (
  `id_denuncia_motivo` int(11) NOT NULL,
  `denuncia_motivo` varchar(20) NOT NULL,
  `categoria_motivo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_servico`
--

CREATE TABLE `denuncia_servico` (
  `id_denuncia_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_denuncia_motivo` int(11) NOT NULL,
  `desc_denuncia_serv` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fale_conosco`
--

CREATE TABLE `fale_conosco` (
  `id_contato` int(11) NOT NULL,
  `nome_contato` varchar(30) NOT NULL,
  `email_contato` varchar(40) NOT NULL,
  `emp_contaato` varchar(30) DEFAULT NULL,
  `fone_contato` varchar(20) NOT NULL,
  `msg_contato` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `motivos_saida_usuario`
--

CREATE TABLE `motivos_saida_usuario` (
  `id_mot_saida_usuario` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_del_motivo` int(11) NOT NULL,
  `outro_del_motivo` varchar(75) DEFAULT NULL COMMENT 'preencher caso id_del_motivo = 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `id_prestador_servico` int(11) NOT NULL,
  `nome_servico` varchar(30) NOT NULL,
  `tipo_servico` int(11) NOT NULL COMMENT '0 = remoto, 1 = presencial',
  `desc_servico` text NOT NULL,
  `orcamento_servico` decimal(8,2) DEFAULT NULL,
  `crit_orcamento_servico` varchar(30) NOT NULL,
  `data_public_servico` datetime DEFAULT current_timestamp(),
  `nota_media_servico` decimal(2,1) DEFAULT NULL,
  `status_servico` int(11) DEFAULT 1 COMMENT '0 = suspenso, 1 = disponível, 2 = denunciado/banido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos_salvos`
--

CREATE TABLE `servicos_salvos` (
  `id_servico_salvo` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_categorias`
--

CREATE TABLE `servico_categorias` (
  `id_servico_categoria` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_imagens`
--

CREATE TABLE `servico_imagens` (
  `id_imagem` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `dir_servico_imagem` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id_subcategoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nome_subcategoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `subcategorias`
--

INSERT INTO `subcategorias` (`id_subcategoria`, `id_categoria`, `nome_subcategoria`) VALUES
(1, 1, 'Desenvolvimento web'),
(2, 1, 'Desenvolvimento de jogos'),
(3, 1, 'Montagem de computador'),
(4, 1, 'Conserto de celular'),
(5, 1, 'Manutenção de hardware'),
(6, 1, 'Manutenção de impressora');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(15) NOT NULL,
  `sobrenome_usuario` varchar(15) NOT NULL,
  `fone_usuario` varchar(20) NOT NULL,
  `email_usuario` varchar(40) NOT NULL,
  `senha_usuario` varchar(40) NOT NULL,
  `data_nasc_usuario` date NOT NULL,
  `sexo_usuario` char(1) NOT NULL,
  `classif_usuario` int(11) NOT NULL COMMENT '0 = cliente, 1 = prestador, 2 = pequeno negócio',
  `cep_usuario` char(8) NOT NULL,
  `uf_usuario` char(2) NOT NULL,
  `cidade_usuario` varchar(30) NOT NULL,
  `bairro_usuario` varchar(30) NOT NULL,
  `rua_usuario` varchar(30) NOT NULL,
  `numero_usuario` varchar(5) NOT NULL,
  `comple_usuario` varchar(20) DEFAULT NULL,
  `data_entrada_usuario` datetime DEFAULT current_timestamp(),
  `desc_usuario` text DEFAULT NULL,
  `site_usuario` varchar(40) DEFAULT NULL,
  `status_usuario` int(11) NOT NULL DEFAULT 1 COMMENT '0 = suspenso, 1 = ativo, 2 = denunciado/banido',
  `imagem_usuario` varchar(60) DEFAULT 'no_picture.jpg',
  `nota_media_usuario` decimal(2,1) DEFAULT NULL,
  `posicao_usuario` point DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_redes_sociais`
--

CREATE TABLE `usuario_redes_sociais` (
  `id_rede_social` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `rede_social` varchar(10) NOT NULL,
  `nick_rede_social` varchar(30) DEFAULT NULL,
  `link_rede_social` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD KEY `FK_ServicoComentario` (`id_servico`),
  ADD KEY `FK_UsuarioComentario` (`id_usuario`);

--
-- Índices para tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_contrato`),
  ADD KEY `FK_ServicoContrato` (`id_servico`),
  ADD KEY `FK_ClienteContrato` (`id_cliente`),
  ADD KEY `FK_PrestadorContrato` (`id_prestador`);

--
-- Índices para tabela `deletar_conta_motivos`
--
ALTER TABLE `deletar_conta_motivos`
  ADD PRIMARY KEY (`id_del_motivo`);

--
-- Índices para tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  ADD PRIMARY KEY (`id_denuncia_comentario`),
  ADD KEY `FK_ComentarioDenuncia` (`id_comentario`);

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
  ADD KEY `FK_ServicoDenuncia` (`id_servico`),
  ADD KEY `FK_MotivoDenuncia` (`id_denuncia_motivo`);

--
-- Índices para tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  ADD PRIMARY KEY (`id_contato`);

--
-- Índices para tabela `motivos_saida_usuario`
--
ALTER TABLE `motivos_saida_usuario`
  ADD PRIMARY KEY (`id_mot_saida_usuario`),
  ADD KEY `FK_motivo_saida_usuario` (`id_usuario`),
  ADD KEY `FK_mot_saida_usuario_del_motivo` (`id_del_motivo`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `FK_UsuarioServico` (`id_prestador_servico`);

--
-- Índices para tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  ADD PRIMARY KEY (`id_servico_salvo`),
  ADD KEY `FK_ServicoSalvo` (`id_servico`),
  ADD KEY `FK_UsuarioServicoSalvo` (`id_usuario`);

--
-- Índices para tabela `servico_categorias`
--
ALTER TABLE `servico_categorias`
  ADD PRIMARY KEY (`id_servico_categoria`),
  ADD KEY `FK_Servico` (`id_servico`),
  ADD KEY `FK_CategoriaServico` (`id_categoria`),
  ADD KEY `FK_SubcategoriaServico` (`id_subcategoria`);

--
-- Índices para tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  ADD PRIMARY KEY (`id_imagem`),
  ADD KEY `FK_ServicoImagem` (`id_servico`);

--
-- Índices para tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `FK_CategoriaSubcategoria` (`id_categoria`);

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
  ADD KEY `FK_UsuarioRedeSocial` (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de tabela `deletar_conta_motivos`
--
ALTER TABLE `deletar_conta_motivos`
  MODIFY `id_del_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT de tabela `motivos_saida_usuario`
--
ALTER TABLE `motivos_saida_usuario`
  MODIFY `id_mot_saida_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico_categorias`
--
ALTER TABLE `servico_categorias`
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
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_ServicoComentario` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`),
  ADD CONSTRAINT `FK_UsuarioComentario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `FK_ClienteContrato` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `FK_PrestadorContrato` FOREIGN KEY (`id_prestador`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `FK_ServicoContrato` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

--
-- Limitadores para a tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  ADD CONSTRAINT `FK_ComentarioDenuncia` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id_comentario`);

--
-- Limitadores para a tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  ADD CONSTRAINT `FK_MotivoDenuncia` FOREIGN KEY (`id_denuncia_motivo`) REFERENCES `denuncia_motivo` (`id_denuncia_motivo`),
  ADD CONSTRAINT `FK_ServicoDenuncia` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

--
-- Limitadores para a tabela `motivos_saida_usuario`
--
ALTER TABLE `motivos_saida_usuario`
  ADD CONSTRAINT `FK_mot_saida_usuario_del_motivo` FOREIGN KEY (`id_del_motivo`) REFERENCES `deletar_conta_motivos` (`id_del_motivo`),
  ADD CONSTRAINT `FK_motivo_saida_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `FK_UsuarioServico` FOREIGN KEY (`id_prestador_servico`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  ADD CONSTRAINT `FK_ServicoSalvo` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`),
  ADD CONSTRAINT `FK_UsuarioServicoSalvo` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `servico_categorias`
--
ALTER TABLE `servico_categorias`
  ADD CONSTRAINT `FK_CategoriaServico` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `FK_Servico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`),
  ADD CONSTRAINT `FK_SubcategoriaServico` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategorias` (`id_subcategoria`);

--
-- Limitadores para a tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  ADD CONSTRAINT `FK_ServicoImagem` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`);

--
-- Limitadores para a tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `FK_CategoriaSubcategoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Limitadores para a tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  ADD CONSTRAINT `FK_UsuarioRedeSocial` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
