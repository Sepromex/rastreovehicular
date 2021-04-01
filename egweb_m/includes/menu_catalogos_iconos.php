<div id="menu_catalogo" align='center'>
				<ul id="nav1" class="drop1" >
                    <li id="coches" class="current" title='Veh&iacute;culos' onclick="c_tipo(1,<?php echo (int)$idu?>,<?php echo $est?>);">
						<a href="javascript:void(null);" ><img src='img2/vehiculo.png' height='20px'></a>
					</li>
                    <li id="sitInt" title='Sitios de inter&eacute;s' onclick="c_tipo(2,<?php echo $ide?>,<?php echo $est?>);">
						<a href="javascript:void(null);" ><img src='img2/interes.png' height='20px'></a>
					</li>
                    <li id="geoCer"title='Geocercas' onclick="c_tipo(3,<?php echo $ide?>,<?php echo $est?>);">
						<a href="javascript:void(null);" ><img src='img2/cerca.png' height='20px'></a>
					</li>
					<!-- PARTE CORRESPONDIENTE A USUARIOS -->
					<li id="usuarios" title='Usuarios' onclick="c_tipo(4,<?php echo $ide?>,<?php echo $est?>);">
						<a href="javascript:void(null);" ><img src='img2/usuarios.png' height='20px'></a>
					</li>
					<?
					$si = strstr($prm,"8");
					if(($est != 3) ||($est == 3 && !empty($si))){?>
						<li id="empresa" title='Mi empresa' onclick="c_tipo(5,<?php echo $ide?>,<?php echo $est?>);">
							<a href="javascript:void(null);" ><img src='img2/empresa.png' height='20px'></a>
						</li>
					<?
						}
					?>
					<li id="correos" title='Mis correos' onclick="c_tipo(6,<?php echo $ide?>,<?php echo $est?>);">
						<a href="#" ><img src='img2/email-info-icon.png' height='20px'></a>
					</li>
                </ul>
            </div>