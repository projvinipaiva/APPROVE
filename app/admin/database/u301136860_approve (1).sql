-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16/09/2024 às 18:41
-- Versão do servidor: 10.11.8-MariaDB-cll-lve
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u301136860_approve`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alternativas`
--

CREATE TABLE `alternativas` (
  `alternativa_id` int(11) NOT NULL,
  `texto` varchar(255) NOT NULL,
  `correta` tinyint(1) NOT NULL,
  `pergunta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alternativas`
--

INSERT INTO `alternativas` (`alternativa_id`, `texto`, `correta`, `pergunta_id`) VALUES
(1, 'A) 406', 0, 1),
(2, 'B) 1334', 1, 1),
(3, 'C) 4002', 0, 1),
(4, 'D) 9338', 0, 1),
(5, 'E) 28014', 0, 1),
(6, 'A) 22', 0, 2),
(7, 'B) 25', 0, 2),
(8, 'C) 26', 1, 2),
(9, 'D) 29', 0, 2),
(10, 'E) 36', 0, 2),
(11, 'A) 1 e 2', 0, 3),
(12, 'B) 2 e 2', 0, 3),
(13, 'C) 3 e 1', 0, 3),
(14, 'D) 2 e 1', 0, 3),
(15, 'E) 3 e 3', 1, 3),
(16, 'A) 12', 0, 4),
(17, 'B) 14', 1, 4),
(18, 'C) 16', 0, 4),
(19, 'D) 32', 0, 4),
(20, 'E) 42', 0, 4),
(21, 'A) A', 0, 5),
(22, 'B) B ', 0, 5),
(23, 'C) C', 0, 5),
(24, 'D) D', 0, 5),
(25, 'E) E', 1, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estatisticas_usuarios`
--

CREATE TABLE `estatisticas_usuarios` (
  `estatistica_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `acertos` int(11) DEFAULT 0,
  `erros` int(11) DEFAULT 0,
  `total_perguntas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `nome`) VALUES
(1, 'PORTUGUÊS'),
(2, 'MATEMÁTICA'),
(3, 'BIOLOGIA'),
(4, 'QUÍMICA'),
(5, 'FÍSICA'),
(6, 'HISTÓRIA'),
(7, 'GEOGRAFIA'),
(8, 'FILOSOFIA'),
(9, 'SOCIOLOGIA'),
(10, 'INGLÊS'),
(11, 'ESPANHOL\r\n');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pdfs`
--

CREATE TABLE `pdfs` (
  `pdf_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `subconteudo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pdfs`
--

INSERT INTO `pdfs` (`pdf_id`, `titulo`, `url`, `subconteudo_id`) VALUES
(1, 'teste', 'https://me-qr.com/sBoPfJmg', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `pergunta_id` int(11) NOT NULL,
  `enunciado` text NOT NULL,
  `questionario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perguntas`
--

INSERT INTO `perguntas` (`pergunta_id`, `enunciado`, `questionario_id`) VALUES
(1, 'A disparidade de volume entre os planetas é tão grande que seria possível colocá-los uns dentro dos outros. O planeta Mercúrio é o menor de todos. Marte é o segundo menor: dentro dele cabem três Mercúrios. Terra é o único com vida: dentro dela cabem sete Martes. Netuno e o quarto maior: dentro dele cabem 58 Terras. Júpiter é o maior dos planetas: dentro dele cabem 23 Netunos.\r\n\r\nRevista Veja. Ano 41, nº. 26, 25 jun. 2008 (adaptado)\r\n\r\nSeguindo o raciocínio proposto, quantas Terras cabem dentro de Júpiter?', 4),
(2, 'Em um torneio interclasses de um colégio, visando estimular o aumento do número de gols nos jogos de futebol, a comissão organizadora estabeleceu a seguinte forma de contagem de pontos para cada partida: uma vitória vale três pontos, um empate com gols vale dois pontos, um empate sem gols vale um ponto e uma derrota vale zero ponto. Após 12 jogos, um dos times obteve como resultados cinco vitórias e sete empates, dos quais, três sem gols.', 4),
(3, 'Na cidade de João e Maria, haverá shows em uma boate. Pensando em todos, a boate propôs pacotes para que os fregueses escolhessem o que seria melhor para si.\r\n\r\nPacote 1: taxa de 40 reais por show.\r\n\r\nPacote 2: taxa de 80 reais mais 10 reais por show.\r\n\r\nPacote 3: taxa de 60 reais para 4 shows, e 15 reais por cada show a mais.\r\n\r\nJoão assistirá a 7 shows e Maria, a 4. As melhores opções para João e Maria são, respectivamente, os pacotes', 4),
(4, 'Um clube de futebol abriu inscrições para novos jogadores. Inscreveram-se 48 candidatos. Para realizar uma boa seleção, deverão ser escolhidos os que cumpram algumas exigências: os jogadores deverão ter mais de 14 anos, estatura igual ou superior à mínima exigida e bom preparo físico. Entre os candidatos, 7/8 têm mais de 14 anos e foram pré-selecionados. Dos pré-selecionados, 1/2 têm estatura igual ou superior à mínima exigida e, destes, 2/3 têm bom preparo físico.\r\n\r\nA quantidade de candidatos selecionados pelo clube de futebol foi', 4),
(5, 'Um paciente precisa ser submetido a um tratamento, sob orientação médica, com determinado medicamento. Há cinco possibilidades de medicação, variando a dosagem e o intervalo de ingestão do medicamento. As opções apresentadas são:\r\n\r\nA: um comprimido de 400 mg, de 3 em 3 horas, durante 1 semana;\r\nB: um comprimido de 400 mg, de 4 em 4 horas, durante 10 dias;\r\nC: um comprimido de 400 mg, de 6 em 6 horas, durante 2 semanas;\r\nD: um comprimido de 500 mg, de 8 em 8 horas, durante 10 dias;\r\nE: um comprimido de 500 mg, de 12 em 12 horas, durante 2 semanas.\r\n\r\nPara evitar efeitos colaterais e intoxicação, a recomendação é que a quantidade total de massa da medicação ingerida, em miligramas, seja a menor possível.\r\n\r\nSeguindo a recomendação, deve ser escolhida a opção', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pontuacoes`
--

CREATE TABLE `pontuacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `pontos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE `questionarios` (
  `questionario_id` int(11) NOT NULL,
  `subconteudo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questionarios`
--

INSERT INTO `questionarios` (`questionario_id`, `subconteudo_id`) VALUES
(3, NULL),
(4, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_usuarios`
--

CREATE TABLE `respostas_usuarios` (
  `resposta_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `pergunta_id` int(11) DEFAULT NULL,
  `alternativa_id` int(11) DEFAULT NULL,
  `correta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `subconteudos`
--

CREATE TABLE `subconteudos` (
  `subconteudo_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `materia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `subconteudos`
--

INSERT INTO `subconteudos` (`subconteudo_id`, `nome`, `materia_id`) VALUES
(1, 'As quatro operações', 2),
(2, 'Equação do 1° grau', 2),
(3, 'Equação do 2° grau', 2),
(4, 'Razão e proporção', 2),
(5, 'Interpretação de texto', 1),
(6, 'Gêneros textuais', 1),
(7, 'Variedade línguistica', 1),
(8, 'Figuras de linguagem', 1),
(9, 'Genética', 3),
(10, 'Ecologia', 3),
(11, 'Citologia', 3),
(12, 'Evolução', 3),
(13, 'Estequiometria', 4),
(14, 'Funções orgânicas', 4),
(15, 'Termoquímica', 4),
(16, 'Reações orgânicas', 4),
(17, 'Ondulatória', 5),
(18, 'Cinemática', 5),
(19, 'Eletrodinâmica', 5),
(20, 'Dinâmica', 5),
(21, 'Brasil colônia', 6),
(22, 'Brasil império', 6),
(23, 'Brasil república', 6),
(24, 'Segunda Guerra Mundial', 6),
(25, 'Urbanização', 7),
(26, 'Meio Ambiente', 7),
(27, 'Demografia', 7),
(28, 'Cartografia', 7),
(29, 'Iluminismo', 8),
(30, 'Contratualismo', 8),
(31, 'Liberalismo', 8),
(32, 'Socialismo', 8),
(33, 'Movimentos sociais', 9),
(34, 'Desigualdades sociais', 9),
(35, 'Cidadania ', 9),
(36, 'Cultura e patrimônio', 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`) VALUES
(1, 'nicolas', 'nicolas@email.com', '123'),
(2, 'Victor', 'victor@email.com', '123'),
(3, 'Júlia', 'julia@email.com', '123'),
(4, 'Paiva', 'paiva@email.com', '123'),
(5, 'Guilherme', 'guilherme@email.com', '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `videoaulas`
--

CREATE TABLE `videoaulas` (
  `videoaula_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `subconteudo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `videoaulas`
--

INSERT INTO `videoaulas` (`videoaula_id`, `titulo`, `url`, `subconteudo_id`) VALUES
(1, 'AS QUATRO OPERAÇÕES', 'https://www.youtube.com/watch?v=751x7-ICCOA', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alternativas`
--
ALTER TABLE `alternativas`
  ADD PRIMARY KEY (`alternativa_id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

--
-- Índices de tabela `estatisticas_usuarios`
--
ALTER TABLE `estatisticas_usuarios`
  ADD PRIMARY KEY (`estatistica_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pdfs`
--
ALTER TABLE `pdfs`
  ADD PRIMARY KEY (`pdf_id`),
  ADD KEY `subconteudo_id` (`subconteudo_id`) USING BTREE;

--
-- Índices de tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`pergunta_id`),
  ADD KEY `questionario_id` (`questionario_id`);

--
-- Índices de tabela `pontuacoes`
--
ALTER TABLE `pontuacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `questionarios`
--
ALTER TABLE `questionarios`
  ADD PRIMARY KEY (`questionario_id`),
  ADD KEY `subconteudo_id` (`subconteudo_id`);

--
-- Índices de tabela `respostas_usuarios`
--
ALTER TABLE `respostas_usuarios`
  ADD PRIMARY KEY (`resposta_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pergunta_id` (`pergunta_id`),
  ADD KEY `alternativa_id` (`alternativa_id`);

--
-- Índices de tabela `subconteudos`
--
ALTER TABLE `subconteudos`
  ADD PRIMARY KEY (`subconteudo_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `videoaulas`
--
ALTER TABLE `videoaulas`
  ADD PRIMARY KEY (`videoaula_id`),
  ADD KEY `subconteudo_id` (`subconteudo_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alternativas`
--
ALTER TABLE `alternativas`
  MODIFY `alternativa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `estatisticas_usuarios`
--
ALTER TABLE `estatisticas_usuarios`
  MODIFY `estatistica_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `pdfs`
--
ALTER TABLE `pdfs`
  MODIFY `pdf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `pergunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pontuacoes`
--
ALTER TABLE `pontuacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `questionario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `respostas_usuarios`
--
ALTER TABLE `respostas_usuarios`
  MODIFY `resposta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subconteudos`
--
ALTER TABLE `subconteudos`
  MODIFY `subconteudo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `videoaulas`
--
ALTER TABLE `videoaulas`
  MODIFY `videoaula_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alternativas`
--
ALTER TABLE `alternativas`
  ADD CONSTRAINT `alternativas_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`pergunta_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `estatisticas_usuarios`
--
ALTER TABLE `estatisticas_usuarios`
  ADD CONSTRAINT `estatisticas_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estatisticas_usuarios_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pdfs`
--
ALTER TABLE `pdfs`
  ADD CONSTRAINT `pdfs_ibfk_1` FOREIGN KEY (`subconteudo_id`) REFERENCES `subconteudos` (`subconteudo_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`questionario_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pontuacoes`
--
ALTER TABLE `pontuacoes`
  ADD CONSTRAINT `pontuacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pontuacoes_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `questionarios`
--
ALTER TABLE `questionarios`
  ADD CONSTRAINT `questionarios_ibfk_1` FOREIGN KEY (`subconteudo_id`) REFERENCES `subconteudos` (`subconteudo_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `respostas_usuarios`
--
ALTER TABLE `respostas_usuarios`
  ADD CONSTRAINT `respostas_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_usuarios_ibfk_2` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`pergunta_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_usuarios_ibfk_3` FOREIGN KEY (`alternativa_id`) REFERENCES `alternativas` (`alternativa_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `subconteudos`
--
ALTER TABLE `subconteudos`
  ADD CONSTRAINT `subconteudos_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `videoaulas`
--
ALTER TABLE `videoaulas`
  ADD CONSTRAINT `videoaulas_ibfk_1` FOREIGN KEY (`subconteudo_id`) REFERENCES `subconteudos` (`subconteudo_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
