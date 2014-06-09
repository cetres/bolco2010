function resultados() {

	$host = "localhost";
	$database = "bolco";
	$login_db = "bolco";
	$senha_db = "girafaganso";
	global $database;
	global $host;
	global $login_db;
	global $senha_db;

	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);
/*
	$q = "SELECT jo_codigo from jogos where jo_result_golp1 is not NULL order by jo_hora desc, jogos.jo_codigo desc";
	$rs = mysql_query($q);
	//echo mysql_result($rs,0,"jo_codigo");
	//echo mysql_num_rows($rs);
if(mysql_num_rows($rs) >= 1){
	$ultimoJogo = mysql_result($rs,0,"jo_codigo");	
} else {
	$ultimoJogo = 0;
}
*/
//echo $ultimoJogo;
	$q = <<< EOL
SELECT r.idusu, u.apelido nome, u.quemchamou idchamador,
SUM(IF(r.Acerto='A',1,0)) a,
SUM(IF(r.Acerto='B',1,0)) b,
SUM(IF(r.Acerto='C',1,0)) c,
SUM(IF(r.Acerto='D',1,0)) d,
SUM(IF(r.Acerto='E',1,0)) e,
SUM(IF(r.Acerto='F',1,0)) f,
sum(r.pontos) pts 
FROM usuarios u 
left outer join resultados r on r.idusu=u.idusu 
left outer join jogos j on r.jo_codigo = j.jo_codigo 
WHERE
u.tipo not in ('Visitante','Convidado') AND u.aceitouReg = 0 AND u.ativo = 0 AND u.apelido <> '' AND
j.jo_hora < (SELECT MAX(d.jo_hora) FROM jogos d WHERE d.jo_result_golp1 is not NULL)
group by r.idusu
order by pts desc, A desc, B desc, C desc, D desc, E desc, F desc;
EOL;
/*
	$q = "SELECT u.idusu idusu, u.apelido nome, u.quemchamou idchamador";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'A' and jo_codigo <> '$ultimoJogo') as A";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'B' and jo_codigo <> '$ultimoJogo') as B";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'C' and jo_codigo <> '$ultimoJogo') as C";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'D' and jo_codigo <> '$ultimoJogo') as D";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'E' and jo_codigo <> '$ultimoJogo') as E";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'F' and jo_codigo <> '$ultimoJogo') as F";
	$q .= ", (select count(*) from resultados r where u.idusu = r.idusu and jo_codigo <> '$ultimoJogo')  as jogos";
	$q .= ", (select sum(pontos) from resultados r where u.idusu = r.idusu and jo_codigo <> '$ultimoJogo') as pontos";
	$q .= " from usuarios u";
    	$q .= " where u.tipo not in ('Visitante','Convidado') and u.aceitouReg = 0 and u.ativo = 0 and u.apelido <> '' ";
	$q .= " order by IF(ISNULL(pontos),1,0),pontos desc, A desc, B desc, C desc, D desc, E desc, F desc, u.apelido;";
*/
	//echo $q;

	$rs = mysql_query($q);
	if (!$rs) {
	 	 die('Could not query:' . mysql_error());
	}
	$numA = mysql_num_rows($rs);
	$c = 0;
	//echo $q;
	$usuarios =  array();
	$posicaoAnt =  array();
	$pos=0;
	$pontuacaoAnterior="";
	while ($c < $numA) {
		$pontuacao=mysql_result($rs,$c,"a").mysql_result($rs,$c,"b").mysql_result($rs,$c,"c").mysql_result($rs,$c,"d").mysql_result($rs,$c,"e").mysql_result($rs,$c,"f");
		$usuarios[$c] = mysql_result($rs,$c,"idusu");	
		$pos++;
		if ($pontuacao!=$pontuacaoAnterior) {
			$posAnt=$pos;
			$pontuacaoAnterior=$pontuacao;
		}
		$posicaoAnt[$c] = $posAnt;
		//echo 	mysql_result($rs,$c,"nome")." - ".$posicaoAnt[$c]." - ".mysql_result($rs,$c,"pontos")."<br>";
		if (mysql_result($rs,$c,"idusu")==$_SESSION["id"]) {
			$idChamador=mysql_result($rs,$c,"idchamador");
		}
	    $c++;
	}

	$USUSEM="select distinct(u.idusu),u.apelido, u.email from usuarios u left join aposta a on u.idusu=a.idusu and jo_codigo=49 where ativo=0 and apelido <>'' and idaposta is null and apelido <> 'visitante';";
	
    global $db;
	$idusu =  $_SESSION["id"];
