<?
#Agregamos la tabla para "FATIGA"-->
$formu.="
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
			Desactivado:<input type='radio' name='inactividad' id='inactivo2'>
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
		<td><input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"inactivo\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='UCAN(\"inactivo\",\"set\",\"distSA@tiemSA\")'></td>
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
			Desactivado:<input type='radio' name='movs' id='motion2'>
		</td>
	</tr>
	<tr>
		<td>Fuerza del movimiento</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='mfuer' value='5' max='15' min='1' onchange='rangevalueFM.value=value'/>
				<span class='highlight'></span>
				<output id='rangevalueFM'>5</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener'  class='agregar1' onclick='UCAN(\"motion\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar'  class='guardar1' onclick='UCAN(\"motion\",\"set\",\"mfuer\")'></td>
	</tr>
</table><hr>";
?>
