<?php
require("protecao.php");
require("email.php");
require("usuario.php");

if ($_SESSION["tipo"] != "admin") {
  die ("Apenas administradores");
}

if (isset($_POST["emailsConvite"])) {
	$RES = array();
	$tipo = $_POST["tipo"];
	$idConvidador = $_SESSION["id"];
    $e = new Email();
    $emailsConvite = split(';',$_POST["emailsConvite"]);
	foreach ($emailsConvite as $email) {
		$email = trim($email);
		if (!Email::validar($email)) {
		   $RES[$email] = "Erro - email invalido";
		   continue;
		}
		if (Usuario::emailExiste($email)) {
		   $RES[$email] = "Erro - email ja cadastrado";
		   continue;
		}
		$usuario = new ConviteUsuario($email,$tipo,$idConvidador);
		if ($usuario->id > 0 ) {
			if ($tipo == "notorio") {
	    		$e->convidarNotorio($usuario->id);
			} else {
				$e->convidarConhecido($usuario->id,$_POST["comentario"]);
			}
			$RES[$email] = "OK - email enviado";
		} else {
		    $RES[$email] = "Erro - usuario nao cadastrado. Vai saber...";
		}
		unset($usuario);
	}
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>

</head>
<body>
<pre><?php 
if (isset($RES)) {
    echo "Resultado do envio:";
	print_r($RES);
}
?></pre>
<form name="formconvidar" method="post" action="convidar.php">
  <label>coment&aacute;rio (n&atilde;o &eacute; enviado para convite de not&oacute;rio)<br>
  <textarea name="comentario" cols="50" rows="3"></textarea>
  </label><br/>
  <label>e-mails (separados por &quot;;&quot; - ponto-e-v&iacute;rgula) <br>
  <textarea name="emailsConvite" cols="50" rows="3"></textarea>
  </label><br/>
   <label>Tipo 
  <select name="tipo">
  <option value='usuario'>Usuario</option> 
  <option value='notorio'>Notorio</option> 
  </select>
  </label>
  <br/>
  
  <input name="" type="submit" value="Enviar Convites"> &nbsp; &nbsp;
  <input name="" type="button" value="Voltar" onClick="window.location='bolco.php'">
</form>
</body>
</html>