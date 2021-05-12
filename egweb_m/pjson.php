<?php
 $string = '{"id_veh":"P1-OKUBO","num_veh":54541,"telefonos":[{"panico":true,"geocercas":false,"geocercasp":true,"bateriabaja":false,"posicion":true,"simpacto":false},{"panico":true,"geocercas":false,"geocercasp":true,"bateriabaja":false,"posicion":true,"simpacto":false},{"panico":true,"geocercas":false,"geocercasp":true,"bateriabaja":false,"posicion":true,"simpacto":false}]}';
 //$string = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
 $decoded = json_decode($string);
 //echo $decoded->{'id_veh'}."<br><br>";
 //echo $decoded->{'num_veh'}."<br><br>";
 $object = $decoded->{'telefonos'};
 //var_dump($decoded);
 //echo "<br><br>".$object[0]->{'panico'}."<br>";
 
 //var_dump($object[0]->{'panico'});
 
 $json = array();
 $json['id_veh'] = "P1-OKUBO";
 $json['num_veh'] = 54541;
 $json['telefonos'] = array();
 $tel1Array = array();
 $tel1Array['panico'] = true;
 $tel1Array['geocercas'] = true;
 $tel1Array['geocercasp'] = true;
 $tel1Array['bateriabaja'] = true;
 $tel1Array['posicion'] = true;
 $tel1Array['simpacto'] = true;
 $json['telefonos'][0] = $tel1Array;
 $tel1Array = array();
 $tel1Array['panico'] = false;
 $tel1Array['geocercas'] = true;
 $tel1Array['geocercasp'] = false;
 $tel1Array['bateriabaja'] = true;
 $tel1Array['posicion'] = false;
 $tel1Array['simpacto'] = true; 
 $json['telefonos'][1] = $tel1Array;
 $tel1Array = array();
 $tel1Array['panico'] = false;
 $tel1Array['geocercas'] = false;
 $tel1Array['geocercasp'] = false;
 $tel1Array['bateriabaja'] = false;
 $tel1Array['posicion'] = false;
 $tel1Array['simpacto'] = false;  
 $json['telefonos'][2] = $tel1Array;
 $a = array('<foo>',"'bar'",'"baz"','asdas');
 $encoded = json_encode($json);
 
 //echo "<br><br><br>".$encoded ;
?>
<html>
	<head>
<script type="text/javascript" language="javascript" src="librerias/json2.js"></script>	
<script>
var StringJson = '{"id_veh":"P1-OKUBO","num_veh":54541,"telefonos":[{"panico":true,"geocercas":true,"geocercasp":true,"bateriabaja":true,"posicion":true,"simpacto":true},';
StringJson += '{"panico":false,"geocercas":true,"geocercasp":false,"bateriabaja":true,"posicion":false,"simpacto":true},{"panico":false,"geocercas":false,"geocercasp":false,"bateriabaja":false,"posicion":false,"simpacto":false}]}';
function pruebaJson(){
	var JSONobject = JSON.parse(StringJson);
	var div = document.getElementById("respuesta");
	div.innerHTML += "Campo id_veh: "+JSONobject.id_veh+"<br>";
	div.innerHTML += "Campo num_veh: "+JSONobject.num_veh+"<br>";
	div.innerHTML += "Numero de telefonos "+JSONobject.telefonos.length+"<br>";
	
	for(i = 0 ; i < JSONobject.telefonos.length ; i++ ){
		div.innerHTML += "Telefono "+(i+1)+"<br>";
		div.innerHTML += "Numero: "+JSONobject.telefonos[i].numero+"<br>";
		div.innerHTML += "Panico: "+JSONobject.telefonos[i].panico+"<br>";
		div.innerHTML += "Geocercas: "+JSONobject.telefonos[i].geocercas+"<br>";
		div.innerHTML += "GeocercasP: "+JSONobject.telefonos[i].geocercasp+"<br>";
		div.innerHTML += "Bateria baja: "+JSONobject.telefonos[i].bateriabaja+"<br>";
		div.innerHTML += "Posicion: "+JSONobject.telefonos[i].posicion+"<br>";
		div.innerHTML += "S imapcto: "+JSONobject.telefonos[i].simpacto+"<br>";
	}
	
}
</script>
	</head>
	<body>
		<input type="button" value="prueba" onclick="pruebaJson();" />
		<div id="respuesta">
		</div>
	</body>
</html>