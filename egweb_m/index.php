<?php
/*
//header("Cache-Control: no-store, no-cache, must-revalidate");
//header("Expires: Mon, 01 Jan 2000 01:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

*/
include_once('../patError/patErrorManager.php');
include_once('../patSession/patSession.php');
require('../xajaxs/xajax_core/xajax.inc.php');



session_start();
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,'processForm');

$options = array('expire'=>1);
$sess    =&    patSession::singleton( 'egw' );
$prueba = $_SESSION["Idu"];

function get_real_ip(){
	if (isset($_SERVER["HTTP_CLIENT_IP"])){
		return $_SERVER["HTTP_CLIENT_IP"];
	}else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if (isset($_SERVER["HTTP_X_FORWARDED"])){
		return $_SERVER["HTTP_X_FORWARDED"];
	}else if (isset($_SERVER["HTTP_FORWARDED_FOR"])){
		return $_SERVER["HTTP_FORWARDED_FOR"];
	}else if (isset($_SERVER["HTTP_FORWARDED"])){
		return $_SERVER["HTTP_FORWARDED"];
	}else{
		return $_SERVER["REMOTE_ADDR"];
	}
}

function processForm($aFormValues){	
	$objResponse = new xajaxResponse();
	if ((trim($aFormValues['usuario']) != "") && (trim($aFormValues['clave']) != "")){
		return Login($aFormValues);		
	}else if (((trim($aFormValues['usuario'])) == "") && ((trim($aFormValues['clave'])) == "")){
		$objResponse->alert("Ingrese el nombre de usuario y la clave.");
	}else if ((trim($aFormValues['usuario'])) == ""){
		$objResponse->alert("Ingrese el nombre de usuario.");
	}else if ((trim($aFormValues['clave'])) == ""){
		$objResponse->alert("Ingrese la clave.");
	}
	return $objResponse;		
}	

