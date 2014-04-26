<?php
require_once("protecao.php");
require_once("pre.php");
require_once("email.php");

$email = strtolower($_POST["email"]);
$comentario = $_POST["Comentario"];
$tipo = $_POST["tipo"];
$idconvidador = $_POST["idconvidador"];
$senha = rand(1000, 9999);
$idusu = $_SESSION["id"];

$res = $db->getOne("select idusu from usuarios where email = ?",array($email));
if (PEAR::isError($res)) {
	error_log($res->getMessage()." / ".$res->getDebugInfo());
	die($res->getMessage());
}  
if($res){
	$msg = "Este email já esta cadastrado no site!";
} else {
	$e = new Email();
	if (!Email::validar($email)) {
		$msg = "Email invalido. Digite novamente";
		
	} else {
		$q = "INSERT INTO usuarios (senha, dateCreated, pago, tipo, email, ativo, quemchamou, aceitouReg) VALUES (?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),?,?,?,?,?,?)";
		$res = $db->query($q,array($senha,0,$tipo,$email,0,$idconvidador,1));
		if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
  		die($res->getMessage());
		}  
		$q = "INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES (?,?,?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'))";  
    $res = $db->query($q,array('Envio de convite',$idusu,'Envio de convite para $email'));
		if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
  		die($res->getMessage());
		}  
		$id = $db->getOne("select idusu from usuarios where email = ?",array($email));
		if (PEAR::isError($id)) {
			error_log($id->getMessage()." / ".$id->getDebugInfo());
  		die($res->getMessage());
		}  
		if ($tipo=="notorio") {
			$e->convidarNotorio($id);
		} else {
			$e->convidarConhecido($id,$comentario);
		}
		$msg = "Convite enviado com sucesso.";
	}
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