<?php

ini_set("soap.wsdl_cache_enabled", "0");
require_once("../pre.php");

$TESTE_JOGO=false;

function ObterPalpites($jid) {
	global $db;
	error_log("Iniciando pesquisa de palpites - " . $jid);
	$TEMPLATE='envioJogo';
	$q = <<< EOL
SELECT j.jo_codigo jid, p1.nome pn1, p2.nome pn2, j.jo_hora hora, j.jo_fase fase
FROM jogos j 
  LEFT JOIN paises p1 ON p1.idpaises = j.jo_time1 
  LEFT JOIN paises p2 ON p2.idpaises = j.jo_time2
  LEFT JOIN enviarEmail e ON j.jo_codigo = e.ee_usuario AND e.ee_template = ?
WHERE e.ee_id is NULL AND 
SUBDATE(jo_hora, INTERVAL 5 minute) < CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00')
EOL;
    if (intval($jid) > 0) {
		$q.="AND j.jo_codigo=?";
		$res =& $db->query($q,array($TEMPLATE,intval($jid)));
	} else {
		$res =& $db->query($q,$TEMPLATE);
	}
    
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
	  	die($res->getMessage());
    }
	if (!$res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		die("");	
	}
	error_log("Envio de palpite se preparando para enviar jogo ".$row["jid"]);
	$jid = $row["jid"];
	$r["jid"]=$row["jid"];
	$r["jogo"]=utf8_encode($row["pn1"]." X ".$row["pn2"]);
	$r["hora"]=$row["hora"];

	$res->free();
	$q = <<< EOL
SELECT u.idusu idusu, u.apelido apelido, a.golp1 gp1, a.golp2 gp2 
FROM aposta a, usuarios u 
WHERE a.idusu = u.idusu AND 
a.ativa = 0 AND 
a.jo_codigo = ? AND
u.ativo = 0
ORDER BY u.apelido
EOL;
    $res =& $db->query($q,intval($jid));
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
	  	die($res->getMessage());
    }
	$r["palpite"] = array();
	while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		$cod = sprintf("%03d - ",$row["idusu"]);
		$linha = $cod.$row["apelido"].str_repeat(" ", 40 - strlen($row["apelido"]))." ".$row["gp1"]." x ".$row["gp2"]."\n";
		array_push($r["palpite"],utf8_encode($linha));
  	}
	$r["quantidade"]=count($r["palpite"]);
	$res->free();
	
		$q = <<< EOL
SELECT email
FROM usuarios
WHERE receberPalpites = 0 AND
ativo=0 AND 
email <> "Visitante" AND 
apelido <> ""
EOL;
    $res =& $db->query($q);
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
	  	die($res->getMessage());
    }
	$r["email"] = array();
	while ($res->fetchInto($row)) {
		array_push($r["email"],$row[0]);
	}
	$res->free();
	if (intval($jid) == 0) {
		$q = <<< EOL
INSERT INTO enviarEmail (ee_usuario,ee_template,ee_programado,ee_enviado) 
VALUES (?,?,CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'),CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00'));
EOL;
		$res =& $db->query($q,array($jid,$TEMPLATE));
		if (PEAR::isError($res)) {
			error_log($res->getMessage()." / ".$res->getDebugInfo());
			die($res->getMessage());
		}
		error_log("Envio de palpite enviando jogo");
	} else {
		error_log("Teste do jogo " . $jid);
	}
	return $r;
}

$server = new SoapServer("../ws/bolco2010.wsdl");
$server->addFunction("ObterPalpites");
$server->handle();

?>