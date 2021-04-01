<?
include("./librerias/conexion.php");
//?empresa=15
//$accion=$_GET['accion'];
//base 64 

$cadena=$_GET['eg'];
$params=explode("&",base64_decode($cadena));

list($n,$accion)=explode("=",$params[0]);
//echo $accion;
switch($accion){
	case 'folios'://ver los folios de la empresa
		list($ne,$empresa)=explode("=",$params[1]);
		list($nl,$limit)=explode("=",$params[2]);
		$l_folio="";
		if($limit){//si mando un limit, agrego a la consulta lo siguiente
			$l_folio=" and m.folio>".$limit;
		}
		$query=mysql_query("SELECT m.folio,m.descripcion,m.enviaremail FROM gpscondicionalerta m
		where m.id_empresa=".$empresa." and m.activo=1 $l_folio");
		$correos=mysql_query("SELECT * from correos_empresa where id_empresa=".$empresa." and activo=1");
		$i=0;
		if(mysql_num_rows($correos)>0){
			while($row=mysql_fetch_array($correos)){
				if($i==0){
					$cadena.=$row[0]."|";
				}
				$cadena.=$row[2].":".$row[3];//muestro en pantalla el resultado
				if($i<mysql_num_rows($correos)-1){
					$cadena.=";";
				}
				$i++;
			}
			echo $cadena.'%';
		}
		else{
			echo $empresa."|N/A%";
		}
		$i=0;
		while($row=mysql_fetch_array($query)){
			echo $row[0]."|".utf8_decode($row[1])."|".$row[2];//muestro en pantalla el resultado
			if($i<mysql_num_rows($query)-1){
				echo '%';
			}
			$i++;
		}
		break;
	case 'actualiza'://actualiza los correos del folio seleccionado
		list($ne,$empresa)=explode("=",$params[1]);
		list($ne,$folio)=explode("=",$params[2]);
		list($nm,$mail)=explode("=",$params[3]);
		$update="UPDATE gpscondicionalerta set enviaremail='".$mail."' where folio=".$folio;
		mysql_query($update);
		if(!mysql_error()){
			echo "UPDATE%".$folio."%OK";//respondo que se hizo bien el proceso
		}
		else{
			echo "UPDATE%".$folio."%ERROR";//respondo que se hizo mal el proceso
		}
		//echo $update;
		break;
	case 'insertar'://inserto la nuevo "regla"
		list($ne,$empresa)=explode("=",$params[1]);
		list($ne,$desc)=explode("=",$params[2]);
		list($nm,$mail)=explode("=",$params[3]);
		$desc=trim(addslashes(str_replace("%",' ',$desc)));
		$insert="INSERT INTO gpscondicionalerta values(0,'".$desc."',0,".$empresa.",'".
		date("Y-m-d H:i:s")."','".$mail."',0,0,1,1,-1,0,0,0,-1);";
		mysql_query($insert);
		if(!mysql_error()){
			echo "INSERT%".mysql_insert_id()."%OK";//respondo que se realizo bien el proceso y retorno el folio capturado
		}
		else{
			echo "INSERT%N/A%ERROR";//envio el error de que no se inserto la REGLA
		}
		//echo $insert;
		break;
	case 'borrar':
		list($nf,$folio)=explode("=",$params[1]);
		$borrar1="UPDATE gpscondicionalerta SET activo=0 WHERE folio=".$folio;
		mysql_query($borrar1);
		$borrar2="UPDATE gpscondicionalertadet SET activo=0 WHERE folio=".$folio;
		mysql_query($borrar2);
		if(!mysql_error()){
			echo "BORRAR%".$folio."%OK";//respondo que se realizo bien el proceso y retorno el folio "borrado"
		}
		else{
			echo "BORRAR%N/A%ERROR";//envio el error de que no se borro la REGLA
		}
		//echo $borrar;
		break;
}
?>