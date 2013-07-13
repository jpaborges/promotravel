DELIMITER $

DROP FUNCTION IF EXISTS AttPrioridade $

CREATE FUNCTION AttPrioridade(varIda DATE,varVolta DATE, varOrigem char(3),varDestino Char(3)) RETURNS INT
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

	

END;
$

DROP PROCEDURE IF EXISTS AtivarPesquisa $
CREATE PROCEDURE AtivarPesquisa(var_CodPesquisa INT)
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


END;
$

DROP PROCEDURE IF EXISTS EncerrarPesquisa $
CREATE PROCEDURE EncerrarPesquisa(var_CodPesquisa INT) 
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


END;
$

DROP PROCEDURE IF EXISTS InserirDia $
CREATE PROCEDURE InserirDia(varEmail varchar(50), varOrigem char(3),varDestino Char(3), varPreco decimal(10,2), varIda DATE,varVolta DATE)
BEGIN
	DECLARE varCod INT;
	SELECT Cod into varCod from Pesquisa 
	WHERE Origem = varOrigem and Destino = varDestino and Email_Cliente = varEmail and PrecoEsperado = varPreco LIMIT 1;
	
		INSERT INTO Dia(CodPesquisa,DiaIda,DiaVolta) VALUES (varCod,varIda,varVolta);
	

END;
$

/*
Trigger para atualizar a prioridade do voo, TODO: analisar o desempenho

*/
DROP TRIGGER IF EXISTS AttPrioridadeVoo $

CREATE TRIGGER AttPrioridadeVoo AFTER UPDATE ON Pesquisa
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
END;
$
DROP FUNCTION IF EXISTS PegarVooAtomicamente $
CREATE FUNCTION PegarVooAtomicamente() RETURNS VARCHAR(60)
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
END;
$

DROP TRIGGER IF EXISTS HistoricoPreco $
CREATE TRIGGER HistoricoPreco AFTER UPDATE ON Voo
FOR EACH ROW BEGIN
	INSERT INTO Historico VALUES (NEW.COD,OLD.Preco,OLD.UltimaPesquisa);
END;
$

delimiter ;
