<?php

date_default_timezone_set('America/Sao_Paulo');

$SERVIDOR = 0;

if ("/home/cetres/webapps/bolco" == $_SERVER["DOCUMENT_ROOT"]) {
	$SERVIDOR = 1;
} else if ("web72.webfaction.com" == getenv("HOSTNAME")) {
	$SERVIDOR = 1;
} else if ("STAGE" == getenv("BOLCO_ENV")) {
	$SERVIDOR = 2;
}

if ($SERVIDOR==1) {
    set_include_path(get_include_path() . PATH_SEPARATOR . "/home/cetres/lib/pear");
    //ini_set("include_path", ".:/usr/local/lib/php:/home/cetres/lib/pear");
	$dsn = 'mysql://cetres_bolco:girafaganso@localhost/cetres_bolco';
} else if ($SERVIDOR==2) {
	$dsn = null;
} else {
	$dsn = 'mysql://bolco:girafaganso@localhost/bolco';
}

require_once('DB.php');


$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);

if ($dsn) {
	$db =& DB::connect($dsn, $options);
	if (PEAR::isError($db)) {
    	error_log($db->getMessage()." / ".$db->getDebugInfo());
    	die($db->getMessage());
	}
}
$versao="3.1.0";

?>
