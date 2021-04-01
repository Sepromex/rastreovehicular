<?
//Registro de telefonos autorizados
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"tel_autorizado\")'>";
$formu .= "
<table id='rounded-corner'>
	<tr>
		<td width='220'><b>Registro de Telefonos autorizados</b></td>
		<td style='text-align:right'>&nbsp;$btn_info</td>
	</tr>
	<tr>
		<td colspan='3'><div id='telaviso'></div></td>
	</tr>
	<tr>
		<td width='220'>1-<input type='text' id='tel1' name='tel1' /></td>
		<td id='tel1av' style='color:red;font-style:italic;'>&nbsp;</td>
	</tr>
	<tr>
		<td width='220'>2-<input type='text' id='tel2' name='tel2' /></td>
		<td id='tel2av' style='color:red;font-style:italic;'>&nbsp;</td>
	</tr>
	<tr>
		<td width='220'>3-<input type='text' id='tel3' name='tel3' /></td>
		<td id='tel3av' style='color:red;font-style:italic;'>&nbsp;</td>
	</tr>
	<tr>
		<td width='220'>4-<input type='text' id='tel4' name='tel4' /></td>
		<td id='tel4av' style='color:red;font-style:italic;'>&nbsp;</td>
	</tr>
</table>";
//Alertas Autorizadas
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"alertas_p1\")'>";
$formu .= "
<table id='rounded-corner'>
	<tr>
		<td colspan='5'><b>Alertas autorizadas</b>$btn_info</td>
	</tr>
	<tr>
		<td></td>
		<td>Tel1</td>
		<td>Tel2</td>
		<td>Tel3</td>
		<td>Tel4</td>
	</tr>
	<tr>
		<td>Se&ntilde;al de emergencias</td>
		<td><input type='checkbox' id='pan01'/></td>
		<td><input type='checkbox' id='pan02'/></td>
		<td><input type='checkbox' id='pan03'/></td>
		<td><input type='checkbox' id='pan04'/></td>
	</tr>
	<tr>
		<td>Reporte de geocerca personal</td>
		<td><input type='checkbox' id='geop01'/></td>
		<td><input type='checkbox' id='geop02'/></td>
		<td><input type='checkbox' id='geop03'/></td>
		<td><input type='checkbox' id='geop04'/></td>
	</tr>
	<tr>
		<td>Se&ntilde;al de energ&iacute;a baja</td>
		<td><input type='checkbox' id='pw01'/></td>
		<td><input type='checkbox' id='pw02'/></td>
		<td><input type='checkbox' id='pw03'/></td>
		<td><input type='checkbox' id='pw04'/></td>
	</tr>
	<tr>
		<td>Reporte de sensor de impacto</td>
		<td><input type='checkbox' id='imp01'/></td>
		<td><input type='checkbox' id='imp02'/></td>
		<td><input type='checkbox' id='imp03'/></td>
		<td><input type='checkbox' id='imp04'/></td>
	</tr>
	<tr>
		<td colspan='5' align='center'>
			<input id='botel' type='button' class='agregar1' value='Obtener' disabled=true onclick='xajax_auditabilidad(115,$veh);getTelefonosP1();'/>
			<input id='betel' type='button' value='Guardar' class='guardar1' disabled=true onclick='xajax_auditabilidad(116,$veh);verificaTelefonosP1();'/>
		</td>
	</tr>
</table>
<hr>";
//fin registro de telefonos autorizados

