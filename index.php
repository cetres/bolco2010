<?php
  if ($_SERVER['SERVER_NAME'] == "bolco.com.br") {
  	header("Location: http://www.bolco.com.br/");
  	exit;
  }


  session_start();
  session_unset();
  session_destroy();
  unset($_SESSION);
  session_write_close();
  
  $email=(isset($_GET["e"])?$_GET["e"]:"");
   
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>BolC&oacute; 2010</title>
<link href="bolco.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript" src="bolco.js"></script>
<script language="JavaScript" type="text/JavaScript"> 
function Validaform() { 
with (document.FormComent)	{ 
if (email.value=="") { alert("Preencha o campo email!"); return false; } 
if (senha.value=="") { alert("Preencha o campo senha!"); return false; } 
document.FormComent.action = 'bolco.php';
document.submit();
} }
function ValidaformRe() { 
with (document.FormComent)	{ 
if (email.value=="") { alert("Preencha o campo email!"); return false; } 
document.FormComent.action = 'resenha.php';
document.submit();
}}
</script> 
</head>
<body bgcolor="#ffffff">
<div align="center">

<table width="800" height="800" align="center">

<tr><td width="800" height="80" >&nbsp;</td></tr>
<tr>

<td width="800" background="imagens/bolco.jpg" style="background-repeat:no-repeat;">


<form  name="FormComent" method="post">
<br><br><br><br><br><br>
<table cellpadding="0"  cellspacing="0">

	<tr>
		<td width="40"></td>
		<td ><br>
			<table bordercolor="#ffffff"  cellpadding="0"  cellspacing="0">
			<tr><td colspan="4" bgcolor="#f8aa14" height="25" >&nbsp;&nbsp;<b class="titulo">Acesso ao Sistema</b></td></tr>
			<tr><td colspan="4" height="1" bgcolor="#f8aa14" ></td></tr>
			
<tr><td colspan="1" width="1" bgcolor="#f8aa14" ></td><td height="25">&nbsp;<b class="titulo">Email</b><br></td><td></td><td colspan="1" width="1" bgcolor="#f8aa14" ></td></tr>
<tr><td colspan="1" width="1" bgcolor="#f8aa14" ></td><td height="25">&nbsp;<input value="<?php echo $email ?>" type="text" size="40" name="email" STYLE="border:1 inset #000088;font-size:8pt;color:#000000;"  onfocus="control_onfocus(this);" onblur="control_onblur(this);"></td><td>&nbsp;&nbsp;&nbsp;<input type="submit" value="Acessar" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;" onclick="return Validaform()"><br></td><td colspan="1" width="1" bgcolor="#f8aa14" ></td></tr>
<tr><td colspan="1" width="1" bgcolor="#f8aa14" ></td><td height="25">&nbsp;<b class="titulo">Senha</b><br></td><td></td><td colspan="1" width="1" bgcolor="#f8aa14" ></td></tr>
<tr><td colspan="1" width="1" bgcolor="#f8aa14" ></td><td height="25">&nbsp;<input value=""  type="password" name="senha" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;"  onfocus="control_onfocus(this);" onblur="control_onblur(this);"></td><td>&nbsp;&nbsp;&nbsp;<input type="submit" value="Esqueceu a senha?" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"  onclick="return ValidaformRe()"><br></td><td colspan="1" width="1" bgcolor="#f8aa14" ></td></tr>
<tr><td colspan="1" width="1" bgcolor="#f8aa14" ></td><td height="25">&nbsp;
	<a class="titulo" href="visitante.php?a=i"><strong>Visitante</strong></a></td><td></td><td colspan="1" width="1" bgcolor="#f8aa14" >
</td></tr>
			<tr><td colspan="4" height="1" bgcolor="#f8aa14" ></td></tr>
</table>
		</td>
	</tr>
</table>
</form>
</td></tr></table></div>
<?php include("analytics.inc"); ?>
</body>
</html>
