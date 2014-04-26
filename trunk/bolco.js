function OnlyNumbers(e) { 
	if (window.event) { 
		tecla = e.keyCode; 
	} else if (e.which) { 
        tecla = e.which; 
   	} 
    if ( (tecla >= 48 && tecla <= 57)||(tecla == 8 ) ) {
      	return true;
    } else {
     	return false;
    }
}

function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}

function control_onfocus(campo){
 campo.style.backgroundColor='#cccccc';
}
function control_onblur(campo){
 campo.style.backgroundColor='#FFFFFF';
}

function atualizaHorario(obj,prefixo) {
  var dataAtual = new Date();
  dataAtual.setTime(eval(obj).value);
  $(prefixo+'h').innerHTML = dataAtual.getHours();
  $(prefixo+'m').innerHTML = dataAtual.getMinutes();
//  $(prefixo+'s').innerHTML = dataAtual.getSeconds();
  eval(obj).value = dataAtual.getTime() + 1000;
  setTimeout("atualizaHorario('"+obj+"','"+prefixo+"')",1000);
}

function selecionarTab(num,local,pri) {
	if (pri) {
		alert("Voce precisa fazer sua inscricao abaixo primeiro!!!");
		return false;
	}
	for(var i = 1; i < 8; i++)
		if ($("tab0"+i).className = "tdMenuPanelOn")
			$("tab0"+i).className = "tdMenuPanelOff";
	$("tab0"+num).className = "tdMenuPanelOn";	
    $("fAbaixo").src = local;
	return true;
}

function selecionarTab2(num,local) {
	//for(var i = 1; i < 6; i++)
	//	if ($("tab0"+i).className = "tdMenuPanelOn")
	//		$("tab0"+i).className = "tdMenuPanelOff";
	//$("tab0"+num).className = "tdMenuPanelOn";	
    window.location = local;
}

function EnviarConvite() {
	var email = document.fConvite.iEmailConvite.value;
	if (!isValidEmail(email)) {
		alert("E-mail invalido");
		return false;
	}
	$("fAbaixo").src = "./enviarConvite.php?c="+email;
	var numConvites = parseInt($("numConvites").innerHTML);
	numConvites--;
	document.fConvite.iEmailConvite.value = "";
	if (numConvites > 0) {
		$("numConvites").innerHTML = numConvites;
	} else {
		$("dConvite").innerHTML = "<div class='divAtencao'>Voc&ecirc; n&atilde;o possui mais convites!!!</div>";
	}
}

function EsqueciSenha() {
	var email = document.fLogin.username.value;
	if (!isValidEmail(email)) {
		alert("E-mail de usuario invalido");
		return false;
	}
	$("fAbaixo").src = "./esqueciSenha.php?e="+email;
}

function isValidEmail(str) {
   return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
}

function ModTam(e) {
 //alert(window.innerHeight);
 if (document.all) {
   $("fAbaixo").height = document.documentElement.clientHeight - 233;
 } else {
   $("fAbaixo").height = window.innerHeight - 233;
 }
}

function ExibirJogo(num,pri) {
	if (pri) {
		alert("Voce precisa fazer sua inscricao abaixo primeiro!!!");
		return false;
	}
	for(var i = 1; i < 8; i++)
		if ($("tab0"+i).className = "tdMenuPanelOn")
			$("tab0"+i).className = "tdMenuPanelOff";
    $("fAbaixo").src = "partida.php?j="+num;
	return true;
}

function irJogo(jid) {
  window.location="jogo.php?j="+jid;
}

function irresultado(jid) {
  window.location="mresultado.php?us="+jid;
}