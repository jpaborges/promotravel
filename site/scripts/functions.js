// JavaScript Document
<!-- HIDE FROM OLD BROWSERS
/* <![CDATA[ */

function autoCompleteDB()
{
	this.aNames=new Array();
}

autoCompleteDB.prototype.assignArray=function(aList)
{
	this.aNames=aList;
};

autoCompleteDB.prototype.getMatches=function(str,aList,maxSize)
{
	/* debug */ //alert(maxSize+"ok getmatches");
	var ctr=0;
	for(var i in this.aNames)
	{
		if(this.aNames[i].toLowerCase().indexOf(str.toLowerCase())==0) /*looking for case insensitive matches */
		{
			aList.push(this.aNames[i]);
			ctr++;
		}
		if(ctr==(maxSize-1)) /* counter to limit no of matches to maxSize */
			break;
	}
};

function autoComplete(aNames,oText,oDiv,maxSize)
{

	this.oText=oText;
	this.oDiv=oDiv;
	this.maxSize=maxSize;
	this.cur=-1;

	
	/*debug here */
	//alert(oText+","+this.oDiv);
	
	this.db=new autoCompleteDB();
	this.db.assignArray(aNames);
	
	oText.onkeyup=this.keyUp;
	oText.onkeydown=this.keyDown;
	oText.autoComplete=this;
	oText.onblur=this.hideSuggest;
}

autoComplete.prototype.hideSuggest=function()
{
	this.autoComplete.oDiv.style.visibility="hidden";
	getPrecoMedio();
	
};

autoComplete.prototype.selectText=function(iStart,iEnd)
{
	if(this.oText.createTextRange) /* For IE */
	{
		var oRange=this.oText.createTextRange();
		oRange.moveStart("character",iStart);
		oRange.moveEnd("character",iEnd-this.oText.value.length);
		oRange.select();
	}
	else if(this.oText.setSelectionRange) /* For Mozilla */
	{
		this.oText.setSelectionRange(iStart,iEnd);
	}
	this.oText.focus();
};

autoComplete.prototype.textComplete=function(sFirstMatch)
{
	if(this.oText.createTextRange || this.oText.setSelectionRange)
	{
		var iStart=this.oText.value.length;
		this.oText.value=sFirstMatch;
		this.selectText(iStart,sFirstMatch.length);
	}
};

autoComplete.prototype.keyDown=function(oEvent)
{
	oEvent=window.event || oEvent;
	iKeyCode=oEvent.keyCode;

	switch(iKeyCode)
	{
		case 38: //up arrow
			this.autoComplete.moveUp();
			break;
		case 40: //down arrow
			this.autoComplete.moveDown();
			break;
		case 13: //return key
			window.focus();
			break;
		case 27: //escape key
			window.focus();
			break;
	}
};

autoComplete.prototype.moveDown=function()
{
	if(this.oDiv.childNodes.length>0 && this.cur<(this.oDiv.childNodes.length-1))
	{
		++this.cur;
		for(var i=0;i<this.oDiv.childNodes.length;i++)
		{
			if(i==this.cur)
			{
				this.oDiv.childNodes[i].className="over";
				this.oText.value=this.oDiv.childNodes[i].innerHTML;
			}
			else
			{
				this.oDiv.childNodes[i].className="";
			}
		}
	}
};

autoComplete.prototype.moveUp=function()
{
	if(this.oDiv.childNodes.length>0 && this.cur>0)
	{
		--this.cur;
		for(var i=0;i<this.oDiv.childNodes.length;i++)
		{
			if(i==this.cur)
			{
				this.oDiv.childNodes[i].className="over";
				this.oText.value=this.oDiv.childNodes[i].innerHTML;
			}
			else
			{
				this.oDiv.childNodes[i].className="";
			}
		}
	}
};

autoComplete.prototype.keyUp=function(oEvent)
{
	oEvent=oEvent || window.event;
	var iKeyCode=oEvent.keyCode;
	
	if(iKeyCode==8 || iKeyCode==46)
	{
		this.autoComplete.onTextChange(false); /* without autocomplete */
	}
	else if (iKeyCode <= 46 || (iKeyCode >= 112 && iKeyCode <= 123) || iKeyCode == 222 || iKeyCode == 219 || iKeyCode == 192) 
	{
        //ignore
    } 
	else 
	{
		this.autoComplete.onTextChange(true); /* with autocomplete */
	}
};

