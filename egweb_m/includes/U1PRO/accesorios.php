<?
$formu.="<table id='rounded-corner' >
	<tr>
		<th colspan='2'>Temperatura<div id='temp'></div></th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='activo' id='temp1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='activo' id='temp0'>
		</td>
	</tr>
	<tr>
		<td>Sensor</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='sensor' value='2' max='4' min='1' onchange='rangeF.value=value'/>
				<span class='highlight'></span>
				<output id='rangeF'>2</output> 
			</div>
	</tr>
	<tr>
		<td colspan='2'>Rango:
			<select id='rango'>
				<option value='D'>Dentro</option>
				<option value='F'>Fuera</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan='2'>Temperatura</td>
	</tr>
	<tr>
		<td>
			Minima:
		</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='minima' value='20' max='850' min='-100' onchange='range.value=value'/>
				<span class='highlight'></span>
				<output id='range'>20</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td>M&aacute;xima:</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='maxima' value='0' max='850' min='-100' onchange='rangeFM.value=value'/>
				<span class='highlight'></span>
				<output id='rangeFM'>30</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td>Tiempo en esta condici&oacute;n</td>
		<td><input type='text' id='tiempo' 
		onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
		onblur='
		var tmp = document.getElementById(\"tiempo\");
		var s = tmp.value;
		if(s<1){alert(\"No puede ser menor a 1 \");tmp.value=1; tmp.focus();}
		if(s>255){alert(\"No puede ser mayor a 255 \"); tmp.value=255; tmp.focus();}
		'
		><br>(tiempo en segundos)</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='U1PRO(\"temp\",\"get\",\"\")'>
			<input type='button' value='Asignar' class='guardar1' onclick='U1PRO(\"temp\",\"set\",\"sensor@rango@minima@maxima@tiempo\")'>
		</td>
	</tr>
</table><hr>";
?>