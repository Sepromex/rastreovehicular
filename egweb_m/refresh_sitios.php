<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualiza_sitios</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
</head>
<body id="fondo" style='overflow:hidden;background:url(img2/main-bkg-00.png) transparent repeat;'>
<?php 
include_once('../patSession/patSession.php');
require("librerias/conexion.php");
switch($_GET['b']){
case 1:	if($_GET['ids']!='' && $_GET['ide']!=''){
			$cad_sitios = "select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_tipo from sitios s ";
			$cad_sitios .= "left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) where s.id_empresa = ".$_GET['ide']." and ";
			$cad_sitios .= "s.id_sitio = ".$_GET['ids'];
			$resp_sitios = mysql_query($cad_sitios);
			$s_row=mysql_fetch_array($resp_sitios);
		}
		else{ echo "<script type='text/javascript'>alert('No hay datos para actualizar')</script>";
			  echo "<script type='text/javascript'>window.close()</script>";
			}
break;
case 2:	if($_POST['nombre']!=''&& $_POST['tipo']!=''&& $_POST['lat']!=''&& $_POST['long']!=''){
			$cad_act="Update sitios set nombre='".$_POST['nombre']."',latitud='".$_POST['lat']."',longitud='".$_POST['long']."',";
			$cad_act.="contacto='".$_POST['contacto']."',tel1='".$_POST['tel1']."',tel2='".$_POST['tel2']."',id_tipo='".$_POST['tipo'];
			$cad_act.="' where id_empresa=".$_POST['empresa']." and id_sitio=".$_POST['sitio'];
			$act = mysql_query($cad_act);
			echo mysql_error();
			if($act != 0){
				$sess =& patSession::singleton('egw', 'Native', $options );
				$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',14,'Modificar sitio de interes',13,".$sess->get('Ide').")";
				mysql_query($consulta);
				//echo $consulta;
				echo "<script type='text/javascript'>alert('Se realizó su modificación')</script>";
				echo "<script type='text/javascript'>opener.document.location.href='catalogos.php?tipo=2'</script>";
				echo "<script type='text/javascript'>window.close()</script>";
				
			}
			else{
				echo "<script type='text/javascript'>alert('Falla al intentar actualizar')</script>";
				echo "<script type='text/javascript'>opener.document.location..href='catalogos.php?tipo=2'</script>";
				echo "<script type='text/javascript'>window.close()</script>";
				
				}
		}
		else{
			echo "<script type='text/javascript'>alert('Favor de llenar los campos marcados con *')</script>";
			echo "<script type='text/javascript'>window.close()</script>";
			}
break;
}
?>
<div id="fondo1" >
	<div id="fondo2" >
		<div id="fondo3" >
		<center>
<form id="sitios_act" name="sitios_act" method="post" action="refresh_sitios.php?b=2">
<div id="act_sitios">
  <table id='box-table-a1' style='margin:0px;padding:0px;'>
    <tr>
      <th colspan="2" align="center"  class="fuente_siete">ACTUALIZAR SITIOS DE INTERES</th>
    </tr>
    <tr>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td width="73">Nombre:</td>
      <td width="157"><label>
        <input name="nombre" type="text" id="nombre" value="<?php echo $s_row[0] ?>" size="20"/>
      </label></td>
    </tr>
    <tr>
      <td>Tipo</td>
      <td>
      <select name="tipo" >
      <?php 
	  	$c_tipo = "Select id_tipo,descripcion from tipo_sitios";
	  	$res_tipo = mysql_query($c_tipo);
	  	while($t_row = mysql_fetch_array($res_tipo)){
	  		$selected="";
	  		if($s_row[7]==$t_row[0]){
		  		$selected="selected";
	  		}
		  	echo "<option value='$t_row[0]' $selected>".htmlentities($t_row[1])."</option>";
	  	}
	  		
	  	?>
      </select>	  </td>
    </tr>
    <tr>
      <td>Longitud:</td>
      <td><input name="long" type="text" id="long" readonly="readonly" value="<?php echo $s_row[2] ?>" size="15"/></td>
    </tr>
    <tr>
      <td>Latitud:</td>
      <td><input name="lat" type="text" id="lat" readonly="readonly" value="<?php echo $s_row[1] ?>" size="15" /></td>
    </tr>
    <tr>
      <td>Contacto:</td>
      <td><input type="text" name="contacto" id="contacto" value="<?php echo $s_row[3] ?>"/></td>
    </tr>
    <tr>
      <td>Teléfono:</td>
      <td><input name="tel1" type="text" id="tel1"  value="<?php echo $s_row[4] ?>" size="15" maxlength="15"/></td>
    </tr>
    <tr>
      <td>Telefono:</td>
      <td><input type="text" name="tel2" id="tel2" value="<?php echo $s_row[5] ?>" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="button" id="button" value="Enviar" class="guardar1"/>
      	<input type="hidden" name="empresa" value="<?php echo $_GET['ide']?>" />	
       	<input type="hidden" name="sitio" value="<?php echo $_GET['ids']?>" />      </td>
      <td><label>
        <input type="button" name="button2" value="Reset"  class="cancelar1" onclick="alert('Se canceló su movimiento'); window.close();"/>
      </label></td>
    </tr>
  </table>
  </div>
</form>
</center>
        </div>
	</div>
</div>
</body>
</html>
