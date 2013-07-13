<?
$databasehost = "mysql1.alwaysdata.com";
$databasename = "promotravel_bd";
$databaseusername ="46507_promo";
$databasepassword = "BIDord$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());

$query = " SELECT DISTINCT v.Origem as origem, v.Destino as destino, v.Cia as cia, 
FROM Pesquisa p , Voo v, Dia d 
WHERE v.Origem = p.Origem and v.Destino = p.Destino and 
v.DiaIda = d.DiaIda and ((v.DiaVolta = d.DiaVolta) or (v.DiaVolta is NULL)) and 
p.Status = 1 and 
v.Preco <= AVG(Select dos outros preços) ";

$sth = mysql_query($query);

if (mysql_errno()) { 
    header("HTTP/1.1 500 Internal Server Error");
    echo $query.'\n';
    echo mysql_error(); 
}
else
{

	echo "Promoções: <br /><br />"
    while($r = mysql_fetch_assoc($sth)) {

	$origem = $r['origem'];
	$destino = $r['destino'];
	$ida = $r['ida'];
	$volta = $r['volta'];
	$cia = $r['cia'];
	$preco = $r['preco'];
	
	echo "($cia) De  $origem  Para  $destino <br />"

   }

} 

?>