<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Geocercas Poligonales</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
</head>
<body id="fondo" style="overflow:hidden;">
<?php 
	if($_GET['ide']!='' && $_GET['cons']!=''){
		$ide  =  $_GET['ide'];
		$cons = $_GET['cons'];
		$idu = $_GET['idu'];
	}
	if($_POST['nombre']!=''){
		$nombre = $_POST['nombre'];
		$ide = $_POST['empresa'];
		$visible = "visibility:hidden";
		require("librerias/conexion.php");
		$cad_geo = "insert into geo_time (latitud,longitud,radioMts,agenda,nombre,id_usuario,tipo,id_empresa) ";
		$cad_geo .= "values('0','0','0','0','$nombre','0','1','$ide')";
		//echo $cad_geo;
		$resp = mysql_query($cad_geo);
		if($resp != 0){
			$newgeo = mysql_insert_id($conec);
	    	$consulta = str_replace(",","','",$_POST['consulta']); 
			$consulta = str_replace("(","('",$consulta); 
			$consulta = str_replace(")","'),",$consulta);
			$consulta = str_replace("),:",")",$consulta);
			$consulta = str_replace("num_geo",$newgeo,$consulta);
			$cad_cons = "insert into geo_puntos (latitud,longitud,orden,id_geo) values $consulta";
			//echo $cad_cons;
			$resp_puntos = mysql_query($cad_cons);
				if($resp_puntos != 0){
					echo "<script type='text/javascript'>alert('Se registró la geocerca')</script>";
					//echo "<script type='text/javascript'>window.close()</script>";
					echo "<script type='text/javascript'>window.location.href='principal.php'</script>";
					mysql_close($conec);
				}
				else{echo "<script type='text/javascript'>alert('Falló el registro')</script>";
					echo "<script type='text/javascript'>window.location.href='principal.php'</script>";
				 	//echo "<script type='text/javascript'>opener.document.location.reload()</script>";
				}
		}
		else{
			echo "<script type='text/javascript'>alert('Falló el registro, Intente nuevamente')</script>";
			echo "<script type='text/javascript'>window.location.href='principal.php'</script>";
			//echo "<script type='text/javascript'>opener.document.location.reload()</script>";
		}
	}
?>
<div style='position:absolute;left:30px;top:20px;'>
<form id="form-pol" name="form" method="post" action="registra_geo_pol.php" style=" <?php echo $visible; ?>">
 
	<table border="0" class="fuente" id='newspaper-a1'>
      <tr class="fuente_cuatro">
        <td colspan="2"><div align="center">Registrar Geocerca Poligonal</div></td>
      </tr>
      <tr>
        <td width="61">Nombre:</td>
        <td width="215"><input type="text" name="nombre" id="nombre"  /></td>
      </tr>
      <tr>
        <td colspan='2' align='center'>
			<!--<input type="submit" name="enviar" class='guardar1' id="enviar" value="Enviar" />
			<input type="button" onclick="window.location.href='principal.php'" name="cancelar" class='cancelar1' id="cancelar" value="Cancelar" />-->
			<input type="hidden" name="empresa"  value="<?php echo $ide?>"/>
			<input type="hidden" name="consulta" id="consulta"  value="<?php echo $cons?>"/>
		</td>
      </tr>
    </table>
 </form> 
</div>
</body>
</html>
