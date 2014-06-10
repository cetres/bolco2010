<?php
require_once('pre.php');
session_cache_expire(10);
session_start();

if ($SERVIDOR==1) {
	$host = "localhost";
	$database = "cetres_bolco";
	$login_db = "cetres_bolco";
	$senha_db = "girafaganso";
} else {
	$host = "localhost";
	$database = "bolco";
	$login_db = "bolco";
	$senha_db = "girafaganso";
}

$ordem_jogos=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64);

function anti_sql_injection($string) {
    $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
    $string = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($string) : mysql_escape_string($string);
    return $string;
}

function LogBolco($tipo,$usuario,$descricao) {
   global $db;
   $res = $db->query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES (?, ?, ?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'))", array($tipo,$usuario,$descricao));
   if (PEAR::isError($res)) {
	 error_log($res->getMessage()." / ".$res->getDebugInfo());
   }
}

function verifica_usuario($email, $senha) {
    global $db;
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT count(*) as total from usuarios where email = '" . anti_sql_injection($email) . "' AND senha = '" . anti_sql_injection($senha) . "'";
	$re = mysql_query($q);
	$total = mysql_result($re, 0, "total");
	mysql_close();
	if($total != 1)  {
		if (isset($_POST["email"])) {
			echo "<script>alert('Senha incorreta!');";
			echo "window.location = '/';";
			echo "</script>";
		} else {
			echo "<script>window.location = '/';</script>";
		}
		exit;
	}
	if(!isset($_SESSION["email"]))  {
		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "select idusu, apelido, tipo,aceitouReg from usuarios where email = '$email' and senha = '$senha'";
		$rs = mysql_query($q);
		if (!$rs) {
	   		die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) >= 1){
			$_SESSION["nome"] = mysql_result($rs,0,"apelido");
		 	$_SESSION["tipo"] = mysql_result($rs,0,"tipo");
			$_SESSION["senha"] = $senha;
			$_SESSION["email"] = $email;
			$_SESSION["id"] =  mysql_result($rs,0,"idusu");
			$_SESSION["Aceitou"] =  mysql_result($rs,0,"aceitouReg");
			$db->query("UPDATE usuarios SET ultimoAcesso=CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') WHERE idusu=?",$_SESSION["id"]);
		}
	}
}

//verifico se existe a sessao e ja pego os dados que nela contem
if(isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
	$senha = $_SESSION["senha"];
	verifica_usuario($email, $senha);
} else {
 //aqui eu verifico se o usuario esta vindo de um formulario e pego os valores
	$email = isset($_POST["email"])?$_POST["email"]:"";
	$senha = isset($_POST["senha"])?$_POST["senha"]:"";
	verifica_usuario($email, $senha);
	$idusu = $_SESSION["id"];
	LogBolco('Log de Acesso', $idusu, 'Acesso ao Sistema');
}


