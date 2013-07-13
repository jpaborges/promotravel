-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2012 at 12:15 AM
-- Server version: 5.5.27
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `promotra_bd`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `AtivarPesquisa`$$
CREATE DEFINER=`promotra`@`localhost` PROCEDURE `AtivarPesquisa`(var_CodPesquisa INT)
BEGIN
	DECLARE codVoo INT;
	DECLARE var_origem char(3);
	DECLARE var_destino Char(3);
	DECLARE var_dia DATE;
	DECLARE var_diaVolta DATE;
	DECLARE var_ocorrencia INT;
	DECLARE var_status INT;
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur1 CURSOR FOR SELECT D.DiaIda, D.DiaVolta FROM Dia D where D.CodPesquisa = var_CodPesquisa;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	SELECT P.Origem, P.Destino, P.Status INTO var_origem, var_destino, var_status FROM Pesquisa P
	WHERE P.Cod = var_CodPesquisa;

	IF (var_status <> 1) THEN
		OPEN cur1;

		read_loop: LOOP
	    		FETCH cur1 INTO var_dia, var_diaVolta;
	    		IF done THEN
	       			LEAVE read_loop;
	    		END IF;
			SET codVoo = 0;

			SELECT V.Cod, V.Ocorrencia INTO codVoo, var_ocorrencia FROM Voo V 
			WHERE V.DiaIda = var_dia and V.DiaVolta = var_diaVolta and V.Origem = var_origem and V.Destino = var_destino
			LIMIT 1;

			IF (codVoo IS NULL) or (codVoo = 0) THEN
				SET done = FALSE;
				INSERT INTO Voo(Origem,Destino,DiaIda,DiaVolta,Prioridade, Ocorrencia) VALUES (var_origem,var_destino,var_dia,var_diaVolta, AttPrioridade(var_dia,var_diaVolta,var_origem,var_destino),1);
			ELSE
				UPDATE Voo SET Ocorrencia = var_ocorrencia + 1 WHERE Cod = codVoo;	
			END IF;

		END LOOP;

		CLOSE cur1;

		UPDATE Pesquisa SET Status = 1 WHERE Cod = var_CodPesquisa;
	END IF;


END$$

DROP PROCEDURE IF EXISTS `EncerrarPesquisa`$$
CREATE DEFINER=`promotra`@`localhost` PROCEDURE `EncerrarPesquisa`(var_CodPesquisa INT)
BEGIN
	DECLARE codVoo INT;
	DECLARE var_origem char(3);
	DECLARE var_destino Char(3);
	DECLARE var_dia DATE;
	DECLARE var_diaVolta DATE;
	DECLARE var_ocorrencia INT;
	DECLARE var_status INT;
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur1 CURSOR FOR SELECT D.DiaIda, D.DiaVolta FROM Dia D where D.CodPesquisa = var_CodPesquisa;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	SELECT P.Origem, P.Destino, P.Status INTO var_origem, var_destino, var_status FROM Pesquisa P
	WHERE P.Cod = var_CodPesquisa;

  	IF (var_status <> 2) THEN
		OPEN cur1;

		read_loop: LOOP
	    		FETCH cur1 INTO var_dia, var_diaVolta ;
	    		IF done THEN
	       			LEAVE read_loop;
	    		END IF;

			UPDATE Voo SET Ocorrencia = Ocorrencia -1 WHERE DiaIda = var_dia and DiaVolta = var_diaVolta and Origem = var_origem and Destino = var_destino;	


		END LOOP;

		CLOSE cur1;

		UPDATE Pesquisa SET Status = 2 WHERE Cod = var_CodPesquisa;
	END IF;


END$$

DROP PROCEDURE IF EXISTS `InserirDia`$$
CREATE DEFINER=`promotra`@`localhost` PROCEDURE `InserirDia`(varEmail varchar(50), varOrigem char(3),varDestino Char(3), varPreco decimal(10,2), varIda DATE,varVolta DATE)
BEGIN
	DECLARE varCod INT;
	SELECT Cod into varCod from Pesquisa 
	WHERE Origem = varOrigem and Destino = varDestino and Email_Cliente = varEmail and PrecoEsperado = varPreco LIMIT 1;
	
		INSERT INTO Dia(CodPesquisa,DiaIda,DiaVolta) VALUES (varCod,varIda,varVolta);
	

END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `AttPrioridade`$$
CREATE DEFINER=`promotra`@`localhost` FUNCTION `AttPrioridade`(varIda DATE,varVolta DATE, varOrigem char(3),varDestino Char(3)) RETURNS int(11)
    DETERMINISTIC
