<?php
require("protecao.php");
require("email.php");
require("usuario.php");

if ($_SESSION["tipo"] != "admin") {
  header("Location: /");
  exit;
}

$cor["A"]="#F00";
$cor["N"]="#00F";
$cor["U"]="#050";

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Usuarios - BolC&oacute; 2010</title>
<link rel="stylesheet" type="text/css" href="bolco.css" />
</head>
<body>
<pre><?php 
if (isset($RES)) {
	echo "Resultado do envio:";
	print_r($RES);
}
?></pre>
<center><input type="button" value="Voltar" onClick="window.location='/admin/'"/></center>
<table class='usuarios'>
 <tr>
  <th>Codigo</th>
  <th title="Tipo de usuario">T.</th>
  <th>Apelido</th>
  <th>Nome</th>
  <th>E-mail</th>
  <th>Ultimo Acesso</th>
  <th>Chamador</th>
  <th>Pago</th>
  </tr>
<?php

$q = <<< EOL
	SELECT u.idusu idusu, u.apelido apelido, u.nome nome, u.tipo tipo, u.email email, c.apelido chamador, u.pago pago, u.ultimoacesso ultimoacesso, p.apelido recebedor
	from usuarios u
    left join usuarios c on u.quemchamou = c.idusu 
	left join usuarios p on u.pago = p.idusu and u.pago > 0
    where u.tipo not in ('Visitante','Convidado') and u.ativo = 0;
EOL;

$res =& $db->query($q);
while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
	$tipo = strtoupper(substr($row["tipo"],0,1));
	echo "<tr>\n";
	echo " <td><a href='admin/cadastro.php?idusu=".$row["idusu"]."'>".$row["idusu"]."</a></td>\n";
	echo " <td>".$tipo."</td>\n";
	echo " <td>".htmlentities($row["apelido"])."</td>\n";
	echo " <td>".htmlentities($row["nome"])."</td>\n";
	echo " <td style='color:".$cor[$tipo]."'>".$row["email"]."</td>\n";
	echo " <td>".$row["ultimoacesso"]."</td>\n";
	echo " <td>".htmlentities($row["chamador"])."</td>\n";
	echo " <td>".((intval($row["pago"])>0)?"S-".$row["recebedor"]:"N")."</td>\n";
	echo "</tr>\n";
}
?>
</table>
<center><input type="button" value="Voltar" onClick="window.location='/admin/'"/></center>
</body>
</html>