function menu() {
	$tipo = $_SESSION["tipo"];
	printf ("<table cellspacing='0' cellpadding='0'>");
	printf ("<tr><td valign='bottom' width='800' valign='top' style='background-image:url(\"imagens/superiora.jpg\");background-repeat:no-repeat;background-position:center;'  height='118' border='0' alt=''><a href='logout.php'><p align='right' class='titulo'>Sair &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p></a></td></tr>");
	printf ("   <tr><td width='800' valign='top' height='1' bgcolor='#000000'></td></tr>");
	printf ("   <tr><td width='800' valign='top' height='50' background='imagens/menu.jpg'>");
	printf ("<table class='barra_menu' cellpadding='1' cellspacing='1'>");
	printf ("<tr>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='bolco.php'>In&iacute;cio</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='resultados.php'>Classifica&ccedil;&atilde;o</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='regulamento.php'>Regulamento</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	if ($tipo != "Visitante") {
		printf("<td><a class='titulo' href='cadastro.php'>Meus Dados</a></td><td width='36' align='center'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		printf ("<td><a class='titulo' href='jogos.php?g=8'>Palpites</b></td>");
		printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		if ($tipo == "admin") {
			printf ("<td><a class='titulo' href='admin/'>Admin</b></td>");
			printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		}
		printf ("<td width='230' align='right'><a class='titulo'>Usu&aacute;rio: </a><b class='titulo'>".$_SESSION["nome"]."</b></td>");
	}
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='/'>Sair</b></td>");
printf ("</tr></table>  ");
}

function menu2() {
	$tipo = $_SESSION["tipo"];
	printf ("<table cellspacing='0' cellpadding='0'>");
	printf ("<tr><td valign='bottom' width='850' valign='top' style='background-image:url(\"imagens/superiorini.jpg\");background-repeat:no-repeat;background-position:center;'  height='118' border='0' alt=''><a href='logout.php'><p align='right' class='titulo'>Sair &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p></a></td></tr>");
	printf ("   <tr><td width='800' valign='top' height='1' bgcolor='#000000'></td></tr>");
	printf ("   <tr><td width='800' valign='top' height='50' background='imagens/menu.jpg'>");
	printf ("<table class='barra_menu' cellpadding='1' cellspacing='1'>");
	printf ("<tr>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='bolco.php'>In&iacute;cio</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='resultados.php'>Classifica&ccedil;&atilde;o</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='regulamento.php'>Regulamento</b></td>");
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	if ($tipo != "Visitante") {
		printf("<td><a class='titulo' href='cadastro.php'>Meus Dados</a></td><td width='36' align='center'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		printf ("<td><a class='titulo' href='jogos.php?g=8'>Palpites</b></td>");
		printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		if ($tipo == "admin") {
			printf ("<td><a class='titulo' href='admin/'>Admin</b></td>");
			printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
		}
		printf ("<td width='230' align='right'><a class='titulo'>Usu&aacute;rio: </a><b class='titulo'>".$_SESSION["nome"]."</b></td>");
	}
	printf ("<td width='26'><img src='imagens/divide.jpg' width='2' height='29' border='0' alt=''></td>");
	printf ("<td><a class='titulo' href='/'>Sair</b></td>");
printf ("</tr></table>");
}


function proximos_Jogos($ng) {
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	$idusu =  $_SESSION["id"];
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT * FROM jogos inner join paises p1 on p1.idpaises = jo_time1 inner join estadio est on est.idestadio = jo_estadio inner join paises p2 on p2.idpaises = jo_time2 left outer join aposta on aposta.jo_codigo = jogos.jo_codigo and aposta.idusu = '$idusu' and aposta.ativa = 0 ";
	if ($ng != 64) {
		$q .= "where jo_hora > CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') order by jo_hora, jogos.jo_codigo limit $ng";
	} else {
		$q .= "order by jo_hora, jogos.jo_codigo";
	}
	$horario = mktime(); //date("Y-m-d H:i:s");
	$horario = $horario + 300;
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$i = 0;
	printf ("<table class='grupos' width='95%%'>");
	printf ("<thead><tr><td colspan='11'><b class='texto'>Pr&oacute;ximas Partidas</b></td></tr>");
	printf ("<tr>");
	printf ("<td width='16'>&nbsp;</td>");
	printf ("<td colspan='1'><b class='texto'>Data</b></td>");
	printf ("<td colspan='7'><b class='texto'>Jogo</b></td>");
	printf ("<td colspan='1'><b class='texto'>Local</b></td>");
	printf ("</tr></thead>");
	$num = mysql_num_rows($rs);
	while ($i < $num) {
	$j = mysql_result($rs,$i,"jo_codigo");
	printf ("<tr>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><img src='imagens/lapis.jpg' width=16 height=16></td>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'>".arrumadata(mysql_result($rs,$i,"jo_hora"))."</a></td>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p1.figura").".jpg' border='0' alt=''></a></td>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p1.Nome")))."</a></td>");
		if ( strtotime(mysql_result($rs,$i,"jo_hora")) >= $horario) {
			printf ("<td><input class='formAp'  onkeypress='return OnlyNumbers(event)'   type='text' name='p1".$i."' size='2' value='".mysql_result($rs,$i,"golp1")."'></td>");
		} else {
			printf ("<td><input class='formAp'  onkeypress='return OnlyNumbers(event)'  readonly type='text' name='p1".$i."' size='2' value='".mysql_result($rs,$i,"golp1")."'></td>");
		}
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'>X</td>");
		if ( strtotime(mysql_result($rs,$i,"jo_hora")) >= $horario) {
			printf ("<td><input  onkeypress='return OnlyNumbers(event)'  class='formAp' type='text' name='p2".$i."' size='2' value='".mysql_result($rs,$i,"golp2")."'></td>");
		} else {
			printf ("<td><input  onkeypress='return OnlyNumbers(event)'   class='formAp' readonly  type='text' name='p2".$i."' size='2' value='".mysql_result($rs,$i,"golp2")."'></td>");
		}
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p2.Nome")))."</a></td>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p2.figura").".jpg' border='0' alt=''></a></td>");
		printf ("<td onclick='irJogo(".$j.")' class='link_jogo'><a class='texto'>".mysql_result($rs,$i,"est.nome")."</a></td>");
	printf ("<input class='formAp' type='hidden' name='j".$i."' size='2' value='".mysql_result($rs,$i,"jo_codigo")."'></tr>\n");

	//echo strtotime(mysql_result($rs,$i,"jo_hora")).".";
	//echo $horario."<br>";

	$i++;
	}
	printf ("<input class='formAp' type='hidden' name='total' size='2' value='".($i-1)."'></tr>\n");
	printf ("</table>");


}


function grupos($g) {
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	$idusu =  $_SESSION["id"];
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT * FROM jogos inner join paises p1 on p1.idpaises = jo_time1 inner join estadio est on est.idestadio = jo_estadio inner join paises p2 on p2.idpaises = jo_time2 left outer join aposta on aposta.jo_codigo = jogos.jo_codigo and aposta.idusu = '$idusu' and aposta.ativa = 0 where jo_fase = '$g' order by jo_hora, jogos.jo_codigo limit 6";
	//echo $q;
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$horario = mktime(); //date("Y-m-d H:i:s");
	$horario = $horario + 300;

	$i = 0;
	printf ("<table  class='grupos'  width='95%%'>");
		printf ("<thead><tr><td colspan='9'><b class='texto'>$g</b></td></tr>");
		printf ("<tr>");
		printf ("<td colspan='1'><b class='texto'>Data</b></td>");
		printf ("<td colspan='3'><b class='texto'>Jogo</b></td>");
		printf ("<td colspan='3'><b class='texto'>Palpites</b></td>");
		printf ("<td colspan='1'><b class='texto'>Local</b></td>");
	printf ("</tr></thead>");
	$num = mysql_num_rows($rs);
	while ($i < $num) {
	printf ("<tr>");
		printf ("<td><a class='texto'>".arrumadata(mysql_result($rs,$i,"jo_hora"))."</a></td>");
		printf ("<td><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p1.figura").".jpg' border='0' alt=''></a><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p1.Nome")))."</a></td>");
		printf ("<td><a class='texto'>X</td>");
		printf ("<td><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p2.figura").".jpg' border='0' alt=''></a><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p2.Nome")))."</a></td>");
		if ( strtotime(mysql_result($rs,$i,"jo_hora")) >= $horario) {
			printf ("<td><input class='formAp'  onkeypress='return OnlyNumbers(event)'   type='text' name='p1".$i."' size='2' value='".mysql_result($rs,$i,"golp1")."'></td>");
		} else {
			printf ("<td><input class='formAp'   onkeypress='return OnlyNumbers(event)'  readonly type='text' name='p1".$i."' size='2' value='".mysql_result($rs,$i,"golp1")."'></td>");
		}
		printf ("<td><a class='texto'>X</a></td>");
		if ( strtotime(mysql_result($rs,$i,"jo_hora")) >= $horario) {
			printf ("<td><input class='formAp'   onkeypress='return OnlyNumbers(event)'   type='text' name='p2".$i."' size='2' value='".mysql_result($rs,$i,"golp2")."'></td>");
		} else {
			printf ("<td><input class='formAp'   onkeypress='return OnlyNumbers(event)'   readonly  type='text' name='p2".$i."' size='2' value='".mysql_result($rs,$i,"golp2")."'></td>");
		}
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"est.nome")."</a></td>");
	printf ("<input class='formAp' type='hidden' name='j".$i."' size='2' value='".mysql_result($rs,$i,"jo_codigo")."'></tr>\n");
	$i++;
	}
	printf ("<input class='formAp' type='hidden' name='total' size='2' value='".($i-1)."'></tr>\n");
	printf ("</table>");
}


