<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i><?=($geot_form==0)?" Nueva Geocerca":" Editar Geocerca"?> 
    </h5>     
    <i class="icon-close icons openside reset_form h3" data-reset="/"></i>     
</div>

<form class="needs-validation" id="side_maingeo" method="POST" novalidate >
   
    <div class="modal-body h-100">               
        <?php if($geot_form != 0): ?>
            <input type="hidden" value="<?=$geoside["num_geo"]?>" name="geoside_id" id="geoside_id">
            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">ID</div>
                <div class="d-block h6  small"><?=$geoside["num_geo"]?></div>
            </div> 

            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">Empresa</div>
                <div class="d-block h6  small"><?=$geoside["empresa"]?></div>
            </div> 

            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">Usuario</div>
                <div class="d-block h6  small"><?=$geoside["username"]?></div>
            </div>

            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">Radio</div>
                <div class="d-block h6  small"><?=$geoside["radioMts"]?></div>
            </div>
        <?php else: ?>
            <input type="hidden" name="maingeo_latitud" id="maingeo_latitud" value="22.151192871203786">
            <input type="hidden" name="maingeo_longitud" id="maingeo_longitud" value="-103.04950489859309">
            <input type="hidden" name="maingeo_radio" id="maingeo_radio" value="10">
            <input type="hidden" name="maingeo_tipo" id="maingeo_tipo" value="1">            
        <?php endif; ?>

        <div class="row mb-2"> 
            <label for="name_site" class="col-form-label text-muted">Nombre</label>
            <input type="text" value="<?=(isset($geoside["nombre"]))?$geoside["nombre"]:""?>" name="geoside_name" id="geoside_name" class="form-control" required="" >            
        </div>                

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form" data-reset="reset_user">Cancelar</button>
        <?php if($geot_form==0): ?>
            <button type="button" class="btn btn-primary" onclick="save_newgeo()">Agregar Geocerca</button>        
        <?php else: ?>
            <button type="button" class="btn btn-primary" onclick="edit_geoside(<?=$geoside['num_geo']?>)">Editar Geocerca</button>        
        <?php endif; ?>
    </div>

</form>  