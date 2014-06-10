<?php
require_once("../protecao.php");
global $database;
global $host;
global $login_db;
global $senha_db;
if ($_SESSION["tipo"] != "admin")  {
  header("Location: /");
  exit;
}
		$nome = "";
		$Telefone = "";
		$Comentario = "";
		$pagamento = "0";
		$email ="";
		$Apelido = "";
		$Convite = "";
		$ida ="";
		$tipo = "";
		$Ativo = 0;
		$tipo = "";
		$Comentarioadm = "";

if (isset($_GET['acao'])) {
$acao = $_GET['acao'];

	if ($acao == "E") {

		$ida =$_GET['id'];
		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "update usuario set ativo = '1' where idusu = '$ida'";
		$rs = mysql_query($q);
		$Ativo = 1;

	} elseif ($acao == "I") {

		$Apelido = ($_POST["Apelido"]);
		$nome = ($_POST["nome"]);
		$email = ($_POST["email"]);
		$Telefone = ($_POST["Telefone"]);
		$Comentario = ($_POST["Comentario"]);
		$tipo = ($_POST["tipo"]);
		$Comentarioadm = ($_POST["Comentarioadm"]);
		$senha = rand(5000, 15000);
		$idusu =  $_SESSION["id"];
		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "select idusu from usuarios where email = '$email'";
		$rs = mysql_query($q);
	 	if (!$rs) {
	   	 die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) == 1){
			$msg = "Este email já esta cadastrado!";
			$acao = "N";
		} else {
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			$q = "INSERT INTO usuarios (email, nome, apelido, telefone,comentario,senha, convite, pago, dateCreated, tipo, ativo,Comentarioadm  ) values ('$email', '$nome','$Apelido', '$Telefone' , '$Comentario' , '$senha', '0', 0, LOCALTIME(), '$tipo',0,'$Comentarioadm')";
			//echo $q;
			$rs = mysql_query($q);
			if (!$rs) {
   				die('Could not query:' . mysql_error());
			}
			$msg = "Dados cadastrados com sucesso.";
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Cadastro de Dados do usuário', '$idusu', 'Cadastro admin - usuario: $email ',LOCALTIME()  )") or die(mysql_error());

				$q = "select idusu from usuarios where email = '$email'";
				$rs = mysql_query($q);
				$ida = mysql_result($rs,0,"idusu");
		}
		////// INSERIR EMAIL DE CONVITE ????? /////////
	} elseif ($acao == "N") {
		$nome = "";
		$Telefone = "";
		$Comentario = "";
		$pagamento = "0";
		$email ="";
		$Apelido = "";
		$Convite = "";
		$ida ="0";

	} elseif ($acao == "U") {
		$ida =$_GET['id'];

		$Apelido = ($_POST["Apelido"]);
		$nome = ($_POST["nome"]);
		$email = ($_POST["email"]);
		$Telefone = ($_POST["Telefone"]);
		$Comentario = ($_POST["Comentario"]);
		$tipo = ($_POST["tipo"]);
		$senha = rand(5000, 15000);
		$ativo = ($_POST["ativo"]);
		$idusu =  $_SESSION["id"];
		$Comentarioadm = ($_POST["Comentarioadm"]);

		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "select idusu from usuarios where email = '$email' and idusu <> $ida";
		$rs = mysql_query($q);
	 	if (!$rs) {
	   	 die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) == 1){
			$msg = "Este email já esta cadastrado!";
			//$acao = "N";
		} else {

			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			//$q = "INSERT INTO usuarios (email, nome, apelido, telefone,comentario,senha, convite, pago, dateCreated, tipo, ativo  ) values ('$email', '$nome','$Apelido', '$Telefone' , '$Comentario' , '$senha', '0', $pagamento, LOCALTIME(), '$tipo',0)";
			$q = "update usuarios set email = '$email', nome = '$nome', apelido = '$Apelido', Telefone  = '$Telefone' ,Comentario  = '$Comentario', tipo = '$tipo' , ativo = $ativo, Comentarioadm = '$Comentarioadm'  where idusu = '$ida' ";
			$rs = mysql_query($q);
			if (!$rs) {
   				die('Could not query:' . mysql_error());
			}
			$msg = "Dados atualizados com sucesso.";
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Alteração de Dados do usuário', '$idusu', 'Alteração de Cadastro admin - usuario: $email ',LOCALTIME()  )") or die(mysql_error());

				$q = "select idusu from usuarios where email = '$email'";
				$rs = mysql_query($q);
				$ida = mysql_result($rs,0,"idusu");
		}


	} elseif ($acao == "P") {
		   $ida =$_GET['id'];

		   $res =& $db->query("update usuarios set pago = ? where idusu = ?",array($_SESSION["id"],$ida));

           if (PEAR::isError($res)) {
	 			error_log($res->getMessage()." / ".$res->getDebugInfo());
				die("Erro ao atualizar pagamento");
   			}

			$msg="Pagamento realizado - ".$_SESSION["id"]."/".$ida;
		}

} else {
	$acao = "";
	if (isset($_REQUEST["idusu"])) {
		$ida = $_REQUEST["idusu"];
		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "select * from usuarios where  idusu = '$ida'";
		//echo $q;
		$rs = mysql_query($q);
		if (!$rs) {
			die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) == 1){
			$nome = htmlentities(utf8_encode(mysql_result($rs,0,"nome")));
			$Telefone = mysql_result($rs,0,"telefone");
			$Comentario = htmlentities(utf8_encode(mysql_result($rs,0,"comentario")));
			$pagamento = mysql_result($rs,0,"pago");
			$email = mysql_result($rs,0,"email");
			$senha = mysql_result($rs,0,"senha");
			$Apelido = htmlentities(utf8_encode(mysql_result($rs,0,"Apelido")));
			$Convite = mysql_result($rs,0,"Convite");
			$tipo = mysql_result($rs,0,"tipo");
			$ativo = mysql_result($rs,0,"ativo");
//			echo $Ativo;
		}
	}
}
?>
<html>
<head>
    <title>
        Bolco 2014
    </title>
