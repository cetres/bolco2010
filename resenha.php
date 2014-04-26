<?php
require_once("email.php");

$email = strtolower($_POST["email"]);

if(Email::validar($email)) {
		$e = new Email();
		if($e->enviarSenha($email)){
				$msg = "Senha enviada para o email";
		} else {
				$msg = "Email nao cadastrado";
		}
} else {
		$msg = "Email invalido. Insira novamente";
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<script type="text/javascript">
<?php if ($msg != "") { ?>
alert("<?php echo $msg; ?>");
<?php }?>
window.location = "/"
</script>
</head>
</html>