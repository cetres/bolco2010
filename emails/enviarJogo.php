<?php
set_time_limit(200);
require_once "DB.php";
$dsn = "mysql://bolco:girafaganso@localhost/bolco";
$path = "/var/www/html.bolco/emails";
$SSL = true;
$TESTE = false;

$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);

$db =& DB::connect($dsn, $options);
syslog(1,"[BolCo] Enviando e-mail para os participantes");
chdir($path);
$q = "SELECT j.jo_codigo,t1.ti_grupo, t1.ti_nome , t1.ti_acron , ";
$q.= "t2.ti_nome, t2.ti_acron, j.jo_hora, j.jo_aposta_encerrada FROM jogos j ";
$q.= "LEFT JOIN times t1 ON t1.ti_codigo =. j.jo_time1 ";
$q.= "LEFT JOIN times t2 ON t2.ti_codigo =. j.jo_time2 ";
$q.= "WHERE j.jo_aposta_encerrada = 1 ";
$q.= "AND LOCALTIME() > DATE_SUB(j.jo_hora,INTERVAL 10 MINUTE);";
//$q.= "AND LOCALTIME() > DATE_SUB(j.jo_hora,INTERVAL 5 HOUR);";

$res1 =& $db->query($q);
if (PEAR::isError($res1)) {
  die($res1->getMessage());
}
while ($res1->fetchInto($row) || $TESTE) {
  $bufferTotal = "";
  if ($TESTE) {
    $j = 0;
    $jidStr = sprintf("%02d",0);
    $C[1] = "0";
    $C[2] = "Time 1";
    $C[3] = "Time 2";
    syslog(1,"[BolCo] TESTE - Jogo 0");
  } else {
    $j = $row[0];
    $jidStr = sprintf("%02d",$row[0]);
    $C[1] = $row[0];
    $C[2] = $row[2];
    $C[3] = $row[4];
    syslog(1,"[BolCo] Email para o jogo $j");
  }

  $q = "SELECT a.designacao, p.pa_t1, p.pa_t2, b.designacao, a.palpitesPub FROM apto101.palpitesBolCo p ";
  $q.= "left join participanteBolCo a ON p.pa_uid = a.uid ";
  $q.= "left join participanteBolCo b ON b.uid =. a.notorio_pai ";
  $q.= "where p.pa_jogo = $j ORDER BY a.designacao;";

  $res2 =& $db->query($q);
  if (PEAR::isError($res2)) {
    die($res2->getMessage());
  }

  $fp = fopen("$path/emailJogo.txt","r");
  while (!feof($fp)) {
    $buffer = fgets($fp, 4096);
    foreach($C as $key => $value) {
      $campo = sprintf("\${C%02d}",$key);
      $buffer = str_replace($campo,$value,$buffer);
    }
    $bufferTotal .= $buffer;
  }
  fclose($fp);
  $bufferTotal .= "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
  while ($res2->fetchInto($row)) {
    $nome = utf8_decode($row[0]);
    $bufferTotal .= $nome.str_repeat(" ", 40 - strlen($nome))." ".$row[1]." x ".$row[2]."\n";
  }
  $bufferTotal .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
  $bufferTotal .= "BolCo2014: http://www.bolco.com.br/\n";



      /*  Teste de envio com e-mail assindado */
if ($SSL) {
  $bufferTotal = "Content-Type: text/plain;\r\n".
                 "   charset=\"iso-8859-1\"\r\n".
                 "Content-Transfer-Encoding: 7bit\r\n\r\n".$bufferTotal;

  $fp = fopen("$path/jogo_$jidStr.uns", "w");
  fwrite($fp, $bufferTotal);
  fclose($fp);
  $headersOSSL = array("From" => "BolCo2014-Audit <contato@bolco.com.br>",
	                   "Reply-To" => "suporte@apto101.com.br",
					   "X-Mailer" => "BolCo/v.3.0.0");

  openssl_pkcs7_sign("$path/jogo_$jidStr.uns", "$path/jogo_$jidStr.sig", "contatoBolco.pem", array("contatoBolco.pem", ""), $headersOSSL);
  $bufferTotal = file_get_contents("$path/jogo_$jidStr.sig");
  $parts = explode("\n\n", $bufferTotal, 2);
     /*  fim do teste */
} else {
  $headers = "From: BolCo2014-Audit <contato@bolco.com.br>\r\n" .
           "Reply-To: contato@bolco.com.br\r\n" .
           "X-Mailer: BolCo/v.3.0.0\r\n";
//		   "Disposition-Notification-To: suporte@apto101.com.br\r\n";

}
  $q = "SELECT designacao,email FROM participanteBolCo WHERE palpitesEmail = 1 AND inativo=0";

  $res2 =& $db->query($q);
  if (PEAR::isError($res2)) {
    die($res2->getMessage());
  }
  $ct=0;
  while ($res2->fetchInto($row)) {
    if (!$TESTE) {
      if ($SSL) {
        mail($row[1],"[BolCo2014] Jogo $jidStr",$parts[1], $parts[0]);
	  } else {
        $destino = imap_8bit(utf8_decode("To: ".$row[0]." <".$row[1].">"));
        mail($row[1],"[BolCo2014] Jogo ".sprintf("%02d",$C[1]),$bufferTotal,$headers.$destino);
	  }
	}
    $ct++;
  }
  syslog(1,"[BolCo] Email enviado para $ct participantes");

  if (!$TESTE) {
    $q = "UPDATE jogos SET jo_aposta_encerrada = 2 WHERE jo_codigo = $j";
    $res2 =& $db->query($q);
    if (PEAR::isError($res2)) {
      die($res2->getMessage());
    }
  } else {
    mail("bolco2014@gmail.com","[BolCo2014] Jogo $jidStr",$parts[1], $parts[0]);
	$TESTE = false;
  }
  syslog(1,"[BolCo] Envio finalizado para o jogo $j");
}



?>
