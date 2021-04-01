<?
	$tipo=$_GET['tipo'];
	$contenido="";
	$info='';
	if($tipo=='interes'){
		$contenido="Esta herrramienta sirve para crear en nuestro mapa un punto de referencia. <br>
					Este punto de referencia nos puede ayudar a controlar mas nuestros veh&iacute;culos
					ya que podemos crear cuantos sitios de interes necesitemos.
					<img src='img2/sitios.png'>";
		$info="Sitios de Interes.";
	}
	if($tipo=='cerca'){
		$contenido="Al posicionarnos sobre este icono nos desplegar&aacute; los diferentes tipos de geocercas que podemos asignar 
					a nuestros veh&iacute;culos.<br>
					<img src='img2/geocercas.png'>
					<br>
					Cuando demos click en alguna de ellas, se activara la funcion correspondiente para generar el tipo de geocerca seleccionado en el mapa,
					solo bastara con posicionarnos sobre el mapa para comenzar a dibujar nuestra geocerca.<br>
					<img src='img2/circular.png'>
					";
		$info="Geocercas.";
	}
	if($tipo=='satelite'){
		$contenido="Esta herramienta sirve para actualizar la posici&oacute;n de nuestro veh&iacute;culo cada que demos clic en este icono.<br>
					Muchos de nuestros veh&iacute;culos actualizan su posici&oacute;n cada determinado tiempo, pero si necesitamos su posicion actual
					al momento, basta con dar clic en este icono.";
		$info="Solicitar Posici&oacute;n.";
	}
	if($tipo=='expandir'){
		$contenido="";
		$info="Sitios de Interes.";
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contacto</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
</head>
<body id="fondo" style='width:400px;'>
<center>
<div id="fondo1">
	<div id="fondo2">
		<div id="fondo3">
		<div style='position:absolute;top:0px;left:40px;'>
		<table id='rounded-corner' style='width:320px;'>
			<tr>
				<th align='center'>Informaci&oacute;n  de:  <? echo $info;?></th>
			</tr>
			<tr>
				<td>
					<? echo $contenido;?>
				</td>
			</tr>
		</table>
		</div>
		</div>
	</div>
</div>
</center>
</body>
</html>