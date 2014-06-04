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
        Meus Resultados - BolC&oacute; 2014
    </title>
</head>


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
<link rel="STYLESHEET" type="text/css" href="bolco.css">
   <div align="center"><BODY marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
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
<b class="tit">Resultados Jogo a Jogo</b><br><br>
<table width="750" >
<tr>
	<td align="center"  valign="top">
		<?php
		if (isset($_GET["us"])) {
		mresultados($_GET["us"]);
		} else	{
		mresultados('0');
		}?>
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