function ClassificacaoGrupo($g) {
global $database;
	global $host;
	global $login_db;
	global $senha_db;
	$idusu =  $_SESSION["id"];
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT distinct p1.nome,p1.figura, p1.idpaises,";
	$q .= "((select sum(jo_time1_pt) from jogos j1 where j1.jo_time1 = p1.idpaises and jo_fase = '$g') + ";
	$q .= "(select sum(jo_time2_pt) from jogos j2 where j2.jo_time2 = p1.idpaises and jo_fase = '$g')) AS ponto,";
	$q .= "((select count(*) from jogos where jo_result_golp1 > jo_result_golp2 and  jo_time1 = p1.idpaises and jo_fase = '$g') +";
	$q .= "(select count(*) from jogos where jo_result_golp2 > jo_result_golp1 and  jo_time2 = p1.idpaises and jo_fase = '$g')) AS vitorias,";
	$q .= "((select count(*) from jogos where jo_result_golp1 = jo_result_golp2 and  jo_time1 = p1.idpaises and jo_fase = '$g') +";
	$q .= "(select count(*) from jogos where jo_result_golp2 = jo_result_golp1 and  jo_time2 = p1.idpaises and jo_fase = '$g')) AS empates,";
	$q .= "((select count(*) from jogos where jo_result_golp1 < jo_result_golp2 and  jo_time1 = p1.idpaises and jo_fase = '$g') +";
	$q .= "(select count(*) from jogos where jo_result_golp2 < jo_result_golp1 and  jo_time2 = p1.idpaises and jo_fase = '$g')) AS derrotas,";
	$q .= "((select sum(jo_result_golp1) from jogos where jo_time1 = p1.idpaises and jo_fase = '$g') +";
	$q .= "(select sum(jo_result_golp2) from jogos where jo_time2 = p1.idpaises and jo_fase = '$g')) AS golspro,";
	$q .= "((select sum(jo_result_golp2) from jogos where jo_time1 = p1.idpaises and jo_fase = '$g') +";
	$q .= "(select sum(jo_result_golp1) from jogos where jo_time2 = p1.idpaises and jo_fase = '$g')) AS golscontra";
	$q .= ",((select count(*) from jogos where jo_time1 = p1.idpaises and jo_result_golp1  is not null)+";
	$q .= "(select count(*) from jogos where jo_time2 = p1.idpaises and jo_result_golp2 is not null)) as jogos";
	$q .= " FROM jogos ";
	$q .= "inner join paises p1 on p1.idpaises = jo_time1 ";
	$q .= "inner join paises p2 on p2.idpaises = jo_time2 ";
	$q .= "where jo_fase ='$g' order by ponto desc";

	//echo $q;
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$i = 0;
	printf ("<table  class='grupos'  width='95%%'>");
	printf ("<thead><tr><td colspan='11'><b class='texto'>$g</b></td></tr>");
	printf ("<tr>");
	printf ("<td colspan='1'><b class='texto'></b></td>");
	printf ("<td colspan='2'><b class='texto'>Sele&ccedil;&atilde;o</b></td>");
	printf ("<td colspan='1'><b class='texto'>Pontos</b></td>");
	printf ("<td colspan='1'><b class='texto'>J</b></td>");
	printf ("<td colspan='1'><b class='texto'>V</b></td>");
	printf ("<td colspan='1'><b class='texto'>E</b></td>");
	printf ("<td colspan='1'><b class='texto'>D</b></td>");
	printf ("<td colspan='1'><b class='texto'>GP</b></td>");
	printf ("<td colspan='1'><b class='texto'>GC</b></td>");
	printf ("<td colspan='1'><b class='texto'>SG</b></td>");
	printf ("</tr></thead>");
	$num = mysql_num_rows($rs);
	while ($i < $num) {
	printf ("<tr>");
		$p = mysql_result($rs,$i,"golspro");
		$c = mysql_result($rs,$i,"golscontra");
		$s = $p - $c;
		printf ("<td><a class='texto'>".($i+1)."</a></td>");
		printf ("<td><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p1.figura").".jpg' border='0' alt=''></a></td>");
		printf ("<td><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p1.Nome")))."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"ponto")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"jogos")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"vitorias")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"empates")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"derrotas")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"golspro")."</a></td>");
		printf ("<td><a class='texto'>".mysql_result($rs,$i,"golscontra")."</a></td>");
		printf ("<td><a class='texto'>".$s."</a></td>");
	printf ("</tr>");
	$i++;
	}
	printf ("</table>");
}

