<?php 
	header("Location: index.php");
	session_destroy();
	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax();
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,'processForm');
	$xajax->register(XAJAX_FUNCTION,'Login');

	include_once('../patError/patErrorManager.php');
	include_once('../patSession/patSession.php');
	$sess =& patSession::singleton( 'egw', 'Native', $options );
	$prueba = $sess->get("Idu");
/*	if(isset($prueba)){
		echo "<script>alert('Para accesar espere un momento')</script>";
		echo "<script>window.parent.location='principal.php'</script>";
	}*/
	
	function Login()
	{
		$objResponse = new xajaxResponse();
		$usuario = "demoapa";
		$clave =  "apademo";
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
			 $web = 1;
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
 			 header("Location: ./principal.php?$queryString");

			 
		} else{
			$cancelado = $db->getOne("SELECT username FROM usuarios WHERE username = '".mysql_real_escape_string($usuario)."' AND password = '".mysql_real_escape_string($clave)."' AND (estatus = 0 or f_termino < '".date('Y-m-d')."')");
			if ($cancelado) {
		
			} else {

	            $ip = $_SERVER['REMOTE_ADDR']; 	   				
	  		    $db->Execute("INSERT INTO anomalias (username,password,ip,estado) VALUES ('$usuario','$clave','$ip',0)");    				
			}
		}	
		return $objResponse;
	}
$xajax->ProcessRequest();
Login();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>::..ACCESO A EGWEB..::</title>
<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function submitSignup(){
	xajax_Login();
	return false;
}
</script>
<?php $xajax->printJavaScript(); ?>
</head>
<body onload="submitSignup()">
</body>
</html>
