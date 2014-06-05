<?php
require_once("protecao.php");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>BolC&oacute; 2014</title>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>
<script language=javascript>
<!--
$(document).ready(function() {
  proxJogo = new Date(2010,5,11,11,0,0);
  $('#proxJogo').countdown({until: proxJogo, format: 'dHMS'});
});
//-->
</script>
<script language="JavaScript1.2" SRC="load.js" TYPE='text/javascript'></SCRIPT>
<style type="text/css">
@import "jquery.countdown.css";
</style>
<link rel="stylesheet" type="text/css" href="bolco.css" />
</head>
<body marginheight="0" marginwidth="0" rightmargin="0" leftmargin="0" topmargin="0" bgcolor="#ffffff" >
<div align="center">
  <table cellpadding="0" cellspacing="0" border="0" bordercolor="#ffffff">
    <tr>
      <td background="imagens/lado_esq.jpg" width="17"></td>
      <td width="800" valign="top"><?php menu2();?></td>
    </tr>
      <tr>
      <td width="800" valign="top" >

    <table cellpadding="5" cellspacing="5" border="0" bordercolor="#ffffff">
        <tr>

        <td width="35%" valign="top" align="center" >

      <table bordercolor="#ffffff"  cellpadding="0"  cellspacing="0">
        <tr>
          <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
        </tr>
        <tr>
          <td colspan="1" width="1" bgcolor="#1c5e29" ></td>
          <td height="250" align="justify">
          <a class="twitter-timeline" href="https://twitter.com/search?q=%23bolco" data-widget-id="474377679664193536">Tweets sobre "#bolco"</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


   
          </td>
          <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
        </tr>
          </td>
          </tr>

        <tr>
          <td colspan="2" height="1" bgcolor="#2B59AE" ></td>
        </tr>
      </table>
        </td>

        <td width="65%" valign="top" align="center" >
        <table bordercolor="#ffffff"  cellpadding="0"  cellspacing="0">
          <tr>
            <td colspan="3" bgcolor="#2B59AE" height="25" >&nbsp;&nbsp;<b class="titulo">TV BolC&oacute;</b></td>
          </tr>
          <tr>
            <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
          </tr>
          <tr>
            <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
            <td height="250" align="justify"><object width="560" height="340">
                <param name="movie" value="http://www.youtube.com/v/jsyNx-LUKXo&hl=en_US&fs=1&rel=0&color1=0x2B59AE&color2=0x2B59AE">
                </param>
                <param name="allowFullScreen" value="true">
                </param>
                <param name="allowscriptaccess" value="always">
                </param>
                <embed src="http://www.youtube.com/v/jsyNx-LUKXo&hl=en_US&fs=1&rel=0&color1=0x2B59AE&color2=0x2B59AE" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed>
              </object></td>
            <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
          </tr>
            </td>
            </tr>

          <tr>
            <td colspan="2" height="1" bgcolor="#2B59AE" ></td>
          </tr>
        </table>
          </td>
      </tr>
        <tr>

      <!-- Inicio Convite -->
      <?php if (($_SESSION["tipo"] == "admin") || ($_SESSION["tipo"] == "notorio")) {  ?>
      <td valign="top" align="center" ><table bordercolor="#ffffff"  cellpadding="4"  cellspacing="0">
          <tr>
            <td colspan="3" bgcolor="#2B59AE" height="25" >&nbsp;&nbsp;<b class="titulo">Convide um amigo</b></td>
          </tr>
          <tr>
            <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
          </tr>
          <tr>
            <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
            <td height="250" align="justify"><form name="FormComent"  action="convite.php" method="Post" >
                <input type=hidden name="idconvidador" value="<?php echo $_SESSION["id"]; ?>">
                <a>Email: </a><br>
                <input STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" type="text" name="email" size="40" value="">
                <br>
                <a>Insira seus Coment&aacute;rios:</a><br>
                <textarea STYLE="border:1 inset #efefef;font-size:8pt;color:#707070;" cols="28" rows="7" name="Comentario"></textarea>
                <br>
                <?php if ($_SESSION["tipo"] == "admin") {  ?>
                <a>Tipo:</a>
                <select STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;" name="tipo" size=1>
                  <option value='usuario'>Usuario</option>
                  <option value='notorio'>Notorio</option>
                </select>
                <br/>
                <br />
                <center>
                  <a href="convidar.php">Enviar em lote</a>
                </center>
                <br />
                <?php } else {  ?>
                <input type=hidden name="tipo" value="usuario">
                <?php }  ?>
                <input type="submit" value="Enviar" STYLE="border:1 outset #efefef;font-size:8pt;color:#707070;">
              </form></td>
            <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
          </tr>
          <tr>
            <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
          </tr>
        </table></td>
      <td><?php } else {  ?>
        <td colspan=2 valign="top" align="center" >

      <?php } ?>
      <!-- Fim Convite -->

      <table bordercolor="#ffffff"  cellpadding="0"  cellspacing="0">
        <tr>
          <td colspan="3" bgcolor="#2B59AE" height="25" >&nbsp;&nbsp;<b class="titulo">Avisos</b></td>
        </tr>
        <tr>
          <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
        </tr>
        <tr>
          <td colspan="1" width="1" bgcolor="#2B59AE" ></td>
          <td height="250" align="justify" class="noticia">
          <p style="font-size:9px;text-align:right">Bras&iacute;lia, 09 de junho de 2014</p>
           <blockquote><strong>Amigos apostadores,</strong></blockquote>
