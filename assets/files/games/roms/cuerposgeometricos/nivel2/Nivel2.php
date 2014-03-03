<!-- saved from url=(0013)about:internet -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nivel2</title>
</head>
<body bgcolor="#ffffff">
<script language="JavaScript">
<!--
var isInternetExplorer = navigator.appName.indexOf("Microsoft") != -1;
// Gestionar todos los mensajes de FSCommand de una película Flash
function Nivel2_DoFSCommand(command, args) {
	var Nivel2Obj = isInternetExplorer ? document.all.Nivel2 : document.Nivel2;
	//
	// Introduzca su código aquí.
	//
}
// Ancla para Internet Explorer
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
	document.write('<script language=\"VBScript\"\>\n');
	document.write('On Error Resume Next\n');
	document.write('Sub Nivel2_FSCommand(ByVal command, ByVal args)\n');
	document.write('	Call Nivel2_DoFSCommand(command, args)\n');
	document.write('End Sub\n');
	document.write('</script\>\n');
}
//-->
</script>
<!--URL utilizadas en la película-->
<a href="../../index.php"></a>
<a href="javascript:window.close()"></a>
<!--Texto utilizado en la película-->
<!--
<p align="center"></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">5</font></p>
<p align="left"></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">6</font></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">3</font></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">7</font></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">4</font></p>
<p align="center"><font face="Arial Black" size="22" color="#ffffff" letterSpacing="0.000000" kerning="1">8</font></p>
-->
<?php
$pntos1 =  $_GET["PuntosNivel1"] ; 
$pntos2 =  $_GET["PuntajeAcumulado"] ; 
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" id="Nivel2" width="100%" height="100%" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="Nivel2.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="FlashVars" value="pnt=<?= $pntos1?>&pnta=<? print $pntos2?>" /><embed src="Nivel2.swf" FlashVars="pnt=<?= $pntos1?>&pnta=<? print $pntos2?>" quality="high" bgcolor="#ffffff" width="100%" height="100%" swLiveConnect=true id="Nivel2" name="Nivel2" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer_es" />
</object>
</body>
</html>
