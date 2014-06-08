<?php
require_once("protecao.php");
if ($_SESSION["tipo"] == "Visitante")  {
	if (isset($_REQUEST["p1"]) && isset($_REQUEST["p2"])) {
		die("Erro - Sessão finalizada");
	}
  echo "<html><head><script type='text/javascript'>window.open('/', '_self');</script></head></html>";
  exit();
}
if (!isset($_REQUEST["j"])) {
  die("Operacao invalida");
}
$j = intval($_REQUEST["j"]);
if (isset($_REQUEST["p1"]) && isset($_REQUEST["p2"])) {
  $q = "SELECT jo_codigo FROM jogos WHERE SUBDATE(jo_hora, INTERVAL 5 minute) > CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') and jo_codigo=?";
  $res = $db->query($q,$j);
  if ($res->numRows() == 1) {
  	$p1=intval($_REQUEST["p1"]);
  	$p2=intval($_REQUEST["p2"]);
  	$ip=$_SERVER["REMOTE_ADDR"];
  	$q = "update aposta set ativa = 1, dataExclusao = CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'), ipExclusao = ? WHERE jo_codigo = ? and idusu = ? and ativa = 0";
  	$res = $db->query($q,array($ip,$j,$_SESSION["id"]));
  	if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
		die("Erro ao enviar o seu palpite. Tente novamente mais tarde...");
  	}
  	$q = "insert into aposta (jo_codigo,idusu,golp1,golp2,ativa,dataCriacao,ipcriacao) values (?,?,?,?,0,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),?)";
  	$res = $db->query($q,array($j,$_SESSION["id"],$p1,$p2,$ip));
  	if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
		die("Erro ao enviar o seu palpite. Tente novamente mais tarde...");
  	}
  	echo "Seu palpite foi atualizado com sucesso";
  	exit();
  } else {
	  die("Erro - Apostas sao encerradas 5 min antes do inicio da partida");
  }
}

$q = <<< EOL
SELECT p1.nome pn1, p1.figura pi1, p2.nome pn2, p2.figura pi2, j.jo_hora hora, e.nome estadio,
       j.jo_result_golp1 re1, j.jo_result_golp2 re2, a.golp1 ap1, a.golp2 ap2, b.bw_time1 bw1,
       b.bw_time2 bw2, b.bw_empate bwe, j.jo_fase fase, b.bw_data atualizacao
FROM jogos j
  LEFT JOIN paises p1 ON p1.idpaises = j.jo_time1
  LEFT JOIN paises p2 ON p2.idpaises = j.jo_time2
  LEFT JOIN aposta a ON a.jo_codigo = j.jo_codigo AND a.idusu=? AND a.ativa = 0
  LEFT JOIN estadio e ON e.idestadio = j.jo_estadio
  LEFT JOIN bwin b ON b.bw_jogo = j.jo_codigo AND b.bw_data = (SELECT MAX(ba.bw_data) FROM bwin ba WHERE ba.bw_jogo = j.jo_codigo)
WHERE j.jo_codigo=?
EOL;
$res =& $db->getAll($q,array($_SESSION['id'],$j),DB_FETCHMODE_ASSOC);
if (PEAR::isError($res)) {
	error_log($res->getMessage()." / ".$res->getDebugInfo());
	die($res->getMessage());
}
$r = $res[0];

for ($ct=-5;$ct<=5;$ct++) {
  $SAL[$ct]=0;
}
$JOG=array();

$q = <<< EOL
select a.golp1 ap1,a.golp2 ap2,a.idusu idusu,u.apelido apelido, u.mostrapalpite mostra,
  if(CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00')>SUBDATE(jo_hora, INTERVAL 5 minute),1,0) jafoi from aposta a, usuarios u, jogos j
WHERE a.idusu=u.idusu AND a.jo_codigo = j.jo_codigo AND a.ativa = 0 AND a.jo_codigo=? ORDER BY u.apelido;
EOL;
$res =& $db->query($q,array($j));
while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
  if (($row["idusu"] != $_SESSION['id']) && (($row["mostra"]==0)||$row["jafoi"]==1)) {
    $JOG[htmlentities($row["apelido"])] = array($row["idusu"],$row["ap1"],$row["ap2"]);
  }
  $s = $row["ap2"]-$row["ap1"];
  if (abs($s)<6) {
  	$SAL[$s]++;
  }
  $jafoi=$row["jafoi"];
}

$chd=implode(",",array_values($SAL));
rsort($SAL);
$max=$SAL[0]+2;

	$idusu =  $_SESSION["id"];
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "SELECT * FROM jogos inner join $database.paises p1 on p1.idpaises = jo_time1 inner join $database.estadio est on est.idestadio = jo_estadio inner join $database.paises p2 on p2.idpaises = jo_time2 left outer join aposta on aposta.jo_codigo = jogos.jo_codigo and aposta.ativa = 0 ";
	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$num = mysql_num_rows($rs);

