-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Set-2021 às 09:01
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
(1, 'Informática'),
(2, 'Pets'),
(3, 'Eventos'),
(4, 'Moda e beleza'),
(5, 'Limpeza'),
(6, 'Manutenção'),
(7, 'Assistência técnica'),
(8, 'Transporte'),
(9, 'Serviço de professores'),
(10, 'Doméstico');

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
  `data_comentario` timestamp NULL DEFAULT current_timestamp(),
  `status_comentario` int(11) NOT NULL DEFAULT 1 COMMENT '0 = excluído, 1 = exibido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_servico`, `id_usuario`, `nota_comentario`, `desc_comentario`, `data_comentario`, `status_comentario`) VALUES
(1, 3, 2, '4.0', 'O site ficou legal, mas deu bug em uma página', '2021-09-07 13:11:36', 1),
(2, 2, 2, '5.0', 'Montou meu pc direitinho e nem saiu tão caro.', '2021-09-07 13:13:10', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `data_contrato` timestamp NULL DEFAULT current_timestamp(),
  `status_contrato` int(11) NOT NULL COMMENT '0 = pendente, 1 = aceito, 2 = rejeitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `contratos`
--

INSERT INTO `contratos` (`id_contrato`, `id_servico`, `id_cliente`, `id_prestador`, `data_contrato`, `status_contrato`) VALUES
(1, 3, 2, 1, '2021-09-07 13:08:45', 1),
(2, 2, 2, 1, '2021-09-07 13:08:47', 1),
(3, 1, 2, 1, '2021-09-07 13:08:49', 2),
(4, 3, 1, 1, '2021-09-07 14:13:10', 1),
(5, 2, 1, 1, '2021-09-07 15:05:51', 1),
(6, 5, 1, 2, '2021-09-07 15:12:51', 1),
(7, 4, 1, 2, '2021-09-07 15:12:54', 1);

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
  `id_denuncia_motivo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'usuário que fez a denúncia',
  `desc_denuncia_comen` text NOT NULL,
  `data_denuncia_comen` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_denuncia_comen` int(11) NOT NULL DEFAULT 0 COMMENT '0 = não resolvido, 1 = em análise, 2 = resolvido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `denuncia_comentario`
--

INSERT INTO `denuncia_comentario` (`id_denuncia_comentario`, `id_comentario`, `id_denuncia_motivo`, `id_usuario`, `desc_denuncia_comen`, `data_denuncia_comen`, `status_denuncia_comen`) VALUES
(1, 1, 2, 2, 'comentário machista', '2021-09-07 17:39:33', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_motivo`
--

CREATE TABLE `denuncia_motivo` (
  `id_denuncia_motivo` int(11) NOT NULL,
  `denuncia_motivo` varchar(20) NOT NULL,
  `categoria_motivo` int(11) NOT NULL COMMENT '1 = para serviços, 2 = para comentários'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `denuncia_motivo`
--

INSERT INTO `denuncia_motivo` (`id_denuncia_motivo`, `denuncia_motivo`, `categoria_motivo`) VALUES
(1, 'serviço enganoso', 1),
(2, 'comentário ofensivo', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncia_servico`
--

CREATE TABLE `denuncia_servico` (
  `id_denuncia_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_denuncia_motivo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'usuário que fez a denúncia',
  `desc_denuncia_serv` text NOT NULL,
  `data_denuncia_serv` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_denuncia_serv` int(11) NOT NULL DEFAULT 0 COMMENT '0 = não resolvido, 1 = em análise, 2 = resolvido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `denuncia_servico`
--

INSERT INTO `denuncia_servico` (`id_denuncia_servico`, `id_servico`, `id_denuncia_motivo`, `id_usuario`, `desc_denuncia_serv`, `data_denuncia_serv`, `status_denuncia_serv`) VALUES
(1, 1, 1, 2, 'é scam. O cara não faz o serviço que promete', '2021-09-07 17:28:27', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fale_conosco`
--

CREATE TABLE `fale_conosco` (
  `id_contato` int(11) NOT NULL,
  `nome_contato` varchar(30) NOT NULL,
  `email_contato` varchar(40) NOT NULL,
  `motivo_contato` int(11) NOT NULL COMMENT '1 = Elogios, 2 = Sugestões, 3 = Reclamações, 4 = Problemas/bugs, 5 = Outros',
  `fone_contato` varchar(20) NOT NULL,
  `msg_contato` text NOT NULL,
  `data_contato` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_contato` int(11) NOT NULL DEFAULT 0 COMMENT '0 = não visto, 1 = ignorado, 2 = resolvendo, 3 = resolvido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fale_conosco`
--

INSERT INTO `fale_conosco` (`id_contato`, `nome_contato`, `email_contato`, `motivo_contato`, `fone_contato`, `msg_contato`, `data_contato`, `status_contato`) VALUES
(1, 'Teste contato', 'email@email.com', 3, '(21) 56165-1651', 'dsadsadasasd', '2021-09-04 13:45:46', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `motivos_saida_usuario`
--

CREATE TABLE `motivos_saida_usuario` (
  `id_mot_saida_usuario` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_del_motivo` int(11) NOT NULL,
  `outro_del_motivo` varchar(75) DEFAULT NULL COMMENT 'preencher caso id_del_motivo = 1',
  `data_del_conta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `motivos_saida_usuario`
--

INSERT INTO `motivos_saida_usuario` (`id_mot_saida_usuario`, `id_usuario`, `id_del_motivo`, `outro_del_motivo`, `data_del_conta`) VALUES
(1, 2, 10, NULL, '2021-09-04 13:46:41'),
(2, 2, 9, NULL, '2021-09-04 13:46:41'),
(3, 2, 1, 'A plataforma tem poucos usuários', '2021-09-04 13:46:41'),
(4, 1, 11, NULL, '2021-09-07 18:16:18'),
(5, 1, 5, NULL, '2021-09-07 18:16:18'),
(6, 1, 4, NULL, '2021-09-07 18:16:18'),
(7, 1, 9, NULL, '2021-09-07 18:16:18');

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
  `data_public_servico` timestamp NULL DEFAULT current_timestamp(),
  `nota_media_servico` decimal(2,1) DEFAULT NULL,
  `status_servico` int(11) DEFAULT 1 COMMENT '0 = suspenso, 1 = disponível, 2 = denunciado/banido',
  `qnt_visualizacoes_servico` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `id_prestador_servico`, `nome_servico`, `tipo_servico`, `desc_servico`, `orcamento_servico`, `crit_orcamento_servico`, `data_public_servico`, `nota_media_servico`, `status_servico`, `qnt_visualizacoes_servico`) VALUES
(1, 1, 'Ajuda na mudança de casa', 1, 'ajudo com o transporte na mudança de casa', '20.00', 'por quilo', '2021-09-07 12:52:11', NULL, 0, 0),
(2, 1, 'Montagem completa de PC', 1, 'Me diga sua necessidade e eu monto um pc com as peças ideais para você', NULL, 'A definir orcamento', '2021-09-07 12:53:32', '5.0', 0, 0),
(3, 1, 'Desenvolvimento de site', 0, 'faço site', '100.00', 'por página', '2021-09-07 12:54:23', '4.0', 0, 0),
(4, 2, 'conserto de eletrodoméstico', 1, 'Seus eletrodomésticos ficarão novinhos em folha', NULL, 'A definir orcamento', '2021-09-07 15:10:30', NULL, 1, 0),
(5, 2, 'Matador de insetos', 1, 'mato os insetos ', '100.00', 'por serviço', '2021-09-07 15:12:33', NULL, 1, 0),
(6, 1, 'Adestrador de cachorro', 1, 'adestro cachorro', '80.00', 'por hora', '2021-09-07 16:54:43', NULL, 0, 0);

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

--
-- Extraindo dados da tabela `servico_categorias`
--

INSERT INTO `servico_categorias` (`id_servico_categoria`, `id_servico`, `id_categoria`, `id_subcategoria`) VALUES
(1, 1, 8, 89),
(2, 1, 8, 90),
(3, 1, 8, 92),
(4, 2, 1, 1),
(5, 2, 1, 2),
(6, 2, 1, 7),
(7, 3, 1, 6),
(8, 4, 7, 74),
(9, 4, 7, 77),
(10, 4, 7, 88),
(11, 5, 5, 43),
(12, 5, 5, 44),
(13, 6, 2, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_imagens`
--

CREATE TABLE `servico_imagens` (
  `id_imagem` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `dir_servico_imagem` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servico_imagens`
--

INSERT INTO `servico_imagens` (`id_imagem`, `id_servico`, `dir_servico_imagem`) VALUES
(1, 1, 'user1/service_images/service1/16310191326137607c21ae7.jpg'),
(2, 1, 'user1/service_images/service1/16310191326137607c2ab63.jpg'),
(3, 2, 'user1/service_images/service2/1631019212613760ccb199a.jpg'),
(4, 2, 'user1/service_images/service2/1631019212613760ccb4dd7.jpg'),
(5, 3, 'user1/service_images/service3/1631019263613760ffe08bc.png'),
(6, 3, 'user1/service_images/service3/1631019263613760ffe98ec.jpg'),
(7, 3, 'user1/service_images/service3/1631019263613760fff2e3d.jpg'),
(8, 4, 'user2/service_images/service4/1631027430613780e624143.png'),
(9, 4, 'user2/service_images/service4/1631027430613780e62703c.jpg'),
(10, 4, 'user2/service_images/service4/1631027430613780e63076a.jpg'),
(11, 5, 'user2/service_images/service5/16310275536137816114300.jpg'),
(12, 6, 'user1/service_images/service6/1631033683613799537ea52.jpg'),
(13, 6, 'user1/service_images/service6/1631033683613799538193a.jpg'),
(14, 6, 'user1/service_images/service6/16310336836137995384d38.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id_subcategoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nome_subcategoria` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `subcategorias`
--

INSERT INTO `subcategorias` (`id_subcategoria`, `id_categoria`, `nome_subcategoria`) VALUES
(1, 1, 'Configurações e programações de sistemas informáticos'),
(2, 1, 'Montagem e instalação de computadores'),
(3, 1, 'Correção de defeitos nas redes/equipamentos'),
(4, 1, 'Desenvolvimento e instalação de softwares'),
(5, 1, 'Desenvolvimento de sistemas para computadores'),
(6, 1, 'Desenvolvimento de websites na internet'),
(7, 1, 'Cabeamento e redes'),
(8, 2, 'Adestrador de Cachorro'),
(9, 2, 'Medicina veterinária'),
(10, 2, 'Passeador de Cachorro'),
(11, 3, 'Assessor de Eventos'),
(12, 3, 'Bandas e Cantores'),
(13, 3, 'Bartender'),
(14, 3, 'Brindes e Lembranças '),
(15, 3, 'Churrasqueiro'),
(16, 3, 'Confeiteiro'),
(17, 3, 'Decoração'),
(18, 3, 'Food Truck'),
(19, 3, 'Fotógrafo'),
(20, 3, 'Garçons'),
(21, 3, 'Recepcionista'),
(22, 3, 'Manobrista'),
(23, 3, 'Organização de Eventos'),
(24, 4, 'Alfaiate'),
(25, 4, 'Artesanato'),
(26, 4, 'Barbeiro'),
(27, 4, 'Bronzeamento'),
(28, 4, 'Cabeleireiros'),
(29, 4, 'Corte e Custura'),
(30, 4, 'Depilação'),
(31, 4, 'Designer de Cílios'),
(32, 4, 'Designer de Sobrancelhas'),
(33, 4, 'Esteticista'),
(34, 4, 'Estilista'),
(35, 4, 'Minucure e Pedicure'),
(36, 4, 'Maquiador'),
(37, 4, 'Micropigmentador'),
(38, 4, 'Sapateiro'),
(39, 5, 'Limpeza de Vidro'),
(40, 5, 'Limpeza Pós-Obras'),
(41, 5, 'Limpeza de caixa da água'),
(42, 5, 'Limpeza de Calha'),
(43, 5, 'Higienização de colchões'),
(44, 5, 'Dedetização'),
(45, 5, 'Auxiliar de serviços gerais'),
(46, 6, 'Arquiteto'),
(47, 6, 'Chaveiro'),
(48, 6, 'Decorador'),
(49, 6, 'Desentupidor'),
(50, 6, 'Eletricista Residencial'),
(51, 6, 'Eletricista Industrial'),
(52, 6, 'Eletricista Automobilístico'),
(53, 6, 'Encanador'),
(54, 6, 'Engenheiro'),
(55, 6, 'Gesso e DryWall'),
(56, 6, 'Instalador de eletrônicos'),
(57, 6, 'Instalação de Papel de Parede'),
(58, 6, 'Isolamentos Térmicos e Acústicos'),
(59, 6, 'Jardinagem'),
(60, 6, 'Lazer e Recreação'),
(61, 6, 'Limpeza de Vidro'),
(62, 6, 'Limpeza Pós-Obras'),
(63, 6, 'Marceneiro'),
(64, 6, 'Marido de Aluguel'),
(65, 6, 'Mecânico'),
(66, 6, 'Montador de móveis'),
(67, 6, 'Pedreiro'),
(68, 6, 'Pintor'),
(69, 6, 'Reciclagem'),
(70, 6, 'Remoção de Entulho'),
(71, 6, 'Serralheiro'),
(72, 6, 'Soldagem'),
(73, 6, 'Vidraceiro'),
(74, 7, 'Assitência Técnica de eletro domésticos'),
(75, 7, 'Assitência técnica de Ar condicionado'),
(76, 7, 'Assitência técnica de Fogão'),
(77, 7, 'Assitência técnica de Geladeira'),
(78, 7, 'Assitência técnica de Microondas'),
(79, 7, 'Assitência Técnica de Eletronicos'),
(80, 7, 'Assitência Técnica de TV'),
(81, 7, 'Assitência Técnica de Notebook'),
(82, 7, 'Assitência Técnica de Computador'),
(83, 7, 'Assitência Técnica de Caixa de Som'),
(84, 7, 'Assitência Técnica de Celular'),
(85, 7, 'Assitência Técnica de Tablet '),
(86, 7, 'Assitência Técnica de Impressora'),
(87, 7, 'Assitência Técnica de Video Game'),
(88, 7, 'Assistência Técnica de Aquecedor a Gás'),
(89, 8, 'Mudança Residencial Completa'),
(90, 8, 'Carreto'),
(91, 8, 'Frete de Objetos e Caixas leves'),
(92, 8, 'Transporte de eletrodomésticos'),
(93, 9, 'Artes'),
(94, 9, 'Artesanato'),
(95, 9, 'Beleza'),
(96, 9, 'Dança'),
(97, 9, 'Desenvolvimento Web'),
(98, 9, 'Educação Especial'),
(99, 9, 'Escolares e Reforço'),
(100, 9, 'Fotografia'),
(101, 9, 'Gastronia'),
(102, 9, 'Idiomas'),
(103, 9, 'Informática'),
(104, 9, 'Luta'),
(105, 9, 'Moda'),
(106, 9, 'Música'),
(107, 10, 'Babá'),
(108, 10, 'Cozinheira'),
(109, 10, 'Diarista'),
(110, 10, 'Empregada Doméstica'),
(111, 10, 'Faxineira'),
(112, 10, 'Lavadeira'),
(113, 10, 'Lavagem de Cortinas, Persianas e Tapetes'),
(114, 10, 'Mensalista'),
(115, 10, 'Passadeira');

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
  `data_entrada_usuario` timestamp NULL DEFAULT current_timestamp(),
  `desc_usuario` text DEFAULT NULL,
  `site_usuario` varchar(40) DEFAULT NULL,
  `status_usuario` int(11) NOT NULL DEFAULT 1 COMMENT '0 = suspenso, 1 = ativo, 2 = denunciado/banido',
  `imagem_usuario` varchar(60) DEFAULT 'no_picture.jpg',
  `nota_media_usuario` decimal(2,1) DEFAULT NULL,
  `posicao_usuario` point DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `sobrenome_usuario`, `fone_usuario`, `email_usuario`, `senha_usuario`, `data_nasc_usuario`, `sexo_usuario`, `classif_usuario`, `cep_usuario`, `uf_usuario`, `cidade_usuario`, `bairro_usuario`, `rua_usuario`, `numero_usuario`, `comple_usuario`, `data_entrada_usuario`, `desc_usuario`, `site_usuario`, `status_usuario`, `imagem_usuario`, `nota_media_usuario`, `posicao_usuario`) VALUES
(1, 'Lauro', 'Gomes', '(11) 95789-6526', 'lauringamesbr@gmail.com', 'senha2222', '2003-07-28', 'M', 1, '09771220', 'SP', 'São Bernardo do Campo', 'Nova Petrópolis', 'Rua Ernesta Pelosini', '14', NULL, '2021-08-30 17:04:07', 'Caso se interesse por um serviço, chama pv', 'https://www.lauro.com', 0, 'user1/profile_image/163101887361375f790b7ce.png', '4.5', 0x00000000010100000024b4e55c8ab337c018b2bad5734647c0),
(2, 'Natan', 'Barbosa', '(11) 99182-5452', 'natanbarbosa525@gmail.com', 'temp1234', '2003-07-28', 'M', 1, '09771220', 'SP', 'São Bernardo do Campo', 'Nova Petrópolis', 'Rua Ernesta Pelosini', '23', NULL, '2021-09-01 11:36:21', NULL, NULL, 1, 'user2/profile_image/1631020084613764344cd0e.jpg', NULL, 0x00000000010100000024b4e55c8ab337c018b2bad5734647c0);

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
-- Extraindo dados da tabela `usuario_redes_sociais`
--

INSERT INTO `usuario_redes_sociais` (`id_rede_social`, `id_usuario`, `rede_social`, `nick_rede_social`, `link_rede_social`) VALUES
(1, 1, 'instagram', '@lauro_gomes', 'https://www.instagram.com/lauro_gomes'),
(2, 1, 'facebook', NULL, NULL),
(3, 1, 'twitter', '@lauro_gomes', 'https://twitter.com/lauro_gomes'),
(4, 1, 'linkedin', NULL, NULL),
(5, 2, 'instagram', NULL, NULL),
(6, 2, 'facebook', NULL, NULL),
(7, 2, 'twitter', NULL, NULL),
(8, 2, 'linkedin', NULL, NULL);

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
  ADD KEY `FK_ComentarioDenuncia` (`id_comentario`),
  ADD KEY `FK_MotivoDenunciaComen` (`id_denuncia_motivo`),
  ADD KEY `FK_UsuarioDenunciaComen` (`id_usuario`);

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
  ADD KEY `FK_MotivoDenuncia` (`id_denuncia_motivo`),
  ADD KEY `FK_UsuarioDenunciaServ` (`id_usuario`);

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
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `deletar_conta_motivos`
--
ALTER TABLE `deletar_conta_motivos`
  MODIFY `id_del_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `denuncia_comentario`
--
ALTER TABLE `denuncia_comentario`
  MODIFY `id_denuncia_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `denuncia_motivo`
--
ALTER TABLE `denuncia_motivo`
  MODIFY `id_denuncia_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  MODIFY `id_denuncia_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `motivos_saida_usuario`
--
ALTER TABLE `motivos_saida_usuario`
  MODIFY `id_mot_saida_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico_categorias`
--
ALTER TABLE `servico_categorias`
  MODIFY `id_servico_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `FK_ComentarioDenuncia` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id_comentario`),
  ADD CONSTRAINT `FK_MotivoDenunciaComen` FOREIGN KEY (`id_denuncia_motivo`) REFERENCES `denuncia_motivo` (`id_denuncia_motivo`),
  ADD CONSTRAINT `FK_UsuarioDenunciaComen` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  ADD CONSTRAINT `FK_MotivoDenuncia` FOREIGN KEY (`id_denuncia_motivo`) REFERENCES `denuncia_motivo` (`id_denuncia_motivo`),
  ADD CONSTRAINT `FK_ServicoDenuncia` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`),
  ADD CONSTRAINT `FK_UsuarioDenunciaServ` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

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
