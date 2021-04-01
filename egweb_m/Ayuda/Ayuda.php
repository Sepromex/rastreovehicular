<?
 include_once('../../patSession/patSession.php');
 include_once('../../patError/patErrorManager.php');
 $sess =& patSession::singleton('egw', 'Native', $options );
 $estses = $sess->getState();
 if($estses == empty_referer){
	header("Location: index.php?$web");		
  }
$result = $sess->get( 'expire-test' );
if((!patErrorManager::isError($result))) {}
else{
	header("Location: index.php?");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ayuda</title>
<link href="../css/black.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
<link href="../principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../principal/js/jquery-ui-1.10.3.custom.js"></script>
<style>
.tablamenu
{
border:thin;
border-color:#999999;
}
</style>
</head>
<script>
$(document).ready(function () {
	$("#menuayuda").show();
	$("#informacion").hide();
	$(this).mousemove(function (e) {
        opener.idleTime = 0;
    });
   $(this).keypress(function (e) {
        opener.idleTime = 0;
    });
});
function descargar(){
	$('a#descargar').attr({target: '_blank',href  : 'Manual_de_EGWEB_para_el_Usuario.pdf'});
}
	
</script>
<body id="fondo" style="overflow:hidden;max-height:350px;overflow:hidden;background:url(main-bkg-00.png) transparent repeat;">
<div id="fondo1" style="background:url(main-bkg-01.png) transparent repeat;">
	<div id="fondo2" style="background:url(main-bkg-02.png) transparent repeat;">
		<div id="fondo3" style="background:url(main-bkg-03.png) transparent repeat;">
		<div id="cuerpoSuphead" style='height:800px;'>
		<div id="logo"><img src='logo1.png' width="70" height="62"></div><!--Nos muestra el logo de la pagina "oficial"-->
		</div>
<div id="newspaper-a1" style='position:absolute;top:80px;border:none;'>
<br>
Bienvenido a la Ayuda del sistema EGWeb. 
<br>
<br>
<div id="newspaper-a1" style='border:none;'>De click <a href='#' id="descargar" onclick="descargar();">aquí</a> para descargar el manual de la EGWeb.</div>
	<!--<div id="menuayuda">
	  <table width="328" height="169" id='box-table-a'>
	  <tr>
		<td><span style="cursor:pointer;" onclick="ver_temas('ingsis');"> Ingreso al sistema </span></td>
		<td><span style="cursor:pointer;" onclick="ver_temas('reccon');"> Recuperar Contrase&ntilde;a </span></td>
	  </tr>
	  <tr>
		<td><span style="cursor:pointer;" onclick="ver_temas('camcon');">Cambiar contrase&ntilde;a </span></td>
		<td><span style="cursor:pointer;" onclick="ver_temas('conpos');">Consultar Posici&oacute;n Actual </span></td>
	  </tr>
	  <tr >
		<td><span style="cursor:pointer;" onclick="ver_temas('solpos');">Solicitar Posici&oacute;n </span></td>
		<td><span style="cursor:pointer;" onclick="ver_temas('tipmap');">Tipos de mapa </span></td>
	  </tr>
	 <!-- <tr>
		<td><span style="cursor:pointer;" onclick="ver_temas('envmsj');">Env&iacute;o de Mensajes </span></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	</div>
	<div id='informacion' style='position:absolute;left:20px;'></div>-->

	
	</div>
</div>
</div>
</div>
</body>
</html>
