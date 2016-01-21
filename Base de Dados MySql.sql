-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema enquete
--

CREATE DATABASE IF NOT EXISTS enquete;
USE enquete;

--
-- Definition of table `enquete`
--

DROP TABLE IF EXISTS `enquete`;
CREATE TABLE `enquete` (
  `id_enquete` int(11) NOT NULL auto_increment,
  `no_titulo` varchar(45) default NULL,
  PRIMARY KEY  (`id_enquete`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enquete`
--

/*!40000 ALTER TABLE `enquete` DISABLE KEYS */;
INSERT INTO `enquete` (`id_enquete`,`no_titulo`) VALUES 
 (9,'AvaliaÃ§Ã£o de Carros'),
 (10,'Quando realiza compras'),
 (14,'Viagens');
/*!40000 ALTER TABLE `enquete` ENABLE KEYS */;


--
-- Definition of table `pergunta`
--

DROP TABLE IF EXISTS `pergunta`;
CREATE TABLE `pergunta` (
  `id_pergunta` int(11) NOT NULL auto_increment,
  `no_pergunta` varchar(45) default NULL,
  `enquete_id_enquete` int(11) NOT NULL,
  PRIMARY KEY  (`id_pergunta`),
  KEY `fk_pergunta_enquete` (`enquete_id_enquete`),
  CONSTRAINT `fk_pergunta_enquete` FOREIGN KEY (`enquete_id_enquete`) REFERENCES `enquete` (`id_enquete`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pergunta`
--

/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
INSERT INTO `pergunta` (`id_pergunta`,`no_pergunta`,`enquete_id_enquete`) VALUES 
 (28,'Qual carro possui melhor desempenho?',9),
 (29,'Qual carro Ã© mais luxuoso?',9),
 (30,'Qual a melhor cor para um carro?',9),
 (31,'Qual carro voce nÃ£o compraria?',9),
 (32,'Onde prefere ir?',10),
 (33,'Gasta em mÃ©dia quanto?',10),
 (34,'O que prefere comprar?',10),
 (36,'Para onde gosta de viajar?',14),
 (37,'Prefere ir como?',14);
/*!40000 ALTER TABLE `pergunta` ENABLE KEYS */;


--
-- Definition of table `resposta`
--

DROP TABLE IF EXISTS `resposta`;
CREATE TABLE `resposta` (
  `id_resposta` int(11) NOT NULL auto_increment,
  `no_resposta` varchar(45) default NULL,
  `pergunta_id_pergunta` int(11) NOT NULL,
  PRIMARY KEY  (`id_resposta`),
  KEY `fk_resposta_pergunta1` (`pergunta_id_pergunta`),
  CONSTRAINT `fk_resposta_pergunta1` FOREIGN KEY (`pergunta_id_pergunta`) REFERENCES `pergunta` (`id_pergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resposta`
--

/*!40000 ALTER TABLE `resposta` DISABLE KEYS */;
INSERT INTO `resposta` (`id_resposta`,`no_resposta`,`pergunta_id_pergunta`) VALUES 
 (65,'Gol',28),
 (66,'Palio',28),
 (67,'Civic',28),
 (68,'Corola',28),
 (69,'Civic',29),
 (70,'Corola',29),
 (71,'HB 20',29),
 (72,'BMW',29),
 (73,'Branco',30),
 (74,'Preto',30),
 (75,'Prata',30),
 (76,'Vermelho',30),
 (77,'Fusca',31),
 (78,'Opala',31),
 (79,'Chevette',31),
 (80,'Maverik',31),
 (81,'Corcel',31),
 (82,'Shopping',32),
 (83,'Feira',32),
 (84,'Camelo',32),
 (85,'Entre 50 e 100',33),
 (86,'Entre 100 e 500',33),
 (87,'Entre 500 e 1000',33),
 (88,'Mais que 1000',33),
 (89,'Roupas',34),
 (90,'CalÃ§ados',34),
 (91,'Brinquedos',34),
 (92,'Perfumes',34),
 (95,'Recife',36),
 (96,'MaceiÃ³',36),
 (97,'Fortaleza',36),
 (98,'FlorianÃ³polis',36),
 (99,'De Ã´nibus',37),
 (100,'De aviÃ£o',37),
 (101,'De carro',37);
/*!40000 ALTER TABLE `resposta` ENABLE KEYS */;


--
-- Definition of table `resultado`
--

DROP TABLE IF EXISTS `resultado`;
CREATE TABLE `resultado` (
  `id_resultado` int(11) NOT NULL auto_increment,
  `id_enquete` int(11) NOT NULL,
  `id_pergunta` int(11) NOT NULL,
  `id_resposta` int(11) NOT NULL,
  PRIMARY KEY  (`id_resultado`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resultado`
--

/*!40000 ALTER TABLE `resultado` DISABLE KEYS */;
INSERT INTO `resultado` (`id_resultado`,`id_enquete`,`id_pergunta`,`id_resposta`) VALUES 
 (97,8,24,54),
 (98,8,25,56),
 (99,8,26,59),
 (100,8,27,63),
 (101,9,28,65),
 (102,9,29,70),
 (103,9,30,75),
 (104,9,31,79),
 (105,10,32,83),
 (106,10,33,86),
 (107,10,34,89),
 (108,9,28,66),
 (109,9,29,70),
 (110,9,30,74),
 (111,9,31,78),
 (112,10,32,82),
 (113,10,33,85),
 (114,10,34,89),
 (115,9,28,67),
 (116,9,29,69),
 (117,9,30,75),
 (118,9,31,79),
 (119,14,36,97),
 (120,14,37,100),
 (121,14,36,97),
 (122,14,37,99);
/*!40000 ALTER TABLE `resultado` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