BEGIN
	DECLARE mediaPreco FLOAT;
	DECLARE mediaPrecoPesq FLOAT;
	DECLARE prioridade INT;
	DECLARE mediaQtd INT;
	DECLARE var_ocorrencia INT;
	
	SET prioridade = 0;

	IF varVolta <> NULL THEN 
		select avg(v.Preco) into mediaPreco from Voo v where v.Origem = varOrigem and v.Destino = varDestino and diaVolta <> NULL;
	ELSE
		select avg(v.Preco) into mediaPreco from Voo v where v.Origem = varOrigem and v.Destino = varDestino and diaVolta = NULL;
	END IF;

	select avg(PrecoEsperado) into mediaPrecoPesq from Pesquisa P, Dia D where P.Origem = varOrigem  and P.Destino = varDestino and D.CodPesquisa = P.Cod and D.DiaIda = varIda and D.DiaVolta = varVolta; 
	
	IF (mediaPreco*mediaPrecoPesq/100) < 25 THEN
		SET prioridade = 0;
	ELSEIF (mediaPreco*mediaPrecoPesq/100) >= 25 and (mediaPreco*mediaPrecoPesq/100) < 50 THEN
		SET prioridade = 1;
	ELSEIF (mediaPreco*mediaPrecoPesq/100) >= 50 and (mediaPreco*mediaPrecoPesq/100) < 100 THEN
		SET prioridade = 2;
	ELSEIF (mediaPreco*mediaPrecoPesq/100) >= 100 and (mediaPreco*mediaPrecoPesq/100) < 125 THEN
		SET prioridade = 3;
	ELSEIF (mediaPreco*mediaPrecoPesq/100) >= 125 and (mediaPreco*mediaPrecoPesq/100) < 150 THEN
		SET prioridade = 4;
	ELSEIF (mediaPreco*mediaPrecoPesq/100) >= 150 THEN
		SET prioridade = 5;
	END IF;	

	
	IF (varIda >= adddate(now(),3)) and (varIda <= adddate(now(),10)) THEN
		SET prioridade = prioridade + 3;
	ELSEIF (varIda >= adddate(now(),11)) and (varIda <= adddate(now(),45)) THEN
		SET prioridade = prioridade + 2;
	ELSEIF (varIda >= adddate(now(),46)) and (varIda <= adddate(now(),60)) THEN
		SET prioridade = prioridade + 1;
	ELSE
		SET prioridade = prioridade;
	END IF;


	select avg(Ocorrencia) into mediaQtd from Voo;
	
	select Ocorrencia into var_ocorrencia from Voo where DiaIda = varIda and DiaVolta = varVolta and Origem = varOrigem and Destino = varDestino limit 1;
	
	IF var_ocorrencia > mediaQtd THEN
		SET prioridade = prioridade + 2;
	ELSEIF var_ocorrencia = mediaQtd THEN
		SET prioridade = prioridade + 1;
	ELSE
		SET prioridade = prioridade;
	END IF;
	
	return prioridade;

	

END$$

DROP FUNCTION IF EXISTS `PegarVooAtomicamente`$$
CREATE DEFINER=`promotra`@`localhost` FUNCTION `PegarVooAtomicamente`() RETURNS varchar(60) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE var_dia DATE;
	DECLARE var_volta DATE;
	DECLARE var_origem char(3);
	DECLARE var_destino Char(3);
	DECLARE var_numErro INT;
	DECLARE var_cod INT;
	DECLARE retorno VARCHAR(60);

	SELECT Cod, Origem, Destino, DiaIda, DiaVolta, NumErro into var_cod,var_origem,var_destino,var_dia, var_volta,var_numErro from Voo where (pesquisando = 0 		or (pesquisando = 1 and UltimaPesquisa < subtime(now(),'12:00'))) and UltimaPesquisa <  subtime(now(),'6:00') and DiaIda > adddate(now(),3) and Ocorrencia > 0 and NumErro < 5 order by prioridade desc limit 1;
	
	UPDATE Voo SET  Pesquisando = 1, UltimaPesquisa = Now() where cod = var_cod;
	
	IF var_volta is NULL THEN
		set retorno = concat(var_cod,'$',var_origem,'$',var_destino,'$',var_dia,'$NULL$',var_numErro);		
	ELSE
		set retorno = concat(var_cod,'$',var_origem,'$',var_destino,'$',var_dia,'$', var_volta,'$',var_numErro);
	END IF;
	return retorno;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Dia`
--

DROP TABLE IF EXISTS `Dia`;
CREATE TABLE IF NOT EXISTS `Dia` (
  `CodPesquisa` int(11) NOT NULL,
  `DiaIda` date NOT NULL,
  `DiaVolta` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='A tabela que faz a ligacao 1..n entre dias e pesquisa';

-- --------------------------------------------------------

--
-- Table structure for table `EmailsEnviados`
--

DROP TABLE IF EXISTS `EmailsEnviados`;
CREATE TABLE IF NOT EXISTS `EmailsEnviados` (
  `CodPesquisa` int(11) NOT NULL COMMENT 'Fara o relacionamento',
  `Tipo` enum('Acomp Semanal','Acomp mensal','Grafico','Outros') NOT NULL,
  `DataEnvio` datetime NOT NULL,
  `Obs` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Historico`
