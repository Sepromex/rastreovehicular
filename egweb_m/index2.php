<?php 
	session_destroy();
	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax();
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,'processForm');

	include_once('../patError/patErrorManager.php');
	include_once('../patSession/patSession.php');
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
		$db->PConnect($site,$usr,$pass,$dbc);
		$existe = $db->getOne("SELECT username FROM usuarios WHERE username = '".mysql_real_escape_string($usuario)."' AND password = '".mysql_real_escape_string($clave)."' AND estatus > 0 AND '".date('Y-m-d H:i:s')."' between f_inicio and f_termino");  	  
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
			 $options = array('expire'=>3);
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
		  	 $queryString = $sess->getQueryString();			 
		     $ip = $_SERVER['REMOTE_ADDR']; 	   
		     $db->Execute("INSERT INTO anomalias (username,password,ip,estado) VALUES ('$usuario','$clave','$ip',1)");
			 $db->Execute("insert into eventos (id_usuario,num_veh,notas,tipo) values ('$idu','0','Entrada a EGWeb','10')");
 			 $carga = '<div id="mensaje"><div id="msg">Espere....</div><div id="animacion"></div></div>';
			 $objResponse->append("fondo_principal_index", "innerHTML", $carga);		 		 			 
 			 $objResponse->redirect("principal.php?$web".$queryString,3.9);
			 
		} else{
			$cancelado = $db->getOne("SELECT username FROM usuarios WHERE username = '".mysql_real_escape_string($usuario)."' AND password = '".mysql_real_escape_string($clave)."' AND (estatus = 0 or f_termino <= '".date('Y-m-d')."')");
			if ($cancelado) {
				$objResponse->alert(" Usuario se ha Cancelado o Caducado");			
			} else {
				$objResponse->alert("Usuario o clave invalida.".$cad);
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
<link href="librerias/dsnx.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function submitSignup(){
	xajax_processForm(xajax.getFormValues("signupForm"));
	return false;
}
function aviso(){
	window.open('mtto.php','fotografia', 'width=420,height=310,scrollbars=NO');
}
</script>
<?php $xajax->printJavaScript(); ?>
</head>
<body id="fondo" onload="document.signupForm.usuario.focus();">
<center>
<form id="signupForm" name="signupForm" action="javascript:void(null);" onsubmit="submitSignup();">
<div id="fondo_principal_index">
	<div id="cuerpo_index">
	  <table width="454" border="0" class="fuente_ocho" style="position:absolute;top:25px; left:15px; text-align:left"> 
        <tr class="fuente_nueve">
          <td width="109" rowspan="7"><img src="img/Logo.png" width="138" height="132" /></td>
          <td colspan="2">&iexcl;Bienvenido a la EGWeb!</td>
          </tr>
        <tr>
          <td colspan="2"><u>Por favor introduzca su usuario y contrase&ntilde;a para acceder a la  aplicaci&oacute;n.</u></td>
          </tr>
        <tr>
          <td width="90">&nbsp;</td>
          <td width="241">&nbsp;</td>
        </tr>
        <tr>
          <td>Usuario:</td>
          <td> <input name="usuario" type="text"  id="usuario" maxlength="10"></td>
        </tr>
        <tr>
          <td>Contrase&ntilde;a:</td>
          <td><input name="clave" type="password"  id="clave" maxlength="10"></td>
        </tr>
        <tr>
          <td></td>
          <td><label>
            <div align="right">
              <input name="button" type="submit" id="button" value="Enviar"  class="boton_x"/>
              </div>
          </label></td>
        </tr>
        <tr>
          <td colspan="2"><div align="right"><a href="javascript:;"
	onclick="window.open('recupera.php', 'Recuperar', 'width=250,height=170,left=500,top=250');">
    Recuperar Contrase&ntilde;a</a></div></td>
        </tr>
      </table>
    </div>
    <div id="contacto_index">Si tiene dudas, comentarios o sugerencias llámenos al (33) 3825 5200 ext. 206 , o bien envíe un email a <u>aclientes@sepromex.com.mx</u></div>
</div>
</form>
</center>	
</body>
</html>
