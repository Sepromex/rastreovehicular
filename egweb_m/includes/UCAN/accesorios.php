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
			Desactivado:<input type='radio' name='activo' id='temp2'>
		</td>
	</tr>
	<tr>
		<td colspan='2'>Temperatura</td>
	</tr>
	<tr>
		<td>
			Temperatura:
		</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='maxima' value='20' max='215' min='-40' onchange='rangevalue.value=value'/>
				<span class='highlight'></span>
				<output id='rangevalue'>20</output> 
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
		if(s<1){alert(\"No puede ser menor a 1 Min \");tmp.value=1; tmp.focus();}
		if(s>65535){alert(\"No puede ser mayor a 65535 Mins \"); tmp.value=65535; tmp.focus();}
		'
		><br>(tiempo en segundos)</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"temp\",\"get\",\"\")'>
			<input type='button' value='Asignar' class='guardar1' onclick='UCAN(\"temp\",\"set\",\"maxima@tiempo\")'>
		</td>
	</tr>
</table><hr>";
?>