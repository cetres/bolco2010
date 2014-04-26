<?php
require_once("../pre.php");

function inserirColocacoes($jid) {
	global $db;	
	$q = <<< EOL
SELECT idusu,
SUM(IF(Acerto='A',1,0)) a,
SUM(IF(Acerto='B',1,0)) b,
SUM(IF(Acerto='C',1,0)) c,
SUM(IF(Acerto='D',1,0)) d,
SUM(IF(Acerto='E',1,0)) e,
SUM(IF(Acerto='F',1,0)) f,
sum(pontos) pts FROM resultados r, jogos j
WHERE
r.jo_codigo = j.jo_codigo AND
(j.jo_hora < (SELECT jo_hora FROM jogos d WHERE d.jo_codigo=?) OR
(j.jo_hora = (SELECT jo_hora FROM jogos d WHERE d.jo_codigo=?) AND j.jo_codigo <= ?))
group by idusu
order by pts desc, A desc, B desc, C desc, D desc, E desc, F desc;
EOL;
	$res =& $db->query($q,array($jid,$jid,$jid));
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	}
	$pos=0;
	$posAnt='';
	$pontuacaoAnterior="";
	$sth=$db->prepare("UPDATE resultados SET colocacao=? WHERE idusu=? AND jo_codigo=?");
	while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		$pontuacao=$row["a"].$row["b"].$row["c"].$row["d"].$row["e"].$row["f"];
		$pos++;
		if ($pontuacao!=$pontuacaoAnterior) {
			$posAnt=$pos;
			$pontuacaoAnterior=$pontuacao;
		}
		$atu = $db->execute($sth, array($posAnt,$row["idusu"],$jid));
		if (PEAR::isError($atu)) {
			error_log($atu->getMessage()." / ".$atu->getDebugInfo());
		  	die($atu->getMessage());
	    }
	}
	
}

/*
inserirColocacoes(1);
inserirColocacoes(2);
inserirColocacoes(4);
inserirColocacoes(3);
inserirColocacoes(5);
inserirColocacoes(6);
inserirColocacoes(8);
inserirColocacoes(7);
inserirColocacoes(9);
inserirColocacoes(10);
inserirColocacoes(11);
inserirColocacoes(12);
inserirColocacoes(13);
*/

if (isset($_GET["col_jid"])) {
	require_once("../protecao.php");
	if ($_SESSION["tipo"] != "admin")  {
  		header("Location: /");
  		exit;
	}
	$jid = intval($_GET["col_jid"]);
	inserirColocacoes($jid);
}


?>