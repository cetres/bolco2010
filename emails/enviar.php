<?php
/*
 Codigo fonte parece ser de 2006 uma vez que em 2010 nao foi utilizada criptografia


*/
$DEBUG = false;
$TESTE_JOGO = false;
$TESTE_EMAIL = false;

$METODO = 2; // 1 = nativo; 2 = smtp
$TIPO='soap';
$PROVEDOR = 1; // 1 = gmail; 2 = aws; 3 = webfaction
$JOGO = 0; // 0 = obtem o ultimo jogo; n>0 = jid

if (PHP_SAPI === 'cli' || empty($_SERVER['REMOTE_ADDR'])) {
	$options = getopt("j:p:m:ted");
	if (isset($options["t"])) {
		$TESTE_JOGO = true;
		print("Iniciando modo teste de jogo\n");
	}
	if (isset($options["e"])) {
		$TESTE_EMAIL = true;
		print("Iniciando modo teste de email\n");
	}
	if (isset($options["d"])) {
		$DEBUG = true;
		print("Modo DEBUG habilitado\n");
	}
	if (isset($options["j"])) {
		$TESTE_JOGO = true;      // Trava de seguranca para nao ocorrer falhas
		$JOGO = $options["j"];
		print("Jogo selecionado: " . $JOGO . "\n");
	}
	if (isset($options["p"])) {
		$PROVEDOR = $options["p"];
		print("Selecionando provedor $PROVEDOR\n");
	}
	if (isset($options["m"])) {
		$METODO = $options["m"];
	}
}

if ($PROVEDOR == 1) {
	$SMTP_SERVER="smtp.gmail.com";
	$SMTP_USER="juiz@bolco.com.br";
	$SMTP_PASS="girafaganso";
} else if ($PROVEDOR == 2) {
    $SMTP_SERVER="email-smtp.us-east-1.amazonaws.com";
    $SMTP_USER="AKIAJNNOGX7SDKTZJ3AA";
	$SMTP_PASS="AkF2VQ8i2QofvSYTSuYLBoR4HlPl8LWrKNJnPoQGGXC3";
} else {
	$SMTP_SERVER="smtp.webfaction.com";
	$SMTP_USER="cetres_bolco";
	$SMTP_PASS="925cbe63";
}

$LIMITE_LOTE = 50;

function enviarEmail($email, $assunto, $template, $apelido, $C) {
	global $METODO, $versao, $ERR, $TESTE_EMAIL,$SMTP_SERVER,$SMTP_USER,$SMTP_PASS;

	$bufferTotal = "";
	$fn = $template.".txt";
  	if (!file_exists($fn))
  		return false;
  	$fp = fopen($fn,"r");
  	while (!feof($fp)) {
    	$buffer = fgets($fp, 4096);
		foreach($C as $key => $value) {
	  		$campo = sprintf("\${C%02d}",$key);
	  		$buffer = str_replace($campo,utf8_decode($value),$buffer);
		}
		$bufferTotal .= $buffer;
  	}
  	fclose($fp);
	if ($METODO == 1) {
		$remetente = 'From: Juiz BolCo <contato@bolco.com.br>';
	  	$para = $apelido." <".$email.">";
		$headers = $remetente . "\r\n" .
             'Reply-To: contato@bolco.com.br' . "\r\n" .
             'X-Mailer: BolCo/v.'.$versao. "\r\n" .
			 'Disposition-Notification-To: contato@bolco.com.br';
		$enviado = mail($para,$assunto,$bufferTotal,$headers);
	} else {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = $SMTP_SERVER;
		$mail->Port = 465;
		$mail->SMTPDebug = false;
		$mail->Username = $SMTP_USER;
		$mail->Password = $SMTP_PASS;
		$mail->Hostname = 'bolco.com.br';
   		$mail->From = "juiz@bolco.com.br";
    	$mail->FromName = "Juiz BolCo";
    	$mail->AddAddress($email,$apelido);
    	$mail->AddBCC('bolco2010@gmail.com');
        //$mail->AddReplyTo($webmaster_email,"Webmaster");
        //$mail->WordWrap = 50;
        //$mail->AddAttachment("/var/tmp/file.tar.gz");
		$mail->IsHTML(false);
		$mail->Subject = $assunto;
		$mail->Body = $bufferTotal;
        //$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
		if ($TESTE_EMAIL) {
		    echo "TESTE: \n" . var_dump($mail);
			$enviado=false;
		} else {
			$enviado = $mail->Send();
		}
		$ERR .= $mail->ErrorInfo;
		unset($mail);
	}
	return $enviado;
}

