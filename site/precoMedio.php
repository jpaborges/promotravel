<?php
header('Content-Type: text/html; charset=utf-8');
$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
$origem=$_GET["o"];
$destino=$_GET["d"];
$tipo=$_GET["t"];
if ($tipo == 0) {//ida e volta
	$query = "SELECT AVG(h.Preco) as media FROM Historico h, Voo WHERE h.Cod = Voo.Cod and Origem = '$origem' and Destino = '$destino' and not Voo.DiaVolta is NULL;";
}
else{
	$query = "SELECT AVG(h.Preco) as media  FROM Historico h, Voo WHERE h.Cod = Voo.Cod and Origem = '$origem' and Destino = '$destino' and  Voo.DiaVolta is NULL;";	
}
$sth = mysql_query($query);

if (mysql_errno()) { 
  header("HTTP/1.1 500 Internal Server Error");
  echo $query.'\n';
  echo mysql_error(); 
}
else
  {
    if($row = mysql_fetch_array($sth))
	{
		if(round($row['media']) > 0)
			echo "<html><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><b>Pre&ccedil;o m&eacute;dio &eacute;: R$ ". round($row['media']) . ",00</b></html>";
	}
  }
?> 