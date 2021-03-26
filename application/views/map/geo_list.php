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
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right bulk-mail-type">
                <a class="dropdown-item" href="#" data-type="g-polig"> Todas las Geo-cerca </a>
                <a class="dropdown-item" href="#" data-type="g-polig"> <img src="/dist/images/map/geo/polig.png" width="15px" height="15px"> Poligonal </a>
                <a class="dropdown-item" href="#" data-type="g-circle"> <img src="/dist/images/map/geo/circle.png" width="15px" height="15px"> Circular </a>
            </div>
            

            <div>
            <a href="#" class="ml-0 toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Empresa/Usuario"><i class="mdi mdi-home-city"></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right company_type">
                <a class="dropdown-item" href="#" data-filter="all">Todas </a>
                <a class="dropdown-item" href="#" data-filter="company"><span class="dot bg-primary"></span> Geocerca Empresas </a>
                <a class="dropdown-item" href="#" data-filter="user"><span class="dot bg-success"></span> Mis Geocerca</a>                
            </div>
            </div>

            <div>
                <a href="#" class="mr-0 toltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">
                    <a class="dropdown-item mailread" href="#" ><i class="icon-reload"></i> Limpiar mapa </a>
                    <a class="dropdown-item mailunread" href="#"><i class="mdi mdi-trash-can-outline"></i> Eliminar </a>
                    <a class="dropdown-item mailunread" href="#"><i class="mdi mdi-trash-can-outline"></i> Nueva Geocerca </a>
                </div>
            </div> 

        </div>
</div> 
<div class="scrollertodo">  <!-- LISTADO VEHICULOS -->
    <ul class="mail-app list-unstyled" id="geo_list">
        <?php foreach($geoc as $geo): 
                $icon = ($geo->tipo==0)?'circle':'polig'; 
        ?>
        <li class="py-1 px-2 mail-item inbox sent g-<?=$icon?> ">
            <div class="d-flex align-self-center align-middle">
                <label class="chkbox">
                    <input type="checkbox">
                    <span class="checkmark small"></span>
                </label>
                <div class="mail-content d-md-flex w-100">                                                    
                    <span class="car-name"><?=$geo->nombre?></span>                                                     
                    <div class="d-flex mt-3 mt-md-0 ml-auto">                         
                        <img src="/dist/images/map/geo/<?=$icon?>.png" width="20px" height="18px">

                        <a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </a>

                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right">										
                            <a class="dropdown-item" href="#" onclick="edit_sitelist(<?=0?>)"><i class="mdi mdi-playlist-edit"></i> Editar </a>
                            <a class="dropdown-item" href="#" onclick="delete_mainsite(<?=0?>)"><i class="icon-trash"></i> Eliminar </a>
                        </div>
                        
                    </div>
                </div>



            </div>
        </li>        
        <?php endforeach; ?>
    </ul>
</div> <!-- LISTADO VEHICULOS -->
 