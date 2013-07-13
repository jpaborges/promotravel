


if(opcao == "Ida e Volta" && (a == "" || b == "") && chkFds == false && chkFeriados == false)
{
	alert("Você deve selecionar uma data de ida e outra para volta ou clicar em finais de semana ou feriados!");
	return false;
}
if( opcao == "Somente Ida" && a == "" && chkFds == false && chkFeriados == false)
{
	alert("Você deve selecionar uma data de ida ou clicar em finais de semana ou feriados!");
	return false;	
}
//
if ( opcao == "Ida e Volta" )
{
	//Se for Ida e Volta, efetua a verificação da data valida, levando em consideração valores validos para periodos. Ex: Data de ida tem que ser antes da volta, como ambas as datas devem ser após o dia atual
	if( validate_date(0,a,b) )
	{
		var textFieldVal = 'Ida: ' + a + ', Volta: ' + b;
	}
	else
	{
		if (chkFds == false && chkFeriados == false){
			alert("Período Inválido!");
			return false;
		}
	}
}
else
{
	
	if( validate_date(1,a) )
	{
		
		var textFieldVal = 'Ida: ' + a;
	}
	else
	{
		if (chkFds == false && chkFeriados == false){
			alert("Data Inválida!");
			return false;
		}
	}	
}

//Isso nunca seria executado teoricamente!
if (textFieldVal == "") {
alert("Você deve selecionar uma data!");
return false;
}

//Se uma data ja existir na lista, irá mostra-la e então um aviso será exibido
for (var i=0; i<opts.length; i++) {
if (opts[i].value.replace(/^\s+|\s+$/g,"").toLowerCase() == textFieldVal ) {
alert("Essa data já foi adicionada!"); 
opts[i].selected = true; 
return false; 
}

function dateToStr(date)
{// retorna uma string no formato dd/MM/yyyy dado um date
	var str = padStr(date.getDate()) + "/" + padStr(date.getMonth() + 1) + "/" + padStr(date.getFullYear());
	return str;
}
function padStr(i) {
    return (i < 10) ? "0" + i : "" + i;
}

function strToDate(dateString)
{// retorna um objeto do tipo date dado uma string no formato dd/MM/yyyy
	var curValue = dateString;
	var sepChar= "/";
	var curPos=0;
	var cDate,cMonth,cYear,endPos;

	//extrai a parte referente ao dia
	curPos=dateString.indexOf(sepChar);
	cDate=dateString.substring(0,curPos);

	//extrai a parte referente ao mes
	endPos=dateString.indexOf(sepChar,curPos+1);	 
	cMonth=dateString.substring(curPos+1,endPos);

	//extrai a parte referente ao ano	
	curPos=endPos;
	endPos=curPos+5;	
	cYear=curValue.substring(curPos+1,endPos);

	//Cria o objeto do tipo Date
	dtObject=new Date(cYear,cMonth-1,cDate);	
	
	
	//Se tiver selecionado ida e volta
		//Se o feriado for numa segunda a data de ida fica para

	return dtObject;
}



function validate_date(tipo,ida,volta)
{ //validate_date = Valida o campo de ida e volta, verificando se as datas são valores válidos lógicamente.

var dateString = ida;
var today = new Date();
if( tipo == 0 )
var dateString2 = volta;

//Essa função retorna um objeto do tipo date depois de aceito
dtObject=strToDate(dateString);	
if ( tipo == 1 && (dtObject < today) || (( ((dtObject.getTime() - today.getTime())/86400000) <= 3)) )
	return false;
if ( tipo == 1 )
	return true;


//------------------------------------------
//Inicia a verificação do segundo campo, no caso volta

//Cria o objeto do tipo Date
dtObject2=strToDate(dateString2);	

//Realiza a comparação entre os objetos do tipo date


if ( (dtObject > dtObject2) || ( ((dtObject.getTime() - today.getTime())/86400000) <= 3)  || (dtObject2 < today)) 
return false;
else
return true;
}