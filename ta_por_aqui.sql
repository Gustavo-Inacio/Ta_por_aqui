-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Out-2021 às 11:35
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
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id_adm` int(11) NOT NULL,
  `email_adm` varchar(40) NOT NULL,
  `senha_adm` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id_adm`, `email_adm`, `senha_adm`) VALUES
(1, 'adm@taporaqui.com', 'admtaporaqui123');

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
-- Estrutura da tabela `chat_contatos`
--

CREATE TABLE `chat_contatos` (
  `id_chat_contato` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `status_chat_contato` int(11) NOT NULL DEFAULT 1 COMMENT '0 = contato bloqueado, 1 = contato desbloqueado',
  `quem_bloqueou_contato` int(11) DEFAULT NULL,
  `criacao_chat_contato` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_att_contato` timestamp NULL DEFAULT NULL,
  `id_prestador` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `chat_contatos`
--

INSERT INTO `chat_contatos` (`id_chat_contato`, `id_servico`, `status_chat_contato`, `quem_bloqueou_contato`, `criacao_chat_contato`, `ultima_att_contato`, `id_prestador`, `id_cliente`) VALUES
(4, 2, 1, NULL, '2021-10-03 13:01:41', '2021-10-06 14:45:32', 3, 1),
(5, 1, 1, NULL, '2021-10-03 13:21:23', '2021-10-09 14:14:43', 1, 2),
(7, 3, 1, NULL, '2021-10-06 14:44:22', '2021-10-07 12:07:05', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat_contatos_favoritos`
--

CREATE TABLE `chat_contatos_favoritos` (
  `id_chat_favorito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_chat_contato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat_mensagens`
--

CREATE TABLE `chat_mensagens` (
  `id_chat_mensagem` int(11) NOT NULL,
  `id_chat_contato` int(11) NOT NULL,
  `id_remetente_usuario` int(11) NOT NULL,
  `id_destinatario_usuario` int(11) NOT NULL,
  `mensagem_chat` text COLLATE utf8mb4_bin NOT NULL,
  `diretorio_arquivo_chat` varchar(75) COLLATE utf8mb4_bin DEFAULT NULL,
  `apelido_arquivo_chat` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `hora_mensagem_chat` timestamp NOT NULL DEFAULT current_timestamp(),
  `mensagem_lida` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `chat_mensagens`
--

INSERT INTO `chat_mensagens` (`id_chat_mensagem`, `id_chat_contato`, `id_remetente_usuario`, `id_destinatario_usuario`, `mensagem_chat`, `diretorio_arquivo_chat`, `apelido_arquivo_chat`, `hora_mensagem_chat`, `mensagem_lida`) VALUES
(3, 5, 1, 2, 'oiiiiiiiiiiiiiiiiiii', NULL, NULL, '2021-10-03 14:13:32', 1),
(4, 5, 2, 1, 'opa', NULL, NULL, '2021-10-03 14:13:38', 1),
(6, 5, 1, 2, 'ola\ntudo bem?', NULL, NULL, '2021-10-03 14:39:29', 1),
(7, 5, 2, 1, 'de boa mano? e ai?', NULL, NULL, '2021-10-03 14:40:08', 1),
(8, 5, 1, 2, 'tranquilo poh, kk', NULL, NULL, '2021-10-03 15:15:48', 1),
(9, 5, 1, 2, 'arquivo', 'contato5/16332742336159c979d8113.png', '67cbe9b74baf7f893488c5fc426d31eb.png', '2021-10-03 15:17:13', 1),
(10, 5, 2, 1, 'arquivo', 'contato5/16332758856159cfed09f5d.mp4', 'yt1s.com - MELTING VERSION DILUC TEARING APART 123_480p.mp4', '2021-10-03 15:44:45', 1),
(11, 5, 1, 2, 'arquivo', 'contato5/16332762736159d171469d3.mp3', 'Haikyuu - Team Potential (Extend) 20mins _160k.mp3', '2021-10-03 15:51:13', 1),
(12, 5, 1, 2, 'arquivo', 'contato5/16332773546159d5aa132d6.sql', 'ta_por_aqui.sql', '2021-10-03 16:09:14', 1),
(13, 5, 2, 1, 'teste mensagem visualizada', NULL, NULL, '2021-10-05 13:57:12', 1),
(14, 5, 1, 2, 'outro teste', NULL, NULL, '2021-10-05 15:05:29', 1),
(15, 5, 2, 1, 'lida?', NULL, NULL, '2021-10-05 15:06:34', 1),
(16, 5, 2, 1, 'lida?', NULL, NULL, '2021-10-05 15:06:45', 1),
(17, 5, 2, 1, 'lida?', NULL, NULL, '2021-10-05 15:08:19', 1),
(18, 5, 1, 2, 'leu', NULL, NULL, '2021-10-05 15:12:46', 1),
(19, 5, 2, 1, 'leu', NULL, NULL, '2021-10-05 15:12:52', 1),
(20, 5, 1, 2, 'não leu', NULL, NULL, '2021-10-05 15:13:02', 1),
(21, 5, 2, 1, 'não leu', NULL, NULL, '2021-10-05 15:13:33', 1),
(22, 5, 2, 1, 'leu', NULL, NULL, '2021-10-05 15:13:36', 1),
(23, 5, 2, 1, 'teste popover chat', NULL, NULL, '2021-10-05 15:16:41', 1),
(24, 5, 1, 2, 'ala, para de ler minha msg mano', NULL, NULL, '2021-10-05 15:16:51', 1),
(25, 5, 1, 2, 'mó chato', NULL, NULL, '2021-10-05 15:16:58', 1),
(26, 5, 2, 1, 'ok', NULL, NULL, '2021-10-05 15:17:08', 1),
(27, 5, 2, 1, '1', NULL, NULL, '2021-10-05 16:08:44', 1),
(28, 5, 2, 1, '2', NULL, NULL, '2021-10-05 16:08:54', 1),
(29, 5, 2, 1, '3', NULL, NULL, '2021-10-05 16:08:55', 1),
(30, 5, 2, 1, '4', NULL, NULL, '2021-10-05 16:12:13', 1),
(31, 5, 1, 2, 'teste', NULL, NULL, '2021-10-05 16:15:11', 1),
(32, 5, 1, 2, 'mais', NULL, NULL, '2021-10-05 17:10:41', 1),
(33, 5, 1, 2, 'um', NULL, NULL, '2021-10-05 17:10:43', 1),
(34, 5, 1, 2, 'teste', NULL, NULL, '2021-10-05 17:10:45', 1),
(35, 5, 2, 1, 'cala boca mlk', NULL, NULL, '2021-10-05 17:15:54', 1),
(37, 4, 1, 3, 'Olá senhor Edson, tudo bom? Estou interessado em seus serviços', NULL, NULL, '2021-10-05 22:11:34', 1),
(38, 4, 3, 1, 'Boa noite, fico feliz de poder ajudar o senhor. Pode me especificar mais o seu problema?', NULL, NULL, '2021-10-05 22:12:03', 1),
(39, 4, 1, 3, 'Claro... O problema é que a tela do meu celular está branca quando eu ligo, não importa o que eu faço', NULL, NULL, '2021-10-05 22:12:38', 1),
(40, 4, 1, 3, 'Vou enviar uma foto da situação', NULL, NULL, '2021-10-05 22:12:56', 1),
(41, 4, 1, 3, 'arquivo', 'contato4/1633472059615cce3b28c68.jpg', 'tela branca.jpg', '2021-10-05 22:14:19', 1),
(42, 5, 1, 2, 'desce', NULL, NULL, '2021-10-05 22:49:25', 1),
(43, 5, 1, 2, 'teste', NULL, NULL, '2021-10-05 23:06:40', 1),
(44, 5, 2, 1, 'teste', NULL, NULL, '2021-10-05 23:24:05', 1),
(45, 5, 2, 1, 'asdsad', NULL, NULL, '2021-10-06 00:27:09', 1),
(46, 5, 1, 2, 'dame dame', NULL, NULL, '2021-10-06 01:57:13', 1),
(47, 5, 1, 2, 'dameio', NULL, NULL, '2021-10-06 01:57:15', 1),
(48, 5, 1, 2, 'dame damoyooo', NULL, NULL, '2021-10-06 01:57:19', 1),
(49, 5, 1, 2, 'antada', NULL, NULL, '2021-10-06 01:57:21', 1),
(50, 5, 1, 2, 'sukide', NULL, NULL, '2021-10-06 01:57:23', 1),
(51, 5, 1, 2, 'suki sukite', NULL, NULL, '2021-10-06 01:57:27', 1),
(52, 5, 1, 2, 'doredake', NULL, NULL, '2021-10-06 01:57:29', 1),
(53, 5, 1, 2, 'arquivo', 'contato5/1633485485615d02ad4b5e6.mp4', 'tanka-speedrun.mp4', '2021-10-06 01:58:05', 1),
(54, 5, 1, 2, 'dadasdasda', NULL, NULL, '2021-10-06 12:13:43', 1),
(55, 5, 1, 2, 'dsadsadsa', NULL, NULL, '2021-10-06 12:13:51', 1),
(56, 5, 2, 1, '😆😃😃😃😃😃😃', NULL, NULL, '2021-10-06 12:14:40', 1),
(57, 5, 2, 1, 'arquivo', 'contato5/1633522493615d933de697b.jpg', 'R.jpg', '2021-10-06 12:14:53', 1),
(58, 5, 2, 1, 'arquivo', 'contato5/1633522530615d9362dba51.mp3', 'Haikyuu - Team Potential (Extend) 20mins _160k.mp3', '2021-10-06 12:15:30', 1),
(59, 5, 1, 2, 'arquivo', 'contato5/1633522716615d941cbb559.pdf', 'UML-caso-de-uso.pdf', '2021-10-06 12:18:36', 1),
(75, 5, 1, 2, 'youtube.com/pele', NULL, NULL, '2021-10-06 15:20:56', 1),
(77, 5, 1, 2, 'Ta funcionando?', NULL, NULL, '2021-10-07 13:16:38', 1),
(78, 5, 1, 2, 'ok, está!', NULL, NULL, '2021-10-07 13:16:42', 1),
(79, 5, 2, 1, 'oiiiiiii????????', NULL, NULL, '2021-10-09 13:35:51', 0),
(80, 5, 2, 1, 'hola maestro', NULL, NULL, '2021-10-09 13:36:44', 0),
(81, 5, 2, 1, '😍😍😍', NULL, NULL, '2021-10-09 14:14:43', 0);

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
  `status_comentario` int(11) NOT NULL DEFAULT 1 COMMENT '0 = excluído, 1 = exibido, 2 = suspenso com usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_servico`, `id_usuario`, `nota_comentario`, `desc_comentario`, `data_comentario`, `status_comentario`) VALUES
(1, 1, 1, '4.0', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkk. Meu próprio serviço é muito bom', '2021-10-06 12:31:25', 1);

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
(1, 1, 2, 1, '2021-09-27 12:32:29', 1),
(2, 1, 3, 1, '2021-09-29 16:06:57', 0),
(3, 2, 1, 3, '2021-10-03 13:01:28', 1),
(4, 1, 1, 1, '2021-10-06 12:29:50', 1),
(5, 3, 1, 2, '2021-10-06 14:44:20', 0);

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `fale_conosco`
--

CREATE TABLE `fale_conosco` (
  `id_contato` int(11) NOT NULL,
  `nome_contato` varchar(30) NOT NULL,
  `email_contato` varchar(40) NOT NULL,
  `motivo_contato` int(11) NOT NULL COMMENT '1 = Elogios, 2 = Sugestões, 3 = Reclamações, 4 = Problemas/bugs, 5 = Outros, 6 = Contestação de banimento',
  `fone_contato` varchar(20) NOT NULL,
  `msg_contato` text NOT NULL,
  `data_contato` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_contato` int(11) NOT NULL DEFAULT 0 COMMENT '0 = não visto, 1 = ignorado, 2 = resolvendo, 3 = resolvido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fale_conosco`
--

INSERT INTO `fale_conosco` (`id_contato`, `nome_contato`, `email_contato`, `motivo_contato`, `fone_contato`, `msg_contato`, `data_contato`, `status_contato`) VALUES
(1, 'Teste contato', 'email@email.com', 3, '(21) 56165-1651', 'dsadsadasasd', '2021-09-04 13:45:46', 3),
(2, 'Natan Barbosa', 'natanbarbosa525@gmail.com', 4, '(11) 99182-5452', 'Não consegui me cadastrar. Não recebi o email', '2021-09-08 17:13:54', 3),
(3, 'Lucas Silva', 'email@gmail.com', 1, '(99) 99999-9999', 'Plataforma muito boa. Já me rendeu uma boa grana', '2021-09-08 17:14:30', 2),
(4, 'Cleiton Maciel', 'cletin@gmail.com', 3, '(14) 64865-4654', 'Plataforma sem segurança nenhuma. Hackearam meu serviço', '2021-09-08 17:15:08', 0),
(5, 'Lauro Gomes', 'LauroGomes@gmail.com', 4, '(11) 95789-6526', 'Não me é enviado o email de cadastro quando tento criar uma nova conta. O programa exibe uma mensagem de erro com código 7.', '2021-09-10 21:10:41', 0),
(6, 'Lauro Gomes', 'lauringamesbr@gmail.com', 6, '(11) 95789-6526', 'Tira o ban do meu serviço. O id dele é 10', '2021-09-10 21:35:37', 1);

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
  `status_servico` int(11) DEFAULT 1 COMMENT '0 = suspenso, 1 = disponível, 2 = denunciado/banido, 3 = ocultado pelo user',
  `qnt_visualizacoes_servico` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `id_prestador_servico`, `nome_servico`, `tipo_servico`, `desc_servico`, `orcamento_servico`, `crit_orcamento_servico`, `data_public_servico`, `nota_media_servico`, `status_servico`, `qnt_visualizacoes_servico`) VALUES
(1, 1, 'Desenvolvimento de site', 0, 'Desenvolvo um site para o seu negócio', NULL, 'A definir orcamento', '2021-09-27 12:31:25', '4.0', 1, 0),
(2, 3, 'Conserto celular', 1, 'mldnaskjfas', NULL, 'A definir orcamento', '2021-09-29 22:05:33', NULL, 1, 0),
(3, 2, 'Vendedor de canela', 1, 'Eu virei vendedor de canela\r\nnão vendo manjericção\r\nsó vendo canela ya\r\nsoca nela ya\r\nsoca soca nela ya', '50.00', 'por canela', '2021-10-06 14:44:06', NULL, 1, 0);

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
(1, 1, 1, 1),
(2, 1, 1, 5),
(3, 1, 1, 6),
(4, 2, 7, 84),
(5, 3, 3, 11),
(6, 3, 3, 13),
(7, 3, 3, 15);

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
(1, 1, 'user1/service_images/service1/16327458856151b99de0d6b.jpg'),
(2, 1, 'user1/service_images/service1/16327458856151b99df04b1.jpg'),
(3, 1, 'user1/service_images/service1/16327458866151b99e052ce.jpg'),
(4, 2, 'user3/service_images/service2/16329531336154e32d343c5.png'),
(5, 2, 'user3/service_images/service2/16329531336154e32d376e8.jpg'),
(6, 2, 'user3/service_images/service2/16329531336154e32d426d0.jpg'),
(7, 3, 'user2/service_images/service3/1633531446615db6366c789.jpg'),
(8, 3, 'user2/service_images/service3/1633531446615db6366fa76.jpg');

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
(115, 10, 'Passadeira'),
(116, 9, 'professor de balé'),
(117, 10, 'madame');

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
  `senha_usuario` char(40) NOT NULL,
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
  `online_usuario` tinyint(1) NOT NULL DEFAULT 1,
  `imagem_usuario` varchar(60) DEFAULT 'no_picture.jpg',
  `nota_media_usuario` decimal(2,1) DEFAULT NULL,
  `posicao_usuario` point DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `sobrenome_usuario`, `fone_usuario`, `email_usuario`, `senha_usuario`, `data_nasc_usuario`, `sexo_usuario`, `classif_usuario`, `cep_usuario`, `uf_usuario`, `cidade_usuario`, `bairro_usuario`, `rua_usuario`, `numero_usuario`, `comple_usuario`, `data_entrada_usuario`, `desc_usuario`, `site_usuario`, `status_usuario`, `online_usuario`, `imagem_usuario`, `nota_media_usuario`, `posicao_usuario`) VALUES
(1, 'Jayden', 'Barbosa', '(45) 78451-2336', 'natanbarbosa@vivaldi.net', '14240d95986f1c26d62c5b5c70bf3d81ef49f9c0', '2000-04-25', 'F', 2, '68500310', 'PA', 'Marabá', 'Velha Marabá', 'Rua Magalhães Barata', '89', 'ap 14B', '2021-09-22 13:06:32', NULL, NULL, 1, 0, 'user1/profile_image/16329342236154994f61a3b.png', '4.0', 0x0000000001010000002ba4fca4da6715c03eae0d15e39048c0),
(2, 'Everton', 'Silva', '(75) 13235-4845', 'lauringamesbr@gmail.com', '14240d95986f1c26d62c5b5c70bf3d81ef49f9c0', '2000-09-02', 'M', 1, '09771200', 'SP', 'São Bernardo do Campo', 'Nova Petrópolis', 'Rua Professor Antônio Prudente', '78', NULL, '2021-09-27 12:28:14', NULL, NULL, 1, 0, 'user2/profile_image/1632933749615497755c9b0.jpg', NULL, 0x000000000101000000cea5b8aaecb337c0ee3d5c72dc4547c0),
(3, 'Edson', 'José', '(12) 45784-5265', 'natanbarbosa525@gmail.com', '14240d95986f1c26d62c5b5c70bf3d81ef49f9c0', '2000-07-02', 'M', 1, '57046782', 'AL', 'Maceió', 'Serraria', 'Rua Euclides Gonçalves Navarro', '45', NULL, '2021-09-29 16:05:01', '', '', 1, 0, 'user3/profile_image/1633471796615ccd347e5ac.jpg', NULL, 0x00000000010100000063d17476323823c05bd3bce314dd41c0),
(4, 'Macintosh', 'Destroyer', '(14) 95165-2316', 'kowevap225@cantouri.com', '14240d95986f1c26d62c5b5c70bf3d81ef49f9c0', '2000-07-19', 'O', 0, '65076902', 'MA', 'São Luís', 'São Francisco', 'Avenida Ana Jansen 200', '45', NULL, '2021-10-02 22:03:12', NULL, NULL, 1, 0, 'no_picture.jpg', NULL, 0x00000000010100000022a64412bd0c04c017f19d98f52646c0);

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
(13, 4, 'instagram', NULL, NULL),
(14, 4, 'facebook', NULL, NULL),
(15, 4, 'twitter', NULL, NULL),
(16, 4, 'linkedin', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_adm`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `chat_contatos`
--
ALTER TABLE `chat_contatos`
  ADD PRIMARY KEY (`id_chat_contato`),
  ADD KEY `FK_ServicoContato` (`id_servico`),
  ADD KEY `FK_UsuarioCliente` (`id_cliente`),
  ADD KEY `FK_UsuarioPrestador` (`id_prestador`),
  ADD KEY `FK_quemBloqueouContatoUsuario` (`quem_bloqueou_contato`);

--
-- Índices para tabela `chat_contatos_favoritos`
--
ALTER TABLE `chat_contatos_favoritos`
  ADD PRIMARY KEY (`id_chat_favorito`),
  ADD KEY `FK_ChatContatoFavorito` (`id_chat_contato`),
  ADD KEY `FK_UsuarioChatFavorito` (`id_usuario`);

--
-- Índices para tabela `chat_mensagens`
--
ALTER TABLE `chat_mensagens`
  ADD PRIMARY KEY (`id_chat_mensagem`),
  ADD KEY `FK_ContatoChatMensagens` (`id_chat_contato`),
  ADD KEY `FK_UsuarioDestinatario` (`id_destinatario_usuario`),
  ADD KEY `FK_UsuarioRemetente` (`id_remetente_usuario`);

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
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `chat_contatos`
--
ALTER TABLE `chat_contatos`
  MODIFY `id_chat_contato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `chat_contatos_favoritos`
--
ALTER TABLE `chat_contatos_favoritos`
  MODIFY `id_chat_favorito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `chat_mensagens`
--
ALTER TABLE `chat_mensagens`
  MODIFY `id_chat_mensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id_denuncia_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `denuncia_servico`
--
ALTER TABLE `denuncia_servico`
  MODIFY `id_denuncia_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fale_conosco`
--
ALTER TABLE `fale_conosco`
  MODIFY `id_contato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `motivos_saida_usuario`
--
ALTER TABLE `motivos_saida_usuario`
  MODIFY `id_mot_saida_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servicos_salvos`
--
ALTER TABLE `servicos_salvos`
  MODIFY `id_servico_salvo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico_categorias`
--
ALTER TABLE `servico_categorias`
  MODIFY `id_servico_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `servico_imagens`
--
ALTER TABLE `servico_imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario_redes_sociais`
--
ALTER TABLE `usuario_redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `chat_contatos`
--
ALTER TABLE `chat_contatos`
  ADD CONSTRAINT `FK_ServicoContato` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`),
  ADD CONSTRAINT `FK_UsuarioCliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `FK_UsuarioPrestador` FOREIGN KEY (`id_prestador`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `FK_quemBloqueouContatoUsuario` FOREIGN KEY (`quem_bloqueou_contato`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `chat_contatos_favoritos`
--
ALTER TABLE `chat_contatos_favoritos`
  ADD CONSTRAINT `FK_ChatContatoFavorito` FOREIGN KEY (`id_chat_contato`) REFERENCES `chat_contatos` (`id_chat_contato`),
  ADD CONSTRAINT `FK_UsuarioChatFavorito` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `chat_mensagens`
--
ALTER TABLE `chat_mensagens`
  ADD CONSTRAINT `FK_ContatoChatMensagens` FOREIGN KEY (`id_chat_contato`) REFERENCES `chat_contatos` (`id_chat_contato`),
  ADD CONSTRAINT `FK_UsuarioDestinatario` FOREIGN KEY (`id_destinatario_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `FK_UsuarioRemetente` FOREIGN KEY (`id_remetente_usuario`) REFERENCES `usuarios` (`id_usuario`);

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
