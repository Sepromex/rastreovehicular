<!--  Busqueda  -->
<div class="card-header border-bottom p-2 d-flex">
    <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
    <input type="text" class="form-control border-0  w-100 h-100 site-search" placeholder="Search ..."> </br>    
</div>

<div class="card-header border-bottom p-2 d-flex">    
    <select class="form-control select-form" id="site_tipe" style="display:block;">
        <option value="0" data-icon="iconos_sitios/defaul_marker.png"> Todos los sitios </option>   
        <?php foreach($site_type as $site): ?>
        <option value="<?=$site->id_tipo?>" data-icon="<?=$site->imagen?>"> <?=$site->descripcion?></option>
        <?php endforeach; ?>
    <select>
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

        <!-- Filtrar por Etiquetas -->
        <a href="#" class="ml-auto toltip" data-placement="top" title="Eliminar"><i class="icon-trash"></i></a>
        
        <!-- 
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right bulk-mail-type">
                <a class="dropdown-item" href="#" data-speed="speed-blue">--</a>
            </div> 
        -->
        
        <div>
            <a href="#" class="mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">                
                <a class="dropdown-item mailread" href="#" onclick="clearMark()" ><i class="icon-reload"></i> Limpiar mapa </a>                    
                <div class="dropdown-divider"></div>
                <a class="dropdown-item mailread" href="#" onclick="new_mainsite()"><i class="icon-plus"></i> Nuevo sitio de interés </a>                    
            </div>
        </div>

    </div>
</div>            

<form id="form_sitelist">
<div class="scrollertodo">  <!-- LISTADO VEHICULOS -->
    <ul class="mail-app list-unstyled" id="sites_list">
        <!-- ITEMS <div id="vehicles_list"></div> -->
        <?php foreach($sites as $site): 
                $icon_class = ($site->id_tipo>0)?$site->id_tipo:0;			
                $iconimg    = ($site->imagen!="")?substr($site->imagen,14):"defaul_marker.png";    
                $idsite     = $site->id_sitio;
        ?> 
        <li class="py-1 px-2 mail-item inbox sitetype-<?=$icon_class?> cursor-pointer pointer" id="sitelist_<?=$idsite?>"> 
            <div class="d-flex align-self-center align-middle">
                <label class="chkbox">
                    <input type="checkbox" onclick="show_site(this,<?=$idsite?>)" name="mark_site[<?=$idsite?>]" value="<?=$idsite?>">
                    <span class="checkmark small"></span>
                </label>
                <div class="mail-content d-md-flex w-100">								
                    <span class="car-name" id="sitename_<?=$idsite?>" onclick="veh_seleccion(<?=$site->latitud?>,<?=$site->longitud?>)"><?=$site->nombre?></span>                                                     
                    <div class="d-flex mt-3 mt-md-0 ml-auto"> 
                        <div id="siteicon_<?=$idsite?>"><img src="/dist/images/map/site_type/<?=$iconimg?>" width="25px" height="22px" class="toltip" data-placement="top" title="<?=$site->descripcion?>"></div>
                        <a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical"></i>
                        </a>
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right">										
                            <a class="dropdown-item" href="#" onclick="edit_sitelist(<?=$idsite?>)"><i class="mdi mdi-playlist-edit"></i> Editar </a>
                            <a class="dropdown-item" href="#" onclick="delete_mainsite(<?=$idsite?>)"><i class="icon-trash"></i> Eliminar </a>
                        </div>
                    </div>
                </div> 
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div> <!-- LISTADO VEHICULOS -->
</form> 

<script>
 
function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  var baseUrl = "/dist/images/map/site_type/";  
  var icon = state.element.dataset.icon;
  //iconos_sitios/15_taller.png  
  
  var icon = baseUrl+icon.substr(14);

   var $state = $(
    '<span><img src="' + icon + '" class="img-flag" /> ' + state.text +  '</span>'
  );
  return $state;  
};

$('#site_tipe').select2({
  templateResult: formatState
});

</script>