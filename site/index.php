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

</head>


<body onLoad="createAutoComplete();">
<div id="templatemo_container">
 
 <!-- inicio do cabecalho -->
    <div id="templatemo_header">
    
    	<div id="logosection"></div>
        
        <div id="header">
        	<div class="title">Diga quanto pode pagar, que <br /> <span class="bigtext">procuramos</span> <br /> por você!</div>
        </div>
	</div>   
 <!-- final do cabecalho -->
 
 <!-- inicio do menu de cima -->
	<div id="templatemo_menu">
    	<div id="search"></div>
        
        <div id="menu">
            <ul>
                <li><a href="#" class="current">Home</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="form_contato.php">Fale Conosco</a></li>
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
											"Campinas / Viracopos (VCP) " ,
											"Campo Grande (CGR) " ,
											"Carajás (CKS)" ,
											"Canelas (QCN)",
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
								echo '<li><a style="color: rgb(255,255,255)" onclick="maisProcurados('."'".'('.$r["Origem"].') - ('.$r["Destino"].')'."'".')">'.$origemLi[0].' - '.$destinoLi[0].'</a> </li>';
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
        
    	<div id="templatemo_middle_column">
    	  <div id="section2">
          <div class="section2_top"><h2>Passagens</h2></div>
                
                <form method="post" action="tratamento.php" id="myForm" name="myForm" autocomplete=off>
                
                <div class="form_row">
                    <li class="twoColumns">
                        <fieldset>
                            <![if !IE | (gte IE 8)]>
                            <legend class="desc"> Tipo de viagem <span class="req">*</span></legend>
                            <![endif]>
                            
                            <div>
                            <span>
                            <input class="field radio" type="Radio" name="Tipo" value="Somente Ida" onchange="check()" tabindex="1" />
                            <label class="choice" >Somente ida </label>
                            </span>
                            
                            <span>
                            <input class="field radio" type="Radio" name="Tipo" value="Ida e Volta" onchange="check()" tabindex="2" checked="checked" />
                            <label class="choice"> Ida e volta</label>
                            </span>
                            </div>
                            
                       </fieldset>
                   </li>
               </div>
                
			   
               <div class="form_row">
               <div id="suggest" style="visibility:hidden;border:#000000 1px solid;width:150px;z-index:100"></div>
                    <li>
                        <label class="desc" id="title16" for="Field16">Informaçoes da viagem<span id="req_16" class="req">*</span></label>
                        
                        <span>
                        <input id="origem" name="origem" type="text" onblur="getPrecoMedio()" style="border:#000000 1px solid;width:150px;" autocomplete=off class="field text fn" value="" size="15" tabindex="3" required />
                        <label for="origem">Origem</label>
                        </span> 
                        
                        <span>
                        <input id="destino" name="destino" type="text" onblur="getPrecoMedio()" style="border:#000000 1px solid;width:150px;" autocomplete=off class="field text ln" value="" size="15" tabindex="4" required />
                        <label for="destino">Destino</label>
                        </span>
                    </li>
          		</div>
               
                               
                <div class="form_row">
                    <li>
                        <label class="desc" > Email <span class="req">*</span></label>
                        <div><input id="email" name="email" type="text" class="field text medium" value="" maxlength="255" tabindex="5" required /></div>
                    </li>
                </div>
                
                
				<div class="form_row">               
                	<li class="date leftHalf">
                		<label title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" class="desc">Data de partida</label>
                        <input tabindex="6" type="text" class="inputfield" title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" readonly name="theDate" id="ida" onclick="displayCalendar(document.forms[0].theDate,'dd/mm/yyyy',this)"/>
                        
                        <input style="background-image:url(images/calendar.jpg); title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" height: 20px; width: 20px;" type="button"  onclick="displayCalendar(document.forms[0].theDate,'dd/mm/yyyy',this)"/>                        
					</li>
                </div>
                        
				<div class="form_row">
                	<li class="date rightHalf">
                		<label title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" class="desc">Data de volta</label>
                        <input tabindex="7" title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" type="text" class="inputfield" readonly id="volta" name="theDate2" onclick="displayCalendar2(document.forms[0].theDate,document.forms[0].theDate2,'dd/mm/yyyy',this)" disabled="disabled"/>
                        <input id="voltabt" title="Tente em dias da semana diferentes – não é só você que quer viajar na sexta a noite e voltar na segunda bem cedinho. Se você começar pesquisando nesses dias pode não encontrar a menor tarifa. Tente datas que caiam na segunda-feira, na terça-feira, na quarta-feira e no sábado" style="background-image:url(images/calendar.jpg); height: 20px; width: 20px;" type="button" onclick="displayCalendar2(document.forms[0].theDate,document.forms[0].theDate2,'dd/mm/yyyy',this)" disabled="disabled"/>
              		</li>
				</div>
                
                <div class="form_row">                      
           			<input type="checkbox" name="fds" id="fds" value="fds" alt="Adiciona os próximos 4 finais de semana, sempre com saída na sexta e volta no domingo." /> Finais de Semana    
                    <input type="checkbox" name="feriados" id="feriados" value="feriados" alt="Adiciona os feriados nos próximos 3 meses.Ida no ultimo dia útil antes do feriado e volta no ultimo dia útil após o feriado." /> Feriados         
                </div>
                
  				<div class="form_row">                      
           			<input class="button"  style="float:none;" name="Adicionar" type="button" value="Adicionar" onclick="updateList()"/>  
          		    <input class="button" value="Remover" type="button" style="float:none;" onclick="removeList()" />           
                </div>
                
  				<div class="form_row">
  					<li>
                		<label class="desc" id="title11" for="Field11">Períodos escolhidos:<span class="req">*</span></label>
                        <select rows="10" cols="50" tabindex="8"  class="field textarea medium" name="languages" size="10" id="selOriginalWindow" style="width:300px; height: 70px;"	multiple="multiple"></select>
	                </li>
 				</div>
  
				<div class="form_row">
                	<li>
                		<label class="desc">Preço Esperado<span class="req">*</span></label>
                		<span class="symbol">R$</span>
               			<input id="preco_esperado" name="preco_esperado" onclick="getPrecoMedio()" onfocus="getPrecoMedio()" onkeypress="return formatar_moeda(this,',','.',event);" type="text" class="field text currency nospin" value="" size="10" tabindex="9" />  
                        <div id="txtHint"><b></b></div>
                        <!--<label class="desc">Preço Médio<span class="req">*</span></label>  
                        <input id="preco_medio" name="preco_medio" type="text" class="field text currency nospin" value="" size="10" tabindex="9" />  -->        
					</li>       
                </div>
  
  
  				<div class="form_row">
                    <input type="hidden" name="alloptions" />              
                    <input class="button" type="button" name="Submit" value="Buscar" onclick="selectAll()" /> 
                    <input class="button" type="Reset" value="Limpar" onclick="limpartudo()"> 
                </div>
            	
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
            <a href="index.php">Home</a> | <a href="sobre.php">Sobre</a> | <a href="form_contato.php">Fale Conosco</a><br />
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