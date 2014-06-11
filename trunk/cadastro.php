<?php
if (strtolower($_SESSION["tipo"]) == "visitante")  {
	header("Location: /");
	exit();
}
require_once("pre.php");
require_once("protecao.php");
require_once("email.php");

$idusu =  $_SESSION["id"];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$apelido = ($_POST["apelido"]);
	$nome = (isset($_POST["nome"]))?strip_tags($_POST["nome"]):"";
	$telefone = (isset($_POST["telefone"]))?strip_tags($_POST["telefone"]):"";
	$comentario = (isset($_POST["comentario"]))?strip_tags($_POST["comentario"]):"";
	$palpite = (isset($_POST["palpite"]))?strip_tags($_POST["palpite"]):"";
	$receberPalpites = (isset($_POST["receberPalpites"]))?strip_tags($_POST["receberPalpites"]):"";
	$pagamento = (isset($_POST["pagamento"]))?$_POST["pagamento"]:"";

	$q = "UPDATE usuarios SET mostrapalpite=?,nome=?,apelido=?,telefone=?,comentario=?,receberPalpites=? WHERE idusu=?";
	$res =& $db->query($q, array($palpite,$nome,$apelido,$telefone,$comentario,$receberPalpites,$idusu));
	$_SESSION["nome"] = $palpite;
	if (PEAR::isError($res)) {
		error_log("Update User ".$res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	} 
	if (isset($_POST["senha"]) && strlen($_POST["senha"]) > 0) {
		$senha = strip_tags($_POST["senha"]);
		$q = "UPDATE usuarios SET senha=? WHERE idusu=?";
		$res =& $db->query($q, array($senha,$idusu));
		$_SESSION["senha"] = $senha;
		if (PEAR::isError($res)) {
			error_log("Update Senha ".$res->getMessage()." / ".$res->getDebugInfo());
			die($res->getMessage());
		} 
	}
	$msg = "Dados alterados com sucesso.";

	$q = "INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Alteração de Dados do usuário', ?, 'Alteração de Cadastro',CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00')  )";
	$res =& $db->query($q, $idusu);
	if (PEAR::isError($res)) {
		error_log("Log ".$res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	}
} else {
	$q = "SELECT * FROM usuarios WHERE idusu=?";
	$res =& $db->query($q, $idusu);
	if (PEAR::isError($res)) {
		error_log("Select ".$res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	} 
	if ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		$apelido = $row['apelido'];
		$nome = $row['nome'];
		$telefone = $row['telefone'];
		$comentario = $row['comentario'];
		$pagamento = $row['pago'];
		$palpite = $row['mostrapalpite'];
		$receberPalpites = $row['receberpalpites'];
	} else {
		$msg = "Usuario nao encontrado";
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
    if (apelido.value=="") { alert("Preencha o campo Apelido!"); return false; }
    if ((senha.value!="") && (senha.value!=confirma.value)) { alert("O campo Senha tem que ser igual ao campo Cofirma Senha!"); return false; }
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
<table width="80%">
<form name="FormComent"  action="cadastro.php" method="Post"  onSubmit="return Validaform()" >
<input type=hidden name="operacao" value="<?php echo $operacao; ?>">
<input type=hidden name="pagamento" value="<?php echo $pagamento; ?>">
<tr valign="top" align="left">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Apelido</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="apelido" type="text" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo htmlentities(utf8_encode($apelido)); ?>" size="50" maxlength="50"><br></td>
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
<td><input name="telefone" type="text" STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="<?php echo $telefone; ?>" size="25" maxlength="20"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Senha</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="senha" type=password STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" value="" size="25" maxlength="10" autocomplete="off"><span class="texto">(Preencha apenas se for alterar)</span><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Confirme a senha</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input name="confirma" type=password STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;"  value="" size="25" maxlength="10" autocomplete="off"><br></td>

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
<td><textarea STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" cols="35" rows="7" name="comentario"><?php echo $comentario; ?></textarea><br></td>
</tr>
<tr valign="top">
<td></td>
<td><input type="submit" value="Enviar" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;"><br></td>
</tr>
</form>
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
