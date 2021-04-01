<?php 
       
//se registran variables
require("librerias/conexion.php"); 
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"eliminar");
$xajax->register(XAJAX_FUNCTION,"inicio");
$xajax->register(XAJAX_FUNCTION,"busquedaX");

function inicio($idu,$est){
$objResponse = new xajaxResponse();
$cad_asn  = "select v.id_veh, v.num_veh";
$cad_asn .= " from veh_usr vu";
$cad_asn .= " inner Join vehiculos v on vu.num_veh = v.num_veh";
$cad_asn .= " where vu.id_usuario =  $idu";
$cad_asn .= " order by v.id_veh asc";
$res_asn = mysql_query($cad_asn);
if(mysql_num_rows($res_asn)){
	$dsn = "<table width='200' border='0' class='fuente_diez'>";
	$dsn .= "<tr style='background:#002B5C;color:#FFFFFF;'>";
	$dsn .= "<td>Vehículo</td><td>&nbsp;</td>";
	$dsn .= "</tr>";
		while($row = mysql_fetch_array($res_asn)){
		  $dsn .= "<tr><td>$row[0] $row[2]</td><td>";
		  if($est!=3){
			$dsn .= "<a href='javascript:void(null);' onclick='elimina_asg($row[1],".$_GET['idu'].")'><img src='img/ico_delete.png' border='0' ></a>";
		  }
		  $dsn .= "</td>";
		  $dsn .= "</tr>";
		}
	$dsn .= "</table>";
	$objResponse->assign('cuerpo1','innerHTML',$dsn);
}else
$objResponse->assign('cuerpo1','innerHTML','No hay vehículos asignados');
return $objResponse;
}

function eliminar($idv,$idu){
$objResponse = new xajaxResponse();
	$cad_asg = "delete from veh_usr where id_usuario='$idu' and num_veh='$idv'";
	$res_asg = mysql_query($cad_asg);
	if($res_asg){
		$objResponse->alert('Se eliminó la asignación');
		$objResponse->call("xajax_inicio",$idu);
	}
	else $objResponse->alert('Falló la solicitud');
return $objResponse;
}

function busquedaX($carros,$text)
{
	$objResponse = new xajaxResponse();
	$objResponse->alert(count($carros));
	return $objResponse;
}

$xajax->processRequest();     
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vehiculos Asignados</title>
</head>
<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var Carros = new Array();

function elimina_asg(idv,idu){
var c = confirm("¿Está usted seguro de eliminar la asignación?");
	if(c)
		xajax_eliminar(idv,idu);
}

function CuantosCarros()
{
	alert(Carros.length);
}

function tecla()
{
    var Tabla = "<table>";
	itemToFind = document.getElementById("busqueda").value.toLowerCase();
	if(itemToFind != "")
	{
		document.getElementById("cual").innerHTML = itemToFind;
		for( i = 0; i < Carros.length; i++)
		{
			if( Carros[i].toLowerCase().indexOf(itemToFind) > -1 )
			{
				Tabla += "<tr><td>"+Carros[i]+"</td></tr>";
			}
		}
		document.getElementById("sorting").innerHTML = Tabla;
	}else
	{
		document.getElementById("cual").innerHTML = itemToFind;
		for( i = 0; i < Carros.length; i++)
		{
			Tabla += "<tr><td>"+Carros[i]+"</td></tr>";			
		}
		document.getElementById("sorting").innerHTML = Tabla;	
	}
}

</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<body>
 <input type="text" id="busqueda" OnKeyUp="tecla();" disabled=true /><input type="button"  value="Checa"  onclick="CuantosCarros();" />
 <p id="cual">
   
 </p>
 <div id="sorting">
    <table >
	 <?php
	   
	   $carros = "select id_veh from vehiculos";
	   $result = mysql_query($carros);
	   while( $row = mysql_fetch_array($result))
	   {
			echo "<tr><td>$row[0]</td></tr>";
	   ?>
	    <script language="JavaScript">
		  Carros.push("<?php echo $row[0] ?>");
		</script>
	   <?php
	   }
	 ?>
	<script language="JavaScript">
		document.getElementById("busqueda").disabled= false;
    </script>
	</table>
 </div>
</body>
</html>