function fase2() {
global $database;
	global $host;
	global $login_db;
	global $senha_db;
	$idusu =  $_SESSION["id"];
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT jogos.jo_codigo, p1.nome as p11, p1.figura as fig1, p2.figura as fig2, p2.nome as p22, jo_hora, jo_fase, golp1, golp2 FROM `jogos` ";
	$q .= " inner join paises p1 on p1.idpaises = jo_time1";
	$q .= " inner join paises p2 on p2.idpaises = jo_time2";
	$q .= "	left outer join aposta on aposta.jo_codigo = jogos.jo_codigo and aposta.idusu = '$idusu' and aposta.ativa = 0";
	$q .= " where jo_fase not like  '%grupo%' order by jogos.jo_codigo;";
	//echo $q;
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$i = 0;
	printf ("<table  class='fase2'  width='100%%' cellpadding='0' cellspacing='0'>");
	printf ("<thead><tr>");
	printf ("<td colspan='7'><b class='texto'>Segunda Fase</b></td>");
	printf ("</tr>");
	printf ("<thead><tr>");
	printf ("<td colspan='1'><b class='texto'>Oitavas de Final</b></td>");
	printf ("<td colspan='1'><b class='texto'>Quartas de Final</b></td>");
	printf ("<td colspan='1'><b class='texto'>Semi-Final</b></td>");
	printf ("<td colspan='1'><b class='texto'>Finais</b></td>");
	printf ("<td colspan='1'><b class='texto'>Semi-Final</b></td>");
	printf ("<td colspan='1'><b class='texto'>Quartas de Final</b></td>");
	printf ("<td colspan='1'><b class='texto'>Oitavas de Final</b></td>");
	printf ("</tr>");
	printf ("</thead>");
	printf ("<tr>");
	printf ("<td width='14%%'>");
	jogo_fase2(0,mysql_result($rs,0,"jo_codigo"),mysql_result($rs,0,"p11"),mysql_result($rs,0,"p22"),mysql_result($rs,0,"golp1"),mysql_result($rs,0,"golp2"),mysql_result($rs,0,"jo_hora"));
	printf ("</td>");
	printf ("<td width='14%%'></td>");
	printf ("<td width='14%%'></td>");
	printf ("<td width='14%%'></td>");
	printf ("<td width='14%%'></td>");
	printf ("<td width='14%%'></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(2,mysql_result($rs,2,"jo_codigo"),mysql_result($rs,2,"p11"),mysql_result($rs,2,"p22"),mysql_result($rs,2,"golp1"),mysql_result($rs,2,"golp2"),mysql_result($rs,2,"jo_hora"));
	printf ("</td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(9,mysql_result($rs,9,"jo_codigo"),mysql_result($rs,9,"p11"),mysql_result($rs,9,"p22"),mysql_result($rs,9,"golp1"),mysql_result($rs,9,"golp2"),mysql_result($rs,9,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(10,mysql_result($rs,10,"jo_codigo"),mysql_result($rs,10,"p11"),mysql_result($rs,10,"p22"),mysql_result($rs,10,"golp1"),mysql_result($rs,10,"golp2"),mysql_result($rs,10,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td width='14%%'>");
	jogo_fase2(1,mysql_result($rs,1,"jo_codigo"),mysql_result($rs,1,"p11"),mysql_result($rs,1,"p22"),mysql_result($rs,1,"golp1"),mysql_result($rs,1,"golp2"),mysql_result($rs,1,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(15,mysql_result($rs,15,"jo_codigo"),mysql_result($rs,15,"p11"),mysql_result($rs,15,"p22"),mysql_result($rs,15,"golp1"),mysql_result($rs,15,"golp2"),mysql_result($rs,15,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(3,mysql_result($rs,3,"jo_codigo"),mysql_result($rs,3,"p11"),mysql_result($rs,3,"p22"),mysql_result($rs,3,"golp1"),mysql_result($rs,3,"golp2"),mysql_result($rs,3,"jo_hora"));
	printf ("</td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(12,mysql_result($rs,12,"jo_codigo"),mysql_result($rs,12,"p11"),mysql_result($rs,12,"p22"),mysql_result($rs,12,"golp1"),mysql_result($rs,12,"golp2"),mysql_result($rs,12,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(13,mysql_result($rs,13,"jo_codigo"),mysql_result($rs,13,"p11"),mysql_result($rs,13,"p22"),mysql_result($rs,13,"golp1"),mysql_result($rs,13,"golp2"),mysql_result($rs,13,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td width='14%%'>");
	jogo_fase2(4,mysql_result($rs,4,"jo_codigo"),mysql_result($rs,4,"p11"),mysql_result($rs,4,"p22"),mysql_result($rs,4,"golp1"),mysql_result($rs,4,"golp2"),mysql_result($rs,4,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(14,mysql_result($rs,14,"jo_codigo"),mysql_result($rs,14,"p11"),mysql_result($rs,14,"p22"),mysql_result($rs,14,"golp1"),mysql_result($rs,14,"golp2"),mysql_result($rs,14,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(16,mysql_result($rs,6,"jo_codigo"),mysql_result($rs,6,"p11"),mysql_result($rs,6,"p22"),mysql_result($rs,6,"golp1"),mysql_result($rs,6,"golp2"),mysql_result($rs,6,"jo_hora"));
	printf ("</td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(8,mysql_result($rs,8,"jo_codigo"),mysql_result($rs,8,"p11"),mysql_result($rs,8,"p22"),mysql_result($rs,8,"golp1"),mysql_result($rs,8,"golp2"),mysql_result($rs,8,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(11,mysql_result($rs,11,"jo_codigo"),mysql_result($rs,11,"p11"),mysql_result($rs,11,"p22"),mysql_result($rs,11,"golp1"),mysql_result($rs,11,"golp2"),mysql_result($rs,11,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("</tr>");
	printf ("<tr>");
	printf ("<td width='14%%'>");
	jogo_fase2(5,mysql_result($rs,5,"jo_codigo"),mysql_result($rs,5,"p11"),mysql_result($rs,5,"p22"),mysql_result($rs,5,"golp1"),mysql_result($rs,5,"golp2"),mysql_result($rs,5,"jo_hora"));
	printf ("</td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td></td>");
	printf ("<td width='14%%'>");
	jogo_fase2(7,mysql_result($rs,7,"jo_codigo"),mysql_result($rs,7,"p11"),mysql_result($rs,7,"p22"),mysql_result($rs,7,"golp1"),mysql_result($rs,7,"golp2"),mysql_result($rs,7,"jo_hora"));
	printf ("</td>");
	printf ("</tr>");
	printf ("<input class='formAp' type='hidden' name='total' size='2' value='9'></tr>\n");
	printf ("</table>");
}


function gravaaposta(){
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	$ip = $_SERVER['REMOTE_ADDR'];
	if (($_SESSION["tipo"] == "Visitante") ||(!isset($_POST["total"])))  {
		echo "<script>window.open('/', '_self');</script>";
	}
	$idusu = $_SESSION["id"];
	foreach($_POST as $campo => $valor){
	if (($campo{0} == "p") && ($campo{1} == "1")) {
		$p1 = $valor;
	}
	if (($campo{0} == "p") && ($campo{1} == "2")) {
		$p2 = $valor;
	}
	if ($campo{0} == "j") {

	$horario = mktime();
	$horario = $horario + 300;



		$j = $valor;
		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "select jo_hora from jogos where jo_codigo = '$j'";
		$rs = mysql_query($q);
		$jh = mysql_result($rs,0,"jo_hora");

	if ( strtotime($jh) >= $horario) {

		$q ="select golp1, golp2 from aposta where jo_codigo = '$j' and idusu = '$idusu'  and ativa = 0";
		$rs = mysql_query($q);
		if (!$rs) {
			die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) >= 1){
			if (($p1 != mysql_result($rs,0,"golp1")) || ($p2 != mysql_result($rs,0,"golp2"))) {
				$rs2 = mysql_query("update aposta set ativa = 1, dataExclusao = CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'), ipExclusao = '$ip' where jo_codigo = '$j' and idusu = '$idusu' and ativa = 0");
				if (!$rs2) {
		  			die('Could not query:' . mysql_error());
				}
				$rs3 = mysql_query("insert into aposta (jo_codigo,idusu,golp1,golp2,ativa,dataCriacao,ipcriacao) values ('$j','$idusu','$p1','$p2',0,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),'$ip')");
				if (!$rs3) {
					die('Could not query:' . mysql_error());
				}
			}
		} else {
			if (($p1 != "") || ($p2 != "")) {
				$rs4 = mysql_query("insert into aposta (jo_codigo,idusu,golp1,golp2,ativa,dataCriacao,ipcriacao) values ('$j','$idusu','$p1','$p2',0,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),'$ip')");
				if (!$rs4) {
			   		die('Could not query:' . mysql_error());
				}
				}
			}
		}
	}
	}
}
	//jogo_fase2(mysql_result($rs,0,"jo_codigo"),mysql_result($rs,0,"p11"),mysql_result($rs,0,"p22"),mysql_result($rs,0,"golp1"),mysql_result($rs,0,"golp2"));

function jogo_fase2($n,$j,$r1,$r2,$a1,$a2,$jh) {
	$horario = mktime();
	$horario = $horario + 300;
	printf ("<a class='texto'>".arrumadata($jh)."</a>");
	printf ("<a class='texto'>(".$j.") - ".$r1." X ".$r2."</a>");
	if ( strtotime($jh) >= $horario) {
		printf ("<a class='texto'><input   class='formAp' type='text'  name='p1$n' size='1' value='".$a1."'  onkeypress='return OnlyNumbers(event)'  >"." X "."<input  onkeypress='return OnlyNumbers(event)' class='formAp' type='text' name='p2$n' size='1' value='".$a2."'></a>");
	} else {
		printf ("<a class='texto'><input class='formAp' type='text' readonly name='p1$n'  onkeypress='return OnlyNumbers(event)' size='1' value='".$a1."'>"." X "."<input  onkeypress='return OnlyNumbers(event)' class='formAp' type='text' readonly name='p2$n' size='1' value='".$a2."'></a>");
	}
//	printf ("<a class='texto'><input class='formAp' type='text' name='p1$n' size='1' value='".$a1."'>"." X "."<input class='formAp' type='text' name='p2$n' size='1' value='".$a2."'></a>");
	printf ("<input class='formAp' type='hidden' name='j$n' size='1' value='".$j."'>\n\n");
}


function resultados() {

	$host = "localhost";
	$database = "bolco";
	$login_db = "bolco";
	$senha_db = "girafaganso";
	global $database;
	global $host;
	global $login_db;
	global $senha_db;

	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
/*
	$q = "SELECT jo_codigo from jogos where jo_result_golp1 is not NULL order by jo_hora desc, jogos.jo_codigo desc";
	$rs = mysql_query($q);
	//echo mysql_result($rs,0,"jo_codigo");
	//echo mysql_num_rows($rs);
if(mysql_num_rows($rs) >= 1){
	$ultimoJogo = mysql_result($rs,0,"jo_codigo");
} else {
	$ultimoJogo = 0;
}
*/
//echo $ultimoJogo;
	$q = <<< EOL
SELECT r.idusu, u.apelido nome, u.quemchamou idchamador,
SUM(IF(r.Acerto='A',1,0)) a,
SUM(IF(r.Acerto='B',1,0)) b,
SUM(IF(r.Acerto='C',1,0)) c,
SUM(IF(r.Acerto='D',1,0)) d,
SUM(IF(r.Acerto='E',1,0)) e,
SUM(IF(r.Acerto='F',1,0)) f,
sum(r.pontos) pts FROM resultados r, jogos j, usuarios u
WHERE
r.idusu=u.idusu AND u.tipo not in ('Visitante','Convidado') AND u.aceitouReg = 0 AND u.ativo = 0 AND u.apelido <> '' AND
r.jo_codigo = j.jo_codigo AND
j.jo_hora < (SELECT MAX(d.jo_hora) FROM jogos d WHERE d.jo_result_golp1 is not NULL)
group by r.idusu
order by pts desc, A desc, B desc, C desc, D desc, E desc, F desc;
EOL;
/*
	$q = "SELECT u.idusu idusu, u.apelido nome, u.quemchamou idchamador";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'A' and jo_codigo <> '$ultimoJogo') as A";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'B' and jo_codigo <> '$ultimoJogo') as B";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'C' and jo_codigo <> '$ultimoJogo') as C";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'D' and jo_codigo <> '$ultimoJogo') as D";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'E' and jo_codigo <> '$ultimoJogo') as E";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'F' and jo_codigo <> '$ultimoJogo') as F";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and jo_codigo <> '$ultimoJogo')  as jogos";
	$q .= ", (select sum(pontos) from resultados r where u.idusu = r.idusu and jo_codigo <> '$ultimoJogo') as pontos";
	$q .= " from usuarios u";
    	$q .= " where u.tipo not in ('Visitante','Convidado') and u.aceitouReg = 0 and u.ativo = 0 and u.apelido <> '' ";
	$q .= " order by IF(ISNULL(pontos),1,0),pontos desc, A desc, B desc, C desc, D desc, E desc, F desc, u.apelido;";
*/
	//echo $q;

	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$numA = mysql_num_rows($rs);
	$c = 0;
	//echo $q;
	$usuarios =  array();
	$posicaoAnt =  array();
	$pos=0;
	$pontuacaoAnterior="";
	while ($c < $numA) {
		$pontuacao=mysql_result($rs,$c,"a").mysql_result($rs,$c,"b").mysql_result($rs,$c,"c").mysql_result($rs,$c,"d").mysql_result($rs,$c,"e").mysql_result($rs,$c,"f");
		$usuarios[$c] = mysql_result($rs,$c,"idusu");
		$pos++;
		if ($pontuacao!=$pontuacaoAnterior) {
			$posAnt=$pos;
			$pontuacaoAnterior=$pontuacao;
		}
		$posicaoAnt[$c] = $posAnt;
		//echo 	mysql_result($rs,$c,"nome")." - ".$posicaoAnt[$c]." - ".mysql_result($rs,$c,"pontos")."<br>";
		if (mysql_result($rs,$c,"idusu")==$_SESSION["id"]) {
			$idChamador=mysql_result($rs,$c,"idchamador");
		}
	    $c++;
	}

	$USUSEM="select distinct(u.idusu),u.apelido, u.email from usuarios u left join aposta a on u.idusu=a.idusu and jo_codigo=49 where ativo=0 and apelido <>'' and idaposta is null and apelido <> 'visitante';";

    global $db;
	$idusu =  $_SESSION["id"];
/*
	$q = <<< EOL
SELECT u.idusu idusu, u.apelido apelido, u.nome nome, c.apelido chamador, u.pago pago, u.quemchamou idchamador, u.tipo tipo
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'A') as A
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'B') as B
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'C') as C
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'D') as D
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'E') as E
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'F') as F
, (select count(*) from resultados r where u.idusu = r.idusu) as jogos
, (select sum(pontos) from resultados r where u.idusu = r.idusu) as pontos
from usuarios u
left join usuarios c on u.quemchamou = c.idusu and u.tipo='usuario'
where u.tipo not in ('Visitante','Convidado') and u.aceitouReg = 0 and u.ativo = 0 and u.apelido <> ''
order by IF(ISNULL(pontos),1,0),pontos desc, A desc, B desc, C desc, D desc, E desc, F desc, u.apelido;
EOL;
*/
	$q = <<< EOL
SELECT u.idusu, u.apelido apelido, u.quemchamou idchamador, c.apelido chamador, u.pago pago, u.tipo tipo, u.aceitouReg Reg,
SUM(IF(r.Acerto='A',1,0)) a,
SUM(IF(r.Acerto='B',1,0)) b,
SUM(IF(r.Acerto='C',1,0)) c,
SUM(IF(r.Acerto='D',1,0)) d,
SUM(IF(r.Acerto='E',1,0)) e,
SUM(IF(r.Acerto='F',1,0)) f,
COUNT(r.idusu) jogos,
SUM(r.pontos) pontos
FROM
usuarios u
left join resultados r on r.idusu=u.idusu
left join jogos j on r.jo_codigo = j.jo_codigo
left join usuarios c on u.quemchamou = c.idusu and u.tipo='usuario'
WHERE
u.tipo not in ('Visitante','Convidado')
AND u.ativo = 0 AND u.apelido <> ''
group by u.idusu
order by pontos desc, A desc, B desc, C desc, D desc, E desc, F desc,u.apelido asc;
EOL;

	$res =& $db->query($q);
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	}
	$i = 0;
	//$msg = $ultimoJogo."<br>";
	printf ("<table  class='grupos'  width='95%%'>");
	printf ("<thead><tr><td colspan='14'><b class='texto'>Classifica&ccedil;&atilde;o Geral</b></td></tr>");
	printf ("<tr>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>Pos.</b></td>");
	printf ("<td nowrap colspan='1' width='28%%'><b class='texto'>Bolcó</b></td>");
	printf ("<td nowrap colspan='1' width='10%%'><b class='texto'>Boc-mor</b></td>");
	printf ("<td nowrap colspan='1' width='10%%'><b class='texto'>Reg*</b></td>");
	printf ("<td nowrap colspan='1' width='5%%'><b class='texto'>Pago</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>A</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>B</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>C</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>D</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>E</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>F</b></td>");
	printf ("<td nowrap colspan='1' width='8%%'><b class='texto'>Jogos</b></td>");
	printf ("<td nowrap colspan='1' width='8%%'><b class='texto'>Pontos</b></td>");
	printf ("<td nowrap colspan='1' width='5%%'><b class='texto'>-</b></td>");
	printf ("</tr></thead>");

	$pos=0;
	$posAnt='';
	$pontuacaoAnterior="";
	while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		$pontuacao=$row["a"].$row["b"].$row["c"].$row["d"].$row["e"].$row["f"];
		$pos++;
		if ($pontuacao!=$pontuacaoAnterior) {
			$posAnt=$pos;
			$pontuacaoAnterior=$pontuacao;
		}
		$posicaoExibir = ($posAnt==$pos)?$pos:"";
		$classeLinha = "";
		if ($row["idusu"]==$_SESSION["id"]) {
			$classeLinha = "meuResultado";
		} elseif(($_SESSION["tipo"]=='notorio')||($_SESSION["tipo"]=='admin')) {
			if (($row["idchamador"]==$_SESSION["id"])&&($row["tipo"]=='usuario')) {
				$classeLinha = "amigoResultado";
			} elseif (($row["tipo"]=='notorio')||($row["tipo"]=='admin')) {
				$classeLinha = "notorio";
			}
		} elseif(($_SESSION["tipo"]=='usuario')&&($row["idusu"]==$idChamador)) {
			$classeLinha = "amigoResultado";
	    } elseif($row["tipo"]=='usuario') {
			if ($row["idchamador"]==$idChamador) {
				$classeLinha = "amigoResultado";
			}

		}
		printf ("<tr class='".$classeLinha."'>");
		printf ("<td class='texto'>".$posicaoExibir."</td>");
		$CARTAO_AMARELO='';
		//if ($row["idusu"] == "206") {
		//	$CARTAO_AMARELO = " &nbsp; <img src='imagens/cartaoAmarelo.png' border='0' width=6 height=10 alt='C.A.' title='Cartao Amarelo' style='display:inline'>";
		//}
		printf ("<td onclick='irresultado(".$row["idusu"].")' class='link_jogo' nowrap><b><a class='texto' href='mresultados.php?us=".$row["idusu"]."'>".$row["apelido"].$CARTAO_AMARELO."</a></b></td>");
		printf ("<td><a class='texto'>".$row["chamador"]."</a></td>");
		

			printf ("<td><a class='texto' style='color:#C20000'>".$row["Reg"]."N&atilde;o</a></td>");
	
		if (intval($row["pago"]) > 0) {
			printf ("<td><a class='texto'>Sim</a></td>");
		} else {
			printf ("<td><a class='texto' style='color:#C20000'>N&atilde;o</a></td>");
		}
		if ($row["jogos"] > 0) {
			$Media = ($row["pontos"] / $row["jogos"]);
		} else {
			$Media = "";
		}
		printf ("<td><a class='texto'>".$row["a"]."</a></td>");
		printf ("<td><a class='texto'>".$row["b"]."</a></td>");
		printf ("<td><a class='texto'>".$row["c"]."</a></td>");
		printf ("<td><a class='texto'>".$row["d"]."</a></td>");
		printf ("<td><a class='texto'>".$row["e"]."</a></td>");
		printf ("<td><a class='texto'>".$row["f"]."</a></td>");
		printf ("<td><a class='texto'>".$row["jogos"]."</a></td>");
		printf ("<td><a class='texto'>".$row["pontos"]."</a></td>");
		//comparando posicao anterior
//		$row["idusu"]
		$cont = 0;

		if ($c == 0) {
			printf ("<td nowrap><a class='texto'><img src='imagens/grp_nul.gif' width='11' height='13' border='0'' alt=''></a></td>");

		}	else {

		for ($cont = 0; $cont < $c; $cont++) {
				if ($row["idusu"] == $usuarios[$cont]) {
					if ($posAnt < $posicaoAnt[$cont]) {
						printf ("<td nowrap><a class='texto'><img src='imagens/grp_up.gif' width='11' height='13' border='0'' alt=''>+".($posicaoAnt[$cont]-$posAnt)."</a></td>");
					} elseif ($posAnt > $posicaoAnt[$cont]) {
						printf ("<td nowrap><a class='texto'><img src='imagens/grp_down.gif' width='11' height='13' border='0'' alt=''>-".($posAnt-$posicaoAnt[$cont])."</a></td>");
					}	else {
					printf ("<td nowrap><a class='texto'><img src='imagens/grp_nul.gif' width='11' height='13' border='0'' alt=''></a></td>");
					}

				}
    		}

		}
	printf ("</tr>");
	$i++;
	}
	printf ("</table>");
	//printf ($msg);

}

function mresultados($g) {
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	if ($g != 0) {
		$idusu = $g;
	} else {
		$idusu =  $_SESSION["id"];
	}
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT apelido, mostrapalpite from usuarios where idusu = '$idusu' ";
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$Apelido = mysql_result($rs,0,"apelido");
	$mostrapalpite = mysql_result($rs,0,"mostrapalpite");
	$q = "SELECT jogos.jo_codigo, p1.nome, p1.figura, p2.figura, p2.nome, jo_hora, jo_fase, golp1, golp2, Acerto, jo_result_golp1, jo_result_golp2, pontos, colocacao FROM `jogos` ";
	$q .= " inner join paises p1 on p1.idpaises = jo_time1";
	$q .= " inner join paises p2 on p2.idpaises = jo_time2";
	$q .= "	left outer join aposta on aposta.jo_codigo = jogos.jo_codigo and aposta.idusu = '$idusu' and aposta.ativa = 0";
	$q .= "	left outer join resultados on resultados.idusu = aposta.idusu and resultados.jo_codigo = jogos.jo_codigo";
	$q .= " order by jogos.jo_hora, jogos.jo_codigo";
	//echo $q;
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$horario = mktime(); //date("Y-m-d H:i:s");
	$i = 0;
	printf ("<table  class='grupos'  width='95%%'>");
		printf ("<thead><tr><td colspan='16'><b class='texto'>Resultados Inidividuais - Usu&aacute;rio: $Apelido </b></td></tr>");
		printf ("<tr>");
		printf ("<td colspan='1'><b class='texto'>Data</b></td>");
		printf ("<td colspan='5'><b class='texto'>Jogo</b></td>");
		printf ("<td colspan='3'><b class='texto'>Seu Palpite</b></td>");
		printf ("<td colspan='3'><b class='texto'>Resultado</b></td>");
		printf ("<td colspan='1'><b class='texto'>Acerto</b></td>");
		printf ("<td colspan='1'><b class='texto'>Pontos</b></td>");
		printf ("<td colspan='1'><b class='texto'>Pos.</b></td>");
		printf ("<td colspan='1'><b class='texto'>Var.</b></td>");
	printf ("</tr></thead>");
	$num = mysql_num_rows($rs);
	$posAnt=0;
	$vari="";
	while ($i < $num) {
	printf ("<tr>");
		printf ("<td height='20' valign='middle'><a class='texto'>".arrumadata(mysql_result($rs,$i,"jo_hora"))."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p1.figura").".jpg' border='0' alt=''></a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p1.Nome")))."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>X</td>");
		printf ("<td height='20' valign='middle'><a class='texto'>".htmlentities(utf8_encode(mysql_result($rs,$i,"p2.Nome")))."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'><img src='imagens/paises/".mysql_result($rs,$i,"p2.figura").".jpg' border='0' alt=''></a></td>");

		if (($idusu == $_SESSION["id"]) || ($mostrapalpite == 0) || (strtotime(mysql_result($rs,$i,"jo_hora")) < $horario)){
			printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"golp1")."</a></td>");
			printf ("<td height='20' valign='middle'><a class='texto'>X</a></td>");
			printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"golp2")."</a></td>");
		} else {
			printf ("<td height='20' valign='middle'><a class='texto'><img src='imagens/paises/AAA.gif' border='0' alt=''></a></td>");
			printf ("<td height='20' valign='middle'><a class='texto'>X</a></td>");
			printf ("<td height='20' valign='middle'><a class='texto'><img src='imagens/paises/AAA.gif' border='0' alt=''></a></td>");
		}
		printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"jo_result_golp1")."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>X</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"jo_result_golp2")."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"Acerto")."</a></td>");
		printf ("<td height='20' valign='middle'><a class='texto'>".mysql_result($rs,$i,"Pontos")."</a></td>");
		$posNova = mysql_result($rs,$i,"colocacao");
		if (($posNova > 0) && ($posAnt > 0)) {
		  $pos=$posNova;
		  $vari = $posAnt - $posNova;
		  if ($vari>0) {
			  $vari = "<img src='imagens/grp_up.gif' width='11' height='13' border='0'' alt=''>+".$vari;
		  } elseif ($vari<0) {
			  $vari = "<img src='imagens/grp_down.gif' width='11' height='13' border='0'' alt=''>".$vari;
		  } else {
			  $vari = "<img src='imagens/grp_nul.gif' width='11' height='13' border='0'' alt=''>";
		  }
		  $posAnt=$posNova;
		} elseif($posNova=="") {
			$vari="";
			$pos="";
		} elseif($posNova>0) {
			$posAnt=$posNova;
			$pos=$posNova;
		}

		printf ("<td height='20' valign='middle'><a class='texto'>".$vari."</a></td>");

	$i++;
	}
	printf ("</table>");
}

