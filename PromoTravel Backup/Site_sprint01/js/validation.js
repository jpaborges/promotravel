$(function() {
			var availableTags = [
			"Alta Floresta (AFL)" ,
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
			"Vitória da Conquista (VDC)"
			];
			$( ".autocomplete-city" ).autocomplete({
				source: availableTags
			});
		});



function validate_city(campo){
	var str = document.getElementById(campo).value;

	if( str != "" && aNames.indexOf(str)==-1 ){
		alert("Preencha o campo " + campo + " corretamente.");
		document.getElementById(campo).value = "";
	}
}

function validate_radio()
{
	//Verifica o tipo de viagem selecionada e adapta o formulario e outras variaveis a ela.
	//Ex: Somente ida não necessita preencher o campo de volta.

	var len = document.getElementsByName('tipoDaViagem').length;
	for (i = 0; i <len; i++) 
	{
		if (document.getElementsByName('tipoDaViagem').item(i).checked) 
		{
			opcao = document.getElementsByName('tipoDaViagem').item(i).value;
			if ( opcao == "Somente Ida")
			{
			document.getElementById("volta").disabled = "disabled" ;
			document.getElementById("voltabt").disabled = "disabled" ; 
			}
			else
			{
				document.getElementById("volta").disabled = "";
				document.getElementById("voltabt").disabled = "" ;
			}
			return true;
		}
	}
}

function validate_value(campo, separador_milhar, separador_decimal, tecla)
{ 
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? tecla.which : tecla.keyCode;

	if (whichCode == 13) return true; // Tecla Enter
	if (whichCode == 8) return true; // Tecla Delete
	key = String.fromCharCode(whichCode); // Pegando o valor digitado
	if (strCheck.indexOf(key) == -1) return false; // Valor inválido (não inteiro)
	len = campo.value.length;
	for(i = 0; i < len; i++)
	if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != separador_decimal)) break;
	aux = '';
	for(; i < len; i++)
	if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
	aux += key;
	len = aux.length;
	if (len == 0) campo.value = '';
	if (len == 1) campo.value = '0'+ separador_decimal + '0' + aux;
	if (len == 2) campo.value = '0'+ separador_decimal + aux;

	if (len > 2) {
	aux2 = '';

	for (j = 0, i = len - 3; i >= 0; i--) {
		if (j == 3) {
			aux2 += separador_milhar;
			j = 0;
		}
		aux2 += aux.charAt(i);
		j++;
	}

campo.value = '';
len2 = aux2.length;
for (i = len2 - 1; i >= 0; i--)
campo.value += aux2.charAt(i);
campo.value += separador_decimal + aux.substr(len - 2, len);
}

return false;
}

function validate_email() {
var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var address = document.getElementById("email").value;
if(reg.test(address) == false) {
alert('Endereco de Email Inválido');
document.getElementById("email").value = "";
return false;
}
else
return true;
}