autoComplete.prototype.positionSuggest=function() /* to calculate the appropriate poistion of the dropdown */
{
	var oNode=this.oText;
	var x=0,y=oNode.offsetHeight;

	while(oNode.offsetParent && oNode.offsetParent.tagName.toUpperCase() != 'BODY')
	{
		x+=oNode.offsetLeft;
		y+=oNode.offsetTop;
		oNode=oNode.offsetParent;
	}

	x+=oNode.offsetLeft;
	y+=oNode.offsetTop;

	this.oDiv.style.top=y+"px";
	this.oDiv.style.left=x+"px";
}

autoComplete.prototype.onTextChange=function(bTextComplete)
{
	var txt=this.oText.value;
	var oThis=this;
	this.cur=-1;
	
	if(txt.length>0)
	{
		while(this.oDiv.hasChildNodes())
			this.oDiv.removeChild(this.oDiv.firstChild);
		
		var aStr=new Array();
		this.db.getMatches(txt,aStr,this.maxSize);
		if(!aStr.length) {this.hideSuggest ;return}
		if(bTextComplete) this.textComplete(aStr[0]);
		this.positionSuggest();
		
		for(i in aStr)
		{
			var oNew=document.createElement('div');
			this.oDiv.appendChild(oNew);
			oNew.onmouseover=
			oNew.onmouseout=
			oNew.onmousedown=function(oEvent)
			{
				oEvent=window.event || oEvent;
				oSrcDiv=oEvent.target || oEvent.srcElement;

				//debug :window.status=oEvent.type;
				if(oEvent.type=="mousedown")
				{
					oThis.oText.value=this.innerHTML;
				}
				else if(oEvent.type=="mouseover")
				{
					this.className="over";
				}
				else if(oEvent.type=="mouseout")
				{
					this.className="";
				}
				else
				{
					this.oText.focus();
				}
			};
			oNew.innerHTML=aStr[i];
		}
		
		this.oDiv.style.visibility="visible";
	}
	else
	{
		this.oDiv.innerHTML="";
		this.oDiv.style.visibility="hidden";
	}
};

function createAutoComplete()
{
var aNames =
[
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

new autoComplete(aNames,document.getElementById('origem'),document.getElementById('suggest'),10);
new autoComplete(aNames,document.getElementById('destino'),document.getElementById('suggest'),10);

document.getElementById("volta").disabled = "";
document.getElementById("voltabt").disabled = "" ;
}

var opcao = "Ida e Volta";

function updateList () {
//updateList = Atualiza a lista de periodos escolhidos validando a data e o campo em si e colocando apenas os validos na lista.

var a = document.getElementById('ida').value;
var b = document.getElementById('volta').value;
var chkFds = document.getElementById('fds').checked;
var chkFeriados = document.getElementById('feriados').checked;

if (chkFds == true){
	if(opcao == "Ida e Volta")
		addFds(0);
	else
		addFds(1);
}

if (chkFeriados == true){
	if(opcao == "Ida e Volta")
		addFeriados(0);
	else
		addFeriados(1);
}


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
//Limpa os campos de ida e volta
document.getElementById('ida').value = "";
document.getElementById('volta').value = "";
document.getElementById('fds').checked = false;
document.getElementById('feriados').checked = false;
var languages = document.getElementById('languagesList');
var opts = document.getElementById('myForm').languages.options;
var antigo = textFieldVal;
textFieldVal = textFieldVal.replace(/^\s+|\s+$/g,"").toLowerCase(); 

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
}
//Adiciona o novo periodo a lista
opts[opts.length] = new Option (antigo, antigo); 
}

function alterarDataDblClique(){
	var opts = document.getElementById('myForm').languages.options;
	for (var i=0; i<opts.length; i++) {
		if (opts[i].selected ) {
			var s = opts[i].value.split(": ");
			document.getElementById('ida').value = s[1].split(",")[0];
			document.getElementById('volta').value = s[2];
			break;
		}
		//opts[i].selected = true; 
		//return false; 
	}
	removeList();
	
}

