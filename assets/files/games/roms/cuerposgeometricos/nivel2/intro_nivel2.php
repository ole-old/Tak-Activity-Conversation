<!-- saved from url=(0013)about:internet -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>intro_nivel2</title>
</head>
<body bgcolor="#ffffff">
<script language="JavaScript">
<!--
var isInternetExplorer = navigator.appName.indexOf("Microsoft") != -1;
// Gestionar todos los mensajes de FSCommand de una película Flash
function intro_nivel2_DoFSCommand(command, args) {
	var intro_nivel2Obj = isInternetExplorer ? document.all.intro_nivel2 : document.intro_nivel2;
	//
	// Introduzca su código aquí.
	//
}
// Ancla para Internet Explorer
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
	document.write('<script language=\"VBScript\"\>\n');
	document.write('On Error Resume Next\n');
	document.write('Sub intro_nivel2_FSCommand(ByVal command, ByVal args)\n');
	document.write('	Call intro_nivel2_DoFSCommand(command, args)\n');
	document.write('End Sub\n');
	document.write('</script\>\n');
}
//-->
</script>
<!--URL utilizadas en la película-->
<!--Texto utilizado en la película-->
<?php
$pntos1 =  $_GET["PuntosNivel1"] ; 
$pntos2 =  $_GET["PuntajeAcumulado"] ; 
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" id="intro_nivel2" width="100%" height="100%" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="intro_nivel2.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="FlashVars" value="pnt=<? print $pntos1?>&pnta=<? print $pntos2?>" /><embed src="intro_nivel2.swf" FlashVars="pnt=<? print $pntos1?>&pnta=<? print $pntos2?>" quality="high" bgcolor="#ffffff" width="100%" height="100%" swLiveConnect=true id="intro_nivel2" name="intro_nivel2" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer_es" />
</object>
</body>
</html>
