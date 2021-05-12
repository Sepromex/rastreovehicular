<?php
  include('conn.php');
  include('../adodb/adodb.inc.php');
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $estses = $sess->getState();
  
  if (isset($_GET["Logout"])) {
    $sess->Destroy();
    header("Location: index.php");
  }
  
  if ($estses == empty_referer) {
	header("Location: index.php");
  } 
  $result = $sess->get( 'expire-test' );
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
	$queryString = $sess->getQueryString();	
	$idu = $sess->get("Idu");
	$ide = $sess->get("Ide");
    $usn = $sess->get("Usn");
	$pol = $sess->get("Pol");
	$reg = $sess->get('Registrado');
	$nom = $sess->get("nom");
	$eve = $sess->get('eve');
	if (!$reg) {
	    $sess->set('Registrado',1);	
	}	
  }	else {
      $sess->Destroy();
      header("Location: index.php");
  }          
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesar Sitios</title>
<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
//esta funcion lee el archivo *.xls
if($_FILES['imp_excel']['name'] != '' && $_POST['procesa']=='Procesa'){
	require("librerias/conexion.php");	
	chmod("http://www.sepromex.com.mx:81/sistema_EGWEB/upload_sitios/", 777);

	if(!copy($_FILES['imp_excel']['tmp_name'],"http://www.sepromex.com.mx:81/sistema_EGWEB/upload_sitios/".$_FILES['imp_excel']['name']))
	{
		 echo "Error al copiar ...\n";
	}
	else{
		echo $_FILES['imp_excel']['tmp_name'];
	}
	$path = "http://www.sepromex.com.mx:81/sistema_EGWEB/upload_sitios/".$_FILES['imp_excel']['name'];
	require('librerias/reader.php');
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($path);
	error_reporting(E_ALL ^ E_NOTICE);
	
	$cad_sitios = "insert into sitios_temp (id_tipo,nombre,latitud,longitud,contacto,tel1,tel2,id_empresa) values ";
		for ($i = 4; $i <= $data->sheets[0]['numRows']; $i++) {
			$cad_sitios .= "('1',";
			for ($j = 2; $j <= $data->sheets[0]['numCols']; $j++) {
				$cad_sitios .= "'".$data->sheets[0]['cells'][$i][$j]."',";
			}
			$cad_sitios .= "'$ide'),";
		}
	$cad_sitios .=";";
	unlink($path); //elimino el archivo xls despues de leerlo.
	$cad_sitios=str_replace(",),","),",$cad_sitios); 
	$cad_sitios=str_replace("),;",");",$cad_sitios); 
	$resp = mysql_query($cad_sitios);
	$cad_temp = "Select * from sitios_temp where id_empresa =".$ide;
	$resp = mysql_query($cad_temp);
	$cad_tsitios = "select id_tipo,descripcion from tipo_sitios where id_empresa = $ide or id_empresa = 15";
	$t_resp = mysql_query($cad_tsitios);
	while($t_fila = mysql_fetch_array($t_resp)){
		$tipos .= "<option value='$t_fila[0]'>".htmlentities($t_fila[1])."</option>";
	}
	mysql_close($conec);
}
else{
echo "NO MANDA";
$visible = "visibility:hidden";
}

