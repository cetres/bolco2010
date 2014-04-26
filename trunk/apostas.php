<?php
require_once("protecao.php");
gravaaposta();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<script type="text/javascript">
		alert('Apostas atualizadas com sucesso!');
<?php
if($_GET['p'] == "g")  {
	if (isset($_GET['g']) && $_GET['g'] != "") {
	echo "window.location = 'grupos.php?g=".$_GET['g']."';";
	} else { 
	echo "window.location = 'grupos.php?g=A';";
	}
} elseif ($_GET['p'] == "p")  {
	echo "window.location = 'jogos.php?g=8';";
} elseif ($_GET['p'] == "2")  {
	echo "window.location = 'fase2.php';";
} else {
	echo "window.location = 'jogos.php';";
}
?>
</script>
</head>
</html>