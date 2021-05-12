<?php
  include('conn.php');
  $query = "select ID_VEH from vehiculos";
  $result = mysql_query($query);
  while($row = mysql_fetch_array($result))
  {
    $veh = $row[0];
	$insert = "insert into usuario_veh (ID_USUARIO,ID_VEH) values(1,$veh)";	
	//mysql_query($insert);
	echo $veh."<br>";
  }
  
  
?>