function addFds(tipo){ //Adiciona os próximos 4 finais de semana, sempre com saída na sexta e volta no domingo.

	var today = new Date();
	var textFieldVal = "";
	today.setDate(today.getDate()+4);
	var dtIda = new Date();
	var dtVolta = new Date();
	var day=today.getDay();
    dtIda.setDate(today.getDate()+ (5 - day));//proxima sexta
	dtVolta.setDate(today.getDate()+ (7 - day));//proximo domingo
	for  (var i =0;i<4; i++){
		textFieldVal = "";
		if (tipo == 0){
			textFieldVal = 'Ida: ' + dateToStr(dtIda) + ', Volta: ' + dateToStr(dtVolta);
		}
		else{
			textFieldVal = 'Ida: ' + dateToStr(dtIda);
		}
		
		//adiciona na lista
		var languages = document.getElementById('languagesList');
		var opts = document.getElementById('myForm').languages.options;
		var antigo = textFieldVal;
		textFieldVal = textFieldVal.replace(/^\s+|\s+$/g,"").toLowerCase(); 

		if (textFieldVal != "") {
			var add = true;
			for (var i=0; i<opts.length; i++) {
				if (opts[i].value.replace(/^\s+|\s+$/g,"").toLowerCase() == textFieldVal ) {
					add = false;
				}
			}
				//Adiciona o novo periodo a lista
				if(add)
					opts[opts.length] = new Option (antigo, antigo); 
			
		}
		
		dtIda.setDate(dtIda.getDate()+7);
		dtVolta.setDate(dtVolta.getDate()+7);
	}
	
}

