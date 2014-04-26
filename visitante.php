<?php
session_cache_expire(10);
session_start();
 	$_SESSION["nome"] = "Visitante";
 	$_SESSION["tipo"] = "Visitante";
 	$_SESSION["senha"] = "";
 	$_SESSION["id"] = "19";
	$_SESSION["email"] = "Visitante";
$login_action = $_GET['a'];

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<script type="text/javascript">
<?php
if ($login_action == "i") {
echo "window.open('bolco.php', '_self');";
} elseif ($login_action == "c") {
echo "window.open('cadastro.php', '_self');";
}
?>
</script>
</head>
</html>