//Guarda los sitios de interes luego de ser modificado el tipo
if ($_POST["nombre"]!= '' && $_POST['band'] == 'Enviar'){
	$cad_insert = "Insert into sitios (id_tipo,nombre,latitud,longitud,contacto,tel1,tel2,id_empresa) values ";
     	foreach ($_POST["nombre"] as $indic => $nombre) {   
           $cad_insert .= "('".$tipo=$_POST["tipo"][$indic] ."',";		   
           $cad_insert .= "'".$nombre=$_POST["nombre"][$indic] ."',";
		   $cad_insert .= "'".$lat=$_POST["lat"][$indic] ."',";		   
		   $cad_insert .= "'".$long=$_POST["Long"][$indic] ."',";		   
		   $cad_insert .= "'".$contacto=$_POST["Contacto"][$indic] ."',";
		   $cad_insert .= "'".$tel1=$_POST["tel1"][$indic] ."',";
		   $cad_insert .= "'".$tel2=$_POST["tel2"][$indic] ."',";		   
		   $cad_insert .= "'".$ide."'),";
      	}
		$cad_insert .= ";";  
		$cad_insert=str_replace("),;",");",$cad_insert);
		require("librerias/conexion.php");	
		$resp_sitios = mysql_query($cad_insert);
		if($resp_sitios != 0){
			mysql_query("delete from sitios_temp where id_empresa = $ide");
			echo "<script type='text/javascript'>alert('Se exportaron correctamente sus datos')</script>";
			mysql_close(conec);
			echo "<script type='text/javascript'>window.parent.location='principal.php'</script>";
		}else echo "<script type='text/javascript'>alert('No se exportaron correctamente sus datos')</script>";
		mysql_close(conec);
		$visible = "visibility:hidden";  
 }

//Guarda las categorias para los sitios de interes
if($_POST['nombre']!='' && $_POST['enviar']=='Enviar' && $_FILES['imagen']['name']!=''){
	$acep = copy($_FILES['imagen']['tmp_name'],"iconos_sitios/".$ide."_".$_FILES['imagen']['name']);
	if($acep!= 0 ){
		$descrip = $_POST['nombre'];
		require("librerias/conexion.php");
		$imagen = "iconos_sitios/".$ide."_".$_FILES['imagen']['name'];
		$cad_tipo = "insert into tipo_sitios (descripcion,imagen,id_empresa) values ('$descrip','$imagen','$ide')";
		$resp = mysql_query($cad_tipo);
		mysql_close($conec);
			if($resp!=0){
			echo "<script type='text/javascript'>alert('Sus datos se Guardaron Correctamente')</script>";
			echo "<script type='text/javascript'>window.parent.location='principal.php'</script>";
			}
	}else echo "<script type='text/javascript'>alert('Revise Su imagen, puede que haya problemas')</script>";
}
?>

<form id="form1" name="form1" method="post" action="procesar_imp.php" style=" <? echo $visible;?>" >
  <table width="592" border="0">
  	<tr style='background:#204A7F' class='fuente_siete'>
      <td colspan="7">Seleccione el Tipo de Sitio Para Cada Fila</td>
    </tr>
    <tr style='background:#204A7F' class='fuente_siete'>
      <td>Nombre</td>
      <td>Tipo</td>
      <td>Latitud</td>
      <td>Longitud</td>
      <td>Contacto</td>
      <td>Tel.</td>
      <td>Tel.</td>
    </tr>
<?php 
$i==0;
while($fila = mysql_fetch_array($resp)){?>
	<tr>
	<td><input type="text" name="nombre[<?php echo $i?>]" value="<?php echo $fila[2]?>"  size="15" readonly="readonly"/></td>
	<td>
    	<select name="tipo[<?php echo $i?>]" id="select">
        <?php echo $tipos?>
        </select>
    </td>
	<td><input type="text" name="lat[<?php echo $i?>]" value="<?php echo $fila[3]?>" size="10" readonly="readonly"/></td>
	<td><input type="text" name="Long[<?php echo $i?>]" value="<?php echo $fila[4]?>" size="10" readonly="readonly" /></td>
	<td><input type="text" name="Contacto[<?php echo $i?>]" value="<?php echo $fila[5]?>" size="20" readonly="readonly"/></td>
	<td><input type="text" name="tel1[<?php echo $i?>]" value="<?php echo $fila[6]?>" size="15" readonly="readonly"/></td>
	<td><input type="text" name="tel2[<?php echo $i?>]" value="<?php echo $fila[7]?>" size="15" readonly="readonly"/></td>
	</tr>
<?php
$i++;
}
?>
</table>
<label><input type="submit" name="band" value="Enviar" />
</label><input type="button" name="cancel" value="Cancelar" onclick="window.parent.location='catalogos.php'"/>
</form>
<label></label>
</body>
</html>
