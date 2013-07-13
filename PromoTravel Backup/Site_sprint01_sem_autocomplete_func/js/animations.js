function animations(){

/* MOUSE MUDANDO POSIÇÂO DO BACKGROUND
var actual_x = 0;
var actual_y = 0;
 $(document).mousemove(function(e){
      //$('#status').html(e.pageX +', '+ e.pageY);
	var x = e.pageX;
	var y = e.pageY;

	$("body").stop().animate({backgroundPosition:x+"px " + y+"px"});
	
	actual_x = e.pageX;
	actual_y = e.pageY;
	
   });*/
							

/*
//SHOW CALENDAR MODAL

$('input[name=calendarIda],input[name=calendarVolta]').click(
		 function(){
				var h = $(document).height();
				$('#lightbox').css({height: h+'px'});
				$('#lightbox').fadeIn(500);
				$('.centralizing').fadeIn(500);
			}
	);
//HIDE CALENDAR MODAL
$('#lightbox').click(
					 function(){
			 			$('#lightbox').fadeOut('slow');
						$('.centralizing').fadeOut(200);
				   }
	);
	
	$('input[type=button]').click( function(){ alert('test');});
	$('.facebook-plugin').load(function(){
			   $('.facebook-preloader').fadeOut('fast');
			   });
	*/

$(function() {
			var availableTags = [
			"Alta Floresta (AFL)" ,
			"Altamira (ATM)" ,
			"Aracaju (AJU)" ,
			"Aragua&iacute;na (AUX)" ,
			"Araraquara (AQA)" ,
			"Arax&aacute; (AAX)" ,
			"Ara&ccedil;atuba (ARU)" ,
			"Barreiras (BRA)" ,
			"Bauru (JTC)" ,
			"Belo Horizonte / Confins (CNF)" ,
			"Belo Horizonte / Pampulha (PLU)" ,
			"Belo Horizonte / Todos os Aeroportos (BHZ)" ,
			"Bel&eacute;m (BEL)" ,
			"Boa Vista (BVB)" ,
			"Bonito (BYO)" ,
			"Bras&iacute;lia (BSB)" ,
			"Cacoal (OAL)",
			"Campinas / Viracopos (VCP) " ,
			"Campo Grande (CGR) " ,
			"Caraj&aacute;s (CKS)" ,
			"Canelas (QCN)",
			"Cascavel (CAC)" ,
			"Ca&ccedil;ador (CFC)" ,
			"Chapec&oacute; (XAP)" ,
			"Comandatuba (UNA)" ,
			"Corumb&aacute; (CMG)" ,
			"Crici&uacute;ma (CCM)" ,
			"Cruzeiro do Sul (CZS)" ,
			"Cuiab&aacute; (CGB)" ,
			"Curitiba (CWB)" ,
			"Dourados (DOU)" ,
			"Erechim (ERM)" ,
			"Fernando de Noronha (FEN)" ,
			"Florian&oacute;polis (FLN)" ,
			"Fortaleza (FOR)" ,
			"Foz do Igua&ccedil;u (IGU)" ,
			"Franca (FRC)" ,
			"Goiânia (GYN)" ,
			"Gov. Valadares (GVR)" ,
			"Guarapuava (GPB)" ,
			"Ilh&eacute;us (IOS)" ,
			"Imperatriz (IMP)" ,
			"Ipatinga (IPN)" ,
			"Itaituba (ITB)" ,
			"Ji-Paran&aacute; (JPR)" ,
			"Joa&ccedil;aba (JCB)" ,
			"Joinville (JOI)" ,
			"Jo&atilde;o Pessoa (JPA)" ,
			"Juiz de Fora (JDF)" ,
			"Len&ccedil;&oacute;is (LEC)" ,
			"Londrina (LDB)" ,
			"Macap&aacute; (MCP)" ,
			"Maca&eacute; (MEA)" ,
			"Macei&oacute; (MCZ)" ,
			"Manaus (MAO)" ,
			"Marab&aacute; (MAB)" ,
			"Maring&aacute; (MGF)" ,
			"Mar&iacute;lia (MII)" ,
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
			"Ribeir&atilde;o Preto (RAO)" ,
			"Rio Branco (RBR)" ,
			"Rio Grande (RIG)" ,
			"Rio Verde (RVD)" ,
			"Rio de Janeiro / Gale&atilde;o (GIG)" ,
			"Rio de Janeiro / Santos Dumont (SDU)" ,
			"Rio de Janeiro / Todos os Aeroportos (RIO)" ,
			"Rondon&oacute;polis (ROO)" ,
			"Salvador (SSA)" ,
			"Santa Maria (RIA)" ,
			"Santa Rosa (SRA)" ,
			"Santar&eacute;m (STM)" ,
			"Santo Angelo (GEL)" ,
			"Sinop (OPS)" ,
			"S&atilde;o Jos&eacute; do Rio Preto (SJP)" ,
			"S&atilde;o Jos&eacute; dos Campos (SJK)" ,
			"S&atilde;o Lu&iacute;s (SLZ)" ,
			"S&atilde;o Paulo / Congonhas (CGH)" ,
			"S&atilde;o Paulo / Guarulhos (GRU)" ,
			"S&atilde;o Paulo / Todos os Aeroportos (SAO)" ,
			"Tabatinga (TBT)" ,
			"Tefe (TFF)" ,
			"Teresina (THE)" ,
			"Trombetas (TMT)" ,
			"Tucuru&iacute; (TUR)" ,
			"Uberaba (UBA)" ,
			"Uberlândia (UDI)" ,
			"Uruguaiana (URG)" ,
			"Vilhena (BVH)" ,
			"Vit&oacute;ria (VIX)" ,
			"Vit&oacute;ria da Conquista (VDC)"
			];
			$( ".autocomplete-city" ).autocomplete({
				source: availableTags
			});
		});


	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		buttonImage: "imgs/calendar_icon.png",
		buttonImageOnly: true
	});
	
	//Criando Lista encadeada
