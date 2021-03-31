<!-- VER VEHICULO -->

<!--  Busqueda  -->
<div class="card-header border-bottom p-2 d-flex">
    <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
    <input type="text" class="form-control border-0  w-100 h-100 geo-search" placeholder="Search ...">
</div>
<!--  VEHICULO MENU LISTADO  --> 
<div class="row m-0 border-bottom theme-border">
        <div class="col-12 px-2 py-3 d-flex mail-toolbar">
            <div class="check d-inline-block mr-3">
                <label class="chkbox">All 
                    <input name="all" value="" type="checkbox" class="checkall">
                    <span class="checkmark"></span>
                </label>
            </div>  

            <a href="#" class="ml-auto toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Tipo de Geocerca"><i class="mdi mdi-map-marker-radius "></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right fgeo-type">
                <a class="dropdown-item" href="#" data-type="mail-item"> Todas las Geo-cerca </a>
                <a class="dropdown-item" href="#" data-type="g-polig"> <img src="/dist/images/map/geo/polig.png" width="15px" height="15px"> Poligonal </a>
                <a class="dropdown-item" href="#" data-type="g-circle"> <img src="/dist/images/map/geo/circle.png" width="15px" height="15px"> Circular </a>
            </div>
            

            <div>
            <a href="#" class="ml-0 toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Empresa/Usuario"><i class="mdi mdi-shield-check-outline"></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right fcompany_type">
                <a class="dropdown-item" href="#" data-filter="mail-item">Todas </a>
                <a class="dropdown-item" href="#" data-filter="geo_company"><span class="mdi mdi-shield-check-outline text-muted h6"></span> Geocerca Empresas </a>
                <a class="dropdown-item" href="#" data-filter="geo_user"><span class="mdi mdi-account-outline text-success h6"></span> Mis Geocerca </a>                
            </div>  
            </div>

            <div>
                <a href="#" class="mr-0 toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">
                    <a class="dropdown-item mailread" href="#" ><i class="icon-reload"></i> Limpiar mapa </a>
                    <!-- <a class="dropdown-item mailunread" href="#"><i class="mdi mdi-trash-can-outline"></i> Eliminar </a>-->
                    <a class="dropdown-item mailunread" href="#" onclick="ejecutar_geocercas()"><i class="mdi mdi-trash-can-outline"></i> Nueva Geocerca </a>
                </div>
            </div> 

        </div>
</div> 
<form id="form_geolist">
<div class="scrollertodo">  <!-- LISTADO VEHICULOS -->
    <ul class="mail-app list-unstyled" id="geo_list">
        <?php foreach($geoc as $geo): 
                $type = $geo->tipo;

                $icon  = ($type==0)?'circle':'polig';  
                $idgeo = $geo->num_geo;

 
                if($geo->id_usuario == $user_id){
                    $icon_usr =  "mdi mdi-account-outline text-success"; $classusr = "user";
                }else{
                    $icon_usr =  "mdi mdi-shield-check-outline text-muted"; $classusr = "company";
                }

                $lat = $geo->latitud; 
                $lon = $geo->longitud;
                $geoname = $geo->nombre; 
        ?>

        <li class="py-1 px-2 mail-item inbox sent g-<?=$icon?> geo_<?=$classusr?>" id="geolist_<?=$idgeo?>">
            <div class="d-flex align-self-center align-middle">

                <label class="chkbox">
                    <input type="checkbox" name="geocheck[<?=$idgeo?>]" data-name="<?=$geoname?>" data-type="<?=$type?>" data-radio="<?=$geo->radioMts?>" data-lat="<?=$lat?>" data-lon="<?=$lon?>" onclick="contar()" value="<?=$idgeo?>">
                    <span class="checkmark small"></span>
                </label>

                <div class="mail-content d-md-flex w-100">
                    <span class="car-name" id="geoname_<?=$idgeo?>"  onclick="geo_go(<?=$lat?>,<?=$lon?>,<?=$type?>,<?=$idgeo?>)"><?=$geoname?></span>

                    <div class="d-flex mt-3 mt-md-0 ml-auto">

                        <div class="<?=$icon_usr?> h5"></div>

                        <img src="/dist/images/map/geo/<?=$icon?>.png" class="mt-1" width="20px" height="18px">

                        <a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </a>

                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="edit_geolist(<?=$idgeo?>)"><i class="mdi mdi-playlist-edit"></i> Editar </a>
                            <a class="dropdown-item" href="#" onclick="delete_maingeo(<?=$idgeo?>)"><i class="icon-trash"></i> Eliminar </a>
                        </div>
                        
                    </div>
                </div> 

            </div>
        </li>        
        <?php endforeach; ?>
    </ul>
</div> <!-- LISTADO VEHICULOS --> 
</form>