function enviarEmailJogo($obj) {
	global $METODO, $versao, $ERR, $TESTE_EMAIL, $TESTE_JOGO, $SMTP_SERVER, $SMTP_USER, $SMTP_PASS, $LIMITE_LOTE, $DEBUG;
	$enviado=null;

	$bufferTotal= "Este e-mail é para informar os palpites dos participantes do bolão fazendo,\n";
	$bufferTotal.= "assim, uma ferramenta para que possa verificar a integridade do sistema\n";
	$bufferTotal.= "auditando os resultados. Caso não deseje receber mais esses e-mails, basta\n";
	$bufferTotal.= "entrar no sítio na área preferências e desabilitar a opção de receber e-mails.\n";
	$bufferTotal.= "Os palpites do jogo " . $obj->jogo . " são os seguintes:\n";
	$bufferTotal .= "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
	$bufferTotal = utf8_decode($bufferTotal);
	$bufferTotalHTML = nl2br(htmlentities($bufferTotal));
	$bufferTotalHTML .= "<pre>\n";
    foreach ($obj->palpite as $linha) {
		$bufferTotal .= utf8_decode($linha);
		$bufferTotalHTML .= htmlentities(utf8_decode($linha));
	}
	$bufferTotalHTML .= "</pre>\n";
	$bufferTotalHTML .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=<br>";
	$bufferTotalHTML .= "BolCo: http://www.bolco.com.br/\n";
    $bufferTotal .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
    $bufferTotal .= "BolCo: http://www.bolco.com.br/\n";
	if ($DEBUG) {
	   print($bufferTotal);	
	}
	if ($METODO == 1) {
		$remetente = 'From: Juiz BolCo <juiz@bolco.com.br>';
	  	$para = $apelido." <".$email.">";
		$headers = $remetente . "\r\n" .
             'Reply-To: contato@bolco.com.br' . "\r\n" .
             'X-Mailer: BolCo/v.'.$versao. "\r\n" .
			 'Disposition-Notification-To: contato@bolco.com.br';
		$enviado = mail($para,$assunto,$bufferTotal,$headers);
	} else {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = $SMTP_SERVER;
		$mail->Port = 465;
		$mail->SMTPDebug = false;
		$mail->Username = $SMTP_USER;
		$mail->Password = $SMTP_PASS;
		$mail->Hostname = 'bolco.com.br';
    	$mail->From = "juiz@bolco.com.br";
    	$mail->FromName = "BolCo 2014";
		$mail->AddReplyTo('contato@bolco.com.br',"Contato BolCo");
		$mail->IsHTML(true);
		$mail->Subject = "[BolCo] Palpites de ".utf8_decode($obj->jogo);
		$mail->Body = $bufferTotalHTML;
		$mail->AltBody = $bufferTotal;
		if ($TESTE_EMAIL) {
		    echo "TESTE: \n" . var_dump($mail);
			$enviado = false;
		} elseif ($TESTE_JOGO) {
			$mail->AddBCC("gustavo@apto101.com.br");
			print("Iniciando envio de email...");
			$enviado = $mail->Send();
			$ERR .= $mail->ErrorInfo;
			if ($ERR!="") {
				print("Erro no envio de emails dos jogos - " . $ERR);
				syslog(LOG_ERR, "Erro no envio de emails dos jogos - " . $ERR);
			}
		} else {
			$LOTE=1;
			$CT=0;
			$CT_TOTAL;
			$emails_enviados="";
			foreach ($obj->email as $email) {
				$mail->AddBCC($email);
				$emails_enviados.=$email.",";
				$CT++;
				$CT_TOTAL++;
				if (($LIMITE_LOTE > 0) && (($CT>=$LIMITE_LOTE)||($CT_TOTAL==count($obj->email)))) {
					//$mail->AddBCC('cetres@gmail.com');
					$CT=0;
     				$enviado = $mail->Send();
					$ERR .= $mail->ErrorInfo;
					if (!$enviado) {
						syslog(LOG_ERR,"Erro no envio de emails dos jogos lote $LOTE - ".$mail->ErrorInfo);
						syslog(LOG_ERR,"Lote $LOTE: ".$emails_enviados);
					} else {
						syslog(LOG_INFO,"Lote $LOTE enviado - ".$mail->ErrorInfo);
						syslog(LOG_INFO,"Lote $LOTE: ".$emails_enviados);
					}
					$emails_enviados='';
					$mail->ClearBCCs();
					$LOTE++;
				}
//				if (!in_array($email,$EMAIL_ERR))
//					$mail->AddBCC($email);
			}
		}
		if((!$TESTE_EMAIL && !$TESTE_JOGO) && !($LIMITE_LOTE > 0)) {
			$enviado = $mail->Send();
			$ERR .= $mail->ErrorInfo;
			if ($ERR!="") {
				syslog(LOG_ERR, "Erro no envio de emails dos jogos - " . $ERR);
			}
		}
		unset($mail);
	}
	return $enviado;
}


