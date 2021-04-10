<!--  Busqueda  -->
<div class="card-header border-bottom p-2 d-flex">    
    <input type="text" class="form-control border-0  w-100 h-100 vehicle-search" placeholder="Search ...">
</div>
 
<!--  VEHICULO MENU LISTADO  -->
<div class="row m-0 border-bottom theme-border">
        <div class="col-12 px-2 py-3 d-flex mail-toolbar">

            <!-- <div class="check d-inline-block mr-3">
                <label class="chkbox">All 
                    <input name="all" value="" type="checkbox" class="checkall checkall-veh">
                    <span class="checkmark"></span>
                </label>
            </div>  -->
 
            <!-- Filter by speed -->
            <a href="#" class="ml-auto toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Velocidades"><i class="mdi mdi-speedometer"></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right bulk-mail-type">
                <a class="dropdown-item" href="#" data-speed="mail-item">Todas las velocidades</a>
                <a class="dropdown-item opt-blue" href="#" data-speed="speed-blue"><span class="dot bg-primary"></span> Detenido</a>
                <a class="dropdown-item opt-green" href="#" data-speed="speed-green"><span class="dot bg-success"></span> Minima</a>
                <a class="dropdown-item opt-yellow" href="#" data-speed="speed-yellow"><span class="dot bg-warning"></span> Normal</a>
                <a class="dropdown-item opt-orange" href="#" data-speed="speed-orange"><span class="dot bg-orange"></span> Regular</a>
                <a class="dropdown-item opt-red" href="#" data-speed="speed-red"><span class="dot bg-danger"></span> Máxima</a>
            </div> 
 
            <div>
                <a href="#" class="mr-2 toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Estado de motor" ><i class="mdi mdi-engine"></i></a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-left status-engine">
                    <a class="dropdown-item opt-engineof" href="#" data-engine="mail-item">Todos</a>
                    <a class="dropdown-item" href="#" data-engine="engine-on">
                        <h4 class="mdi mdi-engine text-success d-inline"></h5> Motor Encendido 
                    </a>
                    <a class="dropdown-item opt-engineon" href="#" data-engine="engine-off">
                        <h5 class="mdi mdi-engine text-primary d-inline"></h5> Motor apagado 
                    </a>
                    <a class="dropdown-item opt-termon" href="#" data-engine="term-on">
                        <h5 class="mdi mdi-power-plug text-success d-inline"></h5> Terminal conectada y puerta cerrada
                    </a>
                    <a class="dropdown-item opt-termoff" href="#" data-engine="term-off">
                        <h5 class="mdi mdi-power-plug-off text-primary  d-inline"></h5> Terminal desconectada y puerta abierta 
                    </a>
                    <a class="dropdown-item opt-termonoff" href="#" data-engine="term-onoff">
                        <h5 class="mdi mdi-power-plug text-orange  d-inline"></h5> Terminal conectada y puerta abierta
                    </a>
                    <a class="dropdown-item opt-termoffon" href="#" data-engine="term-offon">
                        <h5 class="mdi mdi-power-plug-off text-orange d-inline"></h5> Terminal desconectada y puerta cerrada 
                    </a>
                </div>
            </div> 
 
            
            <div>
                <a href="#" class="mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">
                    <a class="dropdown-item mailread" href="#" onclick="clearveh()"><i class="icon-reload"></i> Limpiar vehículos </a>
                    <!-- <a class="dropdown-item mailunread" href="#"><i class="mdi mdi-trash-can-outline"></i> Eliminar </a>-->
                </div>
            </div>           


        </div>
</div>

<form id="form_vehlist">
<div class="scrollertodo">  <!-- LISTADO VEHICULOS -->

    <ul class="mail-app list-unstyled" id="vehicles_list">
        <?php foreach($vehicles as $veh): $vehid = $veh->NUM_VEH;  $comp = $veh->id_empresa; ?>
            <li class="py-1 px-2 mail-item inbox  cursor-pointer" id="vehiclelist_<?=$vehid?>">
                <div class="d-flex align-self-center align-middle">
                  
                    <div class="mail-content d-md-flex w-100">                                                    
                        
                        <span class="car-name" onclick="vehicle_ubication('<?=$vehid?>','<?=$comp?>',1)"><?=$veh->ID_VEH?></span>

                        <div class="d-flex mt-3 mt-md-0 ml-auto" id="vehicle-element<?=$vehid?>" onclick="vehicle_ubication('<?=$vehid?>','<?=$comp?>',0)">                                                           <div class="h6 mr-1 mdi mdi-engine-off text-info engine-off"></div>
                                
                            <div class="speed-icon mr-1">
                                    <img class="toltip" style="width:100%;" src="<?=base_url()?>/dist/images/config/vehicles/speed_blue.png">
                            </div>

                        </div>
 
                        <div class="d-flex mt-3 mt-md-0">       
                        
                        
                            <!-- <i class="mdi mdi-map-marker text-danger toltip"  onclick="vehicle_ubication('<?=$vehid?>','<?=$comp?>',2)"    data-placement="top" title="Ubicacion"></i> -->
                            <i class="mdi mdi-information text-primary toltip"  onclick="vehicle_detail(<?=$vehid?>)"   data-placement="top" title="Información"></i>
                            
                            <i class="mdi mdi-map-marker-path ml-1 text-primary toltip" onclick="vehicle_ubication('<?=$vehid?>','<?=$comp?>',2)"  data-list="geoc_list"  data-placement="top" title="Ruta"></i> 

                            <a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-options-vertical"></i>
                            </a>                             
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-right"> 
                                    <a class="dropdown-item mailread" href="#" onclick="edit_vehiclelist(<?=$vehid?>)"><i class="mdi mdi-playlist-edit"></i> Editar </a>
                            </div>  
                        </div>

                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

</div> <!-- LISTADO VEHICULOS -->
</form>