function Login($aFormValues){
	$objResponse = new xajaxResponse();
	$usuario = trim($aFormValues['usuario']);
	$clave =  trim($aFormValues['clave']);
	include('librerias/conexion.php');

	$cad = "SELECT username FROM sepromex.usuarios WHERE username = '$usuario' AND password = '$clave' AND estatus > 0 AND activo = 1 AND NOW() between f_inicio AND f_termino";
	$existe = mysql_query($cad);
	if (mysql_num_rows($existe)>0) {
		$datos=mysql_query("SELECT u.id_usuario,u.id_empresa,u.username, u.poleo_web,u.nombre,u.permisos,u.estatus,c.sitios,c.geocercas 
							FROM  usuarios u LEFT OUTER JOIN configuracion c ON (u.id_usuario = c.id_usr) WHERE u.username = '$usuario' AND u.password = '$clave'");
		$datosusr = mysql_fetch_array($datos);
		$idu = $datosusr[0];
		$ide = $datosusr[1];
		$usn = $datosusr[2];
		$pol = $datosusr[3];
		$nom = $datosusr[4];
		$prm = $datosusr[5];
		$est = $datosusr[6];
		$sit = $datosusr[7];	
		$geo = $datosusr[8];
		$web = 2;
		if($sit == '') $sit = 0;
		if($geo == '') $geo = 0;
		
		$fecha_even = mysql_query("SELECT MAX(fecha) AS maxfecha FROM eventos WHERE id_usuario = $idu AND tipo = 11");
		$f_even = mysql_fetch_array($fecha_even);
		if($f_even[0] != ''){ $eve = $f_even[0]; }else{ $eve = date("Y-m-d 00:00:00"); }		
		$_SESSION['expire'] = 40;
		$sess    =&    patSession::singleton( 'egw' );
		$_SESSION[''];
		$_SESSION['Idu'] = $idu;
		$_SESSION['Ide'] = $ide;
		$_SESSION['Usn'] = $usn;
		$_SESSION['Pol'] = $pol;
		$_SESSION['nom'] = $nom;
		$_SESSION['per'] = $prm; 
		$_SESSION['sta'] = $est;
		$_SESSION['sit'] = $sit;
		$_SESSION['geo'] = $geo;
		$_SESSION['eve'] = $eve;
		$_SESSION['evf'] = $eve;
		$_SESSION['ban'] = 0;
		$_SESSION['dis'] =1 ; 
		$_SESSION['pan'] = 1; 
		$_SESSION['web'] = $web;
		$_SESSION['config_folio'] = '';
		$_SESSION['config_vel'] = '';
		$_SESSION['manual'] = '0';
		$_SESSION['apa'] = 0;
		session_write_close();
		mysql_query("INSERT INTO eventos VALUES('$idu','0','".date("Y-m-d H:i:s")."','Entrada a EGWeb Nueva','10','".get_real_ip()."')");
		$objResponse->redirect("principal.php",0);		 
	}else{
		$cancelado = mysql_query("SELECT username FROM usuarios WHERE username = '$usuario' AND password = '$clave' AND (estatus = 0 or f_termino <= '".date('Y-m-d')."')");
		if (mysql_num_rows($cancelado)){
			$objResponse->alert(" Usuario se ha Cancelado o Caducado");
			//$objResponse->script("borra_pass()");
		}else{
			//$objResponse->alert("Usuario o clave invalida.".$cad);
			$objResponse->alert("Usuario o clave invalida.");
			//$objResponse->script("borra_pass()");
			$ip = $_SERVER['REMOTE_ADDR']; 	   				
		    mysql_query("INSERT INTO anomalias (username,password,ip,estado) VALUES ('$usuario','$clave','$ip',0)");    				
		}
	}
	return $objResponse;		
}

$xajax->ProcessRequest();
$xajax->printJavascript("");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>::..ACCESO A EGWEB..::</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img2/favicon.png" type="image/png">
<script type="text/javascript" src="librerias/jquery.js"></script> 
<script language="JavaScript">
$(document).ready(function(){
	if($.browser.mozilla)
		$(".boton_x").css({"padding":"2px 3px 8px 2px"});
});
function submitSignup(){
	xajax_processForm(xajax.getFormValues("signupForm"));
	return false;
}
function borra_pass(){
	$('#clave').val('');
}
function mantenimiento(){
	alert("Lamentamos este inconveniente, nos encontramos en mantenimineto. Vuelva a intentar en unos minutos, Gracias!");
	window.location.href='https://www.sepromex.com.mx/'
}
</script>
</head>
<body id="fondo" onLoad="document.signupForm.usuario.focus();" style='overflow:hidden;width:100%;height:100%;'>
<div id="fondo1" style='width:100%;height:100%;'>
<div id="fondo2" style='width:100%;height:100%;' >
<div id="fondo3" style='width:100%;height:100%;'>
<center>
<form id="signupForm" name="signupForm" action="javascript:void(null);" onSubmit="submitSignup();" autocomplete="off">
<div id="fondo_principal_index">
	<div id="cuerpo_index">
	  <table width="454" border="0" class="fuente_ocho" style="position:absolute;top:25px; left:15px; text-align:left"> 
        <tr class="fuente_nueve">
          <td width="109" rowspan="7"><img src="img/logo-sombra2.png" width="132" height="137" /></td>
          <td colspan="2">&iexcl;Bienvenido a la EGWeb!</td>
          </tr>
        <tr>
          <td colspan="2">Por favor introduzca su usuario y contrase&ntilde;a para acceder a la  aplicaci&oacute;n.</td>
        </tr>
        <tr>
          <td width="90">&nbsp;</td>
          <td width="241">&nbsp;</td>
        </tr>
        <tr>
          <td>Usuario:</td>
          <td> <input name="usuario" type="text"  id="usuario" maxlength="10" style="width:150px;"></td>
        </tr>
        <tr>
          <td>Contrase&ntilde;a:</td>
          <td><input name="clave" type="password"  id="clave" maxlength="25" style="width:150px;" ></td>
        </tr>
        <tr>
          <td></td>
          <td><label>
            <div style="position:relative;left:15px;">
              <input name="button" type="submit" id="button" value="Entrar"  class="boton_x"/>
              </div>
          </label></td>
        </tr>
        <tr>
          <td colspan="2">
          	<div style="text-align:right;">
          		<a href="" onclick="window.open('recupera.php', 'Recuperar', 'width=350,height=200,left=500,top=250');">Recuperar Contrase&ntilde;a</a>
          	</div>
          </td>
        </tr>
		<tr>
			<td colspan="3" >
				<a href="../movil/mobilex.php" style="text-decoration:none;" class="fuente_ocho" >
					<img src="img/mobile33.png" border="0" style="cursor:pointer;"  /> Versión para moviles
				</a>
			</td>
		</tr>
      </table>
    </div>
    <div id="contacto_index">
    		Si tiene dudas, comentarios o sugerencias llámenos al (33 38255200) ext. 104 , o bien envíe un email a monitoreo_gps@sepromex.com.mx.
	</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create','UA-44268501-1','sepromex.com.mx');
  ga('send','pageview');



	var isMobile = {
		mobilecheck : function() {
		return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i.test(navigator.userAgent||navigator.vendor||window.opera)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test((navigator.userAgent||navigator.vendor||window.opera).substr(0,4)))
		}
	}
//var movil = "";
if(isMobile.mobilecheck() === true){
	var es_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
	if(es_chrome){
		alert("Para efectos de calidad del sistema, te recomendamos utilizar el Navegador Mozilla Firefox.");
	}
}
</script>
</form>
</center>
</div>
</div>
</div>	
</body>
</html>