$ERR='';

if (defined('STDIN')) {
  chdir(dirname(__FILE__));
}

if (file_exists("pre.php")) {
	require_once("pre.php");
	require_once("emails/pm/class.phpmailer.php");
} else {
    require_once("../pre.php");
	require_once("pm/class.phpmailer.php");
}

syslog(LOG_INFO,"Inicio do procedimento para enviar e-mail");

if (file_exists("./emails"))
	chdir("./emails");

if ($TIPO=="soap") {
	ini_set("soap.wsdl_cache_enabled", "0");
  	$client = new SoapClient("../ws/bolco2010.wsdl");
	if (!$TESTE_JOGO) {
	  	$obj = $client->ObterEnvioEmail("");
  		while (isset($obj)) {
	  		$CT=1;
  			foreach($obj->parametro as $c) {
    			$C[$CT++]=$c;
	  		}
  			$enviado = enviarEmail($obj->email,$obj->assunto,$obj->template,$obj->apelido,$C);
  			if ($enviado) {
				$client->ConfirmarEnvioEmail($obj->id);
			} else {
				error_log("Erro ao enviar o e-mail para " . $obj->email . " - " . $ERR . " / SOAP," . $PROVEDOR . "," . $METODO);
			}
			$obj = $client->ObterEnvioEmail("");
		}
	}
	$obj = $client->ObterPalpites($JOGO);
	if ($DEBUG) {
		print("Objeto obtido. Len: " . count($obj));
		print_r($obj);
	}
	if (isset($obj)) {
		syslog(LOG_INFO,"Envio Palpites - Preparando para enviar emails");
		$enviado = enviarEmailJogo($obj);
		if ($enviado) {
			$assunto = "[BolCo ADM] (".$obj->jid.") Palpites enviados com sucesso ";
			mail("gustavo@apto101.com.br",$assunto,"Palpites enviados com sucesso\n".print_r($obj, true));
		} else {
			$assunto = "[BolCo ADM] (".$obj->jid.") Erro ao enviar palpites ";
			mail("gustavo@apto101.com.br",$assunto,"Erro ao enviar palpites\n".print_r($obj, true));
			syslog(LOG_INFO,"Envio Palpites - Erro ao enviar emails");
			error_log("Erro ao enviar o e-mail para o jogo " . utf8_decode($obj->jogo));
		}
	}
} else { // Tipo de conexao direto. Nao SOAP
  	$q = "SELECT e.*, p.apelido, p.email FROM enviarEmail e ";
  	$q.= "LEFT JOIN usuarios p ON p.idusu = e.ee_usuario ";
  	$q.= "WHERE e.ee_programado < CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') ";
  	$q.= "AND e.ee_enviado IS NULL AND p.ativo = 0;";

  	$res1 =& $db->query($q);
  	if (PEAR::isError($res1)) {
				die($res1->getMessage());
  	}
  	while ($res1->fetchInto($row1,DB_FETCHMODE_ASSOC)) {
  			$q = "SELECT * FROM enviarEmailCampo c where c.ec_id = '".$row1["ee_id"]."'";
  			$res2 =& $db->query($q);
  			while ($res2->fetchInto($row2)) {
    				$C[$row2[1]] = $row2[2];
  			}
  			$res2->free();
    		$enviado = enviarEmail($row1["email"],$row1["ee_assunto"],$row1["ee_template"],$row1["apelido"],$C);
    		if ($enviado) {
    				$q = "UPDATE enviarEmail e SET e.ee_enviado = CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') ";
  					$q.= "WHERE e.ee_id = '".$row1["ee_id"]."'";
  					$res2 =& $db->query($q);
  					if (PEAR::isError($res1)) {
								die($res2->getMessage());
						}
				} else {
						error_log("Erro ao enviar o e-mail para " . $row1["email"] . " - " . $ERR);
				}
				$res1->free();
		}
}
syslog(LOG_INFO,"Fim do procedimento para envio de e-mail");
?>