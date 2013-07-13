<html>

<body>

<?php 

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//--------------------------------------------------------------------------------------------------
//TRATAMENTO DAS VARIAVEIS
$origem_bd = check_input($_POST['origem']);
$destino_bd = check_input($_POST['destino']);
$email_bd = check_input($_POST['email']);
$data_bd = check_input($_POST['alloptions']);
$preco_bd = check_input($_POST['preco_esperado']);

//parser ORIGEM
$origem_tam = strlen($origem_bd);
$x1 = ($origem_tam - 4);
$x2 = ($origem_tam - 3);
$x3 = ($origem_tam - 2);
$final_origem = $origem_bd[$x1].$origem_bd[$x2].$origem_bd[$x3];

//parser DESTINO
$destino_tam = strlen($destino_bd);
$y1 = ($destino_tam - 4);
$y2 = ($destino_tam - 3);
$y3 = ($destino_tam - 2);
$final_destino = $destino_bd[$y1].$destino_bd[$y2].$destino_bd[$y3];

//DEBUGS
//echo "DEBUGS: <br />";
//echo "ORIGEM--->   $final_origem <br />";
//echo "DESTINO--->   $final_destino <br />";
//echo "EMAIL--->   $email_bd <br />";
//echo "PREÇO--->   $preco_bd <br />";
//echo "ALLOPTIONS TESTE--->   $data_bd <br />";


$verifica = array("Alta Floresta (AFL)" ,
"Altamira (ATM)" ,
"Aracaju (AJU)" ,
"Araguaína (AUX)" ,
"Araraquara (AQA)" ,
"Araxá (AAX)" ,
"Araçatuba (ARU)" ,
"Barreiras (BRA)" ,
"Bauru (JTC)" ,
"Belo Horizonte / Confins (CNF)" ,
"Belo Horizonte / Pampulha (PLU)" ,
"Belo Horizonte / Todos os Aeroportos (BHZ)" ,
"Belém (BEL)" ,
"Boa Vista (BVB)" ,
"Bonito (BYO)" ,
"Brasília (BSB)" ,
"Cacoal (OAL)",
"Campinas / Viracopos (VCP) " ,
"Campo Grande (CGR) " ,
"Carajás (CKS)" ,
"Cascavel (CAC)" ,
"Canelas (QCN)",
"Caçador (CFC)" ,
"Chapecó (XAP)" ,
"Comandatuba (UNA)" ,
"Corumbá (CMG)" ,
"Criciúma (CCM)" ,
"Cruzeiro do Sul (CZS)" ,
"Cuiabá (CGB)" ,
"Curitiba (CWB)" ,
"Dourados (DOU)" ,
"Erechim (ERM)" ,
"Fernando de Noronha (FEN)" ,
"Florianópolis (FLN)" ,
"Fortaleza (FOR)" ,
"Foz do Iguaçu (IGU)" ,
"Franca (FRC)" ,
"Goiânia (GYN)" ,
"Gov. Valadares (GVR)" ,
"Guarapuava (GPB)" ,
"Ilhéus (IOS)" ,
"Imperatriz (IMP)" ,
"Ipatinga (IPN)" ,
"Itaituba (ITB)" ,
"Ji-Paraná (JPR)" ,
"Joaçaba (JCB)" ,
"Joinville (JOI)" ,
"João Pessoa (JPA)" ,
"Juiz de Fora (JDF)" ,
"Lençóis (LEC)" ,
"Londrina (LDB)" ,
"Macapá (MCP)" ,
"Macaé (MEA)" ,
"Maceió (MCZ)" ,
"Manaus (MAO)" ,
"Marabá (MAB)" ,
"Maringá (MGF)" ,
"Marília (MII)" ,
"Minacu (MQH)" ,
"Montes Claros (MOC)" ,
"Natal (NAT)" ,
"Navegantes (NVT)" ,
"Palmas (PMW)" ,
"Parintins (PIN)" ,
"Passo Fundo (PFB)" ,
"Patos de Minas (POJ)" ,
"Pelotas (PET)" ,
"Petrolina (PNZ)" ,
"Porto Alegre (POA)" ,
"Porto Seguro (BPS)" ,
"Porto Velho (PVH)" ,
"Presidente Prudente (PPB)" ,
"Recife (REC)" ,
"Ribeirão Preto (RAO)" ,
"Rio Branco (RBR)" ,
"Rio Grande (RIG)" ,
"Rio Verde (RVD)" ,
"Rio de Janeiro / Galeão (GIG)" ,
"Rio de Janeiro / Santos Dumont (SDU)" ,
"Rio de Janeiro / Todos os Aeroportos (RIO)" ,
"Rondonópolis (ROO)" ,
"Salvador (SSA)" ,
"Santa Maria (RIA)" ,
"Santa Rosa (SRA)" ,
"Santarém (STM)" ,
"Santo Angelo (GEL)" ,
"Sinop (OPS)" ,
"São José do Rio Preto (SJP)" ,
"São José dos Campos (SJK)" ,
"São Luís (SLZ)" ,
"São Paulo / Congonhas (CGH)" ,
"São Paulo / Guarulhos (GRU)" ,
"São Paulo / Todos os Aeroportos (SAO)" ,
"Tabatinga (TBT)" ,
"Tefe (TFF)" ,
"Teresina (THE)" ,
"Trombetas (TMT)" ,
"Tucuruí (TUR)" ,
"Uberaba (UBA)" ,
"Uberlândia (UDI)" ,
"Uruguaiana (URG)" ,
"Vilhena (BVH)" ,
"Vitória (VIX)" ,
"Vitória da Conquista (VDC)");