$idx = array_search($j, $ordem_jogos);
$jogoAnt = ($idx > 1)?$ordem_jogos[$idx-1]:0;
$jogoPos = ($idx < 63)?$ordem_jogos[$idx+1]:0;

//$q="select jo_codigo from jogos where jo_hora < CONVERT(?,DATETIME) order by jo_hora desc limit 1";
//$q="select jo_codigo from jogos where jo_hora > CONVERT(?,DATETIME) order by jo_hora limit 1";
//$jogoPos =& $db->getOne($q,$r['hora']);

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>Jogo - BolC&oacute; 2014</title>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" language="Javascript">
var jid=<?php echo $j ?>;
var ap1=<?php echo ($r['ap1']=="")?"null":$r['ap1']; ?>;
var ap2=<?php echo ($r['ap2']=="")?"null":$r['ap2']; ?>;
</script>
<SCRIPT LANGUAGE="JavaScript1.2" SRC="bolco.js" TYPE='text/javascript'></SCRIPT>
<link rel="stylesheet" type="text/css" href="bolco.css" />
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
<div align="center">
<table cellpadding="0" cellspacing="0" border="0" bordercolor="#ffffff" height="100%" id="panorama">
   <tr>
   	<td background="imagens/lado_esq.jpg" width="17"></td>
   	<td width="800" valign="top">
<?php menu();?>
   </td></tr>
   <tr><td width="800" valign="top" >
<table cellpadding="5" cellspacing="5" border="0" bordercolor="#ffffff">
   <tr>
   	<td width="100%" valign="top" align="left" >
<b class="tit">
<?php echo $r['fase'] ?>: <?php echo htmlentities($r['pn1']) ?> X <?php echo  htmlentities($r['pn2']) ?> - <?php echo arrumadata($r['hora']) ?>
</b>

<table width="750" id="panorama">
<tr>
	<td width="33%"><?php if ($jogoAnt) { echo "<a href=\"jogo.php?j=".($jogoAnt)."\">&lt; &lt; Jogo Anterior</a>";} ?></td>
	<td colspan='3'></td>
	<td width="33%"><?php if ($jogoPos) { echo "<a href=\"jogo.php?j=".($jogoPos)."\">Jogo Posterior &gt; &gt;</a>";} ?></td>
</tr>


<tr>
	<td class="resultado" width="33%"><?php echo $r['re1'] ?></td>
	<td colspan='3' height="75"><img src="http://chart.apis.google.com/chart?cht=bvg&chbh=9,1&chxl=0:|5|4|3|2|1|0|1|2|3|4|5&chs=210x200&chd=t:<?php echo $chd?>&chxt=x,y&chco=4D89F9&chxs=0,2222ff,10,0,lt|1,3333ff,10,1,lt&chds=0,<?php echo $max?>" width="210" height="200" title="Saldo de gols dos palpites" /></td>
	<td class="resultado" width="33%"><?php echo $r['re2'] ?></td>
</tr>
</table>

<table width="750" class="grupos">
<thead>
<tr >
	<td colspan='5'><b class="tit">JOGO</td>
</tr>
</thead>
<tr>
	<td height="20" class="nTime" width="33%"><b class="texto"><?php echo htmlentities(utf8_encode($r['pn1'])) ?></td>
	<td height="20" width="11%" ><img src="/imagens/paises/<?php echo $r['pi1'] ?>.jpg" width="29" height="20" /></td>
	<td height="20" width="11%" class="nTime"><b class="texto">X</td>
	<td height="20" width="11%" ><img src="/imagens/paises/<?php echo $r['pi2'] ?>.jpg" width="29" height="20" /></td>
	<td height="20" width="33%" class="nTime"><b class="texto"><?php echo htmlentities(utf8_encode($r['pn2'])) ?></td>
</tr>
<tr class="linha_palpite">
	<td><input type="text" name="p1" id="ap1" maxlength="2" size="2" value="<?php echo $r['ap1']?>" class="palpite" <?php echo ($jafoi==1)?"disabled":"";?> /></td>
	<td colspan='3' id="comando_palpite"><b class="texto">Seu palpite</td>
	<td><input type="text" name="p2" id="ap2" maxlength="2" size="2" value="<?php echo $r['ap2']?>" class="palpite" <?php echo ($jafoi==1)?"disabled":"";?> /></td>
</tr>
</table><br>

