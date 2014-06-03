<?php
require_once("../protecao.php");
require_once("colocacao.php");
global $database;
global $host;
global $login_db;
global $senha_db;

// ALTER TABLE resultados ADD COLUMN colocacao INTEGER UNSIGNED AFTER pontos;

if ($_SESSION["tipo"] != "admin")  {
echo "<script>window.open('./index.php', '_self');</script>";
}
$ida = "";
$idusu =  $_SESSION["id"];
if (isset($_POST["idjogo"])) {
	$ida = $_POST["idjogo"];
}
$time1 = "";
$time2 = "";
$local = "";

if (isset($_GET['acao'])) {
		$acao = $_GET['acao'];

		if ($acao == "U") {
			$golt1 = ($_POST["time1"]);
			$golt2 = ($_POST["time2"]);
			if ($golt1 > $golt2) {
				$pt1 = "3";
				$pt2 = "0";
			} elseif ($golt1 < $golt2) {
				$pt1 = "0";
				$pt2 = "3";
			} else {
				$pt1 = "1";
				$pt2 = "1";
			}

			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("delete  from resultados where jo_codigo = '$ida'") or die(mysql_error());
			$q = "update jogos set jo_result_golp1 = '$golt1', jo_result_golp2 = '$golt2', jo_time1_pt = '$pt1' , jo_time2_pt = '$pt2' where jo_codigo = '$ida' ";
			//echo $q;
			$rs = mysql_query($q);
			if (!$rs) {
   				die('Could not query:' . mysql_error());
			}
			$msg = "Dados Alterados com sucesso com sucesso.";
			$q = "select * from aposta inner join jogos on aposta.jo_codigo = jogos.jo_codigo where ativa = 0 and aposta.jo_codigo = '$ida' ";
			$rs = mysql_query($q);
			if (!$rs) {
				die('Could not query:' . mysql_error());
			}
			$i = 0;
			$numA = mysql_num_rows($rs);
			while ($i < $numA) {
				$idusuAp = mysql_result($rs,$i,"idusu");
				$golp1 = mysql_result($rs,$i,"golp1");
				$golp2 = mysql_result($rs,$i,"golp2");
				$fase =  mysql_result($rs,$i,"jo_fase");
				//Resultado_Aposta($golp1,$golp2,$golt1,$golt2)
				//echo $fase;
				// Testa se Acertou o Resultado
				if ( (($golp1 > $golp2) && ($golt1 > $golt2)) || (($golp1 < $golp2) && ($golt1 < $golt2)) ) {
				//Acertou o vitorioso
					if (($golp1 == $golt1) && ($golt2 == $golp2)) {

						 $Acerto = "A";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "25";
						} elseif ($fase == "Semi-Final") {
						 $pt = "20";
						} elseif ($fase == "Quarta") {
						 $pt = "18";
						} elseif ($fase == "Oitava") {
						 $pt = "15";
						} else {
						 $pt = "12";
						}
                   //Vitória simples
					} elseif ( (($golp1 > $golp2) && ($golp1 == $golt1)) || (($golp2 > $golp1) && ($golp2 == $golt2)) ) {
						$Acerto = "C";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "18";
						} elseif ($fase == "Semi-Final") {
						 $pt = "15";
						} elseif ($fase == "Quarta") {
						 $pt = "12";
						} elseif ($fase == "Oitava") {
						 $pt = "10";
						} else {
						 $pt = "9";
						}
                    // Derrota Simples
					} elseif ( (($golp1 > $golp2) && ($golp2 == $golt2)) || (($golp2 > $golp1) && ($golp1 == $golt1)) ) {
						$Acerto = "D";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "15";
						} elseif ($fase == "Semi-Final") {
						 $pt = "12";
						} elseif ($fase == "Quarta") {
						 $pt = "9";
						} elseif ($fase == "Oitava") {
						 $pt = "8";
						} else {
						 $pt = "7";
						}
					//Saldo de gols
					} elseif ($golp1 - $golp2 == $golt1 - $golt2)  {
						$Acerto = "E";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "12";
						} elseif ($fase == "Semi-Final") {
						 $pt = "9";
						} elseif ($fase == "Quarta") {
						 $pt = "7";
						} elseif ($fase == "Oitava") {
						 $pt = "6";
						} else {
						 $pt = "5";
						}
                    //Indicativo de Vencedor
					} else {
						 $Acerto = "F";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "9";
						} elseif ($fase == "Semi-Final") {
						 $pt = "7";
						} elseif ($fase == "Quarta") {
						 $pt = "5";
						} elseif ($fase == "Oitava") {
						 $pt = "4";
						} else {
						 $pt = "3";
						}
					}

					mysql_query("INSERT INTO resultados (idusu, jo_codigo, Acerto, pontos) VALUES ('$idusuAp', '$ida', '$Acerto', '$pt')") or die(mysql_error());

				} elseif (($golp1 == $golp2) && ($golt1 == $golt2)) {
				//Acertou o empate
					// acerto exato
					if ($golp1 == $golt1) {
						 $Acerto = "A";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "25";
						} elseif ($fase == "Semi-Final") {
						 $pt = "20";
						} elseif ($fase == "Quarta") {
						 $pt = "18";
						} elseif ($fase == "Oitava") {
						 $pt = "15";
						} else {
						 $pt = "12";
						}
					// empate incerto
					} else {
						 $Acerto = "B";
						if (($fase == "Final") || ($fase == "3º Lugar")) {
						 $pt = "16";
						} elseif ($fase == "Semi-Final") {
						 $pt = "13";
						} elseif ($fase == "Quarta") {
						 $pt = "10";
						} elseif ($fase == "Oitava") {
						 $pt = "9";
						} else {
						 $pt = "8";
						}
					}
					mysql_query("INSERT INTO resultados (idusu, jo_codigo, Acerto, pontos) VALUES ('$idusuAp', '$ida', '$Acerto', '$pt')") or die(mysql_error());

				} else {
				//errou
				mysql_query("INSERT INTO resultados (idusu, jo_codigo, Acerto, pontos) VALUES ('$idusuAp', '$ida', 'X', 0)") or die(mysql_error());

				}

			$i++;
			}


			inserirColocacoes($ida);



			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Cadastro de reultado de jogos', '$idusu', 'Cadastro admin - jogo: $ida ',LOCALTIME()  )") or die(mysql_error());
			$q = "select idusu from usuarios where email = '$email'";
			$rs = mysql_query($q);
			$ida = mysql_result($rs,0,"idusu");


		}	elseif ($acao == "C") {
		// ANULA RESULTADO
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			$q = "update jogos set jo_result_golp1 = null, jo_result_golp2 = null where jo_codigo = '$ida' ";
			//echo $q;
			$rs = mysql_query($q);
			if (!$rs) {
   				die('Could not query:' . mysql_error());
			}
			$msg = "Dados Alterados com sucesso com sucesso.";
			mysql_connect($host, $login_db, $senha_db);
			mysql_select_db($database);
			mysql_query("INSERT INTO logbolco (lo_tipo, lo_usuario, lo_desc, lo_data) VALUES ('Cadastro de reultado de jogos', '$idusu', 'Cadastro admin - Cancelamento - jogo: $ida ',LOCALTIME()  )") or die(mysql_error());
			mysql_query("delete  from resultados where jo_codigo = '$ida'") or die(mysql_error());

		}
