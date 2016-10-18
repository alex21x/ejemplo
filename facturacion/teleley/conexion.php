<?php
	$ilink=mysql_connect("www.asesor.com.pe","joelrc","teleley");
	if ($ilink>0) {
	$idbsel=mysql_select_db("teleley",$ilink);
	} else {
	include("error_conexion.inc");
	exit;
	}

?>