function LinkedListNode() {
	this.data = null;
	this.next = null;
}

function LinkedList() {
	this.firstNode = null;
	this.lastNode = null;
	this.size = 0;
}

this.add = function(data) {

		var newNode = new LinkedListNode();
		newNode.data = data;

		if (this.firstNode == null) {
			this.firstNode = newNode;
			this.lastNode = newNode;
		}
		else {
			this.lastNode.next = newNode;
			this.lastNode = newNode;
		}

		this.size++;
	}
	
this.remove = function(data) {
		var currentNode = this.firstNode;

        if (this.size == 0) {
        	return;
        }

        var wasDeleted = false;

        /* Are we deleting the first node? */
        if (data == currentNode.data) {

        	/* Only one node in list, be careful! */
            if (currentNode.next == null) {
            	this.firstNode.data = null;
            	this.firstNode = null;
            	this.lastNode = null;
            	this.size--;
            	return;
            }

        	currentNode.data = null;
        	currentNode = currentNode.next;
        	this.firstNode = currentNode;
        	this.size--;
        	return;
        }

        while (true) {
            /* If end of list, stop */
            if (currentNode == null) {
            	wasDeleted = false;
                break;
            }

            /* Check if the data of the next is what we're looking for */
            var nextNode = currentNode.next;
            if (nextNode != null) {
                if (data == nextNode.data) {

                    /* Found the right one, loop around the node */
                    var nextNextNode = nextNode.next;
                    currentNode.next = nextNextNode;

                    nextNode = null;
                    wasDeleted = true;
                    break;
                }
            }

            currentNode = currentNode.next;
        }

        if (wasDeleted) {
        	this.size--;
        }
    }
	
	this.getSize = function() {
		return this.size;
	}

	this.indexOf = function(data) {
		var currentNode = this.firstNode;
		var position = 0;
		var found = false;

        for (; ; position++) {
            if (currentNode == null) {
                break;
            }

            if (data == currentNode.data) {
            	found = true;
                break;
            }

            currentNode = currentNode.next;
        }

        if (!found) {
        	position = -1;
        }

        return position;
	}

	this.toString = function() {
	    var currentNode = this.firstNode;

	    result = '{';

	    for (i = 0; currentNode != null; i++) {
	    	if (i > 0) {
	    		result += ',';
	    	}
	    	var dataObject = currentNode.data;

	    	result += (dataObject == null ? '' : dataObject);
	        currentNode = currentNode.next;
	    }
	    result += '}';

	    return result;
	}