</head>
<script language=javascript>
<!--

function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}
//-->
<?php if ($msg != "") { ?>
alert("<?php echo $msg; ?>");
<?php }?>
</script>


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
<link rel="STYLESHEET" type="text/css" href="../bolco.css">
   <div align="center"><BODY marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
<h1 class="tit">Cadastro</h1><br><br>
<font class="texto">Administra&ccedil;&atilde;o de Usu&aacute;rios </font><br><br>
<table width="70%">
<form name="FormComent"  action="cadastro.php" method="Post" >
<tr valign="top" align="left">
<td width="30%"><a class="rodape">:.</a>&nbsp;<a class="texto">Vossa Excel&ecirc;ncia:</a>&nbsp;<a class="rodape">.: *</a></td>
<td width="70%"><?php echo $_SESSION["nome"]; ?><br></td>
</tr>

<tr valign="top" align="left">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Usu&aacute;rio</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
  <select name="idusu" size=1 onChange="FormComent.submit();">


<?php if ($ida == "") { ?>
  <option value=''>Nome - Email - Apelido - Perfil</option>

<?php } else {
echo "<option value='$ida'>$nome - $email - $Apelido</option> "; ?>
  <option value=''>Nome - Email - Apelido - Perfil</option>

<?php }  ?>

<?php
mysql_connect($host, $login_db, $senha_db);
mysql_select_db($database);
$q = "select nome, idusu, email, apelido, tipo from usuarios where tipo <> 'Visitante'";
$rs = mysql_query($q);
$i = 0;
	$num = mysql_num_rows($rs);
	while ($i < $num) {
		printf ("<option value='".mysql_result($rs,$i,"idusu")."'>".htmlentities(mysql_result($rs,$i,"nome"))." / ".mysql_result($rs,$i,"email")." / ".htmlentities(mysql_result($rs,$i,"apelido"))." / ".mysql_result($rs,$i,"tipo")."</option>");
	$i++;
	}
?></select>
<br></td>
</tr>


<tr valign="top" align="left">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Apelido</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="Apelido" size="50" value="<?php echo $Apelido; ?>"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Nome Completo</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="nome" size="50" value="<?php echo $nome; ?>"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Email</a>&nbsp;<a class="rodape">.: *</a></td>
<td><input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="email" size="50" value="<?php echo $email; ?>"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Telefone</a>&nbsp;<a class="rodape">.:</a></td>
<td><input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="Telefone" size="25" value="<?php echo $Telefone; ?>"><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Pagamento</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
 <?php if (intval($pagamento) > 0) { ?>
   Sim - <?php echo $pagamento ?>
 <?php } else { ?>
   N&atilde;o - <input type="button" value="Pagar" onClick="window.location='cadastro.php?acao=P&amp;id=<?php echo $ida ?>'">
 <?php }?>
  <br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Situa&ccedil;&atilde;o</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
  <select name="ativo" size=1>
<?php if ($ativo == "0") { ?>
  <option value='0'>Ativo</option>
  <option value='1'>Excluído</option>
<?php } elseif ($ativo == "1") { ?>
  <option value='1'>Excluído</option>
  <option value='0'>Ativo</option>
<?php } ?>

</select><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Tipo de Usuario</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
  <select name="tipo" size=1>
<?php if ($tipo == "Usuario") { ?>
  <option value='Usuario'>Usuario</option>
  <option value='Notorio'>Notorio</option>
<?php } elseif ($tipo == "Notorio") { ?>
  <option value='Notorio'>Notorio</option>
  <option value='Usuario'>Usuario</option>
<?php } else  { ?>
  <option value='<?php echo $tipo; ?>'><?php echo $tipo; ?></option>
  <option value='Notorio'>Notorio</option>
  <option value='Usuario'>Usuario</option>

<?php } ?>

</select><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Coment&aacute;rios</a>&nbsp;<a class="rodape">.:</a></td>
<td><textarea STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" cols="35" rows="7" name="Comentario"><?php echo $Comentario; ?></textarea><br></td>
</tr>
<tr valign="top">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Coment&aacute;rios da Administra&ccedil;&atilde;o</a>&nbsp;<a class="rodape">.:</a></td>
<td><textarea STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" cols="35" rows="7" name="Comentarioadm"><?php echo $Comentarioadm; ?></textarea><br></td>
</tr>
<tr valign="top">
<td></td>

<td>
<?php if ($acao == "N") {  ?>
<input type="submit" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;" name="2" value="Pr&eacute; Cadastro e Envio de Convite" onClick="javascript: FormComent.action='cadastro.php?acao=I';" />
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;" name="1" value="Voltar" onClick="javascript: FormComent.action='cadastro.php'" />

<?php } elseif ($ida == "") { ?>
<input type="submit" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;" name="1" value="Novo" onClick="javascript: FormComent.action='cadastro.php?acao=N';" />

<?php } else { ?>
<input type="submit" value="Atualizar Registro" name="2" onClick="javascript: FormComent.action='cadastro.php?acao=U&id=<?php echo $ida; ?>';" >
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit"  name="3" value="Novo" onClick="javascript: FormComent.action='cadastro.php?acao=N';">

<?php }   ?>
<input type="button" value="Voltar ao menu" onClick="window.location='/admin/'">
</td>
</tr>
</table><br>
 </form>
</div>
   </body>
</html>
