<?php

header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=Tiempos_sin_movimiento-".date("Y-m-d H-i-s").".xls");
header("Cache-Control:");
header("Pragma: ");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//require("librerias/conexion.php");

$dsn=$_POST['dsn'];

  echo $dsn;
 ?>
</body>
</html> 
 
 