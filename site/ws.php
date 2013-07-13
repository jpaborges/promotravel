<?
//curl  --data '1&jpaborges3&SSA&REC&100&2012.05.17#2012.05.18&2012.06.10'  http://promotravel.com.br/ws.php

$databasehost = "localhost";
$databasename = "promotra_bd";
$databaseusername ="promotra";
$databasepassword = "BIDordService$";

$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
mysql_select_db($databasename) or die(mysql_error());
$entrada = explode("&",file_get_contents("php://input")); 


if ($entrada[0] == 1){

	/*
		Codigo utilizado para insercao de dados. O formato da string sera: 1&email&origem&destino&precoE&diasIda&diasVolta
		Os dias serao separados por #, exemplo 2012.10.20#AAAA.MM.DD
		Se a volta não estiver nada nada diasVoltas = "NULL"
	*/
	$email = $entrada[1];
	$origem = $entrada[2];
	$destino = $entrada[3];
	$preco = $entrada[4];
	
	$query = "INSERT INTO Pesquisa (Email_Cliente,Origem,Destino,PrecoEsperado) VALUES ('$email','$origem','$destino',$preco)";
	
	$sth = mysql_query($query);

	if ($entrada[6] != "NULL")
		$diasvolta = explode("#",$entrada[6]); 
	else
		$diasvolta = array();
		
	foreach (explode('#',$entrada[5]) as $dia){
		
		$i = count($diasvolta);
		if ($i == 0){
			print $dia;	
			$query = "Call InserirDia ('$email','$origem','$destino',$preco,'$dia',NULL)";
			$sth = mysql_query($query);
		}
		else{
			while ($i > 0){
				$aux = $i - 1;
				$d = $diasvolta[$aux];
				$query = "Call InserirDia ('$email','$origem','$destino',$preco,'$dia','$d')";
				$sth = mysql_query($query);
				$i = $i -1;
			}
		}
		
	}
	

	if (mysql_errno()) { 
		header("HTTP/1.1 500 Internal Server Error");
		echo $query.'\n';
		echo mysql_error(); 
	}
	else
	{
		echo "Cadastrado com Sucesso";
	}
}
else if ($entrada[0] == 2){

	/*
		Codigo utilizado para selecionar os voos dado a origem o preco e uma lista de tupla de datas.
		A string sera: 2&origem&preco&Data1,data2#data3,data4

	*/
	$origem = $entrada[1];
	$preco = $entrada[2];
	$datas = explode("#",$entrada[3]);
	$i = count($datas);

	$query = "Select Destino, DiaIda, DiaVolta, Preco, Cia from Voo where origem = '$origem' and preco <= $preco and (";
	while ($i > 0){
		$aux = $i - 1;
		$dia = explode(",",$datas[$aux]);
		if ($i == count($datas))
			$query = $query . " (DiaIda >= '$dia[0]' and DiaIda <= '$dia[1]')"; 
		else
			$query = $query . " or (DiaIda >= '$dia[0]' and DiaIda <= '$dia[1]')"; 

		$i = $i -1;
	}
	$query = $query . ")";
	print $query;
	
	
	
	$sth = mysql_query($query);

	if (mysql_errno()) { 
	    header("HTTP/1.1 500 Internal Server Error");
	    echo $query.'\n';
	    echo mysql_error(); 
	}
	else
	{
	    $rows = array();
	    while($r = mysql_fetch_assoc($sth)) {
		$rows[] = $r;
	    }
	    print json_encode($rows);
	}


}
else if ($entrada[0] == 3){

$query = base64_decode($entrada[1]);

	
	
	$sth = mysql_query($query);

	if (mysql_errno()) { 
	    header("HTTP/1.1 500 Internal Server Error");
	    echo $query.'\n';
	    echo mysql_error(); 
	}
	else
	{
	if(strtoupper($query[0]) == 'S')	
	    $rows = array();
	    while($r = mysql_fetch_assoc($sth)) {
		$rows[] = $r;
	    }
	    print json_encode($rows);
	}

}
else{
	print "else";
}
		

mysql_close($con);


?> 