//FIM Lista encadeada
	
	var itensDates = 0;
	
	$('input[name=inserirDatas]').click(function (){
				   var ida = $('input[name="dataIda"]').val();
				   var idaID = ida.split('/');
				   var volta = $('input[name="dataVolta"]').val();
				   var voltaID = volta.split('/');
		
				   
				   //var radiob = $('input[name="tipoDaViagem"]').is(":checked");
				   
				   //var radiob = $('input[name="tipoDaViagem"]').val();
				   
				   //var data_ida = ida.split('/');
				   //var data_volta = ida.split('/');
				   //DIA -> 0
				   //MES -> 1
				   //ANO -> 2
				   
				   var radiob = "";
				   $('input:radio[name=tipoDaViagem]').each(function() {
                        //Verifica qual está selecionado e guarda em radiob
                        if ($(this).is(':checked'))
                            radiob = $(this).val();
                    });
					
					//Se for somente ida e tiver preenchido
				   if(radiob == "Somente Ida" && ida != "")
				   {
				   		$('input[name="dataIda"]').val("");
				   		$('input[name="dataVolta"]').val("");
						if(validate_date(1,ida,volta))
						{
							//Se não tem nenhum elemento na lista
							if(itensDates == 0)
							{
								//Adicione na lista
								itensDates = itensDates + 1;
								$('.list-date').html("<div class='item-date' style='display:none;' id='item"+idaID[0]+idaID[1]+idaID[2]+"'> <label><b>Ida :</b>"+ida +"</label><input type='image' src='imgs\\close_icon.png' class='btn-remove-item'/> </div>");
							}
							else
							{
								//Se tiver insira os outros elementos atuais e junte com o novo.
								itensDates = itensDates + 1;
								var actualItens = $('.list-date').html();
								$('.list-date').html(actualItens+
										"<div class='item-date' style='display:none;' id='item"+idaID[0]+idaID[1]+idaID[2]+
										"'> <label><b>Ida: </b>"+ida +"</label><input class='btn-remove-item' type='image' src='imgs\\close_icon.png'/></div>", function(){$('#item'+itensDates).slideDown('fast');});							
							}
							
							//Coisa de designer '0'
							$('#item'+idaID[0]+idaID[1]+idaID[2]).fadeIn('fast');
							updateRemoveFunction();
							//Esta função acima é rodada toda vez que um novo item eh inserido. Pois o jquery so associa um método à um elemento o qual o seletor alcanse quando rodado.					
							$('input[name="dataIda"]').removeClass('input-erro');
							$('input[name="dataVolta"]').removeClass('input-erro');
							$('#possiveis-datas').slideUp(300);
						}
						else
						{
							alert("colocar aqui erro bonitinho que a data de somente ida é invalida :D");
						}
						
				   }
				   //Se for ida e volta e os campos estiverem preenchidos
				   else if(radiob == "Ida e Volta" && ida != "" &&  volta != "")
				   {
						$('input[name="dataIda"]').val("");
				   		$('input[name="dataVolta"]').val("");
						if(validate_date(0,ida,volta))
						{
							//Se não tem nenhum elemento na lista
							if(itensDates == 0)
							{
								//Adicione na lista
								itensDates = itensDates + 1;
								$('.list-date').html("<div class='item-date' style='display:none;' id='item"+itensDates+"'> <label><b>Ida :</b>"+ida +"</label><label><b>Volta: </b>"+volta+"</label><input type='image' src='imgs\\close_icon.png' class='btn-remove-item'/> </div>");
							}
							else
							{
								//Se tiver insira os outros elementos atuais e junte com o novo.
								itensDates = itensDates + 1;
								var actualItens = $('.list-date').html();
								$('.list-date').html(actualItens+
										"<div class='item-date' style='display:none;' id='item"+itensDates+
										"'> <label><b>Ida: </b>"+ida +"</label><label><b>Volta:</b>"+volta+
										"</label><input class='btn-remove-item' type='image' src='imgs\\close_icon.png'/></div>", function(){$('#item'+itensDates).slideDown('fast');});							
							}
							
							//Coisa de designer '0'
							$('#item'+itensDates).fadeIn('fast');
							updateRemoveFunction();
							//Esta função acima é rodada toda vez que um novo item eh inserido. Pois o jquery so associa um método à um elemento o qual o seletor alcanse quando rodado.					
							$('input[name="dataIda"]').removeClass('input-erro');
							$('input[name="dataVolta"]').removeClass('input-erro');
							$('#possiveis-datas').slideUp(300);
						}
						else
						{
							alert("colocar aqui erro bonitinho que a data de ida e volta são invalidas :D");
						}
					}
					   else{
						   //Datas vazias
					   $('#possiveis-datas').slideDown(250);
						$('input[name="dataIda"]').addClass('input-erro');
						$('input[name="dataVolta"]').addClass('input-erro');
						   }
	});
	function updateRemoveFunction(){
		$('.btn-remove-item').click(function(){
											 $(this).parent().fadeOut(350, function(){$(this).remove();});
											 itensDates = itensDates -1;
											 if(itensDates == 0){
						 							$('.list-date').html("<div class='empty-list'>Lista Vazia - Digite os campos disponiveis a cima e clique em 'Inserir Datas'</div>");
												 }
											 });
	}
	
	//validate_date = Valida o campo de ida e volta, verificando se as datas são valores válidos lógicamente.
	function validate_date(tipo,ida,volta)
		{ 
		//Tipo 0 -> Ida e Volta
		//Tipo 1 -> Somente Ida

		var dateString = ida;
		var dateString2 = volta;
		var today = new Date();


		//Essa função retorna um objeto do tipo date depois de aceito
		dtObject=strToDate(dateString);	
		
		//Se ida for antes de hoje, ou antes de 3 dias de diferença 
		if ( tipo == 1 && (dtObject < today) || (( ((dtObject.getTime() - today.getTime())/86400000) <= 3)) )
			return false;
			
		if ( tipo == 1 )
			return true;

		
		//------------------------------------------
		//Inicia a verificação do segundo campo, no caso volta
		//Cria o objeto do tipo Date
		dtObject2=strToDate(dateString2);
		
		//Realiza a comparação entre os objetos do tipo date

		//Se ida for depois da volta, ou ida com 3 dias de diferença de hoje, ou se volta for antes de hoje
		
		if ( (dtObject > dtObject2) || ( ((dtObject.getTime() - today.getTime())/86400000) <= 3)  || (dtObject2 < today) || (dtObject < today) ) 
		return false;
		else
		{
			return true;
		}
		}
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
			objret=new Date(cYear,cMonth-1,cDate);	
			
			
			//Se tiver selecionado ida e volta
				//Se o feriado for numa segunda a data de ida fica para

			return objret;
		}

		