function Valores() {
	global $database;
	global $host;
	global $login_db;
	global $senha_db;
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT count(*) from usuarios where pago > 0 and ativo = 0 and aceitouReg = 0";
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$Total = mysql_result($rs,0,0);
	$Total = $Total * 20;

	printf ("<a class='texto'>At&eacute; momento foi arrecadado o total de </a><b class='texto'>R$ ".CvPV($Total)."</b><br>");
	printf ("<a class='texto'>O primeiro colocado receber&aacute;: </a><b class='texto'>R$ ".CvPV($Total*0.6)."</b><br>");
	printf ("<a class='texto'>O Segundo colocado receber&aacute;: </a><b class='texto'>R$ ".CvPV($Total*0.3)."</b><br>");
	printf ("<a class='texto'>O Terceiro colocado receber&aacute;: </a><b class='texto'>R$ ".CvPV($Total*0.1)."</b><br>");
}


function CvPV($valor) {
 $saida = "";
 $lpt = 0;
 //echo "(Debug<1>:".strlen($valor).")";
 if (strlen($valor) > 0) {
  $lpt = strlen($valor);
  for ($ct=0;$ct<strlen($valor)&&$ct<$lpt+3;$ct++) {
   $alg = substr($valor,$ct,1);
   //echo "(Debug<2>:".$alg.")";
   switch($alg) {
   case ',': break;
   case '.': $saida=$saida.',';$lpt=$ct;break;
   default : $saida=$saida.$alg;
   }
   //echo "(Debug<3>:".$saida.")<BR>";
  }
  if ($lpt>3) {
    $saida=substr($saida,0,$lpt-3).".".substr($saida,$lpt-3,strlen($valor));
    if ($lpt>6) {
      $saida=substr($saida,0,$lpt-6).".".substr($saida,$lpt-6,strlen($valor));
    }
  }
  if ($lpt==strlen($valor)) {
   $saida=$saida.",00";
  }
  if ($lpt==strlen($valor)-2) {
   $saida=$saida."0";
  }
 }
 return $saida;
}

function CvVP($valor) {
 $saida = "";
 $ult=100;
 if (strlen($valor) > 0) {
  for ($ct=0;$ct<strlen($valor)&&$ct<$ult;$ct++) {
   $alg = substr($valor,$ct,1);
   //echo "(Debug<2>:".$alg.")";
   switch(ord($alg)) {
   case 44: $saida=$saida.".";$ult=$ct+3; break;
   case 46: break;
   default : $saida=$saida.$alg;
   }
  }
  //echo "[Debug<1>: funcao CvVP ($valor)->($saida)]";
 }
 return $saida;
}


function arrumadata($horario) {
$month = substr($horario,5,2);
$date = substr($horario,8,2);
$year = substr($horario,0,4);
$hour = substr($horario,11,2);
$minutes = substr($horario,14,2);
$seconds = substr($horario,17,4);
return $date."/".$month."/".$year." ".$hour.":".$minutes;
}


?>
