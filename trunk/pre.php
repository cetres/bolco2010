<?php

$SERVIDOR = 0;

if ($_SERVER["DOCUMENT_ROOT"] == "/home/cetres/webapps/bolco") {
  $SERVIDOR = 1;
}

if ($SERVIDOR==1) {
    set_include_path(get_include_path() . PATH_SEPARATOR . "/home/cetres/lib/pear");
    //ini_set("include_path", ".:/usr/local/lib/php:/home/cetres/lib/pear");
	$dsn = 'mysql://cetres_bolco:girafaganso@localhost/cetres_bolco';
} else {
	$dsn = 'mysql://bolco:girafaganso@localhost/bolco';
}

require_once('DB.php');


$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);

$db =& DB::connect($dsn, $options);
if (PEAR::isError($db)) {
    error_log($sth->getMessage()." / ".$res->getDebugInfo());
    die($db->getMessage());
}

date_default_timezone_set('America/Sao_Paulo');

$versao="3.0.0";

?>
