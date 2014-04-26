<?php
require_once("protecao.php");
if ($_SESSION["tipo"] == "Visitante")  {
  echo "<html><head><script type='text/javascript'>window.open('/', '_self');</script></head></html>";
  exit();
}
$g = $_GET['g'];
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>
        Grupos - BolC&oacute; 2010
    </title>
</head>
<script language=javascript>
<!--

function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}
//-->
</script>
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
Em 2 de Dezembro, a FIFA anunciou oficialmente os cabe&ccedil;as de chaves e as divis&otilde;es dos potes para o sorteio. A grande surpresa foi a presen&ccedil;a da Holanda no pote dos cabe&ccedil;as de chave.
Foi realizado em 4 de Dezembro de 2009, na Cidade do Cabo, &Aacute;frica do Sul. As 32 sele&ccedil;&otilde;es classificadas para o est&aacute;gio final da Copa do Mundo foram divididas em 8 grupos (A, B, C, D, E, F, G e H) de 4 pa&iacute;ses cada.<br>
As equipes participantes disputaram a fase de grupos da Copa no sistema de &quot;todos contra todos&quot; em turno &uacute;nico. Os crit&eacute;rios de desempate desta fase ser&atilde;o aplicados na seguinte ordem:<br>
   1. Saldo de gols/diferen&ccedil;a de gols<br>
   2. Gols feitos<br>
   3. Resultado do confronto direto entre as equipes empatadas<br>
   4. Sorteio pelo Comit&ecirc; Organizador da FIFA ou play-off (de acordo com o calend&aacute;rio)<br><br>


<a class="texto"><strong>Selecione o grupo e palpite!</strong>


<br><br>
<b class="tit">Fase de Grupos</b><br><br><br>
<form name="FormComent"  action="apostas.php?p=g&g=<?php echo $g; ?>" method="Post"  onSubmit="return Validaform()" >
<table width="100%" >
<tr>
	<td align="center"  valign="top">
		<a href="grupos.php?g=A" class="texto">Grupo A</a><a class="texto"> | </a>
		<a href="grupos.php?g=B" class="texto">Grupo B</a><a class="texto"> | </a>
		<a href="grupos.php?g=C" class="texto">Grupo C</a><a class="texto"> | </a>
		<a href="grupos.php?g=D" class="texto">Grupo D</a><a class="texto"> | </a>
		<a href="grupos.php?g=E" class="texto">Grupo E</a><a class="texto"> | </a>
		<a href="grupos.php?g=F" class="texto">Grupo F</a><a class="texto"> | </a>
		<a href="grupos.php?g=G" class="texto">Grupo G</a><a class="texto"> | </a>
		<a href="grupos.php?g=H" class="texto">Grupo H</a><a class="texto"> | </a>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		<?php Grupos("Grupo ".$g); ?>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		<input type="submit" value="Enviar Palpites" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"><br><br></form>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		<?php //ClassificacaoGrupo("Grupo ".$g); ?>
	</td>
</tr>
<tr>
	<td align="center"  valign="top">
		
		<table width="100%">
			<tr>
				<td align="center"  valign="top"><a href="jogos.php" class="texto"><img src="imagens/todos.gif" width="30" height="43" border="0" alt=""></a><br><a href="jogos.php" class="texto">Todos os Jogos</a></td>
				<td align="center"  valign="top"><a href="jogos.php?g=8" class="texto"><img src="imagens/prox.gif" width="30" height="22" border="0" alt=""></a><br><a href="jogos.php?g=8" class="texto">Pr&oacute;ximos os Jogos</a></td>
				<td align="center"  valign="top"><a href="fase2.php" class="texto"><img src="imagens/2fase.gif" width="60" height="45" border="0" alt=""></a><br><a href="fase2.php" class="texto">Segunda Fase</a></td>
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
