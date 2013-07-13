#!/usr/bin/php
<?php


$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
//$query = "SELECT DISTINCT Email_Cliente, PrecoEsperado,v.Preco, v.Origem,v.Destino,v.DiaIda,v.DiaVolta,v.Cia, p.Cod FROM Pesquisa p , Voo v, Dia d WHERE v.Origem = p.Origem and v.Destino = p.Destino and v.Preco <= p.PrecoEsperado and v.DiaIda = d.DiaIda and v.DiaVolta = d.DiaVolta and p.Cod = d.CodPesquisa and p.Status = 1;";
$query = "SELECT DISTINCT Email_Cliente, PrecoEsperado,v.Preco as preco, v.Origem as origem,v.Destino as destino,v.DiaIda as ida,v.DiaVolta as volta,v.Cia as cia, p.Cod as cod FROM Pesquisa p , Voo v, Dia d WHERE v.Origem = p.Origem and v.Destino = p.Destino and v.DiaIda = d.DiaIda and ((v.DiaVolta = d.DiaVolta) or (v.DiaVolta is NULL)) and p.Cod = d.CodPesquisa and p.Status = 1 and PrecoEsperado >= v.Preco;";


$sth = mysql_query($query);

if (mysql_errno()) { 
    header("HTTP/1.1 500 Internal Server Error");
    echo $query.'\n';
    echo mysql_error(); 
}
else
{

    while($r = mysql_fetch_assoc($sth)) {
	//print "AQUI";
	$email = $r['Email_Cliente'];
	$origem = $r['origem'];
	$destino = $r['destino'];
	$ida = $r['ida'];
	$volta = $r['volta'];
	$cia = $r['cia'];
	$preco = $r['preco'];
	$codPesquisa = $r['cod'];
	$nome = 'usuario';
	// subject
	$subject = 'PromoTravel - Passagem encontrada!';

	// message
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Untitled Document</title>
	</head>

	<body>
	<div align="center" style="height:700px; width:470px; z-index:-1" > <a href="http://promotravel.com.br"><img src="http://promotravel.alwaysdata.net/fundo2.png" style="height:700px; width:470px; z-index:-1; position:absolute"></a>

	</div>
	O trecho '. $origem . ' - '. $destino . ' na data: ' . $ida . ', ' . $volta. '<br/>foi encontrado na '.$cia. ' por R$'.$preco. '<br/>
	 <br /><br />
	Atenciosamente <br/>
	Promotravel <br/>
	</body>
	</html>';

	/* Atenção se você pretende inserir numa variável uma mensagem html mais
	 complexa do que essa sem precisar escapar os carateres 
	 necessários pode ser feito o uso da sintaxe heredoc, consulte tipos-string-sintaxe-heredoc */

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'To: '.$nome .'<'.$email.'>' . "\r\n";
	$headers .= 'From: PromoTravel <promotravel@alwaysdata.net>' . "\r\n";

	//print $message.'<br /><br />'.$r[8];
	// Mail it
	mail($email, $subject, $message, $headers);
	$query2 = "Call EncerrarPesquisa($codPesquisa);";
	$sth2 = mysql_query($query2);
	if (mysql_errno()) { 
	    header("HTTP/1.1 500 Internal Server Error");
	    echo $query2.'\n';
	    echo mysql_error(); 
	}
	else{
		print "Email enviado para $email";
	}
    }
}


?>