function addFeriados(tipo){ //Adiciona os feriados nos próximos 3 meses.Ida no ultimo dia util antes do feriado e volta no ultimo dia util apos o feriado.
	var today = new Date();
	var listaFeriados = ["07/09/2012","12/10/2012","02/11/2012","15/11/2012","25/12/2012",
	"01/01/2013","12/02/2013","29/03/2013","21/04/2013","01/05/2013","30/06/2013","07/09/2013","12/10/2013","02/11/2013","15/11/2013","25/12/2013"];
	var dt, dtIda, dtVolta, day;
	var textFieldVal = "";
	
	for  (var i =0;i<listaFeriados.length; i++){
		textFieldVal = "";
		dt = strToDate(listaFeriados[i]);
		if ((dt > today) && (((dt.getTime() - today.getTime())/86400000) <= 90)){ //no intervalo de 3 meses
			//Ultimo dia util antes do feriado
			dtIda = strToDate(listaFeriados[i]);
			day=dt.getDay();
			switch (day)
			{
			case 0://domingo
			  dtIda.setDate(dtIda.getDate()-2);//ultima sexta
			  break;
			case 1://segunda
			  dtIda.setDate(dtIda.getDate()-3);//ultima sexta
			  break;
			case 2://terca
			  dtIda.setDate(dtIda.getDate()-4);//ultima sexta
			  break;
			default: dtIda.setDate(dtIda.getDate()-1); //ontem
			}

			if (tipo == 0){
				//Ida e volta
				dtVolta = strToDate(listaFeriados[i]);
				switch (day)
				{
				case 0://domingo
				  dtVolta = dt;//nesse domingo
				  break;
				case 4://quinta
				  dtVolta.setDate(dtVolta.getDate()+3);//proximo domingo
				  break;
				case 5://sexta
				  dtVolta.setDate(dtVolta.getDate()+2);//proximo domingo
				  break;
				default: dtVolta.setDate(dtVolta.getDate()+1);//amanha
				}
					if( validate_date(0,dateToStr(dtIda),dateToStr(dtVolta)) )
					{
						textFieldVal = 'Ida: ' + dateToStr(dtIda) + ', Volta: ' + dateToStr(dtVolta);
					}
			}
			else{
					if( validate_date(0,dateToStr(dtIda)) )
					{
						textFieldVal = 'Ida: ' + dateToStr(dtIda);
					}
			}
			
			//adiciona na lista
			var languages = document.getElementById('languagesList');
			var opts = document.getElementById('myForm').languages.options;
			var antigo = textFieldVal;
			textFieldVal = textFieldVal.replace(/^\s+|\s+$/g,"").toLowerCase(); 

			if (textFieldVal != "") {
				var add = true;
				for (var i=0; i<opts.length; i++) {
					if (opts[i].value.replace(/^\s+|\s+$/g,"").toLowerCase() == textFieldVal ) {
						add = false;
					}
				}
					//Adiciona o novo periodo a lista
					if(add)
						opts[opts.length] = new Option (antigo, antigo); 
				
			}
			
			
		}
	}
	
	//alert(listaFeriados);
	return true;
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

function limpartudo()
{	//limpartudo = Responsável por limpar todos os campos e listas mais complexas, bem como voltar as escolhas para o default

	var opts = document.getElementById('myForm').languages.options;
	opts.length = 0;
	opcao = "Ida e Volta";
	document.getElementById("volta").disabled = "" ;
	document.getElementById("voltabt").disabled = "" ;
	document.getElementById('fds').checked = false;
	document.getElementById('feriados').checked = false;
	document.getElementById("txtHint").innerHTML="";
	
}

function removeList()
{
  //removeList = Remove o elemento selecionado da lista de periodos
  
  var opts = document.getElementById('myForm').languages.options;
  var i;
  for (var i=0; i< opts.length; i++) 
  {
    if (opts[i].selected) 
	{
      opts.remove(i);
    }
  }
}

function selectAll() {
  // selectAll = Prepara e envia todos os elementos da lista de periodos para uma variavel oculta chamada alloptions no html
  if ( validate_email() )
  {
	  var opts = document.getElementById('myForm').languages.options;
	  var i;
	  var s = "";
	  if( opts.length == 0 )
	  {
	  alert("Nenhum período foi adicionado!");
	  return false;
	  }
	  if( document.getElementById("preco_esperado").value == "" )
	  {
	  alert("Digite o valor esperado!");
	  return false;
	  }
	  for (var i=0; i< opts.length; i++) 
	  {
		if( i != 0){
			s += '$' + opts[i].value;
		}
		else
		{
			s += opts[i].value;
		}
		
	  }
	  document.getElementById('myForm').alloptions.value = s;
	  document.getElementById('myForm').submit();
  }
  else
  return false;
  
}

function check()
{  
	
	// check = Verifica o tipo de viagem selecionada e adapta o formulario e outras variaveis a ela. Ex: Somente ida não necessita preencher o campo de volta.
	var len = document.getElementsByName('Tipo').length;
	for (i = 0; i <len; i++) 
	{
		if (document.getElementsByName('Tipo').item(i).checked) 
		{
			opcao = document.getElementsByName('Tipo').item(i).value;
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


function Limpar2(valor, validos) {
// Limpar2 = retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;
}
}
return result;
}

function getPrecoMedio()
{// executa uma chamada assincrona ao php

	var str = "";
	var origem = document.getElementById('origem').value;
	var destino = document.getElementById('destino').value;
	
	if (origem != "" && destino != ""){
		origem = origem.split(" (")[1].split(")")[0];	
		destino = destino.split(" (")[1].split(")")[0];	
		if(opcao == "Ida e Volta")
			str = "precoMedio.php?o="+origem+"&d="+destino+"&t=0";
		else
			str = "precoMedio.php?o="+origem+"&d="+destino+"&t=1";
			
		//alert(str);
		//document.getElementById("txtHint").innerHTML="<b>Preço médio é: R$ 946,00</b>";
	}
	
	
	if (str=="")
	  {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  } 
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET",str,true);
	xmlhttp.send();
}

function maisProcurados(obj)
{// Preeche a origem e o destino

	var origem = obj.split(" - ")[0];
	var destino = obj.split(" - ")[1];
	
	var aNames =
	[
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
	"Canelas (QCN)",
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

	for (var i=0; i< aNames.length; i++) {
		if (aNames[i].search(origem) != -1)
			document.getElementById('origem').value = aNames[i];
		
		if (aNames[i].search(destino) != -1)
			document.getElementById('destino').value = aNames[i];
	}
	
	getPrecoMedio();

}

function formatar_moeda(campo, separador_milhar, separador_decimal, tecla)
{ var sep = 0;
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
   // validate_email = Valida o campo E-mail
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.getElementById("email").value;
   if(reg.test(address) == false) {
      alert('Endereco de Email Invalido');
      return false;
   }
   else
   return true;
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