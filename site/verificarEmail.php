#!/usr/bin/php
<?php
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
		"Belo Horizonte  / Todos os Aeroportos (BHZ)" ,
		"Belém (BEL)" ,
		"Boa Vista (BVB)" ,
		"Bonito (BYO)" ,
		"Brasília (BSB)" ,
		"Cacoal (OAL)",
		"Campinas / Viracopos (VCP) " ,
		"Campo Grande (CGR) " ,
		"Carajás (CKS)" ,
		"Cascavel (CAC)" ,
		"Caçador (CFC)" ,
		"Canelas (QCN)",
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
		"São Paulo  / Todos os Aeroportos (SAO)" ,
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
$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
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
	
	//Para converter SAO em Sao Paulo
	foreach ($verifica as $s){
		if (strpos($s,$origem)){
			$origem = $s ;
		}
		
		if (strpos($s,$destino)){
			$destino = $s ;
		}
	}
	
	
	$ida = $r['ida'];
	$volta = $r['volta'];
	$cia = $r['cia'];
	$ciaAux = strtoupper($cia);
	$preco = $r['preco'];
	$codPesquisa = $r['cod'];
	if (strpos($ciaAux,"GOL"){
		$siteCia = "www.voegol.com.br";
	}else if (strpos($ciaAux,"TAM"){
		$siteCia = "www.Tam.com.br";
	}
	else if (strpos($ciaAux,"AVIANCA"){
		$siteCia = "www.avianca.com.br";
	}
	else if (strpos($ciaAux,"AZUL"){
		$siteCia = "www.voeazul.com.br";
	}
	else if (strpos($ciaAux,"WEBJET"){
		$siteCia = "www.webjet.com.br";
	}
	else if (strpos($ciaAux,"PASSAREDO"){
		$siteCia = "www.voepassaredo.com.br";
	}
	else if (strpos($ciaAux,"TRIP"){
		$siteCia = "www.voetrip.com.br";
	}
	else{
		$siteCia = "#";
	}
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
	<div align="center" style="height:700px; width:470px; z-index:-1" > <a href="http://promotravel.com.br"><img src="http://promotravel.com.br/fundoemail.png" style="height:700px; width:470px; z-index:-1; position:absolute"></a>
	<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Origem: </div>'.
	$origem.
	'<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Destino: </div>'.
	$destino.
	'<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Data ida: </div>'
	$ida.
	'<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Data Volta:</div>'
	.$volta.
	'<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Preço:</div>'
	.$preco.
	'<div style="font-family: &quot;Arial Rounded MT Bold&quot;">Companhia Aérea:</div>
	<a href="'.$siteCia.'">'.$cia.'</a>
	
	<div style="font-family: &quot;Arial Rounded MT Bold&quot;"><br />Boa Viagem! <br/> Equipe PromoTravel</div>
	</div>
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
	$headers .= 'From: PromoTravel <promotravel@promotravel.com.br>' . "\r\n";

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