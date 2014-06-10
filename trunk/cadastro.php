<?php
require_once("protecao.php");
require_once("email.php");
global $database;
global $host;
global $login_db;
global $senha_db;

$Apelido = $_SESSION["nome"];
$senha = $_SESSION["senha"];
$email = $_SESSION["email"];
$nome = "";
$Telefone = "";
$Comentario = "";
$pagamento =  "0";
$contrato  = "";
$palpite = "";
if (isset($_POST["Apelido"])) {
	$Apelido = ($_POST["Apelido"]);
	$nome = (isset($_POST["nome"]))?mysql_real_escape_string (strip_tags($_POST["nome"])):"";
	$Telefone = (isset($_POST["Telefone"]))?mysql_real_escape_string (strip_tags($_POST["Telefone"])):"";
	$Comentario = (isset($_POST["Comentario"]))?mysql_real_escape_string (strip_tags($_POST["Comentario"])):"";
	$senha = (isset($_POST["senha"]))?mysql_real_escape_string (strip_tags($_POST["senha"])):"";
	$palpite = (isset($_POST["palpite"]))?mysql_real_escape_string (strip_tags($_POST["palpite"])):"";
	$receberPalpites = (isset($_POST["receberPalpites"]))?mysql_real_escape_string (strip_tags($_POST["receberPalpites"])):"";
	$pagamento = (isset($_POST["pagamento"]))?$_POST["pagamento"]:"";


	if ($_SESSION["tipo"] != "Visitante")  {
		$idusu =  $_SESSION["id"];
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			$q = "update usuarios set mostrapalpite = '$palpite', nome = '$nome', apelido = '$Apelido', Telefone  = '$Telefone' ,Comentario  = '$Comentario' , senha = '$senha', receberPalpites = '$receberPalpites' where idusu = '$idusu' ";
			//echo $q;
			$rs = mysql_query($q);
		if (!$rs) {
	   	  die('Could not query:' . mysql_error());
		}
			$msg = "Dados alterados com sucesso.";
			$_SESSION["nome"] = $Apelido;
			$_SESSION["senha"] = $senha;
			$_SESSION["Aceitou"] = $contrato;
			// manda email
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Alteração de Dados do usuário', '$idusu', 'Alteração de Cadastro',CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00')  )") or die(mysql_error());
// Se existe monstra mensagem avisando
	}
} else {
	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
	$q = "select nome,Telefone,Comentario,pago,mostrapalpite,receberPalpites from usuarios where email = '$email' and senha = '$senha'";
	$rs = mysql_query($q);
	if (!$rs) {
		die('Could not query:' . mysql_error());
	}
	if(mysql_num_rows($rs) == 1){
		$nome = mysql_result($rs,0,"nome");
		$Telefone = mysql_result($rs,0,"telefone");
		$Comentario = mysql_result($rs,0,"comentario");
		$pagamento = mysql_result($rs,0,"pago");
		$palpite = mysql_result($rs,0,"mostrapalpite");
		$receberPalpites = mysql_result($rs,0,"receberpalpites");
	}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>
        Cadastro - BolC&oacute; 2014
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
} }
<?php if (isset($msg) && ($msg != "")) { ?>
alert("<?php echo $msg; ?>");
<?php }?>
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
   	<td width="100%" valign="top" align="left" >
<b class="tit">Cadastro</b><br><br>
<font class="texto">Voc&ecirc; foi convidado a participar deste bol&atilde;o por&eacute;m &eacute; preciso preencher alguns dados antes de come&ccedil;ar. Leia o regulamento e ent&atilde;o aceite-o para continuar </font>

<table width="70%">
<form name="FormComent"  action="cadastro.php" method="Post"  onSubmit="return Validaform()" >
<input type=hidden name="operacao" value="<?php echo $operacao; ?>">
<input type=hidden name="pagamento" value="<?php echo $pagamento; ?>">
<tr valign="top" align="left">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Apelido</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="Apelido" type="text" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo htmlentities(utf8_encode($Apelido)); ?>" size="50" maxlength="50"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Nome Completo</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="nome" type="text" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo htmlentities(utf8_encode($nome)); ?>" size="50" maxlength="100"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Email</a>&nbsp;<a class="rodape">.: </a></td>
<td><input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="email" size="50" value="<?php echo $email; ?>" disabled><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Telefone</a>&nbsp;<a class="rodape">.:</a></td>
<td><input name="Telefone" type="text" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo $Telefone; ?>" size="25" maxlength="20"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Senha</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="senha" type=password STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo utf8_encode($senha); ?>" size="25" maxlength="10"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Confirme a senha</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="confirma" type=password STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;"  value="<?php echo utf8_encode($senha); ?>" size="25" maxlength="10"><br></td>

</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Palpites P&uacute;blicos?</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
  <select name="palpite" size=1>
  <option value='0' <?php echo ($palpite == "0")?"selected":"" ?>>Sim</option>
  <option value='1'<?php echo ($palpite == "0")?"":"selected" ?>>Nao</option>
</select><br></td>
</tr>

<tr valign="top">
  <td><a class="rodape">:.</a>&nbsp;<a class="texto">Receber palpites 5 min antes por email</a>&nbsp;<a class="rodape">.: *</a></td>
  <td><select name="receberPalpites" readonly size=1>
  <option value='0' <?php echo ($receberPalpites == "0")?"selected":"" ?>>Sim</option>
  <option value='1'<?php echo ($receberPalpites == "0")?"":"selected" ?>>Nao</option>
  </select></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Pagamento</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
<?php if (intval($pagamento) == 0) { ?>
<a class="texto" style="font-weight:bold;color:#F00">Pagamento n&atilde;o registrado.</a>
<?php } elseif ($pagamento > 0) { ?>
<a class="texto">Pagamento registrado</a>
<?php } ?>
<br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Coment&aacute;rios</a>&nbsp;<a class="rodape">.:</a></td>
<td><textarea STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" cols="35" rows="7" name="Comentario"><?php echo $Comentario; ?></textarea><br></td>
</tr>
<tr valign="top">
<td></td>
<td><input type="submit" value="Enviar" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"><br></td>
</tr>
<?php // inserir opções  de administrador; ?>
</table><br>
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
