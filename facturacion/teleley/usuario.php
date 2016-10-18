<?
//session_start();
include("conexion/conexion.php");
@$user = $_SESSION['usuario'];
//if (!session_is_registered("usuario")) {
if (!isset($_SESSION['usuario'])) {
    ?>
    <FORM name='frm' id='frm' action="index.php" METHOD="POST">
        <table width="150" height="125" border="0" cellpadding="0" cellspacing="0" background="../images/bg_login.gif"
               style="background-repeat:no-repeat;">
            <tr>
                <td width="150" valign="top">
                    <table width="150" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height=45></td>
                        </tr>
                        <tr>
                            <td width="7"></td>
                            <td width=65><b style="color:#ffffff;text-align: left;"><font size="1">Usuario</font></b>
                            </td>
                            <td width="6"></td>
                            <td width=65><b style="color:#ffffff;text-align: left;"><font
                                        size="1">Contrase&ntilde;a</font></b>
                            </td>
                            <td width="7"></td>
                        </tr>
                        <tr>
                            <td height=4></td>
                        </tr>
                        <tr>
                            <td width="7"></td>
                            <td width=65><input name="txtlogin" id="txtlogin" maxlength="30" size="10" class="txtinput">
                            </td>
                            <td width="6"></td>
                            <td width=65><input name="txtclave" id="txtclave" maxlength="30" size="10" type='password'
                                                class="txtinput"></td>
                            <td width="7"></td>
                        </tr>
                        <tr>
                            <td height=4></td>
                        </tr>
                        <tr>
                            <td width="7"></td>
                            <td width=65><input type='image' src="images/bt_login_off.png"/></td>
                            <td width="6"></td>
                            <td width=65></td>
                            <td width="7"></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="center">
                           <!--     <a href="http://www.teleley.com/phpchat/" target="_blank"><img
                                        src="../imagenes/logochat.jpg" width="146" height="28" border="0"/></a>		-->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
<?
} else {
    $sqlusuario = "select nombre, fechfinal from tusuarios where login = '" . $user . "' ";
    $xsqlusuario = mysql_query($sqlusuario);
    $rwuser = mysql_fetch_array($xsqlusuario);
    ?>
    <table width="150" height="91" border="0" cellpadding="0" cellspacing="0" background="../images/bg_login_s.gif"
           style="background-repeat:no-repeat;">
        <tr>
            <td height="30" colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td width="27"><font class="textoBlanco"><img src="../imagenes/usuariosi.png" width="24"
                                                          height="24"/></font>
            </td>
            <td width="120" align="left"><font class="textoBlanco"><? echo $rwuser[0]; ?></font></td>
        </tr>
        <tr>
            <td height="36" colspan="2" align="right">
                <a href="cerrar.php"><img src="images/bt_login_close.png" border="0" style="text-decoration:none"></a>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            <!--    <a href="http://www.teleley.com/phpchat/" target="_blank"><img src="../imagenes/logochat.jpg"
                                                                               width="146"
                                                                               height="28" border="0"/></a>		-->
            </td>
        </tr>
    </table>
<?
}
?>
<form name="frmbuscar" action="http://www.teleley.com/buscar.php">
    <table width="150" height="26" border="0" cellpadding="0" cellspacing="0" background="../images/bg_buscar.jpg"
           style="background-repeat:no-repeat;">
        <tr>
            <td align="center" valign="middle">
                <input name="txtbuscar" type="text" size="13" class="txtinput"/>
            </td>
            <td valign="middle">
                <input type="submit" name="btbuscar" value="Buscar"
                       style="background-color:##F93; font:Arial; font-size:12px"/>
            </td>
        </tr>
    </table>
</form>