if(in_array($origem_bd, $verifica) && in_array($destino_bd, $verifica)){

//Vetor que vai receber os valores vindo da lista
$teste = explode('$', $data_bd);


$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";
$preco_bd = str_replace(",","",$preco_bd);

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());

$query = "INSERT INTO Pesquisa (Email_Cliente,Origem,Destino,PrecoEsperado) VALUES ('$email_bd','$final_origem','$final_destino','$preco_bd')";

$sth = mysql_query($query);


foreach ($teste as &$item){

  //Remove todos os espaços em branco, e tira os nomes Ida: e Volta: da string.
  $cat = str_replace(array("Ida:","Volta:"," "), "", $item);
 // echo "DEBUG: $cat <br />";
  
  //Remove o ponto e virgula que separa as datas quando for Ida e Volta, caso seja só ida nada é removido.
  $cat = explode(",", $cat);
  
  //Obtem o tamanho do vetor $cat, se for 1 só tem 1 data ou seja é somente ida, se for 2 é ida e volta.
  $tam = sizeof($cat);
 
  if(sizeof($cat) == 1)
  {
 //   echo " ---------- Executar uma consulta de ida com os valores --------------<br />";
    //Separa os valores com /, obtem assim um vetor de 3 elementos contendo nessa ordem: [Data,Mes,Ano]
	$aux2 = $cat[0];
    $var = explode("/",$aux2);
    //echo "Dia: $var[0] <br / >";
    //echo "Mes: $var[1] <br / >";
    //echo "Ano: $var[2] <br / >";
	
	$dia = $var[2].".".$var[1].".".$var[0];
	
	//echo "Debug 1<br/>";
	//print $dia;	
	$query = "Call InserirDia ('$email_bd','$final_origem','$final_destino',$preco_bd,'$dia',NULL)";
	$sth = mysql_query($query);
 //   echo " ---------- Fim da consulta de ida com os valores --------------<br />";
  }
  else
  {
//    echo "-------------- Executar uma consulta de ida e volta com os valores --------------<br />";
    //Separa os valores com /, obtem assim um vetor de 3 elementos contendo nessa ordem: [Data,Mes,Ano]
	$dia = array();
    foreach ($cat as &$value)
    {
      $var = explode("/",$value);
      //echo "Dia: $var[0] <br / >";
      //echo "Mes: $var[1] <br / >";
      //echo "Ano: $var[2] <br / >";
		
	  $aux =  $var[2].".".$var[1].".".$var[0];
	  array_push($dia,$aux);
    }
	
	//echo "DEBUG 2 <br/>";
	//echo "$dia[0]<br/>";
	//echo "$dia[1]<br/>";
	$query = "Call InserirDia ('$email_bd','$final_origem','$final_destino',$preco_bd,'$dia[0]','$dia[1]')";
	$sth = mysql_query($query);
	
  //  echo "-------------- Fim da consulta de ida e volta com os valores --------------<br />";
  }
  
  
}

$query = "SELECT Cod FROM Pesquisa WHERE Email_Cliente = '$email_bd' AND PrecoEsperado = $preco_bd AND Origem = '$final_origem' AND Destino =  '$final_destino'
LIMIT 1";

	
	$sth = mysql_query($query);
	

	
	$r = mysql_fetch_assoc($sth);
	
	
	

///////////////////////////
$idPesquisa = $r["Cod"]; //TODO: pegar esse valor depois
$email = $email_bd;
$nome = 'Usuário';
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
<div align="center" style="height:700px; width:470px; z-index:-1" > <a href="http://promotravel.com.br/ativarPesquisa.php?'.$codificada  .'"><img src="http://promotravel.com.br/fundo2.png" style="height:700px; width:470px; z-index:-1; position:absolute"></a>

</div>
Caso não consiga abrir o link, copie e cole este link no seu navegador.<br/><br/>
http://promotravel.com.br/ativarPesquisa.php?'.$codificada  .' <br /><br />
Atenciosamente <br/>
Promotravel <br/>
</body>
</html>';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$nome .'<'.$email.'>' . "\r\n";
$headers .= 'From: PromoTravel <promotravel@promotravel.com.br>' . "\r\n";


// Mail it
mail($email, $subject, $message, $headers);

///////////////////////
if (mysql_errno()) { 
		header("HTTP/1.1 500 Internal Server Error");
		echo $query.'\n';
		echo mysql_error(); 
	}
	else
	{
		//echo "Cadastrado com Sucesso";
	}
	
mysql_close($con);
echo ' <script language= "JavaScript"> alert("Pesquisa realizada com sucesso. Verifique seu email para ativar sua pesquisa.") </script> ' ;
}
else{
echo ' <script language= "JavaScript"> alert("Verifique a origem e/ou destino.") </script> ' ;
}

?>



<script language= "JavaScript">

location.href="http://promotravel.com.br"

</script>


</body>

</html>