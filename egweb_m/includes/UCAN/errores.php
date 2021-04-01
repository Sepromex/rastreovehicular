<?
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>
			Fallas
			<div id='fallas'></div>
		</th>
	</tr>
	<tr>
		<td>Reportar Fallas</td>
		<td>
			Activado:<input type='radio' id='fallas1' name='fallas' value='activo'><br>
			Desactivado:<input type='radio' id='fallas2' name='fallas' value='desactivado'>
		</td>
	</tr>
	<tr>
		<td>Intervalo</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='i_hora' value='1' max='24' min='1' onchange='rangevalue.value=value'/>
				<span class='highlight'></span>
				<output id='rangevalue'>1</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"fallas\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='UCAN(\"fallas\",\"set\",\"i_hora\")'></td>
	</tr>
</table><hr>
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>
			DTC
			<div id='dtc'>
		</th>
	</tr>
	<tr>
		<td colspan='2'><div id='datos'></div></td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"dtc\",\"get\",\"\")'>
		</td>
	</tr>
</table>";
?>