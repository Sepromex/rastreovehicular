<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i><?=($geot_form==0)?" Nueva Geocerca":" Editar Geocerca"?> 
    </h5>     
    <i class="icon-close icons openside reset_form h3" onclick="cancelgeo()"></i>     
</div>

<form class="needs-validation" id="side_maingeo" method="POST" novalidate >
   
    <div class="modal-body h-100">                       
            <input type="hidden" value="<?=$geoside["num_geo"]?>" name="geoside_id" id="geoside_id">
            <?php if($geot_form != 0): ?>
            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">ID</div>
                <div class="d-block h6  small"><?=$geoside["num_geo"]?></div>
            </div> 
            <?php endif; ?>

            <div class="row mb-2"> 
                <label for="name_site" class="col-form-label text-muted">Nombre</label>
                <input type="text" value="<?=(isset($geoside["nombre"]))?$geoside["nombre"]:""?>" name="geoside_name" id="geoside_name" class="form-control" required="" >
                <div class="invalid-feedback" id="feedback-geoside_name"></div>
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
                <div class="text-muted w-100 mb-2">Latitud</div>
                <div class="d-block h6  small"><?=$geoside["latitud"]?></div>
                <input type="hidden" name="maingeo_latitud" id="maingeo_latitud" value="<?=$geoside["latitud"]?>">
            </div>

            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">Longitud</div>
                <div class="d-block h6  small"><?=$geoside["longitud"]?></div>
                <input type="hidden" name="maingeo_longitud" id="maingeo_longitud" value="<?=$geoside["longitud"]?>">
            </div>

            <div class="row mb-2"> 
                <div class="text-muted w-100 mb-2">Radio</div>
                <div class="d-block h6  small"><?=$geoside["radioMts"]?></div>
                <input type="hidden" name="maingeo_radio" id="maingeo_radio" value="<?=$geoside["radioMts"]?>">
            </div>            
            
            <input type="hidden" name="maingeo_tipo" id="maingeo_tipo" value="0">

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form" onclick="cancelgeo()">Cancelar</button>
        <?php if($geot_form==0): ?>
            <button type="button" class="btn btn-primary" onclick="save_newgeo()">Agregar Geocerca</button>        
        <?php else: ?>
            <button type="button" class="btn btn-primary" onclick="edit_geoside(<?=$geoside['num_geo']?>)">Editar Geocerca</button>        
        <?php endif; ?>
    </div>

</form>  



<script>
  
$("#geoside_name").on('blur',function(){validate_name("#geoside_name","#feedback-geoside_name"); });
 
    

 
</script>