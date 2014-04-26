<?php

ini_set("soap.wsdl_cache_enabled", "1");
require_once("../pre.php");

function ObterEnvioEmail($data) {
	  global $db;
		$q = "SELECT e.*, p.apelido, p.email FROM enviarEmail e ";
  	$q.= "LEFT JOIN usuarios p ON p.idusu = e.ee_usuario ";
  	$q.= "WHERE e.ee_programado < CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') ";
  	$q.= "AND e.ee_enviado IS NULL AND p.ativo = 0 LIMIT 1;";
    $res =& $db->query($q);
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
	  	die($res->getMessage());
    }
  	if ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
  		$r["id"]=$row["ee_id"];
        $r["idusu"]=$row["ee_usuario"];
        $r["email"]=$row["email"];
        $r["assunto"]=$row["ee_assunto"];
		$r["template"]=$row["ee_template"];
		$r["apelido"]=utf8_encode($row["apelido"]);
  		$q = "SELECT ec_valor FROM enviarEmailCampo c where c.ec_id = ? ORDER BY ec_num";
  		$res =& $db->query($q,$row["ee_id"]);
  		$r["parametro"]=array();
  		while ($res->fetchInto($row)) {
    		array_push($r["parametro"],utf8_encode($row[0]));
  		}
  		$res->free();
  	}
    return $r;
}

function ConfirmarEnvioEmail($id) {
	  global $db;
    $q ="UPDATE enviarEmail SET ee_enviado=CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-03:00') ";
    $q.="WHERE ee_enviado IS NULL AND ee_id=?";
    $res =& $db->query($q,intval($id));
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
	  	die($res->getMessage());
    }
    return 0;
}

$server = new SoapServer("../ws/bolco2010.wsdl");
#$server->setClass("Bolco");
$server->addFunction("ObterEnvioEmail");
$server->addFunction("ConfirmarEnvioEmail");
$server->handle();

?>