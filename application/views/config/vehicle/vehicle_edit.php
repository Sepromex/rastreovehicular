<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Editar Vehiculo
    </h5>     
    <i class="icon-close icons openside reset_form h3" data-reset="/"></i>     
</div>

<form class="needs-validation" id="vehedit_configform" name="vehedit_configform" method="POST" novalidate >
   
    <div class="modal-body h-100">   
        <input type="hidden" value="<?=$vehicle["num_veh"]?>" name="vehedit_vehid">
        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Número </div>
            <div class="d-block h6 small"><?=$vehicle["num_veh"]?></div>
        </div>

        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Identificador</div>
            <div class="d-block h6  small"><?=$vehicle["id_veh"]?></div>
        </div> 

        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Estatus</div>
            <div class="d-block h6 small"><?=$vehicle["estatus_desc"]?></div>
        </div> 
 
        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Empresa</div>
            <div class="d-block h6 small"><?=$vehicle["empresanom"]?></div>
        </div>
  
        <div class="row mb-2"> 
            <label for="newv_plate" class="col-form-label text-muted">Placas</label>
            <input type="text" value="<?=$vehicle["placas"]?>" name="vehedit_plate" id="newv_plate" class="form-control" required="" >            
        </div>

        <div class="row mb-2"> 
            <label for="newv_model" class="col-form-label text-muted">Modelo</label>
            <input type="text" value="<?=$vehicle["modelo"]?>" name="vehedit_model" id="newv_model" class="form-control" required="" >            
        </div> 
 

        <div class="row mb-2"> 
            <label for="newv_detail" class="col-form-label text-muted">Detalle</label>
            <textarea name="vehedit_detail" id="newv_detail" class="form-control" required="" ><?=$vehicle["detalle"]?></textarea>
        </div>

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form" data-reset="reset_user" >Cancelar</button>
        <button type="button" class="btn btn-primary openside" onclick="edit_vehicle()">Editar Vehículo</button>
    </div>

</form>  