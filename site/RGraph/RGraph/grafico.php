 <html>
<head>

    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <title>Promotravel</title>

    <link rel="stylesheet" href="css/website.css" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RGraph: Javascript charts for your website" href="http://www.rgraph.net/news.xml">
    
    <link rel="icon" type="image/png" href="images/favicon2.jpg">
    
    <script src="libraries/RGraph.common.core.js" ></script>
    <script src="libraries/RGraph.common.dynamic.js" ></script>
    <script src="libraries/RGraph.common.effects.js" ></script>
    <script src="libraries/RGraph.common.tooltips.js" ></script>
    <script src="libraries/RGraph.line.js" ></script>
 
 
 <?php 
						$databasehost = "localhost";
						$databasename = "promotra_bd";
						$databaseusername ="promotra";
						$databasepassword = "BIDordService$";
						
						$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
						mysql_select_db($databasename) or die(mysql_error());
						$cod= $_SERVER['QUERY_STRING'];
						$cod = base64_decode($cod);
						$query = "SELECT Historico.DT_Pesquisa, Historico.Preco, Voo.Origem,Voo.Destino,Voo.DiaIda,Voo.DiaVolta from Historico, Voo where Historico.Cod = $cod and Voo.Cod = $cod";
						$sth = mysql_query($query);
						if (mysql_errno()) { 
							echo "Ainda não há dados suficientes para o seu voo.";
						}
						else
						{
							$datas = "[";
							$label= "[";
							$precos = "[";
							$precoAnts = 0;
							$i = 0;
							$aux = 0;
							
							while($r = mysql_fetch_assoc($sth)) {
								$data = $r["DT_Pesquisa"];
								$preco =  $r["Preco"];
								$origem = $r["Origem"];
								$destino = $r["Destino"];
								$ida = $r["DiaIda"];
								$volta = $r["DiaVolta"];
								$aux +=  1;
								if (($preco != $precoAnts) || ($aux > 10)){
									$precoAnts= $preco;
									$d = explode('-',$data);
									$aux = 0;
									$datas .= "'". $data ." - R$ ".$preco ."',";
									$precos .= "'". $preco."',";
									$i += 1;
									if (($i % 5) == 0){
										$dia = explode(' ',$d[2]);
										$label.= "'". $dia[0] . "/" .$d[1] ."',";
									}
								}
							}
							$precos .= ']';
							$precos = str_replace(',]', ']', $precos);
							$datas .= ']';
							$datas= str_replace(',]', ']', $datas);
							$label.= ']';
							$label= str_replace(',]', ']', $label); 
							echo "Origem: $origem - Destino: $destino <br />Ida: $ida e Volta: $volta<br /><br />"; 
							echo "<script>";
							echo "var datas = $datas;";
							echo "var precos = $precos;";
							echo "var label = $label;";
							echo "</script>";
							
						}
					?>
					
<script>
        window.onload = function ()
        {
			
			var line2 = new RGraph.Line('line2', precos);

            var grad = line2.context.createLinearGradient(0,0,0,150);
            grad.addColorStop(0,'rgba(255,255,255,0.5)');
            grad.addColorStop(1,'rgba(0,0,0,0)');

            line2.Set('chart.filled', true);
            line2.Set('chart.fillstyle', [grad]);
            line2.Set('chart.colors', ['black']);
            line2.Set('chart.linewidth', 2);
            line2.Set('chart.hmargin', 5);
            line2.Set('chart.tickmarks', 'circle');
            line2.Set('chart.labels', label);
            line2.Set('chart.tooltips', datas);
            line2.Draw();
        }
    </script>
</head>
<body>


	<canvas width="600" height="250" id="line2" style="float: center"></canvas>


</body>
</html>
					