//Modificar radio geocerca personal
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"geo_personal\")'>";
$formu .= "
<table id='rounded-corner'>
	<tr>
		<td width='400' colspan='2'><b>Cambiar radio de la geocerca personal</b></td>
		<td width='140'>$btn_info</td>
	</tr>
	<tr height='25'>
		<td colspan='4' id='geopaviso'></td>
	</tr>
	<tr>
		<td width='220'>
			Radio:
			<input type='text' name='radioP1' id='radioP1' size='5'
				onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
				onblur='
				var dm = document.getElementById(\"radioP1\");
				var x = parseFloat(dm.value);
				var max = 65535;
				if(x < 20){alert(\"No puede ser menor a 20 Metros \");dm.value=20; dm.focus();}
				if(x > 65535){alert(\"No puede ser mayor a 65.5 Kms \"); dm.value=max; dm.focus();}
				'
			/>
			Mtrs
		</td>
		<td style='color:red;font-style:italic;' width='180' id='radioav' ></td>
		<td>
			<input id='borg' type='button' class='agregar1' value='Obtener' disabled=true onclick='xajax_auditabilidad(117,$veh);getRadioP1();'/>
			<input type='button' id='berg' class='guardar1' value='Guardar' disabled=true onclick='xajax_auditabilidad(118,$veh);verificaRadioP1();'/>
		</td>
	</tr>
</table>
<hr>";
//fin modificar radio geocerca personal

//Actibar BUZZER
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"buzzer\")'>";
$formu .= "
<table id='rounded-corner'>
	<input type='hidden' id='buzz1'>
	<tr height='25'>
		<td colspan='4' id='buzzaviso'>&nbsp;$btn_info</td>
	</tr>
	<tr>
		<td width='220'><b>Activar Buzzer</b></td>
		<td width='220'></td>
		<td width='100'>
			<input type='button' class='guardar1' id='bebu' disabled=true value='Enviar' onclick='xajax_auditabilidad(119,$veh);activaBuzzerP1();'/>
		</td>
	</tr>
</table>
<hr>";
//fin activar buzzer

//Activar o Desactivar Sensor de movimiento
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"mov_p1\")'>";
$formu .= "
<table id='rounded-corner'>
	<tr>
		<td width='220'><b>Sensor de movimiento</b></td>
		<td width='320' colspan='2'  >&nbsp;$btn_info</td>
	</tr>
	<tr>
		<td colspan='3'><div id='moviaviso'></div></td>
	</tr>
	<tr>
		<td width='220'>Estado actual:<input type='text' id='statusM' size='15' readonly=true  disabled=true style='background-color:#D0D0D0;'/></td>
		<td width='180'></td><td width='140'></td>
	</tr>
	<tr>
		<td><input type='radio' name='smovimiento' id='movibutton1' checked=true />Activar sensor</td>
		<td><input type='radio' id='movibutton2' name='smovimiento' id='' />Desactivar sensor</td>
		<td>
			<input type='button' id='bosm' disabled=true value='Obtener' class='agregar1' onclick='xajax_auditabilidad(120,$veh);getSensorMotionP1();'/>
			<input type='button' id='besm' onclick='xajax_auditabilidad(121,$veh);activaSensorMotionP1();' class='guardar1' value='Guardar' disabled=true />
		</td>
	</tr>
</table>
<hr>";		
//fin activar o desactivar sensor de movimiento

//Activar o Desactivar Sensor de impacto
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"impacto_p1\")'>";
$formu .= "
<table id='rounded-corner'>
	<tr>
		<td width='220'><b>Sensor de impacto</b></td>
		<td width='320' colspan='2'>&nbsp;$btn_info</td>
	</tr>
	<tr>
		<td colspan='3'><div id='impaviso'></div></td>
	</tr>
	<tr>
		<td width='220'>Estado actual:<input type='text' id='statusI' size='15' readonly=true disabled=true style='background-color:#D0D0D0;'/></td>
		<td width='180'></td><td width='140'></td>
	</tr>
	<tr>
		<td><input type='radio' name='simpacto' id='impbutton1' checked=true/>Activar sensor</td>
		<td><input type='radio' name='simpacto' id='impbutton2' />Desactivar sensor</td>
		<td>
			<input type='button' class='agregar1' disabled=true id='bosi' value='Obtener' onclick='xajax_auditabilidad(122,$veh);getSensorImpactP1();'/>
			<input type='button' id='besi' class='guardar1' value='Guardar' disabled=true onclick='xajax_auditabilidad(123,$veh);activaSensorImpactP1();'/>
		</td>
	</tr>
</table>
<hr>";		
//fin activar o desactivar sensor de impacto
?>