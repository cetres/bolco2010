<?php
require_once("protecao.php");
require_once("pre.php");
require_once("email.php");
require_once("usuario.php");

$email = strtolower($_POST["email"]);
$comentario = $_POST["Comentario"];
$tipo = $_POST["tipo"];
$idconvidador = $_POST["idconvidador"];
$senha = rand(1000, 9999);
$idusu = $_SESSION["id"];

if (Usuario::emailExiste($email)) {
	$msg = "Este email já esta cadastrado no site!";
} else if (!Email::validar($email)) {
	$msg = "Email invalido. Digite novamente";
} else {
	$convite = new ConviteUsuario($email, $tipo, $idconvidador);
	$e = new Email();
	if ($tipo=="notorio") {
		$e->convidarNotorio($id);
	} else {
		$e->convidarConhecido($id, $comentario);
	}
	$msg = "Convite enviado com sucesso.";
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<script type="text/javascript"> 
<?php if ($msg != "") { ?>
alert("<?php echo $msg; ?>");
<?php }?>
window.location = "bolco.php";
</script>
</head>
</html>