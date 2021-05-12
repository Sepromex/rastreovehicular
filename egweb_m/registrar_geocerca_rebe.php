<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geocercas</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
</head>
<body id="fondo" style='overflow:hidden;'>
<?php 
$emp =  $_GET['ide'];
$lat =  $_GET['lat'];
$lon =  $_GET['lon'];
$rad =  $_GET['rad'];
$idu = $_GET['idu'];

if($_POST['nombre']!='' && $_POST['latitud']!='' && $_POST['longitud']!='' && $_POST['enviar']=='Enviar'){
	$nombre = $_POST['nombre'];		$empresa = $_POST['empresa'];
	$latitud = $_POST['latitud'];	$longitud = $_POST['longitud'];
	$radio = $_POST['radio'];
	require("librerias/conexion.php");
	$cad_geo = "insert into geo_time (latitud,longitud,radioMts,agenda,nombre,tipo,id_empresa,id_usuario) ";
	$cad_geo .= "values ('$latitud','$longitud','$radio','0','$nombre','0','$empresa','$idu')"; //registrar geocercas circulares
	$resp = mysql_query($cad_geo);
	//mysql_close(conec);
	if($resp != 0){
		$visible = "visibility:hidden";
		echo "<script type='text/javascript'>alert('Se registró la geocerca')</script>";
		echo "<script type='text/javascript'>window.location.href='principal.php'</script>";
		
	}
	else{
		echo "<script type='text/javascript'>alert('No se registró la geocerca, vuelva a intentar')</script>";
		echo "<script type='text/javascript'>window.location.href='principal.php'</script>";
	}
}
?>
<div style="position:absolute;left:10px;">
<form id="form-circ" name="form1" method="post" action="registrar_geocerca_rebe.php" style=" <?php echo $visible;?>">
  <table width="280" border="0" class="fuente" id='newspaper-a1' >
    <tr class="fuente_cuatro">
      <td colspan="2"><div align="center">Registrar Geocercas</div>
      <input type="hidden" value="<?php echo $emp?>" name="empresa" />
      <input type="hidden" value="<?php echo $rad?>" name="radio" />
      </td>
    </tr>
    <tr>
      <td width="73">Nombre:</td>
      <td width="243"><input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td>Latitud:</td>
      <td><input type="text" name="latitud" id="latitud" readonly="readonly"  value="<?php echo $lat ?>"/></td>
    </tr>
    <tr>
      <td>Longitud:</td>
      <td><input type="text"  name="longitud" id="longitud"  readonly="readonly" value="<?php echo $lon ?>"/></td>
    </tr>
    <tr>
      <td>Radio:</td>
      <td><input type="text" name="radioMuestra" id="radioMuestra" readonly="readonly" value="<?php echo number_format($rad,2,'.','')?>"/></td>
    </tr>
     <!--<tr>
     <td><input type="submit" name="enviar" value="Enviar"  class="guardar1"/></td>
      <td><input type="button" name="reset" value="Cancelar" onclick="window.location.href='principal.php'"  class="cancelar1"/></td>
    </tr>-->
  </table>
</form>
</div>
</body>
</html>
