
function acompanhar_clicked(){
		acompanharOn();
		quemOff();
		faleOff();
		showContent();
}
function showContent(){
	$('#content').fadeIn(50).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);
	}
	
//ACOMPANHAR
function acompanharOn(){
	$('#btn-acompanhar').animate({marginLeft: "120px",marginTop: "-5px"}, 700 );
	}
function acompanharBegin(){
	$('#btn-acompanhar').animate({marginLeft: "343px", marginTop:"140px", opacity: 1.0}, 700 );
	}
	
//QUEM SOMOS
function quemOff(){
		$('#btn-quem').animate({marginLeft: "715px",marginTop:"28px", width:"130px", height:"147px", opacity: 0.75}, 700 );
	}
function quemBegin(){
		$('#btn-quem').animate({marginLeft: "423px",opacitty: 1.0}, 700 );
	}
	
//FALE CONOSCO
function faleOn(){
	$('#btn-fale').animate({marginLeft: "423px",marginTop:"140px", opacity: 1.0}, 700 );
	}
function faleOff(){
	$('#btn-fale').animate({marginLeft: "785px",marginTop:"145px", width:"130px", height:"147px", opacity: 0.75}, 700 );
	}
function falseBegin(){
	$('#btn-fale').animate({marginLeft: "423px",marginTop:"140px", opacity: 1.0}, 700 );
	}