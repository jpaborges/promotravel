<?php

$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
$idPesquisa   = $_SERVER['QUERY_STRING'];
$idPesquisa = base64_decode($idPesquisa);
$query = "Call AtivarPesquisa ($idPesquisa)";
$sth = mysql_query($query);

if (mysql_errno()) { 
  header("HTTP/1.1 500 Internal Server Error");
  echo $query.'\n';
  echo mysql_error(); 
}
else
  {
    $redirect = "http://promotravel.com.br/sucesso.html";
    header("location:$redirect");
  }
?> 