/*
	$q = <<< EOL
SELECT u.idusu idusu, u.apelido apelido, u.nome nome, c.apelido chamador, u.pago pago, u.quemchamou idchamador, u.tipo tipo
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'A') as A
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'B') as B
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'C') as C
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'D') as D
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'E') as E
, (select count(*) from resultados r where u.idusu = r.idusu and Acerto = 'F') as F
, (select count(*) from resultados r where u.idusu = r.idusu) as jogos
, (select sum(pontos) from resultados r where u.idusu = r.idusu) as pontos
from usuarios u
left join usuarios c on u.quemchamou = c.idusu and u.tipo='usuario'
where u.tipo not in ('Visitante','Convidado') and u.aceitouReg = 0 and u.ativo = 0 and u.apelido <> ''
order by IF(ISNULL(pontos),1,0),pontos desc, A desc, B desc, C desc, D desc, E desc, F desc, u.apelido;
EOL;
*/
	$q = <<< EOL
SELECT r.idusu, u.apelido apelido, u.quemchamou idchamador, c.apelido chamador, u.pago pago, u.tipo tipo,
SUM(IF(r.Acerto='A',1,0)) a,
SUM(IF(r.Acerto='B',1,0)) b,
SUM(IF(r.Acerto='C',1,0)) c,
SUM(IF(r.Acerto='D',1,0)) d,
SUM(IF(r.Acerto='E',1,0)) e,
SUM(IF(r.Acerto='F',1,0)) f,
COUNT(r.idusu) jogos,
SUM(r.pontos) pontos FROM resultados r, jogos j, usuarios u
left join usuarios c on u.quemchamou = c.idusu and u.tipo='usuario'
WHERE
r.idusu=u.idusu AND u.tipo not in ('Visitante','Convidado') AND u.aceitouReg = 0 AND u.ativo = 0 AND u.apelido <> '' AND
r.jo_codigo = j.jo_codigo 
group by r.idusu
order by pontos desc, A desc, B desc, C desc, D desc, E desc, F desc;
EOL;

	$res =& $db->query($q);
    if (PEAR::isError($res)) {
		error_log($res->getMessage()." / ".$res->getDebugInfo());
		die($res->getMessage());
	}
	$i = 0;
	//$msg = $ultimoJogo."<br>";
	printf ("<table  class='grupos'  width='95%%'>");
	printf ("<thead><tr><td colspan='13'><b class='texto'>Classifica&ccedil;&atilde;o Geral</b></td></tr>");
	printf ("<tr>");
	printf ("<td nowrap colspan='1' width='4%%'></td>");
	printf ("<td nowrap colspan='1' width='28%%'><b class='texto'>Bocs</b></td>");
	printf ("<td nowrap colspan='1' width='10%%'><b class='texto'>Boc-mor</b></td>");
	printf ("<td nowrap colspan='1' width='5%%'><b class='texto'>Pago</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>A</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>B</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>C</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>D</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>E</b></td>");
	printf ("<td nowrap colspan='1' width='4%%'><b class='texto'>F</b></td>");
	printf ("<td nowrap colspan='1' width='8%%'><b class='texto'>Jogos</b></td>");
	printf ("<td nowrap colspan='1' width='8%%'><b class='texto'>Pontos</b></td>");
	printf ("<td nowrap colspan='1' width='5%%'><b class='texto'>-</b></td>");
	printf ("</tr></thead>");

	$pos=0;
	$posAnt='';
	$pontuacaoAnterior="";
	while ($res->fetchInto($row,DB_FETCHMODE_ASSOC)) {
		$pontuacao=$row["a"].$row["b"].$row["c"].$row["d"].$row["e"].$row["f"];
		$pos++;
		if ($pontuacao!=$pontuacaoAnterior) {
			$posAnt=$pos;
			$pontuacaoAnterior=$pontuacao;
		}
		$posicaoExibir = ($posAnt==$pos)?$pos:"";
		$classeLinha = "";
		if ($row["idusu"]==$_SESSION["id"]) {
			$classeLinha = "meuResultado";
		} elseif(($_SESSION["tipo"]=='notorio')||($_SESSION["tipo"]=='admin')) {
			if (($row["idchamador"]==$_SESSION["id"])&&($row["tipo"]=='usuario')) {
				$classeLinha = "amigoResultado";
			} elseif (($row["tipo"]=='notorio')||($row["tipo"]=='admin')) {
				$classeLinha = "notorio";
			}
		} elseif(($_SESSION["tipo"]=='usuario')&&($row["idusu"]==$idChamador)) {
			$classeLinha = "amigoResultado";
	    } elseif($row["tipo"]=='usuario') {
			if ($row["idchamador"]==$idChamador) {
				$classeLinha = "amigoResultado";
			}
			
		}
		printf ("<tr class='".$classeLinha."'>");
		printf ("<td class='texto'>".$posicaoExibir."</td>");
		$CARTAO_AMARELO='';
		//if ($row["idusu"] == "206") {
		//	$CARTAO_AMARELO = " &nbsp; <img src='imagens/cartaoAmarelo.png' border='0' width=6 height=10 alt='C.A.' title='Cartao Amarelo' style='display:inline'>";
		//} 
		printf ("<td onclick='irresultado(".$row["idusu"].")' class='link_jogo' nowrap><b><a class='texto' href='mresultados.php?us=".$row["idusu"]."'>".$row["apelido"].$CARTAO_AMARELO."</a></b></td>");
		printf ("<td><a class='texto'>".$row["chamador"]."</a></td>");
		if (intval($row["pago"]) > 0) {
			printf ("<td><a class='texto'>Sim</a></td>");
		} else {
			printf ("<td><a class='texto' style='color:#C20000'>N&atilde;o</a></td>");
		}
		if ($row["jogos"] > 0) {
			$Media = ($row["pontos"] / $row["jogos"]);
		} else {
			$Media = "";	
		}
		printf ("<td><a class='texto'>".$row["a"]."</a></td>");
		printf ("<td><a class='texto'>".$row["b"]."</a></td>");
		printf ("<td><a class='texto'>".$row["c"]."</a></td>");
		printf ("<td><a class='texto'>".$row["d"]."</a></td>");
		printf ("<td><a class='texto'>".$row["e"]."</a></td>");
		printf ("<td><a class='texto'>".$row["f"]."</a></td>");
		printf ("<td><a class='texto'>".$row["jogos"]."</a></td>");
		printf ("<td><a class='texto'>".$row["pontos"]."</a></td>");
		//comparando posicao anterior
//		$row["idusu"]
		$cont = 0;
		for ($cont = 0; $cont < $c; $cont++) {
			if ($row["idusu"] == $usuarios[$cont]) {
				if ($posAnt < $posicaoAnt[$cont]) {
					printf ("<td nowrap><a class='texto'><img src='imagens/grp_up.gif' width='11' height='13' border='0'' alt=''>+".($posicaoAnt[$cont]-$posAnt)."</a></td>");
				} elseif ($posAnt > $posicaoAnt[$cont]) {
					printf ("<td nowrap><a class='texto'><img src='imagens/grp_down.gif' width='11' height='13' border='0'' alt=''>-".($posAnt-$posicaoAnt[$cont])."</a></td>");
				}	else {
					printf ("<td nowrap><a class='texto'><img src='imagens/grp_nul.gif' width='11' height='13' border='0'' alt=''></a></td>");
				}

			}
    		}
	printf ("</tr>");
	$i++;
	}
	printf ("</table>");
	//printf ($msg);

}
