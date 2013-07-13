DROP TABLE IF EXISTS Voo;
DROP TABLE IF EXISTS Pesquisa;
DROP TABLE IF EXISTS Dia;

CREATE TABLE IF NOT EXISTS `Voo` (
  `Cod` int(11) NOT NULL auto_increment COMMENT 'Fara o relacionamento',
  `Origem` char(3) NOT NULL,
  `Destino` char(3) NOT NULL,
  `DiaIda` date NOT NULL,
  `DiaVolta` date default NULL,
  `NumErro` int(11) default '0',
  `Preco` decimal(10,2) default NULL,
  `Cia` varchar(30) default NULL,
  `HoraSaidaIda` varchar(10) default NULL,
  `HoraChegadaIda` varchar(10) default NULL,
  `HoraSaidaVolta` varchar(10) default NULL,
  `HoraChegadaVolta` varchar(10) default NULL,
  `UltimaPesquisa` datetime NOT NULL default '1.1.1',
  `Pesquisando` tinyint(1) NOT NULL default '0' COMMENT 'Se pesquisando = 1 quer dizer que alguma thread ta fazendo um craw desse voo',
  `Prioridade` int(11) NOT NULL default '0',
  `Ocorrencia` int(11) NOT NULL default '0' COMMENT 'Por quantas pesquisas esse voo esta associado',
  PRIMARY KEY  (`Cod`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='A tabela que representa um voo' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `Pesquisa` (
  `Cod` int(11) NOT NULL auto_increment,
  `Email_Cliente` varchar(50) NOT NULL,
  `PrecoEsperado` decimal(10,2) NOT NULL,
  `Origem` char(3) NOT NULL,
  `Destino` char(3) NOT NULL,
  `Status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`Cod`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `Dia` ( 
  `CodPesquisa` int(11) NOT NULL,
  `DiaIda` date NOT NULL,
  `DiaVolta` date default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='A tabela que faz a ligacao 1..n entre dias e pesquisa'; 

CREATE TABLE IF NOT EXISTS `Historico` (
  `Cod` int(11) NOT NULL COMMENT 'Fara o relacionamento com Voo',
  `Preco` decimal(10,2) default NULL,
  `Dt_Pesquisa` datetime NOT NULL default '1.1.1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='A tabela que guardará o historico de voos'; 
