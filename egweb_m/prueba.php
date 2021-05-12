<?php 

	require_once 'librerias/reader.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read("prueba.xls");
	error_reporting(E_ALL ^ E_NOTICE);

	echo "Rows: ".$data->sheets[0]['numRows']." Cols: ".$data->sheets[0]['numCols'];
	$array = $data->sheets[0]['cells'];
	echo "<br>PRUEBA: ".$array[1][3];
	echo "<br>Cantos : ".count($array);
				

?>