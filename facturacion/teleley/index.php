
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

<?php

$ilink = mysql_connect("www.asesor.com.pe", "joelrc", "teleley");
//$ilink = mysql_connect("localhost", "root", "");
if ($ilink > 0) {
    $idbsel = mysql_select_db("teleley", $ilink);
} else {
    include("error_conexion.inc");
    exit;
}

session_start();
function desconenctar($usuario)
{
    $nombre = $usuario;

    /*$updatesql="update tnatural set logeado='B' where login='".$nombre."'";
    $xpsql=mysql_query($updatesql,$ilink);

    $updatesql="update tjuridica set logeado='B' where login='".$nombre."'";
    $xpsql = mysql_query($updatesql,$ilink);*/

    $updatesql = "update tusuarios set logeado='B' where login='" . $nombre . "'";
//    $xpsql = mysql_query($updatesql, $ilink);

    ?>
    <DIV ID="micapa">
        <font class="textoBlanco">
            Espere.... intente nuevamente...
        </font>
    </DIV>
    <?
    echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=$PHP_SELF'>";
}

function conectado($usuario)
{
    $nombre = $usuario;

    /*$updatesql="update tnatural set logeado='B' where login='".$nombre."'";
    $xpsql=mysql_query($updatesql,$ilink);

    $updatesql="update tjuridica set logeado='B' where login='".$nombre."'";
    $xpsql = mysql_query($updatesql,$ilink);*/

    $updatesql = "update tusuarios set logeado='A' where login='" . $nombre . "'";
//    $xpsql = mysql_query($updatesql, $ilink);

    ?>
    <DIV ID="micapa">
        Un momento ...verificando...
    </DIV>
    <?
    echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=$PHP_SELF'>";
}

function RandomString($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE)
{
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if ($uc == 1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($n == 1) $source .= '1234567890';
    if ($sc == 1) $source .= '|@#~$%()=^*+[]{}-_';
    if ($length > 0) {
        $rstr = "";
        $source = str_split($source, 1);
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1, count($source));
            $rstr .= $source[$num - 1];
        }
    }
    return $rstr;
}

//$cookyreg = $_COOKIE['teleley'];
//if($cookyreg !="")
//{
//			if($cookyreg == $txtlogin){
//		 	echo "Ud. ya tiene una sesion abierta ...... cierre el sistema";
//		 	echo "<meta http-equiv='Refresh' content='1;URL=http://www.teleley.com'>";
//			break;
//			}
//}

if (isset($btingresar)) {
    setcookie("teleley", $_POST['txtlogin'], time() + 300, "/", "");
    setcookie("teleley", "1", time() + 300, "", "",1);
}

if (@$mensaje == "notuser1"){
//if ($_GET['mensaje'] == "notuser1"){
echo '<script language="JavaScript" type="text/javascript">alert ("Servicio disponible solo para nuestros suscriptores pagantes...");</script>';
?>
<html>
<script src="DWConfiguration/ActiveContent/IncludeFiles/AC_RunActiveContent.js" type="text/javascript"></script>
<body bgcolor="#E8E8E8" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0" onLoad="initjsDOMenu()">
<font face="Century Gothic" size="2"><strong>Cargando...</strong></font>
<?php
echo "<meta http-equiv='Refresh' content='1;URL=http://www.teleley.com'>";
?>
<script>
    window.open('http://<?php echo  $_SERVER['HTTP_HOST'];?>/contactenos.php', '_blank');
</script><?php
}

//TODO: No mover de aquí txtlogin ni txtclave
//$txtlogin = "";
//$txtclave = "";

$obtener_ip = $_SERVER['REMOTE_ADDR'];
$sqlip = "select * from direcip where ipskip = '" . $obtener_ip . "' ";
$xsqlip = mysql_query($sqlip);
$nfip = mysql_num_rows($xsqlip);

if (($nfip == 1)) {
    if ($obtener_ip == "190.12.74.141" || $obtener_ip == "200.11.48.40" || $obtener_ip == "200.11.48.12" || $obtener_ip == "190.102.145.240" || $obtener_ip == "190.116.22.201" || $obtener_ip == "200.11.48.18" || $obtener_ip == "200.11.58.40" || $obtener_ip =="200.11.59.225") {
        $txtlogin = "ulima";
        $txtclave = "ulima";
        $slqmoduserulima = "update tusuarios set logeado='B' where login='" . $txtlogin . "' ";
        $xslqmoduserulima = mysql_query($slqmoduserulima);
    }
	
	else {
    if ($obtener_ip == "200.107.135.184" || $obtener_ip == "200.107.135.185" || $obtener_ip == "200.107.135.186") {
        $txtlogin = "userunc";
        $txtclave = "userunc";
        $slqmoduserunc ="update tusuarios set logeado='B' where login='".$txtlogin."' ";
        $xslqmoduserunc = mysql_query ($slqmoduserunc);
}
}
//else {
//    if ($obtener_ip == "200.107.135.184" || $obtener_ip == "200.107.135.185" || $obtener_ip == "200.107.135.186") {
//        $txtlogin = "userunc";
//        $txtclave = "userunc";
//        $slqmoduserunc ="update tusuarios set logeado='B' where login='".$txtlogin."' ";
//        $xslqmoduserunc = mysql_query ($slqmoduserunc);
//}
}

