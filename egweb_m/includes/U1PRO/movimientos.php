<?
#Agregamos la tabla para "FATIGA"-->
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>
			Alerta de Fatiga
			<div id='fatigue'></div>
		</th>
	</tr>
	<tr>
		<td>
			Tiempo:<input type='text' id='tiempo' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tiempo = document.getElementById(\"tiempo\");
			var s = tiempo.value;
			var max = 1092;
			if(s<1){alert(\"No puede ser menor a 1 hora \");tiempo.value=1; tiempo.focus();}
			if(s>max){alert(\"No puede ser mayor a 1092 horas. \"); tiempo.value=max; tiempo.focus();}
			'
			>
		</td>
		<td>
			Distancia:<input type='text' id='distancia' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var dis = document.getElementById(\"distancia\");
			var x = parseFloat(dis.value);
			var max = 4000000;
			if(x < 1){alert(\"No puede ser menor a 1 Km \");dis.value=1; dis.focus();}
			if(x > max){alert(\"No puede ser mayor a 4,000,000 Kms. \"); dis.value=max; dis.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td>
			<input type='radio' name='fatigar' id='fatigue1'>Por Minutos
			<br>
			<input type='radio' name='fatigar' id='fatigue2'>Por Distancia
		</td>
		<td>
			<input type='radio' name='fatigar' id='fatigue3'>Por Tiempo Y Distancia
			<br>
			<input type='radio' name='fatigar' id='fatigue4'>
			Por Tiempo &Oacute; Distancia
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Obtener Fatiga' class='agregar1' onclick='U1PRO(\"fatigue\",\"get\",\"\")' >
		</td>
		<td>
			<input type='button' value='Guardar Fatigas' class='guardar1' onclick='U1PRO(\"fatigue\",\"set\",\"tiempo@distancia\")' >
		</td>
	</tr>
</table><hr>
<!--#tabla para remolcados-->
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>Remolque <br> <div id='remolcar'></div></th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='remolque' id='remolcar1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='remolque' id='remolcar0'>
		</td>
	</tr>
	<tr>
		<td>
			Distancia (Mts)
		</td>
		<td>
			<input type='text' size='4' id='rdist' onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var dist = document.getElementById(\"rdist\");
			var x = parseFloat(dist.value);
			var max = 1000;
			if(x < 5){alert(\"No puede ser menor a 5 Mts \");dist.value=5; dist.focus();}
			if(x > max){alert(\"No puede ser mayor a 1,000 Mts. \"); dist.value=max; dist.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td>
			Tiempo (Seg)
		</td>
		<td>
			<input type='text' size='4' id='rtiempo' 
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var rtm = document.getElementById(\"rtiempo\");
			var x = parseFloat(rtm.value);
			var max = 1000;
			if(x < 5){alert(\"No puede ser menor a 5 Segundos \");rtm.value=5; rtm.focus();}
			if(x > max){alert(\"No puede ser mayor a 1,000 Segundos \"); rtm.value=max; rtm.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td>
			Sensibilidad
		</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='rsen' value='15' max='50' min='2' onchange='range.value=value'/>
				<span class='highlight'></span>
				<output id='range'>10</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td>
			Fuerza
		</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='rfuer' value='5' max='16' min='1' onchange='rangeF.value=value'/>
				<span class='highlight'></span>
				<output id='rangeF'>5</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='U1PRO(\"remolcar\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='U1PRO(\"remolcar\",\"set\",\"rdist@rtiempo@rsen@rfuer\")'></td>
		
	</tr>
</table><hr>
<!--#tabla para Sin Actividad-->
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>Sin Actividad <div id='inactivo'></div></th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='inactividad' id='inactivo1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='inactividad' id='inactivo0'>
		</td>
	</tr>
	<tr>
		<td>Distancia M&iacute;nima</td>
		<td>
			<input type='text' id='distSA' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var dm = document.getElementById(\"distSA\");
			var x = parseFloat(dm.value);
			var max = 65535;
			if(x < 1){alert(\"No puede ser menor a 1 Metro \");dm.value=1; dm.focus();}
			if(x > 65535){alert(\"No puede ser mayor a 65.5 Kms \"); dm.value=max; dm.focus();}
			'
			>
			Metros
		</td>
	</tr>
	<tr>
		<td>Tiempo M&aacute;ximo</td>
		<td>
			<input type='text' id='tiemSA' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tm = document.getElementById(\"tiemSA\");
			var x = parseFloat(tm.value);
			var max = 255;
			if(x < 1){alert(\"No puede ser menor a 1 Minuto \");tm.value=1; tm.focus();}
			if(x > max){alert(\"No puede ser mayor a 255 Minutos \"); tm.value=max; tm.focus();}
			'
			>
			Segundos
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='U1PRO(\"inactivo\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='U1PRO(\"inactivo\",\"set\",\"distSA@tiemSA\")'></td>
	</tr>
</table><hr>
<!--#tabla para En Movimiento-->
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>Veh&iacuteculo en Movimiento <div id='motion'></div></th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='movs' id='motion1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='movs' id='motion0'>
		</td>
	</tr>
	<tr>
		<td>Fuerza del movimiento</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='mfuer' value='5' max='15' min='1' onchange='rangeFM.value=value'/>
				<span class='highlight'></span>
				<output id='rangeFM'>5</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener'  class='agregar1' onclick='U1PRO(\"motion\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar'  class='guardar1' onclick='U1PRO(\"motion\",\"set\",\"mfuer\")'></td>
	</tr>
</table><hr>
<table id='rounded-corner' >
	<tr>
		<th colspan='1'>
			Od&oacute;metro
		</th>
		<th><div id='odo'></div></th>
		
	</tr>
	<tr>
		<td>Kilometraje</td>
		<td>
			<input type='text' size='10' maxlength='10'
			id='odometro'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var odometro = document.getElementById(\"odometro1\");
			var s = odometro.value;
			if(s>4294967295){alert(\"No puede ser mayor a 4294967295 \"); odometro.value=4294967295; odometro.focus();}
			'
			>
			<br>
			(0-4294967295 km)
		</td>
	</tr>
	<tr>
		<td width='210px'>
			Reiniciar al Encender:
		</td>
		<td>
			Activado:<input type='radio' name='odometro' id='odo1'><br>
			Desactivado:<input type='radio' name='odometro' id='odo0'>
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Obtener Od&oacute;metro' class='agregar1' onclick='U1PRO(\"odo\",\"get\",\"\")'>
		</td>
		<td>
			<input type='button' value='Guardar Od&oacute;metro' class='guardar1' onclick='U1PRO(\"odo\",\"set\",\"odometro\")'>
		</td>
	</tr>
	<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
</table><hr>";
?>
