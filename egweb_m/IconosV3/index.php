<?php 
	//header("Location: ../patError_egweb.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Expires: Mon, 01 Jan 2000 01:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//echo $_SERVER['HTTP_COOKIE'];
	require_once('Mobile-Detect/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	// Any mobile device (phones or tablets).
	if ($detect->isMobile()) {
		header("Location: index_mobil.php");			//habilitar para los moviles
	}
	
	include('ObtenUrl.php');
	$ua=getBrowser();
	//echo $ua['name'];
	if($ua['name']!='Google Chrome' && $ua['name']!='Mozilla Firefox'){
		?>
			<script type='text/javascript'>
				var advertencia='Lo sentimos, la version de su Navegador no cuenta con la tecnologia requerida para ver esta pagina.\nEs necesario usar Google Chrome o Firefox.';
				alert(advertencia);
				window.location.href='https://www.google.com/intl/es/chrome/';
			</script>
		<?
	}
	function get_real_ip()
	{
		if (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
		{
			return $_SERVER["HTTP_X_FORWARDED"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_FORWARDED"]))
		{
			return $_SERVER["HTTP_FORWARDED"];
		}
		else
		{
			return $_SERVER["REMOTE_ADDR"];
		}
	}
	//echo realpath(dirname(__FILE__));
	require_once('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax();
	if(preg_match('/seprosat/',curPageURL())){
		
		$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
	}
	else{
		
		$xajax->configure('javascript URI', '../xajaxs/');
		
	}
	$xajax->register(XAJAX_FUNCTION,'processForm');

	include_once('../patError/patErrorManager.php');
	include_once('../patSession/patSession.php');
	$options = array('expire'=>40);
	$sess =& patSession::singleton( 'egw', 'Native', $options );
	$prueba = $sess->get("Idu");
	if(isset($prueba)){
		echo "<script>alert('Para accesar espere un momento')</script>";
		echo "<script>window.parent.location='principal.php'</script>";
	}
	function processForm($aFormValues){	
	$objResponse = new xajaxResponse();
		if ((trim($aFormValues['usuario']) != "") && (trim($aFormValues['clave']) != "")) {
			return Login($aFormValues);		
		} else if (((trim($aFormValues['usuario'])) == "") && ((trim($aFormValues['clave'])) == "")) {
			$objResponse->alert("Ingrese el nombre de usuario y la clave.");
		} else if ((trim($aFormValues['usuario'])) == "") {
			$objResponse->alert("Ingrese el nombre de usuario.");
		} else if ((trim($aFormValues['clave'])) == "") {
			$objResponse->alert("Ingrese la clave.");
		}
	return $objResponse;		
	}	
	
	function Login($aFormValues){
		$objResponse = new xajaxResponse();
		$usuario = trim($aFormValues['usuario']);
		$clave =  trim($aFormValues['clave']);
		require('conn.php');
		require('../adodb/adodb.inc.php');
		$db = NewADOConnection('mysql');
		$db->Connect($site,$usr,$pass,$dbc);
		$existe = $db->getOne("SELECT username FROM usuarios WHERE 
		username = '".mysql_real_escape_string($usuario)."' 
		AND password = '".mysql_real_escape_string($clave)."' 
		AND estatus > 0 
		AND '".date('Y-m-d H:i:s')."' 
		between f_inicio and f_termino
		and activo=1");  	  
		if ($existe) {
		     $datosusr = $db->Execute("select u.id_usuario,u.id_empresa,u.username,u.poleo_web,u.nombre,u.permisos,u.estatus,c.sitios,c.geocercas FROM  usuarios u left outer join configuracion c on (u.id_usuario = c.id_usr) WHERE u.username = '$usuario' AND u.password = '$clave'");			 
			 $idu = $datosusr->fields[0];
			 $ide = $datosusr->fields[1];
			 $usn = $datosusr->fields[2];
			 $pol = $datosusr->fields[3];
			 $nom = $datosusr->fields[4];
			 $prm = $datosusr->fields[5];
			 $est = $datosusr->fields[6];
			 $sit = $datosusr->fields[7];	
			 $geo = $datosusr->fields[8];
			 $web = 2;
			 if($sit == '')
			 	$sit = 0;
			 if($geo == '')
			 	$geo = 0;
			 $f_even = $db->Execute("select max(fecha) as maxfecha from eventos where id_usuario = $idu and tipo = 11");
			 if($f_even->fields[0] != '')	 
			 	$eve = $f_even->fields[0];		 		 
			 else{
				$eve = date("Y-m-d 00:00:00");
				}
		     include_once('../patError/patErrorManager.php');
			 include_once('../patSession/patSession.php');
			 $options = array('expire'=>40);
			 $sess =& patSession::singleton('egw', 'Native', $options );
			 $sess->set('Idu',$idu);
			 $sess->set('Ide',$ide);
		     $sess->set('Usn',$usn);
			 $sess->set('Pol',$pol);
			 $sess->set('nom',$nom);
			 $sess->set('per',$prm); 
			 $sess->set('sta',$est);
			 $sess->set('sit',$sit);
			 $sess->set('geo',$geo);
			 $sess->set('eve',$eve);
			 $sess->set('evf',$eve);
			 $sess->set('ban',0);
			 $sess->set('dis',1); 
			 $sess->set('pan',0); 
			 $sess->set('web',$web);
			 $sess->set('config_folio','');
			 $sess->set('config_vel','');
			 $sess->set('manual','0');
			 $sess->set('apa',0);
		  	 $queryString = $sess->getQueryString();			 
		     $ip = $_SERVER['REMOTE_ADDR']; 	   
		     //$db->Execute("INSERT INTO anomalias (username,password,ip,estado) VALUES ('$usuario','$clave','$ip',1)");
			 $db->Execute("insert into eventos values('$idu','0','".date("Y-m-d H:i:s")."','Entrada a EGWeb Nueva','10','".get_real_ip()."')");
 			 //$carga = '<div id="mensaje"><div id="msg">Espere....</div><div id="animacion"></div></div>';
			 //$objResponse->append("fondo_principal_index", "innerHTML", $carga);		 		 			 
 			//$objResponse->redirect("principal.php?$web".$queryString,0);
 			 $objResponse->redirect("principal.php",0);
			 
		} else{
			$cancelado = $db->getOne("SELECT username FROM usuarios WHERE username = '".mysql_real_escape_string($usuario)."' AND password = '".mysql_real_escape_string($clave)."' AND (estatus = 0 or f_termino <= '".date('Y-m-d')."')");
			if ($cancelado) {
				$objResponse->alert(" Usuario se ha Cancelado o Caducado");
				$objResponse->script("borra_pass()");
			} else {
				$objResponse->alert("Usuario o clave invalida.".$cad);
				$objResponse->script("borra_pass()");
	            $ip = $_SERVER['REMOTE_ADDR']; 	   				
	  		    $db->Execute("INSERT INTO anomalias (username,password,ip,estado) VALUES ('$usuario','$clave','$ip',0)");    				
			}
		}
		return $objResponse;
	}
$xajax->ProcessRequest();
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
	window.location.href='http://www.sepromex.com.mx/'
}
</script>
<?php $xajax->printJavaScript(); ?>
</head>
<body id="fondo" onload="document.signupForm.usuario.focus();" style='overflow:hidden;width:100%;height:100%;'>
<div id="fondo1" style='width:100%;height:100%;'>
<div id="fondo2" style='width:100%;height:100%;' >
<div id="fondo3" style='width:100%;height:100%;'>
<center>
<form id="signupForm" name="signupForm" action="javascript:void(null);" onsubmit="submitSignup();" autocomplete="off">
<div id="fondo_principal_index">
	<div id="cuerpo_index">
	  <table width="454" border="0" class="fuente_ocho" style="position:absolute;top:25px; left:15px; text-align:left"> 
        <tr class="fuente_nueve">
          <td width="109" rowspan="7"><img src="img/logo-sombra2.png" width="132" height="137" /></td>
          <td colspan="2">&iexcl;Bienvenido a la EGWeb!</td>
          </tr>
		<? if($_GET['in']==''){ 
				//echo "<tr><td colspan='2' class='fuente_ocho'>Su sesion caduco por inactividad...</td></tr>";
			}
		?>
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
          <td><input name="clave" type="password"  id="clave" maxlength="10" style="width:150px;" ></td>
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
          <td colspan="2"><div align="right"><a href="javascript:;"
	onclick="window.open('recupera.php', 'Recuperar', 'width=350,height=200,left=500,top=250');">
    Recuperar Contrase&ntilde;a</a></div></td>
        </tr>
		<tr>
			<td colspan="3" ><a href="../movil/mobilex.php" style="text-decoration:none;" class="fuente_ocho" ><img src="img/mobile33.png" border="0" style="cursor:pointer;"  /> Versión para moviles</a></td>
		</tr>
      </table>
    </div>
    <div id="contacto_index">Si tiene dudas, comentarios o sugerencias llámenos al (33) <a href="<? echo ($detect->isMobile())? 'tel' : 'callto'; ?>:38255200">3825 5200</a> ext. 104 , o bien envíe un email a 
		<a href="mailto:monitoreo_gps@sepromex.com.mx">monitoreo_gps@sepromex.com.mx</a>
	</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create','UA-44268501-1','sepromex.com.mx');
  ga('send','pageview');
</script>
</form>
</center>
</div>
</div>
</div>	
</body>
</html>