--

DROP TABLE IF EXISTS `Historico`;
CREATE TABLE IF NOT EXISTS `Historico` (
  `Cod` int(11) NOT NULL COMMENT 'Fara o relacionamento com Voo',
  `Preco` decimal(10,2) DEFAULT NULL,
  `Dt_Pesquisa` datetime NOT NULL DEFAULT '2001-01-01 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='A tabela que guardará o historico de voos';

-- --------------------------------------------------------

--
-- Table structure for table `Pesquisa`
--

DROP TABLE IF EXISTS `Pesquisa`;
CREATE TABLE IF NOT EXISTS `Pesquisa` (
  `Cod` int(11) NOT NULL AUTO_INCREMENT,
  `Email_Cliente` varchar(50) NOT NULL,
  `PrecoEsperado` decimal(10,2) NOT NULL,
  `Origem` char(3) NOT NULL,
  `Destino` char(3) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `Hora_Insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

--
-- Triggers `Pesquisa`
--
DROP TRIGGER IF EXISTS `AttPrioridadeVoo`;
DELIMITER //
CREATE TRIGGER `AttPrioridadeVoo` AFTER UPDATE ON `Pesquisa`
 FOR EACH ROW BEGIN
	DECLARE var_dia DATE;
	DECLARE var_volta DATE;
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur1 CURSOR FOR SELECT D.DiaIda, D.DiaVolta FROM Dia D where D.CodPesquisa = NEW.Cod;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	IF NEW.Status <> OLD.Status THEN
		OPEN cur1;

		read_loop: LOOP
	    		FETCH cur1 INTO var_dia, var_volta;
	    		IF done THEN
	       			LEAVE read_loop;
	    		END IF;

			UPDATE Voo SET Prioridade = AttPrioridade(var_dia, var_volta, NEW.Origem, NEW.Destino) 
			WHERE DiaIda = var_dia and DiaVolta = var_volta and Origem = NEW.Origem and Destino = NEW.Destino; 	


		END LOOP;

		CLOSE cur1;
			
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Voo`
--

DROP TABLE IF EXISTS `Voo`;
CREATE TABLE IF NOT EXISTS `Voo` (
  `Cod` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Fara o relacionamento',
  `Origem` char(3) NOT NULL,
  `Destino` char(3) NOT NULL,
  `DiaIda` date NOT NULL,
  `DiaVolta` date DEFAULT NULL,
  `NumErro` int(11) DEFAULT '0',
  `Preco` decimal(10,2) DEFAULT NULL,
  `Cia` varchar(30) DEFAULT NULL,
  `HoraSaidaIda` varchar(10) DEFAULT NULL,
  `HoraChegadaIda` varchar(10) DEFAULT NULL,
  `HoraSaidaVolta` varchar(10) DEFAULT NULL,
  `HoraChegadaVolta` varchar(10) DEFAULT NULL,
  `UltimaPesquisa` datetime NOT NULL DEFAULT '2001-01-01 00:00:00',
  `Pesquisando` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Se pesquisando = 1 quer dizer que alguma thread ta fazendo um craw desse voo',
  `Prioridade` int(11) NOT NULL DEFAULT '0',
  `Ocorrencia` int(11) NOT NULL DEFAULT '0' COMMENT 'Por quantas pesquisas esse voo esta associado',
  PRIMARY KEY (`Cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='A tabela que representa um voo' AUTO_INCREMENT=255 ;

--
-- Triggers `Voo`
--
DROP TRIGGER IF EXISTS `HistoricoPreco`;
DELIMITER //
CREATE TRIGGER `HistoricoPreco` AFTER UPDATE ON `Voo`
 FOR EACH ROW BEGIN
	INSERT INTO Historico VALUES (NEW.COD,OLD.Preco,OLD.UltimaPesquisa);
END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