//else {
//    if ($obtener_ip == "190.81.111.213") {
//        //$txtlogin = "tytl";
//        //$txtclave = "tytl";
//        //$slqmodusertytl="update tusuarios set logeado='B' where login='".$txtlogin."' ";
//        //$xslqmodusertytl = mysql_query ($slqmodusertytl);
//    }
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include('includes/head.php'); ?>
<body>
<!-- ************************************************ ARRIBA **************************************** -->
<?php
include("includes/arriba.php");
?>
<!-- ************************************************ ARRIBA **************************************** -->
<table width="900" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td valign="top" background="images/bg_borde_izq.gif" width="10" height="300"></td>
<td width="879" valign=top>
<table width="879" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td width="181" class="color3" valign=top>

    <!-- ************************************************ IZQUIERDA **************************************** -->

    <table width="181" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width=15>&nbsp;</td>
            <td width=150 valign=top>
                <br>
                <?
                $fechahoy = date("Y-m-d");
                $fechareg = date("Y-m-d");
                $horareg = date("H:i:s");

                //                if ($_POST) {
                //                    $txtlogin = $_POST['txtlogin'];
                //                    $txtclave = $_POST['txtclave'];
                //                }

                $sqlusertususc = "select * from tusuarios where login='" . $txtlogin . "' and passw='" . $txtclave . "' and estado='A' and fechinicial <= '" . $fechahoy . "' and fechfinal >= '" . $fechahoy . "' and logeado = 'B'";
                $xsqlusertususc = mysql_query($sqlusertususc, $ilink);
                $numfilatu = mysql_num_rows($xsqlusertususc);
                $rwusersusctu = mysql_fetch_array($xsqlusertususc);

                $otrouser = "NO";
                if (($txtlogin == 'ulima') or ($txtlogin == 'userunc')) {
                    $otrouser = 'SI';
                }

                if (($numfilatu == 1) or (@$otrouser == 'SI')) {
                    if (($txtlogin == 'ulima') or ($txtlogin == 'ulima')) {
                        $key = "ulima2012";
                    } else {
                        $key = RandomString(10, TRUE, TRUE, FALSE);
                    }
                    $updatesql = "update tusuarios  set logeado='A', keyuser = '" . $key . "' where login='" . $txtlogin . "'";
                    $xpsql = mysql_query($updatesql, $ilink);

                    $usuario = $txtlogin;
                    session_register("usuario");
                    $_SESSION['usuario'] = $txtlogin;
                    session_register("key");
                    $_SESSION['key'] = $key;

                    //TODO: check this issue, fixed
                    @setcookie("teleley", $_POST['txtlogin'], time() + 300, "/", "");

                    setcookie("teleley", "1", time() + 300, "", "", 1);

                    $iduserrecord = $rwusersusctu[13];
                    $tipo = "U";

                    if ($iduserrecord != "") {
                        $sqlrecord = "insert into trecordusers (iduser, tipouser, fechaent, horaent) values ( '" . $iduserrecord . "', '" . $tipo . "', '" . $fechareg . "', '" . $horareg . "') ";
                        $xsqlrecord = mysql_query($sqlrecord);
                    } else {
                        echo "Inicie nuevamente sesi?n...";
                    }

                } else {
                    $sqlerrorlogout = "select * from tusuarios where login='" . $txtlogin . "' and passw='" . $txtclave . "' and estado='A' and logeado='A' and fechinicial <= '" . $fechahoy . "' and fechfinal >= '" . $fechahoy . "' ";
                    $xsqlerrorlogout = mysql_query($sqlerrorlogout, $ilink);
                    $numfilaerror = mysql_num_rows($xsqlerrorlogout);
                    if ($numfilaerror == 1) {
                        $updatesql = "update tusuarios set logeado='B' where login='" . $txtlogin . "'";
                        $xpsql = mysql_query($updatesql, $ilink);
                        session_destroy("usuario");
                        echo '<script language="JavaScript" type="text/javascript">alert ("Ud. finalizo erroneamente la sesi?n anterior .... o ya cuenta con una sesi?n activa... desconectando...");</script>';
                        desconenctar($txtlogin);
                    }
                }
                ?>
                <?
                //                if (session_is_registered("usuario")) {
                if (!isset($_SESSION['usuario'])) {
                    include_once("conexion/conexion.inc");
                    $user = $_SESSION['usuario'];
                }
                ?>
                <?php
                include("includes/usuario.php");
                ?>
                <?php //echo $_SERVER['REMOTE_ADDR']; ?>

            </td>
            <td width=16>&nbsp;</td>
        </tr>
    </table>
    <?php
    include("includes/menu.php");
    ?>
    <!-- ************************************************ IZQUIERDA **************************************** -->
