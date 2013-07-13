<?php 
// Recebendo os dados passados pela página "form_contato.php"
$recebenome = $_GET["nome"];
$recebemail = $_GET["email"];
$recebemsg  = $_GET["mensagem"];

function validaEmail($email) {
	$conta = "^[a-zA-Z0-9\._-]+@";
	$domino = "[a-zA-Z0-9\._-]+.";
	$extensao = "([a-zA-Z]{2,4})$";
	$pattern = $conta.$domino.$extensao;
	if (ereg($pattern, $email))
		return true;
	else
		return false;
}

if( (strcmp($recebenome, "") != 0) &&  (strcmp($recebemsg, "") != 0) && validaEmail($recebemail)) 
{
	try
	{
		// Definindo os cabeçalhos do e-mail
		$headers = "Content-type:text/html; charset=iso-8859-1";

		// Definindo destinatário do email
		$para = "promotravel@promotravel.com.br";
		// $para = "joaoluizdhv@gmail.com";
		
		// Definindo o aspecto da mensagem
		$mensagem   = "<h3>De: </h3>  ";
		$mensagem  .= $recebenome ." ". $recebemail;
		$mensagem  .= "<h3>Assunto:</h3>";
		$mensagem  .= "Mensagem do Site";
		$mensagem  .= "<h3>Mensagem</h3>";
		$mensagem  .= "<p>";
		$mensagem  .= $recebemsg;
		$mensagem  .= "</p>";

		// Enviando a mensagem para o destinatário
		$envia =  mail($para,"Fale Conosco Site",$mensagem,$headers);
		echo "Mensagem Recebida com Sucesso!";
	}
	catch (Exception $e)
	{
		echo "Erro ao enviar mensagem. Tente novamente mais tarde.";
	}
}
else
{
	echo "Erro nos campos recebidos. Favor preenchê-los de forma correta.";
}
?>