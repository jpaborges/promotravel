#!/usr/bin/php
<?php

$idPesquisa = 2; //TODO: pegar esse valor depois
$email = 'jpaborges@gmail.com';
$nome = 'Joao Paulo';
$codificada = base64_encode($idPesquisa);

// subject
$subject = 'PromoTravel - Confirmação de pesquisa.';

// message
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<div align="center" style="height:700px; width:470px; z-index:-1" > <a href="http://promotravel.alwaysdata.net/ativarPesquisa.php?'.$codificada  .'"><img src="http://promotravel.alwaysdata.net/fundo2.png" style="height:700px; width:470px; z-index:-1; position:absolute"></a>

</div>
Caso não consiga abrir o link, copie e cole este link no seu navegador.<br/><br/>
http://promotravel.alwaysdata.net/ativarPesquisa.php?'.$codificada  .' <br /><br />
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


// Mail it
mail($email, $subject, $message, $headers);
?>
