<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Promotravel</title>
<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon" />
<meta name="keywords" content="Business Website, viagem, promoção, passagens aéreas, promoções" />
<meta name="description" content="Site que busca promoções de passagens aéreas." />

<!-- CSS -->

<link rel="stylesheet" href="css/form.css" type="text/css" />
<link rel="stylesheet" href="css/maintemplate.css" type="text/css" />

<!-- JavaScript do efeito amarelo no form -->	
<script src="scripts/wufoo.js"></script>

<!-- include do calendario-->
<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" media="screen"></link>

<script src="scripts/functions.js"></script>

<style type="text/css">
.auto-style1 {
	margin-left: 14px;
	margin-right: 0px;
}
</style>

</head>


<body onLoad="createAutoComplete();">
<div id="templatemo_container">
 
 <!-- inicio do cabecalho -->
    <div id="templatemo_header">
    
    	<div id="logosection"></div>
        
        <div id="header">
        	<div class="title">As melhores promoções<br /> <span class="bigtext">em um só lugar</span> <br /> para você!</div>
        </div>
	</div>   
 <!-- final do cabecalho -->
 
 <!-- inicio do menu de cima -->
	<div id="templatemo_menu">
    	<div id="search"></div>
        
        <div id="menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre.php" >Sobre</a></li>
                <li><a href="#" class="current">Fale Conosco</a></li>
            </ul>
        </div>
	</div>
<!-- fim do menu de cima -->
    
<!-- inicio do conteudo principal -->    
	<div id="templatemo_content">
    
   	  <div id="templatemo_left_column">        	

            <div id="leftcolumn_box01">
               <div class="leftcolumn_box01_top">
                    <h2>Mais procurados</h2>
                </div>
                <div class="leftcolumn_box01_bottom">
                    <div class="section2_bottom">
			      	<ul>
                       <?php 
						//curl  --data '1&jpaborges3&SSA&REC&100&2012.05.17#2012.05.18&2012.06.10'  http://promotravel.com.br/ws.php

						$databasehost = "localhost";
						$databasename = "promotra_bd";
						$databaseusername ="promotra";
						$databasepassword = "BIDordService$";
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
											"Belo Horizonte (BHZ)" ,
											"Belém (BEL)" ,
											"Boa Vista (BVB)" ,
											"Bonito (BYO)" ,
											"Brasília (BSB)" ,
											"Cacoal (OAL)",
											"Canelas (QCN)",
											"Campinas / Viracopos (VCP) " ,
											"Campo Grande (CGR) " ,
											"Carajás (CKS)" ,
											"Cascavel (CAC)" ,
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
											"Rio de Janeiro (RIO)" ,
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
											"São Paulo (SAO)" ,
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
						$con = mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
						mysql_select_db($databasename) or die(mysql_error());
						$query = "SELECT Origem, Destino, count( * ) AS qtd FROM Voo GROUP BY Origem, Destino ORDER BY qtd DESC LIMIT 0, 20";
						$sth = mysql_query($query);
						if (mysql_errno()) { 
							header("HTTP/1.1 500 Internal Server Error");
							echo $query.'\n';
							echo mysql_error(); 
						}
						else
						{
							
							while($r = mysql_fetch_assoc($sth)) {
								$origemLi = $r["Origem"];
								$destinoLi =  $r["Destino"];
								foreach ($verifica as $s){
									if (strpos($s,$origemLi)){
										$origemLi = $s ;
									}
									
									if (strpos($s,$destinoLi)){
										$destinoLi = $s ;
									}
								}
								$origemLi = explode("(",$origemLi);
								$destinoLi = explode("(",$destinoLi);
								echo '<li><a href="#" style="color: rgb(255,255,255)">'.$origemLi[0].' - '.$destinoLi[0].'</a> </li>';
							}
							
						}
					?>
					</ul>
            		</div>
                </div>            
           </div>       
      </div>
<!-- end of left column -->
        
<!-- start of middle column -->
        
    	<div id="templatemo_middle_column" class="auto-style1" style="width: 439px">
    	  <div id="section2" style="width: 450px">
          <div class="section2_top"><h2>Fale conosco:</h2></div>
                
                <form id="form1" name="form1" method="post" action="enviar_contato.php">

					  <table width="500" border="0" cellspacing="2" cellpadding="5">
					
					    <tr>
					
					      <td>Nome:</td>
					
					      <td>
						  <input name="nome" type="text" id="nome" style="width: 290px
						  " /></td>
					
					    </tr>
					
					    <tr>
					
					      <td>E-mail:</td>
					
					      <td>
						  <input name="email" type="text" id="email" style="width: 290px" /></td>
					
					    </tr>
					
					    <tr>
					
					      <td>Mensagem:</td>
					
					      <td><textarea name="mensagem" cols="35" rows="10" id="mensagem"></textarea></td>
					
					    </tr>
					
					    <tr>
					
					      <td> </td>
					
					      <td>
						  <input type="submit" name="Submit" value="Enviar Mensagem" style="height: 28px" /></td>
					
					    </tr>
					
					  </table>
					
					</form> 
            </div>
   
        </div>
        
<!-- end of middle column -->
        
<!-- start of right column -->
        
        <div id="templatemo_right_column">
        
            <div id="right_box02">
                <div class="rightbox02_top"><h2 align="center">Parceiros</h2></div>
				<IMG SRC="images/anuncieAqui.png">
            </div>
          
         </div>
        
<!-- end of right column -->
    
    </div>
    
<!-- end of content -->
        
<!--Toda essa bagunca eh o nomezinho embaixo, favor nao mecher aqui...  INICIO -->        
	<div id="templatemo_footer">
            <a href="index.php">Home</a> | <a href="sobre.php">Sobre</a> |  <a href="form_contato.php">Fale Conosco</a><br />
            <a href="http://www.promotravel.com.br" target="_blank">Viagem Promoção</a>
        <a class="powertiny" href="http://www.promotravel.com.br" title="Powered by Promo Travel"
style="display:block !important;visibility:visible !important;text-indent:0 !important;position:relative !important;height:auto !important;width:95px !important;overflow:visible !important;text-decoration:none;cursor:pointer !important;margin:0 auto !important">
<span style="background:url(images/powerlogo.png) no-repeat center 7px; margin:0 auto;display:inline-block !important;visibility:visible !important;text-indent:-9000px !important;position:static !important;overflow: auto !important;width:62px !important;height:30px !important">Wufoo</span>
<b style="display:block !important;visibility:visible !important;text-indent:0 !important;position:static !important;height:auto !important;width:auto !important;overflow: auto !important;font-weight:normal;font-size:9px;color:#777;padding:0 0 0 3px;">Designed</b>
</a>
		</div>
    </div>
<!--Toda essa bagunca eh o nomeziho embaixo, favor nao mecher aqui...   FIM -->

</body>

</html>