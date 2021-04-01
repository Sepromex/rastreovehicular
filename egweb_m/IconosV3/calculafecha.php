<html>
<head>
<script>
function calculaFecha()
{
	var fecha1 = document.getElementById("fecha1").value;
	var fecha2 = document.getElementById("fecha2").value;
	var nuevoCorreo = fecha1;
	var filtro=/^[A-Za-z][A-Za-z0-9_.\-]*@[A-Za-z0-9_.\-]+\.[A-Za-z0-9_.]+[A-za-z]$/;
	var filtro2 = /^1\/2$/;
	var filtro3 = /^[0-9][0-9][0-9][0-9]-[0-1][1-2]-[0-3][0-9] [0-2]$/;
	var filtro4 = /^\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:\d{1,2}$/;
	if(filtro4.test(fecha1) && filtro4.test(fecha2) )
	{
		var arrayFecha1 = fecha1.split(" ");
		var arrayFecha2 = fecha2.split(" ");
		arrayFecha1 = arrayFecha1[0].split("-");
		arrayFecha2 = arrayFecha2[0].split("-");
		var date1 = new Date(arrayFecha1[0] , arrayFecha1[1] , arrayFecha1[2]);
		var date2 = new Date(arrayFecha2[0] , arrayFecha2[1] , arrayFecha2[2]);
		if( date1 >= date2)
		{
			var one_day=1000*60*60*24;		
			alert("Diferencia: "+Math.ceil((date1.getTime()-date2.getTime())/(one_day)));		
		}else alert("Tiene que ser mayor date1");
	}
	else alert("False");
}	
</script>
</head>
<body>
	<input type="text" id="fecha1" name="fecha1" /> <br>
	<input type="text" id="fecha2" name="fecha2" /><br>
    <input type="button" value="Calcula" onclick="calculaFecha();" />	
</body>
</html>