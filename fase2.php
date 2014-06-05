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
        Fase 2 - BolC&oacute; 2014
    </title>
</head>
<script language="Javascript">
<!--
// use via onkeypress="SoNumeros()" no textbox
function OnlyNumbers(e) {

        if (window.event) //IE
        {
        tecla = e.keyCode;
        }

   else if (e.which) //FF
   {
        tecla = e.which;
   }
        //teclas dos numemros(0 - 9) de 48 a 57
   //techa==8 é para permitir o backspace funcionar para apagar

           if ( (tecla >= 48 && tecla <= 57)||(tecla == 8 ) ) {
                           return true;
                  }
                  else {
                           return false;
                  }
}

//-->
</script>
<script language=javascript>
<!--
function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}
//-->

function Validaform() {
with (document.FormComent)	{
     for ( i = 0 ; i < form .elements.length; i++ ) {
         if ( form .elements [ i ] .type == "text" && form .elements [ i ] .value == "" ){
             alert ( "Please fill out all fields." )
             form .elements [ i ] .focus ()
             break
         }
     }
} }

<?php if ($msg != "") { ?>
alert("<?php echo $msg; ?>");
<?php }?>
</script>
<style>
body {
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
<b class="tit">Jogos e Apostas</b><br><br>
<a class="texto">
As fases de oitavas-de-final, quartas-de-final, semifinais e final ser&atilde;o disputadas em sistema eliminat&oacute;rio ou MATA MATA!!!
</a>
<br><br>
<b class="tit">Segunda Fase</b><br><br><br>
<form name="FormComent"  action="apostas.php?p=2" method="Post" >
<table width="100%" >
<tr>
	<td align="center"  valign="top">
		<?php 	fase2(); ?>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		<input type="submit" value="Enviar Palpites" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"><br><br></form>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">

		<table width="100%">
			<tr>
				<td align="center"  valign="top"><a href="jogos.php" class="texto"><img src="imagens/todos.gif" width="30" height="43" border="0" alt=""></a><br><a href="jogos.php" class="texto">Todos os Jogos</a></td>
				<td align="center"  valign="top"><a href="jogos.php?g=8" class="texto"><img src="imagens/prox.gif" width="30" height="22" border="0" alt=""></a><br><a href="jogos.php?g=8" class="texto">Pr&oacute;ximos os Jogos</a></td>
				<td align="center"  valign="top"><a href="grupos.php?g=A" class="texto"><img src="imagens/grupos.gif" width="50" height="23" border="0" alt=""></a><br><a href="grupos.php?g=A" class="texto">Fase de Grupos</a></td>
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
</body>
</html>