<table width="750" class="grupos">
<thead>
<tr >
	<td colspan='5'><b class="tit">BOLSA DE APOSTAS <span style="font-size:9px;font-style:italic">(&Uacute;ltima atualiza&ccedil;&atilde;o: <?php echo substr(arrumaData($r['atualizacao']),0,10) ?>)</span></td>
</tr>
</thead>
<tr class="ajuda">
	<td><b class="texto"><?php echo CvPV($r['bw1'])?></td>
	<td colspan='3'><b class="texto"><?php echo CvPV($r['bwe'])?></td>
	<td><b class="texto"><?php echo CvPV($r['bw2'])?></td>
</tr>
<tr class="ajuda">
	<td><b class="texto"><?php echo @CvPV(100/$r['bw1'])?>%</td>
	<td colspan='3'><b class="texto"><?php echo @CvPV(100/$r['bwe'])?>%</td>
	<td><b class="texto"><?php echo @CvPV(100/$r['bw2'])?>%</td>
</tr>
</table><br>

<table width="750" class="grupos">

<thead>
<tr>
	<td colspan='5'><b class="tit">OUTROS PALPITES NO BOLC&Oacute;</td>
</tr>
</thead>
<?php foreach ($JOG as $apelido => $valores ) { ?>

<tr class="jogadas">
	<td class="<?php echo ($valores[1]>$valores[2])?"ganha":"" ?>"><b class="texto"><?php echo $valores[1] ?></td>
	<td colspan='3'><a href="mresultados.php?us=<?php echo $valores[0] ?>"><?php echo $apelido?></a></td>
	<td class="<?php echo ($valores[2]>$valores[1])?"ganha":"" ?>"><b class="texto"><?php echo $valores[2] ?></td>
</tr>
<?php } ?>
</table>
	</td>
</tr>

<tr>
	<td align="center"  valign="top">

		<table width="100%">
			<tr>
				<td align="center"  valign="top"><a href="jogos.php" class="texto"><img src="imagens/todos.gif" width="30" height="43" border="0" alt=""></a><br><a href="jogos.php" class="texto">Todos os Jogos</a></td>
				<td align="center"  valign="top"><a href="jogos.php?g=8" class="texto"><img src="imagens/prox.gif" width="30" height="22" border="0" alt=""></a><br><a href="jogos.php?g=8" class="texto">Pr&oacute;ximos os Jogos</a></td>
				<td align="center"  valign="top"><a href="grupos.php?g=A" class="texto"><img src="imagens/grupos.gif" width="50" height="23" border="0" alt=""></a><br><a href="grupos.php?g=A" class="texto">Fase de Grupos</a></td>
				<td align="center"  valign="top"><a href="fase2.php" class="texto"><img src="imagens/2fase.gif" width="60" height="45" border="0" alt=""></a><br><a href="fase2.php" class="texto">Segunda Fase</a></td>
			</tr>
		</table>
	</td>
</tr>
	</table>
   </td></tr>
   <tr><td><br><div align="center" class="divRodape">2002 &copy; <a href="http://www.apto101.com.br/">Apartamento 101</a></div><br></td></tr>
</table>

  </td><td background="imagens/lado_dir.jpg" width="12"> </td>
   </tr>
   </table>
</td>
</tr>
</table>
</div>
<script type="text/javascript" language="Javascript">

function enviar() {
  if (($('#ap1').val() == "") || ($('#ap2').val() == "")) {
    alert("Aposta invalida");
	return;
  }
  $.get(
    "jogo.php",
	{j: jid, p1: $('#ap1').val(), p2: $('#ap2').val()},
    function(data){
	    if (data.substr(0,4) != "Erro") {
		 ap1=$('#ap1').val();
		 ap2=$('#ap2').val();
		 $('#comando_palpite').html("Seu palpite");
		 $('.linha_palpite').css('background-color', '#5A8BCE');
		  alert(data);
		} else {
          $('#comando_palpite').html("<input type='button' value='Clique aqui para atualizar' onclick='enviar()' />");
		  alert(data);
		}
    }
  );
  $('#comando_palpite').html("Aguarde um momento...<img src='imagens/loader1.gif' width=16 height=16 />");
}

$('.palpite').change(function() {
  if (($('#ap1').val()!=ap1) || ($('#ap2').val()!=ap2)) {
    $('#comando_palpite').html("<input type='button' value='Clique aqui para atualizar' onclick='enviar()' />");
	$('.linha_palpite').css('background-color', '#C20000');
  } else {
    $('#comando_palpite').html("Seu palpite");
	$('.linha_palpite').css('background-color', '#5A8BCE');
  }
  return true;

});
</script>
<?php include("analytics.inc"); ?>
   </body>
</html>
