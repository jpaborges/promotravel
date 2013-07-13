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
alert('Endereco de Email Inv&aacute;lido');
document.getElementById("email").value = "";
return false;
}
else
return true;
}
/*############################## Parte João Luiz ##############################*/

function validate_email_contato(email) {
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(reg.test(email) == false) {
		return false;
	}
	else
		return true;
}

function enviarEmail() { 
	var email = document.getElementById("email").value;
	var nome = document.getElementById("nome").value;
	var mensagem = document.getElementById("mensagem").value;	
	var teste = null;
	if(nome != "")
	{
		if(mensagem != "")
		{
			if(validate_email_contato(email))
			{
				if(window.ActiveXObject)
				{
					teste = new ActiveXObject("Msxml2.DOMDocument.3.0");
					teste.async = true;
					teste.onreadystatechange = function () 
					{
						if(teste.readyState == 4)
						alert(teste.responseText);
					}
					teste.load("enviar_contato.php");
				}
				else if(window.XMLHttpRequest)
				{
					teste = new XMLHttpRequest();
					teste.onreadystatechange = function ()
					{
						if(teste.readyState == 4)
						alert(teste.responseText);
					}
					var url = "enviar_contato.php?nome="+nome+"&email="+email+"&mensagem="+mensagem;
					teste.open("GET", url ,true);
					teste.send(null);
				}
				else
					alert("Ajax não pode ser rodado");
			}
			else
			{
				alert("Favor preencher o campo email corretamente");
			}
		}
		else
		{
			alert("Favor preencher o campo mensagem");
		}
	} 
	else
	{ 
		alert("Favor preencher o campo nome"); 
	} 
} 
//Fim parte João Luiz