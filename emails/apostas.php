<?php
/*
 Parece que esse codigo nao foi utilizado em produção


*/
		$host = "localhost";
	$database = "bolco";
	$login_db = "bolco";
	$senha_db = "girafaganso";

	mysql_connect($host, $login_db, $senha_db);
	mysql_select_db($database);





$q = "SELECT * from usuarios inner join aposta on aposta.idusu = usuarios.idusu where aposta.jo_codigo = '4' and aposta.ativa = 0 order by apelido";
$rs = mysql_query($q);
		if (!$rs) {
	   		die('Could not query:' . mysql_error());
		}
$i= 0;
$email = "";
		$num = mysql_num_rows($rs);
		while ($i < $num) {	
			$nome = mysql_result($rs,$i,"apelido");
		 	$golp1 = mysql_result($rs,$i,"golp1");
			$golp2 = mysql_result($rs,$i,"golp2");
			echo $nome." - ".$golp1." X ".$golp2."<br>";
			$email .= mysql_result($rs,$i,"email").";";
		$i++;
		}
echo "<br><br>".$email;

?>