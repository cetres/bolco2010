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
        Regulamento - BolC� 2014
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


<span class="texto">O Bol�o "Rumo ao Hexa", referente � Copa do Mundo de 2014 realizada no Brasil, � uma competi��o de progn�sticos esportivos, sem fins lucrativos, com o intuito de promover o lado psicosocioesportivo de seus participantes. As apostas ser�o para toda a competi��o da Copa do Mundo, cujos jogos j� est�o pr�-estabelecidos pela FIFA - F�d�ration Internationale de Football Association - e correspondem �queles da fase classificat�ria da Copa.</span><br><br>
<span class="texto">A vincula��o e promo��o do Bol�o "Rumo ao Hexa" est� sendo feita atrav�s do site: http://www.bolco.com.br . Todo e qualquer uso e divulga��o � de responsabilidade �nica e exclusiva de seus criadores, sendo proibida c�pia, execu��o p�blica e r�dioteledifus�o.</span><br>
<br><b class="texto">Da Inscri��o</b><br><br>
<span class="texto">O apostador, ap�s indicado pelos criadores ou por um not�rio, dever� se cadastrar no site citado para fazer os seus progn�sticos. O pagamento ser� facultativo, por�m a premia��o se destinar� apenas aos pagadores.</span><br>
<br><b class="texto">Dos Palpites</b><br><br>
<span class="texto">Os progn�sticos dever�o ser efetuados at� 5 (cinco) minutos antes de cada partida, atrav�s do site, j� in�meras vezes citado.</span><br>
<span class="texto">A aposta de um jogador poder� ficar invis�vel (caso ele deseje) a outros participantes at� 5 (cinco) minutos antes de cada evento futebol�stico, quando ser� enviado um e-mail com as apostas de todos os participantes. Essa � uma forma de todos os apostadores comprovarem a integridade do BolC� 2014.</span><br>
<br><b class="texto">Da Pontua��o</b><br><br>
<span class="texto">A pontua��o adotada ser� a seguinte:</span><br>
<span class="texto">* <strong>Placar Correto</strong>: acerto integral do placar do jogo</span><br>
<span class="texto">* <strong>Vit�ria simples</strong>: Indica��o do time vencedor e acerto somente do n� de gols do vencedor da partida</span><br>
<span class="texto">* <strong>Empate incerto</strong>: acerto do empate no jogo, mas com placar incorreto</span><br>
<span class="texto">* <strong>Derrota simples</strong>: Indica��o do time vencedor e acerto somente do n� de gols do perdedor da partida</span><br>
<span class="texto">* <strong>Saldo de gols</strong>: Acerto do saldo de gols entre os dois times lembrando que o time vencedor deve coincidir</span><br>
<span class="texto">* <strong>Indicativo do vencedor</strong>: indica��o do vencedor e perdedor, com desacerto do n�mero de gols marcados por ambos</span><br>

<br><span class="texto">Em caso de empate na soma dos pontos, ser� nomeado vencedor o participante que tiver o maior n�mero de acertos na seguinte ordem: placar correto, empate incerto, vit�ria simples, derrota simples, saldo de gols e indicativo do vencedor. Permanecendo ainda o empate o pr�mio ser� dividido entre os dois �cag�es� que conseguiram essa proeza.</span><br><br>
<div align="center">
<table class="Grupos" width="80%">
<thead>
<tr>
<td></td>
	<td><b class="texto">Fase de Grupos</td>
	<td><b class="texto">Oitavas-de-Final</td>
	<td><b class="texto">Quartas-de-Final</td>
	<td><b class="texto">Semi-Final</td>
	<td><b class="texto">Final e 3� Lugar</td>
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
<br><a class="texto">Na <b>Segunda Fase</b> o resultado dos jogos ao t�rmino dos 90 minutos ser� considerado para efeito de pontua��o, o resultado da prorroga��o e da disputa de penaltis n�o ser� considerado. </a><br><br>

<br><b class="texto">Da Premia��o</b><br><br>

<span class="texto">A premia��o ficar� condicionada ao pagamento n�o obrigat�rio da taxa de R$ 20,00 a ser feita em uma conta corrente do Banco do Brasil at� as 23:59h do dia 16/06/2014. O procedimento de pagamento ser� devidamente explicado em um local espec�fico do site do Bolc� (www.bolco.com.br).</span><br><br>
<span class="texto">Lembrando que toda a renda arrecadada ser� utilizada somente para o pagamento da premia��o. Toda e qualquer tipo de doa��o aos criadores e administradores do site ser� muito bem-vinda.</span><br><br>
<span class="texto">Caso o vencedor n�o tenha realizado o pagamento da taxa, a premia��o ser� destinada ao apostador pagante melhor colocado. A premia��o ser� dividida da seguinte forma:</span><br><br>

<br><b class="texto">* 1� Colocado - 60%</b>
<br><b class="texto">* 2� Colocado - 30%</b>
<br><b class="texto">* 3� Colocado - 10%</b>

<br><br><b class="texto">Dos Participantes</b><br><br>
<a class="texto">Esta � uma competi��o de cunho psicosocioesportivo e voltada � integra��o social da fam�lia �Medeiros de Oliveira� e seus amigos.</a><br><br>
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
