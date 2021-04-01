<?
$formu.="
<!--#tabla para remolcados-->
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>Remolcado <br> <div id='remolcar'></div></th>
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
			if(x < 5){alert(\"No puede ser menor a 5 Mts \");dist.value=1; dist.focus();}
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
			if(x < 5){alert(\"No puede ser menor a 5 Segundos \");rtm.value=1; rtm.focus();}
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
		<td><input type='button' value='Obtener' class='agregar1' onclick='U1LITE(\"remolcar\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='U1LITE(\"remolcar\",\"set\",\"rdist@rtiempo@rsen@rfuer\")'></td>
		
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
		<td><input type='button' value='Obtener' class='agregar1' onclick='U1LITE(\"inactivo\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='U1LITE(\"inactivo\",\"set\",\"distSA@tiemSA\")'></td>
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
		<td><input type='button' value='Obtener'  class='agregar1' onclick='U1LITE(\"motion\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar'  class='guardar1' onclick='U1LITE(\"motion\",\"set\",\"mfuer\")'></td>
	</tr>
</table><hr>";
?>
