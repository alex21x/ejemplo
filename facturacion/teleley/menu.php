<?php
include("conexion/conexion.php");

$sql = " select * from tytl_menu where   tytlmenu_tipo='M' and tytlmenu_estado='A' order by nro_orden";
$rs = mysql_query($sql, $ilink);

while($row = mysql_fetch_array($rs,MYSQL_ASSOC)){
	$array_menu[ $row['tytlmenu_parent'] ][] =$row;
}

function menu($id,$array,$len){
?>	<ul style="display: none; z-index:100px; visibility: hidden; width:<?php echo $len?>;" >
		<?php foreach ($array[$id] as $temp1){?>
		<li><a href="<?php if(trim($temp1['tytlmenu_url'])==''){ echo '#'; }else{echo $temp1['tytlmenu_url'];}?>" style="color:#ffffff;text-align: left;"><?php if(array_key_exists($temp1['tytlmenu_id'],$array)==true){?><img src="images/bull_menu.gif" border="0" /> &nbsp;<?php }?><?php echo htmlentities($temp1['tytlmenu_menu'])?></a><?php if( array_key_exists($temp1['tytlmenu_id'],$array)==true){ menu($temp1['tytlmenu_id'],$array,'250px;left:270px'); }?></li>
		<?php }?>
	</ul>
<?php
}

?><div align="center" id="menu_container" style="position: absolute; z-index:100px;">
<ul id="sample-menu-3" class="sf-menu sf-vertical sf-js-enabled sf-shadow"><?php
foreach ($array_menu[0] as $temp){
?><li class="current"> <a href="<?php if($temp['tytlmenu_url']==''){ echo '#'; }else{echo $temp['tytlmenu_url'];}?>" style="color:#ffffff;text-align: left;"><img src="images/bull_menu.gif" border="0" /> &nbsp; <?php echo htmlentities($temp['tytlmenu_menu'])?></a>
<?php if( array_key_exists($temp['tytlmenu_id'],$array_menu)==true){ menu($temp['tytlmenu_id'],$array_menu,'270px'); }?>
</li><?php
}
?></ul>
</div>





<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> <br>
<br clear="all">

<div id="GWeather">
<table width="180" cellpadding="3" cellspacing="1" border="0" bgcolor="#C0C4C8"><tr height="20"><td bgcolor="#C0C4C8" valign="top">
<table  width="100%" cellpadding="0" cellspacing="0" border="0">

<tr><td valign="top"><span style="line-height:20px;font-family:Arial; font-weight:bold;font-size:14px;letter-spacing:-1px; color:#e57e00;">&nbsp;TIPO DE CAMBIO</span></td></tr>

<tr><td align="right" style="padding:5px;font-family:tahoma;font-size:11px;text-decoration:none;color:#2b3f35;">Moneda de Hoy</td></tr>

</table>


<div class="current" style="padding:10px;" align="center">
<table style="position:relative; top:-5px;font-size:12px;text-decoration:none;" cellpadding="5" cellspacing="1" width="94%" bgcolor="#2b3f35"><tr><td bgcolor="white" align="left">
<font color="#2b3f35">

<?PHP
$from   = 'USD';
$to     = 'PEN';
//$url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $from . $to .'=X';
$url = "http://download.finance.yahoo.com/d/quotes.csv?s=".$from.$to."=X&f=sl1d1t1ba&e=.csv";
$handle = @fopen($url, 'r');

if ($handle) {
    $result = @fgets($handle, 4096);
    fclose($handle);
}

$allData = explode(',',$result);
$dollarCompra = $allData[4];
$dollarVenta  = $allData[5];
echo '<b>Dolar:</b><br>&nbsp;&nbsp; Compra S/. '.$dollarCompra .'<br>&nbsp;&nbsp; Venta &nbsp;&nbsp;&nbsp;&nbsp;S/. '.$dollarVenta .' <br><br> ';


$from   = 'EUR';
$to     = 'PEN';
$url = "http://download.finance.yahoo.com/d/quotes.csv?s=".$from.$to."=X&f=sl1d1t1ba&e=.csv";
$handle = @fopen($url, 'r');

