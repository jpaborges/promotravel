<?php 
// Recebendo os dados passados pela página "form_contato.php"
$recebenome = $_POST["nome"];
$recebemail = $_POST["email"];
$recebemsg  = $_POST["mensagem"];

// Definindo os cabeçalhos do e-mail
$headers = "Content-type:text/html; charset=iso-8859-1";

// Vamos definir agora o destinatário do email, ou seja, VOCÊ ou SEU CLIENTE
$para = "promotravel@promotravel.com.br";

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

// Envia um e-mail para o remetente, agradecendo a visita no site, e dizendo que em breve o e-mail será respondido.
//$mensagem2  = "<p>Olá <strong>" . $recebenome . "</strong>. Agradeçemos sua visita. Em breve resolveremos sua solicitação.</p>";
//$mensagem2 .= "<p>Observação - Não é necessário responder esta mensagem.</p>";
//$mensagem2 .= "<p>Atenciosamente:</p>";
//$mensagem2 .= "<p>Promotravel</p>";
//$envia =  mail($recebemail,"Sua mensagem foi recebida!",$mensagem2,$headers);

// Exibe na tela a mensagem de sucesso, e depois redireciona devolta para a página de contato.
echo "Mensagem Recebida com Sucesso!";
echo "<meta http-equiv='refresh' content='2;URL=form_contato.php'>";
?>