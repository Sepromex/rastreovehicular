<?
	//Cambiar nombre del equipo
	/*
	$formu .= "<table id='rounded-corner'>";
	$formu .= "<tr><td width='220'><b>Cambiar nombre al equipo</b></td><td colspan='2' ></td></tr><tr><td colspan='3' id='nombreaviso'><div></div></td></tr>";
	$formu .= "<tr></td><td width='220'>Nombre:<input type='text' maxlength=30 id='nombreP1' name='nombreP1' /></td><td width='180' id='nombreav' style='color:red;font-style:italic;'></td><td><input type='button' class='guardar1' id='benb' value='Enviar' disabled='true' onclick='verificaNombreP1();'/><input type='button' id='bonb' value='Obtener' class='agregar1' disabled='true' onclick='getNombreP1();'/></td></tr>";
	$formu .= "</table><hr>";
	*/
	
	//Registro de telefonos autorizados
	$formu .= "
	<table id='rounded-corner'>
		<tr>
			<td width='220'><b>Registro de Telefonos autorizados</b></td>
			<td style='text-align:right'>&nbsp;</td>
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
	$formu .= "
	<table id='rounded-corner'>
		<tr>
			<td colspan='5'><b>Alertas autorizadas</b></td>
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
		<!--<tr>
			<td>Reporte de geocercas</td>
			<td><input type='checkbox' id='geo01'/></td>
			<td><input type='checkbox' id='geo02'/></td>
			<td><input type='checkbox' id='geo03'/></td>
			<td><input type='checkbox' id='geo04'/></td>
		</tr>-->
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
				<input id='betel' type='button' value='Enviar' class='guardar1' disabled=true onclick='verificaTelefonosP1();'/>
				<input id='botel' type='button' class='agregar1' value='Obtener' disabled=true onclick='getTelefonosP1();'/>
			</td>
		</tr>
	</table>
	<hr>";
	//fin registro de telefonos autorizados
	
	//Modificar radio geocerca personal
	$formu .= "
	<table id='rounded-corner'>
		<tr>
			<td width='400' colspan='2'><b>Cambiar radio de la geocerca personal</b></td>
			<td width='140'></td>
		</tr>
		<tr height='25'>
			<td colspan='4' id='geopaviso'></td>
		</tr>
		<tr>
			<td width='220'>Radio:<input type='text' name='radioP1' id='radioP1' size='10'/></td>
			<td style='color:red;font-style:italic;' width='180' id='radioav' ></td>
			<td>
				<input type='button' id='berg' class='guardar1' value='Enviar' disabled=true onclick='verificaRadioP1();'/>
				<input id='borg' type='button' class='agregar1' value='Obtener' disabled=true onclick='getRadioP1();'/>
			</td>
		</tr>
	</table>
	<hr>";
	//fin modificar radio geocerca personal
	
	//Actibar BUZZER
	$formu .= "
	<table id='rounded-corner'>
		<tr height='25'>
			<td colspan='4' id='buzzaviso'>&nbsp;</td>
		</tr>
		<tr>
			<td width='220'><b>Activar Buzzer</b></td>
			<td width='220'></td>
			<td width='100'>
				<input type='button' class='guardar1' id='bebu' disabled=true value='Enviar' onclick='activaBuzzerP1();'/>
			</td>
		</tr>
	</table>
	<hr>";
	//fin activar buzzer
	
	//Activar o Desactivar Sensor de movimiento
	$formu .= "
	<table id='rounded-corner'>
		<tr>
			<td width='220'><b>Sensor de movimiento</b></td>
			<td width='320' colspan='2'  >&nbsp;</td>
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
				<input type='button' id='besm' onclick='activaSensorMotionP1();' class='guardar1' value='Enviar' disabled=true />
				<input type='button' id='bosm' disabled=true value='Obtener' class='agregar1' onclick='getSensorMotionP1();'/>
			</td>
		</tr>
	</table>
	<hr>";		
	//fin activar o desactivar sensor de movimiento
	
	//Activar o Desactivar Sensor de impacto
	$formu .= "
	<table id='rounded-corner'>
		<tr>
			<td width='220'><b>Sensor de impacto</b></td>
			<td width='320' colspan='2'>&nbsp;</td>
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
				<input type='button' id='besi' class='guardar1' value='Enviar' disabled=true onclick='activaSensorImpactP1();'/>
				<input type='button' class='agregar1' disabled=true id='bosi' value='Obtener' onclick='getSensorImpactP1();'/>
			</td>
		</tr>
	</table>
	<hr>";		
	//fin activar o desactivar sensor de impacto

	//Registro de geocercas
	/*
	$formu .= "<table cellspacing='0' width='570' cellpadding='0' border='0'>";
	$formu .= "<tr><td width='220'><b>Registro de geocercas</b></td><td width='180' >&nbsp;</td><td><input type='button' id='boge' disabled=true value='Obtener' onclick=''/></td></tr>";
	$formu .= "</table>";
	$formu .= "<table width='570' style='text-align:center;' cellspacing='0' class='tablaBorder' cellpadding='0'>";
	$formu .= "<tr ><td class='tablaBorder' width='30'>Indice</td><td class='tablaBorder' width='280'>Nombre</td><td class='tablaBorder' width='65'>Agregar</td><td class='tablaBorder' width='65'>Eliminar</td><td class='tablaBorder' width='65'>Entrada</td><td class='tablaBorder' width='65'>Salida</td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >1</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >2</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >3</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >4</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >5</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >6</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >7</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >8</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >9</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "<tr ><td class='tablaBorder' >10</td><td class='tablaBorder' ></td><td class='tablaBorder' ><img width='16'  height='16' src='img/suma.png' /></td><td class='tablaBorder' ><img width='16'  height='16' src='img/resta.png' /></td><td class='tablaBorder' ><input type='checkbox' /></td><td class='tablaBorder' ><input type='checkbox' /></td></tr>";
	$formu .= "</table>";	
	*/	
	
	//fin cambiar nombre del equipo
?>