$(document).ready(function () {
	//MENU CONSTRUCTOR
	var lastActivedID = 'btn-acompanhar';
	$('#'+lastActivedID).addClass('actived');
	$('#'+lastActivedID).stop().animate({width:'154px', opacity:1,marginTop:'-10px'});
	$('#btn-container').animate({marginLeft:'25px'});

	//MENU ANIMATION
	$('#btn-container .btn-main').css({width:'120px',opacity:0.8}).hover(
			function(){
				var className = new String($(this).attr('class'));
				if(className.match('actived') == null){
					$(this).stop().animate({width:'154px', opacity:1, marginTop:'-10px'}); $('#btn-container').stop().animate({marginLeft:'0px'});
				}
			},
			function(){
				var className =  new String($(this).attr('class'));
				if(className.match('actived') == null){
					$(this).stop().animate({width:'120px', opacity:0.8,marginTop:'0px'}); $('#btn-container').stop().animate({marginLeft:'25px'});
					}
				}
			);

	//ACTIVE MENUITEM
	$('#btn-container .btn-main').click(
										function(){
											$('#'+lastActivedID).removeClass('actived');
											
											//put on state off
											$('#'+lastActivedID).stop().animate({width:'120px', opacity:0.8,marginTop:'0px'});
											$('#btn-container').stop().animate({marginLeft:'25px'});
											
											$(this).addClass('actived');
											lastActivedID = $(this).attr('id');
											$(this).stop().css({width:'154px', opacity:1, marginTop:'-10px'});
											}										
										);
	animations();

});

/*
$('input[name=calendarIda],input[name=calendarVolta]').click(
		 function(){
			 	var h = $(document).height();
			 	$('#lightbox').css({height: h+'px'});
			 	$('#lightbox').fadeIn(500);
			 	$('.centralizing').fadeIn(500);
			}
	);
	
	$('#lightbox').click(
		 function(){
			 			$('#lightbox').fadeOut('slow');
						$('.centralizing').fadeOut(200);
				   }
	);
	
	$('input[type=button]').click( function(){ alert('test');});
							 }); */
