--
-- Database: `NewFitnessDB`
--

CREATE DATABASE NewFitnessDB;

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cod_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `cod_perfil` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Test Data Insert
--

INSERT INTO `tb_usuario`
  (`cod_usuario`, `nome`, `endereco`, `telefone`, `email`, `login`, `senha`, `cod_perfil`)
VALUES
  ('1', 'Teste', 'Rua Teste 123', '031999991234', 'email@email.com', 'login', '123456', NULL);