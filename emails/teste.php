<?
  $versao="3.0.0"
  $path = "/var/www/html.bolco/emails";
  $fp = fopen("$path/jogo_00.uns", "w");
  fwrite($fp, "Content-Type: text/plain;\r\n".
              "   charset=\"iso-8859-1\"\r\n".
              "Content-Transfer-Encoding: 7bit\r\n\r\n".
              "Teste de assinatura");
  fclose($fp);
  $headersOSSL = array("From" => "BolCo2014-Audit <contato@bolco.com.br>",
	                     "Reply-To" => "suporte@apto101.com.br",
											 "X-Mailer" => "BolCo/v.".$versao);

 openssl_pkcs7_sign("$path/jogo_00.uns", "$path/jogo_00.sig", "contatoBolco.pem", array("contatoBolco.pem", ""), $headersOSSL);

$data = file_get_contents("$path/jogo_00.sig");

$parts = explode("\n\n", $data, 2);

mail("cetres@gmail.com", "Tete 1", $parts[1], $parts[0]);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>

</body>
</html>
