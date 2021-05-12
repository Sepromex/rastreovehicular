<?php
	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax();
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,'recPass');
	
	function recPass($forInfo){
	    require("./librerias/conexion.php");
		$objResponse = new xajaxResponse();
		$cad_mail = "select username, password, email from usuarios  where "; 
		$cad_mail .= "email = '".mysql_real_escape_string($forInfo['correo'])."' and username = '".mysql_real_escape_string($forInfo['usuario'])."'";
		$res_mail = mysql_query($cad_mail);
		$num = mysql_num_rows($res_mail);
			if($num == 1 ){
				$row = mysql_fetch_row($res_mail);
				require("./librerias/phpmailer/class.phpmailer.php");
				  ob_start();
					$mail = new phpmailer();
					$mail->PluginDir = "./librerias/phpmailer/";		
					$mail->Mailer = "smtp";
					$mail->Host = "mail.sepromex.com.mx";
					$mail->Port = 26;
					$mail->SMTPAuth = true;
					$mail->Username = "notifica@sepromex.com.mx";
					$mail->Password = "6652273833a";
					$mail->From = "notifica@sepromex.com.mx";
					$mail->FromName = "Servicio a Clientes de Sepromex";   
					$mail->Timeout=30;
				    $mail->AddAddress($row[2]);		
					$mail->Subject = "Password EGWEB";
					$cadena = "Usted ha solicitado una recuperaci&oacute;n de contrase&ntilde;a<br /><br />";
					$cadena .= "<br />El usuario es: ".$row[0];
					$cadena .= "<br />El password es: ".$row[1];
					$cadena .= "<br /><br />Gracias por utilizar el servicio, &iexcl;Estamos para servirle!";
					$mail->Body = $cadena;	
					$mail->IsHTML(true);		
					$exito = $mail->Send();
					if($exito){
						$objResponse->alert("Se envio un correo con su password, favor de revisar su e-mail");
						$objResponse->script("window.close()");
					}else $objResponse->alert("Error en el envio, intente nuevamente".$mail->ErrorInfo);
			}
			else $objResponse->alert("Su nombre de usuario no coincide con su correo, favor de comunicarse a SEPROMEX");
		return $objResponse;
	}
	$xajax->ProcessRequest();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recuperar Contraseña</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function enInfo(){
	xajax_recPass(xajax.getFormValues("recupera"));
}
</script>
<?php $xajax->printJavaScript(); ?>
</head>
<body id="fondo" style='overflow:hidden;'>
<div id="fondo1">
	<div id="fondo2">
		<div id="fondo3">
			<div style='position:absolute;top:20px;left:20px;'>
			<form name="recupera" method="post" action="javascript:void(null);" id="recupera" onsubmit="enInfo();">
			  <table id='newspaper-a1'>
				<tr>
				  <td colspan="2">Inserte el usuario y el correo que registró en <br>nuestra empresa</td></tr>
				<tr>
				 <tr>
				  <td colspan="2">&nbsp;</td></tr>
				  <tr>
				  <td>Usuario:</td>
				  <td><input name="usuario" type="text" size="20" /></td>
				</tr>
				<tr>
				  <td>Correo:</td>
				  <td><input name="correo" type="text" size="20" /></td>
				</tr>
				<tr>
				  <td colspan="2">&nbsp;</td>
				</tr>
				<tr>  
				  <td colspan="2">
					<input type="submit" name="recupe" class='agregar1' value="Enviar" />
				  </td>
				</tr>
			  </table>
			</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>