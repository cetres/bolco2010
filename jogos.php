<?php
require_once("protecao.php");
if ($_SESSION["tipo"] == "Visitante")  {
  echo "<html><head><script type='text/javascript'>window.open('/', '_self');</script></head></html>";
  exit();
}
if(!isset($_GET['g']))  {
	$ng = 64; 
} else {
	$ng = $_GET['g'];
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>
        Jogos - BolC&oacute; 2014
    </title>
<SCRIPT LANGUAGE="JavaScript1.2" SRC="bolco.js" TYPE='text/javascript'></SCRIPT>
<script> 
function Validaform() { 
	with (document.FormComent)	{ 
		if (nome.value=="") { alert("Preencha o campo Nome!"); return false; } 
		if (email.value=="") { alert("Preencha o campo email!"); return false; } 
		if (Apelido.value=="") { alert("Preencha o campo Apelido!"); return false; } 
		if (senha.value=="") { alert("Preencha o campo Senha!"); return false; } 
		if (confirma.value=="") { alert("Preencha o campo Confirma Senha!"); return false; } 
		if (senha.value!=confirma.value) { alert("O campo Senha tem que ser igual ao campo Cofirma Senha!"); return false; } 
	} 
}
</script> 
<link rel="STYLESHEET" type="text/css" href="bolco.css">
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
   <div align="center">
<table cellpadding="0" cellspacing="0" border="0" bordercolor="#ffffff" height="100%">
   <tr>
   	<td background="imagens/lado_esq.jpg" width="17"></td>
   	<td width="800" valign="top">
<?php menu();?>
   </td></tr>
   <tr><td width="800" valign="top" >
<table cellpadding="5" cellspacing="5" border="0" bordercolor="#ffffff">
   <tr>
   	<td width="100%" valign="top" align="left">
<b class="tit">Jogos e Apostas</b><br><br> 
<a class="texto">
<strong>Wikip&eacute;dia:</strong> Bol&atilde;o &eacute; uma modalidade de aposta, inoficiosa na maioria dos casos, que pode ocorrer de duas formas - numa, v&aacute;rios apostadores se juntam para adquirir uma s&eacute;rie de cart&otilde;es de apostas, aumentando assim a probabilidade de acertos, e com posterior rateamento dos pr&ecirc;mios; e a variante popular, que &eacute; a de apostar no resultado de um evento futuro, em geral esportivo como os gols de uma partida de futebol.
</a>
<br><br>
<b class="tit">Pr&oacute;ximos Jogos</b><br>
<p class="texto">
Para maiores detalhes sobre um jogo como por exemplo as apostas de outros jogadores ou a cota&ccedil;&atilde;o do favorito da partida, clique no bot&atilde;o azul referente ao jogo desejado.</p>

<table width="100%" >
<?php if ($_SESSION["Aceitou"] == "0") { ?>

				<?php if ($ng == 8) { ?>
<form name="FormComent"  action="apostas.php?p=p" method="Post"  onSubmit="return Validaform()" >
				<?php } else {  ?>
<form name="FormComent"  action="apostas.php?p=t" method="Post"  onSubmit="return Validaform()" >
				<?php } ?>

<tr>
	<td align="center"  valign="top">
		<?php
		proximos_Jogos($ng); ?>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		<input type="submit" value="Enviar Palpites" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"><br></form>
	</td>
</tr>

<tr>
	<td align="center"  valign="top">
		
		<table width="100%">
			<tr>
				<?php if ($ng == 8) { ?>
				<td align="center"  valign="top"><a href="jogos.php" class="texto"><img src="imagens/todos.gif" width="30" height="43" border="0" alt=""></a><br><a href="jogos.php" class="texto">Todos os Jogos</a></td>
				<?php } else {  ?>
				<td align="center"  valign="top"><a href="jogos.php?g=8" class="texto"><img src="imagens/prox.gif" width="30" height="22" border="0" alt=""></a><br><a href="jogos.php?g=8" class="texto">Pr&oacute;ximos os Jogos</a></td>
				<?php } ?>
				<td align="center"  valign="top"><a href="grupos.php?g=A" class="texto"><img src="imagens/grupos.gif" width="50" height="23" border="0" alt=""></a><br><a href="grupos.php?g=A" class="texto">Fase de Grupos</a></td>
				<td align="center"  valign="top"><a href="fase2.php" class="texto"><img src="imagens/2fase.gif" width="60" height="45" border="0" alt=""></a><br><a href="fase2.php" class="texto">Segunda Fase</a></td>
			</tr>
			
	
			
		</table>
	</td>
</tr>
<?php } else { ?>
<tr>
	<td align="center"  valign="top">
		<a class="texto"&gt;Voc&ecirc; deve aceitar o regulamento para poder apostar!!</a><br>
		<a class="texto">Acesse <strong>"Regulamento"</strong> leia o conte&uacute;do e em seguida acesse <strong>"Meus dados"</strong> para aceita&ccedil;&atilde;o. </a><br>
	</td>
</tr>
<?php } 
//echo $_SESSION["Aceitou"] ;?>
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
<?php include("analytics.inc"); ?>
   </body>
</html>
