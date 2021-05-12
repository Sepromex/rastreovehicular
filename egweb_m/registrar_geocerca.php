<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geocercas</title>
<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
$emp =  $_GET['ide'];
$lat =  $_GET['lat'];
$lon =  $_GET['lon'];
$rad =  $_GET['rad'];
$usuario = $_GET['idu'];

if($_POST['nombre']!='' && $_POST['latitud']!='' && $_POST['longitud']!='' && $_POST['enviar']=='Enviar'){
	$nombre = $_POST['nombre'];		$empresa = $_POST['empresa'];
	$latitud = $_POST['latitud'];	$longitud = $_POST['longitud'];
	$radio = $_POST['radio'];
	require("librerias/conexion.php");
	$cad_geo = "insert into geo_time (latitud,longitud,radioMts,agenda,nombre,tipo,id_empresa) ";
	$cad_geo .= "values ('$latitud','$longitud','$radio','0','$nombre','0','$empresa')"; //registrar geocercas circulares
	$resp = mysql_query($cad_geo);
	mysql_close(conec);
	if($resp != 0){
		$visible = "visibility:hidden";
		echo "<script type='text/javascript'>alert('Se registró la geocerca')</script>";
		echo "<script type='text/javascript'>window.close()</script>";
		echo "<script type='text/javascript'>opener.document.location.reload()</script>";
		
	}
	else{
	echo "<script type='text/javascript'>alert('No se registró la geocerca, vuelva a intentar')</script>";
		echo "<script type='text/javascript'>window.close()</script>";
	}
}
?>
<form id="form1" name="form1" method="post" action="registrar_geocerca.php" style=" <?php echo $visible;?>">
  <table width="332" border="0" class="fuente" >
    <tr class="fuente_cuatro">
      <td colspan="2"><div align="center">Registrar Geocercas</div>
      <input type="hidden" value="<?php echo $emp?>" name="empresa" />
      <input type="hidden" value="<?php echo $rad?>" name="radio" />
      </td>
    </tr>
    <tr>
      <td width="73">Nombre:</td>
      <td width="243"><input type="text" name="nombre" /></td>
    </tr>
    <tr>
      <td>Latitud:</td>
      <td><input type="text" name="latitud" readonly="readonly"  value="<?php echo $lat ?>"/></td>
    </tr>
    <tr>
      <td>Longitud:</td>
      <td><input type="text"  name="longitud"  readonly="readonly" value="<?php echo $lon ?>"/></td>
    </tr>
    <tr>
      <td>Radio:</td>
      <td><input type="text" name="radioMuestra" readonly="readonly" value="<?php echo number_format($rad,2,'.','')?>"/></td>
    </tr>
    <tr>
      <td><input type="submit" name="enviar" value="Enviar"  class="boton_x"/></td>
      <td><input type="button" name="reset" value="Reset"  class="boton_x"/></td>
    </tr>
  </table>
</form>
</body>
</html>
