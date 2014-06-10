<?php

require_once("protecao.php");
require_once("usuario.php");

if ($_SESSION["tipo"] != "Visitante")  {
	$usuario = new Usuario($_SESSION["id"]);
}

if (isset($usuario) && isset($_GET["aceita"]) && $_GET["aceita"]=="1") {
	$usuario->aceitarRegulamento();
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>
        Regulamento - BolCó 2014
    </title>
</head>
<script language=javascript>
<!--

function troca_cor(src,nova_cor) {
    src.bgColor = nova_cor;
}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript1.2" SRC="load.js" TYPE='text/javascript'></SCRIPT>

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
<link rel="STYLESHEET" type="text/css" href="bolco.css">
   <div align="center"><BODY marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
   <table cellpadding="0" cellspacing="0" border="0" bordercolor="#ffffff" height="100%">
   <tr>
   <td background="imagens/lado_esq.jpg" width="17"></td><td width="800" valign="top">


	<?php menu();?>

   </td></tr>
   <tr>
   	<td width="800" valign="top" >

<table cellpadding="5" cellspacing="5" border="0" bordercolor="#ffffff"><tr><td>


<span class="texto">O Bolão "Rumo ao Hexa", referente à Copa do Mundo de 2014 realizada no Brasil, é uma competição de prognósticos esportivos, sem fins lucrativos, com o intuito de promover o lado psicosocioesportivo de seus participantes. As apostas serão para toda a competição da Copa do Mundo, cujos jogos já estão pré-estabelecidos pela FIFA - Fédération Internationale de Football Association - e correspondem àqueles da fase classificatória da Copa.</span><br><br>
<span class="texto">A vinculação e promoção do Bolão "Rumo ao Hexa" está sendo feita através do site: http://www.bolco.com.br . Todo e qualquer uso e divulgação é de responsabilidade única e exclusiva de seus criadores, sendo proibida cópia, execução pública e rádioteledifusão.</span><br>
<br><b class="texto">Da Inscrição</b><br><br>
<span class="texto">O apostador, após indicado pelos criadores ou por um notório, deverá se cadastrar no site citado para fazer os seus prognósticos. O pagamento será facultativo, porém a premiação se destinará apenas aos pagadores.</span><br>
<br><b class="texto">Dos Palpites</b><br><br>
<span class="texto">Os prognósticos deverão ser efetuados até 5 (cinco) minutos antes de cada partida, através do site, já inúmeras vezes citado.</span><br>
<span class="texto">A aposta de um jogador poderá ficar invisível (caso ele deseje) a outros participantes até 5 (cinco) minutos antes de cada evento futebolístico, quando será enviado um e-mail com as apostas de todos os participantes. Essa é uma forma de todos os apostadores comprovarem a integridade do BolCó 2014.</span><br>
<br><b class="texto">Da Pontuação</b><br><br>
<span class="texto">A pontuação adotada será a seguinte:</span><br>
<span class="texto">* <strong>Placar Correto</strong>: acerto integral do placar do jogo</span><br>
<span class="texto">* <strong>Vitória simples</strong>: Indicação do time vencedor e acerto somente do nº de gols do vencedor da partida</span><br>
<span class="texto">* <strong>Empate incerto</strong>: acerto do empate no jogo, mas com placar incorreto</span><br>
<span class="texto">* <strong>Derrota simples</strong>: Indicação do time vencedor e acerto somente do nº de gols do perdedor da partida</span><br>
<span class="texto">* <strong>Saldo de gols</strong>: Acerto do saldo de gols entre os dois times lembrando que o time vencedor deve coincidir</span><br>
<span class="texto">* <strong>Indicativo do vencedor</strong>: indicação do vencedor e perdedor, com desacerto do número de gols marcados por ambos</span><br>

<br><span class="texto">Em caso de empate na soma dos pontos, será nomeado vencedor o participante que tiver o maior número de acertos na seguinte ordem: placar correto, empate incerto, vitória simples, derrota simples, saldo de gols e indicativo do vencedor. Permanecendo ainda o empate o prêmio será dividido entre os dois “cagões” que conseguiram essa proeza.</span><br><br>
<div align="center">
<table class="Grupos" width="80%">
<thead>
<tr>
<td></td>
	<td><b class="texto">Fase de Grupos</td>
	<td><b class="texto">Oitavas-de-Final</td>
	<td><b class="texto">Quartas-de-Final</td>
	<td><b class="texto">Semi-Final</td>
	<td><b class="texto">Final e 3º Lugar</td>
</tr>
</thead>
<tr>
	<td><b class="texto">Placar Correto</td>
	<td><b class="texto">12</td>
	<td><b class="texto">15</td>
	<td><b class="texto">18</td>
	<td><b class="texto">20</td>
	<td><b class="texto">25</td>
</tr>
<tr>
	<td><b class="texto">Vit&oacute;ria simples</td>
	<td><b class="texto">9</td>
	<td><b class="texto">10</td>
	<td><b class="texto">12</td>
	<td><b class="texto">15</td>
	<td><b class="texto">18</td>
</tr>
<tr>
	<td><b class="texto">Empate incerto</td>
	<td><b class="texto">8</td>
	<td><b class="texto">9</td>
	<td><b class="texto">10</td>
	<td><b class="texto">13</td>
	<td><b class="texto">16</td>
</tr>
<tr>
	<td><b class="texto">Derrota simples</td>
	<td><b class="texto">7</td>
	<td><b class="texto">8</td>
	<td><b class="texto">9</td>
	<td><b class="texto">12</td>
	<td><b class="texto">15</td>
</tr>
<tr>
	<td><b class="texto">Saldo de gols</td>
	<td><b class="texto">5</td>
	<td><b class="texto">6</td>
	<td><b class="texto">7</td>
	<td><b class="texto">9</td>
	<td><b class="texto">12</td>
</tr>
<tr>
	<td><b class="texto">Indicativo do vencedor</td>
	<td><b class="texto">3</td>
	<td><b class="texto">4</td>
	<td><b class="texto">5</td>
	<td><b class="texto">7</td>
	<td><b class="texto">9</td>
</tr>
</table></div>
<br><a class="texto">Na <b>Segunda Fase</b> o resultado dos jogos ao término dos 90 minutos será considerado para efeito de pontuação, o resultado da prorrogação e da disputa de penaltis não será considerado. </a><br><br>

<br><b class="texto">Da Premiação</b><br><br>

<span class="texto">A premiação ficará condicionada ao pagamento não obrigatório da taxa de R$ 20,00 a ser feita em uma conta corrente do Banco do Brasil até as 23:59h do dia 16/06/2014. O procedimento de pagamento será devidamente explicado em um local específico do site do Bolcó (www.bolco.com.br).</span><br><br>
<span class="texto">Lembrando que toda a renda arrecadada será utilizada somente para o pagamento da premiação. Toda e qualquer tipo de doação aos criadores e administradores do site será muito bem-vinda.</span><br><br>
<span class="texto">Caso o vencedor não tenha realizado o pagamento da taxa, a premiação será destinada ao apostador pagante melhor colocado. A premiação será dividida da seguinte forma:</span><br><br>

<br><b class="texto">* 1º Colocado - 60%</b>
<br><b class="texto">* 2º Colocado - 30%</b>
<br><b class="texto">* 3º Colocado - 10%</b>

<br><br><b class="texto">Dos Participantes</b><br><br>
<a class="texto">Esta é uma competição de cunho psicosocioesportivo e voltada à integração social da família “Medeiros de Oliveira” e seus amigos.</a><br><br>
</td></tr><tr><td align="center">
<?php
if (isset($usuario) && $usuario->aceitouReg==1) {
	echo "<form method='get'>";
	echo "<input type='hidden' name='aceita' value='1' />";
	echo "<input type='submit' value='Aceitar Regulamento'/>";
	echo "</form>";
}
?>
</td></tr></table>

   </td></tr>
   <tr><td><br><div align="center" class="divRodape">2002 &copy; <a href="http://www.apto101.com.br/">Apartamento 101</a></div><br></td></tr>
</table>

  </td><td background="imagens/lado_dir.jpg" width="12"> </td>
   </tr>
   </table>

</div>
<?php include("analytics.inc"); ?><!--<?php echo $_SESSION["id"]."/".$_SESSION["Aceitou"]."/".$usuario->aceitouReg  ?> -->
   </body>
</html>