Conforme previsto no regulamento do BolC&oacute;, s&oacute; ter&aacute; direito ao pr&ecirc;mio aquele apostador que pagar a quantia de <strong>R$15,00</strong>.
<br><br>
Boa sorte a todos!!<br>
Comiss&atilde;o Organizadora
          <br> <br>
          <hr>
          <p style="font-size:9px;text-align:right">Bras&iacute;lia, 09 de junho de 2014</p>
          <blockquote><strong>Caros admiradores do futebol,</strong></blockquote>
            <br>
            J&aacute; virou tradi&ccedil;&atilde;o!! Ap&oacute;s longos 4 anos, o BolC&oacute; retorna para ser mais um ingrediente na festa da Copa do Mundo de Futebol 2014. E para este ano temos novidades:<br>
            <br>
            - O BolC&oacute; ganhou um endere&ccedil;o pr&oacute;prio: www.bolco.com.br<br>
            - O apostador poder&aacute; verificar as tend&ecirc;ncias de apostas na &aacute;rea &quot;Balc&atilde;o de Apostas&quot;. Nesta &aacute;rea, ser&atilde;o apresentados sugest&otilde;es de resultados, de acordo com a casa de aposta austriaca <a href="http://www.bwin.com/">BWin</a>.<br>
            - O BolC&oacute; estar&aacute; mandando not&iacute;cias atrav&eacute;s do Twitter (<a href="http://www.twitter.com/bolco2010">@bolco2010</a>)<br>
            <br>
            Como voc&ecirc;s podem ver, este ano estamos mais interativos visando entreter ainda mais todos os apostadores.<br>
            <br>
            Em breve voc&ecirc; receber&aacute; um e-mail com os dados de acesso ao BolC&oacute;. <br>
            Tenham uma &oacute;tima Copa do Mundo de Futebol e boas apostas.<br>
            <br>
            Abra&ccedil;os,<br>
            Comiss&atilde;o organizadora. </td>
          <td colspan="1" width="1" bgcolor="#1c5e29" ></td>
        </tr>
          </td>
          </tr>

        <tr>
          <td colspan="3" height="1" bgcolor="#2B59AE" ></td>
        </tr>
      </table>
        </td>

        </tr>

    </table>
    <?php //echo $_SESSION["tipo"]; ?>
      </td>
      </tr>

    <tr>
      <td></td>
    </tr>
  </table>
  <div align="center" class="divRodape">2002 &copy; <a href="http://www.apto101.com.br/">Apartamento 101</a></div>
  </td>
  <td background="imagens/lado_dir.jpg" width="12"></td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
</div>
<?php include("analytics.inc"); ?>
</body>
</html>