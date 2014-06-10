<?php
require_once("protecao.php");
if(!isset($_GET['g']))  {
	$ng = 64;
} else {
	$ng = $_GET['g'];
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>
        Resultados - BolC&oacute; 2014
    </title>
<style>
BODY {
scrollbar-3d-light-color:#C7AE52;
scrollbar-arrow-color:#34317D;
scrollbar-base-color:#ffffff;
scrollbar-dark-shadow-color:#34317D;
scrollbar-face-color:#EFEFEF;
scrollbar-highlight-color:#D6D7D6;
scrollbar-shadow-color:#D6D7D6}
</style>
<link rel="STYLESHEET" type="text/css" href="bolco.css" />
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" ><div align="center">
<table cellpadding="0" cellspacing="0" border="0" bordercolor="#ffffff" height="100%">
   <tr>
   	<td background="imagens/lado_esq.jpg" width="17"></td>
   	<td width="800" valign="top">
<?php menu();?>

   </td></tr>
   <tr><td width="800" valign="top" >

<table cellpadding="5" cellspacing="5" border="0" bordercolor="#ffffff">
   <tr>
   	<td width="100%" valign="top" align="left" >
<b class="tit">Pontua&ccedil;&atilde;o e resultados dos Jogos</b><br><br>
<table width="100%" >

<!-- Por que diabo voce esta vendo esse codigo??? -->

<tr>
	<td align="center"  valign="top">
		<?php 	resultados(); ?>
	</td>
</tr>

<tr>
	<td align="left"  width="750"  valign="top">
<span class="texto">
<b>Se você pagou e seu nome não está na lista abaixo verifique se você aceitou o regulamento do BOLCÓ. Maiores informa&ccedil;&otilde;es veja o regulamento.</b><br><br>
Legenda da Tabela:
<li>A - Placar Correto; </li>
<li>B - Acerto em empate com n&uacute;mero de gols incorreto; </li>
<li>C - Indica&ccedil;&atilde;o correta do vencedor e acerto do n&uacute;mero de gols do vencedor; </li>
<li>D - Indica&ccedil;&atilde;o correta do vencedor e acerto do n&uacute;mero de gols do perdedor; </li>
<li>E - Indica&ccedil;&atilde;o correta do vencedor e acerto do saldo de gols do jogo; e </li>
<li>F - Indica&ccedil;&atilde;o correta do vencedor. </li>
</span>
	</td>
</tr>

<tr>
	<td align="left"  valign="top" width="200px">
    <span class="texto"><b>Cores</b></span>
    <table class="tabLegenda">
    <tr class="meuResultado"><td class="texto">Eu</td></tr>
    <tr class="amigoResultado"><td class="texto">Meu Amigo</td></tr>
    <tr class="notorio"><td class="texto">Notório</td></tr>
    </table>
    </td>
 </tr>
    <!--<a class="verm">&sup1; - A Organização do Bolco incentiva e agradece todas as participações construtivas. </b>-->

	</td>
</tr>
<tr>
	<td align="left"  valign="top">
		<table width="100%">
			<tr>
				<td align="center"  valign="middle"><a href="mresultados.php" class="texto">Meus Resultados</a></td>
				<td align="left"  valign="top"><?php Valores(); ?></td>
			</tr>

		</table>
	</td>
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
<?php include("analytics.inc"); ?>
   </body>
</html>