if ($handle) {
    $result = fgets($handle, 4096);
    fclose($handle);
}
$allData = explode(',',$result);
$dollarCompra = $allData[4];
$dollarVenta  = $allData[5];
echo '<b>Euro:</b><br>&nbsp;&nbsp; Compra S/. '.$dollarCompra .'<br>&nbsp;&nbsp; Venta &nbsp;&nbsp;&nbsp;&nbsp;S/. '.$dollarVenta .' <br> ';

?></font>

</td></tr></table>

</div>

</td></tr></table>
</div>



<br>
<table  width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="100%" align=center>
  <p>
    <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','156','height','65','src','banners/libro2','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','banners/libro2' ); //end AC code
  </script>
    <noscript>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="156" height="65">
        <param name="movie" value="banners/libro2.swf" />
        <param name="quality" value="high" />
        <embed src="banners/libro2.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="156" height="65"></embed>
      </object>
      </noscript>
    <br><br>
    <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','156','height','65','src','banners/banner_abogados','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','banners/banner_abogados' ); //end AC code
  </script>
    <noscript>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="156" height="65">
        <param name="movie" value="banners/banner_abogados.swf" />
        <param name="quality" value="high" />
        <embed src="banners/banner_abogados.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="156" height="65"></embed>
      </object>
      </noscript>
    <br><br>

  <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','156','height','65','src','banners/banner_asesor','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','banners/banner_asesor' ); //end AC code
</script>
  <noscript>
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="156" height="65">
    <param name="movie" value="banners/banner_asesor.swf" />
    <param name="quality" value="high" />
    <embed src="banners/banner_asesor.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="156" height="65"></embed>
  </object>
  </noscript>
  

<noscript>
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="156" height="65">
    <param name="movie" value="banners/banner_asesor.swf" />
    <param name="quality" value="high" />
    <embed src="banners/banner_asesor.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="156" height="65"></embed>
  </object>
  </noscript>
  <br><br>
  <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','156','height','65','src','banners/banner_laencuesta','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','banners/banner_laencuesta' ); //end AC code
</script>
  <noscript>
  <div class="contenedor"></div>
  </noscript>
  <br><br>
<!--  
  <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','156','height','65','src','banners/banner_sumilla','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','banners/banner_sumilla' ); //end AC code
</script>
  <noscript>

  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="156" height="65">
    <param name="movie" value="banners/banner_sumilla.swf" />
    <param name="quality" value="high" />
    <embed src="banners/banner_sumilla.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="156" height="65"></embed>
  </object>
-->
  </noscript>
  </p>
  <table width="107" border="0">
  <tr>
    <td width="101" ><a href="http://www.teleley.com/libroReclamacion.php"><img src="libro.png" width="98" height="56" border="0" /></a></td>
     </tr> <p> </p>
</table>
<br>
  <table width="0" border="0" cellpadding="0">
    <tr>
      <td colspan="2" align="center"><b><font class="textoBlanco">Encuentrenos en: </font></b></td>
    </tr>
    
    <tr>
      <td align="center"><a href="http://twitter.com/teleley"><img src="../imagenes/logotwitter.jpg" width="45" height="45" border="0" /></a></td>
      <td align="center"><a href="http://www.facebook.com/teleley?ref=ts&fref=ts" target="blanck"><img src="../imagenes/logofacebook.png" width="45" height="45" border="0" /></a></td>
    </tr>
  </table>
  <p><br>
    <br>
  </p></td>
</tr>
</table>
<!--

facebook antiguo: http://www.facebook.com/pages/TELELEY-PRIMER-PORTAL-LEGAL-DEL-PERU/258599015851
<table height="76" cellspacing="0" cellpadding="0"  border="0"  width="100%">
      <tbody><tr>
        <td height="19" align="center" colspan="2"><font class='textoBlanco'><b>Encuentranos en: </b></font></td>
        </tr>
      <tr>
        <td align="center" width="72"><center>
          <a href="http://www.facebook.com/pages/TELELEY-PRIMER-PORTAL-LEGAL-DEL-PERU/258599015851"><img height="50" border="0" width="50" src="http://www.teleley.com/imagenes/logofacebook.jpg"/></a>
        </center>
        </td>
        <td align="center" width="72"><a href="http://www.twitter.com/teleley"><img height="50" border="0" width="47" src="http://www.teleley.com/imagenes/logo-twitter.png"/></a></td>
      </tr>
    </tbody></table>-->