$ida = "";

} elseif (isset($ida)) {

		mysql_connect($host, $login_db, $senha_db);
		mysql_select_db($database);
		$q = "SELECT * FROM jogos inner join $database.paises p1 on p1.idpaises = jo_time1 inner join $database.estadio est on est.idestadio = jo_estadio inner join $database.paises p2 on p2.idpaises = jo_time2 where jo_codigo = '$ida' order by jo_hora";
		$rs = mysql_query($q);
		if (!$rs) {
			die('Could not query:' . mysql_error());
		}
		if(mysql_num_rows($rs) == 1){
			$time1 = mysql_result($rs,0,"p1.nome");
			$time2 = mysql_result($rs,0,"p2.nome");
			$goltime1 = mysql_result($rs,0,"jo_result_golp1");
			$goltime2 = mysql_result($rs,0,"jo_result_golp2");
			$local = mysql_result($rs,0,"jo_hora");
		}

}

function Resultado_Aposta($golp1,$golp2,$golt1,$golt2) {

}
?>
<html>
<head>
    <title>
        Bolco 2014
    </title>
</head>
<script language=javascript>
<!--

function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}
//-->
<?php if ($msg != "") { ?>
alert("<?php echo $msg; ?>");
<?php }?>
</script>


<style>
BODY {
scrollbar-3d-light-color:#C7AE52;
scrollbar-arrow-color:#34317D;
scrollbar-base-color:#ffffff;
scrollbar-dark-shadow-color:#34317D;
scrollbar-face-color:#EFEFEF;
scrollbar-highlight-color:#D6D7D6;
scrollbar-shadow-color:#D6D7D6}
</style>
<link rel="STYLESHEET" type="text/css" href="../bolco.css">
   <div align="center"><BODY marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
<h1 class="tit">Resultados</h1><br><br>
<font class="texto">Administra&ccedil;&atilde;o de Resultados</font><br><br>
<table width="70%">
<form name="FormComent"  action="resultados.php" method="Post">
<tr valign="top" align="left">
<td><a class="rodape">:.</a>&nbsp;<a class="texto">Jogo</a>&nbsp;<a class="rodape">.: *</a></td>
<td>
  <select name="idjogo" size=1 onChange="FormComent.submit();">


<?php if ($ida == "") { ?>
  <option value=''>Time1 X Time2 - Data</option>

<?php } else {
echo "<option value='$ida'>$time1 X- $time2 - $local</option> "; ?>

<?php }  ?>

<?php
mysql_connect($host, $login_db, $senha_db);
mysql_select_db($database);
$q = "SELECT * FROM jogos inner join $database.paises p1 on p1.idpaises = jo_time1 inner join $database.estadio est on est.idestadio = jo_estadio inner join $database.paises p2 on p2.idpaises = jo_time2  order by jo_hora";
$rs = mysql_query($q);
$i = 0;
	$num = mysql_num_rows($rs);
	while ($i < $num) {
		printf ("<option value='".mysql_result($rs,$i,"jo_codigo")."'>".mysql_result($rs,$i,"p1.nome")." X  ".mysql_result($rs,$i,"p2.nome")." / ".mysql_result($rs,$i,"jo_hora")."</option>");
	$i++;
	}
?></select>
<br></td>
</tr>

<?php if ($ida != "") { ?>
<tr valign="top" align="left">
<td></td><td colspan="1">
<a class="texto"><?php echo $time1; ?></a>
<input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="time1" size="5" value="<?php echo $goltime1; ?>">
<a class="rodape"> X </a>&nbsp;
<input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="time2" size="5" value="<?php echo $goltime2; ?>">
<a class="texto"><?php echo $time2; ?></a>
</td>
</tr>
<?php } ?>

<tr valign="top">
<td></td>

<td>
<?php if ($ida != "") {  ?>

<input type="submit" value="Atualizar Resultado" name="2" onClick="javascript: FormComent.action='resultados.php?acao=U&id=<?php echo $ida; ?>';" >
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Cancelar Resultado" name="2" onClick="javascript: FormComent.action='resultados.php?acao=C&id=<?php echo $ida; ?>';" >


<?php }   ?>

</td>
</tr>
</table><br>
 </form>
</div><center><input type="button" value="Voltar ao menu" onClick="window.location='/admin/'"/></center>
   </body>
</html>