</td>
<td width="11" class="color2">&nbsp;</td>
<td width="676" class="color2" valign=top>

    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="14"></td>
        </tr>
    </table>
    <!-- ************************************************ CENTRO **************************************** -->
    <table width="676" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="676"><img src="images/b_arriba.png"/></td>
        </tr>
    </table>
    <table width="676" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="84" class="color5" align="center" valign="middle"><img src="images/lupa.png"/></td>
            <td width="16" class="color6">&nbsp;</td>
            <td align=left width="536" valign="top" class="color6">
                <br>
                <!-- *************** BUSQUEDA *************** -->
                <font class=tituloAzul><b>Busque en todo Teleley</b> (Normas legales, Informes Legales,
                    Jurisprudencias...)
                </font>

                <form name="form1" method="post" action="buscar.php">
                    <font class="textoAzul">Texto a buscar: </font>
                    <label>
                        <input name="txtbuscar" type="text" class="txtarea" id="txtbuscar" size="55"
                               maxlength="255">
                    </label>
                    <label>
                        <input name="Submit" type="submit" class="txtinput" value="Buscar">
                    </label>
                    <br>
                    <font class="textoNaranja"><b>Nota:</b></font> <font class="textoAzul">Coloque la
                        palabra o palabras a buscar.</font><br>
                    <font class="textoAzul">Si desea efectuar una b&uacute;squeda utilizando una frase
                        exacta col&oacute;quela entre comillas.</font>
                    <br/>
                    <font class="textoAzul">Si desea efectuar una b&uacute;squeda avanzada en nuestra secci&oacute;n
                        de normas presione <a href="legislacion/buscarnormas.php">AQUI. </a></font>
                </form>
                <!-- *************** BUSQUEDA *************** -->
            </td>
            <td width=40 class="color6">&nbsp;</td>
        </tr>
    </table>
    <table width="676" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="676"><img src="images/b_abajo.png"/></td>
        </tr>
    </table>
    <?
    //    if (!session_is_registered("usuario")) {
    if (!isset($_SESSION['usuario'])) {
    } else {
        if (($_SESSION['usuario'] == "lhinostroza") or ($_SESSION['usuario'] == "rtorresm")) {
            include("datosusc2.php");
        } else if ($_SESSION['usuario'] == "useruap") {

        } else if ($_SESSION['usuario'] == "useresan") {

        } else if ($_SESSION['usuario'] == "userutp") {

        } else if ($_SESSION['usuario'] == "userusjb") {

        } else {
            if ($_SESSION['usuario'] != "userbcrp") {
                include("datosusc.php");
            }
        }
    }
    ?>
    <table width="676" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td height="15"></td>
            <td height="15"></td>
            <td width="254" rowspan="2" align="right"><a href="http://www.teleley.com/phpchat/"></a></td>
        </tr>
        <!--                    Aquí-->
        <?php
        if (!isset($_SESSION['usuario'])) {
            ?>
            <tr>
                <td width="19">&nbsp;</td>
                <td width="403" valign=top>
                    <font class="tituloGrande"><strong>Ultimas Actualizaciones</strong></font></td>
            </tr>
        <?php
        }
        ?>
        <!--                    Aqui-->
    </table>
    <?php
    if (!isset($_SESSION['usuario'])) {
        ?>
        <!--                aqui-->
        <table width="676" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td width="676"><img src="images/r_arriba.png"/></td>
            </tr>
        </table>
    <?php
    }
    ?>
    <!--                aqui-->
    <table width="676" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td height="15" class="color4"></td>
        </tr>
        <tr>
            <td width="676" height=300 class="color4">
                <!-- *************** RESULTADO *************** -->
                <?
                include("ultimos.php");
                ?>
                <!-- *************** RESULTADO *************** -->
            </td>
        </tr>
        <tr>
            <td height="15" align="right" class="color4">
            </td>
        </tr>
    </table>
    <!-- ************************************************ CENTRO **************************************** -->
</td>
<td width="11" class="color2">&nbsp;</td>
</tr>
</table>
</td>
<td valign="top" background="images/bg_borde_der.gif" width="11" height="300"></td>
</tr>
</table>
<!-- ************************************************ ABAJO **************************************** -->
<?php
include("includes/abajo.php");
?>
<!-- ************************************************ ABAJO **************************************** -->
</body>
</html>
<div id="Layer11" style="position:absolute; left:0px; top:1760px; width:310px; height:75px; z-index:14">

    <!-- ADDFREESTATS.COM AUTOCODE V4.0 -->

    <!-- ENDADDFREESTATS.COM AUTOCODE V4.0  -->
</div>
