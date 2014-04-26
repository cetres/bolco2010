<?php
require_once("../protecao.php");
if ($_SESSION["tipo"] != "admin")  {
  header("Location: /");
  exit;
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Administra&ccedil;&atilde;o BolC&oacute;</title>
</head>
<body>
<table cellpadding="10"><tr>
  <td><a href="cadastro.php">Cadastro de usu&aacute;rios</a></td></tr><tr>
  <td><a href="../usuarios.php">Listagem de usu&aacute;rios</a></td></tr><tr><td><a href="resultados.php">Resultados da Copa</a></td></tr>
  <tr>
    <td><a href="/bolco.php">Voltar &agrave; P&aacute;gina inicial</a></td></tr>
  </table>
</body>
</html>
